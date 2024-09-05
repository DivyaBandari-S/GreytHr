<?php
// File Name                       : vdDetails.php
// Description                     : This file contains the implementation of the Approved leave applications details in detail.....,
// Creator                         : Bandari Divya
// Email                           : bandaridivya1@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : LeaveRequest,EmployeeDetails -->

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

class ApprovedDetails extends Component
{
    public $selectedLeaveRequestId;
    public $employeeId;
    public $leaveRequestId;
    public $full_name;
    public $employeeDetails = [];
    public $leaveRequest;
    public $selectedYear;
    public $leaveBalances;
    public $selectedWeek;
    public $startOfWeek;
    public $leaveApplications;
    public $leaveCount;
    public $endOfWeek;
    public $showViewImageDialog = false;

    public function mount($leaveRequestId)
    {
        try {
            // Fetch leave request details based on $leaveRequestId with employee details
            $this->selectedWeek = 'this_week';
            $this->setWeekDates();
            $this->leaveRequest = LeaveRequest::with('employee')->find($leaveRequestId);
            $this->leaveRequest->from_date = Carbon::parse($this->leaveRequest->from_date);
            $this->leaveRequest->to_date = Carbon::parse($this->leaveRequest->to_date);
            $this->selectedYear = Carbon::now()->format('Y');
            $this->leaveBalances = LeaveBalances::getLeaveBalances($this->leaveRequest->emp_id, $this->selectedYear);
        } catch (\Exception $e) {
            if ($e instanceof \Illuminate\Database\QueryException) {
                // Handle database query exceptions
                Log::error("Database error registering employee: " . $e->getMessage());
                session()->flash('emp_error', 'Database connection error occurred. Please try again later.');
            } elseif (strpos($e->getMessage(), 'Call to a member function store() on null') !== false) {
                // Display a user-friendly error message for null image
                session()->flash('emp_error', 'Please upload an image.');
            } elseif ($e instanceof \Illuminate\Http\Client\RequestException) {
                // Handle network request exceptions
                Log::error("Network error registering employee: " . $e->getMessage());
                session()->flash('emp_error', 'Network error occurred. Please try again later.');
            } elseif ($e instanceof \PDOException) {
                // Handle database connection errors
                Log::error("Database connection error registering employee: " . $e->getMessage());
                session()->flash('emp_error', 'Database connection error. Please try again later.');
            } else {
                // Handle other generic exceptions
                Log::error("Error registering employee: " . $e->getMessage());
                session()->flash('emp_error', 'Failed to register employee. Please try again later.');
            }
            // Redirect the user back to the registration page or any other appropriate action
            return redirect()->back();
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
                if (self::getSessionNumber($fromSession) !== self::getSessionNumber($toSession)) {
                    return 1;
                } elseif (self::getSessionNumber($fromSession) == self::getSessionNumber($toSession)) {
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
        return (int) str_replace('Session ', '', $session);
    }

    //this method used to fetch weekly dropdown data
    public function setWeekDates()
    {
        try {
            if ($this->selectedWeek === 'this_week') {
                $this->startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
                $this->endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');
            } elseif ($this->selectedWeek === 'next_week') {
                $this->startOfWeek = Carbon::now()->addWeek()->startOfWeek()->format('Y-m-d');
                $this->endOfWeek = Carbon::now()->addWeek()->endOfWeek()->format('Y-m-d');
            } elseif ($this->selectedWeek === 'last_week') {
                $this->startOfWeek = Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d');
                $this->endOfWeek = Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d');
            } elseif ($this->selectedWeek === 'this_month') {
                $this->startOfWeek = Carbon::now()->startOfMonth()->format('Y-m-d');
                $this->endOfWeek = Carbon::now()->endOfMonth()->format('Y-m-d');
            } elseif ($this->selectedWeek === 'next_month') {
                $this->startOfWeek = Carbon::now()->addMonth()->startOfMonth()->format('Y-m-d');
                $this->endOfWeek = Carbon::now()->addMonth()->endOfMonth()->format('Y-m-d');
            } elseif ($this->selectedWeek === 'last_month') {
                $this->startOfWeek = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
                $this->endOfWeek = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
            } else {
                // Handle any additional cases here
            }
            // Fetch leave applications based on the selected week
            $this->fetchLeaveApplications();
        } catch (\Exception $e) {
            if ($e instanceof \Illuminate\Database\QueryException) {
                // Handle database query exceptions
                Log::error("Database error registering employee: " . $e->getMessage());
                session()->flash('emp_error', 'Database connection error occurred. Please try again later.');
            } elseif (strpos($e->getMessage(), 'Call to a member function store() on null') !== false) {
                // Display a user-friendly error message for null image
                session()->flash('emp_error', 'Please upload an image.');
            } elseif ($e instanceof \Illuminate\Http\Client\RequestException) {
                // Handle network request exceptions
                Log::error("Network error registering employee: " . $e->getMessage());
                session()->flash('emp_error', 'Network error occurred. Please try again later.');
            } elseif ($e instanceof \PDOException) {
                // Handle database connection errors
                Log::error("Database connection error registering employee: " . $e->getMessage());
                session()->flash('emp_error', 'Database connection error. Please try again later.');
            } else {
                // Handle other generic exceptions
                Log::error("Error registering employee: " . $e->getMessage());
                session()->flash('emp_error', 'Failed to register employee. Please try again later.');
            }
            // Redirect the user back to the registration page or any other appropriate action
            return redirect()->back();
        }
    }


    public function updatedSelectedWeek()
    {
        $this->setWeekDates();
    }

    //
    public function fetchLeaveApplications()
    {
        try {
            // Fetch leave applications where status is approved, rejected, or withdrawn
            // and emp_id matches the logged-in employee's ID, and the leave period overlaps with the selected week
            $this->leaveApplications = LeaveRequest::whereIn('status', ['approved'])
                ->where('emp_id', auth()->guard('emp')->user()->emp_id)
                ->where(function ($query) {
                    $query->whereBetween('from_date', [$this->startOfWeek, $this->endOfWeek])
                        ->orWhereBetween('to_date', [$this->startOfWeek, $this->endOfWeek])
                        ->orWhere(function ($query) {
                            $query->where('from_date', '<', $this->startOfWeek)
                                ->where('to_date', '>', $this->endOfWeek);
                        });
                })
                ->get();
            $this->leaveCount =  $this->leaveApplications->count();
        } catch (\Exception $e) {
            if ($e instanceof \Illuminate\Database\QueryException) {
                // Handle database query exceptions
                Log::error("Database error registering employee: " . $e->getMessage());
                session()->flash('emp_error', 'Database connection error occurred. Please try again later.');
            } elseif (strpos($e->getMessage(), 'Call to a member function store() on null') !== false) {
                // Display a user-friendly error message for null image
                session()->flash('emp_error', 'Please upload an image.');
            } elseif ($e instanceof \Illuminate\Http\Client\RequestException) {
                // Handle network request exceptions
                Log::error("Network error registering employee: " . $e->getMessage());
                session()->flash('emp_error', 'Network error occurred. Please try again later.');
            } elseif ($e instanceof \PDOException) {
                // Handle database connection errors
                Log::error("Database connection error registering employee: " . $e->getMessage());
                session()->flash('emp_error', 'Database connection error. Please try again later.');
            } else {
                // Handle other generic exceptions
                Log::error("Error registering employee: " . $e->getMessage());
                session()->flash('emp_error', 'Failed to register employee. Please try again later.');
            }
            // Redirect the user back to the registration page or any other appropriate action
            return redirect()->back();
        }
    }


    public function render()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $employeeDetails = DB::table('employee_details')
                ->select(DB::raw("CONCAT(first_name, ' ', last_name) AS employee_name"))
                ->where('emp_id', $employeeId)
                ->first();

            if ($employeeDetails) {
                $employeeName = ucwords(strtolower($employeeDetails->employee_name));
            } else {
                $employeeName = 'Unknown';
            }
            // Call the getLeaveBalances function to get leave balances
            $leaveBalances = LeaveBalances::getLeaveBalances($employeeId, $this->selectedYear);

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
                Log::error('Error in JSON decoding: ' . $e->getMessage());
                // Handle the error gracefully
                // You can set an error message or take other actions here
            }

            // Pass the leaveRequest data and leaveBalances to the Blade view
            return view('livewire.approved-details', [
                'leaveRequest' => $this->leaveRequest,
                'leaveBalances' => $this->leaveBalances,
                'employeeName' => $employeeName
            ]);
        } catch (\Exception $e) {
            if ($e instanceof \Illuminate\Database\QueryException) {
                // Handle database query exceptions
                Log::error("Database error registering employee: " . $e->getMessage());
                session()->flash('emp_error', 'Database connection error occurred. Please try again later.');
            } elseif (strpos($e->getMessage(), 'Call to a member function store() on null') !== false) {
                // Display a user-friendly error message for null image
                session()->flash('emp_error', 'Please upload an image.');
            } elseif ($e instanceof \Illuminate\Http\Client\RequestException) {
                // Handle network request exceptions
                Log::error("Network error registering employee: " . $e->getMessage());
                session()->flash('emp_error', 'Network error occurred. Please try again later.');
            } elseif ($e instanceof \PDOException) {
                // Handle database connection errors
                Log::error("Database connection error registering employee: " . $e->getMessage());
                session()->flash('emp_error', 'Database connection error. Please try again later.');
            } else {
                // Handle other generic exceptions
                Log::error("Error registering employee: " . $e->getMessage());
                session()->flash('emp_error', 'Failed to register employee. Please try again later.');
            }
            // Redirect the user back to the registration page or any other appropriate action
            return redirect()->back();
        }
    }
}
