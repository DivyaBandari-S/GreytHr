<?php

// File Name                       : AttendanceMasterDataNew.php
// Description                     : This file contains the implementation of the employees who are on leave,absent,present in tabular format 
// Creator                         : Pranita Priyadarshi
// Email                           : priyadarshipranita72@gmail.com
// Organization                    : PayG.
// Date                            : 2023-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : LeaveRequest,EmployeeDetails,HolidayCalendar,SwipeRecord
namespace App\Livewire;

use App\Helpers\FlashMessageHelper;
use Illuminate\Support\Facades\Auth;
use App\Models\EmployeeDetails;
use App\Models\HolidayCalendar;
use App\Models\SwipeRecord;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelWriter;

class AttendenceMasterDataNew extends Component
{
    public $currentMonth;

    public $flag=0;
    public $searching=1;
    public  $holiday;

    public $selectedYear; 
    public $notFound;


  
    public $search;
    public $filteredEmployees;
    public $daysInMonth;
 
    public $results=[];
    public $distinctDatesMap;

    public $currentYear;

    public $attendanceYear;

    public $todaymonth;
    public $todayyear;


    public $legend=false;

    public $todaymonthinformat;
    public function mount()
    {
        $this->todayyear = date('Y');
        $this->todaymonth=date('n');
        $this->todaymonthinformat=date('F');
        $this->selectedYear=date('Y');
    }
    public function openlegend()
    {
        $this->legend=!$this->legend;
    }
    //This method will update the selected year from the dropdown
    public function updateselectedYear()
    {
        try {
            $this->attendanceYear = $this->selectedYear;
        } catch (\Exception $e) {
            Log::error('Error updating selected year: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while updating the selected year. Please try again.');
        }
        
    }
   
    //This method will retrieve the information about the employee that we are searching for 
    public function searchfilter()
    {
                try 
                {
                    $searching = 1;
                    $currentDate = now()->toDateString();
                    $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
                    $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->where('employee_status','active')->get();
                   
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
                } catch (\Exception $e) {
                    Log::error('Error filtering search results: ' . $e->getMessage());
                    FlashMessageHelper::flashError('An error occurred while performing the search. Please try again.');
    
                }   
       
      
    }
    //This method will help us to know the attendance  status for the employees for the particular month and year in excel sheet
    public function downloadExcel()
{
    try {
       
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
      
        $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)
            ->select('emp_id', 'first_name', 'last_name')
            ->where('employee_status', 'active')
            ->get();
        
      
        $currentMonth = date('F');
        $currentMonth1 = date('n');
        $AttendanceYear = $this->selectedYear;
        $todaysDate = date('Y-m-d');
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth1, $AttendanceYear);

      
        $data = [['List of Employees for ' . $currentMonth . ' ' . $AttendanceYear],
                 ['Employee ID', 'Name', 'No. of Present']];

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = new DateTime("$AttendanceYear-$currentMonth1-$i");
            $dayName = $date->format('D');
            $data[1][] = $i . $dayName;
        }

        $employeeIds = $employees->pluck('emp_id');
      
        $distinctDatesMapCount = SwipeRecord::whereIn('swipe_records.emp_id', $employeeIds)
            ->whereMonth('swipe_records.created_at', $currentMonth1)
            ->whereYear('swipe_records.created_at', $AttendanceYear)
            ->whereDate('swipe_records.created_at', '<', Carbon::today())
            ->whereRaw('DAYOFWEEK(swipe_records.created_at) NOT IN (1, 7)')
            ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
            ->selectRaw('swipe_records.emp_id, COUNT(DISTINCT DATE(swipe_records.created_at)) as date_count, employee_details.first_name, employee_details.last_name')
            ->groupBy('swipe_records.emp_id', 'employee_details.first_name', 'employee_details.last_name')
            ->get()
            ->keyBy('emp_id')
            ->toArray();
        

       
        $distinctDatesMap = SwipeRecord::whereIn('emp_id', $employeeIds)
            ->whereMonth('created_at', $currentMonth1)
            ->whereYear('created_at', $this->selectedYear)
            ->whereDate('swipe_records.created_at', '<', Carbon::today())
            ->selectRaw('DISTINCT emp_id, DATE(created_at) as distinct_date')
            ->get()
            ->groupBy('emp_id')
            ->map(function ($dates) {
                return $dates->pluck('distinct_date')->toArray();
            })
            ->toArray();

       
        $approvedLeaveRequests = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
            ->where('leave_applications.leave_status', 2)
            ->whereIn('leave_applications.emp_id', $employeeIds)
            ->whereDate('from_date', '>=', "$AttendanceYear-$currentMonth1-01")
            ->whereDate('to_date', '<=', "$AttendanceYear-$currentMonth1-$daysInMonth")
            ->get();

       
        $holiday = HolidayCalendar::where('month', $currentMonth)
            ->where('year', $AttendanceYear)
            ->pluck('date')
            ->toArray();

       
        foreach ($employees as $employee) {
            $rowData = [$employee['emp_id'], ucwords(strtolower($employee['first_name'])) . ' ' . ucwords(strtolower($employee['last_name']))];

            
            $dateCount = $distinctDatesMapCount[$employee['emp_id']]['date_count'] ?? 0;
            Log::debug("Date count for employee {$employee['emp_id']}: $dateCount");
            for ($j = 1; $j <= $daysInMonth; $j++) {
            foreach ($distinctDatesMap as $empId => $dates) {
                $currentDate = "$AttendanceYear-" . str_pad($currentMonth1, 2, '0', STR_PAD_LEFT) . '-' . str_pad($j, 2, '0', STR_PAD_LEFT);
                if ($employee['emp_id'] == $empId && in_array($currentDate, $dates)) {
                    $inRecord=SwipeRecord::whereDate('created_at',$currentDate)->where('in_or_out','IN')->where('emp_id',$employee['emp_id'])->first();
                    $outRecord=SwipeRecord::whereDate('created_at',$currentDate)->where('in_or_out','OUT')->where('emp_id',$employee['emp_id'])->orderByDesc('created_at')->first();
                 
                    if(($outRecord==null||$inRecord==null)||($inRecord==null)||($outRecord==null))
                    {
                       
                        $dateCount-=1;
                    }
                    else
                    {
                        $formattedInTime = Carbon::parse($inRecord->swipe_time)->format('H:i');
                        $formattedOutTime = Carbon::parse($outRecord->swipe_time)->format('H:i');
                        $inTime = Carbon::parse($inRecord->swipe_time);
                        $outTime = Carbon::parse($outRecord->swipe_time);
                        $differenceInMinutes = $inTime->diffInMinutes($outTime);
                        if($differenceInMinutes <= 270)
                        {
                            $dateCount-=0.5;
                            
                        }
                        
                        
                    }
                   
                    
                    break;
                }
            }
            }
            $rowData[] = $dateCount;

            for ($i = 1; $i <= $daysInMonth; $i++) {
                $currentDate = "$AttendanceYear-" . str_pad($currentMonth1, 2, '0', STR_PAD_LEFT) . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);

                if ($currentDate <= $todaysDate) {
                    if (in_array($currentDate, $holiday)) {
                        $rowData[] = 'H';
                    } elseif (date('N', strtotime($currentDate)) >= 6) {
                        $rowData[] = 'O';
                    }  else {
                        $dateExists = false;
                        $halfdateExists=false;
                        $leaveExists = false;
                       
                        foreach ($distinctDatesMap as $empId => $dates) {
                            if ($employee['emp_id'] == $empId && in_array($currentDate, $dates)) {
                                $inRecord=SwipeRecord::whereDate('created_at',$currentDate)->where('in_or_out','IN')->where('emp_id',$employee['emp_id'])->first();
                                $outRecord=SwipeRecord::whereDate('created_at',$currentDate)->where('in_or_out','OUT')->where('emp_id',$employee['emp_id'])->orderByDesc('created_at')->first();
                             
                                if(($outRecord==null||$inRecord==null)||($inRecord==null)||($outRecord==null))
                                {
                                    $dateExists=false;
                                    $dateCount-=1;
                                }
                                else
                                {
                                    $formattedInTime = Carbon::parse($inRecord->swipe_time)->format('H:i');
                                    $formattedOutTime = Carbon::parse($outRecord->swipe_time)->format('H:i');
                                    $inTime = Carbon::parse($inRecord->swipe_time);
                                    $outTime = Carbon::parse($outRecord->swipe_time);
                                    $differenceInMinutes = $inTime->diffInMinutes($outTime);
                                    if($differenceInMinutes <= 270)
                                    {
                                        $halfdateExists=true;
                                        
                                    }
                                    elseif($differenceInMinutes > 270)
                                    {
                                        $dateExists=true;
                                    }
                                    
                                }
                               
                                
                                break;
                            }
                        }
                        foreach ($approvedLeaveRequests as $leaveRequest) {
                            if ($leaveRequest->emp_id === $employee['emp_id']) {
                                $fromDate = Carbon::parse($leaveRequest->from_date);
                                $toDate = Carbon::parse($leaveRequest->to_date);
                                if ($currentDate >= $fromDate->format('Y-m-d') && $currentDate <= $toDate->format('Y-m-d')) {
                                    $leaveExists = true;
                                    $leaveType = LeaveRequest::where('emp_id', $employee['emp_id'])
                                                ->where('from_date', '>=', $currentDate)
                                                ->where('to_date', '<=', $currentDate)
                                                ->value('leave_type');
                                                $leaveAbbreviation = match ($leaveType) {
                                                    'Loss of Pay' => 'LOP',
                                                    'Casual Leave' => 'CL',
                                                    'Sick Leave' => 'SL',
                                                    'Marriage Leave' => 'ML',
                                                    'Maternity Leave' => 'MTL',
                                                    'Paternity Leave' => 'PL',
                                                    default => 'L', // Optional: handle cases where leave_type doesn't match
                                                };            
                                    break;
                                }
                            }
                        }
                        if ($leaveExists) {
                            $rowData[] = 'L';
                        } 
                        elseif($halfdateExists)
                        {
                            $rowData[] = 'HP';
                        }
                        else {
                            $rowData[] = $dateExists ? 'P' : 'A'; 
                        }
                    }

                }
            }

            $data[] = $rowData;
        }

      
        $filePath = storage_path('app/Attendance_Muster_Report.xlsx');
        SimpleExcelWriter::create($filePath)->addRows($data);

       
        return response()->download($filePath, 'Attendance_Muster_Report.xlsx');
    } catch (\Exception $e) {
        Log::error('Error generating Excel report', ['error' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()]);
        FlashMessageHelper::flashError('An error occurred while generating the Excel report. Please try again.');
    }
}

    public function render()
    {
       
        $currentMonth1 = date('n');
        $currentMonth = date('F');
        $currentYear=$this->selectedYear;
        $firstDayOfCurrentMonth = strtotime(date('Y-m-01'));
        $previousMonth = strtotime('-1 month', $firstDayOfCurrentMonth); 
        $previousMonthName = date('F', $previousMonth); 
        $currentYear1 = date('Y');
        $year = $currentYear;
        $this->holiday = HolidayCalendar::where('month',$currentMonth)
            ->where('year', $year)
            ->pluck('date');
        $holidays = HolidayCalendar::where('month', $currentMonth)
            ->where('year', $this->selectedYear)
            ->pluck('date')
            ->map(function($date) {
                return Carbon::parse($date)->toDateString();
            })
            ->toArray();
            
        $daysInMonth1= cal_days_in_month(CAL_GREGORIAN, $currentMonth1, $currentYear1);
        $currentMonth = now()->format('n');
        $this->daysInMonth = now()->daysInMonth;
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $employees=EmployeeDetails::where('manager_id',$loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->get();
        $employeescount=EmployeeDetails::where('manager_id',$loggedInEmpId)->count();
        $managerId = $loggedInEmpId;
        $employees = EmployeeDetails::where('manager_id', $managerId)
        ->select('emp_id', 'first_name', 'last_name','job_role','job_location')
        ->where('employee_status','active')
        ->get();
        if($this->searching==1)
        {
                $nameFilter = $this->search; // Assuming $this->search contains the name filter
                $filteredEmployees = $employees->filter(function ($employee) use ($nameFilter) {
                    return stripos($employee->first_name, $nameFilter) !== false ||
                        stripos($employee->last_name, $nameFilter) !== false ||
                        stripos($employee->emp_id, $nameFilter) !== false||
                        stripos($employee->job_role, $nameFilter) !== false||
                        stripos($employee->job_location, $nameFilter) !== false||
                        stripos($employee->state, $nameFilter) !== false;
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
        $employeeIds = $employees->pluck('emp_id');
        $distinctDatesMap = SwipeRecord::whereIn('emp_id', $employeeIds)
            ->whereMonth('created_at', $currentMonth1) // December
            ->whereYear('created_at', $this->selectedYear) // December
            ->whereDate('swipe_records.created_at', '<', Carbon::today())
            ->selectRaw('DISTINCT emp_id, DATE(created_at) as distinct_date ')
            ->get()
            ->groupBy('emp_id')
            ->map(function ($dates) {
                return $dates->pluck('distinct_date')->toArray();
            })
            ->toArray();
        
       
            $approvedLeaveRequests1 = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
            ->join('status_types', 'leave_applications.leave_status', '=', 'status_types.status_code') // Join with status_type table to get status_name
            ->where('leave_applications.leave_status', 2) // Filter by leave_status = 3 instead of status = 'approved'
            ->whereIn('leave_applications.emp_id', $employeeIds)
            ->where('leave_applications.from_session', 'Session 1')
            ->where('leave_applications.to_session', 'Session 2')
            ->whereDate('from_date', '>=', $this->selectedYear . '-' . $currentMonth . '-01') // Dynamically set year and month
            ->whereDate('to_date', '<=', $this->selectedYear . '-' . $currentMonth . '-31') // Dynamically set year and month
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

            $approvedLeaveRequestsForSession1 = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
            ->join('status_types', 'leave_applications.leave_status', '=', 'status_types.status_code') // Join with status_type table to get status_name
            ->where('leave_applications.leave_status', 2) // Filter by leave_status = 3 instead of status = 'approved'
            ->whereIn('leave_applications.emp_id', $employeeIds)
            ->where('leave_applications.from_session', 'Session 1')
            ->where('leave_applications.to_session', 'Session 1')
            ->whereDate('from_date', '>=', $this->selectedYear . '-' . $currentMonth . '-01') // Dynamically set year and month
            ->whereDate('to_date', '<=', $this->selectedYear . '-' . $currentMonth . '-31') // Dynamically set year and month
            ->get(['leave_applications.*', 'employee_details.emp_id', 'employee_details.first_name', 'employee_details.last_name', 'status_types.status_name']) // Retrieve status_name from status_type
            ->mapWithKeys(function ($leaveRequestforSession1) {
               
        
                $fromDate = \Carbon\Carbon::parse($leaveRequestforSession1->from_date);
                $toDate = \Carbon\Carbon::parse($leaveRequestforSession1->to_date);
                $number_of_days = $fromDate->diffInDays($toDate) + 1;
        
                
        
                $dates = [];
                for ($i = 0; $i < $number_of_days; $i++) {
                    $currentDate = $fromDate->copy()->addDays($i)->toDateString();
                    $dates[] = $currentDate;
                    
                }
        
                return [
                    $leaveRequestforSession1->emp_id => [
                        'emp_id' => $leaveRequestforSession1->emp_id,
                        'dates' => $dates,
                        'status_name' => $leaveRequestforSession1->status_name, // Include status_name in the output
                    ],
                ];
            });
        
       
            $approvedLeaveRequestsForSession2 = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
            ->join('status_types', 'leave_applications.leave_status', '=', 'status_types.status_code') // Join with status_type table to get status_name
            ->where('leave_applications.leave_status', 2) // Filter by leave_status = 3 instead of status = 'approved'
            ->whereIn('leave_applications.emp_id', $employeeIds)
            ->where('leave_applications.from_session','Session 2')
            ->where('leave_applications.to_session','Session 2')
            ->whereDate('from_date', '>=', $this->selectedYear . '-' . $currentMonth . '-01') // Dynamically set year and month
            ->whereDate('to_date', '<=', $this->selectedYear . '-' . $currentMonth . '-31') // Dynamically set year and month
            ->get(['leave_applications.*', 'employee_details.emp_id', 'employee_details.first_name', 'employee_details.last_name', 'status_types.status_name']) // Retrieve status_name from status_type
            ->mapWithKeys(function ($leaveRequestforSession2) {
                $fromDate = \Carbon\Carbon::parse($leaveRequestforSession2->from_date);
                $toDate = \Carbon\Carbon::parse($leaveRequestforSession2->to_date);
                $number_of_days = $fromDate->diffInDays($toDate) + 1;
                $dates = [];
                for ($i = 0; $i < $number_of_days; $i++) {
                    $dates[] = $fromDate->copy()->addDays($i)->toDateString();
                }
                return [
                    $leaveRequestforSession2->emp_id => [
                        'emp_id' => $leaveRequestforSession2->emp_id,
                        'dates' => $dates,
                        'status_name' => $leaveRequestforSession2->status_name, // Include status_name in the output
                    ],
                ];
            }); 
          
            $leaveDatesForSession2 = [];
            foreach ($approvedLeaveRequestsForSession2 as $emp_id => $leaveRequest) {
                foreach ($leaveRequest['dates'] as $date) {
                    $leaveDatesForSession2[$emp_id][] = $date;
                }
            }
           
            $distinctDatesMapCount = SwipeRecord::whereIn('swipe_records.emp_id', $employeeIds)
            ->whereMonth('swipe_records.created_at', $currentMonth)
            ->whereYear('swipe_records.created_at', $this->selectedYear)
            ->whereDate('swipe_records.created_at', '<', Carbon::today())
            ->whereRaw('DAYOFWEEK(swipe_records.created_at) NOT IN (1, 7)') // Exclude Sunday (1) and Saturday (7)
            ->whereNotIn(DB::raw('DATE(swipe_records.created_at)'), $holidays) // Exclude holidays
            ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
            ->selectRaw('swipe_records.emp_id, COUNT(DISTINCT DATE(swipe_records.created_at)) as date_count, GROUP_CONCAT(DISTINCT DATE(swipe_records.created_at)) as created_at_dates, employee_details.first_name, employee_details.last_name')
            ->groupBy('swipe_records.emp_id', 'employee_details.first_name', 'employee_details.last_name')
            ->get()
            ->map(function ($record) use ($leaveDates) {
                $emp_id = $record->emp_id;
                $created_at_dates = explode(',', $record->created_at_dates); // Convert dates string to array
                if (isset($leaveDates[$emp_id])) {
                    $record->date_count -= count(array_intersect($created_at_dates, $leaveDates[$emp_id]));
                }
                return $record;
            })
            ->keyBy('emp_id')
            ->toArray();
            
                    
        
        
      
         

           
   
            return view('livewire.attendence-master-data-new',['Employees'=>$filteredEmployees,'EmployeesCount'=>$employeescount,'DistinctDatesMap'=>$distinctDatesMap,'DistinctDatesMapCount'=>$distinctDatesMapCount,'Holiday'=> $this->holiday,'ApprovedLeaveRequests1'=>$approvedLeaveRequests1,'ApprovedLeaveRequestsForSession1'=>$approvedLeaveRequestsForSession1,'ApprovedLeaveRequestsForSession2'=>$approvedLeaveRequestsForSession2,'SelectedYear'=>$this->selectedYear ]);
    
    }
}
