<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\RegularisationDates;
use App\Models\RegularisationNew1;
use App\Models\Regularisations;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RegularisationHistory extends Component
{
    public $regularisationdescription;
    public $regularisationrequest;

    public $regularisationEntries;
    public $ManagerId;
    public $ManagerName;
    public $id;

    public $totalEntries;

   
    public $empid;
    public $empName;
    public $regularisationdescrip;
    public function mount($id)
    {
        $this->empid = Auth::guard('emp')->user()->emp_id;
        $this->empName = EmployeeDetails::where('emp_id', $this->empid)->first();
        $this->regularisationrequest = RegularisationDates::with('employee')
        ->join('status_types', 'regularisation_dates.status', '=', 'status_types.status_code') // Join status_types table
        ->select('regularisation_dates.*', 'status_types.status_name') // Select all from regularisation_dates and status_name from status_types
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
