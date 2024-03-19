<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\EmployeeDetails;

class AttendanceMuster extends Component
{
    public $showAttendanceMuster = false;
   
    public function render()
    {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        
         // Check if the logged-in user is a manager by comparing emp_id with manager_id in employeedetails
         $isManager = EmployeeDetails::where('manager_id', $loggedInEmpId)->exists();
 
         // Show "Team on Leave" if the logged-in user is a manager
         $this->showAttendanceMuster = $isManager;
        return view('livewire.attendance-muster', [
            'showAttendanceMuster' => $this->showAttendanceMuster,
        ]);
    }
}


