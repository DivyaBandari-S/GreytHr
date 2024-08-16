<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Torann\GeoIP\Facades\GeoIP;
use Jenssegers\Agent\Agent;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class CheckAuthAndHandleSession
{
    protected $timeout = 15; // Session timeout in minutes

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guards = ['emp', 'it', 'hr', 'com', 'finance', 'admins'];
        $userAuthenticated = false;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                $currentSessionId = Session::getId();
                $userId = $this->getUserIdByGuard($guard, $user);

                $lastActivity = DB::table('sessions')->where('id', $currentSessionId)->value('last_activity');

                if ($lastActivity && (now()->timestamp - $lastActivity > $this->timeout * 60)) {
                    Auth::guard($guard)->logout();
                    Session::flush();

                    return $this->timeoutResponse('Your session has expired. Please login again.');
                }

                // Handle Remember Me logic manually
                if (Auth::guard($guard)->viaRemember()) {
                    $rememberToken = $request->cookies->get('remember_web_' . $guard);

                    if (!$rememberToken || !$this->verifyRememberToken($user, $rememberToken)) {
                        return $this->logout($request, $guard);
                    }
                }

                // Store or update password hash in session
                $this->storePasswordHashInSession($request, $guard);

                if ($request->session()->get('password_hash_' . $guard) !== $request->user()->getAuthPassword()) {
                    return $this->logout($request, $guard);
                }

                // Ensure the password is provided before calling logoutOtherDevices
                $password = $request->input('password');
                if ($password) {
                    $this->logoutOtherDevices($user, $password);
                }

                // Update or insert session data
                $this->updateSessionData($request, $user, $userId);

                $userAuthenticated = true;
                break;
            }
        }

        if (!$userAuthenticated) {
            session(['user_type' => 'guest']);
        }

        return $next($request);
    }

    /**
     * Verify the remember token.
     *
     * @param $user
     * @param string $token
     * @return bool
     */
    protected function verifyRememberToken($user, string $token): bool
    {
        // Assuming 'remember_token' is the field in the users table
        return Hash::check($token, $user->remember_token);
    }

    /**
     * Get the user ID based on the guard and user object.
     *
     * @param string $guard
     * @param $user
     * @return mixed
     */
    protected function getUserIdByGuard(string $guard, $user)
    {
        switch ($guard) {
            case 'emp':
                return $user->emp_id;
            case 'it':
                return $user->it_emp_id;
            case 'hr':
                return $user->hr_emp_id;
            case 'com':
                return $user->company_id;
            case 'finance':
                return $user->fi_emp_id;
            case 'admins':
                return $user->admin_emp_id;
            default:
                return null;
        }
    }

    /**
     * Update or insert session data in the sessions table.
     *
     * @param Request $request
     * @param $user
     * @param $id
     */
    protected function updateSessionData(Request $request, $user, $id)
    {
        $location = GeoIP::getLocation($request->ip());
        $agent = new Agent();
        $deviceType = $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop');

        $today = now()->format('Y-m-d');

        $existingSession = DB::table('sessions')
            ->where('user_id', $id)
            ->whereDate('created_at', $today)
            ->first();

        if ($existingSession) {
            DB::table('sessions')
                ->where('id', $existingSession->id)
                ->update([
                    'last_activity' => now()->timestamp,
                    'updated_at' => now(),
                ]);
        } else {
            DB::table('sessions')->insert([
                'id' => Session::getId(),
                'user_id' => $id,
                'ip_address' => $location->ip ?? 'Unknown IP',
                'user_agent' => $request->header('User-Agent'),
                'iso_code' => $location->iso_code ?? 'N/A',
                'country' => $location->country ?? 'N/A',
                'city' => $location->city ?? 'N/A',
                'state' => $location->state ?? 'N/A',
                'state_name' => $location->state_name ?? 'N/A',
                'postal_code' => $location->postal_code ?? 'N/A',
                'latitude' => $location->lat ?? 0,
                'longitude' => $location->lon ?? 0,
                'timezone' => $location->timezone ?? 'N/A',
                'continent' => $location->continent ?? 'N/A',
                'currency' => $location->currency ?? 'N/A',
                'device_type' => $deviceType,
                'last_activity' => now()->timestamp,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Store the user's current password hash in the session.
     *
     * @param Request $request
     * @param string $guard
     * @return void
     */
    protected function storePasswordHashInSession(Request $request, string $guard)
    {
        if ($request->user()) {
            $request->session()->put('password_hash_' . $guard, $request->user()->getAuthPassword());
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @param string $guard
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws AuthenticationException
     */
    protected function logout(Request $request, string $guard)
    {
        Auth::guard($guard)->logout();
        $request->session()->flush();

        return $this->timeoutResponse('You have been logged out due to session timeout.');
    }

    /**
     * Log out other devices for the authenticated user.
     *
     * @param $user
     * @param string $password
     * @return void
     */
    protected function logoutOtherDevices($user, string $password)
    {
        // Check if the provided password is correct
        if (Auth::attempt(['email' => $user->email, 'password' => $password])) {
            Auth::logoutOtherDevices($password);
        } else {
            throw new \Exception('Invalid password provided.');
        }
    }

    /**
     * Return a custom session timeout response.
     *
     * @param string $message
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function timeoutResponse($message): Response
    {
        $loginUrl = route('emplogin');

        $html = <<<HTML
<html>
<head>
    <title>Session Expired</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .message {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .login-link {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .login-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message">$message</div>
        <a href="$loginUrl" class="login-link">Login</a>
    </div>
</body>
</html>
HTML;

        return new Response($html, 200);
    }
}