<?php

namespace App\Livewire;

use App\Helpers\FlashMessageHelper;
use App\Models\EmployeeDetails;
use App\Models\RegularisationDates;
use App\Models\RegularisationNew1;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

    public $remarks = [];

   
    public $empid;
    public $empName;

    public $employeeDetails;
    public $regularisationdescrip;
    public function mount($id)
    {
       

        // Loop through each request and reject it
        
        $this->empid = Auth::guard('emp')->user()->emp_id;
        $this->empName = EmployeeDetails::where('emp_id', $this->empid)->first();
        $this->regularisationrequest = RegularisationDates::with('employee')->find($id);
        $subordinateEmpId=$this->regularisationrequest->emp_id;
        $this->employeeDetails = Employeedetails::where('emp_id', $subordinateEmpId)->first();
        $this->ManagerId=$this->regularisationrequest->employee->manager_id;
        
        $this->ManagerName=EmployeeDetails::select('first_name','last_name')->where('emp_id',$this->ManagerId)->first();
        $this->regularisationEntries = json_decode($this->regularisationrequest->regularisation_entries, true);
        $this->totalEntries = count($this->regularisationEntries);
    }
   
    public function approve($date)
    {
        // dd('approve'.$date);
        $remark = $this->remarks[$date] ?? null;
        Log::info($remark);
    }
    public function reject($date)
    {
        // dd('reject'.$date);
        $remark = $this->remarks[$date] ?? null;

        // Log the remark for debugging purposes
        Log::info('Remark:', ['remark' => $remark]);

        // Find the entry with the matching date and update its status
        foreach ($this->regularisationEntries as &$entry) {
            if ($entry['date'] === $date) {
                $entry['status'] = 3;
                $entry['remark'] = $remark; // Optionally add the remark to the entry
                FlashMessageHelper::flashSuccess('Regularization Request Rejected Successfully');
                break;
            }
        }

        // Save the updated regularisationEntries back to the database
        $this->regularisationrequest->regularisation_entries = json_encode($this->regularisationEntries);
        $this->regularisationrequest->save();
    }
   
    public function render()
    {
        $today = Carbon::today();
        return view('livewire.review-pending-regularisation',['regularisationdesc'=>$this->regularisationdescription,'today'=>$today]);
    }
}
