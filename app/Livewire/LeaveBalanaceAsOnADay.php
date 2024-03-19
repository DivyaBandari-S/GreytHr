<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LeaveBalanaceAsOnADay extends Component
{
    public $employeeDetails;
    public $allEmployeeDetails;
    public $selectedEmployeeNumbers = [];
    public function mount()
    {
        // Initialize the $employeeDetails variable during component mount
        $this->employeeDetails = EmployeeDetails::all();
    }

    public $employee;
    public function render()
    {
        $companyId = Auth::user()->company_id;
        $this->employeeDetails = EmployeeDetails::where('company_id', $companyId)->get();
        return view('livewire.leave-balanace-as-on-a-day');
    }

    public function downloadExcel()
    {
        session()->flash('message', 'Excel file downloaded successfully!');
        // Your logic for Excel download goes here
    }
    public function calculateLeaveBalance()

    {

        // Fetch employee details based on selected employee numbers
        $this->allEmployeeDetails = EmployeeDetails::whereIn('emp_id', $this->selectedEmployeeNumbers)->get();


        // Calculate leave balance for each employee
        $this->allEmployeeDetails->each(function ($employee) {
            // Replace this with your actual leave balance calculation logic
            $employee->leaveBalance = rand(20, 30);
        });
        $this->allEmployeeDetails->each(function ($employee) {
            // Replace this with your actual leave balance calculation logic
            $employee->leaveBalance = rand(20, 30);
        });
        $this->allEmployeeDetails->push(
            new EmployeeDetails(['leaveBalance' => rand(20, 30)]),
            new EmployeeDetails(['leaveBalance' => rand(20, 30)])
            // Add more employees as needed
        );
    }



    public function leaveBalanceReport()
    {
        // Retrieve selected employee details from the session
        $selectedEmployeeDetails = session()->get('selectedEmployeeDetails');

        // Your existing logic for the leave balance report
        // ...

        // Make sure to clear the flashed data from the session to avoid it being available in subsequent requests
        session()->forget('selectedEmployeeDetails');
    }
}
