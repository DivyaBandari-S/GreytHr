<?php

namespace App\Livewire;
use Illuminate\Support\Facades\Auth;
use App\Models\EmployeeDetails;
use App\Models\SwipeRecord;
use App\Models\LeaveRequest;
use Livewire\Component;
use Carbon\Carbon;

class AttendanceMusterData extends Component
{
    public $currentMonth;
    public $daysInMonth;

    public $distinctDatesMap;
    public function render()
    {
        $currentMonth = now()->format('n');
        $this->daysInMonth = now()->daysInMonth;
        
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $employees=EmployeeDetails::where('manager_id',$loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->get();
        $employeescount=EmployeeDetails::where('manager_id',$loggedInEmpId)->count();
      
        $managerId = $loggedInEmpId;
        // $swipes now contains $managerId = $loggedInEmpId;

        $employees = EmployeeDetails::where('manager_id', $managerId)
        ->select('emp_id', 'first_name', 'last_name','job_title','city')
        ->get();

        $employeeIds = $employees->pluck('emp_id');

        $distinctDatesMap = SwipeRecord::whereIn('emp_id', $employeeIds)
            ->whereMonth('created_at', 12) // December
            ->selectRaw('DISTINCT emp_id, DATE(created_at) as distinct_date ')
            ->get()
            ->groupBy('emp_id')
            ->map(function ($dates) {
                return $dates->pluck('distinct_date')->toArray();
            })
            ->toArray();
            
        $distinctDatesMapCount = SwipeRecord::whereIn('swipe_records.emp_id', $employeeIds)
            ->whereMonth('swipe_records.created_at', 12) // December
            ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
            ->selectRaw('swipe_records.emp_id, COUNT(DISTINCT DATE(swipe_records.created_at)) as date_count, employee_details.first_name, employee_details.last_name')
            ->groupBy('swipe_records.emp_id', 'employee_details.first_name', 'employee_details.last_name')
            ->get()
            ->keyBy('emp_id')
            ->toArray();
        return view('livewire.attendance-muster-data',['Employees'=>$employees,'EmployeesCount'=>$employeescount,'DistinctDatesMap'=>$distinctDatesMap,'DistinctDatesMapCount'=>$distinctDatesMapCount]);
    }
}
