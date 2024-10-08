<?php
/*
 * * File Name                       : EmployeeSwipesData.php
 * * Description                     : This file contains the implementation of all the employees who swiped in today and we can get the swipe record of the employees before todays date 
 * * Creator                         : Pranita Priyadarshi
 * * Email                           : priyadarshipranita72@gmail.com
 * * Organization                    : PayG.
 * * Date                            : 2023-12-07
 * * Framework                       : Laravel (10.10 Version)
 * * Programming Language            : PHP (8.1 Version)
 * * Database                        : MySQL
 * * Models                          : SwipeRecord,EmployeeDetails
*/

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use App\Models\SwipeRecord;
use App\Models\EmployeeDetails;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Spatie\SimpleExcel\SimpleExcelWriter;

class EmployeeSwipesData extends Component
{
    public $employees;

    public $startDate;
    public $endDate;

    public $employeeShiftDetails;
    public $selectedSwipeTime;

    public $search='';

    public $searching=0;

    public $selectedSwipeLogTime = [];
    public $swipeLogTime=null;
    public $sw_ipes;
    public $notFound;
    public $selectedEmployee;
    public $deviceId;
    public $status;
    public $swipes;
    public $mobileId;

    public $flag = false;
    public $swipeTime = '';
    public $searchtest = 0;
    public $loggedInEmpId1;
    public $empid;
    public function mount()
    {
            try {
                $today = now()->startOfDay();
                $authUser = Auth::user();
                $userId = $authUser->emp_id;
                
                $userSwipesToday = SwipeRecord::where('emp_id', Auth::guard('emp')->user()->emp_id)
                    ->where('created_at', '>=', $today)
                    ->where('created_at', '<', $today->copy()->endOfDay())
                    ->exists();

                $userSwipesToday1 = SwipeRecord::where('emp_id', Auth::guard('emp')->user()->emp_id)
                    ->where('created_at', '>=', $today)
                    ->where('created_at', '<', $today->copy()->endOfDay())
                    ->first();

                if ($userSwipesToday1) {
                    $agent = new Agent();

                    if ($agent->isMobile()) {
                        $this->status = 'Mobile';
                    } elseif ($agent->isDesktop()) {
                        $this->status = 'Desktop';
                    } else {
                        $this->status = '-';
                    }
                } else {
                    $this->status = '-';
                }
            } catch (\Exception $e) {
                    Log::error('Error in mount method: ' . $e->getMessage());
                    $this->status = 'Error';
            }   
            
    
            // Construct the table name for SQL Server
           
          
            
              

                // $dataSqlServer = DB::connection('sqlsrv')
                // ->table($tableName)
                // ->select('UserId', 'logDate', 'Direction')
                // ->whereIn('UserId', $employeeIds)
                // ->whereDate('logDate', $today)
                // ->orderBy('logDate')
                // ->get()
                // ->unique('UserId')
                // ->values(); // Re-index the collection
            
              
    }
    public function updateselectedSwipeTime($value)
    {
        $this->selectedSwipeTime=$value;
        
    }
    public function testMethod()
    {
        try
        {
         $currentDate = now()->toDateString();
         $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
         $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->get();
        //  $this->swipes = SwipeRecord::whereIn('id', function ($query) use ($employees, $currentDate) {
        //      $query->selectRaw('MIN(id)')
        //          ->from('swipe_records')
        //          ->whereIn('emp_id', $employees->pluck('emp_id'))
        //          ->whereDate('created_at', $currentDate)
        //          ->groupBy('emp_id');
        //  })
        //      ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
        //      ->when($this->search, function ($query) {
        //          $query->where(function ($subQuery) {
        //              $subQuery->where('first_name', 'like', '%' . $this->search . '%')
        //                  ->orWhere('last_name', 'like', '%' . $this->search . '%');
        //          });
        //      })
        //      ->select('swipe_records.*', 'employee_details.first_name', 'employee_details.last_name')
        //      ->get();
         }catch (\Exception $e) {
             // Handle the exception and provide a user-friendly message
             Log::error('Error in test method: ' . $e->getMessage());
             // Optionally, you could also set an error state or return an error response
             session()->flash('error', 'An error occurred while performing the test method. Please try again.');
         }
    }
    //This method will show the list of all employees who swiped in and swiped out today 
    public function downloadFileforSwipes()
    {
        try
        {
            $currentDate = Carbon::today();    
        $today = $currentDate->toDateString(); // Get today's date in 'Y-m-d' format
        $month = $currentDate->format('n');
        $year = $currentDate->format('Y');
        $authUser = Auth::user();
        $userId = $authUser->emp_id;
        // Construct the table name for SQL Server
        $tableName = 'DeviceLogs_' . $month . '_' . $year;
        $managedEmployees = EmployeeDetails::where('manager_id', $userId)
        ->where('employee_status', 'active')
        ->get();

    $swipeData = [];

    foreach ($managedEmployees as $employee) {
        $normalizedEmployeeId = str_replace('-', '', $employee->emp_id);

        // Fetch the first swipe log for each employee, if it exists
        $employeeSwipeLog = DB::connection('sqlsrv')
            ->table($tableName)
            ->select('UserId', 'logDate', 'Direction')
            ->where('UserId', $normalizedEmployeeId)
            ->whereDate('logDate', $today)
            ->orderBy('logDate')
            ->first(); // Get only the first entry for the day

        // Add the employee and their swipe log (if any) to the results
        if(!empty($employeeSwipeLog))
        {
            $swipeData[] = [
                'Employee ID' => $employee->emp_id,
                'Employee Name' => ucfirst(strtolower($employee->first_name)).' '.ucfirst(strtolower($employee->last_name)), // Assuming you have a `name` field
                'Swipe Date' => \Carbon\Carbon::parse($employeeSwipeLog->logDate)->format('d-M-Y') ,
                'Swipe Time' => \Carbon\Carbon::parse($employeeSwipeLog->logDate)->format('h:i A'),
                'Direction' => $employeeSwipeLog->Direction ,
            ];
        }
    }

    // Define header columns
    $headerColumns = ['Employee ID', 'Employee Name', 'Swipe Date', 'Direction'];

    // Create the Excel file
    $filePath = storage_path('app/todays_present_employees.xlsx');

    SimpleExcelWriter::create($filePath)
        ->addRow($headerColumns) // Add header row
        ->addRows($swipeData) // Add data rows
        ->close(); // Close the writer to save the file

    return response()->download($filePath, 'todays_present_employees.xlsx');
        }catch (\Exception $e) {
            // Handle the exception and provide a user-friendly message
            Log::error('Error downloading file for swipes: ' . $e->getMessage());
            // Optionally, you could also set an error state or return an error response
            session()->flash('error', 'An error occurred while downloading the file for swipes. Please try again.');
            return redirect()->back(); // Redirect back to the previous page
        }
    }
    public function searchEmployee()
    {
        $this->searching=1;
       
    }
    public function checkboxClicked($time)
    {
        // Handle the checkbox click event
        // $time contains the time of the swipe log
        // Perform your logic here

        // Example: Logging the time
       $this->swipeLogTime=$time;
    }
    public function checkDates()
    {
        $this->startDate=$this->startDate;
        $this->endDate=$this->endDate;
        // dd($this->sta)
    }
    public function render()
{
    try {
        $currentDate = now()->toDateString();
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $currentDate = Carbon::today();
        $today = $currentDate->toDateString(); // Get today's date in 'Y-m-d' format
        $month = $currentDate->format('n');
        $year = $currentDate->format('Y');
 
        // Construct the table name for SQL Server
        $tableName = 'DeviceLogs_' . $month . '_' . $year;
 
        // Retrieve the authenticated user details using Eloquent
        $authUser = Auth::user();
        $userId = $authUser->emp_id;
        $normalizedUserId = str_replace('-', '', $userId);
        $managedEmployees = EmployeeDetails::where('manager_id', $userId)->get();
        $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name','shift_start_time','shift_end_time')->get();
        $this->employeeShiftDetails=EmployeeDetails::where('emp_id',$loggedInEmpId)->first();
        $approvedLeaveRequests = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
            ->where('leave_applications.status', 'approved')
            ->whereIn('leave_applications.emp_id', $employees->pluck('emp_id'))
            ->whereDate('from_date', '<=', $currentDate)
            ->whereDate('to_date', '>=', $currentDate)
            ->get(['leave_applications.*', 'employee_details.first_name', 'employee_details.last_name'])
            ->map(function ($leaveRequest) {
                // Calculate the number of days between from_date and to_date
                $fromDate = Carbon::parse($leaveRequest->from_date);
                $toDate = Carbon::parse($leaveRequest->to_date);
        
                $leaveRequest->number_of_days = $fromDate->diffInDays($toDate) + 1; // Add 1 to include both start and end dates
        
                return $leaveRequest;
            });

       
        $managedEmployees = EmployeeDetails::where('manager_id', $userId)->where('employee_status','active')->get();
        $employeeIds=EmployeeDetails::where('manager_id', $userId)->pluck('emp_id')->toArray();
     
        foreach ($managedEmployees as $employee) {
            $normalizedEmployeeId = str_replace('-', '', $employee->emp_id);

            // Fetch the first swipe log for each employee, if it exists
            $employeeSwipeLog = DB::connection('sqlsrv')
                ->table($tableName)
                ->select('UserId', 'logDate', 'Direction')
                ->where('UserId', $normalizedEmployeeId)
                ->whereDate('logDate',$today)
                ->orderBy('logDate')
                ->first(); // Get only the first entry for the day
               
            
            
            // Add the employee and their swipe log (if any) to the results
            $swipeData[] = [
                'employee' => $employee,
                'swipe_log' => $employeeSwipeLog,
            ];

          
        $this->swipes=$swipeData;
        
        
       
    
      
           
       }

        $todaySwipeIN = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->whereDate('created_at', $currentDate)->first();

        if ($todaySwipeIN) {
            // Swipe IN time for today
            $this->swipeTime = $todaySwipeIN->swipe_time;
        }

        return view('livewire.employee-swipes-data', [
            'LoggedInEmpId1' => $this->loggedInEmpId1,
            'SignedInEmployees' => $this->swipes,
            'SwipeTime' => $this->swipeTime,
            // 'SWIPES' => $this->swipes
        ]);
    } catch (\Exception $e) {
        // Handle the exception (e.g., log it, set a default value, or show an error message)
        Log::error('Error in render method: ' . $e->getMessage());
        $this->swipes = collect();
        $this->notFound = true;
        $this->swipeTime = null;

        return view('livewire.employee-swipes-data', [
            'LoggedInEmpId1' => $this->loggedInEmpId1,
            'SignedInEmployees' => $this->swipes,
            'SwipeTime' => $this->swipeTime,
            // 'SWIPES' => $this->swipes
        ]);
    }
}

}
