<?php
 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
 
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
      $emp_id = Auth::guard('emp')->user()->emp_id;
      Session::put('emp_id', $emp_id);
      $user = auth('emp')->user();
      $sessionTimeout = $user->role === 'admin' ? 60 : 10; // Example: Admins get a 60-minute timeout, others get a 10-minute timeout.
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
    }  else {
      session(['user_type' => 'guest']);
      Log::info('Session has timed out');
     // return redirect('/emplogin');
    //  return redirect(route('emplogin'));
      return $next($request);
    }
 
    // Handle other user types and session expiration logic if needed
 
    return $next($request);
  }
}
