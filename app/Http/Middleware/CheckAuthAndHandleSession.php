<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Torann\GeoIP\Facades\GeoIP;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CheckAuthAndHandleSession
{
    protected $timeout = 60 * 60;   // 15*6o minutes timeout in seconds

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guards = ['emp', 'it', 'hr', 'com', 'finance', 'admins'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                if ($this->hasSessionExpired($guard)) {
                    return $this->sessionExpiredResponse();
                }

                if ($this->isSessionHijacked($guard, $user)) {
                    return $this->sessionHijackedResponse($user);
                }

                $this->updateSession($request, $guard, $user);
                $this->storeSessionData($request, $guard, $user);

                // If user is authenticated, stop checking other guards
                break;
            }
        }

        if (!Auth::check()) {
            session(['user_type' => 'guest']);
            Log::info('Session has timed out');
        }

        Log::info('Before next request call', ['request' => $request]);

        return $next($request);
    }

    /**
     * Check if the session has expired.
     *
     * @param string $guard
     * @return bool
     */
    protected function hasSessionExpired(string $guard): bool
    {
        $lastActivity = Session::get('last_activity_time');

        if ($lastActivity && (time() - $lastActivity > $this->timeout)) {
            Auth::guard($guard)->logout();
            Session::flush();
            return true;
        }

        return false;
    }

    /**
     * Check if the session has been hijacked.
     *
     * @param string $guard
     * @param $user
     * @return bool
     */
    protected function isSessionHijacked(string $guard, $user): bool
    {
        $storedSessionId = Session::get('session_id');
        $existingSession = DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('user_type', $guard)
            ->first();

        Log::info('Stored session ID: ' . $storedSessionId);
        Log::info('Existing session ID: ' . ($existingSession->id ?? 'None'));
        // Auth::logoutOtherDevices($user->password);
        if ($existingSession && $existingSession->id !== Session::getId()) {
            Log::info('Session hijacking detected.');
            Auth::guard($guard)->logout();
            Session::flush();
            Session::regenerate(); // Regenerate session ID
            DB::table('sessions')->where('id', $existingSession->id)->delete();
            return true;
        }

        return false;
    }

    /**
     * Update session data with the current request information.
     *
     * @param Request $request
     * @param string $guard
     * @param $user
     */
    protected function updateSession(Request $request, string $guard, $user): void
    {
        // Get GeoIP data using Torann\GeoIP
        $location = GeoIP::getLocation($request->ip());
        $locationString = $location ? "{$location->city}, {$location->country}" : "Unknown Location";

        // Get device type using Jenssegers\Agent
        $agent = new Agent();
        $deviceType = $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop');

        // Update last activity time and store user details in the session
        Session::put('last_activity_time', time());
        Session::put('user', $user);
        Session::put('session_id', Session::getId());
        Session::put('location', $locationString);
        Session::put('device_type', $deviceType);
        Session::put('user_type', $guard);
        Session::put($guard . '_id', $this->getUserIdByGuard($guard, $user));
        Session::put($guard . '_first_name', $user->first_name);

        Log::info('Session updated', [
            'user_id' => $this->getUserIdByGuard($guard, $user),
            'session_id' => Session::getId(),
            'device_type' => $deviceType,
            'location' => $locationString,
        ]);
    }

    /**
     * Get user ID based on the guard.
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
     * Store session data in the sessions table.
     *
     * @param Request $request
     * @param string $guard
     * @param $user
     */
    protected function storeSessionData(Request $request, string $guard, $user): void
    {
        $location = GeoIP::getLocation($request->ip());
        $deviceType = Session::get('device_type');
        $id = $this->getUserIdByGuard($guard, $user);
        $existingSession = DB::table('sessions')
            ->where('user_id', $id)
            ->whereDate('created_at', now()->toDateString())
            ->first();

        $sessionData = [
            'last_activity' => now()->timestamp,
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
            'user_type' => $guard,
        ];

        if ($existingSession) {
            DB::table('sessions')
                ->where('id', $existingSession->id)
                ->update(array_merge($sessionData, ['updated_at' => now()]));
        } else {
            DB::table('sessions')->insert(array_merge($sessionData, [
                'id' => Session::getId(),
                'user_id' => $id,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    /**
     * Return a custom session timeout response.
     *
     * @param string $message
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function sessionExpiredResponse(): Response
    {
        $loginUrl = route('emplogin');

        $html = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Session Expired</title>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: \'Montserrat\', sans-serif;
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
                font-size: 16px;
                color: #fff;
                background-color:#02114f;
                border-radius: 5px;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="message">
                <span>Your session has expired. Please login again.</span>
            </div>
            <a href="' . $loginUrl . '" class="login-link">Login</a>
        </div>
    </body>
    </html>';

        return response($html);
    }

    /**
     * Return a custom session hijacked response.
     *
     * @param $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function sessionHijackedResponse($user): Response
    {
        $loginUrl = route('emplogin');
        $userType = Session::get('user_type');
        $deviceType = Session::get('device_type');
        $location = Session::get('location');
        $ip = request()->ip();

        $html = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Session Hijacked</title>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: \'Montserrat\', sans-serif;
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
                font-size: 16px;
                color: #fff;
                background-color: #dc3545;
                border-radius: 5px;
                text-decoration: none;
            }
            .details {
                margin-top: 20px;
                font-size: 16px;
            }
            .details p {
                margin: 5px 0;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="message">
                <span>Your session has been hijacked. Please login again.</span>
            </div>
            <a href="' . $loginUrl . '" class="login-link">Login</a>
            <div class="details">
                <p><strong>User Type:</strong> ' . $userType . '</p>
                <p><strong>Device Type:</strong> ' . $deviceType . '</p>
                <p><strong>Location:</strong> ' . $location . '</p>
                <p><strong>IP Address:</strong> ' . $ip . '</p>
            </div>
        </div>
    </body>
    </html>';

        return response($html);
    }
}
