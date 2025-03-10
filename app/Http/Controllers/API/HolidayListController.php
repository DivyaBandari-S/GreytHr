<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\HolidayCalendar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HolidayListController extends Controller
{
    //
    public function index(Request $request)
    {
        // Get the year from the request, default to the current year if not provided
        $year = $request->input('year', Carbon::now()->year);
        // Fetch holidays for the given year
        $holidays = HolidayCalendar::whereYear('date', $year)->get(['date', 'festivals']);
        // If no holidays are found, return an error response
        if ($holidays->isEmpty()) {
            return ApiResponse::error(
                self::ERROR_STATUS,
                "No holidays found for the year $year.",
                self::NOT_FOUND
            );
        }

        // Transform holidays to include the day name
        $formattedHolidays = $holidays->map(function ($holiday) {
            return [
                'date' => $holiday->date,
                'day' => Carbon::parse($holiday->date)->format('l'), // 'l' format gives full day name
                'festival' => $holiday->festivals,
            ];
        });

        return ApiResponse::success(
            self::SUCCESS_STATUS,
            "Holidays for the year $year retrieved successfully",
            [
                'year' => $year,
                'total_holidays' => $holidays->count(),
                'holidays' => $formattedHolidays,
            ],
            self::SUCCESS
        );
    }

    /**
     * Fetch upcoming holidays for the current month (excluding past dates).
     */
    /**
     * Fetch upcoming holidays based on the requested month or year.
     */

    public function getUpcomingHolidays(Request $request)
    {
        $currentDate = Carbon::now()->format('Y-m-d'); // Today's date
        $currentMonth = Carbon::now()->month; // Numeric (1-12)
        $currentYear = Carbon::now()->year; // Four-digit year

        // Get request parameters (month or year)
        $month = $request->input('month');
        $year = $request->input('year');

        // If both month and year are missing, default to current month
        if (!$month && !$year) {
            $month = $currentMonth;
            $year = $currentYear;
        }

        // Validate month if provided
        if ($month && (!is_numeric($month) || $month < 1 || $month > 12)) {
            return ApiResponse::error(
                self::ERROR_STATUS,
                "Invalid month. Please provide a value between 1 and 12.",
                self::ERROR
            );
        }

        // Validate year if provided
        if ($year && (!is_numeric($year) || strlen($year) != 4)) {
            return ApiResponse::error(
                self::ERROR_STATUS,
                "Invalid year. Please provide a valid four-digit year (e.g., 2025).",
                self::ERROR
            );
        }

        // Initialize query
        $query = HolidayCalendar::orderBy('date', 'asc');

        if ($year && !$month) {
            // 🟢 Case 1: Fetch all upcoming holidays for the year
            $query->whereYear('date', $year)->where('date', '>=', $currentDate);
        } elseif ($month && !$year) {
            // 🟡 Case 2: Fetch holidays for the month only
            if ($month == $currentMonth) {
                $query->whereYear('date', $currentYear)
                    ->whereMonth('date', $month)
                    ->where('date', '>=', $currentDate);
            } elseif ($month > $currentMonth) {
                $query->whereYear('date', $currentYear)
                    ->whereMonth('date', $month);
            } else {
                return ApiResponse::error(
                    self::ERROR_STATUS,
                    "Invalid request. The selected month has already passed. Use a future month.",
                    self::ERROR
                );
            }
        } else {
            // 🟠 Case 3: Fetch for a specific month and year
            if ($year == $currentYear && $month == $currentMonth) {
                $query->whereYear('date', $year)
                    ->whereMonth('date', $month)
                    ->where('date', '>=', $currentDate);
            } elseif ($year >= $currentYear) {
                $query->whereYear('date', $year)
                    ->whereMonth('date', $month);
            } else {
                return ApiResponse::error(
                    self::ERROR_STATUS,
                    "Invalid request. The selected year has already passed.",
                    self::ERROR
                );
            }
        }

        // Fetch holidays
        $holidays = $query->get(['date', 'festivals']);

        // If no upcoming holidays are found, return an error response
        if ($holidays->isEmpty()) {
            return ApiResponse::error(
                self::ERROR_STATUS,
                "No upcoming holidays found for the selected period.",
                self::NOT_FOUND
            );
        }

        // Group holidays by month
        $groupedHolidays = [];
        foreach ($holidays as $holiday) {
            $holidayMonth = Carbon::parse($holiday->date)->format('F'); // Get full month name

            if (!isset($groupedHolidays[$holidayMonth])) {
                $groupedHolidays[$holidayMonth] = [
                    'month' => $holidayMonth,
                    'total_holidays' => 0,
                    'holidays' => []
                ];
            }

            $groupedHolidays[$holidayMonth]['total_holidays']++;
            $groupedHolidays[$holidayMonth]['holidays'][] = [
                'date' => $holiday->date,
                'day' => Carbon::parse($holiday->date)->format('l'), // Get day name
                'festival' => $holiday->festivals
            ];
        }

        return ApiResponse::success(
            self::SUCCESS_STATUS,
            "Upcoming holidays retrieved successfully",
            [
                'year' => $year ?? $currentYear,
                'total_months' => count($groupedHolidays),
                'months' => array_values($groupedHolidays), // Reset array keys for JSON response
            ],
            self::SUCCESS
        );
    }
}
