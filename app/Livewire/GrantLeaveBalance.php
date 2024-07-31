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
            'selectedEmpIds' => 'required|array|min:1',
            'selectedEmpIds.*' => 'exists:employee_details,emp_id',
            'leave_type' => 'required',
            'leave_balance' => 'required|integer',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        foreach ($this->selectedEmpIds as $emp_id) {
            try {
                $leaveBalance = EmployeeLeaveBalances::where('emp_id', $emp_id)->first();

                if ($leaveBalance) {
                    // Update existing record
                    $leaveTypes = json_decode($leaveBalance->leave_type, true) ?? [];
                    $leaveBalances = json_decode($leaveBalance->leave_balance, true) ?? [];
                    $fromDates = json_decode($leaveBalance->from_date, true) ?? [];
                    $toDates = json_decode($leaveBalance->to_date, true) ?? [];

                    // Update leave types and balances
                    if (!in_array($this->leave_type, $leaveTypes)) {
                        $leaveTypes[] = $this->leave_type;
                    }
                    $leaveBalances[$this->leave_type] = $this->leave_balance;
                    $fromDates[] = $this->from_date;
                    $toDates[] = $this->to_date;

                    $leaveBalance->update([
                        'leave_type' => json_encode($leaveTypes),
                        'leave_balance' => json_encode($leaveBalances),
                        'from_date' => json_encode($fromDates),
                        'to_date' => json_encode($toDates),
                    ]);

                } else {
                    // Create new record
                    EmployeeLeaveBalances::create([
                        'emp_id' => $emp_id,
                        'leave_type' => json_encode([$this->leave_type]),
                        'leave_balance' => json_encode([$this->leave_type => $this->leave_balance]),
                        'from_date' => json_encode([$this->from_date]),
                        'to_date' => json_encode([$this->to_date]),
                    ]);
                }

                // Flash success message
                session()->flash('success', 'Leave balances updated successfully.');
            } catch (QueryException $e) {
                if ($e->errorInfo[1] == 1062) {
                    // Handle the duplicate entry error here
                    session()->flash('error', 'An error occurred while updating leave balances.');
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
