<?php
// File Name                       : LeavePending.php
// Description                     : This file contains the implementation of leave application history details
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
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class LeavePending extends Component
{
    public $selectedLeaveRequestId;
    public $employeeId;
    public $leaveRequestId;
    public $full_name;
    public $employeeDetails = [];
    public $leaveRequest;
    public $selectedYear;
    public $applyingTo;
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
            // Handle the exception here
            $errorMessage = 'Error occurred while getting leave request: ' . $e->getMessage();
            session()->flash('error', $errorMessage);
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


    public function calculateNumberOfDays($fromDate, $fromSession, $toDate, $toSession)
    {
        try {
            $startDate = Carbon::parse($fromDate);
            $endDate = Carbon::parse($toDate);

            // Check if the start or end date is a weekend
            if ($startDate->isWeekend() || $endDate->isWeekend()) {
                return 'Error: Selected dates fall on a weekend. Please choose weekdays.';
            }

            // Check if the start and end sessions are different on the same day
            if ($startDate->isSameDay($endDate)) {
                if ($this->getSessionNumber($fromSession) !== $this->getSessionNumber($toSession)) {
                    return 1;
                } elseif ($this->getSessionNumber($fromSession) == $this->getSessionNumber($toSession)) {
                    return 0.5;
                } else {
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
    private function getSessionNumber($session)
    {
        // You might need to customize this based on your actual session values
        return (int) str_replace('Session ', '', $session);
    }

    public function render()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            // Call the getLeaveBalances function to get leave balances
            $leaveBalances = LeaveBalances::getLeaveBalances($employeeId, $this->selectedYear);

            // Attempt to decode applying_to
            $applyingToJson = trim($this->leaveRequest->applying_to);
            $this->leaveRequest->applying_to = is_array($applyingToJson) ? $applyingToJson : json_decode($applyingToJson, true);

            // Attempt to decode cc_to
            $ccToJson = trim($this->leaveRequest->cc_to);
            $this->leaveRequest->cc_to = is_array($ccToJson) ? $ccToJson : json_decode($ccToJson, true);

            $filePathsJson = trim($this->leaveRequest->file_paths);
            $this->leaveRequest->file_paths = is_array($filePathsJson) ? $filePathsJson : json_decode($filePathsJson, true);

            // Pass the leaveRequest data and leaveBalances to the Blade view
            return view('livewire.leave-pending', [
                'leaveRequest' => $this->leaveRequest,
                'leaveBalances' => $leaveBalances,
            ]);
        } catch (\Exception $e) {
            // Handle the exception, log it, or display an error message
            Log::error('Error rendering leave pending page: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while loading leave history page. Please try again later.');
            return redirect()->back();
        }
    }
}
