<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class CheckAuthAndHandleSession
{
    protected $timeout = 15 * 60; // Timeout in seconds (15 minutes)

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Define an array of guards to check
        $guards = ['emp', 'it', 'hr', 'com', 'finance', 'admins'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                $userId = $this->getUserIdByGuard($guard, $user);
                $currentSessionId = Session::getId();
                $ipAddress = $request->ip();
                $userAgent = $request->header('User-Agent');

                // Enforce single device login
                $existingSession = DB::table('sessions')
                    ->where('user_id', $userId)
                    ->where('id', '!=', $currentSessionId) // Exclude current session
                    ->first();

                if ($existingSession) {
                    // Invalidate the existing session
                    DB::table('sessions')
                        ->where('id', $existingSession->id)
                        ->delete();

                    // Log a message indicating the user was logged out from another device
                    $this->logUserLogout($userId, $existingSession->ip_address, $existingSession->user_agent);
                }

                // Check for session timeout
                $lastActivity = Session::get('last_activity_time');
                if ($lastActivity && (time() - $lastActivity > $this->timeout)) {
                    // Session has expired
                    Auth::guard($guard)->logout();
                    Session::flush();
                    return $this->timeoutResponse('Your session has expired. Please login again.');
                }

                // Get device type using Jenssegers\Agent
                $agent = new Agent();
                $deviceType = $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop');

                // Update session data
                Session::put('last_activity_time', time());
                Session::put('session_id', $currentSessionId);
                Session::put('location', $request->ip());
                Session::put('device_type', $deviceType);

                // Store or update user session info in the sessions table
                DB::table('sessions')->updateOrInsert(
                    ['id' => $currentSessionId],
                    [
                        'user_id' => $userId,
                        'ip_address' => $ipAddress,
                        'user_agent' => $userAgent,
                        'last_activity' => now()->timestamp,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );

                // Log the login details
                Log::info("User {$userId} logged in from IP: {$ipAddress}, Device: {$deviceType}");

                // If user is authenticated, stop checking other guards
                break;
            }
        }

        // If no guard is authenticated, set user_type to guest
        if (!Auth::check()) {
            Session::put('user_type', 'guest');
            Log::info('Session has timed out');
        }

        // Debug log before returning next request
        Log::info('Before next request call', ['request' => $request]);

        return $next($request);
    }

    /**
     * Get user ID based on the guard and user.
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
     * Log a message when a user is logged out from another device.
     *
     * @param mixed $userId
     * @param string $ipAddress
     * @param string $userAgent
     * @return void
     */
    protected function logUserLogout($userId, $ipAddress, $userAgent)
    {
        Log::info("User {$userId} was logged out from IP: {$ipAddress}, Device: {$userAgent} due to login from another device.");
    }

    /**
     * Return a custom session timeout response.
     *
     * @param string $message
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function timeoutResponse(string $message): Response
    {
        $loginUrl = route('emplogin'); // Get the login route URL

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