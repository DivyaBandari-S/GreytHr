<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\LeaveRequest;
use App\Models\SwipeRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelWriter;

class AbsentReport extends Component
{
    public $employees1;

    public $employees;
    public $fromDate;
    public $toDate;
    public $loggedInEmpId;

    public $currentDate;

    public $showAbsentReportDialog = true;
    public $approvedLeaveRequests;

    public $selectedEmployees = [];

    protected $listeners = ['employeeSelected'];
    public function mount()
    {
        $this->loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $this->currentDate = now()->toDateString();
    }
    public function close()
    {
        $this->showAbsentReportDialog = false;
    }
    public function updatefromDate()
    {
        $this->fromDate = $this->fromDate;
    }
    public function updatetoDate()
    {
        $this->toDate = $this->toDate;
    }
    public function downloadAbsentReportInExcel()
    {
        $employees = EmployeeDetails::where('manager_id', $this->loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->get();
        $this->approvedLeaveRequests = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
            ->where('leave_applications.status', 'approved')
            ->whereIn('leave_applications.emp_id', $employees->pluck('emp_id'))
            ->whereDate('from_date', '<=', $this->currentDate)
            ->whereDate('to_date', '>=', $this->currentDate)
            ->get(['leave_applications.*', 'employee_details.first_name', 'employee_details.last_name'])
            ->map(function ($leaveRequest) {

                $fromDate = Carbon::parse($leaveRequest->from_date);
                $toDate = Carbon::parse($leaveRequest->to_date);

                $leaveRequest->number_of_days = $fromDate->diffInDays($toDate) + 1;

                return $leaveRequest;
            });
        if ($this->fromDate && $this->toDate) {
            $query = EmployeeDetails::where('manager_id', $this->loggedInEmpId)
                ->select('emp_id', 'first_name', 'last_name', 'created_at')
                ->whereNotIn('emp_id', function ($query) {
                    $query->select('emp_id')
                        ->from('swipe_records')
                        ->where('manager_id', $this->loggedInEmpId)
                        ->whereDate('created_at', '>=', $this->fromDate)
                        ->whereDate('created_at', '<=', $this->toDate);
                })
                ->whereNotIn('emp_id', $this->approvedLeaveRequests->pluck('emp_id'));
        } else {
            $query = EmployeeDetails::where('manager_id', $this->loggedInEmpId)
                ->select('emp_id', 'first_name', 'last_name', 'created_at')
                ->whereNotIn('emp_id', function ($query) {
                    $query->select('emp_id')
                        ->from('swipe_records')
                        ->where('manager_id', $this->loggedInEmpId)
                        ->whereDate('created_at', $this->currentDate);
                })
                ->whereNotIn('emp_id', $this->approvedLeaveRequests->pluck('emp_id'));
        }
        $employees2 = $query->get();
        if ($this->fromDate && $this->toDate) {
            $data = [
                ['List of Absent Employees on from' . Carbon::parse($this->fromDate)->format('jS F, Y') . 'to' . Carbon::parse($this->toDate)->format('jS F, Y')],
                ['Employee ID', 'Name'],

            ];
        } else {
            $data = [
                ['List of Absent Employees on ' . Carbon::parse($this->currentDate)->format('jS F, Y')],
                ['Employee ID', 'Name'],

            ];
        }
        foreach ($employees2 as $employee) {
            $data[] = [$employee['emp_id'], $employee['first_name'] . ' ' . $employee['last_name']];
        }
        $filePath = storage_path('app/absent_employees.xlsx');
        SimpleExcelWriter::create($filePath)->addRows($data);
        return response()->download($filePath, 'absent_employees.xlsx');
    }
    public function employeeSelected($empId)
    {
        if (in_array($empId, $this->selectedEmployees)) {
            $this->selectedEmployees = array_diff($this->selectedEmployees, [$empId]);
        } else {
            $this->selectedEmployees[] = $empId;
        }
        
    }
    public function render()
    {


        $this->employees = EmployeeDetails::where('manager_id', $this->loggedInEmpId)->select('emp_id', 'first_name', 'last_name','employee_status')->get();
        $this->approvedLeaveRequests = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
            ->where('leave_applications.status', 'approved')
            ->whereIn('leave_applications.emp_id', $this->employees->pluck('emp_id'))
            ->whereDate('from_date', '<=', $this->currentDate)
            ->whereDate('to_date', '>=', $this->currentDate)
            ->get(['leave_applications.*', 'employee_details.first_name', 'employee_details.last_name'])
            ->map(function ($leaveRequest) {

                $fromDate = Carbon::parse($leaveRequest->from_date);
                $toDate = Carbon::parse($leaveRequest->to_date);

                $leaveRequest->number_of_days = $fromDate->diffInDays($toDate) + 1;

                return $leaveRequest;
            });
        if ($this->fromDate && $this->toDate) {
            $query = EmployeeDetails::where('manager_id', $this->loggedInEmpId)
                ->select('emp_id', 'first_name', 'last_name', 'created_at','employee_status')
                ->whereNotIn('emp_id', function ($query) {
                    $query->select('emp_id')
                        ->from('swipe_records')
                        ->where('manager_id', $this->loggedInEmpId)
                        ->whereDate('created_at', '>=', $this->fromDate)
                        ->whereDate('created_at', '<=', $this->toDate);
                })
                ->whereNotIn('emp_id', $this->approvedLeaveRequests->pluck('emp_id'));
        } else {
            $query = EmployeeDetails::where('manager_id', $this->loggedInEmpId)
                ->select('emp_id', 'first_name', 'last_name', 'created_at','employee_status')
                ->whereNotIn('emp_id', function ($query) {
                    $query->select('emp_id')
                        ->from('swipe_records')
                        ->where('manager_id', $this->loggedInEmpId)
                        ->whereDate('created_at', $this->currentDate);
                })
                ->whereNotIn('emp_id', $this->approvedLeaveRequests->pluck('emp_id'));
        }
        $this->employees1 = $query->get();

        return view('livewire.absent-report');
    }
}
