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
use Livewire\Component;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Spatie\SimpleExcel\SimpleExcelWriter;

class EmployeeSwipesData extends Component
{
    public $employees;

    public $startDate;
    public $endDate;

    public $search;
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

    public function checkDates()
    {
        // $this->flag=true;
        // // Add any additional logic you need
        // // dd($this->startDate . ' ' . $this->endDate);
        // $loggedInEmpId1= Auth::guard('emp')->user()->emp_id;
        // $employees1=EmployeeDetails::where('manager_id',$loggedInEmpId1)->select('emp_id', 'first_name', 'last_name')->get();
        // if($this->startDate&& $this->endDate)
        // {
        //     $prev_date=$this->startDate;
        //     $next_date=$this->endDate;
        //     $products = SwipeRecord::whereIn('id', function ($query) use ($employees1, $prev_date,  $next_date) {
        //         $query->selectRaw('MIN(id)')
        //             ->from('swipe_records')
        //             ->whereIn('emp_id', $employees1->pluck('emp_id'))
        //             ->whereBetween('created_at', [$prev_date,$next_date])
        //             ->groupBy('emp_id');
        //     })
        //     ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
        //     ->select('swipe_records.*', 'employee_details.first_name', 'employee_details.last_name')
        //     ->get();
        //     dd($products);
        // }
    }
    public $loggedInEmpId1;
    public function mount()
    {


        $today = now()->startOfDay(); // Carbon instance representing the start of today

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
                // The user accessed the component from a mobile device
                // For example: $this->emit('mobileAccess');
                $this->status = 'Mobile';
            } elseif ($agent->isDesktop()) {
                // The user accessed the component from a desktop or laptop
                $this->status = 'Desktop';
            } else {
                // Default case if neither mobile nor desktop
                $this->status = '-';
            }
        } else {
            $this->status = '-';
        }
    }
    Public $empid;
    public function testMethod()
    {
         $this->searchtest = 1;
        $currentDate = now()->toDateString();
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->get();
         // Start building the query to retrieve swipe records
         $query = SwipeRecord::join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
         ->where('swipe_records.created_at', '>=', $this->startDate) // Filter by current month
         ->where('swipe_records.created_at', '<=', $this->endDate)   // Filter by current month
         ->orderBy('swipe_records.created_at', 'desc');
 
         if ($this->empid) {
             $query->where('swipe_records.emp_id', $this->empid);
         }
 
         if ($this->search) {
             $query->where(function ($subQuery) {
                 $subQuery->where('first_name', 'like', '%' . $this->search . '%')
                     ->orWhere('last_name', 'like', '%' . $this->search . '%');
             });
         }
 
         // Execute the query and retrieve swipe records
         $this->sw_ipes = $query->select('swipe_records.*', 'employee_details.first_name', 'employee_details.last_name')
             ->get();
    }
    public function showEmployeeDetails($empId)
    {
        // Fetch details of the selected employee based on $empId
        $this->selectedEmployee = EmployeeDetails::where('emp_id', $empId)->first();
    }
    public function downloadFileforSwipes()
    {
        $currentDate = now()->toDateString();
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $this->loggedInEmpId1 = EmployeeDetails::where('emp_id', Auth::guard('emp')->user()->emp_id)->get();
        $this->loggedInEmpId1 = EmployeeDetails::where('emp_id', Auth::guard('emp')->user()->emp_id)->get();
        $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->get();
        $approvedLeaveRequests=LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
        ->where('leave_applications.status', 'approved')
        ->whereIn('leave_applications.emp_id', $employees->pluck('emp_id'))
        ->whereDate('from_date', '<=', $currentDate)
        ->whereDate('to_date', '>=', $currentDate)
        ->get(['leave_applications.*', 'employee_details.first_name', 'employee_details.last_name'])
        ->map(function ($leaveRequest) {
            // Calculate the number of days between from_date and to_date
            $fromDate = \Carbon\Carbon::parse($leaveRequest->from_date);
            $toDate = \Carbon\Carbon::parse($leaveRequest->to_date);
     
            $leaveRequest->number_of_days = $fromDate->diffInDays($toDate) + 1; // Add 1 to include both start and end dates
     
            return $leaveRequest;
        });
        if ($this->startDate && $this->endDate) {
            $prev_date = $this->startDate;
            $next_date = $this->endDate;
            $this->swipes = SwipeRecord::whereIn('id', function ($query) use ($employees, $prev_date,  $next_date) {
                $query->selectRaw('MIN(id)')
                    ->from('swipe_records')
                    ->whereIn('emp_id', $employees->pluck('emp_id'))
                    ->whereBetween('created_at', [$prev_date, $next_date])
                    ->groupBy('emp_id');
            })
                ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
                ->select('swipe_records.*', 'employee_details.first_name', 'employee_details.last_name')
                ->get();
        } else {
            $this->swipes = SwipeRecord::select('swipe_records.*', 'employee_details.first_name', 'employee_details.last_name')
            ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
            ->whereNotIn('swipe_records.emp_id', $approvedLeaveRequests->pluck('emp_id')) // Specify swipe_records.emp_id
            ->whereIn('swipe_records.emp_id', $employees->pluck('emp_id')) // Specify swipe_records.emp_id
            ->whereDate('swipe_records.created_at', $currentDate)
            ->orderBy('employee_details.first_name')
            ->get();
        

        }
        $data = [
            ['LIST OF PRESENT EMPLOYEES'],
            ['Employee ID', 'Employee Name', 'Swipe Date', 'Swipe Time', 'Shift', 'In/Out', 'Door/Address', 'Status'],

        ];
        $employees1 = $this->swipes;
        foreach ($employees1 as $employee) {
            $swipeTime1 = Carbon::parse($employee['created_at'])->format('d-m-Y'); // Format the date
            $data[] = [$employee['emp_id'], $employee['first_name'] . ' ' . $employee['last_name'], '=TEXT("' . $swipeTime1 . '","DD-MM-YYYY")', $employee['swipe_time'], '10:00 am to 07:00pm', $employee['in_or_out'], '-', '-'];
        }
        $filePath = storage_path('app/todays_present_employees.xlsx');
    
        SimpleExcelWriter::create($filePath)->addRows($data);  

       return response()->download($filePath, 'todays_present_employees.xlsx');
    }
    public function render()
    {
        $currentDate = now()->toDateString();
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->get();
        $approvedLeaveRequests=LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
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

        if ($this->startDate && $this->endDate) {
            $prev_date = $this->startDate;
            $next_date = $this->endDate;
            $this->swipes = SwipeRecord::whereIn('id', function ($query) use ($employees, $prev_date,  $next_date) {
                $query->selectRaw('MIN(id)')
                    ->from('swipe_records')
                    ->whereIn('emp_id', $employees->pluck('emp_id'))
                    ->whereBetween('created_at', [$prev_date, $next_date])
                    ->groupBy('emp_id');
            })
                ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
                ->select('swipe_records.*', 'employee_details.first_name', 'employee_details.last_name')
                ->orderBy('created_at')
                ->get();
        } else {
            // $this->swipes = SwipeRecord::whereIn('id', function ($query) use ($employees, $currentDate) {
            //     $query->selectRaw('MIN(id)')
            //         ->from('swipe_records')
            //         ->whereIn('emp_id', $employees->pluck('emp_id'))
            //         ->whereDate('created_at', $currentDate)
            //         ->groupBy('emp_id');
            // })
            //     ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
            //     ->select('swipe_records.*', 'employee_details.first_name', 'employee_details.last_name')
            //     ->orderBy('first_name')
            //     ->get();
            $this->swipes = SwipeRecord::select('swipe_records.*', 'employee_details.first_name', 'employee_details.last_name')
            ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
            ->whereNotIn('swipe_records.emp_id', $approvedLeaveRequests->pluck('emp_id')) // Specify swipe_records.emp_id
            ->whereIn('swipe_records.emp_id', $employees->pluck('emp_id')) // Specify swipe_records.emp_id
            ->whereDate('swipe_records.created_at', $currentDate)
            ->orderBy('employee_details.first_name')
            ->get();

        }
        $nameFilter = $this->search; // Assuming $this->search contains the name filter
        $this->swipes = $this->swipes->filter(function ($swipe) use ($nameFilter) {
            return stripos($swipe->first_name, $nameFilter) !== false || stripos($swipe->last_name, $nameFilter) !== false || stripos($swipe->emp_id, $nameFilter) !== false || stripos($swipe->swipe_time, $nameFilter) !== false;
        });
        if ($this->swipes->isEmpty()) {
            $this->notFound = true; // Set a flag indicating that the name was not found
        } else {
            $this->notFound = false;
        }
     

        $todaySwipeIN = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->whereDate('created_at', $currentDate)

            ->first();

        if ($todaySwipeIN) {
            // Swipe IN time for today

            $this->swipeTime = $todaySwipeIN->swipe_time;
        }

        return view('livewire.employee-swipes-data', ['LoggedInEmpId1' => $this->loggedInEmpId1, 'SignedInEmployees' => $this->swipes, 'SwipeTime' => $this->swipeTime, 'SWIPES'=>$this->sw_ipes]);
    }
}
