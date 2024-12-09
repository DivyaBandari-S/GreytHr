<?php

namespace App\Livewire;

use App\Models\IncidentRequest;
use Livewire\Component;
use App\Models\EmployeeDetails;
use App\Models\PeopleList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Models\HelpDesks;
use App\Mail\HelpDeskotification;
use App\Models\Request;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;
use App\Helpers\FlashMessageHelper;
use App\Mail\IncidentRequestMail;
use App\Mail\ServiceRequestMail;
use App\Models\IT;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class IncidentRequests extends Component
{

    public $ServiceRequestaceessDialog = false;
    public $incidentRequestaceessDialog = false;
    use WithFileUploads;
    public $isOpen = false;
  
    public $short_description;
    public $rejection_reason;
    public $full_name;
    public $selectedCategory = [];
    public $file_paths = [];

    public $activeCategory = '';
    public $pendingCategory = '';
    public $closedCategory = '';
    public $searchTerm = '';
    public $showViewFileDialog = false;
    public $showModal = false;
    public $search = '';
    public $isRotated = false;
    public $images = [];

    public $files=[];
    public $requestId;

    public $requestCategories = '';
    public $selectedPerson = null;
    public $peoples;
    public $filteredPeoples;
    public $showserviceViewFileDialog = false;
    public $peopleFound = true;
    public $category;
    public $ccToArray = [];
    public $request;
    public $subject;
    public $description;
    public $file_path;
    public $cc_to;
    public $priority;
    public $servicerecords;
    public $records;
    public $image;
    public $mobile;
    public $selectedPeopleNames = [];
    public $employeeDetails;
    public $showDialog = false;
    public $fileContent, $file_name, $mime_type;

    public $showDialogFinance = false;
    public $record;
    public $peopleData = '';
    public $filterData;
    public $activeTab = 'active';
    public $selectedPeople = [];
    public $activeSearch = [];
    public $pendingSearch = '';
    public $closedSearch = '';
    public $showViewImageDialog=false;



    protected $rules = [

        'short_description' => 'required|string|max:255',

        'description' => 'required|string',

        'priority' => 'required|in:High,Medium,Low',


        'file_path' => 'nullable|file|mimes:xls,csv,xlsx,pdf,jpeg,png,jpg,gif|max:40960',

    ];
    protected $messages = [
        'priority.required' => 'Priority is required.',
        'description.required' => ' Description is required.',
        'short_description.required' => 'Short description required',
    ];

    public function validateField($field)
    {
        if (in_array($field, ['description', 'category', 'priority', 'short_description'])) {
            $this->validateOnly($field, $this->rules);
        }
    }
    public function open()
    {
        $this->showDialog = true;
    }
    public function mount()
    {
        // Fetch unique requests with their categories
        $requestCategories = Request::select('Request', 'category')->get();

        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
        $companyId = auth()->guard('emp')->user()->company_id;
        $this->peoples = EmployeeDetails::whereJsonContains('company_id', $companyId)->whereNotIn('employee_status', ['rejected', 'terminated'])->get();

        $this->peopleData = $this->filteredPeoples ? $this->filteredPeoples : $this->peoples;
        $this->selectedPeople = [];
        $this->selectedPeopleNames = [];
        $employeeName = auth()->user()->first_name . ' #(' . $employeeId . ')';
        $this->records = IncidentRequest::with('emp')
            ->whereHas('emp', function ($query) {
                $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy('created_at', 'desc')


            ->get();
        $this->servicerecords = ServiceRequest::with('emp')
            ->whereHas('emp', function ($query) {
                $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy('created_at', 'desc')


            ->get();


        if ($this->employeeDetails) {
            // Combine first and last names
            $this->full_name = $this->employeeDetails->first_name . ' ' . $this->employeeDetails->last_name;
        }

        $this->filterData = [];
        $this->peoples = EmployeeDetails::whereJsonContains('company_id', $companyId)->whereNotIn('employee_status', ['rejected', 'terminated'])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
        $this->loadHelpDeskData();
    }



    public function cancelIncidentRequest()
    {

        $this->incidentRequestaceessDialog = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->resetIncidentFields();
    }
    public function cancelServiceRequest()
    {

        $this->ServiceRequestaceessDialog = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->resetIncidentFields();
    }


    public function openFinance()
    {
        $this->showDialogFinance = true;
    }
    public function updatedCategory()
    {
        $this->filter();
        logger($this->category); // Log selected category
        logger($this->records); // Log filtered records
    }

    public function loadHelpDeskData()
    {
        $this->activeCategory = '';
        $this->pendingCategory = '';
        $this->closedCategory = '';
        $this->activeSearch = '';
        $this->pendingSearch = '';
        $this->closedSearch = '';
        if ($this->activeTab === 'active') {

            $this->searchActiveHelpDesk();
        } elseif ($this->activeTab === 'pending') {

            $this->searchPendingHelpDesk();
        } elseif ($this->activeTab === 'closed') {
            $this->searchClosedHelpDesk();
        }
    }

    public function updatedActiveTab()
    {
        $this->loadHelpDeskData(); // Reload data when the tab is updated
    }



    public function searchHelpDesk($status, $searchTerm, $selectedCategory, $requestId = null, $priority = null)
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;

        // Base query for employee-specific requests
        // IncidentRequest query

        $this->records = IncidentRequest::where(function ($query) use ($employeeId) {
            $query->where('emp_id', $employeeId);
        });

        // ServiceRequest query


        // Combine both queries using union
        $query = $this->records
            ->orderBy('created_at', 'desc');

        // Apply status filtering for 10 and 8
        if (is_array($status)) {
            $query->whereIn('status_code', $status); // Example: 8 and 10 status codes
        } else {
            $query->where('status_code', $status);
        }

        // Apply active category filter if selected
        if (!empty($selectedCategory)) {
            $query->where(function ($query) use ($selectedCategory) {
                $query->where('category', $selectedCategory);
            });
        }

        // Apply search term filtering (if provided)
        if (!empty($searchTerm)) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('emp_id', 'like', '%' . $searchTerm . '%') // Employee ID
                      ->orWhere('snow_id', 'like', '%' . $searchTerm . '%') // Request ID
                      ->orWhere('priority', 'like', '%' . $searchTerm . '%') // Priority
                      ->orWhereHas('emp', function ($query) use ($searchTerm) { // Related employee name
                          $query->where('first_name', 'like', '%' . $searchTerm . '%')
                                ->orWhere('last_name', 'like', '%' . $searchTerm . '%');
                      });
            });
        }
        // Fetch and assign the results
        $this->filterData = $query->orderBy('created_at', 'desc')->get();
        $this->peopleFound = count($this->filterData) > 0;
    }




    public function searchActiveHelpDesk()
    {

        $this->searchHelpDesk(
            [8, 10],
            $this->activeSearch,
            $this->activeCategory,      // Request ID
        );
    }

    public function searchPendingHelpDesk()
    {
        $this->searchHelpDesk(
            5,
            $this->pendingSearch,
            $this->pendingCategory,          // Request ID
        );
    }

    public function searchClosedHelpDesk()
    {
        $this->searchHelpDesk(
            [11, 3],
            $this->closedSearch,
            $this->closedCategory,       // Request ID
        );
    }

    public function showRejectionReason($id)
    {
  
        $record = HelpDesks::findOrFail($id);
    
        if ($record && $record->status_code === 3) {
            $this->rejection_reason = $record->rejection_reason;
       
            $this->isOpen = true;
        } else {
            $this->dispatchBrowserEvent('notification', ['message' => 'Reason not available.']);
        }
    }
    public function closeModal()
    {
        $this->isOpen = false;
        $this->rejection_reason = null;
    }
    public function close()
    {
        $this->showDialog = false;
        $this->isRotated = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->reset(['subject', 'description', 'cc_to', 'category', 'file_path', 'priority', 'image', 'selectedPeopleNames', 'selectedPeople']);
    }

    public function closeFinance()
    {
        $this->showDialogFinance = false;
    }



    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    protected function addErrorMessages($messages)
    {
        foreach ($messages as $field => $message) {
            $this->addError($field, $message[0]);
        }
    }

    public function openForDesks($taskId)
    {
        $task = IncidentRequest::find($taskId);

        if ($task) {
            $task->update(['status_code' => 12]);
        }
        return redirect()->to('/HelpDesk');
    }

    public function closeForDesks($taskId)
    {
        $task = IncidentRequest::find($taskId);

        if ($task) {
            $task->update(['status_code' => 10]);
        }
        return redirect()->to('/HelpDesk');
    }
    public function setActiveTab($tab)
    {

        $this->activeTab = $tab;
    }
    public function Catalog()
    {
        return redirect()->to('/catalog');
    }

    public function selectPerson($personId)
    {
        try {
            if (count($this->selectedPeopleNames) >= 5 && !in_array($personId, $this->selectedPeople)) {

                return;
            }


            $selectedPerson = $this->peoples->where('emp_id', $personId)->first();

            if ($selectedPerson) {
                if (in_array($personId, $this->selectedPeople)) {
                    $this->selectedPeopleNames[] =  ucwords(strtolower($selectedPerson->first_name)) . ' ' . ucwords(strtolower($selectedPerson->last_name)) . ' #(' . $selectedPerson->emp_id . ')';
                } else {
                    $this->selectedPeopleNames = array_diff($this->selectedPeopleNames, [ucwords(strtolower($selectedPerson->first_name)) . ' ' . ucwords(strtolower($selectedPerson->last_name)) . ' #(' . $selectedPerson->emp_id . ')']);
                }
                $this->cc_to = implode(', ', array_unique($this->selectedPeopleNames));
            }
        } catch (\Exception $e) {
            // Log the exception message or handle it as needed
            Log::error('Error selecting person: ' . $e->getMessage());
            // Optionally, you can set an error message to display to the user
            $this->dispatchBrowserEvent('error', ['message' => 'An error occurred while selecting the person. Please try again.']);
        }
    }




    public function showFile($id)
    {
        $record = IncidentRequest::findOrFail($id);

        if ($record && $record->file_path !== 'N/A') {
            $mimeType = 'image/jpeg'; // Adjust as necessary

            return response($record->file_path, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="image.jpg"'); // Adjust filename and extension as needed
        }

        return abort(404, 'File not found');
    }

    public $recordId;
    public $viewrecord;
    public function downloadFilesAsZip($id)
    {
        // Fetch the record
        $record = IncidentRequest::find($id);
        if (!$record) {
            return response()->json(['error' => 'Record not found'], 404);
        }
    
        $files = $record->getImageUrlsAttribute(); // Assuming this retrieves an array of files
        if (empty($files)) {
            return response()->json(['error' => 'No files available for download'], 404);
        }
    
        // Create a unique name for the ZIP file
        $zipFileName = 'files_' . $id . '_' . time() . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);
    
        // Create a new ZIP archive
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($files as $file) {
                $fileContent = base64_decode($file['data']);
                $originalName = $file['original_name'];
                $zip->addFromString($originalName, $fileContent);
            }
            $zip->close();
        } else {
            return response()->json(['error' => 'Unable to create ZIP file'], 500);
        }
    
        // Return the ZIP file for download
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function showViewFile($id)
    {
        $this->records = IncidentRequest::findOrFail($id);

        if ($this->records && $this->records->file_path !== 'null') {
            $this->file_path = $this->records->file_path;
            $this->showViewFileDialog = true;
        } else {
            // Handle case where file is not found or is null
            $this->dispatch('file-not-found', ['message' => 'File not found.']);
        }
    }
    public function showserviceViewFile($id)
    {
        $this->servicerecords = ServiceRequest::findOrFail($id);

        if ($this->servicerecords &&   $this->servicerecords->file_path !== 'null') {
            $this->file_path = $this->records->file_path;
            $this->showserviceViewFileDialog = true;
        } else {
            // Handle case where file is not found or is null
            $this->dispatch('file-not-found', ['message' => 'File not found.']);
        }
    }
    public $showImageDialog = false;
    public $imageUrl;

    public function getImageUrlAttribute()
    {
        if ($this->file_path && $this->mime_type) {
            return 'data:' . $this->mime_type . ';base64,' . base64_encode($this->file_path);
        }
        return null;
    }

    public function showImage($url)
    {
        $this->imageUrl = $url;

        $this->showImageDialog = true;
    }

    public function closeImageDialog()
    {
        $this->showImageDialog = false;
    }

    public function show()
    {
        $this->showDialog = true;
    }

    public function closeViewFile()
    {
        $this->showViewFileDialog = false;
    }
    public function resetIncidentFields()
    {

        $this->short_description = null;
        $this->priority = null;
        $this->description = null;
        $this->resetErrorBag();
        $this->resetValidation();
    }
    public function downloadActiveImage()
    {
        if (!isset($this->images[$this->currentImageIndex])) {
            session()->flash('error', 'No active image to download.');
            return;
        }
    
        $activeImage = $this->images[$this->currentImageIndex];
        $imageData = base64_decode($activeImage['data']);
        $mimeType = $activeImage['mime_type'];
        $originalName = $activeImage['original_name'];
    
        return response()->stream(
            function () use ($imageData) {
                echo $imageData;
            },
            200,
            [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'attachment; filename="' . $originalName . '"',
            ]
        );
    }
    public function getImageUrlsAttribute()
    {
        $fileDataArray = is_string($this->file_paths)
            ? json_decode($this->file_paths, true)
            : $this->file_paths;
    
        return array_filter($fileDataArray, function ($fileData) {
            return isset($fileData['mime_type']) && strpos($fileData['mime_type'], 'image') !== false;
        });
    }
    public function getFileUrlsAttribute()
    {
        $fileDataArray = is_string($this->file_paths)
            ? json_decode($this->file_paths, true)
            : $this->file_paths;
    
        return array_filter($fileDataArray, function ($fileData) {
            // Check if MIME type is not an image
            return isset($fileData['mime_type']) && strpos($fileData['mime_type'], 'image') === false;
        });
    }
    
    public $currentImageIndex = 0;  
    
    public function closeViewImage()
    {
        $this->showViewImageDialog = false;
    }
    
    // Navigate to the previous image
 
    



    public function showViewImage($id) 
    {
        $this->recordId = $id;
    
        // Fetch the record
        $record = IncidentRequest::find($id);
        
        // Get the images (assuming a JSON structure for images)
        $this->images = $record->getImageUrlsAttribute(); 
    
        // Set the current image index
      
    
        // Show the dialog
        $this->showViewImageDialog = true;
    }
    
    public function setActiveImageIndex($index)
    {
        $this->currentImageIndex = $index; // Update current index dynamically
    }
    public function nextImage()
    {
        $this->currentImageIndex = ($this->currentImageIndex + 1) % count($this->images);
    }

    public function previousImage()
    {
        $this->currentImageIndex = ($this->currentImageIndex - 1 + count($this->images)) % count($this->images);
    }
    public function downloadAllImages()
    {
     
        if (empty($this->images)) {
            session()->flash('error', 'No images available to download.');
            return;
        }

        // Create a temporary file for the zip archive
        $zipFilePath = storage_path('app/public/incident_images.zip');
        $zip = new ZipArchive();
    
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($this->images as $index => $image) {
                $imageData = base64_decode($image['data']);
                $originalName = $image['original_name'];
    
                // Add each image to the zip file
                $zip->addFromString($originalName, $imageData);
            }
    
            // Close the zip archive
            $zip->close();
    
            // Return the zip file as a download response
            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } else {
            session()->flash('error', 'Failed to create ZIP file.');
            return;
        }
    }
    
 
  
    public function ServiceRequest()
    {



        $this->ServiceRequestaceessDialog = true;
        $this->showModal = true;
        $this->category = 'Service Request';
    }

    public function incidentRequest()
    {

        $this->incidentRequestaceessDialog = true;
        $this->showModal = true;
        $this->category = 'Incident Request';
    }
    public function createIncidentRequest()
    {
        // Initialize file paths as an empty array if not provided
        $this->validate([
            'short_description' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:Low,Medium,High',
        ]);
    
        $filePaths = $this->file_paths ?? []; // Default to empty array if no files are uploaded
    
        // Validate file uploads if any files are uploaded
        if (!empty($filePaths) && is_array($filePaths)) {
            $validator = Validator::make(
                ['file_paths' => $filePaths],
                [
                    'file_paths' => 'array', // Ensure file_paths is an array
                    'file_paths.*' => 'file|mimes:xls,csv,xlsx,pdf,jpeg,png,jpg,gif]', // 1MB max
                ],
                [
                    'file_paths.*.file' => 'Each file must be a valid file.',
                    'file_paths.*.mimes' => 'Invalid file type. Only xls, csv, xlsx, pdf, jpeg, png, jpg, and gif are allowed.',
                    'file_paths.*.max' => 'Each file must not exceed 1MB in size.',
                ]
            );
    
            // If validation fails, return an error response
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
        }
    
        // Array to hold processed file data
        $fileDataArray = [];
    
        // Process each file if uploaded
        if (!empty($filePaths) && is_array($filePaths)) {
            foreach ($filePaths as $file) {
                // Check if the file is valid
                if ($file->isValid()) {
                    try {
                        // Get file details
                        $mimeType = $file->getMimeType();
                        $originalName = $file->getClientOriginalName();
                        $fileContent = file_get_contents($file->getRealPath());
    
                        // Encode the file content to base64
                        $base64File = base64_encode($fileContent);
    
                        // Add file data to the array
                        $fileDataArray[] = [
                            'data' => $base64File,
                            'mime_type' => $mimeType,
                            'original_name' => $originalName,
                        ];
                    } catch (\Exception $e) {
                        Log::error('Error processing file', [
                            'file_name' => $file->getClientOriginalName(),
                            'error' => $e->getMessage(),
                        ]);
                        return response()->json(['error' => 'An error occurred while processing the file.'], 500);
                    }
                } else {
                    Log::error('Invalid file uploaded', [
                        'file_name' => $file->getClientOriginalName(),
                    ]);
                    return response()->json(['error' => 'Invalid file uploaded'], 400);
                }
            }
        } else {
            Log::warning('No files uploaded.');
        }
    
        // Further processing, such as saving to the database
        try {
            // Fetch employee details
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
    
            // If no employee details found, handle the error
            if (!$this->employeeDetails) {
                Log::error('Employee details not found', ['emp_id' => $employeeId]);
                return response()->json(['error' => 'Employee details not found'], 404);
            }
    
            // Create Incident Request entry
            $incidentRequest = IncidentRequest::create([
                'emp_id' => $employeeId,
                'category' => $this->category,
                'short_description' => $this->short_description,
                'description' => $this->description,
                'priority' => $this->priority,
                'assigned_dept' => 'IT',
                'file_paths' => !empty($fileDataArray) ? json_encode($fileDataArray) : null, // Set to null if no files
                'status_code' => 10, // Set default status
            ]);
    
            // Notify admin users
            $incidentRequest->refresh();
            $this->resetIncidentFields();
            $this->showModal = false;
            FlashMessageHelper::flashSuccess('Incident request created successfully.');
    
            // Fetch all admin emails from the IT table
            $adminEmails = IT::where('role', 'admin')->pluck('email')->toArray();
    
            // Send Email Notification
            foreach ($adminEmails as $email) {
                // Get the admin's emp_id from the IT table
                $admin = IT::where('email', $email)->first();
    
                if ($admin) {
                    // Retrieve the corresponding first name and last name from EmployeeDetails
                    $employeeDetails = EmployeeDetails::where('emp_id', $admin->emp_id)->first();
    
                    $firstName = $employeeDetails ? $employeeDetails->first_name : 'N/A';
                    $lastName = $employeeDetails ? $employeeDetails->last_name : 'N/A';
    
                    // Send email
                    Mail::to($email)
                        ->send(new IncidentRequestMail(
                            $incidentRequest,
                            $firstName,
                            $lastName
                        ));
                } else {
                    Log::warning("No admin found in IT table for email: $email");
                }
            }
    
            return redirect()->to('/incident');
        } catch (\Exception $e) {
            // Log the error details
            Log::error('Error creating request', [
                'employee_id' => $this->employeeDetails->emp_id ?? 'N/A',
                'category' => $this->category,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_paths' => $fileDataArray,
                'error' => $e->getMessage(),
            ]);
            FlashMessageHelper::flashError('An error occurred while creating the request. Please try again.');
            return response()->json(['error' => 'An error occurred while processing your request.'], 500);
        }
    }
    
    public function createServiceRequest()
    {
        // Initialize file paths as an empty array if not provided
         // Initialize file paths as an empty array if not provided
         $this->validate([
            'short_description' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:Low,Medium,High',
        ]);
    
        $filePaths = $this->file_paths ?? []; // Default to empty array if no files are uploaded
    
        // Validate file uploads if any files are uploaded
        if (!empty($filePaths) && is_array($filePaths)) {
            $validator = Validator::make(
                ['file_paths' => $filePaths],
                [
                    'file_paths' => 'array', // Ensure file_paths is an array
                    'file_paths.*' => 'file|mimes:xls,csv,xlsx,pdf,jpeg,png,jpg,gif]', // 1MB max
                ],
                [
                    'file_paths.*.file' => 'Each file must be a valid file.',
                    'file_paths.*.mimes' => 'Invalid file type. Only xls, csv, xlsx, pdf, jpeg, png, jpg, and gif are allowed.',
                    'file_paths.*.max' => 'Each file must not exceed 1MB in size.',
                ]
            );
    
            // If validation fails, return an error response
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
        }
    
        // Array to hold processed file data
        $fileDataArray = [];
    
        // Process each file if uploaded
        if (!empty($filePaths) && is_array($filePaths)) {
            foreach ($filePaths as $file) {
                // Check if the file is valid
                if ($file->isValid()) {
                    try {
                        // Get file details
                        $mimeType = $file->getMimeType();
                        $originalName = $file->getClientOriginalName();
                        $fileContent = file_get_contents($file->getRealPath());
    
                        // Encode the file content to base64
                        $base64File = base64_encode($fileContent);
    
                        // Add file data to the array
                        $fileDataArray[] = [
                            'data' => $base64File,
                            'mime_type' => $mimeType,
                            'original_name' => $originalName,
                        ];
                    } catch (\Exception $e) {
                        Log::error('Error processing file', [
                            'file_name' => $file->getClientOriginalName(),
                            'error' => $e->getMessage(),
                        ]);
                        return response()->json(['error' => 'An error occurred while processing the file.'], 500);
                    }
                } else {
                    Log::error('Invalid file uploaded', [
                        'file_name' => $file->getClientOriginalName(),
                    ]);
                    return response()->json(['error' => 'Invalid file uploaded'], 400);
                }
            }
        } else {
            Log::warning('No files uploaded.');
        }
    
        // Further processing, such as saving to the database
        try {
            // Fetch employee details
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
    
            // If no employee details found, handle the error
            if (!$this->employeeDetails) {
                Log::error('Employee details not found', ['emp_id' => $employeeId]);
                return response()->json(['error' => 'Employee details not found'], 404);
            }
    
            // Create Incident Request entry
            $incidentRequest = IncidentRequest::create([
                'emp_id' => $employeeId,
                'category' => $this->category,
                'short_description' => $this->short_description,
                'description' => $this->description,
                'priority' => $this->priority,
                'assigned_dept' => 'IT',
                'file_paths' => !empty($fileDataArray) ? json_encode($fileDataArray) : null, // Set to null if no files
                'status_code' => 10, // Set default status
            ]);
    
            // Notify admin users
            $incidentRequest->refresh();
            $this->resetIncidentFields();
            $this->showModal = false;
            FlashMessageHelper::flashSuccess('Service request created successfully.');
    
            // Fetch all admin emails from the IT table
            $adminEmails = IT::where('role', 'admin')->pluck('email')->toArray();
    
            // Send Email Notification
            foreach ($adminEmails as $email) {
                // Get the admin's emp_id from the IT table
                $admin = IT::where('email', $email)->first();
    
                if ($admin) {
                    // Retrieve the corresponding first name and last name from EmployeeDetails
                    $employeeDetails = EmployeeDetails::where('emp_id', $admin->emp_id)->first();
    
                    $firstName = $employeeDetails ? $employeeDetails->first_name : 'N/A';
                    $lastName = $employeeDetails ? $employeeDetails->last_name : 'N/A';
    
                    // Send email
                    Mail::to($email)
                        ->send(new IncidentRequestMail(
                            $incidentRequest,
                            $firstName,
                            $lastName
                        ));
                } else {
                    Log::warning("No admin found in IT table for email: $email");
                }
            }
    
            return redirect()->to('/incident');
        } catch (\Exception $e) {
            // Log the error details
            Log::error('Error creating request', [
                'employee_id' => $this->employeeDetails->emp_id ?? 'N/A',
                'category' => $this->category,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_paths' => $fileDataArray,
                'error' => $e->getMessage(),
            ]);
            FlashMessageHelper::flashError('An error occurred while creating the request. Please try again.');
            return response()->json(['error' => 'An error occurred while processing your request.'], 500);
        }
    
    }

    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $companyId = auth()->guard('emp')->user()->companyc_id;
        $this->peoples = EmployeeDetails::where('company_id', $companyId)->whereNotIn('employee_status', ['rejected', 'terminated'])->get();

        $peopleData = $this->filteredPeoples ? $this->filteredPeoples : $this->peoples;

        $this->peoples = EmployeeDetails::where('company_id', $companyId)->whereNotIn('employee_status', ['rejected', 'terminated'])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $searchData = $this->filterData ?: $this->records;
        $searchData = $this->filterData ?: $this->servicerecords;
        $employeeName = auth()->user()->first_name . ' #(' . $employeeId . ')';

        $this->records = IncidentRequest::with('emp')
            ->whereHas('emp', function ($query) {
                $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();



        $query = IncidentRequest::with('emp')
            ->where('emp_id', $employeeId);


        // Apply filtering based on the selected category

        $this->peoples = EmployeeDetails::whereJsonContains('company_id', $companyId)->get();
        // Initialize peopleData properly
        $peopleData = $this->filteredPeoples ?: $this->peoples;

        // Ensure peopleData is a collection, not null
        $peopleData = $peopleData ?: collect();

        return view('livewire.incident-requests', [
            'records' => $this->records,
            'searchData' => $this->filterData ?: $this->records,
            'requestCategories' => $this->requestCategories,
            'peopleData' => $this->peopleData,
            'showViewImageDialog' => $this->showViewImageDialog,

        ]);
    }
}
