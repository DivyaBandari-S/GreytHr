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


use App\Models\LeaveRequest;
use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Helpers\LeaveHelper;
use Carbon\Carbon;
use App\Livewire\LeavePage;
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
            Log::error('Error mounting leave request: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while fetching leave request details. Please try again later.');
            $this->leaveRequest = null;
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

        // Create a zip file for the images
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
    public $showViewFileDialog = false; // Toggle modal visibility
    public $files = []; // Store files array
    public $selectedFile; // Store the selected file's data


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

    //to count the sessions of leave applied
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
            session()->flash('error', "Error in getting details: " . $e->getMessage());
        }

        // Pass the leaveRequest data and leaveBalances to the Blade view
        return view('livewire.leave-history', [
            'leaveRequest' => $this->leaveRequest,
            'leaveBalances' => $leaveBalances,

        ]);
    }
}
