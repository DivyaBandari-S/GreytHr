<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CompanyShifts;
use App\Models\HolidayCalendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Helpers\ApiResponse;
use App\Models\SwipeRecord;
use App\Models\CompanyShift;

class SwipeController extends Controller
{
    /**
     * Handle Swipe (Single API for both IN & OUT)
     */
    public function swipe(Request $request)
    {
        try {
            $user = Auth::guard('api')->user();
            if (!$user) {
                return ApiResponse::error(self::ERROR_STATUS, 'Unauthorized', self::UNAUTHORIZED);
            }

            // Validate the swipe type (must be IN or OUT)
            $request->validate([
                'in_or_out' => 'required|in:IN,OUT',
            ]);

            $inOrOut = $request->input('in_or_out');
            $currentTime = Carbon::now();
            $currentDate = $currentTime->toDateString(); // YYYY-MM-DD format

            // **Check if Today is a Holiday**
            if (HolidayCalendar::whereDate('date', $currentDate)->exists()) {
                return ApiResponse::error(
                    self::ERROR_STATUS,
                    "Swipe not allowed. Today (" . $currentTime->format('d-m-Y') . ") is a holiday.",
                    self::FORBIDDEN
                );
            }

            // **Get Assigned Shift Based on User's Shift Type**
            $shift = CompanyShifts::where('shift_name', $user->shift_type)
                ->whereIn('company_id', $user->company_id)
                ->first();

            if (!$shift) {
                return ApiResponse::error(self::ERROR_STATUS, 'No assigned shift found for this user.', self::NOT_FOUND);
            }
            if ($shift) {
                $formattedStart = Carbon::parse($shift->shift_start_time)->format('H:i');
                $formattedEnd = Carbon::parse($shift->shift_end_time)->format('H:i');
            }


            // Parse shift times and handle overnight shifts
            $shiftStart = Carbon::now()->setTimeFrom(Carbon::parse($shift->shift_start_time));
            $shiftEnd = Carbon::now()->setTimeFrom(Carbon::parse($shift->shift_end_time));

            if ($shiftStart->gt($shiftEnd)) {
                $shiftEnd = $shiftEnd->addDay(); // Handles overnight shifts
            }

            // **Get Last Swipe Record Within the Shift Period**
            $lastSwipe = SwipeRecord::where('emp_id', $user->emp_id)
                ->whereBetween('swipe_time', [$shiftStart, $shiftEnd])
                ->latest('swipe_time')
                ->first();

            // **Auto Swipe-Out If Last Swipe Was IN & No OUT Before Next Shift**
            if ($inOrOut === 'IN' && $lastSwipe && $lastSwipe->in_or_out === 'IN') {
                $lastSwipeTime = Carbon::parse($lastSwipe->swipe_time);
                $nextShiftStart = Carbon::now()->setTimeFrom(Carbon::parse($shift->shift_start_time));

                if ($lastSwipeTime->lt($nextShiftStart)) {
                    SwipeRecord::create([
                        'emp_id'         => $user->emp_id,
                        'swipe_time'     => $shiftEnd->copy()->subDay()->toDateTimeString(), // Auto swipe out at last shift's end
                        'in_or_out'      => 'OUT',
                        'sign_in_device' => $lastSwipe->sign_in_device,
                        'device_name'    => $lastSwipe->device_name,
                        'device_id'      => $lastSwipe->device_id,
                        'swipe_location' => $lastSwipe->swipe_location,
                        'swipe_remarks'  => 'Auto Swipe Out (Missed Swipe before next shift)',
                    ]);
                }
            }

            // **Prevent Multiple Swipe-Ins Within Shift Time**
            if ($inOrOut === 'IN' && $lastSwipe && $lastSwipe->in_or_out === 'IN') {
                return ApiResponse::error(
                    self::ERROR_STATUS,
                    'You have already swiped in for this shift. Please swipe out before swiping in again.',
                    self::FORBIDDEN
                );
            }

            // **Restrict Swipe-IN to Shift Time**
            if ($inOrOut === 'IN' && ($currentTime->lt($shiftStart) || $currentTime->gt($shiftEnd))) {
                return ApiResponse::error(
                    self::ERROR_STATUS,
                    "Swipe-In not allowed. Your shift is from " . $shiftStart->format('H:i') . " to " . $shiftEnd->format('H:i'),
                    self::FORBIDDEN
                );
            }

            // **Handle Swipe-OUT Restrictions**
            if ($inOrOut === 'OUT') {
                if (!$lastSwipe || $lastSwipe->in_or_out !== 'IN') {
                    return ApiResponse::error(
                        self::ERROR_STATUS,
                        'No active swipe-in found. Please swipe in first.',
                        self::FORBIDDEN
                    );
                }

                // Ensure Swipe-Out is after Swipe-In
                if ($currentTime->lt(Carbon::parse($lastSwipe->swipe_time))) {
                    return ApiResponse::error(
                        self::ERROR_STATUS,
                        'Invalid Swipe-Out. You cannot swipe out before your last swipe-in.',
                        self::FORBIDDEN
                    );
                }
            }

            // **Auto-detect device and location**
            $deviceInfo = $this->getDeviceDetails($request);
            $swipeLocation = $this->getSwipeLocation($request);

            // **Log Swipe (IN or OUT)**
            $swipeRecord = SwipeRecord::create([
                'emp_id'         => $user->emp_id,
                'swipe_time'     => $currentTime->toDateTimeString(),
                'in_or_out'      => $inOrOut,
                'sign_in_device' => $deviceInfo['device'],
                'device_name'    => $deviceInfo['device_name'],
                'device_id'      => $deviceInfo['device_id'],
                'swipe_location' => $swipeLocation,
                'swipe_remarks'  => $request->input('swipe_remarks', 'Automated Swipe'),
            ]);

            // **Format Response**
            $response = [
                'emp_id'         => $swipeRecord->emp_id,
                'swipe_time'     => Carbon::parse($swipeRecord->swipe_time)->format('d-m-Y H:i:s'),
                'in_or_out'      => $swipeRecord->in_or_out,
                'sign_in_device' => $swipeRecord->sign_in_device,
                'device_name'    => $swipeRecord->device_name,
                'device_id'      => $swipeRecord->device_id,
                'swipe_location' => $swipeRecord->swipe_location,
                'swipe_remarks'  => $swipeRecord->swipe_remarks,
                'shift_time' => "{$formattedStart} to {$formattedEnd}"
            ];

            return ApiResponse::success(self::SUCCESS_STATUS, "Swipe-$inOrOut successful", $response);
        } catch (\Exception $e) {
            Log::error("Swipe-$inOrOut error (Emp ID: {$user->emp_id}): " . $e->getMessage());
            return ApiResponse::error(self::ERROR_STATUS, 'Server Error', self::SERVER_ERROR);
        }
    }





    /**
     * Get Device Details Automatically
     */
    private function getDeviceDetails(Request $request)
    {
        $userAgent = $request->header('User-Agent') ?? 'Unknown Device';
        $deviceId = $request->ip() ?? 'Unknown IP';

        return [
            'device' => $this->detectDeviceType($userAgent),
            'device_name' => $userAgent,
            'device_id' => $deviceId,
            // 'os' => $this->detectOperatingSystem($userAgent),
        ];
    }

    private function detectDeviceType($userAgent)
    {
        $userAgent = strtolower($userAgent);

        if (strpos($userAgent, 'mobile') !== false || strpos($userAgent, 'android') !== false || strpos($userAgent, 'iphone') !== false) {
            return 'Mobile';
        }

        if (strpos($userAgent, 'tablet') !== false || strpos($userAgent, 'ipad') !== false) {
            return 'Tablet';
        }

        return 'Desktop';
    }

    private function detectOperatingSystem($userAgent)
    {
        $osArray = [
            'Windows NT 10.0' => 'Windows 10',
            'Windows NT 6.3' => 'Windows 8.1',
            'Windows NT 6.2' => 'Windows 8',
            'Windows NT 6.1' => 'Windows 7',
            'Windows NT 6.0' => 'Windows Vista',
            'Windows NT 5.1' => 'Windows XP',
            'Mac OS X' => 'macOS',
            'Android' => 'Android',
            'iPhone' => 'iOS',
            'iPad' => 'iOS',
            'Linux' => 'Linux',
        ];

        foreach ($osArray as $key => $os) {
            if (stripos($userAgent, $key) !== false) {
                return $os;
            }
        }

        return 'Unknown OS';
    }



    /**
     * Get Swipe Location Based on IP
     */
    private function getSwipeLocation(Request $request)
    {
        // $ip = $request->ip();
        $ip = $request->header('X-Forwarded-For') ?? $request->ip();
        // $location = GeoIP::getLocation($ip);
        // dd($location);
        // Skip for local addresses
        if ($ip === '127.0.0.1' || $ip === '::1') {
            return 'Localhost (Development Environment)';
        }

        // Use an external IP geolocation API
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get("http://ip-api.com/json/{$ip}");
            $data = json_decode($response->getBody(), true);

            if (!empty($data) && $data['status'] === 'success') {
                return "{$data['city']}, {$data['regionName']}, {$data['country']}";
            }
        } catch (\Exception $e) {
            Log::error("Location Fetch Error: " . $e->getMessage());
        }

        return 'Unknown Location';
    }
}
