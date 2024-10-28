<?php
// File Name                       : WhoIsInChart.php
// Description                     : This file contains the list of employees working under specific manager who are on leave,arrived late,arrived early and absent.
// Creator                         : Pranita Priyadarshi
// Email                           : priyadarshipranita72@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : LeaveRequest,EmployeeDetails,SwipeRecord
namespace App\Livewire;

use App\Helpers\FlashMessageHelper;
use App\Models\EmployeeDetails;
use App\Models\SwipeRecord;
use App\Models\LeaveRequest;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Spatie\SimpleExcel\SimpleExcelWriter;

class WhoIsInChart extends Component
{
    use WithPagination;
    public $leaveRequests;
    public $swipe_records;

    public $dayShiftEmployeesCount;

    public $afternoonShiftEmployeesCount;

    public $eveningShiftEmployeesCount;
    
    public $approvedLeaveRequests;
    public $currentDate;
    public $notFound;
    public $notFound2;
    public $notFound3;
    public $isdatepickerclicked = 0;

    public $employeesOnLeaveCount;
    public $absentEmployeesCount;
    public $toggleButton=false;
    public $isToggled = false;

    public $openshiftselector = false;
    public $from_date;

    public $selectedShift=null;
    public $employees4;

    public $openAccordionForAbsent=null;

   public $shiftSelected=null;
  
    public $openAccordionForLate=null;

    public $openAccordionForEarly=null;

    public $openAccordionForLeave=null;
    public $shiftsforAttendance;
    public $search = '';

    // Pass this from your controller or set it within Livewire
   
    public $results = [];
    public function mount()
    {
        $this->currentDate = Carbon::now()->format('Y-m-d');
       
        $this->from_date=$this->currentDate;               
                 



    }
    public function opentoggleButton()
    {
        $this->toggleButton = !$this->toggleButton;   
    }
    
    public function updatedSelectedShift($value)
{
    // This method will be called whenever the selected radio button changes
    // $value will contain the value of the selected shift ('GS', 'AS', or 'ES')
    Log::info('Selected Shift: ' . $value);

    // You can handle the selected value here
    if ($value === 'GS') {
        $this->selectedShift='General Shift';
    } elseif ($value === 'AS') {
        // Handle afternoon shift (AS)
        $this->selectedShift='Afternoon Shift';
    } elseif ($value === 'ES') {
        // Handle evening shift (ES)
        $this->selectedShift='Evening Shift';
    }
}
public function checkshift()
{
    $this->selectedShift=$this->selectedShift;
    $this->openshiftselector=false;
}
    
  
   
    public function toggleAccordionForAbsent($index)
    {
        // Toggle the open state for the clicked accordion
        if ($this->openAccordionForAbsent === $index) {
            $this->openAccordionForAbsent = null; // Close the accordion if it's already open
        } else {
            $this->openAccordionForAbsent = $index; // Open the clicked accordion
        }
    }
    public function toggleAccordionForLate($index)
    {
        // Toggle the open state for the clicked accordion
        if ($this->openAccordionForLate === $index) {
            $this->openAccordionForLate = null; // Close the accordion if it's already open
        } else {
            $this->openAccordionForLate = $index; // Open the clicked accordion
        }
    }
    public function toggleAccordionForEarly($index)
    {
        // Toggle the open state for the clicked accordion
        if ($this->openAccordionForEarly === $index) {
            $this->openAccordionForEarly = null; // Close the accordion if it's already open
        } else {
            $this->openAccordionForEarly = $index; // Open the clicked accordion
        }
    }
    public function toggleAccordionForLeave($index)
    {
        if ($this->openAccordionForLeave === $index) {
            $this->openAccordionForLeave = null; // Close the accordion if it's already open
        } else {
            $this->openAccordionForLeave = $index; // Open the clicked accordion
        }

    }
    //This function will help us to get the details of late arrival employees(who arrived after 10:00am) in excel sheet
    public function downloadExcelForLateArrivals()
    {
        try {
            $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
            $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->get();
            if ($this->isdatepickerclicked == 0) {
                $currentDate = now()->toDateString();
            } else {
                $currentDate = $this->from_date;
            }

            $approvedLeaveRequests =LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
            ->join('status_types', 'leave_applications.leave_status', '=', 'status_types.status_code') // Join with status_types
            ->where('leave_applications.leave_status', 3)
            ->whereIn('leave_applications.emp_id', $employees->pluck('emp_id'))
            ->whereDate('from_date', '<=', $currentDate)
            ->whereDate('to_date', '>=', $currentDate)
            ->where('employee_details.employee_status', 'active')
            ->get([
                'leave_applications.*',
                'employee_details.first_name', 
                'employee_details.last_name', 
                'status_types.status_name as leave_status' // Select status_name as leave_status
            ])
            ->map(function ($leaveRequest) {
                $fromDate = Carbon::parse($leaveRequest->from_date);
                $toDate = Carbon::parse($leaveRequest->to_date);
                $leaveRequest->number_of_days = $fromDate->diffInDays($toDate) + 1;
                return $leaveRequest;
            });

            
                $swipes = SwipeRecord::whereIn('swipe_records.id', function ($query) use ($employees, $approvedLeaveRequests, $currentDate) {
                    $query->selectRaw('MIN(swipe_records.id)')
                        ->from('swipe_records')
                        ->whereIn('swipe_records.emp_id', $employees->pluck('emp_id'))
                        ->whereNotIn('swipe_records.emp_id', $approvedLeaveRequests->pluck('emp_id'))
                        ->whereDate('swipe_records.created_at', $currentDate)
                        ->groupBy('swipe_records.emp_id');
                })
                ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
                ->leftJoin('emp_personal_infos', 'swipe_records.emp_id', '=', 'emp_personal_infos.emp_id')
                ->leftJoin('company_shifts', function ($join) {
                    $join->on(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(employee_details.company_id, '$[0]'))"), '=', 'company_shifts.company_id') // Join on company_id
                         ->whereColumn('employee_details.shift_type', 'company_shifts.shift_name'); // Join on shift_type
                })
                ->select('swipe_records.*', 'employee_details.first_name','employee_details.last_name','company_shifts.shift_start_time', 'company_shifts.shift_end_time','employee_details.emergency_contact', 'company_shifts.shift_name') // Include shift_name in select
                ->where('employee_details.employee_status', 'active')
                ->distinct()
                ->get();
            $data = [
                ['List of Late Arrival Employees on ' . Carbon::parse($currentDate)->format('jS F, Y')],
                ['Employee ID', 'Name', 'Sign In Time', 'Late By(HH:MM)'],
            ];

            foreach ($swipes as $employee) {
                $swipeTime = Carbon::parse($employee->swipe_time);
                $shiftStartTime = $employee->shift_start_time;
                $swipeTime1 = Carbon::parse($employee['created_at'])->format('H:i:s');
                $lateArrivalTime = $swipeTime->diff(Carbon::parse($shiftStartTime))->format('%H:%I:%S');
                $isLateBy10AM = $swipeTime->format('H:i') >= $shiftStartTime;
                if($isLateBy10AM)
                {
                    $data[] = [$employee['emp_id'], ucwords(strtolower($employee['first_name'])) . ucwords(strtolower($employee['last_name'])), $employee['swipe_time'], $lateArrivalTime];
                }
            }

            $filePath = storage_path('app/late_employees.xlsx');
            SimpleExcelWriter::create($filePath)->addRows($data);
            return response()->download($filePath, 'late_employees.xlsx');
        } catch (\Exception $e) {
            Log::error('Error generating Excel report for late arrivals: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while generating the Excel report. Please try again.');
   
            
            return redirect()->back();
        }
    }
    //This function will help us to get the details of early arrival employees(who arrived before 10:00am) in excel sheet
    public function downloadExcelForEarlyArrivals()
    {
        try {
            $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
            $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->get();
            if ($this->isdatepickerclicked == 0) {
                $currentDate = now()->toDateString();
            } else {
                $currentDate = $this->from_date;
            }
            $approvedLeaveRequests = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
            ->join('status_types', 'leave_applications.leave_status', '=', 'status_types.status_code') // Join with status_types
            ->where('leave_applications.leave_status', 3)
            ->whereIn('leave_applications.emp_id', $employees->pluck('emp_id'))
            ->whereDate('from_date', '<=', $currentDate)
            ->whereDate('to_date', '>=', $currentDate)
            ->where('employee_details.employee_status', 'active')
            ->get([
                'leave_applications.*',
                'employee_details.first_name', 
                'employee_details.last_name', 
                'status_types.status_name as leave_status' // Select status_name as leave_status
            ])
            ->map(function ($leaveRequest) {
                $fromDate = Carbon::parse($leaveRequest->from_date);
                $toDate = Carbon::parse($leaveRequest->to_date);
                $leaveRequest->number_of_days = $fromDate->diffInDays($toDate) + 1;
                return $leaveRequest;
            });


            
                $swipes = SwipeRecord::whereIn('swipe_records.id', function ($query) use ($employees, $approvedLeaveRequests, $currentDate) {
                    $query->selectRaw('MIN(swipe_records.id)')
                        ->from('swipe_records')
                        ->whereIn('swipe_records.emp_id', $employees->pluck('emp_id'))
                        ->whereNotIn('swipe_records.emp_id', $approvedLeaveRequests->pluck('emp_id'))
                        ->whereDate('swipe_records.created_at', $currentDate)
                        ->groupBy('swipe_records.emp_id');
                })
                ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
                ->leftJoin('emp_personal_infos', 'swipe_records.emp_id', '=', 'emp_personal_infos.emp_id')
                ->leftJoin('company_shifts', function ($join) {
                    $join->on(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(employee_details.company_id, '$[0]'))"), '=', 'company_shifts.company_id') // Join on company_id
                         ->whereColumn('employee_details.shift_type', 'company_shifts.shift_name'); // Join on shift_type
                })
                ->select('swipe_records.*', 'employee_details.first_name','employee_details.last_name','company_shifts.shift_start_time', 'company_shifts.shift_end_time','employee_details.emergency_contact', 'company_shifts.shift_name') // Include shift_name in select
                ->where('employee_details.employee_status', 'active')
                ->distinct()
                ->get();
            $data = [
                ['List of On Time Employees on ' . Carbon::parse($currentDate)->format('jS F, Y')],
                ['Employee ID', 'Name', 'Sign In Time', 'Early By(HH:MM)'],

            ];
            foreach ($swipes as $employee) {
                $swipeTime = Carbon::parse($employee->swipe_time);
                $shiftStartTime = (new DateTime($employee->shift_start_time))->format('H:i');
                $earlyArrivalTime = $swipeTime->diff(Carbon::parse($shiftStartTime))->format('%H:%I:%S');
                $isEarlyBy10AM = $swipeTime->format('H:i') <=$shiftStartTime;
                if($isEarlyBy10AM)
                {
                    $data[] = [$employee['emp_id'], ucwords(strtolower($employee['first_name'])).' '. ucwords(strtolower($employee['last_name'])), $employee['swipe_time'], $earlyArrivalTime];
                }
            }
            $filePath = storage_path('app/employees_on_time.xlsx');
            SimpleExcelWriter::create($filePath)->addRows($data);
            return response()->download($filePath, 'employees_on_time.xlsx');
        } catch (\Exception $e) {
            Log::error('Error generating Excel report for early/on-time arrivals: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while generating the Excel report. Please try again.');
            
            return redirect()->back();
        }
    }
    //This function will help us to get the details of employees who are on leave in excel sheet
    public function downloadExcelForLeave()
    {
        try {
            $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
            $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->get();
            if ($this->isdatepickerclicked == 0) {
                $currentDate = now()->toDateString();
            } else {
                $currentDate = $this->from_date;
            }

            $approvedLeaveRequests = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
                            ->join('status_types', 'leave_applications.leave_status', '=', 'status_types.status_code') // Join with status_types
                            ->where('leave_applications.leave_status', 2)
                            ->whereIn('leave_applications.emp_id', $employees->pluck('emp_id'))
                            ->whereDate('from_date', '<=', $currentDate)
                            ->whereDate('to_date', '>=', $currentDate)
                            ->where('employee_details.employee_status', 'active')
                            ->get([
                            'leave_applications.*',
                            'employee_details.first_name', 
                            'employee_details.last_name', 
                            'status_types.status_name as leave_status' // Select status_name as leave_status
                            ])
                            ->map(function ($leaveRequest) {
                            $fromDate = Carbon::parse($leaveRequest->from_date);
                            $toDate = Carbon::parse($leaveRequest->to_date);

                            // Calculate the number of days excluding weekends
                            $numberOfDays = 0;
                            while ($fromDate->lte($toDate)) {
                            // Check if the day is not a weekend
                            if (!$fromDate->isWeekend()) {
                                $numberOfDays++;
                            }
                            $fromDate->addDay();
                            }

                            $leaveRequest->number_of_days = $numberOfDays;
                            return $leaveRequest;
                            });


            $data = [
                ['List of On Leave Employees on ' . Carbon::parse($currentDate)->format('jS F, Y')],
                ['Employee ID', 'Name', 'Leave Type', 'Leave Days'],

            ];
            foreach ($approvedLeaveRequests as $employee) {
                $data[] = [$employee['emp_id'], ucwords(strtolower($employee['first_name'])) . ' ' . ucwords(strtolower($employee['last_name'])), $employee['leave_type'], $employee['number_of_days']];
            }

            $filePath = storage_path('app/employees_on_leave.xlsx');

            SimpleExcelWriter::create($filePath)->addRows($data);

            return response()->download($filePath, 'employees_on_leave.xlsx');
        } catch (\Exception $e) {
            Log::error('Error generating Excel report for leave: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while generating the Excel report. Please try again.');
            return redirect()->back();
        }
    }
    //This function will help us to get the details of employees who are absent in excel sheet
    public function downloadExcelForAbsent()
    {
        try {
            $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
            $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->get();

            if ($this->isdatepickerclicked == 0) {
                $currentDate = now()->toDateString();
            } else {
                $currentDate = $this->from_date;
            }

            $approvedLeaveRequests =LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
            ->join('status_types', 'leave_applications.leave_status', '=', 'status_types.status_code') // Join with status_types
            ->where('leave_applications.leave_status', 3)
            ->whereIn('leave_applications.emp_id', $employees->pluck('emp_id'))
            ->whereDate('from_date', '<=', $currentDate)
            ->whereDate('to_date', '>=', $currentDate)
            ->where('employee_details.employee_status', 'active')
            ->get([
                'leave_applications.*',
                'employee_details.first_name', 
                'employee_details.last_name', 
                'status_types.status_name as leave_status' // Select status_name as leave_status
            ])
            ->map(function ($leaveRequest) {
                $fromDate = Carbon::parse($leaveRequest->from_date);
                $toDate = Carbon::parse($leaveRequest->to_date);
                $leaveRequest->number_of_days = $fromDate->diffInDays($toDate) + 1;
                return $leaveRequest;
            });


                $employees1 = EmployeeDetails::where('employee_details.manager_id', $loggedInEmpId)
                ->leftJoin('emp_personal_infos', 'employee_details.emp_id', '=', 'emp_personal_infos.emp_id') // Join personal info table
                ->leftJoin('company_shifts', function ($join) {
                    $join->on(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(employee_details.company_id, '$[0]'))"), '=', 'company_shifts.company_id')
                         ->whereColumn('employee_details.shift_type', 'company_shifts.shift_name'); // Join on shift_type and shift_name
                })
                ->select(
                    'employee_details.*',
                     // Selecting the mobile number from emp_personal_infos
                    'company_shifts.shift_name', // Selecting shift_name from company_shifts
                    'company_shifts.shift_start_time',
                    'company_shifts.shift_end_time'
                )
                ->whereNotIn('employee_details.emp_id', function ($query) use ($loggedInEmpId, $currentDate) {
                    $query->select('emp_id')
                        ->from('swipe_records')
                        ->where('manager_id', $loggedInEmpId)
                        ->whereDate('created_at', $currentDate);
                })
                ->whereNotIn('employee_details.emp_id', $approvedLeaveRequests->pluck('emp_id'))
                ->where('employee_details.employee_status', 'active')
                ->distinct('employee_details.emp_id')
                ->get();
          
            $data = [
                ['List of Absent Employees on ' . Carbon::parse($currentDate)->format('jS F, Y')],
                ['Employee ID', 'Name','Shift_Start_Time'],

            ];
            foreach ($employees1 as $employee) {
                $data[] = [$employee['emp_id'], ucwords(strtolower($employee['first_name'])). ' ' . ucwords(strtolower($employee['last_name'])),$employee['shift_start_time']];
            }
            $filePath = storage_path('app/absent_employees.xlsx');
            SimpleExcelWriter::create($filePath)->addRows($data);
            return response()->download($filePath, 'absent_employees.xlsx');
        } catch (\Exception $e) {
            Log::error('Error generating Excel report for absent: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while generating the Excel report. Please try again.');
            return redirect()->back();
        }
    }

    //This function will help us to search about any particular employees
    public function searchFilters()
    {
        try {
            $loggedInEmpId1 = Auth::guard('emp')->user()->emp_id;
            $this->results = EmployeeDetails::where(function ($query) use ($loggedInEmpId1) {
                $query->where('manager_id', $loggedInEmpId1)
                    ->where(function ($query) {
                        $query->where('first_name', 'like', '%' . $this->search . '%')
                            ->orWhere('last_name', 'like', '%' . $this->search . '%')
                            ->orWhere('emp_id', 'like', '%' . $this->search . '%');
                    });
            })->get();
        } catch (\Exception $e) {
            Log::error('Error performing search: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while performing the search. Please try again.');
        }
    }
    //This function will help us to get the details of the status of all the employees based on the particular date
    public function updateDate()
    {
        try {
            $this->isdatepickerclicked = 1;
            $this->selectedShift=null;
            $this->currentDate = $this->from_date;
        } catch (\Exception $e) {
            Log::error('Error updating date: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while updating the date. Please try again.');
           
        }
    }
    //After seraching about any particular employee it will remove the data from the search bar
    public function clearSearch()
    {
        try {
            $this->search = '';
            $this->results = [];
        } catch (\Exception $e) {
            Log::error('Error clearing search: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while clearing the search. Please try again.');
            
        }
    }
    public function openSelector()
    {
        $this->openshiftselector = true;
    }


    public function toggle()
    {
        $this->isToggled = !$this->isToggled;
    }
    public function closeShiftSelector()
    {
        $this->openshiftselector = false;
    }
    
    public function render()
    {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->where('employee_status','active')->get();
        $employees2 = EmployeeDetails::where('manager_id', $loggedInEmpId)
        ->where('employee_status','active')
                    ->count(); // Count the results
        
        if ($this->isdatepickerclicked == 0) {
            $currentDate = now()->toDateString();
        } else {
            $currentDate = $this->from_date;
        }
     if(empty($this->selectedShift))
     {
        $approvedLeaveRequests = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
                ->leftJoin('emp_personal_infos', 'leave_applications.emp_id', '=', 'emp_personal_infos.emp_id') // Joining with emp_personal_infos
                ->where('leave_applications.leave_status', 2)
                ->whereIn('leave_applications.emp_id', $employees->pluck('emp_id'))
                ->whereDate('from_date', '<=', $currentDate)
                ->whereDate('to_date', '>=', $currentDate)
                ->where('employee_details.employee_status', 'active')
                ->get([
                    'leave_applications.*', // To get leave date and leave type
                    'employee_details.*',
                ])
                ->map(function ($leaveRequest) {
                    // Calculating the number of leave days excluding weekends
                    $fromDate = Carbon::parse($leaveRequest->from_date);
                    $toDate = Carbon::parse($leaveRequest->to_date);

                    // Generate all dates between from_date and to_date, excluding weekends
                    $leave_dates = [];
                    for ($date = $fromDate->copy(); $date->lte($toDate); $date->addDay()) {
                        // Exclude weekends (Saturday=6, Sunday=7)
                        if (!$date->isWeekend()) {
                            $leave_dates[] = $date->format('Y-m-d');
                        }
                    }

                    // Set the leave_dates attribute using setAttribute
                    $leaveRequest->setAttribute('leave_dates', $leave_dates);

                    // Calculate the number of leave days excluding weekends
                    $leaveRequest->number_of_days = count($leave_dates);

                    return $leaveRequest;
                });

    
     }
     else
     {
        $approvedLeaveRequests = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
        ->leftjoin('emp_personal_infos', 'leave_applications.emp_id', '=', 'emp_personal_infos.emp_id') // Joining with emp_personal_infos
        ->where('leave_applications.leave_status', 2)
        ->whereIn('leave_applications.emp_id', $employees->pluck('emp_id'))
        ->whereDate('from_date', '<=', $currentDate)
        ->whereDate('to_date', '>=', $currentDate)
        ->where('employee_details.shift_type',$this->selectedShift)
        ->where('employee_details.employee_status','active')
        ->get([
            'leave_applications.*', // To get leave date and leave type
            'employee_details.*', 
           
        ]) 
        ->map(function ($leaveRequest) {
            // Calculating the number of leave days
            $fromDate = Carbon::parse($leaveRequest->from_date);
            $toDate = Carbon::parse($leaveRequest->to_date);
            $leaveRequest->number_of_days = $fromDate->diffInDays($toDate) + 1;
    
            // Generating all dates between from_date and to_date
            $leave_dates = [];
            for ($date = $fromDate->copy(); $date->lte($toDate); $date->addDay()) {
                $leave_dates[] = $date->format('Y-m-d');
            }
    
            // Set the leave_dates attribute using setAttribute
            $leaveRequest->setAttribute('leave_dates', $leave_dates);
    
            return $leaveRequest;
        });
     }
    




    $approvedLeaveRequests1 = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
    ->leftJoin('emp_personal_infos', 'leave_applications.emp_id', '=', 'emp_personal_infos.emp_id')  // Join with emp_personal_infos
    ->where('leave_applications.leave_status', 2)
    ->whereIn('leave_applications.emp_id', $employees->pluck('emp_id'))
    ->whereDate('leave_applications.from_date', '<=', $currentDate)
    ->whereDate('leave_applications.to_date', '>=', $currentDate)
    ->select(
        'leave_applications.*', 
        'employee_details.*', 
        // Include fields from emp_personal_infos
    )
    ->count();
    
            // dd($approvedLeaveRequests1);

            // $approvedLeaveRequests1List = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
            // ->where('leave_applications.status', 'approved')
            // ->whereIn('leave_applications.emp_id', $employees->pluck('emp_id'))
            // ->whereDate('from_date', '<=', '2024-09-04')
            // ->whereDate('to_date', '>=', '2024-09-04')
            // ->get();
            // dd($approvedLeaveRequests1List);
            if(empty($this->selectedShift))
            {
                $employees1 = EmployeeDetails::where('employee_details.manager_id', $loggedInEmpId)
    ->leftJoin('emp_personal_infos', 'employee_details.emp_id', '=', 'emp_personal_infos.emp_id') // Join personal info table
    ->leftJoin('company_shifts', function ($join) {
        $join->on(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(employee_details.company_id, '$[0]'))"), '=', 'company_shifts.company_id')
             ->whereColumn('employee_details.shift_type', 'company_shifts.shift_name'); // Join on shift_type and shift_name
    })
    ->select(
        'employee_details.*',// Selecting the mobile number from emp_personal_infos
        'company_shifts.shift_name', // Selecting shift_name from company_shifts
        'company_shifts.shift_start_time',
        'company_shifts.shift_end_time'
    )
    ->whereNotIn('employee_details.emp_id', function ($query) use ($loggedInEmpId, $currentDate) {
        $query->select('emp_id')
            ->from('swipe_records')
            ->where('manager_id', $loggedInEmpId)
            ->whereDate('created_at', $currentDate);
    })
    ->whereNotIn('employee_details.emp_id', $approvedLeaveRequests->pluck('emp_id'))
    ->where('employee_details.employee_status', 'active')
    ->distinct('employee_details.emp_id')
    ->get();
                $countOfAbsentEmployees =EmployeeDetails::where('employee_details.manager_id', $loggedInEmpId)
                ->leftJoin('emp_personal_infos', 'employee_details.emp_id', '=', 'emp_personal_infos.emp_id') // Join personal info table
                ->leftJoin('company_shifts', function ($join) {
                    $join->on(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(employee_details.company_id, '$[0]'))"), '=', 'company_shifts.company_id')
                         ->whereColumn('employee_details.shift_type', 'company_shifts.shift_name'); // Join on shift_type and shift_name
                })
                ->select(
                    'employee_details.*',
                    // Selecting the mobile number from emp_personal_infos
                    'company_shifts.shift_name', // Selecting shift_name from company_shifts
                    'company_shifts.shift_start_time',
                    'company_shifts.shift_end_time'
                )
                ->whereNotIn('employee_details.emp_id', function ($query) use ($loggedInEmpId, $currentDate) {
                    $query->select('emp_id')
                        ->from('swipe_records')
                        ->where('manager_id', $loggedInEmpId)
                        ->whereDate('created_at', $currentDate);
                })
                ->whereNotIn('employee_details.emp_id', $approvedLeaveRequests->pluck('emp_id'))
                ->where('employee_details.employee_status', 'active')
                ->distinct('employee_details.emp_id')
                ->count();
             
            }
            else
            {
                $employees1 = EmployeeDetails::where('employee_details.manager_id', $loggedInEmpId)
    ->leftJoin('emp_personal_infos', 'employee_details.emp_id', '=', 'emp_personal_infos.emp_id') // Join with personal info
    ->leftJoin('company_shifts', function ($join) {
        $join->on(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(employee_details.company_id, '$[0]'))"), '=', 'company_shifts.company_id') // Join on company_id
             ->whereColumn('employee_details.shift_type', 'company_shifts.shift_name'); // Join on shift_type
    })
    ->select(
        'employee_details.*',
        // Selecting the mobile number from emp_personal_infos
        'company_shifts.shift_name' // Selecting shift_name from company_shifts
    )
    ->whereNotIn('employee_details.emp_id', function ($query) use ($loggedInEmpId, $currentDate) {
        $query->select('emp_id')
            ->from('swipe_records')
            ->where('manager_id', $loggedInEmpId)
            ->whereDate('created_at', $currentDate);
    })
    ->whereNotIn('employee_details.emp_id', $approvedLeaveRequests->pluck('emp_id'))
    ->where('employee_details.employee_status', 'active')
    ->where('company_shifts.shift_name', $this->selectedShift) // Ensure shift type matches
    ->get();
                $countOfAbsentEmployees = EmployeeDetails::where('employee_details.manager_id', $loggedInEmpId)
    ->leftJoin('emp_personal_infos', 'employee_details.emp_id', '=', 'emp_personal_infos.emp_id') // Use leftJoin here
    ->select(
        'employee_details.*',
         // Selecting the mobile number from emp_personal_infos, will be null if no match
    )
    ->whereNotIn('employee_details.emp_id', function ($query) use ($loggedInEmpId, $currentDate) {
        $query->select('emp_id')
            ->from('swipe_records')
            ->where('manager_id', $loggedInEmpId)
            ->whereDate('created_at', $currentDate);
    })
    ->whereNotIn('employee_details.emp_id', $approvedLeaveRequests->pluck('emp_id'))
    ->where('employee_details.employee_status', 'active')
    ->where('employee_details.shift_type',$this->selectedShift)
    ->count();
                
            }
        
       
            if(empty($this->selectedShift))
            {
                $swipes = SwipeRecord::whereIn('swipe_records.id', function ($query) use ($employees, $approvedLeaveRequests, $currentDate) {
                    $query->selectRaw('MIN(swipe_records.id)')
                        ->from('swipe_records')
                        ->whereIn('swipe_records.emp_id', $employees->pluck('emp_id'))
                        ->whereNotIn('swipe_records.emp_id', $approvedLeaveRequests->pluck('emp_id'))
                        ->whereDate('swipe_records.created_at', $currentDate)
                        ->groupBy('swipe_records.emp_id');
                })
                ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
              
                ->leftJoin('company_shifts', function ($join) {
                    $join->on(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(employee_details.company_id, '$[0]'))"), '=', 'company_shifts.company_id') // Join on company_id
                         ->whereColumn('employee_details.shift_type', 'company_shifts.shift_name'); // Join on shift_type
                })
                ->select('swipe_records.*', 'employee_details.first_name', 'employee_details.last_name', 'company_shifts.shift_start_time', 'company_shifts.shift_end_time', 'employee_details.emergency_contact', 'company_shifts.shift_name') // Include shift_name in select
                ->where('employee_details.employee_status', 'active')
                ->distinct()
                ->orderBy('swipe_records.swipe_time', 'DESC') // Order by swipe_time in descending order
                ->get();
             
                
       
                $lateSwipesCount = SwipeRecord::whereIn('swipe_records.id', function ($query) use ($employees, $approvedLeaveRequests, $currentDate) {
                    $query->selectRaw('MIN(swipe_records.id)')
                        ->from('swipe_records')
                        ->whereNotIn('swipe_records.emp_id', $approvedLeaveRequests->pluck('emp_id'))
                        ->whereIn('swipe_records.emp_id', $employees->pluck('emp_id'))
                        ->whereDate('swipe_records.created_at', $currentDate)
                        ->groupBy('swipe_records.emp_id');
                })
                ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
                ->leftJoin('emp_personal_infos', 'swipe_records.emp_id', '=', 'emp_personal_infos.emp_id') // Join with emp_personal_infos table
                ->leftJoin('company_shifts', function ($join) {
                    $join->on(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(employee_details.company_id, '$[0]'))"), '=', 'company_shifts.company_id') // Join on company_id
                         ->whereColumn('employee_details.shift_type', 'company_shifts.shift_name'); // Join on shift_type
                })
                ->select(
                    'swipe_records.emp_id',  // Ensure that you are selecting emp_id for distinct comparison
                    'swipe_records.swipe_time',
                    'employee_details.first_name', 
                    'employee_details.last_name',
                    'company_shifts.shift_start_time', // Get shift_start_time from company_shifts
                    'company_shifts.shift_end_time',   // Optionally, include shift_end_time if needed
                    'employee_details.emergency_contact'  // Include fields from emp_personal_infos
                )
                ->whereRaw("swipe_records.swipe_time > company_shifts.shift_start_time") // Compare against company_shifts.shift_start_time
                ->distinct('swipe_records.emp_id') // Apply distinct on emp_id to avoid duplicates
                ->count(); // Count distinct late swipes
           
    $earlySwipesCount = SwipeRecord::whereIn('swipe_records.id', function ($query) use ($employees, $approvedLeaveRequests, $currentDate) {
        $query->selectRaw('MIN(swipe_records.id)')
            ->from('swipe_records')
            ->whereIn('swipe_records.emp_id', $employees->pluck('emp_id'))
            ->whereNotIn('swipe_records.emp_id', $approvedLeaveRequests->pluck('emp_id'))
            ->whereDate('swipe_records.created_at', $currentDate)
            ->groupBy('swipe_records.emp_id');
    })
    ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
    ->leftJoin('emp_personal_infos', 'swipe_records.emp_id', '=', 'emp_personal_infos.emp_id') // Joining emp_personal_infos
    ->leftJoin('company_shifts', function ($join) {
        $join->on(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(employee_details.company_id, '$[0]'))"), '=', 'company_shifts.company_id') // Join on company_id
             ->whereColumn('employee_details.shift_type', 'company_shifts.shift_name'); // Join on shift_type
    })

    ->select(
        'swipe_records.*', 
        'employee_details.first_name', 
        'employee_details.last_name', 
        'employee_details.emergency_contact', // Selecting fields from emp_personal_infos
        'company_shifts.shift_start_time', // Get shift_start_time from company_shifts
        'company_shifts.shift_end_time',
    )
    ->where(function ($query) {
        $query->whereRaw("swipe_records.swipe_time <= company_shifts.shift_start_time"); // Compare against company_shifts.shift_start_time
    })
    ->distinct('swipe_records.emp_id')
    ->count();

            }
            else
            {
                $swipes = SwipeRecord::whereIn('swipe_records.id', function ($query) use ($employees, $approvedLeaveRequests, $currentDate) {
                    $query->selectRaw('MIN(swipe_records.id)')
                        ->from('swipe_records')
                        ->whereIn('swipe_records.emp_id', $employees->pluck('emp_id'))
                        ->whereNotIn('swipe_records.emp_id', $approvedLeaveRequests->pluck('emp_id'))
                        ->whereDate('swipe_records.created_at', $currentDate)
                        ->groupBy('swipe_records.emp_id');
                })
                ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
                ->leftjoin('emp_personal_infos', 'swipe_records.emp_id', '=', 'emp_personal_infos.emp_id')
                ->select('swipe_records.*', 'employee_details.*','employee_details.shift_type')
                ->where('employee_details.shift_type',$this->selectedShift)
                ->where('employee_details.employee_status','active')
                ->get();
           
       
            $lateSwipesCount = SwipeRecord::whereIn('swipe_records.id', function ($query) use ($employees, $approvedLeaveRequests, $currentDate) {
                $query->selectRaw('MIN(swipe_records.id)')
                    ->from('swipe_records')
                    ->whereNotIn('swipe_records.emp_id', $approvedLeaveRequests->pluck('emp_id'))
                    ->whereIn('swipe_records.emp_id', $employees->pluck('emp_id'))
                    ->whereDate('swipe_records.created_at', $currentDate)
                    ->groupBy('swipe_records.emp_id');
            })
            ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
            ->leftjoin('emp_personal_infos', 'swipe_records.emp_id', '=', 'emp_personal_infos.emp_id')  // Join with emp_personal_infos table
            ->select(
                'swipe_records.*', 
                'employee_details.first_name', 
                'employee_details.last_name',
                'employee_details.shift_start_time', 
                'employee_details.shift_end_time',
                'employee_details.emergency_contact'  // Include fields from emp_personal_infos
            )
            ->where(function ($query) {
                $query->whereRaw("swipe_records.swipe_time > employee_details.shift_start_time");
            })
            ->where('employee_details.shift_type',$this->selectedShift)
            ->count();
            $earlySwipesCount = SwipeRecord::whereIn('swipe_records.id', function ($query) use ($employees, $approvedLeaveRequests, $currentDate) {
                $query->selectRaw('MIN(swipe_records.id)')
                    ->from('swipe_records')
                    ->whereIn('swipe_records.emp_id', $employees->pluck('emp_id'))
                    ->whereNotIn('swipe_records.emp_id', $approvedLeaveRequests->pluck('emp_id'))
                    ->whereDate('swipe_records.created_at', $currentDate)
                    ->groupBy('swipe_records.emp_id');
            })
            ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
            ->leftJoin('emp_personal_infos', 'swipe_records.emp_id', '=', 'emp_personal_infos.emp_id') // Joining emp_personal_infos
            ->select(
                'swipe_records.*', 
                'employee_details.first_name', 
                'employee_details.last_name', 
                'employee_details.emergency_contact' // Selecting fields from emp_personal_infos
            )
            ->where(function ($query) {
                $query->whereRaw("swipe_records.swipe_time <= employee_details.shift_start_time");
            })
            ->where('employee_details.shift_type',$this->selectedShift)
            ->count();

            }

    
    
            // $lateSwipesList = SwipeRecord::whereIn('id', function ($query) use ($employees, $approvedLeaveRequests, $currentDate) {
            //     $query->selectRaw('MIN(id)')
            //         ->from('swipe_records')
            //         ->whereNotIn('emp_id', $approvedLeaveRequests->pluck('emp_id'))
            //         ->whereIn('emp_id', $employees->pluck('emp_id'))
            //         ->whereDate('created_at', '2024-09-09')
            //         ->groupBy('emp_id');
            // })
            //     ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
            //     ->select('swipe_records.*', 'employee_details.first_name', 'employee_details.last_name','employee_details.shift_start_time','employee_details.shift_end_time')
            //     ->where(function ($query) {
            //         $query->whereRaw("swipe_records.swipe_time > employee_details.shift_start_time");
            //    })
            //     ->get();
            //     dd($lateSwipesList);
            
    
           
        $swipes2 = SwipeRecord::whereIn('id', function ($query) use ($employees, $currentDate) {
            $query->selectRaw('MIN(id)')
                ->from('swipe_records')
                ->whereIn('emp_id', $employees->pluck('emp_id'))
                ->whereDate('created_at', $currentDate)
                ->groupBy('emp_id');
        })
            ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
            ->select('swipe_records.*', 'employee_details.first_name', 'employee_details.last_name')
            ->get();
        $this->dayShiftEmployeesCount=EmployeeDetails::where('shift_type','GS')->count();
        $this->afternoonShiftEmployeesCount=EmployeeDetails::where('shift_type','AS')->count();
        $this->eveningShiftEmployeesCount=EmployeeDetails::where('shift_type','ES')->count();
        $swipes_count = $swipes2->count();
        $countOfEmployees=
        $employeesCount = $employees1->count();
      
        if($employees2>0)
        {
            $calculateAbsent = ($countOfAbsentEmployees / $employees2) * 100;
            $calculateApprovedLeaves = ($approvedLeaveRequests1 / $employees2) * 100;
        }
        else
        {
            $calculateAbsent = 0;
            $calculateApprovedLeaves = 0;
        }
      
        $nameFilter = $this->search;
        $swipes = $swipes->filter(function ($swipe) use ($nameFilter) {
            return stripos($swipe->first_name, $nameFilter) !== false ||
                stripos($swipe->last_name, $nameFilter) !== false ||
                stripos($swipe->emp_id, $nameFilter) !== false ||
                stripos($swipe->swipe_time, $nameFilter) !== false;
        });
        $employees1 = $employees1->filter(function ($swipe) use ($nameFilter) {
            return stripos($swipe->first_name, $nameFilter) !== false ||
                stripos($swipe->last_name, $nameFilter) !== false ||
                stripos($swipe->emp_id, $nameFilter) !== false ||
                stripos($swipe->swipe_time, $nameFilter) !== false;
        });
        $approvedLeaveRequests = $approvedLeaveRequests->filter(function ($swipe) use ($nameFilter) {
            return stripos($swipe->first_name, $nameFilter) !== false ||
                stripos($swipe->last_name, $nameFilter) !== false ||
                stripos($swipe->emp_id, $nameFilter) !== false ||
                stripos($swipe->swipe_time, $nameFilter) !== false;
        });
        $this->employeesOnLeaveCount=$approvedLeaveRequests->count();
        $this->absentEmployeesCount=$employees1->count();
        $this->notFound = $swipes->isEmpty();
        $this->notFound = $employees1->isEmpty();
        $this->notFound3 = $approvedLeaveRequests->isEmpty();
        return view('livewire.who-is-in-chart', ['Swipes' => $swipes, 'ApprovedLeaveRequests' => $approvedLeaveRequests, 'ApprovedLeaveRequestsCount' => $approvedLeaveRequests1, 'Employees1' => $employees1, 'employeesCount1' => $countOfAbsentEmployees, 'Employess2' => $employees2, 'CalculateAbsentees' => $calculateAbsent, 'CalculateApprovedLeaves' => $calculateApprovedLeaves, 'TotalEmployees' => $employees2, 'currentdate' => $this->currentDate, 'Swipes1' => $swipes_count, 'EarlySwipesCount' => $earlySwipesCount, 'LateSwipesCount' => $lateSwipesCount]);
    }
}
