<?php

namespace App\Livewire;

use App\Models\CompanyShifts;
use App\Models\EmployeeDetails;
use App\Models\RegularisationDates;
use App\Models\RegularisationNew1;
use App\Models\Regularisations;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegularisationHistory extends Component
{
    public $regularisationdescription;
    public $regularisationrequest;

    public $regularisationEntries;
    public $ManagerId;
    public $ManagerName;
    public $id;

    public $totalEntries;

    public $empShiftStartTime;
   
    public $empShiftEndTime;
    public $empid;
    public $empName;
    public $regularisationdescrip;

    public $empCompanyName;
    public $empShiftType;
    public function mount($id)
    {
        $this->empid = Auth::guard('emp')->user()->emp_id;
        $this->empName = EmployeeDetails::where('emp_id', $this->empid)->first();
        $this->empShiftType=EmployeeDetails::where('emp_id', $this->empid)->value('shift_type');
        $companyIdJson = EmployeeDetails::where('emp_id', $this->empid)->value('company_id');
        $this->empCompanyName = $companyIdJson[0];
        $this->empShiftStartTime=CompanyShifts::where('company_id',$this->empCompanyName)->where('shift_name',$this->empShiftType)->value('shift_start_time');
        $this->empShiftEndTime=CompanyShifts::where('company_id',$this->empCompanyName)->where('shift_name',$this->empShiftType)->value('shift_end_time');
        $this->regularisationrequest = RegularisationDates::with('employee')
    ->join('status_types', 'regularisation_dates.status', '=', 'status_types.status_code') // Join status_types table
    ->join('employee_details', 'regularisation_dates.emp_id', '=', 'employee_details.emp_id') // Join employee_details based on emp_id

        ->select(
            'regularisation_dates.*', 
            'status_types.status_name', 
           
        )
        ->find($id);
        $this->ManagerId=$this->regularisationrequest->employee->manager_id;
        $this->ManagerName=EmployeeDetails::select('first_name','last_name')->where('emp_id',$this->ManagerId)->first();
        $this->regularisationEntries = json_decode($this->regularisationrequest->regularisation_entries, true);
        $this->regularisationEntries = array_reverse($this->regularisationEntries);
        $this->totalEntries = count($this->regularisationEntries);
    }

    public function render()
    {
        $today = Carbon::today();
        return view('livewire.regularisation-history',['regularisationdesc'=>$this->regularisationdescription,'today'=>$today]);
    }
}
