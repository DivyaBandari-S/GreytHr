<?php
 
namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CheckAuthAndHandleSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Define an array of guards to check
        $guards = ['emp', 'it', 'hr', 'com', 'finance', 'admins'];
 
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
 
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
                Log::info("$guard ID set: $id");
                Session::put('user_type', $guard);
                // Get GeoIP data
                $geoIpData = geoip()->getLocation(geoip()->getClientIP());
                $userAgent = $request->header('User-Agent');
                // Store data in session table
                DB::table('sessions')->updateOrInsert(
                    ['id' => session()->getId()],
                    [
                        'user_id' => $id,
                        'ip_address' => $geoIpData['ip'],
                        'user_agent'=>$userAgent,
                        'iso_code' => $geoIpData['iso_code'],
                        'country' => $geoIpData['country'],
                        'city' => $geoIpData['city'],
                        'state' => $geoIpData['state'],
                        'state_name' => $geoIpData['state_name'],
                        'postal_code' => $geoIpData['postal_code'],
                        'latitude' => $geoIpData['lat'],
                        'longitude' => $geoIpData['lon'],
                        'timezone' => $geoIpData['timezone'],
                        'continent' => $geoIpData['continent'],
                        'currency' => $geoIpData['currency'],
                        'payload' => '', // Example: You can store session payload if needed
                        'last_activity' => now()->timestamp,
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
 
        return $next($request);
    }
}
 
