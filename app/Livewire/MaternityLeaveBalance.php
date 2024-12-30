<?php

namespace App\Livewire;

use App\Models\EmployeeLeaveBalances;
use App\Helpers\FlashMessageHelper;
use App\Models\EmployeeDetails;
use App\Models\HolidayCalendar;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Livewire\Component;

class MaternityLeaveBalance extends Component
{
    public $leaveData, $year, $currentYear;
    public $employeeLeaveBalances;
    public $employeeleaveavlid;
    public $employeeLapsedBalance;
    public $lapsedLeavesCount;
    public $totalSickDays = 0;
    public $employeeDetails;
    public $employeeLapsedBalanceList;
    public $Availablebalance, $leaveGrantedData, $availedLeavesCount;
    public $lapsedBalance;
    public $casualLeaveGrantDays;
    public $employeeLeaveBalancesData;
    public $employeeLapsedBalanceData;
    public $grantedLeavesCount;


    ///calculate number of days
    public function calculateNumberOfDays($fromDate, $fromSession, $toDate, $toSession, $leaveType)
    {
        try {
            $startDate = Carbon::parse($fromDate);
            $endDate = Carbon::parse($toDate);

            // Fetch holidays between the fromDate and toDate
            $holidays = HolidayCalendar::whereBetween('date', [$startDate, $endDate])->get();

            // Check if the start or end date is a weekend for non-Marriage leave
            if (!in_array($leaveType, ['Marriage Leave', 'Sick Leave', 'Maternity Leave', 'Paternity Leave']) && ($startDate->isWeekend() || $endDate->isWeekend())) {
                return 0;
            }

            // Check if the start and end sessions are different on the same day
            if (
                $startDate->isSameDay($endDate) &&
                $this->getSessionNumber($fromSession) === $this->getSessionNumber($toSession)
            ) {
                // Inner condition to check if both start and end dates are weekdays (for non-Marriage leave)
                if (!in_array($leaveType, ['Marriage Leave', 'Sick Leave', 'Maternity Leave', 'Paternity Leave']) && !$startDate->isWeekend() && !$endDate->isWeekend() && !$this->isHoliday($startDate, $holidays) && !$this->isHoliday($endDate, $holidays)) {
                    return 0.5;
                } else {
                    return 0;
                }
            }

            if (
                $startDate->isSameDay($endDate) &&
                $this->getSessionNumber($fromSession) !== $this->getSessionNumber($toSession)
            ) {
                // Inner condition to check if both start and end dates are weekdays (for non-Marriage leave)
                if (!in_array($leaveType, ['Marriage Leave', 'Sick Leave', 'Maternity Leave', 'Paternity Leave']) && !$startDate->isWeekend() && !$endDate->isWeekend() && !$this->isHoliday($startDate, $holidays) && !$this->isHoliday($endDate, $holidays)) {
                    return 1;
                } else {
                    return 0;
                }
            }

            $totalDays = 0;

            while ($startDate->lte($endDate)) {
                // For non-Marriage leave type, skip holidays and weekends, otherwise include weekdays
                if (!in_array($leaveType, ['Marriage Leave', 'Sick Leave', 'Maternity Leave', 'Paternity Leave'])) {
                    if (!$this->isHoliday($startDate, $holidays) && $startDate->isWeekday()) {
                        $totalDays += 1;
                    }
                } else {
                    // For Marriage leave type, count all weekdays without excluding weekends or holidays
                    if (!$this->isHoliday($startDate, $holidays)) {
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
            FlashMessageHelper::flashError('An error occurred while calculating the number of days.');
            return false;
        }
    }
    // Helper method to check if a date is a holiday
    private function isHoliday($date, $holidays)
    {
        // Check if the date exists in the holiday collection
        return $holidays->contains('date', $date->toDateString());
    }
    private function getSessionNumber($session)
    {
        return (int) str_replace('Session ', '', $session);
    }

    public function yearDropDown()
    {
        try {
            $currentYear = Carbon::now()->format('Y');
            if ($this->isTrue($currentYear - 2)) {
            } elseif ($this->isTrue($currentYear - 1)) {
            } elseif ($this->isTrue($currentYear)) {
            } else {
            }
        } catch (\Exception $e) {
            // Add an error message or log a message indicating that an error occurred
            $errorMessage = 'An error occurred in yearDropDown() method: ' . $e->getMessage();
            $this->addError('session', 'An error occurred. Please try again later.');
        }
    }

    public function changeYear($year)
    {
        return redirect()->to("/leave-balances/maternityleavebalance?year={$year}");
    }
    public function render()
    {
        $this->currentYear = date('Y');
        $this->year = request()->query('year') ?? date('Y');

        // $this->yearDropDown();
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
        $this->leaveGrantedData = EmployeeLeaveBalances::where('emp_id', $employeeId)
            ->where('period', 'like', "%$this->year%")
            ->selectRaw("*, JSON_UNQUOTE(JSON_EXTRACT(leave_policy_id, '$[*].leave_name')) AS leave_name") // Get all columns and also leave_name for filtering
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(leave_policy_id, '$[*].leave_name')) LIKE '%Maternity Leave%'") // Filter based on Casual Leave
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
                    if (isset($leavePolicy['leave_name']) && $leavePolicy['leave_name'] === 'Maternity Leave') {
                        // If found, get the grant_days and process
                        $this->casualLeaveGrantDays = $leavePolicy['grant_days'] ?? 0;
                    }
                }
            }
        }



        // Now $employeeLeaveBalances contains all the rows from employee_leave_balances
        // where emp_id matches and leave_type is "Sick Leave"
        $this->employeeleaveavlid = LeaveRequest::where('emp_id', $employeeId)
            ->whereYear('from_date', '<=', $this->year)   // Check if the from_date year is less than or equal to the given year
            ->whereYear('to_date', '>=', $this->year)
            ->where('leave_type', 'Maternity Leave')
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
            if ($leaveRequest->leave_status == '2' && $leaveRequest->cancel_status != '2' &&  $leaveRequest->category_type === 'Leave') {
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
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(leave_policy_id, '$[*].leave_name')) LIKE '%Maternity Leave%'") // Filter based on Casual Leave
            ->get();

        $this->Availablebalance = $this->casualLeaveGrantDays - $this->totalSickDays;

        $this->employeeLapsedBalanceList = EmployeeLeaveBalances::where('emp_id', $employeeId)
            ->where('period', 'like', "%$this->year%")
            ->selectRaw("*, JSON_UNQUOTE(JSON_EXTRACT(leave_policy_id, '$[*].leave_name')) AS leave_name") // Get all columns and also leave_name for filtering
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(leave_policy_id, '$[*].leave_name')) LIKE '%Maternity Leave%'") // Filter based on Casual Leave
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
                    if (isset($leavePolicy['leave_name']) && $leavePolicy['leave_name'] === 'Maternity Leave') {
                        // If found, get the grant_days and process
                        $grantedLeavesCount = $leavePolicy['grant_days'] ?? 0;
                    }
                }
            }
        }

        for ($month = $startingMonth; $month <= $lastmonth; $month++) {
            // Reset availed leaves count for this month
            $this->availedLeavesCount = 0;

            // Fetch leave requests that overlap with the current month
            $availedLeavesRequests = LeaveRequest::where('emp_id', $employeeId)
                ->where('leave_type', 'Maternity Leave')
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
            ->where('period', 'like', "%$this->year%")->first();

        $chartData = [
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            'datasets' => [
                [
                    'label' => 'Granted Leaves',
                    'data' => $grantedLeavesByMonth,
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
                'data' => $lapsedLeavesByMonth,
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

        return view(
            'livewire.maternity-leave-balance',
            [
                'employeeLeaveBalances' => $this->employeeLeaveBalances,
                'employeeleaveavlid' => $this->employeeleaveavlid,
                'totalSickDays' => $this->totalSickDays,
                'Availablebalance' => $this->Availablebalance,
                'lapsedBalance' => $this->lapsedBalance,
                'chartData' => $chartData,
                'employeeLapsedBalanceList' => $this->employeeLapsedBalanceList,
                'chartOptions' => $chartOptions
            ]
        );
    }

}
