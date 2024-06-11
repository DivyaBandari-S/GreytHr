<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Torann\GeoIP\Facades\GeoIP;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        // Check if the user is an employee
         if (auth()->guard('emp')->check()) {
            //   session(['user_type' => 'emp']);
            // $user = Auth::User();
            // Session::put('name', $user->name);
            // $request->session()->forget('department');
            // $request->session()->flush();
            $emp_id = Auth::guard('emp')->user()->emp_id;
            Session::put('emp_id', $emp_id);
            Log::info("Emp ID set: $emp_id");
            $user = auth('emp')->user();
            //   Log::info("Session Timeout: $sessionTimeout minutes");
            //   config(['session.lifetime' => $sessionTimeout]);
            return redirect(route('profile.info'));
        } elseif (auth()->user() && auth()->check()) {
            return redirect('/Jobs');
        } elseif (auth()->guard('com')->check()) {
            return redirect('/PostJobs');
        } else if (auth()->guard('finance')->check()) {
            session(['user_type' => 'finance']);
            return redirect('/financePage');
        } else if (auth()->guard('hr')->check()) {
            session(['user_type' => 'hr']);
            return redirect('/hrPage');
        } else if (auth()->guard('it')->check()) {
            session(['user_type' => 'it']);
            return redirect('/itPage');
        } else if (auth()->guard('admins')->check()) {
            session(['user_type' => 'admins']);
            return redirect('/adminPage');
        } else {
            session(['user_type' => 'guest']);
            Log::info('Session has timed out');
            // return redirect('/emplogin');
            //  return redirect(route('emplogin'));
            return $next($request);
        }

        // Handle other user types and session expiration logic if needed
    }


    //  public function handle(Request $request, Closure $next): Response
    // {
    //   // $employee = $request->user('emp');

    //   //     if ($employee) {
    //   //         Log::info("Authenticated Employee ID: " . $employee->emp_id);

    //   //         // You can use the employee ID as needed
    //   //         return redirect()->route('home');
    //   //     }

    //   $guards = [
    //       'emp' => 'home',
    //       'hr' => 'home',
    //       'finance' => 'home',
    //       'com' => 'home',
    //       'it' => 'home',
    //   ];

    //   foreach ($guards as $guard => $route) {
    //       if (Auth::guard($guard)->check()) {
    //           $user = Auth::guard($guard)->user();
    //           Log::info("Authenticated User ID (Guard: $guard): " . $user->id);
    //           return redirect()->route($route);
    //       }
    //   }

    //   return $next($request);
    // }


}
