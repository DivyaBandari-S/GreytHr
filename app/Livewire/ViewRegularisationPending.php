<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\RegularisationNew;
use App\Models\RegularisationNew1;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ViewRegularisationPending extends Component
{
    public $regularisations;
    public $employeeId;

    public $user;

    public $remarks;

    public $countofregularisations;
    public function mount()
    {
        $this->employeeId = auth()->guard('emp')->user()->emp_id;
        $this->user = EmployeeDetails::where('emp_id', $this->employeeId)->first();
    }
    public function approve($id)
    {
        $currentDateTime = Carbon::now();
        $item = RegularisationNew1::find($id);
        $item->status='approved';
        if(empty($this->remarks))
        {

        }
        else
        {
            $item->approver_remarks=$this->remarks;
        }
        $item->approved_date = $currentDateTime;
        $item->approved_by=$this->user->first_name . ' ' . $this->user->last_name;
        $item->save();
        $this->countofregularisations--;
        Session::flash('success', 'Regularisation Request approved successfully');
    }
    
    public function reject($id)
    {
        $currentDateTime = Carbon::now();
        $item = RegularisationNew1::find($id);
        if(empty($this->remarks))
        {

        }
        else
        {
            $item->approver_remarks=$this->remarks;
        }
        $item->status='rejected';
        $item->rejected_date = $currentDateTime; 
        $item->rejected_by=$this->user->first_name . ' ' . $this->user->last_name;
        $item->save();
        $this->countofregularisations--;
        Session::flash('success', 'Regularisation Request rejected successfully');
    }
 
  
    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $employees=EmployeeDetails::where('manager_id',$employeeId)->select('emp_id', 'first_name', 'last_name')->get();
        $empIds = $employees->pluck('emp_id')->toArray();
        
// Retrieve records from AttendanceRegularisationNew for the extracted emp_ids
        $this->regularisations = RegularisationNew1::whereIn('emp_id', $empIds)
        ->where('is_withdraw', 0) // Assuming you want records with is_withdraw set to 0
        ->where('status','pending')
        ->selectRaw('*, JSON_LENGTH(regularisation_entries) AS regularisation_entries_count')
        ->whereRaw('JSON_LENGTH(regularisation_entries) > 0') 
        ->with('employee') 
        ->get();
              
        $this->countofregularisations=$this->regularisations->count();     
        return view('livewire.view-regularisation-pending');
    }
}
