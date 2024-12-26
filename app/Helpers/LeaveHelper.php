<?php

namespace App\Helpers;

use App\Models\HolidayCalendar;
use Carbon\Carbon;
use App\Models\LeaveRequest;

class LeaveHelper
{
    public static function calculateNumberOfDays($fromDate, $fromSession, $toDate, $toSession, $leaveType)
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
               self::getSessionNumber($fromSession) ===self::getSessionNumber($toSession)
            ) {
                // Inner condition to check if both start and end dates are weekdays (for non-Marriage leave)
                if (!in_array($leaveType, ['Marriage Leave', 'Sick Leave', 'Maternity Leave', 'Paternity Leave']) && !$startDate->isWeekend() && !$endDate->isWeekend() && !self::isHoliday($startDate, $holidays) && !self::isHoliday($endDate, $holidays)) {
                    return 0.5;
                } else {
                    return 0;
                }
            }

            if (
                $startDate->isSameDay($endDate) &&
               self::getSessionNumber($fromSession) !== self::getSessionNumber($toSession)
            ) {
                // Inner condition to check if both start and end dates are weekdays (for non-Marriage leave)
                if (!in_array($leaveType, ['Marriage Leave', 'Sick Leave', 'Maternity Leave', 'Paternity Leave']) && !$startDate->isWeekend() && !$endDate->isWeekend() && !self::isHoliday($startDate, $holidays) && !self::isHoliday($endDate, $holidays)) {
                    return 1;
                } else {
                    return 0;
                }
            }

            $totalDays = 0;

            while ($startDate->lte($endDate)) {
                // For non-Marriage leave type, skip holidays and weekends, otherwise include weekdays
                if (!in_array($leaveType, ['Marriage Leave', 'Sick Leave', 'Maternity Leave', 'Paternity Leave'])) {
                    if (!self::isHoliday($startDate, $holidays) && $startDate->isWeekday()) {
                        $totalDays += 1;
                    }
                } else {
                    // For Marriage leave type, count all weekdays without excluding weekends or holidays
                    if (!self::isHoliday($startDate, $holidays)) {
                        $totalDays += 1;
                    }
                }

                // Move to the next day
                $startDate->addDay();
            }

            // Deduct weekends based on the session numbers
            if (self::getSessionNumber($fromSession) > 1) {
                $totalDays -=self::getSessionNumber($fromSession) - 1; // Deduct days for the starting session
            }
            if (self::getSessionNumber($toSession) < 2) {
                $totalDays -= 2 -self::getSessionNumber($toSession); // Deduct days for the ending session
            }

            // Adjust for half days
            if (self::getSessionNumber($fromSession) === self::getSessionNumber($toSession)) {
                if (self::getSessionNumber($fromSession) !== 1) {
                    $totalDays += 0.5; // Add half a day
                } else {
                    $totalDays += 0.5;
                }
            } elseif (self::getSessionNumber($fromSession) !== self::getSessionNumber($toSession)) {
                if (self::getSessionNumber($fromSession) !== 1) {
                    $totalDays += 1; // Add half a day
                }
            } else {
                $totalDays += (self::getSessionNumber($toSession) - self::getSessionNumber($fromSession) + 1) * 0.5;
            }

            return $totalDays;
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('An error occurred while calculating the number of days.');
            return false;
        }
    }

    private static function isHoliday($date, $holidays)
    {
        // Check if the date exists in the holiday collection
        return $holidays->contains('date', $date->toDateString());
    }

    private static function getSessionNumber($session)
    {
        // Customize this function to return session number (e.g., "Session 1" -> 1)
        return (int) str_replace('Session ', '', $session);
    }


    public static function getApprovedLeaveDays($employeeId, $selectedYear)
    {
        try {

            // Fetch approved leave requests
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
                    'Paternity Leave'
                ])
                ->whereYear('to_date', '=', $selectedYear)
                ->get();
            $totalCasualDays = 0;
            $totalCasualLeaveProbationDays = 0;
            $totalSickDays = 0;
            $totalLossOfPayDays = 0;
            $totalMaternityDays = 0;
            $totalMarriageDays = 0;
            $totalPaternityDays = 0;

            // Calculate the total number of days based on sessions for each approved leave request
            foreach ($approvedLeaveRequests as $leaveRequest) {
                $leaveType = $leaveRequest->leave_type;
                $days = self::calculateNumberOfDays(
                    $leaveRequest->from_date,
                    $leaveRequest->from_session,
                    $leaveRequest->to_date,
                    $leaveRequest->to_session,
                    $leaveRequest->leave_type
                );

                // Accumulate days based on leave type
                switch ($leaveType) {
                    case 'Casual Leave':
                        $totalCasualDays += $days;
                        break;
                    case 'Sick Leave':
                        $totalSickDays += $days;
                        break;
                    case 'Loss Of Pay':
                        $totalLossOfPayDays += $days;
                        break;
                    case 'Casual Leave Probation':
                        $totalCasualLeaveProbationDays += $days;
                        break;
                    case 'Maternity Leave':
                        $totalMaternityDays += $days;
                        break;
                    case 'Marriage Leave':
                        $totalMarriageDays += $days;
                        break;
                    case 'Paternity Leave': // Corrected the spelling
                        $totalPaternityDays += $days;
                        break;
                }
            }

            return [
                'totalCasualDays' => $totalCasualDays,
                'totalCasualLeaveProbationDays' => $totalCasualLeaveProbationDays,
                'totalSickDays' => $totalSickDays,
                'totalLossOfPayDays' => $totalLossOfPayDays,
                'totalMaternityDays' => $totalMaternityDays,
                'totalMarriageDays' => $totalMarriageDays,
                'totalPaternityDays' => $totalPaternityDays,
            ];
        } catch (\Exception $e) {
            // Log the error message or handle it as needed
            FlashMessageHelper::flashError('An error occurred while fetching leave days. Please try again later.');
            return null; // Return null or an empty array to indicate failure
        }
    }

    public static function getApprovedLeaveDaysOnSelectedDay($employeeId, $selectedYear)
    {
        // Fetch approved leave requests

        $approvedLeaveRequests = LeaveRequest::where('emp_id', $employeeId)
            ->where(function ($query) {
                $query->where('leave_status', 2)
                    ->whereIn('cancel_status', [6, 5, 3, 4]); // Check both 'leave_status' and 'cancel_status'
            })
            ->whereIn('leave_type', [
                'Casual Leave Probation',
                'Loss Of Pay',
                'Sick Leave',
                'Casual Leave',
                'Maternity Leave',
                'Marriage Leave',
                'Paternity Leave'
            ])
            ->where('to_date', '=', $selectedYear)
            ->get();



        $totalCasualDays = 0;
        $totalCasualLeaveProbationDays = 0;
        $totalSickDays = 0;
        $totalLossOfPayDays = 0;
        $totalMaternityDays = 0;
        $totalMarriageDays = 0;
        $totalPaternityDays = 0;

        // Calculate the total number of days based on sessions for each approved leave request
        foreach ($approvedLeaveRequests as $leaveRequest) {
            $leaveType = $leaveRequest->leave_type;
            $days = self::calculateNumberOfDays(
                $leaveRequest->from_date,
                $leaveRequest->from_session,
                $leaveRequest->to_date,
                $leaveRequest->to_session,
                $leaveRequest->leave_type
            );

            // Accumulate days based on leave type
            switch ($leaveType) {
                case 'Casual Leave':
                    $totalCasualDays += $days;
                    break;
                case 'Sick Leave':

                    $totalSickDays += $days;
                    break;
                case 'Loss Of Pay':
                    $totalLossOfPayDays += $days;
                    break;
                case 'Casual Leave Probation':
                    $totalCasualLeaveProbationDays += $days;
                    break;
                case 'Maternity Leave':
                    $totalMaternityDays += $days;
                    break;
                case 'Marriage Leave':
                    $totalMarriageDays += $days;
                    break;
                case 'Petarnity Leave':
                    $totalPaternityDays += $days;
                    break;
            }
        }
        return [
            'totalCasualDays' => $totalCasualDays,
            'totalCasualLeaveProbationDays' => $totalCasualLeaveProbationDays,
            'totalSickDays' => $totalSickDays,
            'totalLossOfPayDays' => $totalLossOfPayDays,
            'totalMaternityDays' => $totalMaternityDays,
            'totalMarriageDays' => $totalMarriageDays,
            'totalPaternityDays' => $totalPaternityDays,
        ];
    }
}
