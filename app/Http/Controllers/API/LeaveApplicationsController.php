<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Livewire\LeaveBalances;
use App\Models\EmployeeLeaveBalances;
use App\Models\HolidayCalendar;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LeaveApplicationsController extends Controller
{
    //get total leave application history
    public function getTotalLeaveApplications(Request $request)
    {
        try {
            $employeeId = $request->input('employee_id');
            $selectedYear = $request->input('selected_year');
            $selectedYear = (int) $selectedYear;

            // Start building the query
            $query = LeaveRequest::where('emp_id', $employeeId)
                ->where('category_type', 'Leave')
                ->where(function ($query) use ($selectedYear) {
                    $query->whereYear('from_date', '=', $selectedYear)
                        ->orWhereYear('to_date', '=', $selectedYear)
                        ->orWhere(function ($query) use ($selectedYear) {
                            $query->where('from_date', '<=', Carbon::createFromDate($selectedYear, 12, 31))
                                ->where('to_date', '>=', Carbon::createFromDate($selectedYear, 1, 1));
                        });
                });

            // Apply leave_status filter if it's present in the request
            if ($request->has('leave_status')) {
                $leaveStatus = $request->input('leave_status');
                $query->where('leave_status', $leaveStatus);
            }

            // Apply cancel_status filter if it's present in the request
            if ($request->has('cancel_status')) {
                $cancelStatus = $request->input('cancel_status');
                $query->whereIn('cancel_status', $cancelStatus);
            }
            // Apply cancel_status filter if it's present in the request
            if ($request->has('leave_type')) {
                $leaveType = $request->input('leave_type');
                $query->whereIn('leave_type', $leaveType);
            }

            // Execute the query to get the leave requests
            $approvedLeaveRequests = $query->get();

            return ApiResponse::success(self::SUCCESS_STATUS, self::SUCCESS_MESSAGE, [
                'approvedLeaveRequests' => $approvedLeaveRequests,
            ]);
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return ApiResponse::error(self::ERROR_STATUS, self::INTERNAL_SERVER_ERROR, self::SERVER_ERROR);
        }
    }


    //get granted leave balance method
    public function getGrantedLeaveBalance(Request $request)
    {
        try {
            $employeeId = $request->input('employeeId');
            $selectedYear = $request->input('selectedYear');
            $leaveName = $request->input('leave_type');

            // Get leave balances for the specified employee and year
            $balances = EmployeeLeaveBalances::where('emp_id', $employeeId)
                ->where('period', 'like', "%$selectedYear%")
                ->get();

            // Initialize total granted days
            $totalGrantDays = 0;

            // Loop through each balance record
            foreach ($balances as $balance) {
                // Decode the leave_policy_id column (assuming it's a JSON string)
                $leavePolicies = is_string($balance->leave_policy_id) ? json_decode($balance->leave_policy_id, true) : $balance->leave_policy_id;

                // Ensure leavePolicies is an array
                if (is_array($leavePolicies)) {
                    foreach ($leavePolicies as $policy) {
                        // Check if the leave_name matches the specified leave_name
                        if (isset($policy['leave_name']) && $policy['leave_name'] == $leaveName) {
                            // Add the grant_days for the specified leave_name
                            $totalGrantDays += $policy['grant_days'];
                        }
                    }
                }
            }

            // Round total granted days to 2 decimal places
            $totalGrantDays = round($totalGrantDays, 2);

            // Return the total granted days as part of the response
            return ApiResponse::success(self::SUCCESS_STATUS, self::SUCCESS_MESSAGE, [
                'totalGrantDays' => $totalGrantDays,
            ]);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error occurred while calculating granted leave balance: ' . $e->getMessage());
            // Return an error response
            return ApiResponse::error(self::ERROR_STATUS, self::INTERNAL_SERVER_ERROR, 'An error occurred while calculating the granted leave balance.');
        }
    }


    //get calculate days for leave
    public function calculateLeaveDays(Request $request)
    {
        try {
            // Validate incoming request
            $request->validate([
                'from_date' => 'required|date',
                'from_session' => 'required|string',
                'to_date' => 'required|date',
                'to_session' => 'required|string',
                'leave_type' => 'required|string',
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
