<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EmployeeDetails;
use App\Models\LeaveRequest;
use App\Models\EmployeeLeaveBalances;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CasualLeaveBalance extends Component
{
    public $leaveData, $year, $currentYear;
    public $employeeLeaveBalances;
    public $employeeleaveavlid;
    public $employeeLapsedBalance;
    public $lapsedLeavesCount;
    public $grantedLeavesCount ;
    public $totalSickDays = 0;
    public $employeeDetails;
    public $employeeLapsedBalanceList;
    public $Availablebalance, $leaveGrantedData, $availedLeavesCount;
    public $lapsedBalance;
    public $casualLeaveGrantDays;
    public $employeeLeaveBalancesData;
    public $employeeLapsedBalanceData;

    // public function mount(){
    //     $totalSickDays = 0;
    //     foreach ($approvedLeaveRequests as $leaveRequest) {
    //         $leaveType = $leaveRequest->leave_type;
    //         $days = self::calculateNumberOfDays(
    //             $leaveRequest->from_date,
    //             $leaveRequest->from_session,
    //             $leaveRequest->to_date,
    //             $leaveRequest->to_session
    //         );
    //     }
    //     //dd($employeeLeaveBalances,$employeeleaveavlid);
    // }

    ///calculate number of days
    public function calculateNumberOfDays($fromDate, $fromSession, $toDate, $toSession, $leaveType)
    {
        try {
            $startDate = Carbon::parse($fromDate);
            $endDate = Carbon::parse($toDate);

            // Check if the start or end date is a weekend
            if ($startDate->isWeekend() || $endDate->isWeekend()) {
                return 0;
            }

            // Check if the start and end sessions are different on the same day
            if (
                $startDate->isSameDay($endDate) &&
                $this->getSessionNumber($fromSession) === $this->getSessionNumber($toSession)
            ) {
                // Inner condition to check if both start and end dates are weekdays
                if (!$startDate->isWeekend() && !$endDate->isWeekend()) {
                    return 0.5;
                } else {
                    // If either start or end date is a weekend, return 0
                    return 0;
                }
            }

            if (
                $startDate->isSameDay($endDate) &&
                $this->getSessionNumber($fromSession) !== $this->getSessionNumber($toSession)
            ) {
                // Inner condition to check if both start and end dates are weekdays
                if (!$startDate->isWeekend() && !$endDate->isWeekend()) {
                    return 1;
                } else {
                    // If either start or end date is a weekend, return 0
                    return 0;
                }
            }

            $totalDays = 0;

            while ($startDate->lte($endDate)) {
                if ($leaveType == 'Sick Leave') {
                    $totalDays += 1;
                } else {
                    if ($startDate->isWeekday()) {
                        $totalDays += 1;
                    }
                }
                // Move to the next day
                $startDate->addDay();
            }

            // Deduct weekends based on the session numbers
            if ($this->getSessionNumber($fromSession) > 1) {
                $totalDays -= $this->getSessionNumber($fromSession) - 1; // Deduct days for the starting session
            }
            if ($this->getSessionNumber($toSession) < 2) {
                $totalDays -= 2 - $this->getSessionNumber($toSession); // Deduct days for the ending session
            }
            // Adjust for half days
            if ($this->getSessionNumber($fromSession) === $this->getSessionNumber($toSession)) {
                // If start and end sessions are the same, check if the session is not 1
                if ($this->getSessionNumber($fromSession) !== 1) {
                    $totalDays += 0.5; // Add half a day
                } else {
                    $totalDays += 0.5;
                }
            } elseif ($this->getSessionNumber($fromSession) !== $this->getSessionNumber($toSession)) {
                if ($this->getSessionNumber($fromSession) !== 1) {
                    $totalDays += 1; // Add half a day
                }
            } else {
                $totalDays += ($this->getSessionNumber($toSession) - $this->getSessionNumber($fromSession) + 1) * 0.5;
            }

            return $totalDays;
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }


    private static function getSessionNumber($session)
    {
        // You might need to customize this based on your actual session values
        return (int) str_replace('Session ', '', $session);
    }

    public function changeYear($year)
    {
        return redirect()->to("/leave-balances/casualleavebalance?year={$year}");
    }

    public function render()
    {
        $this->currentYear = date('Y');
        $this->year = request()->query('year') ?? date('Y');

        // $this->yearDropDown();
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
        $this->leaveGrantedData =  EmployeeLeaveBalances::where('emp_id', $employeeId)
            ->where('period', 'like', "%$this->year%")
            ->selectRaw("*, JSON_UNQUOTE(JSON_EXTRACT(leave_policy_id, '$[*].leave_name')) AS leave_name") // Get all columns and also leave_name for filtering
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(leave_policy_id, '$[*].leave_name')) LIKE '%Casual Leave%'") // Filter based on Casual Leave
            ->get();

        // dd( $this->leaveGrantedData);

        $this->employeeLeaveBalancesData = EmployeeLeaveBalances::where('emp_id', $employeeId)
            ->where('period', 'like', "%$this->year%")
            ->get();

        if ($this->employeeLeaveBalancesData) {
            foreach ($this->employeeLeaveBalancesData as $balance) {
                // Decode the leave_policy_id JSON field
                $leavePolicyData = json_decode($balance->leave_policy_id, true);

                // Loop through each leave policy to check for 'Casual Leave'
                foreach ($leavePolicyData as $leavePolicy) {
                    if (isset($leavePolicy['leave_name']) && $leavePolicy['leave_name'] === 'Casual Leave') {
                        // If found, get the grant_days and process
                        $this->casualLeaveGrantDays += ($leavePolicy['grant_days'] ?? 0);
                    }
                }
            }
        }
        $this->casualLeaveGrantDays = round($this->casualLeaveGrantDays, 2);

        // Now $employeeLeaveBalances contains all the rows from employee_leave_balances
        // where emp_id matches and leave_type is "Sick Leave"
        $this->employeeleaveavlid = LeaveRequest::where('emp_id', $employeeId)
            ->whereYear('from_date', '<=', $this->year)   // Check if the from_date year is less than or equal to the given year
            ->whereYear('to_date', '>=', $this->year)
            ->where('leave_type', 'Casual Leave')
            // ->where(function ($query) {
            //     $query->whereIn('status', ['approved', 'rejected','Withdrawn','Pending'])  // Include both approved and rejected statuses
            //         ->whereIn('cancel_status', ['Re-applied', 'Pending Leave Cancel', 'rejected', 'Withdrawn','Pending','approved']);
            // })
            ->orderBy('created_at', 'desc')
            ->get();

        // dd(  $this->employeeleaveavlid);

        foreach ($this->employeeleaveavlid as $leaveRequest) {
            //$leaveType = $leaveRequest->leave_type;
            $days = self::calculateNumberOfDays(
                $leaveRequest->from_date,
                $leaveRequest->from_session,
                $leaveRequest->to_date,
                $leaveRequest->to_session,
                $leaveRequest->leave_type
            );
            if ($leaveRequest->leave_status == '2' && $leaveRequest->cancel_status != '2 ' &&  $leaveRequest->category_type == 'Leave') {
                $this->totalSickDays += $days;
            }

            // $this->Availablebalance = $this->employeeLeaveBalances->leave_balance - $this->totalSickDays;
        }
        // foreach ($this->employeeLeaveBalances as $employeeLeaveBalance) {
        //     $this->Availablebalance = $this->employeeLeaveBalance->leave_balance - $this->totalSickDays;

        // }
        $this->employeeLapsedBalance = EmployeeLeaveBalances::where('emp_id', $employeeId)
            ->where('period', 'like', "%$this->year%")
            ->selectRaw("*, JSON_UNQUOTE(JSON_EXTRACT(leave_policy_id, '$[*].leave_name')) AS leave_name") // Get all columns and also leave_name for filtering
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(leave_policy_id, '$[*].leave_name')) LIKE '%Casual Leave%'") // Filter based on Casual Leave
            ->get();

        $this->Availablebalance = $this->casualLeaveGrantDays - $this->totalSickDays;

        $this->employeeLapsedBalanceList =  EmployeeLeaveBalances::where('emp_id', $employeeId)
            ->where('period', 'like', "%$this->year%")
            ->selectRaw("*, JSON_UNQUOTE(JSON_EXTRACT(leave_policy_id, '$[*].leave_name')) AS leave_name") // Get all columns and also leave_name for filtering
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(leave_policy_id, '$[*].leave_name')) LIKE '%Casual Leave%'") // Filter based on Casual Leave
            ->get();

        $currentMonth = date('n');
        $lastmonth = 12;
        $currentYear = date('Y');

        $startingMonth = 1; // January

        $grantedLeavesByMonth = [];
        $availedLeavesByMonth = [];
        $lapsedLeavesByMonth = []; // Add this for lapsed leaves

        $grantedLeavesCountData =  EmployeeLeaveBalances::where('emp_id', $employeeId)
            ->where('period', 'like', "%$this->year%")
            ->get();
            $grantedLeavesCount = 0;
            if (!$grantedLeavesCountData->isEmpty()) {
            foreach ($grantedLeavesCountData as $balance) {
                // Decode the leave_policy_id JSON field
                $leavePolicyData = json_decode($balance->leave_policy_id, true);

                // Loop through each leave policy to check for 'Casual Leave'
                foreach ($leavePolicyData as $leavePolicy) {
                    if (isset($leavePolicy['leave_name']) && $leavePolicy['leave_name'] === 'Casual Leave') {
                        // If found, get the grant_days and process
                        $grantedLeavesCount = $leavePolicy['grant_days'] ?? 0;
                    }
                }
            }
        }
        $currentMonth = Carbon::now()->month;
        for ($month = $startingMonth; $month <= min($currentMonth, $lastmonth); $month++){
            // Reset availed leaves count for this month
            $this->availedLeavesCount = 0;
            // Fetch leave requests that overlap with the current month
            $availedLeavesRequests = LeaveRequest::where('emp_id', $employeeId)
                ->where('leave_type', 'Casual Leave')
                ->where('leave_status', '2')
                ->where('cancel_status', '!=', '2')
                ->whereYear('from_date', $this->year)
                ->where(function ($query) use ($month) {
                    $query->whereMonth('from_date', $month)
                        ->orWhereMonth('to_date', $month);
                })->where('category_type', 'Leave')
                ->get();

            foreach ($availedLeavesRequests as $availedleaveRequest) {
                $originalStartDate = Carbon::parse($availedleaveRequest->from_date);
                $originalEndDate = Carbon::parse($availedleaveRequest->to_date);

                // Adjust the start date to the first day of the month if it is earlier
                $startDate = $originalStartDate->month < $month ? Carbon::create($currentYear, $month, 1) : $originalStartDate;

                // Adjust the end date to the last day of the month if it is later
                $endDate = $originalEndDate->month > $month ? Carbon::create($currentYear, $month, Carbon::create($currentYear, $month)->daysInMonth) : $originalEndDate;

                // Calculate the number of days within this month
                $days = self::calculateNumberOfDays(
                    $startDate,
                    $availedleaveRequest->from_session,
                    $endDate,
                    $availedleaveRequest->to_session,
                    $availedleaveRequest->leave_type
                );

                // Accumulate the days for this month
                $this->availedLeavesCount += $days;
            }

            // Adjust granted leaves count by subtracting availed leaves count
            $grantedLeavesCount -= $this->availedLeavesCount;

            // Ensure granted leaves count is non-negative
            $grantedLeavesCount = max(0, $grantedLeavesCount);

            // Store the granted leaves count and availed leaves count in their respective arrays
            $grantedLeavesByMonth[] = $grantedLeavesCount;
            $availedLeavesByMonth[] = $this->availedLeavesCount;

            // Calculate lapsed leaves only for December
            if ($month === 12) {
                $lapsedLeaves = EmployeeLeaveBalances::where('emp_id', $employeeId)
                    ->where('period', 'like', "%$this->year%")
                    ->where('is_lapsed', true) // Add this condition to filter by is_lapsed
                    ->get();
                if ($lapsedLeaves) {
                    $this->lapsedLeavesCount = $this->casualLeaveGrantDays - $this->totalSickDays;
                }
                $lapsedLeavesByMonth[] = $this->lapsedLeavesCount;
            } else {
                $lapsedLeavesByMonth[] = 0; // For all other months, set lapsed leaves to 0
            }
        }

        // Check if employee has lapsed leave balance
        $employeeLapsedChartBalance = EmployeeLeaveBalances::where('emp_id', $employeeId)
            ->where('period', 'like', "%$this->year%")
            ->selectRaw("*, JSON_UNQUOTE(JSON_EXTRACT(leave_policy_id, '$[*].leave_name')) AS leave_name") // Get all columns and also leave_name for filtering
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(leave_policy_id, '$[*].leave_name')) LIKE '%Casual Leave%'") // Filter based on Casual Leave
            ->get();

        $chartData = [
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            'datasets' => [
                [
                    'label' => 'Granted Leaves',
                    'data' => array_slice($grantedLeavesByMonth, 0, $currentMonth),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'Availed Leaves',
                    'data' => $availedLeavesByMonth,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];

        // Add "Lapsed Leaves" dataset only if employee has lapsed leave balance
        if (!$grantedLeavesCountData->isEmpty() && $employeeLapsedChartBalance->first() && $employeeLapsedChartBalance->first()->is_lapsed) {

            $chartData['datasets'][] = [
                'label' => 'Lapsed Leaves',
                'data' => array_slice($lapsedLeavesByMonth, 0, $currentMonth),
                'backgroundColor' => 'rgba(255, 159, 64, 0.5)',
                'borderColor' => 'rgba(255, 159, 64, 1)',
                'borderWidth' => 1
            ];
        }


        $chartOptions = [
            'scales' => [
                'y' => [
                    'ticks' => [
                        'beginAtZero' => true,
                        'min' => 0,
                        'max' => 10,
                        'stepSize' => 2
                    ],
                    'grid' => [
                        'display' => false
                    ]
                ],
                'x' => [
                    'grid' => [
                        'display' => false
                    ]
                ]
            ],
            'maintainAspectRatio' => false,
            'responsive' => true
        ];

        return view('livewire.casual-leave-balance', [
            'employeeLeaveBalances' => $this->employeeLeaveBalances,
            'employeeleaveavlid' => $this->employeeleaveavlid,
            'totalSickDays' => $this->totalSickDays,
            'Availablebalance' => $this->Availablebalance,
            'lapsedBalance' => $this->lapsedBalance,
            'chartData' => $chartData,
            'employeeLapsedBalanceList' => $this->employeeLapsedBalanceList,
            'chartOptions' => $chartOptions,
            'casualLeaveGrantDays' => $this->casualLeaveGrantDays,
            'grantedLeavesCount'=>$grantedLeavesCount
        ]);
    }
}
