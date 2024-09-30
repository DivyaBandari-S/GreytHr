<?php
// File Name                       : ViewDetails.php
// Description                     : This file contains the implementation displaying details of pending leaves appear only for manager while approving.
// Creator                         : Bandari Divya
// Email                           : bandaridivya1@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : EmployeeDetails,LeaveRequest
namespace App\Livewire;

use App\Models\LeaveRequest;
use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Helpers\LeaveHelper;
use Carbon\Carbon;
use App\Livewire\LeavePage;
use App\Livewire\LeaveBalances;
use Illuminate\Support\Facades\Log;

class ViewDetails extends Component
{
    public $selectedLeaveRequestId;
    public $employeeId;
    public $leaveRequestId;
    public $full_name;
    public  $firstName;
    public $selectedYear;
    public $employeeDetails = [];
    public $leaveRequest;
    public $showViewImageDialog = false;

    public function mount($leaveRequestId)
    {
        try {
            // Fetch leave request details based on $leaveRequestId with employee details
            $this->leaveRequest = LeaveRequest::with('employee')->find($leaveRequestId);
            $this->selectedYear = Carbon::now()->format('Y');
            // Call the getLeaveBalances function to get leave balances
            $this->leaveRequest->leaveBalances = LeaveBalances::getLeaveBalances($this->leaveRequest->emp_id, $this->selectedYear);
            $this->firstName = $this->leaveRequest->employee->first_name . ' ' . $this->leaveRequest->employee->last_name;
            $this->leaveRequest->from_date = Carbon::parse($this->leaveRequest->from_date);
            $this->leaveRequest->to_date = Carbon::parse($this->leaveRequest->to_date);
        } catch (\Exception $e) {
            // Log the error
            Log::error($e);

            // Flash a message to the session
            session()->flash('error_message', 'An error occurred while fetching data. Please try again later.');

            // Redirect back or to a specific route
            return redirect()->back(); // Or redirect()->route('route.name');
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



    public function calculateNumberOfDays($fromDate, $fromSession, $toDate, $toSession, $leaveType)
    {
        try {
            $startDate = Carbon::parse($fromDate);
            $endDate = Carbon::parse($toDate);

            // Check if the start or end date is a weekend
            if ($startDate->isWeekend() || $endDate->isWeekend()) {
                return 0;
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
                if ($leaveType == 'Sick Leave') {
                    $totalDays += 1;
                } else {
                    if ($startDate->isWeekday()) {
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
            // Attempt to decode applying_to
            $applyingToJson = trim($this->leaveRequest->applying_to);
            $this->leaveRequest->applying_to = is_array($applyingToJson) ? $applyingToJson : json_decode($applyingToJson, true);

            // Attempt to decode cc_to
            $ccToJson = trim($this->leaveRequest->cc_to);
            $this->leaveRequest->cc_to = is_array($ccToJson) ? $ccToJson : json_decode($ccToJson, true);
            
            $filePathsJson = trim($this->leaveRequest->file_paths);
            $this->leaveRequest->file_paths = is_array($filePathsJson) ? $filePathsJson : json_decode($filePathsJson, true);
        } catch (\Exception $e) {
            Log::error("Exception occurred: " . $e->getMessage());
            session()->flash('error_message', 'An error occurred while processing the details. Please try again later.');
        }

        // Pass the leaveRequest data and leaveBalances to the Blade view
        return view('livewire.view-details', [
            'leaveRequest' => $this->leaveRequest,
        ]);
    }
}
