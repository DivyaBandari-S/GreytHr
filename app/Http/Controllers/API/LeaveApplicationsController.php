<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Livewire\LeaveBalances;
use App\Models\HolidayCalendar;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LeaveApplicationsController extends Controller
{
    //get balance for selected leave type
    public function getBalanceBySelectingLeaveType(Request $request)
    {
        try {
            $leave_type = $request->input('leave_type');
            $from_date = $request->input('from_date');
            $to_date = $request->input('to_date');
            $selectedYear = Carbon::now()->format('Y');
            if ($from_date && $to_date) {
                $fromYear = Carbon::parse($from_date)->format('Y');
                $toYear = Carbon::parse($to_date)->format('Y');
                // If both from and to dates belong to the same year, use that year
                // Otherwise, use the current year or the year from 'from_date' as fallback
                $selectedYear = ($fromYear === $toYear) ? $fromYear : Carbon::now()->format('Y');
            } else {
                // Fallback to the current year if no dates are set
                $selectedYear = Carbon::now()->format('Y');
            }
            $employeeId = auth()->guard('emp')->user()->emp_id;
            // Retrieve all leave balances
            $allLeaveBalances = LeaveBalances::getLeaveBalances($employeeId, $selectedYear);
            $leaveBalances = [];
            switch ($leave_type) {
                case 'Casual Leave Probation':
                    $leaveBalances = [
                        'casualProbationLeaveBalance' => $allLeaveBalances['casualProbationLeaveBalance'] ?? '0'
                    ];
                    break;
                case 'Casual Leave':
                    $leaveBalances = [
                        'casualLeaveBalance' => $allLeaveBalances['casualLeaveBalance'] ?? '0'
                    ];
                    break;
                case 'Loss of Pay':
                    $leaveBalances = [
                        'lossOfPayBalance' => $allLeaveBalances['lossOfPayBalance'] ?? '0'
                    ];
                    break;
                case 'Sick Leave':
                    $leaveBalances = [
                        'sickLeaveBalance' => $allLeaveBalances['sickLeaveBalance'] ?? '0'
                    ];
                    break;
                case 'Maternity Leave':
                    $leaveBalances = [
                        'maternityLeaveBalance' => $allLeaveBalances['maternityLeaveBalance'] ?? '0'
                    ];
                    break;
                case 'Paternity Leave':
                    $leaveBalances = [
                        'paternityLeaveBalance' => $allLeaveBalances['paternityLeaveBalance'] ?? '0'
                    ];
                    break;
                case 'Marriage Leave':
                    $leaveBalances = [
                        'marriageLeaveBalance' => $allLeaveBalances['marriageLeaveBalance'] ?? '0'
                    ];
                    break;
                case 'Earned Leave':
                    $leaveBalances = [
                        'earnedLeaveBalance' => $allLeaveBalances['earnedLeaveBalance'] ?? '0'
                    ];
                    break;
                default:
                    break;
            }
            return ApiResponse::success(self::SUCCESS_STATUS, self::SUCCESS_MESSAGE, [
                'leaveBalances' => $leaveBalances,
                'selectedYear' => $selectedYear,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching employee details: ' . $e->getMessage());
            return ApiResponse::error(self::ERROR_STATUS, self::INTERNAL_SERVER_ERROR, self::SERVER_ERROR);
        }
    }

    //get total count of approval leave days
    public function getApprovedLeaveDays(Request $request)
    {
        try {
            $employeeId = $request->input('employee_id');
            $selectedYear = $request->input('selected_year');
            $selectedYear = (int) $selectedYear;
            $approvedLeaveRequests = LeaveRequest::where('emp_id', $employeeId)
                ->where('category_type', 'Leave')
                ->where(function ($query) {
                    $query->where('leave_status', 2)
                        ->whereIn('cancel_status', [6, 5, 3, 4]);
                })
                ->whereIn('leave_type', [
                    'Casual Leave Probation',
                    'Loss Of Pay',
                    'Sick Leave',
                    'Casual Leave',
                    'Maternity Leave',
                    'Marriage Leave',
                    'Paternity Leave',
                    'Earned Leave'
                ])
                ->whereYear('to_date', '=', $selectedYear)
                ->get();

            return ApiResponse::success(self::SUCCESS_STATUS, self::SUCCESS_MESSAGE, [
                'approvedLeaveRequests' => $approvedLeaveRequests,
            ]);
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return ApiResponse::error(self::ERROR_STATUS, self::INTERNAL_SERVER_ERROR, self::SERVER_ERROR);
        }
    }

    //get calculate days for leave
    public function calculateLeaveDays(Request $request)
    {
        try {
            // Validate incoming request
            $request->validate([
                'fromDate' => 'required|date',
                'fromSession' => 'required|string',
                'toDate' => 'required|date',
                'toSession' => 'required|string',
                'leaveType' => 'required|string',
            ]);

            // Get the parameters
            $fromDate = $request->input('from_date');
            $fromSession = $request->input('from_session');
            $toDate = $request->input('to_date');
            $toSession = $request->input('to_session');
            $leaveType = $request->input('leave_type');

            // Call the method to calculate the leave days
            $days = $this->calculateNumberOfDays($fromDate, $fromSession, $toDate, $toSession, $leaveType);

            // Return a success response with the calculated days
            return ApiResponse::success(self::SUCCESS_STATUS, self::SUCCESS_MESSAGE, [
                'days' => $days
            ]);
        } catch (\Exception $e) {
            // Handle any errors that occur and return an error response
            Log::error('Error fetching number of days details: ' . $e->getMessage());
            return ApiResponse::error(self::ERROR_STATUS, self::INTERNAL_SERVER_ERROR, self::SERVER_ERROR);
        }
    }

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
            if ($startDate->isSameDay($endDate) && $this->getSessionNumber($fromSession) === $this->getSessionNumber($toSession)) {
                // Inner condition to check if both start and end dates are weekdays (for non-Marriage leave)
                if (!in_array($leaveType, ['Marriage Leave', 'Sick Leave', 'Maternity Leave', 'Paternity Leave']) && !$startDate->isWeekend() && !$endDate->isWeekend() && !$this->isHoliday($startDate, $holidays) && !$this->isHoliday($endDate, $holidays)) {
                    return 0.5;
                } else {
                    return 0.5;
                }
            }

            if ($startDate->isSameDay($endDate) && $this->getSessionNumber($fromSession) !== $this->getSessionNumber($toSession)) {
                if (!in_array($leaveType, ['Marriage Leave', 'Sick Leave', 'Maternity Leave', 'Paternity Leave']) && !$startDate->isWeekend() && !$endDate->isWeekend() && !$this->isHoliday($startDate, $holidays) && !$this->isHoliday($endDate, $holidays)) {
                    return 1;
                } else {
                    return 1;
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
            return response()->json([
                'error' => 'An error occurred while calculating the number of days.'
            ], 500);
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
}
