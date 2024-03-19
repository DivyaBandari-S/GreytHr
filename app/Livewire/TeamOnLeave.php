<?php
// File Name                       : TeamOnLeave.php
// Description                     : This file contains the implementation of to get team on leave dropdown option for manager
// Creator                         : Bandari Divya
// Email                           : bandaridivya1@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : EmployeeDetails
namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\EmployeeDetails;

class TeamOnLeave extends Component
{
    public $showTeamOnLeave = false;

    public function render()
    {
        // Get the authenticated user's emp_id
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;

        // Check if the logged-in user is a manager by comparing emp_id with manager_id in employeedetails
        $isManager = EmployeeDetails::where('manager_id', $loggedInEmpId)->exists();

        // Show "Team on Leave" if the logged-in user is a manager
        $this->showTeamOnLeave = $isManager;

        return view('livewire.team-on-leave', [
            'showTeamOnLeave' => $this->showTeamOnLeave,
        ]);
    }
}
