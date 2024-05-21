<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use Livewire\Component;
use Carbon\Carbon;

class EmpTimeSheet extends Component
{
    public $employeeDetails;
    public $openTimeSheettable = false;
    public $currentWeek;
    public $submissionDate;
    public $managerDetails;
    public $managerNameOfLogin;
    public $rows = [];
    public $addingRow = false;
    public function addNewRow()
    {
        if (!$this->addingRow) {
            $this->addingRow = true;
            $this->rows[] = ['', '', '', 0, 0, 0, 0, 0, 0, 0, 0];
            $employeeId = auth()->guard('emp')->user()->emp_id;
            session(["timesheet_rows_{$employeeId}" => $this->rows]);
        }
    }
    public function mount()
    {
        // Get the start of the current week
        $startOfWeek = Carbon::now()->startOfWeek();
        $employeeId = auth()->guard('emp')->user()->emp_id;
        // Get the end of the current week
        $endOfWeek = Carbon::now()->endOfWeek();
        $this->submissionDate =$endOfWeek->format('d F, Y');
        // Check if the start and end dates fall within the same month
        if ($startOfWeek->month == $endOfWeek->month) {
            // Format the dates with month name
            $formattedStartDate = $startOfWeek->format('d');
            $formattedEndDate = $endOfWeek->format('d F, Y');
        } else {
            // Format the dates with month name for both start and end dates
            $formattedStartDate = $startOfWeek->format('d F');
            $formattedEndDate = $endOfWeek->format('d F, Y');
        }

        // Set the current week range
        $this->currentWeek = $formattedStartDate . '-' . $formattedEndDate;
        if (session()->has("timesheet_rows_{$employeeId}")) {
            $this->rows = session("timesheet_rows_{$employeeId}");
        } else {
            $this->rows = [
                ['', '', '', 8, 8, 8, 8, 8, 0, 0, 40],
            ];
            session(["timesheet_rows_{$employeeId}" => $this->rows]);
        }
    }

    public function openTimeSheet(){
         $this->openTimeSheettable = true;
    }
    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id',$employeeId)->first();
        if($this->employeeDetails){
            $managerId = $this->employeeDetails->manager_id;
            $this->managerDetails = EmployeeDetails::where('emp_id',$managerId)->first();
            if($this->managerDetails ){
                $this->managerNameOfLogin = ucwords(strtolower($this->managerDetails->first_name)) . ' ' . ucwords(strtolower($this->managerDetails->last_name));
            }else{
                $this->managerNameOfLogin = null;
            }
        }

        return view('livewire.emp-time-sheet',[
            'employeeDetails' => $this->employeeDetails,
            'managerNameOfLogin' => $this->managerNameOfLogin
        ]);
    }
}
