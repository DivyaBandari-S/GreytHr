<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\HolidayCalendar;
use App\Models\LeaveRequest;
use App\Models\SwipeRecord;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelWriter;

class AttendanceMusterReport extends Component
{
    public $employees;

    public $formattedInTime;

    public $formattedOutTime;
    public $fromDate;

    public $toDate;
    public $i = 0;
    public $showAttendanceMusterReportDialog = true;

    public $excessHrsMinutes;

    public $formattedWorkHrsMinutes;
    public  $holiday = false;
    public $loggedInEmpId;
    public $selectedEmployees = [];

    protected $listeners = ['employeeSelected'];
    public function mount()
    {
        $this->loggedInEmpId = Auth::guard('emp')->user()->emp_id;

        // $this->currentDate = now()->toDateString();

    }
    public function updatefromDate()
    {
        $this->fromDate = $this->fromDate;
    }
    public function updatetoDate()
    {
        $this->toDate = $this->toDate;
    }

    public function employeeSelected($empId)
    {
        if (in_array($empId, $this->selectedEmployees)) {
            $this->selectedEmployees = array_diff($this->selectedEmployees, [$empId]);
        } else {
            $this->selectedEmployees[] = $empId;
        }
    }
    public function timeToMinutes($time)
    {
        list($hours, $minutes) = explode(':', $time);
        return ($hours * 60) + $minutes;
    }
    public function downloadAttendanceMusterReportInExcel()
    { 
           if(empty($this->selectedEmployees))
           {
             return redirect()->back()->with('error', 'Select at least one employee detail');
           }
           else
           {
            if ($this->fromDate && $this->toDate) {
                $fromDate = Carbon::parse($this->fromDate);
                $toDate = Carbon::parse($this->toDate);
                $data = [
                    ['List of Attendance Muster Report from' . \Carbon\Carbon::parse($this->fromDate)->format('jS F Y') . 'to' . \Carbon\Carbon::parse($this->toDate)->format('jS F Y')],
                    [
                        'SNO', 'Name',    'Employee  No',    'Date of Joining',    'Manager No',    'Manager Name', 'Attendance Date',    'Day',    'Session1', 'Session2', 'In Time  [Asia/Kolkata]',    'Out Time  [Asia/Kolkata] ', 'Shift Name', 'Shift In Time',    'Shift Out Time', 'Late In Hrs', 'Early Out Hrs', 'Work Hours', 'Excess Hours',    'Total Work Hours'
                    ]
                ];
                $sno = 1;
                $employees1 = EmployeeDetails::where('manager_id', $this->loggedInEmpId)->get();
                $employees6 = EmployeeDetails::where('manager_id', $this->loggedInEmpId)->pluck('emp_id');
     
                for ($date = $fromDate; $date->lte($toDate); $date->addDay()) {
                    $attendanceDate = $date->toDateString();
                    $this->holiday = HolidayCalendar::where('date', $attendanceDate)
                        ->exists();
                    $day = $date->format('l'); // Get day of the week
                    $approvedLeaveRequests = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
                        ->where('leave_applications.status', 'approved')
                        ->whereIn('leave_applications.emp_id', $employees1->pluck('emp_id'))
                        ->get(['leave_applications.*', 'employee_details.first_name', 'employee_details.last_name'])
                        ->map(function ($leaveRequest) {
     
                            $fromDate = Carbon::parse($leaveRequest->from_date);
                            $toDate = Carbon::parse($leaveRequest->to_date);
     
                            $leaveRequest->number_of_days = $fromDate->diffInDays($toDate) + 1;
     
                            return $leaveRequest;
                        });
     
                    $distinctDatesMap = SwipeRecord::whereIn('emp_id', $employees6)
                        ->selectRaw('emp_id, DATE(created_at) as distinct_date')
                        ->distinct()
                        ->get()
                        ->groupBy('emp_id')
                        ->map(function ($dates) {
                            return $dates->pluck('distinct_date')->toArray();
                        })
                        ->toArray();
     
     
     
                    // You need to replace the below dummy data with actual data retrieval logic
                    $employees3 = EmployeeDetails::where('manager_id', $this->loggedInEmpId)->get();
                    $employees2 = EmployeeDetails::whereIn('emp_id', $this->selectedEmployees)->get();
                    $manager = EmployeeDetails::where('emp_id', $this->loggedInEmpId)->first(['first_name', 'last_name']);
                    $manager_name = ucwords(strtolower($manager->first_name)) . ' ' . ucwords(strtolower($manager->last_name));
                    foreach ($employees2 as $emp) {
                        $swiperecordin = SwipeRecord::where('emp_id', $emp->emp_id)->whereDate('created_at', $attendanceDate)->where('in_or_out', 'IN')->first();
                        $swiperecordout = SwipeRecord::where('emp_id', $emp->emp_id)->whereDate('created_at', $attendanceDate)->where('in_or_out', 'OUT')->first();
                        $status1 = 'A';
                        $status2 = 'A';
                        $inTime = 'NA';
                        $outTime = 'NA';
                        $lateInHrs = '00:00';
                        $earlyOutHrs = '00:00';
                        $excessHrs = '00:00';
                        $totalWorkHrs = '00:00';
                        $formattedWorkHrs = '00:00';
                        $result = '';
                        if ($day == 'Saturday' || $day == 'Sunday') {
                            $status1 = $status2 = 'Off';
                        } elseif ($this->holiday == true) {
                            $status1 = $status2 = 'H';
                        } else {
                            foreach ($distinctDatesMap as $empId => $dates) {
                                if ($emp['emp_id'] == $empId && in_array($attendanceDate, $dates)) {
                                    $status1 = $status2 = 'P';
                                    $inTime = $swiperecordin->swipe_time;
                                    if ($swiperecordout == null) {
                                        $outTime = $inTime;
                                    } else {
                                        $outTime = $swiperecordout->swipe_time;
                                    }
     
                                    break;
                                }
                            }
                            if ($inTime == '10:00' || $inTime == 'NA') {
                                $lateInHrs = '00:00';
                            } else {
                                $time = DateTime::createFromFormat('H:i:s', $inTime);
                                if ($time === false) {
                                    $time = DateTime::createFromFormat('H:i', $inTime);
                                }
                                if ($time !== false) {
                                    // Format the time to 'H:i'
                                    $formattedTime = $time->format('H:i');
     
     
                                    // Define the base time
                                    $baseTime = DateTime::createFromFormat('H:i', '10:00');
     
                                    if ($baseTime !== false) {
                                        // Calculate the difference between inTime and baseTime
                                        $difference = $time->diff($baseTime);
                                        $formattedDifference = $difference->format('%H:%I');
                                    }
                                }
     
                                // Calculate the difference
     
     
                                // Format the difference
                                $lateInHrs = $formattedDifference;
                            }
                            if ($outTime == '19:00' || $inTime == 'NA') {
                                $earlyOutHrs = '00:00';
                            } else {
                                $time1 = DateTime::createFromFormat('H:i:s', $outTime);
                                $baseTime1 = DateTime::createFromFormat('H:i:s', '19:00:00');
                                if ($time1 === false) {
                                    $time1 = DateTime::createFromFormat('H:i', $outTime);
                                }
                                if ($baseTime1 === false) {
                                    $baseTime1 = DateTime::createFromFormat('H:i', '19:00');
                                }
                                if ($time1 < $baseTime1) {
                                    $difference1 = $baseTime1->diff($time1);
                                    $formattedDifference1 = $difference1->format('%H:%I');
                                } else {
                                    $formattedDifference1 = '00:00';
                                }
                                // Format the difference
                                $earlyOutHrs = $formattedDifference1;
                            }
                            if ($inTime == $outTime || ($status1 == 'O' || $status1 == 'H')) {
                                $formattedWorkHrs = '00:00';
                            } else {
                                $o1 = DateTime::createFromFormat('H:i', $outTime);
                                $i1 = DateTime::createFromFormat('H:i', $inTime);
                                if ($o1 !== false && $i1 !== false) {
                                    // Calculate the difference between outTime and inTime
                                    $workHrs = $o1->diff($i1);
                                    $formattedWorkHrs = $workHrs->format('%H:%I');
     
                                    // Display the result
     
                                }
                            }
                            // $status1 = $status2 = $dateExists?$status1=$status2='P':$status1=$status2='A';
                            if ($outTime > '19:00' && $status1 == 'P' && $status2 == 'P') {
                                $time2 = DateTime::createFromFormat('H:i:s', $outTime);
                                if ($time2 === false) {
                                    $time2 = DateTime::createFromFormat('H:i', $outTime);
                                }
                                $baseTime2 = DateTime::createFromFormat('H:i', '19:00');
     
                                if ($baseTime2 !== false) {
                                    // Calculate the difference between inTime and baseTime
                                    $difference2 = $baseTime2->diff($time2);
                                    $formattedDifference2 = $difference2->format('%H:%I');
                                }
                                $excessHrs = $formattedDifference2;
                            }
                            if ($excessHrs != '00:00') {
                                $this->excessHrsMinutes = $this->timeToMinutes($excessHrs);
                            }
                            if ($formattedWorkHrs != '00:00') {
                                $this->formattedWorkHrsMinutes = $this->timeToMinutes($formattedWorkHrs);
                            }
                            if ($excessHrs != '00:00' || $formattedWorkHrs != '00:00') {
                                $totalMinutes = $this->excessHrsMinutes + $this->formattedWorkHrsMinutes;
                                $totalHours = floor($totalMinutes / 60);
                                $totalMinutes = $totalMinutes % 60;
                                $result = sprintf('%02d:%02d', $totalHours, $totalMinutes);
                                $totalWorkHrs = $result;
                            }
                        }
     
                        $data[] = [
                            $sno++,
                            ucwords(strtolower($emp->first_name)) . ' ' . ucwords(strtolower($emp->last_name)),
                            $emp->emp_id,
                            \Carbon\Carbon::parse($emp->hire_date)->format('jS F Y'),
                            $emp->manager_id,
                            $manager_name,
                            \Carbon\Carbon::parse($attendanceDate)->format('jS F Y'),
                            $day,
                            $status1, // Replace with actual session data
                            $status2, // Replace with actual session data
                            $inTime, // Replace with actual in time
                            $outTime, // Replace with actual out time
                            '10:00 Am To 07:00 Pm', // Replace with actual shift name
                            '10 : 00', // Replace with actual shift in time
                            '19 : 00', // Replace with actual shift out time
                            $lateInHrs, // Replace with actual late in hours
                            $earlyOutHrs, // Replace with actual early out hours
                            $formattedWorkHrs, // Replace with actual work hours
                            $excessHrs, // Replace with actual excess hours
                            $totalWorkHrs // Replace with actual total work hours
                        ];
                    }
                    $this->holiday = false;
                }
            } else {
                $data = [
                    ['List of Attendance Muster Report from'],
                    [
                        'SNO', 'Name',    'Employee  No',    'Date of Joining',    'Manager No',    'Manager Name', 'Attendance Date',    'Day',    'Session1', 'Status',    'Session2', 'Status', 'In Time  [Asia/Kolkata]',    'Out Time  [Asia/Kolkata]  ', 'Shift Name', 'Shift In Time',    'Shift Out Time', 'Late In Hrs', 'Early Out Hrs', 'Work Hours', 'Excess Hours',    'Total Work Hours'
                    ]
                ];
            }
     
            $filePath = storage_path('app/attendance_muster_report.xlsx');
            SimpleExcelWriter::create($filePath)->addRows($data);
            return response()->download($filePath, 'attendance_muster_report.xlsx');
 
    
           }
    }

    public function render()
    {
        $this->employees = EmployeeDetails::where('manager_id', $this->loggedInEmpId)->get();
        return view('livewire.attendance-muster-report');
    }
}
