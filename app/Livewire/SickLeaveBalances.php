<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\EmployeeLeaveBalances;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SickLeaveBalances extends Component
{
    public $leaveData;
    public $employeeLeaveBalances;
    public $employeeleaveavlid;
    public $totalSickDays = 0;
    public $Availablebalance, $employeeDetails;


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
            }elseif(self::getSessionNumber($fromSession) !== self::getSessionNumber($toSession)){
                if (self::getSessionNumber($fromSession) !== 1) {
                    $totalDays += 1; // Add half a day
                }
            }
            else {
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
        try{
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
            
            $this->employeeLeaveBalances= EmployeeLeaveBalances::where('emp_id', $employeeId)
            ->where('leave_type', 'Sick Leave')
            ->get();
            
            // Now $employeeLeaveBalances contains all the rows from employee_leave_balances 
            // where emp_id matches and leave_type is "Sick Leave"
            $this->employeeleaveavlid = LeaveRequest::where('emp_id', $employeeId)
            ->where('leave_type', 'Sick Leave')
            ->where('status', 'approved')
            ->get();

            
            foreach ($this->employeeleaveavlid as $leaveRequest) {
                //$leaveType = $leaveRequest->leave_type;
                $days = self::calculateNumberOfDays(
                    $leaveRequest->from_date,
                    $leaveRequest->from_session,
                    $leaveRequest->to_date,
                    $leaveRequest->to_session
                );
                $this->totalSickDays += intval($days);
                // $this->Availablebalance = $this->employeeLeaveBalances->leave_balance - $this->totalSickDays;
            }
            foreach ($this->employeeLeaveBalances as $employeeLeaveBalance) {
                $this->Availablebalance = $employeeLeaveBalance->leave_balance - $this->totalSickDays;
                // Do something with $this->Availablebalance
            }


            $currentMonth = date('n');
            $currentYear = date('Y');
            $startingMonth = 1; // January

            $grantedLeavesByMonth = [];
            $availedLeavesByMonth = [];
            $grantedLeavesCount = EmployeeLeaveBalances::where('emp_id', $employeeId)
                ->where('leave_type', 'Sick Leave')
                ->whereYear('from_date', $currentYear)
                ->sum('leave_balance');

            for ($month = $startingMonth; $month <= $currentMonth; $month++) {
                // Fetch availed leaves count for this month
                $availedLeavesCount = LeaveRequest::where('emp_id', $employeeId)
                    ->where('leave_type', 'Sick Leave')
                    ->where('status', 'approved')
                    ->whereYear('from_date', $currentYear)
                    ->whereMonth('from_date', $month)
                    ->count();
                
                // Adjust granted leaves count by subtracting availed leaves count
                $grantedLeavesCount -= $availedLeavesCount;

                // Ensure granted leaves count is non-negative
                $grantedLeavesCount = max(0, $grantedLeavesCount);

                // Store the granted leaves count and availed leaves count in their respective arrays
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
                                'stepSize' => 2 // Adjust the step size to show values at intervals of 2
                            ],
                            'gridLines' => [
                                'display' => false // Remove grid lines from the y-axis
                            ]
                        ]],
                        'xAxes' => [[
                            'gridLines' => [
                                'display' => false // Remove grid lines from the x-axis
                            ]
                        ]]
                    ],
                    'maintainAspectRatio' => false, // Allow chart to be resized
                    'responsive' => true // Make chart responsive
                ];
            return view('livewire.sick-leave-balances', [
                'employeeLeaveBalances' => $this->employeeLeaveBalances,
                'employeeleaveavlid' => $this->employeeleaveavlid,
                'totalSickDays' => $this->totalSickDays,
                'Availablebalance' => $this->Availablebalance,
                'chartData' => $chartData,
                'chartOptions' => $chartOptions // Pass chart options to the view
            ]);
        }
        catch (\Exception $e) {
            Log::error('Error in Sick Leave Balance render method: ' . $e->getMessage());
            return view('livewire.sick-leave-balances');
        }
    }

}
