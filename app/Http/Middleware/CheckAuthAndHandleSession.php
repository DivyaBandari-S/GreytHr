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
    protected $timeout = 10; // 15 minutes timeout in seconds

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

                // Enforce single device login
                $storedSessionId = Session::get('session_id');
                // Check for session timeout
                $lastActivity = Session::get('last_activity_time');

                if ($lastActivity && (time() - $lastActivity > $this->timeout)) {
                    // Session has expired
                    Auth::guard($guard)->logout();
                    Session::flush();

                    // Return a custom response with session expired message and login link
                    return $this->timeoutResponse('Your session has expired. Please login again.');
                }

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

                // Store additional user information based on the guard
                switch ($guard) {
                    case 'emp':
                        $id = $user->emp_id;
                        break;
                    case 'it':
                        $id = $user->it_emp_id;
                        break;
                    case 'hr':
                        $id = $user->hr_emp_id;
                        break;
                    case 'com':
                        $id = $user->company_id;
                        break;
                    case 'finance':
                        $id = $user->fi_emp_id;
                        break;
                    case 'admins':
                        $id = $user->admin_emp_id;
                        break;
                    default:
                        $id = null;
                        break;
                }

                Session::put($guard . '_id', $id);
                Session::put($guard . '_first_name', $user->first_name);
                Log::info("$guard ID set: $id");
                Session::put('user_type', $guard);

                // Store data in the session table
                DB::table('sessions')->updateOrInsert(
                    ['id' => session()->getId()],
                    [
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
                        'payload' => '', // Example: You can store session payload if needed
                        'last_activity' => now()->timestamp,
                        'device_type' => $deviceType,
                        'created_at' => now(), // Set the created_at timestamp
                        'updated_at' => now(), // Set the updated_at timestamp
                    ]
                );

                // If user is authenticated, stop checking other guards
                break;
            }
        }

        if (!Auth::check()) {
            session(['user_type' => 'guest']);
            Log::info('Session has timed out');
        }

        // Debug log before returning next request
        Log::info('Before next request call', ['request' => $request]);

        return $next($request);
    }

    /**
     * Return a custom session timeout response.
     *
     * @param string $message
     * @return \Symfony\Component\HttpFoundation\Response
     */

    protected function timeoutResponse($message): Response
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