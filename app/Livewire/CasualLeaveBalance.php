<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EmployeeDetails;
use App\Models\LeaveRequest;
use App\Models\EmployeeLeaveBalances;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CasualLeaveBalance extends Component
{
    public $leaveData;
    public $employeeLeaveBalances;
    public $employeeleaveavlid;
    public $totalSickDays = 0;
    public $employeeDetails;
    public $Availablebalance,$selectedYear,$currentYear ;


    public function mount(){
        $this->selectedYear = Carbon::now()->format('Y');
        $this->currentYear = now()->year;
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

    ///calculate number of days
    public static function calculateNumberOfDays($fromDate, $fromSession, $toDate, $toSession)
    {
        try {
            $startDate = Carbon::parse($fromDate);
            $endDate = Carbon::parse($toDate);

            // Check if the start and end sessions are different on the same day
            if (
                $startDate->isSameDay($endDate) &&
                self::getSessionNumber($fromSession) !== self::getSessionNumber($toSession)
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
                // Check if it's a weekday (Monday to Friday)
                if ($startDate->isWeekday()) {
                    $totalDays += 1;
                }

                // Move to the next day
                $startDate->addDay();
            }

            // Deduct weekends based on the session numbers
            if (self::getSessionNumber($fromSession) > 1) {
                $totalDays -= self::getSessionNumber($fromSession) - 1; // Deduct days for the starting session
            }
            if (self::getSessionNumber($toSession) < 2) {
                $totalDays -= 2 - self::getSessionNumber($toSession); // Deduct days for the ending session
            }
            // Adjust for half days
            if (self::getSessionNumber($fromSession) === self::getSessionNumber($toSession)) {
                // If start and end sessions are the same, check if the session is not 1
                if (self::getSessionNumber($fromSession) !== 1) {
                    $totalDays += 0.5; // Add half a day
                }
            } elseif (self::getSessionNumber($fromSession) !== self::getSessionNumber($toSession)) {
                if (self::getSessionNumber($fromSession) !== 1) {
                    $totalDays += 1; // Add half a day
                }
            } else {
                $totalDays += (self::getSessionNumber($toSession) - self::getSessionNumber($fromSession) + 1) * 0.5;
            }

            return (float) $totalDays;
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    private static function getSessionNumber($session)
    {
        // You might need to customize this based on your actual session values
        return (int) str_replace('Session ', '', $session);
    }

    public function render()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

            $this->employeeLeaveBalances = EmployeeLeaveBalances::where('emp_id', $employeeId)
                ->where('leave_type', 'Causal Leave')
                ->get();

            $this->employeeleaveavlid = LeaveRequest::where('emp_id', $employeeId)
                ->where('leave_type', 'Causal Leave')
                ->where('status', 'approved')
                ->get();

            foreach ($this->employeeleaveavlid as $leaveRequest) {
                $days = self::calculateNumberOfDays(
                    $leaveRequest->from_date,
                    $leaveRequest->from_session,
                    $leaveRequest->to_date,
                    $leaveRequest->to_session
                );
                $this->totalSickDays += intval($days);
            }

            foreach ($this->employeeLeaveBalances as $employeeLeaveBalance) {
                $this->Availablebalance = $employeeLeaveBalance->leave_balance - $this->totalSickDays;
            }

            $currentMonth = date('n');
            $currentYear = date('Y');
            $startingMonth = 1;

            $grantedLeavesByMonth = [];
            $availedLeavesByMonth = [];
            $grantedLeavesCount = EmployeeLeaveBalances::where('emp_id', $employeeId)
                ->where('leave_type', 'Causal Leave')
                ->whereYear('from_date', $currentYear)
                ->sum('leave_balance');

            for ($month = $startingMonth; $month <= $currentMonth; $month++) {
                $availedLeavesCount = LeaveRequest::where('emp_id', $employeeId)
                    ->where('leave_type', 'Causal Leave')
                    ->where('status', 'approved')
                    ->whereYear('from_date', $currentYear)
                    ->whereMonth('from_date', $month)
                    ->count();

                $grantedLeavesCount -= $availedLeavesCount;
                $grantedLeavesCount = max(0, $grantedLeavesCount);

                $grantedLeavesByMonth[] = $grantedLeavesCount;
                $availedLeavesByMonth[] = $availedLeavesCount;
            }

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

            $chartOptions = [
                'scales' => [
                    'yAxes' => [[
                        'ticks' => [
                            'beginAtZero' => true,
                            'min' => 0,
                            'max' => 10,
                            'stepSize' => 2
                        ],
                        'gridLines' => [
                            'display' => false
                        ]
                    ]],
                    'xAxes' => [[
                        'gridLines' => [
                            'display' => false
                        ]
                    ]]
                ],
                'maintainAspectRatio' => false,
                'responsive' => true
            ];

            return view('livewire.casual-leave-balance', [
                'employeeLeaveBalances' => $this->employeeLeaveBalances,
                'employeeleaveavlid' => $this->employeeleaveavlid,
                'totalSickDays' => $this->totalSickDays,
                'Availablebalance' => $this->Availablebalance,
                'chartData' => $chartData,
                'chartOptions' => $chartOptions
            ]);
        } catch (\Exception $e) {
            Log::error('Error in Casual Leave Balance render method: ' . $e->getMessage());

            return view('livewire.casual-leave-balance')->withErrors(['error' => 'An error occurred while loading the data. Please try again later.']);
        }
    }
}
