<?php
// File Name                       : LeaveHistory.php
// Description                     : This file contains the implementation of leave application pending details
// Creator                         : Bandari Divya
// Email                           : bandaridivya1@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : LeaveRequest,EmployeeDetails
namespace App\Livewire;

use App\Helpers\FlashMessageHelper;
use App\Models\LeaveRequest;
use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Helpers\LeaveHelper;
use Carbon\Carbon;
use App\Livewire\LeavePage;
use App\Models\HolidayCalendar;
use Illuminate\Support\Facades\Log;

class LeaveHistory extends Component
{
    public $selectedLeaveRequestId;
    public $employeeId;
    public $leaveRequestId;
    public $full_name;
    public $employeeDetails = [];
    public $leaveRequest;
    public $selectedYear;
    public $showViewImageDialog = false;
    public $showViewFileDialog = false;
    public $files = [];
    public $selectedFile;
    public $statusMap = [
        0 => 'Active',
        1 => 'InActive',
        2 => 'Approved',
        3 => 'Rejected',
        4 => 'Withdrawn',
        5 => 'Pending',
        6 => 'Re-applied',
        7 => 'Pending Leave Cancel'
    ];
    public function getStatusText($statusCode)
    {
        return $this->statusMap[$statusCode] ?? 'Unknown';
    }
    public function mount($leaveRequestId)
    {
        try {
            // Fetch leave request details based on $leaveRequestId with employee details
            $this->selectedYear = Carbon::now()->format('Y');
            $this->leaveRequest = LeaveRequest::with('employee')->find($leaveRequestId);
            $this->leaveRequest->from_date = Carbon::parse($this->leaveRequest->from_date);
            $this->leaveRequest->to_date = Carbon::parse($this->leaveRequest->to_date);
        } catch (\Exception $e) {
            // Handle the exception, log it, or display an error message
            FlashMessageHelper::flashError('An error occurred while fetching leave request details. Please try again later.');
            $this->leaveRequest = null;
            return false;
        }
    }
    public function downloadImage()
    {
        $fileDataArray = is_string($this->leaveRequest->file_paths)
            ? json_decode($this->leaveRequest->file_paths, true)
            : $this->leaveRequest->file_paths;

        // Filter images
        $images = array_filter(
            $fileDataArray,
            fn($fileData) => strpos($fileData['mime_type'], 'image') !== false,
        );
        // If only one image, provide direct download
        if (count($images) === 1) {
            $image = reset($images); // Get the single image
            $base64File = $image['data'];
            $mimeType = $image['mime_type'];
            $originalName = $image['original_name'];

            // Decode base64 content
            $fileContent = base64_decode($base64File);

            // Return the image directly
            return response()->stream(
                function () use ($fileContent) {
                    echo $fileContent;
                },
                200,
                [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => 'attachment; filename="' . $originalName . '"',
                ]
            );
        }

        // Create a zip file for the images
        if (count($images) > 1) {
            $zipFileName = 'images.zip';
            $zip = new \ZipArchive();
            $zip->open(storage_path($zipFileName), \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            foreach ($images as $image) {
                $base64File = $image['data'];
                $mimeType = $image['mime_type'];
                $extension = explode('/', $mimeType)[1];
                $imageName = uniqid() . '.' . $extension;

                $zip->addFromString($imageName, base64_decode($base64File));
            }

            $zip->close();

            // Return the zip file as a download
            return response()->download(storage_path($zipFileName))->deleteFileAfterSend(true);
        }
        // If no images, return an appropriate response
        return response()->json(['message' => 'No images found'], 404);
    }

    public function closeViewFile()
    {
        $this->showViewFileDialog = false;
    }
    public function showViewFile()
    {

        $this->showViewFileDialog = true;
    }

    public function showViewImage()
    {

        $this->showViewImageDialog = true;
    }
    public function closeViewImage()
    {
        $this->showViewImageDialog = false;
    }


    //used to calculate number of days for leave
    //it will calculate number of days for leave application
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
            if (
                $startDate->isSameDay($endDate) &&
                $this->getSessionNumber($fromSession) === $this->getSessionNumber($toSession)
            ) {
                // Inner condition to check if both start and end dates are weekdays (for non-Marriage leave)
                if (!in_array($leaveType, ['Marriage Leave', 'Sick Leave', 'Maternity Leave', 'Paternity Leave']) && !$startDate->isWeekend() && !$endDate->isWeekend() && !$this->isHoliday($startDate, $holidays) && !$this->isHoliday($endDate, $holidays)) {
                    return 0.5;
                } else {
                    return 0.5;
                }
            }

            if (
                $startDate->isSameDay($endDate) &&
                $this->getSessionNumber($fromSession) !== $this->getSessionNumber($toSession)
            ) {
                // Inner condition to check if both start and end dates are weekdays (for non-Marriage leave)
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
            FlashMessageHelper::flashError('An error occurred while calculating the number of days.');
            return false;
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

    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        // Call the getLeaveBalances function to get leave balances
        $leaveBalances = LeaveBalances::getLeaveBalances($employeeId, $this->selectedYear);

        try {
            // Attempt to decode applying_to
            $applyingToJson = trim($this->leaveRequest->applying_to);
            $this->leaveRequest->applying_to = is_array($applyingToJson) ? $applyingToJson : json_decode($applyingToJson, true);

            // Attempt to decode cc_to
            $ccToJson = trim($this->leaveRequest->cc_to);
            $this->leaveRequest->cc_to = is_array($ccToJson) ? $ccToJson : json_decode($ccToJson, true);

            // Attempt to decode file_oaths
            $filePathsJson = trim($this->leaveRequest->file_paths);
            $this->leaveRequest->file_paths = is_array($filePathsJson) ? $filePathsJson : json_decode($filePathsJson, true);
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('An error occured while getting details');
            return false;
        }

        // Pass the leaveRequest data and leaveBalances to the Blade view
        return view('livewire.leave-history', [
            'leaveRequest' => $this->leaveRequest,
            'leaveBalances' => $leaveBalances,

        ]);
    }
}
