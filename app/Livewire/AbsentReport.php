<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\HolidayCalendar;
use App\Models\LeaveRequest;
use App\Models\SwipeRecord;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelWriter;

class AbsentReport extends Component
{
    public $employees1;

    public $employees;
    public $fromDate;
    public $toDate;

    public $search;

    public $searching=0;
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
    public function searchfilter()
    {
        $this->searching=1;
    }
    public function employeeSelected($empId)
    {
        if (in_array($empId, $this->selectedEmployees)) {
            $this->selectedEmployees = array_diff($this->selectedEmployees, [$empId]);
        } else {
            $this->selectedEmployees[] = $empId;
        
        }
   
       
    }
    public function getHolidays()
    {
            // Fetch only the 'date' column from the HolidayCalendar model
            $holidays = HolidayCalendar::pluck('date');
           // If you need the result as an array of strings (dates)
           $holidayDates = $holidays->map(function($date) {
                   return $date; // Ensure it's in 'Y-m-d' format if necessary
            });

    // Example of how to use the $holidayDates
    return $holidayDates;
}
    public function downloadAbsentReportInExcel()
    {
     
        // $employees = EmployeeDetails::whereIn('emp_id', $this->selectedEmployees)->get();
        // $this->approvedLeaveRequests = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
        //     ->where('leave_applications.status', 'approved')
        //     ->whereIn('leave_applications.emp_id', $employees->pluck('emp_id'))
        //     ->whereDate('from_date', '<=', $this->currentDate)
        //     ->whereDate('to_date', '>=', $this->currentDate)
        //     ->get(['leave_applications.*', 'employee_details.first_name', 'employee_details.last_name'])
        //     ->map(function ($leaveRequest) {

        //         $fromDate = Carbon::parse($leaveRequest->from_date);
        //         $toDate = Carbon::parse($leaveRequest->to_date);

        //         $leaveRequest->number_of_days = $fromDate->diffInDays($toDate) + 1;

        //         return $leaveRequest;
        //     });
           
            // Fetch the swipe records with the minimum IDs
            
           
        
        
            // $query = EmployeeDetails::where('emp_id', $this->selectedEmployees)
            // ->select('emp_id', 'first_name', 'last_name', 'created_at')
            // ->whereNotIn('emp_id', function ($query) {
            //     $query->select('emp_id')
            //         ->from('swipe_records')
            //         ->where('emp_id', $this->selectedEmployees)
            //         ->whereDate('created_at', '>=',$this->currentDate )
            //         ->whereDate('created_at', '<=', $this->currentDate);
            // })
            // ->whereNotIn('emp_id', $this->approvedLeaveRequests->pluck('emp_id'))->get();
            
        // if ($this->fromDate && $this->toDate) {
        //     $query = EmployeeDetails::where('manager_id', $this->loggedInEmpId)
        //         ->select('emp_id', 'first_name', 'last_name', 'created_at')
        //         ->whereNotIn('emp_id', function ($query) {
        //             $query->select('emp_id')
        //                 ->from('swipe_records')
        //                 ->where('manager_id', $this->loggedInEmpId)
        //                 ->whereDate('created_at', '>=', $this->fromDate)
        //                 ->whereDate('created_at', '<=', $this->toDate);
        //         })
        //         ->whereNotIn('emp_id', $this->approvedLeaveRequests->pluck('emp_id'));
        // } else {
        //     $query = EmployeeDetails::where('manager_id', $this->loggedInEmpId)
        //         ->select('emp_id', 'first_name', 'last_name', 'created_at')
        //         ->whereNotIn('emp_id', function ($query) {
        //             $query->select('emp_id')
        //                 ->from('swipe_records')
        //                 ->where('manager_id', $this->loggedInEmpId)
        //                 ->whereDate('created_at', $this->currentDate);
        //         })
        //         ->whereNotIn('emp_id', $this->approvedLeaveRequests->pluck('emp_id'));
        // }
        // $employees2 = $query->get();
        
       if(empty($this->selectedEmployees))
       {
         return redirect()->back()->with('error', 'Select at least one employee detail');
       }
       if(empty($this->fromDate)&&empty($this->toDate))
       {
         return redirect()->back()->with('error', 'Please select fromDate and toDate');
       }
       else
       {
        $employees = EmployeeDetails::whereIn('emp_id', $this->selectedEmployees)->get();
        foreach ($employees as $employee) {
            $empId = $employee['emp_id'];
            $approvedLeaveRequests = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
            ->where('leave_applications.status', 'approved')
            ->where('leave_applications.emp_id', $employee->emp_id)
            ->whereDate('from_date', '<=', $this->currentDate)
            ->whereDate('to_date', '>=', $this->currentDate)
            ->get(['leave_applications.*', 'employee_details.first_name', 'employee_details.last_name']);
            $subquery = SwipeRecord::select(DB::raw('MIN(id) as min_id'))
            ->whereIn('emp_id', $this->selectedEmployees)
            ->where('in_or_out', 'IN')
            ->whereBetween(DB::raw('DATE(created_at)'), ['2024-08-01', '2024-08-26'])
            ->groupBy(DB::raw('DATE(created_at)'));
            $swipeRecords = SwipeRecord::whereIn('id', function ($query) use ($subquery) {
                $query->fromSub($subquery, 'sub');
            })
            ->select('emp_id', DB::raw('DATE(created_at) as swipe_date'))
            ->get();
        // Fetch swipe records for this employee
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
            $startDate = new DateTime($this->fromDate);
            $endDate = new DateTime($this->toDate);    
            $leaveDates = $approvedLeaveRequests->flatMap(function ($leaveRequest) {
                $fromDate = Carbon::parse($leaveRequest->from_date);
                $toDate = Carbon::parse($leaveRequest->to_date);
    
                // Generate an array of dates within the range
                $dates = [];
                while ($fromDate <= $toDate) {
                    $dates[] = $fromDate->format('Y-m-d');
                    $fromDate->addDay();
                }
                return $dates;
            })->unique();
            $holidays = HolidayCalendar::pluck('date')->map(function($date) {
                return Carbon::parse($date)->format('Y-m-d'); // Ensure dates are in 'Y-m-d' format
            })->toArray();
        // $swipeDates = $swipeRecords->map->format('Y-m-d')->unique();
       
        // Get all dates in the current month (or any range you want to cover)
        $datesInMonth = collect();
        $startOfMonth = Carbon::parse($startDate);
        $endOfMonth = Carbon::parse($endDate);
        $date = $startOfMonth->copy();
        $missingData = [];
        while ($date <= $endOfMonth) {
            if (!in_array($date->format('Y-m-d'), $leaveDates->toArray()) &&
                !in_array($date->format('Y-m-d'), $holidays)&& 
                !$date->isWeekend()) {
                $datesInMonth->push($date->format('Y-m-d'));
            }
            $date->addDay();
        }
        foreach ($datesInMonth as $date) {
            foreach ($this->selectedEmployees as $empId) {
                // Check if the date and employee ID are not present in swipe records
                if (!$swipeRecords->contains(function ($record) use ($date, $empId) {
                    return $record->swipe_date === $date && $record->emp_id === $empId;
                })) {
                    // If not present, add to the missing data list
                    $missingData[] = [$empId, $date];
                }
            }
        }
         }
         $filePath = storage_path('app/absent_employees.xlsx');

        // Create the Excel file
        $writer = SimpleExcelWriter::create($filePath);
    
        // Add a header row
        $writer->addRow(['Emp ID', 'Absent Date']);
    
        // Add the data rows
        foreach ($missingData as $row) {
            $writer->addRow($row);
        }
        // Close the writer to ensure the file is saved
        $writer->close();
    
        // Return the file as a download response
        return response()->download($filePath, 'absent_employees.xlsx');
       }
        $startDate = new DateTime($this->fromDate);
        $endDate = new DateTime($this->toDate);
        $endDate->modify('+1 day'); // To include the end date in the loop

        $dates = []; // Initialize an array to hold the dates

        while ($startDate < $endDate) {
            $dates[] = [$startDate->format('Y-m-d')]; // Add each date as a single-element array
            $startDate->modify('+1 day');
        }
        
           // Define the file path
           
    }
  
    public function resetFields()
    {
        $this->selectedEmployees=[];
        $this->fromDate='';
        $this->toDate='';
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
