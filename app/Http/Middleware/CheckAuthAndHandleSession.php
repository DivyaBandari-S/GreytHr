<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CheckAuthAndHandleSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::guard('emp')->check()) {
            $emp_id = Auth::guard('emp')->user()->emp_id;
            Session::put('emp_id', $emp_id);
            Log::info("Emp ID set: $emp_id");
            $user = auth('emp')->user();
            Session::put('user_type', 'emp');
        } elseif (Auth::guard('it')->check()) {
            $it_emp_id = Auth::guard('it')->user()->it_emp_id;
            Session::put('it_emp_id', $it_emp_id);
            Log::info("It ID set: $it_emp_id");
            Session::put('user_type', 'it');
        } elseif (Auth::guard('hr')->check()) {

            $hr_emp_id = Auth::guard('hr')->user()->hr_emp_id;
            Session::put('hr_emp_id', $hr_emp_id);
            Log::info("Hr ID set: $hr_emp_id");
            Session::put('user_type', 'hr');
        }elseif (Auth::guard('com')->check()) {
            $company_id = Auth::guard('com')->user()->company_id;
            Session::put('company_id', $company_id);
            Log::info("Company ID set: $company_id");

            Session::put('user_type', 'company');
        } else if (Auth::guard('finance')->check()) {
            $fi_emp_id = Auth::guard('finance')->user()->fi_emp_id;
            Session::put('fi_emp_id', $fi_emp_id);
            Log::info("Finance ID set: $fi_emp_id");
            session(['user_type' => 'finance']);
        } else if (Auth::guard('admins')->check()) {
            $admin_emp_id = Auth::guard('admins')->user()->admin_emp_id;
            Session::put('admin_emp_id', $admin_emp_id);
            Log::info("Emp ID set: $admin_emp_id");
            session(['user_type' => 'admins']);
        } else {
            session(['user_type' => 'guest']);
            Log::info('Session has timed out');
        }
        return $next($request);
    }
}
