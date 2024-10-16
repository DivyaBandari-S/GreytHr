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
use Google\Service\Sheets\ChartData;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class TeamOnLeaveChart extends Component
{
    public $leaveApplications;
    public $employeesOnLeave;
    public $chartData;
    public $chartOptions;
    public $employeeId, $fromDateFormatted, $toDateFormatted;
    public $duration = 'this_month';
    public $search = '';
    public $leaveTypeFilter = "";
    public $leaveTypes = [];
    public $todaysDate;

    ///this method ill give data for barchart of leave applications of employees
    private function prepareChartData($leaveApplications)
    {
        try {
            $chartData = [
                'labels' => [],
                'datasets' => [],
                'barThickness' => 1,
            ];

            // Generate labels for the entire month
            if ($this->duration == 'last_month') {
                $lastMonth = Carbon::now()->subMonth();  // Get the last month
                $currentMonth = $lastMonth->month;  // Set to last month (e.g., August if now is September)
                $daysInMonth = $lastMonth->daysInMonth;
                $this->fromDateFormatted = $lastMonth->startOfMonth()->format('d M, Y');  // First day of last month
                $this->toDateFormatted = $lastMonth->endOfMonth()->format('d M, Y');
            } else {
                $currentMonth = Carbon::now()->month;  // Current month (e.g., September)
                $daysInMonth = Carbon::now()->daysInMonth;
                $this->fromDateFormatted = Carbon::now()->startOfMonth()->format('d M, Y');  // First day of the current month
                $this->toDateFormatted = Carbon::now()->endOfMonth()->format('d M, Y');
            }

            $chartData['labels'] = array_map(function ($day) use ($currentMonth) {
                return Carbon::create()->month($currentMonth)->day($day)->format('M d');
            }, range(1, $daysInMonth));

            // Extract unique leave types
            $leaveTypes = $leaveApplications->pluck('leave_type')->unique();

            // Initialize datasets for each leave type
            foreach ($leaveTypes as $leaveType) {
                $chartData['datasets'][$leaveType] = array_fill_keys($chartData['labels'], 0);
            }

            // Process each leave application
            foreach ($leaveApplications as $leaveApplication) {
                $fromDate = Carbon::parse($leaveApplication->from_date);
                $toDate = Carbon::parse($leaveApplication->to_date);
                $leaveType = $leaveApplication->leave_type;
                $employeeId = $leaveApplication->employee_id;  // Ensure employee data is available

                // Store the leave count for each employee on a specific day
                $employeeLeaveDays = [];

                if ($this->duration == 'today') {
                    // Handle if today's date is within the fromDate and toDate range
                    $today = Carbon::now();

                    // Check if today's date is between fromDate and toDate (inclusive)
                    if ($today->gte($fromDate) || $today->lte($toDate)) {
                        $day = $today->format('M d'); // Set the label for today in 'Month Day' format

                        $currentDayCount = $this->calculateNumberOfDays(
                            $fromDate->toDateString(),
                            $leaveApplication->from_session,
                            $toDate->toDateString(),
                            $leaveApplication->to_session,
                            $leaveApplication->leave_type
                        );

                        // Ensure the total leave for today does not exceed 1 day
                        if (!isset($employeeLeaveDays[$employeeId][$day])) {
                            $employeeLeaveDays[$employeeId][$day] = 0;
                        }

                        $totalLeaveForDay = $employeeLeaveDays[$employeeId][$day] + $currentDayCount;
                        if ($totalLeaveForDay > 1) {
                            $currentDayCount = 1 - $employeeLeaveDays[$employeeId][$day];
                        }

                        $employeeLeaveDays[$employeeId][$day] += $currentDayCount;

                        // Update the chart data
                        if (!isset($chartData['datasets'][$leaveType][$day])) {
                            $chartData['datasets'][$leaveType][$day] = 0;
                        }

                        $chartData['datasets'][$leaveType][$day] += $currentDayCount;
                    }
                    // $fromDate->addDay();
                }
                else{
                while ($fromDate->lte($toDate)) {
                    // Ensure the date is within the current month
                    if ($fromDate->month == $currentMonth) {
                        $day = $fromDate->format('M d');


                        // Calculate the number of days for the current date
                        $currentDayCount = $this->calculateNumberOfDays(
                            $fromDate->toDateString(),
                            $leaveApplication->from_session,
                            $toDate->toDateString(),
                            $leaveApplication->to_session,
                            $leaveApplication->leave_type
                        );

                        // Ensure that the total leave for any employee does not exceed 1 day per day
                        if (!isset($employeeLeaveDays[$employeeId][$day])) {
                            $employeeLeaveDays[$employeeId][$day] = 0;
                        }

                        $employeeLeaveDays[$employeeId][$day] = (float) $employeeLeaveDays[$employeeId][$day];
                        $currentDayCount = (float) $currentDayCount;
                        // Calculate the total leave for the day and cap it at 1
                        $totalLeaveForDay = $employeeLeaveDays[$employeeId][$day] + $currentDayCount;


                        // Cap the leave to 1 day max per employee on the same day
                        if ($totalLeaveForDay > 1) {
                            $currentDayCount = 1 - $employeeLeaveDays[$employeeId][$day];
                        }

                        // Update the employee's leave count for the day
                        $employeeLeaveDays[$employeeId][$day] += (float)$currentDayCount; // Cast to int

                        // Initialize the chart data for the leave type if it's not set
                        if (!isset($chartData['datasets'][$leaveType][$day])) {
                            $chartData['datasets'][$leaveType][$day] = 0; // Ensure it's initialized as an integer
                        }

                        // Accumulate leave days for the specific leave type
                        $chartData['datasets'][$leaveType][$day] += (float)$currentDayCount; // Cast to int

                    }

                    $fromDate->addDay();
                }
            }

            }

            // Ensure all dates are present for each leave type
            foreach ($chartData['datasets'] as &$leaveTypeData) {
                $leaveTypeData = array_replace(array_fill_keys($chartData['labels'], 0), $leaveTypeData);
            }

            return $chartData;
        } catch (\Exception $e) {
            Log::error('Error occurred in prepareChartData method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while preparing chart data.');
            return [
                'labels' => [],
                'datasets' => [],
                'barThickness' => 10,
            ];
        }
    }



    //this method will fetch only today leave application data
    private function fetchTodayLeaveApplications()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;

            $query = LeaveRequest::where('leave_applications.status', 'approved')
            ->where('category_type', 'Leave')
            ->where('leave_applications.cancel_status', '!=', 'approved')
                ->where(function ($query) use ($employeeId) {
                    $query->whereJsonContains('applying_to', [['manager_id' => $employeeId]])
                        ->orWhereJsonContains('cc_to', [['emp_id' => $employeeId]]);
                })
                ->join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
                ->orderBy('created_at', 'desc');

            // Apply the date filter based on the duration
            if ($this->duration === 'today') {
                $query->whereDate('from_date', '<=', Carbon::now()->today())
                    ->whereDate('to_date', '>=', Carbon::now()->today());
            } else if ($this->duration === 'this_month') {
                $query->where(function ($query) {
                    $query->whereMonth('from_date', Carbon::now()->month)
                        ->orWhereMonth('to_date', Carbon::now()->month);
                });
            } else if ($this->duration === 'last_month') {
                $query->where(function ($query) {
                    $query->whereMonth('from_date', Carbon::now()->subMonth()->month)
                        ->orWhereMonth('to_date', Carbon::now()->subMonth()->month);  // Ensure leaves overlapping into last month are included
                });
            }

            if (!empty($this->search)) {

                $query->where(function ($query) {
                    $query->where('employee_details.first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('employee_details.last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('employee_details.emp_id', 'like', '%' . $this->search . '%');
                });
            }

            if (!empty($this->leaveTypeFilter)) {
                $query->where('leave_type', $this->leaveTypeFilter);
            }



            return $query->get(['leave_applications.*', 'employee_details.image', 'employee_details.first_name', 'employee_details.last_name']);
        } catch (\Exception $e) {
            Log::error('Error occurred in fetching details method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while fetching the leaves.');
        }
    }

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

    public function getSessionNumber($session)
    {
        // You might need to customize this based on your actual session values
        return (int) str_replace('Session ', '', $session);
    }

    public function fetchLeaveTypes()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;

            $leaveTypes = LeaveRequest::where('leave_applications.status', 'approved')
                ->where(function ($query) use ($employeeId) {
                    $query->whereJsonContains('applying_to', [['manager_id' => $employeeId]])
                        ->orWhereJsonContains('cc_to', [['emp_id' => $employeeId]]);
                })
                ->join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
                ->select('leave_type')
                ->whereNotNull('leave_type')
                ->where('leave_type', '!=', '')
                // ->where('leave_applications.leave_type','approved')
                ->distinct()
                ->pluck('leave_type')
                ->toArray();
            // if ($this->duration === 'today') {
            //     $leaveTypes->whereDate('from_date', Carbon::now()->today);
            // } else if ($this->duration === 'this_month') {
            //     $leaveTypes->whereMonth('from_date', Carbon::now()->month);
            // }

            return $leaveTypes;
        } catch (\Exception $e) {
            Log::error('Error occurred in fetching leave types: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while fetching leave types.');
        }
    }


    public function updateDuration($value)
    {

        return redirect()->to("/team-on-leave-chart?duration={$value}");
    }
    public function updateSearch($value)
    {

        $this->leaveApplications = $this->fetchTodayLeaveApplications();
    }
    public function updateLeaveTypeFilter($value)
    {

        $this->leaveTypeFilter = $value;

        $this->leaveApplications = $this->fetchTodayLeaveApplications();
    }

    public function mount()
    {
        try {
            $this->todaysDate = Carbon::now()->format('d M, Y');
            $this->duration = request()->query('duration') ? request()->query('duration') : 'this_month';
            $this->leaveApplications = $this->fetchTodayLeaveApplications();
            // dd( $this->leaveApplications);

            if ($this->leaveApplications == null) {
                $this->leaveApplications = [];
            }

            $chartData = $this->prepareChartData($this->leaveApplications);
            $this->leaveTypes = $this->fetchLeaveTypes();

            $this->chartData = [
                'labels' => $chartData['labels'],
                'datasets' => $chartData['datasets'],
            ];


            $this->chartOptions = [
                'responsive' => true,
                'scales' => [
                    'x' => [
                        'stacked' => true,
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
                        'stacked' => true,
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
        } catch (QueryException $e) {
            // Log the exception or handle it accordingly
            Log::error('QueryException occurred: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while fetching data.');
        } catch (\Exception $e) {
            // Log other exceptions
            Log::error('Exception occurred: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while fetching data.');
        }
    }

    public function render()
    {
        return view(
            'livewire.team-on-leave-chart',
            [

                'chartData' => $this->chartData,
                'chartOptions' => $this->chartOptions,
                'empsOnLeaves' => $this->employeesOnLeave,
                'leaveApplications' => $this->leaveApplications,
                'debugInfo' => [
                    'chartData' => $this->chartData,
                    'chartOptions' => $this->chartOptions,
                ]
            ]
        );
    }

    public function fetchEmployeesOnLeave()
    {
        try {
            // Fetch leave applications based on the duration
            if ($this->duration === 'today') {
                $leaveApplications = $this->fetchTodayLeaveApplications();
            } elseif ($this->duration === 'this_month') {
                $leaveApplications = $this->fetchThisMonthLeaveApplications();
            }
            // Check if there are no leave applications

            // Extract unique employee IDs from the leave applications
            $employeeIds = $leaveApplications->pluck('emp_id')->unique();

            // Fetch employee details based on unique IDs
            $employeesOnLeave = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
                ->whereIn('leave_applications.emp_id', $employeeIds)
                ->where('leave_applications.status', 'approved')
                ->whereMonth('from_date', Carbon::now()->today)
                ->get(['employee_details.emp_id', 'employee_details.first_name', 'employee_details.last_name', 'employee_details.image', 'leave_applications.*'])
                ->toArray();


            return $employeesOnLeave;
        } catch (\Exception $e) {
            Log::error('Error occurred while fetching employee details: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while fetching employee details.');
            return collect([]); // Return an empty collection if an error occurs
        }
    }


    // public function fetchChartData()
    // {

    //     $chartData = $this->prepareChartData($this->leaveApplications);

    //     return response()->json([
    //         'labels' => $chartData['labels'],
    //         'datasets' => $chartData['datasets'],
    //         'options' => [
    //             'responsive' => true,
    //             'scales' => [
    //                 'x' => [
    //                     'stacked' => true,
    //                     'display' => true,
    //                     'title' => [
    //                         'display' => true,
    //                     ],
    //                     'ticks' => [
    //                         'align' => 'center',
    //                     ],
    //                     'grid' => [
    //                         'display' => false,
    //                     ],
    //                 ],
    //                 'y' => [
    //                     'stacked' => true,
    //                     'display' => true,
    //                     'title' => [
    //                         'display' => true,
    //                         'text' => 'Number Of Days',
    //                     ],
    //                     'ticks' => [
    //                         'beginAtZero' => true,
    //                         'stepSize' => 1,
    //                         'max' => 6,
    //                     ],
    //                     'grid' => [
    //                         'display' => false,
    //                     ],
    //                 ],
    //             ],
    //             'elements' => [
    //                 'bar' => [
    //                     'barPercentage' => 1,
    //                 ],
    //             ],
    //         ],
    //     ]);
    // }

}
