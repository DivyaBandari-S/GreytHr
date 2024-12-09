<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelWriter;
use App\Models\LeaveRequest;
use App\Models\EmployeeLeaveBalances;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Helpers\LeaveHelper;
use App\Helpers\FlashMessageHelper;

class ReportManagement extends Component
{
    public $currentSection = " ";

    public $searching = 0;

    public $sno;
    public $employeeType='active';
    public $leaveType='all';
    public $search;
    public $fromDate;
    public $sortBy;
    public $toDate;
    public $hireDate;
    public $sickLeavePerYear;
    public $casualLeavePerYear;
    public $casualProbationLeavePerYear;
    public $lossOfPayPerYear;

    public $notFound;

    public $peoples;
    public $transactionType='all';

    public $employees;
    public $dateErrorMessage;
    public $leaveBalance = [];
    public function showContent($section)
    {

        $this->currentSection = $section;
        $this->resetFields();
    }
    public function updateLeaveType()
    {
        $this->leaveType = $this->leaveType;
    }

    public function  updateSortBy()
    {
        $this->sortBy = $this->sortBy;
    }

    public function  updateEmployeeType($event)
    {
        
        $this->employeeType=$event;
    }

    public function closeShiftSummaryReport()
    {
        $this->currentSection = '';
    }
    public function closeAbsentReport()
    {
        $this->currentSection = '';
    }
    public function showContent1($section)
    {

        $this->currentSection = $section;
    }
    public function searchfilter()
    {
        $this->searching = 1;
    }
    public function close()
    {
        $this->currentSection = '';
        $this->resetErrorBag();
        $this->resetFields();
    }

    public function updateFromDate()
    {
        $this->fromDate = $this->fromDate;
    }
    public function updateToDate()
    {
        $this->toDate = $this->toDate;
    }



    public $myTeam;
    protected $rules = [
        'fromDate' => 'required|date',
        'toDate' => 'required|date|after_or_equal:fromDate',
        'leaveType' => 'required',
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->resetErrorBag($propertyName); // Clear errors for the updated property
    }

    public function resetFields()
    {
        $this->fromDate = null;
        $this->toDate = null;
        $this->leaveType = 'all';
        $this->leaveBalance = [];
    }

    public function downloadLeaveAvailedReportInExcel()
    {
        $this->validate([
            'fromDate' => 'required|date',
            'toDate' => 'required|date|after_or_equal:fromDate',
        ], [
            'fromDate.required' => 'From date is required.',
            'toDate.required' => 'To date is required.',
            'toDate.after_or_equal' => 'To date must be a date after or equal to the from date.',
        ]);
        try {
       
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
    
        $query = LeaveRequest::select(
            DB::raw('DATE(from_date) as date_only'),
            DB::raw('count(*) as total_requests'),
            'leave_applications.emp_id',
            'employee_details.first_name',
            'employee_details.last_name',
            'leave_applications.leave_type',
            'leave_applications.from_date as leave_from_date',
            'leave_applications.to_date as leave_to_date',
            'leave_applications.reason',
            'leave_applications.created_at',
            'leave_applications.from_session',
            'leave_applications.to_session',
            'leave_applications.leave_status',
            'leave_applications.updated_at',
        )
        ->join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
        ->where('leave_applications.leave_status', 2)
        ->when($this->leaveType && $this->leaveType != 'all', function ($query) {

            $leaveTypes = [
                'lop' => 'Loss of Pay',
                'casual_leave' => 'Casual Leave',
                'sick' => 'Sick Leave',
                'petarnity' => 'Petarnity Leave',
                'casual_leave_probation' => 'Casual Leave Probation',
                'maternity' => 'Maternity Leave',
                'marriage_leave' => 'Marriage Leave',
            ];

            if (array_key_exists($this->leaveType, $leaveTypes)) {
                $query->where('leave_applications.leave_type', $leaveTypes[$this->leaveType]);
            }
        })
        ->where(function ($query) use ($loggedInEmpId) {
            $query->whereJsonContains('applying_to', [['manager_id' => $loggedInEmpId]])
                ->orWhereJsonContains('cc_to', [['emp_id' => $loggedInEmpId]]);
        })
        ->where(function ($query) {
            $query->whereBetween('from_date', [$this->fromDate, $this->toDate])
                ->orWhereBetween('to_date', [$this->fromDate, $this->toDate])
                ->orWhere(function ($query) {
                    $query->where('from_date', '<=', $this->toDate)
                        ->where('to_date', '>=', $this->fromDate);
                });
        });
    
        if ($this->employeeType == 'active') {
            $query->where(function ($query) {
                $query->where('employee_details.employee_status', 'active')
                      ->orWhere('employee_details.employee_status', 'on-probation');
            });
        } else {
            $query->where(function ($query) {
                $query->where('employee_details.employee_status', 'resigned')
                    ->orWhere('employee_details.employee_status', 'terminated');
            });
        }
    
        $query = $query->groupBy(
            'date_only',
            'leave_applications.emp_id',
            'employee_details.first_name',
            'employee_details.last_name',
            'leave_applications.leave_type',
            'leave_applications.from_date',
            'leave_applications.to_date',
            'leave_applications.reason',
            'leave_applications.created_at',
            'leave_applications.from_session',
            'leave_applications.to_session',
            'leave_applications.leave_status',
            'leave_applications.updated_at',
        )
        ->orderBy('date_only', 'asc')
        ->get();
       
    
    
        // Aggregate data by date
        $aggregatedData = $query->groupBy('date_only')->map(function ($group) {
            return [
                'date' => Carbon::parse($group->first()->date_only)->format('d M Y'),
                'details' => $group->map(function ($item) {
                    $leaveRequest = new LeaveRequest();
                    $leaveDays = $leaveRequest->calculateLeaveDays(
                        $item->leave_from_date,
                        $item->from_session,
                        $item->leave_to_date,
                        $item->to_session,
                        $item->leave_type
                    );
                    return [
                        'emp_id' => $item->emp_id,
                        'first_name' => $item->first_name,
                        'last_name' => $item->last_name,
                        'leave_type' => $item->leave_type,
                        'leave_from_date' => $item->leave_from_date,
                        'leave_to_date' => $item->leave_to_date,
                        'reason' => $item->reason,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at,
                        'from_session' => $item->from_session,
                        'to_session' => $item->to_session,
                        'leave_days' => $leaveDays,
                        'leave_status' => $item->status,
                    ];
                })
            ];
        });
 
    
        $employeeDetails = EmployeeDetails::where('emp_id', $loggedInEmpId)->first();
        $pdf = Pdf::loadView('leaveAvailedReportPdf', [
            'employeeDetails' => $employeeDetails,
            'leaveTransactions' => $aggregatedData,
            'fromDate' => $this->fromDate,
            'toDate' => $this->toDate,
        ]);
        FlashMessageHelper::flashSuccess('Leave Availed Report Downloaded Successfully!');
    
        return response()->streamDownload(function() use($pdf) {
            echo $pdf->stream();
        }, 'leave_availed_report.pdf');
    } catch (\Exception $e) {
      
        Log::error('Error generating Leave Availed Report', [
            'exception' => $e, // Logs the exception details
        ]);
        // Optionally, return a user-friendly error message
        FlashMessageHelper::flashError('An error occurred while generating the report. Please try again.');
    }

        
    }

    public $filteredEmployees;

    public function searchfilterleave()
    {
        $this->searching = 1;
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->get();
        $nameFilter = $this->search;

        $filteredEmployees = $employees->filter(function ($employee) use ($nameFilter) {
            return stripos($employee->first_name, $nameFilter) !== false ||
                stripos($employee->last_name, $nameFilter) !== false ||
                stripos($employee->emp_id, $nameFilter) !== false ||
                stripos($employee->job_title, $nameFilter) !== false ||
                stripos($employee->city, $nameFilter) !== false ||
                stripos($employee->state, $nameFilter) !== false;
        });

        if ($filteredEmployees->isEmpty()) {
            $this->notFound = true;
        } else {
            $this->notFound = false;
        }
    }

public  function updateTransactionType($event){
    $this->transactionType=$event;

}


    public function dayWiseLeaveTransactionReport()
    {
        $this->validate([
            'fromDate' => 'required|date',
            'toDate' => 'required|date|after_or_equal:fromDate',
            'transactionType' => 'required',
            'employeeType' => 'required',
        ],
         [
            'fromDate.required' => 'From date is required.',
            'toDate.required' => 'To date is required.',
            'toDate.after_or_equal' => 'To date must be a date after or equal to the from date.',
            'transactionType.required' => 'Leave type is required.',
            'employeeType.required' => 'Employee type is required.',
        ]);
        try{

        // dd($this->fromDate,$this->toDate,$this->transactionType,$this->employeeType);

        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $transactionTypeMap = [
            'availed' => 2,    // Availed maps to 2 in DB
            'rejected' => 3,   // Rejected maps to 3 in DB
            'withdrawn' => 4,  // Withdrawn maps to 4 in DB
        ];

        $transactionFilter = null;

        // Handle granted status - If 'Granted' is selected, do special handling
        if ($this->transactionType === 'Granted') {
            // Add logic to filter based on granted status (e.g., from employee_leave_balances table)
            // Assuming 'status' is 'Granted' in employee_leave_balances
            $transactionFilter = 'Granted';
        }

        // Handle lapsed status - If 'Lapsed' is selected, do special handling
        if ($this->transactionType === 'is_lapsed') {
            // Add logic to filter based on lapsed status (e.g., where 'is_lapsed' is 1)
            $transactionFilter = 'Lapsed';
        }

        // Handle other status filters
        if ($this->transactionType !== 'all' && !in_array($this->transactionType, ['Granted', 'is_lapsed'])) {
            $transactionFilter = $transactionTypeMap[$this->transactionType] ?? null;
        }

        $query = LeaveRequest::select(
            DB::raw('DATE(from_date) as date_only'), // Extract date part only
            DB::raw('count(*) as total_requests'), // Aggregate function to count requests
            'leave_applications.emp_id',
            'employee_details.first_name',
            'employee_details.last_name',
            'leave_applications.leave_type',
            'leave_applications.from_date as leave_from_date',
            'leave_applications.to_date as leave_to_date',
            'leave_applications.reason',
            'leave_applications.from_session',
            'leave_applications.to_session',
            'leave_applications.leave_status',
            'employee_leave_balances.status as leave_balance_status',
            'employee_leave_balances.is_lapsed as lapsed_status',
        )
            // ->where('leave_applications.status', 'approved')
            ->where(function ($query) use ($loggedInEmpId) {
                $query->whereJsonContains('applying_to', [['manager_id' => $loggedInEmpId]])
                    ->orWhereJsonContains('cc_to', [['emp_id' => $loggedInEmpId]]);
            })
            ->where(function ($query) {
                $query->whereBetween('from_date', [$this->fromDate, $this->toDate])
                    ->orWhereBetween('to_date', [$this->fromDate, $this->toDate])
                    ->orWhere(function ($query) {
                        $query->where('from_date', '<=', $this->toDate)
                            ->where('to_date', '>=', $this->fromDate);
                    });
            })
            ->join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
            ->join('employee_leave_balances', 'leave_applications.emp_id', '=', 'employee_leave_balances.emp_id')  
            ->groupBy('date_only', 'leave_applications.emp_id', 'employee_details.first_name', 'employee_details.last_name', 'leave_applications.leave_type', 'leave_applications.from_date', 'leave_applications.to_date', 'leave_applications.reason', 'leave_applications.from_session', 'leave_applications.to_session','leave_applications.leave_status','employee_leave_balances.status','employee_leave_balances.is_lapsed'); // Group by the date-only field

            // if ($this->transactionType !== 'all') {
            //     $query->where('leave_applications.leave_status', $this->transactionType);
            // }

            if ($transactionFilter !== null) {
                if ($transactionFilter === 'Granted') {

                    // Logic for filtering Granted (for example from the employee_leave_balances table)
                    $query->where('employee_leave_balances.status', $transactionFilter);
                } elseif ($transactionFilter === 'Lapsed') {
                    $query->where('employee_leave_balances.is_lapsed', 1);
                } else {
                    $query->where('leave_applications.leave_status', $transactionFilter);
                }
            }
    
           if($this->employeeType=='active'){
            $query->where(function ($query) {
                $query->where('employee_details.employee_status', 'active')
                      ->orWhere('employee_details.employee_status', 'on-probation');
            });
           }else{
            $query->where(function ($query) {
                $query->where('employee_details.employee_status', 'resigned')
                    ->orWhere('employee_details.employee_status', 'terminated');
            });
           }
         

            $query = $query->orderBy('date_only', 'asc')
            ->get();
   

        // Aggregate data by date
        $aggregatedData = $query->groupBy('date_only')->map(function ($group) {
            return [
                'date' => Carbon::parse($group->first()->date_only)->format('d M Y'),
                // 'total_requests' => $group->sum('total_requests'),
                'details' => $group->map(function ($item) {
                    $leaveRequest = new LeaveRequest();
                    $leaveDays = $leaveRequest->calculateLeaveDays(
                        $item->leave_from_date,
                        $item->from_session,
                        $item->leave_to_date,
                        $item->to_session,
                        $leaveRequest->leave_type
                    );
                    return [
                        'emp_id' => $item->emp_id,
                        'first_name' => $item->first_name,
                        'last_name' => $item->last_name,
                        'leave_type' => $item->leave_type,
                        'leave_from_date' => $item->leave_from_date,
                        'leave_to_date' => $item->leave_to_date,
                        'reason' => $item->reason,
                        'from_session' => $item->from_session,
                        'to_session' => $item->to_session,
                        'leave_days' => $leaveDays,
                        'leave_status'=>$item->leave_status,
                    ];
                })
            ];
        });

        $employeeDetails = EmployeeDetails::where('emp_id', $loggedInEmpId)->first();
        $pdf = Pdf::loadView('daywiseLeaveTransactionReportPdf', [
            'employeeDetails' => $employeeDetails,
            'leaveTransactions' => $aggregatedData,
            'fromDate' => $this->fromDate,
            'toDate' => $this->toDate,
            'transactionFilter' => $transactionFilter,
        ]);
        FlashMessageHelper::flashSuccess('DayWise Leave Transaction Report Downloaded Successfully!');

        return response()->streamDownload(function() use($pdf){
            echo $pdf->stream();
        }, 'Daywise_leave_transactions.pdf');
    } catch (\Exception $e) {
      
        Log::error('Error generating Leave Availed Report', [
            'exception' => $e, // Logs the exception details
        ]);
        // Optionally, return a user-friendly error message
        FlashMessageHelper::flashError('An error occurred while generating the report. Please try again.');
    }
    }
  


public function leaveBalanceAsOnADayReport()
{
    $this->validate([
        'toDate' => 'required|date',
    ], [
        'toDate.required' => 'Date is required.',
    ]);
try{

    // Validate the 'toDate' input
  
    

    // Check if any employees are selected
    if (empty($this->leaveBalance)) {
        return redirect()->back()->with('error', 'Select at least one employee detail');
    } else {

        // Fetch employee details for selected employees
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;

        $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)
            ->whereIn('emp_id', $this->leaveBalance)
            ->select('emp_id', 'first_name', 'last_name')
            ->get();
   
          
            $combinedData = $employees->map(function ($employee) {
                $leaveBalances = ReportManagement::getLeaveBalances($employee->emp_id, $this->toDate);
               
      
                return [
                    'emp_id' => $employee->emp_id,
                    'first_name' => $employee->first_name,
                    'last_name' => $employee->last_name,
                    'sick_leave_balance' => $leaveBalances['sickLeaveBalance'] ?? 0,
                    'casual_leave_balance' => $leaveBalances['casualLeaveBalance'] ?? 0,
                    'casual_leave_probation_balance' => $leaveBalances['casualProbationLeaveBalance'] ?? 0,
                    'loss_of_pay_balance' => $leaveBalances['lossOfPayBalance'] ?? 0,
                ];
            });
   
        
            $employeeDetails = EmployeeDetails::where('emp_id', $loggedInEmpId)->first();

            $pdf = Pdf::loadView('leaveBalanceAsOnDayReport', [
                'employeeDetails' => $employeeDetails,
                'leaveTransactions' => $combinedData,
                'fromDate' => $this->fromDate,
                'toDate' => $this->toDate,
            ]);
        
            return response()->streamDownload(function() use ($pdf) {
                echo $pdf->stream();
            }, 'leave_balance_as_on_a_day.pdf');
        }
    } catch (\Exception $e) {
      

        // Optionally, return a user-friendly error message
        FlashMessageHelper::flashError('An error occurred while generating the report. Please try again.');
    }
    
}



   
    public function downloadLeaveTransactionReport()
    {
        try{
  
        $this->validate([
            'fromDate' => 'required|date',
            'toDate' => 'required|date|after_or_equal:fromDate',
        ], [
            'fromDate.required' => 'From date is required.',
            'toDate.required' => 'To date is required.',
            'toDate.after_or_equal' => 'To date must be a date after or equal to the from date.',
        ]);
    
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
    
        $query = LeaveRequest::select(
            DB::raw('DATE(from_date) as date_only'),
            DB::raw('count(*) as total_requests'),
            'leave_applications.emp_id',
            'employee_details.first_name',
            'employee_details.last_name',
            'leave_applications.leave_type',
            'leave_applications.from_date as leave_from_date',
            'leave_applications.to_date as leave_to_date',
            'leave_applications.reason',
            'leave_applications.created_at',
            'leave_applications.from_session',
            'leave_applications.to_session',
            'leave_applications.leave_status'
        )
        ->join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
        ->when($this->leaveType && $this->leaveType != 'all', function ($query) {
           
            $leaveTypes = [
                'lop' => 'Loss of Pay',
                'casual_leave' => 'Casual Leave',
                'sick' => 'Sick Leave',
                'petarnity' => 'Petarnity Leave',
                'casual_leave_probation' => 'Casual Leave Probation',
                'maternity' => 'Maternity Leave',
                'marriage_leave' => 'Marriage Leave',
            ];

            if (array_key_exists($this->leaveType, $leaveTypes)) {
                $query->where('leave_applications.leave_type', $leaveTypes[$this->leaveType]);
            }
        })
        ->where(function ($query) use ($loggedInEmpId) {
            $query->whereJsonContains('applying_to', [['manager_id' => $loggedInEmpId]])
                ->orWhereJsonContains('cc_to', [['emp_id' => $loggedInEmpId]]);
        })
        ->where(function ($query) {
            $query->whereBetween('from_date', [$this->fromDate, $this->toDate])
                ->orWhereBetween('to_date', [$this->fromDate, $this->toDate])
                ->orWhere(function ($query) {
                    $query->where('from_date', '<=', $this->toDate)
                        ->where('to_date', '>=', $this->fromDate);
                });
        });
    
        if ($this->transactionType === 'availed') {
            $query->where('leave_applications.leave_status', 2);
        }
        if ($this->transactionType === 'rejected') {
            $query->where('leave_applications.leave_status', 3);
        }
        
        if ($this->transactionType === 'withdrawn') {
            $query->where('leave_applications.leave_status', 4);
        }
        
        if ($this->transactionType === 'all') {
            $query->whereIn('leave_applications.leave_status', [2, 3, 4]);
        }
    
        if ($this->employeeType == 'active') {
            $query->where(function ($query) {
                $query->where('employee_details.employee_status', 'active')
                      ->orWhere('employee_details.employee_status', 'on-probation');
            });
        } else {
            $query->where(function ($query) {
                $query->where('employee_details.employee_status', 'resigned')
                    ->orWhere('employee_details.employee_status', 'terminated');
            });
        }
    
        $query = $query->groupBy(
            'date_only',
            'leave_applications.emp_id',
            'employee_details.first_name',
            'employee_details.last_name',
            'leave_applications.leave_type',
            'leave_applications.from_date',
            'leave_applications.to_date',
            'leave_applications.reason',
            'leave_applications.created_at',
            'leave_applications.from_session',
            'leave_applications.to_session',
            'leave_applications.leave_status'
        )
        ->orderBy('date_only', 'asc')
        ->get();
       
    
       
    
        // Aggregate data by date
        $aggregatedData = $query->groupBy('date_only')->map(function ($group) {
            return [
                'date' => Carbon::parse($group->first()->date_only)->format('d M Y'),
                'details' => $group->map(function ($item) {
                    $leaveRequest = new LeaveRequest();
                    $leaveDays = $leaveRequest->calculateLeaveDays(
                        $item->leave_from_date,
                        $item->from_session,
                        $item->leave_to_date,
                        $item->to_session,
                        $item->leave_type
                    );
                    return [
                        'emp_id' => $item->emp_id,
                        'first_name' => $item->first_name,
                        'last_name' => $item->last_name,
                        'leave_type' => $item->leave_type,
                        'leave_from_date' => $item->leave_from_date,
                        'leave_to_date' => $item->leave_to_date,
                        'reason' => $item->reason,
                        'created_at' => $item->created_at,
                        'from_session' => $item->from_session,
                        'to_session' => $item->to_session,
                        'leave_days' => $leaveDays,
                        'leave_status' => $item->status,
                    ];
                })
            ];
        });
    
        $employeeDetails = EmployeeDetails::where('emp_id', $loggedInEmpId)->first();
        $pdf = Pdf::loadView('leaveTransactionReportPdf', [
            'employeeDetails' => $employeeDetails,
            'leaveTransactions' => $aggregatedData,
            'fromDate' => $this->fromDate,
            'toDate' => $this->toDate,
        ]);
        FlashMessageHelper::flashSuccess('Leave Transaction Report Downloaded Successfully!');
    
        return response()->streamDownload(function() use($pdf) {
            echo $pdf->stream();
        }, 'leave_transactions_report.pdf');
    } catch (\Exception $e) {
      

        // Optionally, return a user-friendly error message
        FlashMessageHelper::flashError('An error occurred while generating the report. Please try again.');
    }
    }
    
    public function downloadNegativeLeaveBalanceReport()
    {
        $this->validate([
            'toDate' => 'required|date',
        ], [
            'toDate.required' => 'Date is required.',
        ]);
        try
        {

       
    
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
    
        $query = LeaveRequest::select(
            DB::raw('DATE(to_date) as date_only'),
            DB::raw('count(*) as total_requests'),
            'leave_applications.emp_id',
            'employee_details.first_name',
            'employee_details.last_name',
            'employee_details.hire_date',
            'employee_details.job_role',
            'leave_applications.leave_type',
            'leave_applications.from_date as leave_from_date',
            'leave_applications.to_date as leave_to_date',
            'leave_applications.from_session',
            'leave_applications.to_session',
            'leave_applications.leave_status'
        )
        ->join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
        ->when($this->leaveType && $this->leaveType != 'all', function ($query) {
           
            $leaveTypes = [
                'lop' => 'Loss of Pay',
                'casual_leave' => 'Casual Leave',
                'sick' => 'Sick Leave',
                'petarnity' => 'Petarnity Leave',
                'casual_leave_probation' => 'Casual Leave Probation',
                'maternity' => 'Maternity Leave',
                'marriage_leave' => 'Marriage Leave',
            ];

            if (array_key_exists($this->leaveType, $leaveTypes)) {
                $query->where('leave_applications.leave_type', $leaveTypes[$this->leaveType]);
            }
        })
        ->where(function ($query) use ($loggedInEmpId) {
            $query->whereJsonContains('applying_to', [['manager_id' => $loggedInEmpId]])
                ->orWhereJsonContains('cc_to', [['emp_id' => $loggedInEmpId]]);
        })
        ->where('to_date', '<=', $this->toDate)
        ->where('leave_applications.leave_status', 2);

       
    
    
        if ($this->employeeType == 'active') {
            $query->where(function ($query) {
                $query->where('employee_details.employee_status', 'active')
                      ->orWhere('employee_details.employee_status', 'on-probation');
            });
        } else {
            $query->where(function ($query) {
                $query->where('employee_details.employee_status', 'resigned')
                    ->orWhere('employee_details.employee_status', 'terminated');
            });
        }
       
       
    
        $query = $query->groupBy(
            'date_only',
            'leave_applications.emp_id',
            'employee_details.first_name',
            'employee_details.last_name',
            'employee_details.hire_date',
            'employee_details.job_role',
            'leave_applications.leave_type',
            'leave_applications.to_date',
            'leave_applications.from_date',
            'leave_applications.from_session',
            'leave_applications.to_session',
            'leave_applications.leave_status',
        )
        ->orderBy('date_only', 'asc')
        ->get();
        

       

 
       
    
        // Aggregate data by date
        $aggregatedData = $query->groupBy('date_only')->map(function ($group) {
            return [
                'date' => Carbon::parse($group->first()->date_only)->format('d M Y'),
                'details' => $group->map(function ($item) {
                    $leaveRequest = new LeaveRequest();
                    $leaveDays = $leaveRequest->calculateLeaveDays(
                        $item->leave_from_date,
                        $item->from_session,
                        $item->leave_to_date,
                        $item->to_session,
                        $item->leave_type
                    );
                    return [
                        'emp_id' => $item->emp_id,
                        'first_name' => $item->first_name,
                        'last_name' => $item->last_name,
                        'hire_date' => $item->hire_date,
                        'job_role' => $item->job_role,
                        'leave_type' => $item->leave_type,
                        'leave_from_date' => $item->leave_from_date,
                        'leave_to_date' => $item->leave_to_date,
                        'from_session' => $item->from_session,
                        'to_session' => $item->to_session,
                        'leave_days' => $leaveDays,
                        'leave_status' => $item->status,
                    ];
                })
            ];
        });
       
     

    
        $employeeDetails = EmployeeDetails::where('emp_id', $loggedInEmpId)->first();
        $pdf = Pdf::loadView('negativeLeaveBalanceReportPdf', [
            'employeeDetails' => $employeeDetails,
            'leaveTransactions' => $aggregatedData,
            'fromDate' => $this->fromDate,
            'toDate' => $this->toDate,
        ]);
        FlashMessageHelper::flashSuccess('Negative Leave Balance Report Downloaded Successfully!');
    
        return response()->streamDownload(function() use($pdf) {
            echo $pdf->stream();
        }, 'negative_leave_balance_report.pdf');
       
    } catch (\Exception $e) {
      

        // Optionally, return a user-friendly error message
        FlashMessageHelper::flashError('An error occurred while generating the report. Please try again.');
    }
    }
    public $totalCasualDays;
    public $totalSickDays;
    public $totalLossOfPayDays;
    public $totalCasualLeaveProbationDays;
    public $sickLeaveBalance;
    public $casualLeaveBalance;
    public $casualProbationLeaveBalance;
    public $lossOfPayBalance;
    public $currentYear;
    public $selectedYear;
    public function render()
    {
       
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
      
 
       
        $search = '';
        if ($this->searching == 1) {
            $this->employees = EmployeeDetails::where('manager_id', $loggedInEmpId)
            ->join('emp_parent_details', 'employee_details.emp_id', '=', 'emp_parent_details.emp_id')
            ->select('employee_details.*', 'emp_parent_details.*')
            ->where(function($query) use ($search) {
                $query->where('employee_details.first_name', 'like', '%' . $search . '%')
                      ->orWhere('employee_details.last_name', 'like', '%' . $search . '%')
                      ->orWhere('emp_parent_details.mother_occupation', 'like', '%' . $search . '%')
                      ->orWhere('emp_parent_details.father_occupation', 'like', '%' . $search . '%');
            })
            ->get();
        }
        else
        {
            $this->employees = EmployeeDetails::where('manager_id', $loggedInEmpId)
        ->join('emp_parent_details', 'employee_details.emp_id', '=', 'emp_parent_details.emp_id')
        ->select('employee_details.*', 'emp_parent_details.*')
        ->get();
        }

        // For Leave Balance On Day


        $this->employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->get();
        if ($this->searching == 1) {
            $nameFilter = $this->search; // Assuming $this->search contains the name filter
            $this->filteredEmployees = $this->employees->filter(function ($employee) use ($nameFilter) {
                return stripos($employee->first_name, $nameFilter) !== false ||
                    stripos($employee->last_name, $nameFilter) !== false ||
                    stripos($employee->emp_id, $nameFilter) !== false ||
                    stripos($employee->job_title, $nameFilter) !== false ||
                    stripos($employee->city, $nameFilter) !== false ||
                    stripos($employee->state, $nameFilter) !== false;
            });


            if ($this->filteredEmployees->isEmpty()) {
                $this->notFound = true; // Set a flag indicating that the name was not found
            } else {
                $this->notFound = false;
            }
        } else {
            $this->filteredEmployees = $this->employees;
        }

        return view('livewire.report-management',[
            'employeetype'=>$this->employeeType,
        ]);
    }
    public static function getLeaveBalances($employeeId, $selectedYear)
    {
        try {
         
          
            // $selectedYear = now()->year;
            $employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
            $sickLeavePerYear = EmployeeLeaveBalances::getLeaveBalancePerYear($employeeId, 'Sick Leave', $selectedYear);
            $casualLeavePerYear = EmployeeLeaveBalances::getLeaveBalancePerYear($employeeId, 'Casual Leave', $selectedYear);
            $casualProbationLeavePerYear = EmployeeLeaveBalances::getLeaveBalancePerYear($employeeId, 'Casual Leave Probation', $selectedYear);
            $lossOfPayPerYear = EmployeeLeaveBalances::getLeaveBalancePerYear($employeeId, 'Loss Of Pay', $selectedYear);

            if (!$employeeDetails) {
                return null;
            }

            // Get the logged-in employee's approved leave days for all leave types
            $approvedLeaveDays = LeaveHelper::getApprovedLeaveDaysOnSelectedDay($employeeId, $selectedYear);

            // Calculate leave balances
            $sickLeaveBalance = $sickLeavePerYear - $approvedLeaveDays['totalSickDays'];
            $casualLeaveBalance = $casualLeavePerYear - $approvedLeaveDays['totalCasualDays'];
            $lossOfPayBalance = $approvedLeaveDays['totalLossOfPayDays'];
            $casualProbationLeaveBalance = $casualProbationLeavePerYear - $approvedLeaveDays['totalCasualLeaveProbationDays'];

            return [
                'sickLeaveBalance' => $sickLeaveBalance,
                'casualLeaveBalance' => $casualLeaveBalance,
                'lossOfPayBalance' => $lossOfPayBalance,
                'casualProbationLeaveBalance' => $casualProbationLeaveBalance,
            ];
        } catch (\Exception $e) {
            if ($e instanceof \Illuminate\Database\QueryException) {
                // Handle database query exceptions
                Log::error("Database error in getLeaveBalances(): " . $e->getMessage());
                session()->flash('emp_error', 'Database connection error occurred. Please try again later.');
            } else {
                Log::error("Error in getLeaveBalances(): " . $e->getMessage());
                session()->flash('emp_error', 'Failed to retrieve leave balances. Please try again later.');
            }
            return null;
        }
    }
   
}
