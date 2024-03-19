<?php

namespace App\Livewire;
use App\Models\EmployeeDetails;
use App\Models\Regularisations;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Livewire\Component;

class TeamOnAttendanceChart extends Component
{
    public $data8;
    public $showTeamOnAttendance1= false;
    public function approve($id)
    {
       
        $regularisation = Regularisations::find($id);
        $currentDateTime1 = Carbon::now(); 
        $regularisation->status = 'approved';
        $s=EmployeeDetails::where('manager_id',auth()->guard('emp')->user()->emp_id)->pluck('report_to')->toArray();
        $s1 = implode(' ', $s); 
  
        $regularisation->approved_by =$s1 ;
     
        $regularisation->is_withdraw = 1;
        $regularisation->approved_date=$currentDateTime1;
        $regularisation->save();
      
    }
    public function reject($id)
    {
        $currentDateTime2 = Carbon::now(); 
        $regularisation = Regularisations::find($id);
        $regularisation->status = 'rejected';
        $s2=EmployeeDetails::where('manager_id',auth()->guard('emp')->user()->emp_id)->pluck('report_to')->toArray();
        $s3 = implode(' ', $s2); 
  
        $regularisation->rejected_by =$s3 ;
        $regularisation->rejected_date =$currentDateTime2;
        $regularisation->is_withdraw = 1;
        $regularisation->save();
    }
    public function render()
    {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        
        // Check if the logged-in user is a manager by comparing emp_id with manager_id in employeedetails
        $isManager = EmployeeDetails::where('manager_id', $loggedInEmpId)->exists();
        $this->showTeamOnAttendance1= $isManager;
        $subordinateEmployeeIds = EmployeeDetails::where('manager_id',auth()->guard('emp')->user()->emp_id)
        ->pluck('first_name','last_name')
        ->toArray();
        $this->data8 = Regularisations::where('is_withdraw', '0')->get();
      
        return view('livewire.team-on-attendance-chart',['withdraw'=> $this->data8,'subordinate'=>$subordinateEmployeeIds]);
    }
}
