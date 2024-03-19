<?php
// File Name                       : TeamOnLeaveChart.php
// Description                     : This file contains the implementation of used leaves by team members this file will appear only for manager
// Creator                         : Bandari Divya
// Email                           : bandaridivya1@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : LeaveRequest
namespace App\Livewire;

use Livewire\Component;
use App\Models\LeaveRequest;
use Carbon\Carbon;

class TeamOnLeaveChart extends Component
{
    public $leaveApplications;
    public $chartData;
    public $chartOptions;
    public $duration = 'this_month';

    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;

        // Fetch data based on the selected duration
        if ($this->duration === 'today') {
            $this->leaveApplications = $this->fetchTodayLeaveApplications();
        } elseif ($this->duration === 'this_month') {
            $this->leaveApplications = $this->fetchThisMonthLeaveApplications();
        }

        $chartData = $this->prepareChartData($this->leaveApplications);

        $this->chartData = [
            'labels' => $chartData['labels'],
            'datasets' => $chartData['datasets'],
        ];

        $this->chartOptions = [
            'responsive' => true,
            'scales' => [
                'x' => [
                    'display' => true,
                    'title' => [
                        'display' => true,

                    ],
                    'ticks' => [
                        'align' => 'center',
                    ],
                    'grid' => [
                        'display' => false,
                    ],
                ],
                'y' => [
                    'display' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Number Of Days',
                    ],
                    'ticks' => [
                        'beginAtZero' => true,
                        'stepSize' => 1,
                        'max' => 6, // Set the max value for the y-axis ticks
                    ],
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
            'elements' => [
                'bar' => [
                    'barPercentage' => 1, // Adjust the bar width percentage (e.g., 0.8 for 80% width)
                ],
            ],
        ];


        return view('livewire.team-on-leave-chart', [
            'leaveApplications' => $this->leaveApplications,
            'chartData' => $this->chartData,
            'chartOptions' => $this->chartOptions,
            'debugInfo' => [
                'chartData' => $this->chartData,
                'chartOptions' => $this->chartOptions,
            ]
        ]);
    }

    private function prepareChartData($leaveApplications)
    {
        $chartData = [
            'labels' => [],
            'datasets' => [],
            'barThickness' => 10,
        ];

        // Generate labels based on the selected duration
        if ($this->duration === 'today') {
            $chartData['labels'][] = Carbon::now()->format('M d');
        } elseif ($this->duration === 'this_month') {
            $chartData['labels'] = array_map(function ($day) {
                $fromDate = Carbon::now()->startOfMonth()->addDays($day - 1);
                return $fromDate->format('M d');
            }, range(1, Carbon::now()->endOfMonth()->day));
        }

        foreach ($leaveApplications as $leaveApplication) {
            $fromDate = Carbon::parse($leaveApplication->from_date);
            $toDate = Carbon::parse($leaveApplication->to_date);

            $leaveType = $leaveApplication->leave_type;

            while ($fromDate->lte($toDate)) {
                // Check if the day is in the current month
                if ($fromDate->month == Carbon::now()->month) {
                    $day = $fromDate->format('M d');

                    // Ensure there is an entry for the leave type
                    if (!isset($chartData['datasets'][$leaveType])) {
                        $chartData['datasets'][$leaveType] = [];
                    }

                    // Set the value for the leave type on the specific day
                    $chartData['datasets'][$leaveType][$day] = isset($chartData['datasets'][$leaveType][$day])
                        ? $chartData['datasets'][$leaveType][$day] + $this->calculateNumberOfDays($fromDate->toDateString(), $leaveApplication->from_session, $fromDate->toDateString(), $leaveApplication->to_session)
                        : $this->calculateNumberOfDays($fromDate->toDateString(), $leaveApplication->from_session, $fromDate->toDateString(), $leaveApplication->to_session);
                }

                $fromDate->addDay();
            }
        }

        // Fill in missing days with zero values for each leave type
        foreach ($chartData['datasets'] as &$leaveTypeData) {
            $leaveTypeData = array_replace(array_fill_keys($chartData['labels'], 0), $leaveTypeData);
        }

        return $chartData;
    }

    private function fetchTodayLeaveApplications()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;

        return LeaveRequest::where('status', 'approved')
            ->where(function ($query) use ($employeeId) {
                $query->whereJsonContains('applying_to', [['manager_id' => $employeeId]])
                    ->orWhereJsonContains('cc_to', [['emp_id' => $employeeId]]);
            })
            ->join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
            ->whereDate('from_date', Carbon::now()->toDateString()) // Filter for today
            ->orderBy('created_at', 'desc')
            ->get(['leave_applications.*', 'employee_details.image', 'employee_details.first_name', 'employee_details.last_name']);
        // Add a null check before returning the data

    }


    public function updateDuration($value)
    {
        $this->duration = $value;

        logger("Selected Duration: $value"); // Add this line for logging

        // Fetch data based on the selected duration
        if ($this->duration === 'today') {
            $this->leaveApplications = $this->fetchTodayLeaveApplications();
        } elseif ($this->duration === 'this_month') {
            $this->leaveApplications = $this->fetchThisMonthLeaveApplications();
        }

        // Rest of the code remains unchanged...
    }


    private function fetchThisMonthLeaveApplications()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;

        return LeaveRequest::where('leave_applications.status', 'approved')
            ->where(function ($query) use ($employeeId) {
                $query->whereJsonContains('applying_to', [['manager_id' => $employeeId]])
                    ->orWhereJsonContains('cc_to', [['emp_id' => $employeeId]]);
            })
            ->join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
            ->whereMonth('from_date', Carbon::now()->month) // Filter for the current month
            ->orderBy('created_at', 'desc')
            ->get(['leave_applications.*', 'employee_details.image', 'employee_details.first_name', 'employee_details.last_name']);
    }

    public  function calculateNumberOfDays($fromDate, $fromSession, $toDate, $toSession)
    {
        try {

            $startDate = Carbon::parse($fromDate);
            $endDate = Carbon::parse($toDate);
            // Check if the start and end sessions are different on the same day
            if ($startDate->isSameDay($endDate) && $this->getSessionNumber($fromSession) === $this->getSessionNumber($toSession)) {
                // Inner condition to check if both start and end dates are weekdays
                if (!$startDate->isWeekend() && !$endDate->isWeekend()) {
                    return 0.5;
                } else {
                    // If either start or end date is a weekend, return 0
                    return 0;
                }
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
                // Check if it's a weekday (Monday to Friday)
                if ($startDate->isWeekday()) {
                    $totalDays += 1;
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

    private function getSessionNumber($session)
    {
        // You might need to customize this based on your actual session values
        return (int) str_replace('Session ', '', $session);
    }
}
