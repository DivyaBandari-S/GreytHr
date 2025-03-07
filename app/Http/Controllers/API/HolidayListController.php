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
}
