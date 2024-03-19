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

class AttendenceMasterDataNew extends Component
{
    public $currentMonth;

    public $flag=0;
    public $searching=1;
    public  $holiday;
    public $notFound;


  
    public $search;
    public $filteredEmployees;
    public $daysInMonth;
 
    public $results=[];
    public $distinctDatesMap;

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
     
 
    
  
  
  

 
  $currentMonth = 12;
  $currentYear = 2023;
  
  // Total number of days in the current month
  $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
  
  // Your data to be exported to Excel
  $data = [ ['List of Employees for Dec2023' ],
      ['Employee ID', 'Name','No. of Present'],
 
  ];
  for ($i = 1; $i <= $daysInMonth; $i++) {
    $data[1][] = $i;
}



$employeeIds = $employees->pluck('emp_id');
  $distinctDatesMapCount = SwipeRecord::whereIn('swipe_records.emp_id', $employeeIds)
  ->whereMonth('swipe_records.created_at', 12) // December
  ->whereRaw('DAYOFWEEK(swipe_records.created_at) NOT IN (1, 7)') // Exclude Sunday (1) and Saturday (7)
  ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
  ->selectRaw('swipe_records.emp_id, COUNT(DISTINCT DATE(swipe_records.created_at)) as date_count, employee_details.first_name, employee_details.last_name')
  ->groupBy('swipe_records.emp_id', 'employee_details.first_name', 'employee_details.last_name')
  ->get()
  ->keyBy('emp_id')
  ->toArray();
  
$distinctDatesMap = SwipeRecord::whereIn('emp_id', $employeeIds)
->whereMonth('created_at', 12) // December
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
    ->whereDate('from_date', '>=', '2023-12-01') // Start of the current month
    ->whereDate('to_date', '<=','2023-12-31') // End of the current month
    ->get(['leave_applications.*', 'employee_details.emp_id','employee_details.first_name', 'employee_details.last_name'])
    ->map(function ($leaveRequest) {
        // Calculate the number of days between from_date and to_date
        $fromDate = \Carbon\Carbon::parse($leaveRequest->from_date);
        $toDate = \Carbon\Carbon::parse($leaveRequest->to_date);
    
        $leaveRequest->number_of_days = $fromDate->diffInDays($toDate) + 1; // Add 1 to include both start and end dates
    
        return $leaveRequest;
    });
   
    
    
    // Remove duplicates and re-index the array

  
$year = 2023;
$holiday = HolidayCalendar::where('month', 'December')
    ->where('year', $year)
    ->pluck('date')
    ->toArray();
foreach ($employees as $employee) {
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
        $currentDate = $currentYear . '-' . $currentMonth . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);

        // Check if the day is Saturday or Sunday
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
                        if ($currentDate >= $fromDate->format('Y-m-d') && $currentDate <= $toDate->format('Y-m-d')) {
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

    // Add the row to the $data array
    $data[] = $rowData;
}

 // Create a temporary file
  $tempFilePath = storage_path('app/public/' . Str::random(16) . '.csv');

  // Open the file for writing
  $file = fopen($tempFilePath, 'w');

  // Write the data to the file
  foreach ($data as $row) {
      fputcsv($file, $row);
  }

  // Close the file
  fclose($file);

  // Set the response headers for download
  $headers = [
      'Content-Type' => 'text/csv',
      'Content-Disposition' => 'attachment; filename="Attendance_Report"',
  ];

  // Return the response with the file and headers
  return response()->stream(
      function () use ($tempFilePath) {
          readfile($tempFilePath);
          // Delete the file after it has been streamed
          File::delete($tempFilePath);
      },
      200,
      $headers
  );
        
    }
    public function render()
    {
        $currentMonth1 = date('n');
        $firstDayOfCurrentMonth = strtotime(date('Y-m-01')); // First day of the current month
        $previousMonth = strtotime('-1 month', $firstDayOfCurrentMonth); // First day of the previous month

        $previousMonthName = date('F', $previousMonth); 
       
        $currentYear1 = date('Y');
        $year = 2023;
        $this->holiday = HolidayCalendar::where('month', 'December')
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
    ->whereDate('from_date', '>=', '2023-12-01')
    ->whereDate('to_date', '<=', '2023-12-31')
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
 

        return view('livewire.attendence-master-data-new',['Employees'=>$filteredEmployees,'EmployeesCount'=>$employeescount,'DistinctDatesMap'=>$distinctDatesMap,'DistinctDatesMapCount'=>$distinctDatesMapCount,'Holiday'=> $this->holiday,'ApprovedLeaveRequests1'=>$approvedLeaveRequests1 ]);
    }
}
