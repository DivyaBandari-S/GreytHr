<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\RegularisationNew1;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReviewPendingRegularisation extends Component
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

    public $employeeDetails;
    public $regularisationdescrip;
    public function mount($id)
    {
       

        // Loop through each request and reject it
        
        $this->empid = Auth::guard('emp')->user()->emp_id;
        $this->empName = EmployeeDetails::where('emp_id', $this->empid)->first();
        $this->regularisationrequest = RegularisationNew1::with('employee')->find($id);
        $subordinateEmpId=$this->regularisationrequest->emp_id;
        $this->employeeDetails = Employeedetails::where('emp_id', $subordinateEmpId)->first();
        $this->ManagerId=$this->regularisationrequest->employee->manager_id;
        $this->ManagerName=EmployeeDetails::select('first_name','last_name')->where('emp_id',$this->ManagerId)->first();
        $this->regularisationEntries = json_decode($this->regularisationrequest->regularisation_entries, true);
        $this->totalEntries = count($this->regularisationEntries);
    }
   
   
    public function render()
    {
        $today = Carbon::today();
        return view('livewire.review-pending-regularisation',['regularisationdesc'=>$this->regularisationdescription,'today'=>$today]);
    }
}
