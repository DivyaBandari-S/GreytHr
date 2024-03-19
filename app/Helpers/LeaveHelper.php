<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\LeaveRequest;

class LeaveHelper
{
    public static function calculateNumberOfDays($fromDate, $fromSession, $toDate, $toSession)
    {
        try {

            $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $fromDate . ' 00:00:00');
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $toDate . ' 00:00:00');

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

    public static function getApprovedLeaveDays($employeeId)
    {
        // Fetch approved leave requests
        $approvedLeaveRequests = LeaveRequest::where('emp_id', $employeeId)
            ->where('status', 'approved')
            ->whereIn('leave_type', ['Causal Leave Probation', 'Sick Leave', 'Loss Of Pay'])
            ->get();
        $totalCausalDays = 0;
        $totalSickDays = 0;
        $totalLossOfPayDays = 0;
    
        // Calculate the total number of days based on sessions for each approved leave request
        foreach ($approvedLeaveRequests as $leaveRequest) {
            $leaveType = $leaveRequest->leave_type;
            $days = self::calculateNumberOfDays(
                $leaveRequest->from_date,
                $leaveRequest->from_session,
                $leaveRequest->to_date,
                $leaveRequest->to_session
            );
            // Accumulate days based on leave type
            if ($leaveType === 'Causal Leave Probation') {
                $totalCausalDays += $days;
            } elseif ($leaveType === 'Sick Leave') {
                $totalSickDays += $days;
            } elseif ($leaveType === 'Loss Of Pay') {
                $totalLossOfPayDays += $days;
            }
        }
    
        return [
            'totalCausalDays' => $totalCausalDays,
            'totalSickDays' => $totalSickDays,
            'totalLossOfPayDays' => $totalLossOfPayDays,
        ];

    }
    
}
