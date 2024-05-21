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
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelWriter;

class AttendenceMasterDataNew extends Component
{
    public $currentMonth;

    public $flag=0;
    public $searching=1;
    public  $holiday;

    public $selectedYear='2024'; 
    public $notFound;


  
    public $search;
    public $filteredEmployees;
    public $daysInMonth;
 
    public $results=[];
    public $distinctDatesMap;

    public $currentYear;

    public $attendanceYear;

    
    public function updateselectedYear()
    {
        // Assign the selected year to $currentYear1234567 directly
        $this->attendanceYear = $this->selectedYear;
        
    }
   
    
    public function searchfilter()
    {
        $searching = 1;
        $currentDate = now()->toDateString();
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->get();
        $nameFilter = $this->search; // Assuming $this->search contains the name filter
$filteredEmployees = $employees->filter(function ($employee) use ($nameFilter) {
    return stripos($employee->first_name, $nameFilter) !== false ||
        stripos($employee->last_name, $nameFilter) !== false ||
        stripos($employee->emp_id, $nameFilter) !== false
        ||stripos($employee->job_title, $nameFilter) !== false
        ||stripos($employee->city, $nameFilter) !== false
        ||stripos($employee->state, $nameFilter) !== false;
});

if ($filteredEmployees->isEmpty()) {
    
    $this->notFound = true; // Set a flag indicating that the name was not found
} else {
    $this->notFound = false;
}
       
       
      
    }
    public function downloadExcel()
    {
         // Your data to be exported to Excel
  // Fetch employee id and name from SwipeRecord model
  
  $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
  $employees=EmployeeDetails::where('manager_id',$loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->get();
     
 
    
  
  
  

 
  $currentMonth =  date('F');
  $currentMonth1 = date('n');
  $AttendanceYear = $this->selectedYear;
  $currentYear = date('Y');
  $todaysDate = date('Y-m-d');

  // Total number of days in the current month
  $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth1, $AttendanceYear);
  
  // Your data to be exported to Excel
  $data = [ ['List of Employees for'.$currentMonth.$AttendanceYear ],
      ['Employee ID', 'Name','No. of Present'],
 
  ];
 
   for ($i = 1; $i <= $daysInMonth; $i++) {
       $date = new DateTime("$AttendanceYear-$currentMonth1-$i");
      
    // Get the day name
       $dayName = $date->format('D');
       $data[1][] = $i.$dayName;
    }
    $employeeIds = $employees->pluck('emp_id');
    $distinctDatesMapCount = SwipeRecord::whereIn('swipe_records.emp_id', $employeeIds)
       ->whereMonth('swipe_records.created_at', $currentMonth1) // December
       ->whereYear('swipe_records.created_at',$AttendanceYear)
       ->whereRaw('DAYOFWEEK(swipe_records.created_at) NOT IN (1, 7)') // Exclude Sunday (1) and Saturday (7)
       ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
       ->selectRaw('swipe_records.emp_id, COUNT(DISTINCT DATE(swipe_records.created_at)) as date_count, employee_details.first_name, employee_details.last_name')
       ->groupBy('swipe_records.emp_id', 'employee_details.first_name', 'employee_details.last_name')
       ->get()
       ->keyBy('emp_id')
       ->toArray();
    $distinctDatesMap = SwipeRecord::whereIn('emp_id', $employeeIds)
       ->whereMonth('created_at', $currentMonth1) // December
       ->whereYear('created_at', $this->selectedYear)
       ->selectRaw('DISTINCT emp_id, DATE(created_at) as distinct_date ')
       ->get()
       ->groupBy('emp_id')
       ->map(function ($dates) {
            return $dates->pluck('distinct_date')->toArray();
        })
       ->toArray();
    $approvedLeaveRequests = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
       ->where('leave_applications.status', 'approved')
       ->whereIn('leave_applications.emp_id', $employees->pluck('emp_id'))
       ->where('employee_details.manager_id', $loggedInEmpId) // Add condition for manager's ID
       ->whereDate('from_date', '>=', $this->selectedYear . '-' . $currentMonth . '-01') // Dynamically set year and month
       ->whereDate('to_date', '<=', $this->selectedYear . '-' . $currentMonth . '-31') // Dynamically set year and month
       ->get(['leave_applications.*', 'employee_details.emp_id','employee_details.first_name', 'employee_details.last_name'])
       ->map(function ($leaveRequest) {
        // Calculate the number of days between from_date and to_date
            $fromDate = \Carbon\Carbon::parse($leaveRequest->from_date);
            $toDate = \Carbon\Carbon::parse($leaveRequest->to_date);
            $leaveRequest->number_of_days = $fromDate->diffInDays($toDate) + 1; // Add 1 to include both start and end dates
            return $leaveRequest;
        });
   $year = $currentYear; 
   $holiday = HolidayCalendar::where('month', $currentMonth)
      ->where('year',$AttendanceYear)
      ->pluck('date')
      ->toArray();
     if($AttendanceYear<$currentYear||$AttendanceYear==$currentYear)
    {
        
        foreach ($employees as $employee) 
        {
             $rowData = [$employee['emp_id'], $employee['first_name'] . ' ' . $employee['last_name']];
             if (isset($distinctDatesMapCount[$employee['emp_id']])) {
                   // If the employee ID exists in $distinctDatesMapCount, use the date count
                   $dateCount = $distinctDatesMapCount[$employee['emp_id']]['date_count'];
             } else {
                  // If the employee ID is not found in $distinctDatesMapCount, set the value as 0
                  $dateCount = 0;
             }
            // Add the date count to the row
            $rowData[] = $dateCount;
            
            for ($i = 1; $i <= $daysInMonth; $i++) {
                 
                 $currentDate = $AttendanceYear . '-' . str_pad($currentMonth1, 2, '0', STR_PAD_LEFT). '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
                 // Check if the day is Saturday or Sunday
                 if($currentDate<=$todaysDate)   
                 {
                 if (date('N', strtotime($currentDate)) == 6 || date('N', strtotime($currentDate)) == 7) {
                      $rowData[] = 'O'; // Set status as 'O' for weekends
                 } elseif (in_array($currentDate, $holiday)) {
                      $rowData[] = 'H'; // Set status as 'H' for holidays
                 }   else {   
            
                    $dateExists = false;
                    $leaveExists = false;
                    foreach ($distinctDatesMap as $empId => $dates) {
                        if ($employee['emp_id'] == $empId && in_array($currentDate, $dates)) {
                              $dateExists = true;
                              break;
                        }
                    }
                    foreach ($approvedLeaveRequests as $leaveRequest) {
                         if ($leaveRequest->emp_id === $employee['emp_id']) {
                            $fromDate = Carbon::parse($leaveRequest->from_date);
                            $toDate = Carbon::parse($leaveRequest->to_date);
                         if ($currentDate >= $fromDate->format('Y-m-d') && $currentDate <= $toDate->format('Y-m-d')) 
                           {
                              $leaveExists = true;
                              break;
                           }
                        }
                    }
                    if ($leaveExists) {
                         $rowData[] = 'L'; // Set status as 'L' for leave
                    } else {
                         $rowData[] = $dateExists ? 'P' : 'A'; // Set status as 'A' for weekdays
                    }
                 }
                
        }
    
    }

    // Add the row to the $data array
    $data[] = $rowData;
}
    }

    $filePath = storage_path('app/Attendance_Muster_Report.xlsx');
    SimpleExcelWriter::create($filePath)->addRows($data);
    return response()->download($filePath, 'Attendance_Muster_Report.xlsx');
 
        
    }
    public function render()
    {
       
        $currentMonth1 = date('n');
        $currentMonth = date('F');
        $currentYear=$this->selectedYear;
        $firstDayOfCurrentMonth = strtotime(date('Y-m-01')); // First day of the current month
        $previousMonth = strtotime('-1 month', $firstDayOfCurrentMonth); // First day of the previous month

        $previousMonthName = date('F', $previousMonth); 
       
        $currentYear1 = date('Y');
        $year = $currentYear;
        
        $this->holiday = HolidayCalendar::where('month',$currentMonth)
            ->where('year', $year)
            ->pluck('date');
        
       
        // Total number of days in the current month
         $daysInMonth1= cal_days_in_month(CAL_GREGORIAN, $currentMonth1, $currentYear1);
       
        $currentMonth = now()->format('n');
        
        $this->daysInMonth = now()->daysInMonth;
       
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $employees=EmployeeDetails::where('manager_id',$loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->get();
       
        
        $employeescount=EmployeeDetails::where('manager_id',$loggedInEmpId)->count();
      
    // You can now loop through $attendanceRecords to access the records
    
  
   
    $managerId = $loggedInEmpId;
// $swipes now contains $managerId = $loggedInEmpId;

$employees = EmployeeDetails::where('manager_id', $managerId)
->select('emp_id', 'first_name', 'last_name','job_title','city')
->get();
if($this->searching==1)
{
$nameFilter = $this->search; // Assuming $this->search contains the name filter
$filteredEmployees = $employees->filter(function ($employee) use ($nameFilter) {
    return stripos($employee->first_name, $nameFilter) !== false ||
        stripos($employee->last_name, $nameFilter) !== false ||
        stripos($employee->emp_id, $nameFilter) !== false||
        stripos($employee->job_title, $nameFilter) !== false||
        stripos($employee->city, $nameFilter) !== false||
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
    ->selectRaw('DISTINCT emp_id, DATE(created_at) as distinct_date ')
    ->get()
    ->groupBy('emp_id')
    ->map(function ($dates) {
        return $dates->pluck('distinct_date')->toArray();
    })
    ->toArray();
       
   
    

    
    $distinctDatesMapCount = SwipeRecord::whereIn('swipe_records.emp_id', $employeeIds)
    ->whereMonth('swipe_records.created_at', $currentMonth) // December
    ->whereYear('swipe_records.created_at',$this->selectedYear)
    ->whereRaw('DAYOFWEEK(swipe_records.created_at) NOT IN (1, 7)') // Exclude Sunday (1) and Saturday (7)
    ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
    ->selectRaw('swipe_records.emp_id, COUNT(DISTINCT DATE(swipe_records.created_at)) as date_count, employee_details.first_name, employee_details.last_name')
    ->groupBy('swipe_records.emp_id', 'employee_details.first_name', 'employee_details.last_name')
    ->get()
    ->keyBy('emp_id')
    ->toArray();
    
    $approvedLeaveRequests = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
    ->where('leave_applications.status', 'approved')
    ->whereIn('leave_applications.emp_id', $employees->pluck('emp_id'))
    ->where('employee_details.manager_id', $managerId) // Add condition for manager's ID
    ->whereDate('from_date', '>=', '2023-12-01') // Start of the current month
    ->whereDate('to_date', '<=','2023-12-31') // End of the current month
    ->get(['leave_applications.*', 'employee_details.first_name', 'employee_details.last_name'])
    ->map(function ($leaveRequest) {
        // Calculate the number of days between from_date and to_date
        $fromDate = \Carbon\Carbon::parse($leaveRequest->from_date);
        $toDate = \Carbon\Carbon::parse($leaveRequest->to_date);
    
        $leaveRequest->number_of_days = $fromDate->diffInDays($toDate) + 1; // Add 1 to include both start and end dates
    
        return $leaveRequest;
    });
    
    $approvedLeaveRequests1 = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
    ->where('leave_applications.status', 'approved')
    ->whereIn('leave_applications.emp_id', $employeeIds)
    ->whereDate('from_date', '>=', $this->selectedYear . '-' . $currentMonth . '-01') // Dynamically set year and month
    ->whereDate('to_date', '<=', $this->selectedYear . '-' . $currentMonth . '-31') // Dynamically set year and month
    ->get(['leave_applications.*', 'employee_details.emp_id', 'employee_details.first_name', 'employee_details.last_name'])
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
            ],
        ];
    }); 
   
 
// Merge the two collections

// $presentEmployees now contains the list of employees present for the current month
 

        return view('livewire.attendence-master-data-new',['Employees'=>$filteredEmployees,'EmployeesCount'=>$employeescount,'DistinctDatesMap'=>$distinctDatesMap,'DistinctDatesMapCount'=>$distinctDatesMapCount,'Holiday'=> $this->holiday,'ApprovedLeaveRequests1'=>$approvedLeaveRequests1,'SelectedYear'=>$this->selectedYear ]);
    }
}
