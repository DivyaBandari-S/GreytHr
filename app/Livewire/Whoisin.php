<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

use App\Models\EmployeeDetails;

class Whoisin extends Component
{
     public $showWhoIsIn=false;
    public function render()
    {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
       
        // Check if the logged-in user is a manager by comparing emp_id with manager_id in employeedetails
        $isManager = EmployeeDetails::where('manager_id', $loggedInEmpId)->exists();
        
        // Show "Team on Leave" if the logged-in user is a manager
        $this->showWhoIsIn = $isManager;
       
    
        return view('livewire.whoisin');
    }
}
