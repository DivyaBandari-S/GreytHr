<?php

namespace App\Livewire;

use App\Exports\ShiftRosterExport;
use App\Models\EmployeeDetails;
use App\Models\HolidayCalendar;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ShiftRoaster extends Component
{
    public $searching=1;
    public $search;

    public $holiday;
    public $notFound;

    public $selectedMonth;
    public $attendanceMonth;

    public $currentMonth;

    public $previousMonth;

    public $nextMonth;

    public $currentMonthForDropdown;
    public $currentYear;

    public $previousYear;

    public $nextYear;

    public $previousMonthWithPreviousYear;

    public $nextMonthWithPreviousYear;

    public $previousMonthWithNextYear;

    public $nextMonthWithNextYear;

    public $selectedMonthWithoutFormat;
    public $attendanceYear;
    public $previousMonthWithCurrentYear;

    public $currentMonthWithPreviousYear;
    public $nextMonthWithCurrentYear;

    public $currentMonthWithNextYear;
    public function mount()
    {
        $currentDate = now();
        $this->currentMonthForDropdown = now()->format('F'); // Current month (e.g., September)
        $this->previousMonth = now()->subMonth(1)->format('F'); // Previous month
        $this->nextMonth = now()->addMonth(1)->format('F'); // Next month
        $this->currentYear = $currentDate->year;
        $this->selectedMonth=now()->format('F');
        $this->selectedMonthWithoutFormat=now()->format('n');
        
    }
    
    public function updateselectedMonth()
    {
        $selected = explode(' ', $this->selectedMonth);
    
        // Update attendanceMonth and attendanceYear
        if (count($selected) === 2) {
            $this->attendanceMonth = $selected[0];  // The month part
            $this->attendanceYear = $selected[1];   // The year part
            
        }
    
        // Debug output to check if both month and year are updated correctly
   
    }
    public function searchfilter()
    {
        $searching = 1;
        $currentDate = now()->toDateString();
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->get();
        $nameFilter = $this->search;
        $filteredEmployees = $employees->filter(function ($employee) use ($nameFilter) {
            return stripos($employee->first_name, $nameFilter) !== false ||
                stripos($employee->last_name, $nameFilter) !== false ||
                stripos($employee->emp_id, $nameFilter) !== false ||
                stripos($employee->job_role, $nameFilter) !== false ||
                stripos($employee->job_location, $nameFilter) !== false ||
                stripos($employee->state, $nameFilter) !== false;
        });

        if ($filteredEmployees->isEmpty()) {
            $this->notFound = true; 
        } else {
            $this->notFound = false;
        } 
        
    }
    public function downloadExcel()
{
    $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
    $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name', 'shift_type')->get();
    $currentMonth = $this->selectedMonth;
    $currentMonth1 = DateTime::createFromFormat('F', $currentMonth)->format('n');
    $currentYear = date('Y');

    
    $holiday = HolidayCalendar::where('month', $currentMonth)
        ->where('year', $currentYear)
        ->pluck('date')
        ->toArray();

    $count_of_holiday = empty($holiday) ? 0 : count($holiday);
    $approvedLeaveRequests1 = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
    ->where('leave_applications.leave_status', 3)
    ->whereIn('leave_applications.emp_id', $employees->pluck('emp_id')->toArray())
    ->whereDate('from_date', '>=', "$currentYear-$currentMonth1-01")
    ->whereDate('to_date', '<=', "$currentYear-$currentMonth1-31")
    ->get(['leave_applications.emp_id', 'leave_applications.from_date', 'leave_applications.to_date'])
    ->flatMap(function ($leaveRequest) {
        $fromDate = Carbon::parse($leaveRequest->from_date);
        $toDate = Carbon::parse($leaveRequest->to_date);
        $dates = [];
        for ($i = 0; $i <= $fromDate->diffInDays($toDate); $i++) {
            $dates[] = $fromDate->copy()->addDays($i)->toDateString();
        }
        return [$leaveRequest->emp_id => $dates]; 
    });

    $leaveDates = $approvedLeaveRequests1->toArray(); 
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth1, $currentYear);

    $data = [['List of Employees for ' . $currentMonth . ' ' . $currentYear]];
    $headers = ['Employee ID', 'Name', 'No. of Regular Days'];
    $leaveDates = [];
    foreach ($approvedLeaveRequests1 as $emp_id => $datesCollection) { 
        foreach ($datesCollection as $date) {  
            $leaveDates[$emp_id][] = $date;  // Store dates for each employee
        }
    }
    for ($i = 1; $i <= $daysInMonth; $i++) {
        $date = new DateTime("$currentYear-$currentMonth1-$i");
        $headers[] = $i . $date->format('D'); 
    }
    $data[] = $headers;

    foreach ($employees as $employee) {
        $rowData = [$employee->emp_id, ucwords(strtolower($employee->first_name)) . ' ' . ucwords(strtolower($employee->last_name))];
        $dateCount = 0;

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $currentDate = "$currentYear-" . str_pad($currentMonth1, 2, '0', STR_PAD_LEFT) . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            if (date('N', strtotime($currentDate)) >= 6) {
                $dateCount++;
            }
        }
        $rowData[] = $daysInMonth - $dateCount - $count_of_holiday;

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $currentDate = "$currentYear-" . str_pad($currentMonth1, 2, '0', STR_PAD_LEFT) . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            $differentShift = $this->isEmployeeAssignedDifferentShift($currentDate, $employee->emp_id)['shiftType'];

            if (date('N', strtotime($currentDate)) >= 6) {
                $rowData[] = 'O';
            } elseif (in_array($currentDate, $holiday)) {
                $rowData[] = 'H';
            } elseif (isset($leaveDates[$employee->emp_id]) && in_array($currentDate, $leaveDates[$employee->emp_id])) {
                $rowData[] = 'L'; // Leave
            } elseif (!empty($differentShift)) {
                $rowData[] = $differentShift;
            } else {
                $rowData[] = $employee->shift_type;
            }
        }
        $data[] = $rowData;
    }

    return Excel::download(new ShiftRosterExport($data), 'Shift_Roaster_Data.xlsx');
}
    public function isEmployeeAssignedDifferentShift($date, $empId)
    {
        $shiftExists = false;
        $shiftType = null;

            $employee = EmployeeDetails::where('emp_id', $empId)->first();

            // Return array with default values if employee not found or no shift entries assigned
            if (!$employee || empty($employee->shift_entries)) {
                return [
                    'shiftExists' => $shiftExists,
                    'shiftType' => $shiftType,
                ];
            }

            $shiftEntries = json_decode($employee->shift_entries, true);
            $date = Carbon::parse($date);

            foreach ($shiftEntries as $shift) {
                $fromDate = Carbon::parse($shift['from_date']);
                $toDate = Carbon::parse($shift['to_date']);

                if ($date->between($fromDate, $toDate)) {
                    $shiftExists = true;
                    $shiftType = $shift['shift_type'];
                } elseif ($date->isSameDay($fromDate) || $date->isSameDay($toDate)) {
                    $shiftExists = true;
                    $shiftType = $shift['shift_type'];
                }
            }

            return [
                'shiftExists' => $shiftExists,
                'shiftType' => $shiftType,
            ];
}
    public function render()
    {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $currentMonth=$this->selectedMonth;
        $currentMonthWithoutFormat=$this->selectedMonthWithoutFormat;
        $currentYear = date('Y');  
        $year = $currentYear;
        $employees=EmployeeDetails::where('manager_id',$loggedInEmpId)->where('employee_status','active')->select('emp_id', 'first_name', 'last_name','job_role','job_location','shift_type')->get();
        $employeeIds = $employees->pluck('emp_id')->toArray();
        $this->holiday = HolidayCalendar::where('month',$currentMonth)
        ->where('year', $year)
        ->get('date');
        $approvedLeaveRequests1 = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
            ->join('status_types', 'leave_applications.leave_status', '=', 'status_types.status_code') // Join with status_type table to get status_name
            ->where('leave_applications.leave_status', 3) // Filter by leave_status = 3 instead of status = 'approved'
            ->whereIn('leave_applications.emp_id', $employeeIds)
            ->whereDate('from_date', '>=', $year . '-' . $currentMonthWithoutFormat . '-01') // Dynamically set year and month
            ->whereDate('to_date', '<=', $year . '-' . $currentMonthWithoutFormat . '-31') // Dynamically set year and month
            ->get(['leave_applications.*', 'employee_details.emp_id', 'employee_details.first_name', 'employee_details.last_name', 'status_types.status_name']) // Retrieve status_name from status_type
            ->mapWithKeys(function ($leaveRequest) {
                $fromDate = \Carbon\Carbon::parse($leaveRequest->from_date);
                $toDate = \Carbon\Carbon::parse($leaveRequest->to_date);
                $number_of_days = $fromDate->diffInDays($toDate) + 1;
                $dates = [];
                for ($i = 0; $i < $number_of_days; $i++) {
                    $dates[] = $fromDate->copy()->addDays($i)->toDateString();
                }
                return [
                    $leaveRequest->emp_id => [
                        'emp_id' => $leaveRequest->emp_id,
                        'dates' => $dates,
                        'status_name' => $leaveRequest->status_name, // Include status_name in the output
                    ],
                ];
            });
 
            $leaveDates = [];
            foreach ($approvedLeaveRequests1 as $emp_id => $leaveRequest) {
                foreach ($leaveRequest['dates'] as $date) {
                    $leaveDates[$emp_id][] = $date;
                }
            }
        $count_of_holiday=count($this->holiday);
        if($this->searching==1)
        {
                $nameFilter = $this->search; // Assuming $this->search contains the name filter
                $filteredEmployees = $employees->filter(function ($employee) use ($nameFilter) {
                    return stripos($employee->first_name, $nameFilter) !== false ||
                        stripos($employee->last_name, $nameFilter) !== false ||
                        stripos($employee->emp_id, $nameFilter) !== false||
                        stripos($employee->job_role, $nameFilter) !== false||
                        stripos($employee->job_location, $nameFilter) !== false;
                });

                if ($filteredEmployees->isEmpty()) {
                    $this->notFound = true; // Set a flag indicating that the name was not found
                } else {
                    $this->notFound = false;
                }
        }
        else
        {
            $filteredEmployees=$employees;
        }
        return view('livewire.shift-roaster',['Employees'=>$filteredEmployees,'Holiday'=> $this->holiday,'CountOfHoliday'=>$count_of_holiday,'Month'=>$currentMonth,'ApprovedLeaveRequests1'=>$approvedLeaveRequests1]);
    }
}
