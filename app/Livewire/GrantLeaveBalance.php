<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\EmployeeLeaveBalances;
use Illuminate\Database\QueryException;
use Livewire\Component;

class GrantLeaveBalance extends Component
{
    public $emp_ids = [];
    public $emp_id;
    public $employeeIds = [];
    public $selectedEmpIds = [];
    public $leave_type;
    public $leave_balance;
    public $from_date;
    public $to_date;
    public $showEmployees = 'false';
    public $selectAllEmployees = false;

    public function mount()
    {
        // Fetch the employee IDs from the database
        $loggedInCompanyId = auth()->guard('hr')->user()->company_id;
        $this->employeeIds = EmployeeDetails::where('company_id', $loggedInCompanyId)->pluck('emp_id')->toArray();
    }

    public function openEmployeeIds()
    {
        $this->showEmployees = 'true';
    }

    public function closeEmployeeIds()
    {
        $this->showEmployees = 'false';
    }

    public function toggleSelectAllEmployees()
    {
        if ($this->selectAllEmployees) {
            // If "Select All" is checked, set selectedEmpIds to all employee IDs
            $this->selectedEmpIds = $this->employeeIds;
        } else {
            // If "Select All" is unchecked, clear selectedEmpIds
            $this->selectedEmpIds = [];
        }
    }

    public function grantLeavesForEmp()
    {
        $this->validate([
            'selectedEmpIds' => 'required|array|min:1', // Ensure at least one employee ID is selected
            'selectedEmpIds.*' => 'exists:employee_details,emp_id', // Validate each selected employee ID exists in the database
            'leave_type' => 'required',
            'leave_balance' => 'required|integer',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        foreach ($this->selectedEmpIds as $emp_id) {
            try {
                EmployeeLeaveBalances::create([
                    'emp_id' => $emp_id,
                    'leave_type' => $this->leave_type,
                    'leave_balance' => $this->leave_balance,
                    'from_date' => $this->from_date,
                    'to_date' => $this->to_date,
                ]);

                // Flash success message
                session()->flash('success', 'Leave balances added successfully.');
            } catch (QueryException $e) {
                if ($e->errorInfo[1] == 1062) {
                    // Handle the duplicate entry error here
                    session()->flash('error', 'Leaves have already been added for the selected employee(s).');
                }
            }
        }

        // Redirect after processing
        return redirect()->to('/addLeaves');
    }

    public function render()
    {
        return view('livewire.grant-leave-balance');
    }
}
