<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Livewire\Component;

class MainLayout extends Component
{
    public $showLogoutModal = false;
    public $loginEmployeeProfile;

    public function mount(){
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->loginEmployeeProfile = EmployeeDetails::where('emp_id',$employeeId)->select('emp_id', 'first_name', 'last_name','image')->first();
    }
    public function handleLogout()
    {
        $this->showLogoutModal = true;
    }
    public function confirmLogout()
    {
        // dump(Session::get('hr_emp_id'));
        // dump(Session::get('admin_emp_id'));
        // dump(Session::get('emp_id'));
        // dump(Session::get('fi_emp_id'));
        // dump(Session::get('it_emp_id'));
        // dd(Session::pull('emp_id'));

        //    if (auth()->guard('emp')->logout()) {
        //         Auth::logout();
        //         session()->forget('emp_id');
        //         session()->forget('admin_emp_id');
        //         session()->forget('fi_emp_id');
        //         session()->forget('hr_emp_id');
        //         session()->forget('it_emp_id');
        //         session()->forget('company_id');
        //         session()->flush();
        //         session_unset();
        //         session()->flash('success', "You are logged out successfully!");
        //     } elseif (auth()->guard('hr')->logout()) {
        //         dd('hello');
        //         dump(Session::get('hr_emp_id'));
        //         Auth::logout();
        //         session()->forget('emp_id');
        //         session()->forget('admin_emp_id');
        //         session()->forget('fi_emp_id');
        //         session()->forget('hr_emp_id');
        //         session()->forget('it_emp_id');
        //         session()->forget('company_id');
        //         session()->flush();
        //         session_unset();
        //         session()->flash('success', "You are logged out successfully!");
        //     } elseif (auth()->guard('it')->logout()) {
        //         Auth::logout();
        //         session()->forget('emp_id');
        //         session()->forget('admin_emp_id');
        //         session()->forget('fi_emp_id');
        //         session()->forget('hr_emp_id');
        //         session()->forget('it_emp_id');
        //         session()->forget('company_id');
        //         session()->flush();
        //         session_unset();
        //         session()->flash('success', "You are logged out successfully!");
        //     } elseif (auth()->guard('finance')->logout()) {
        //         Auth::logout();
        //         session()->forget('emp_id');
        //         session()->forget('admin_emp_id');
        //         session()->forget('fi_emp_id');
        //         session()->forget('hr_emp_id');
        //         session()->forget('it_emp_id');
        //         session()->forget('company_id');
        //         session()->flush();
        //         session_unset();
        //         session()->flash('success', "You are logged out successfully!");
        //     }
        //     //return redirect(route('emplogin'));

        try {
            // Logout the user from all guards
            Auth::logout();

            // Clear session data
            session()->flush();

            // Flash success message
            session()->flash('success', "You are logged out successfully!");

            // Redirect to the login page
            return redirect()->route('emplogin');
        } catch (\Exception $exception) {
            // Handle exceptions
            session()->flash('error', "An error occurred while logging out.");
            return redirect()->route('emplogin'); // Redirect back with an error message
        }
    }
    public function cancelLogout()
    {
        $this->showLogoutModal = false;
    }
    public function render()
    {
        return view('livewire.main-layout');
    }
}
