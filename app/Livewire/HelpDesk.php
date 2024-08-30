<?php
// File Name                       : HelpDesk.php
// Description                     : This file contains the information about various IT requests related to the catalog.
//                                   It includes functionality for adding members to distribution lists and mailboxes, requesting IT accessories,
//                                   new ID cards, MMS accounts, new distribution lists, laptops, new mailboxes, and DevOps access.
// Creator                         : Asapu Sri Kumar Mmanikanta,Ashannagari Archana
// Email                           : archanaashannagari@gmail.com
// Organization                    : PayG.
// Date                            : 2023-09-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : HelpDesk,EmployeeDetails
namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\PeopleList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\HelpDesks;
use App\Models\Request;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Response;

class HelpDesk extends Component
{
    use WithFileUploads;
    public $selectedCategory = [];
    public $searchTerm = '';
    public $showViewFileDialog = false;
    public $showModal = false;
    public $search = '';
    public $isRotated = false;

    public $requestCategories = '';
    public $selectedPerson = null;
    public $peoples;
    public $filteredPeoples;
    public $peopleFound = true;
    public $category;
    public $ccToArray = [];
    public $request;
    public $subject;
    public $description;
    public $file_path;
    public $cc_to;
    public $priority;
    public $records;
    public $image;
    public $mobile;
    public $selectedPeopleNames = [];
    public $employeeDetails;
    public $showDialog = false;
    public $fileContent,$file_name,$mime_type;

    public $showDialogFinance = false;
    public $record;
    public $peopleData = '';
    public $filterData;
    public $activeTab = 'active';
    public $selectedPeople = [];
    protected $rules = [
        'category' => 'required|string',
        'subject' => 'required|string',
        'description' => 'required|string',
        'file_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,csv,xls,xlsx|max:40960', // Adjust max size as needed
        'priority' => 'required|in:High,Medium,Low',

    ];

    protected $messages = [
        'category.required' => 'Category is required.',
        'subject.required' => 'Subject is required.',
        'description.required' => 'Description is required.',
        'priority.required' => 'Priority is required.',
        'priority.in' => 'Priority must be one of: High, Medium, Low.',
        'image.image' => 'File must be an image.',
        'image.max' => 'Image size must not exceed 2MB.',
        'file_path.mimes' => 'File must be a document of type: pdf, xls, xlsx, doc, docx, jpg, jpeg, png.',
        'file_path.max' => 'Document size must not exceed 40 MB.',
    ];

    public function validateField($field)
    {
        if (in_array($field, ['description', 'subject','category','priority',])) {
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
        $this->peoples = EmployeeDetails::where('company_id', $companyId)->get();

        $this->peopleData = $this->filteredPeoples ? $this->filteredPeoples : $this->peoples;
        $this->selectedPeople = [];
        $this->selectedPeopleNames = [];
        $employeeName = auth()->user()->first_name . ' #(' . $employeeId . ')';
        $this->records = HelpDesks::with('emp')
            ->where(function ($query) use ($employeeId, $employeeName) {
                $query->where('emp_id', $employeeId)
                    ->orWhere('cc_to', 'LIKE', "%$employeeName%");
            })
            ->orderBy('created_at', 'desc')
            ->get();
        // dd( $this->records);
        $this->peoples = EmployeeDetails::where('company_id', $companyId)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        // Group categories by their request
        if ($requestCategories->isNotEmpty()) {
            // Group categories by their request
            $this->requestCategories = $requestCategories->groupBy('Request')->map(function ($group) {
                return $group->unique('category'); // Ensure categories are unique
            });
        } else {
            // Handle the case where there are no requests
            $this->requestCategories = collect(); // Initialize as an empty collection
        }
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





    public function searchCompleted()
    {
        // Filter people based on search term
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $companyId = Auth::user()->company_id;
        $this->records = HelpDesks::all();
        $this->peoples = EmployeeDetails::where('company_id', $companyId)
            ->where(function ($query) {
                $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $this->filteredPeoples = $this->searchTerm ? $this->peoples : null;

        // Filter records based on category and search term
        $this->records = HelpDesks::with('emp')
            ->whereHas('emp', function ($query) {
                $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
            })

            ->orderBy('created_at', 'desc')
            ->get();
    }
    public function searchActiveHelpDesk()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;

        $query = HelpDesks::where(function ($query) use ($employeeId) {
            $query->where('emp_id', $employeeId)->orWhere('cc_to', 'like', "%$employeeId%");
        })
            ->where('status', 'Recent');

        if ($this->selectedCategory) {
            logger('Selected Category: ' . $this->selectedCategory);
            // Filter HelpDesks based on the selectedCategory's associated categories
            $query->whereIn('category', Request::where('Request', $this->selectedCategory)->pluck('category'));
        }

        // Additional filtering logic, if any, can go here

        // Final query execution
        $results = $query->orderBy('created_at', 'desc')->get();
        logger('Filtered Results: ', $results->toArray());
        $this->filterData = $results;

        if ($this->search) {
            $query->where(function ($query) {
                $query->where('emp_id', 'like', '%' . $this->search . '%')
                    ->orWhere('category', 'like', '%' . $this->search . '%')
                    ->orWhere('subject', 'like', '%' . $this->search . '%')
                    ->orWhereHas('emp', function ($query) {
                        $query->where('first_name', 'like', '%' . $this->search . '%')
                            ->orWhere('last_name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        $this->filterData = $query->orderBy('created_at', 'desc')->get();
        $this->peopleFound = count($this->filterData) > 0;
    }

    public function searchPendingHelpDesk()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $query = HelpDesks::where(function ($query) use ($employeeId) {
            $query->where('emp_id', $employeeId)->orWhere('cc_to', 'like', "%$employeeId%");
        })
            ->where('status', 'Pending');

        if ($this->selectedCategory) {
            logger('Selected Category: ' . $this->selectedCategory);
            // Filter HelpDesks based on the selectedCategory's associated categories
            $query->whereIn('category', Request::where('Request', $this->selectedCategory)->pluck('category'));
        }

        // Additional filtering logic, if any, can go here

        // Final query execution
        $results = $query->orderBy('created_at', 'desc')->get();
        logger('Filtered Results: ', $results->toArray());
        $this->filterData = $results;

        if ($this->search) {
            $query->where(function ($query) {
                $query->where('emp_id', 'like', '%' . $this->search . '%')
                    ->orWhere('category', 'like', '%' . $this->search . '%')
                    ->orWhere('subject', 'like', '%' . $this->search . '%')
                    ->orWhereHas('emp', function ($query) {
                        $query->where('first_name', 'like', '%' . $this->search . '%')
                            ->orWhere('last_name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        $this->filterData = $query->orderBy('created_at', 'desc')->get();
        $this->peopleFound = count($this->filterData) > 0;
    }
    public function searchClosedHelpDesk()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $query = HelpDesks::where(function ($query) use ($employeeId) {
            $query->where('emp_id', $employeeId)->orWhere('cc_to', 'like', "%$employeeId%");
        })
            ->where('status', 'Completed');

        if ($this->selectedCategory) {
            logger('Selected Category: ' . $this->selectedCategory);
            // Filter HelpDesks based on the selectedCategory's associated categories
            $query->whereIn('category', Request::where('Request', $this->selectedCategory)->pluck('category'));
        }

        // Additional filtering logic, if any, can go here

        // Final query execution
        $results = $query->orderBy('created_at', 'desc')->get();
        logger('Filtered Results: ', $results->toArray());
        $this->filterData = $results;

        if ($this->search) {
            $query->where(function ($query) {
                $query->where('emp_id', 'like', '%' . $this->search . '%')
                    ->orWhere('category', 'like', '%' . $this->search . '%')
                    ->orWhere('subject', 'like', '%' . $this->search . '%')
                    ->orWhereHas('emp', function ($query) {
                        $query->where('first_name', 'like', '%' . $this->search . '%')
                            ->orWhere('last_name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        $this->filterData = $query->orderBy('created_at', 'desc')->get();
        $this->peopleFound = count($this->filterData) > 0;
    }
    public function close()
    {
        $this->showDialog = false;

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
        $task = HelpDesks::find($taskId);

        if ($task) {
            $task->update(['status' => 'Completed']);
        }
        return redirect()->to('/HelpDesk');
    }

    public function closeForDesks($taskId)
    {
        $task = HelpDesks::find($taskId);

        if ($task) {
            $task->update(['status' => 'Open']);
        }
        return redirect()->to('/HelpDesk');
    }

    public function selectPerson($personId)
    {
        try {
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
        $record = HelpDesks::findOrFail($id);

        if ($record && $record->file_path !== 'N/A') {
            $mimeType = 'image/jpeg'; // Adjust as necessary

            return response($record->file_path, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="image.jpg"'); // Adjust filename and extension as needed
        }

        return abort(404, 'File not found');
    }

    public function submit()
    {

        try {

            $validatedData = $this->validate($this->rules);
 // Validate and store the uploaded file
 $fileContent = null;
            $mime_type = null;
            $file_name = null;
           $this->validate($this->rules);
            if ($this->file_path) {
                $fileContent = file_get_contents($this->file_path->getRealPath());
                $mime_type = $this->file_path->getMimeType();
                $file_name = $this->file_path->getClientOriginalName();
                // Validate and store the uploaded file
            }
            // Store the file as binary data


            if (  $fileContent  === false) {
                Log::error('Failed to read the uploaded file.', [
                    'file_path' => $this->file_path->getRealPath(),
                ]);
                session()->flash('error', 'Failed to read the uploaded file.');
                return;
            }

            // Check if the file content is too large
            if (strlen(  $fileContent ) > 16777215) { // 16MB for MEDIUMBLOB
                session()->flash('error', 'File size exceeds the allowed limit.');
                return;
            }

            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

            HelpDesks::create([
                'emp_id' => $this->employeeDetails->emp_id,
                'category' => $this->category,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path' => $fileContent, // Store the binary file data
                'cc_to' => $this->cc_to ?? '-',
                'priority' => $this->priority,
                'file_name' => $file_name,
                'mime_type' => $mime_type,
                'mail' => 'N/A',
                'mobile' => 'N/A',
                'distributor_name' => 'N/A',
            ]);
            session()->flash('message', 'Request created successfully.');
            $this->reset();
            return redirect()->to('/HelpDesk');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
        } catch (\Exception $e) {
            Log::error('Error creating request: ' . $e->getMessage(), [
                'employee_id' => $employeeId,
                'category' => $this->category,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path_length' => isset($fileContent) ? strlen($fileContent) : null, // Log the length of the file content
            ]);
            session()->flash('error', 'An error occurred while creating the request. Please try again.');
        }
    }
    public $recordId;
    public $viewrecord;
    public function showViewFile($id)
    {
        $this->records = HelpDesks::findOrFail($id);

        if ($this->records && $this->records->file_path !== 'null') {
            $this->file_path = $this->records->file_path;
            $this->showViewFileDialog = true;
        } else {
            // Handle case where file is not found or is null
            $this->dispatchBrowserEvent('file-not-found', ['message' => 'File not found.']);
        }
    }
    public $showImageDialog = false;
    public $imageUrl;
    public function downloadImage()
    {
        if ($this->imageUrl) {
            // Decode the Base64 data if necessary
            $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->imageUrl));

            // Determine MIME type and file extension
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_buffer($finfo, $fileData);
            finfo_close($finfo);

            $extension = '';
            switch ($mimeType) {
                case 'image/jpeg':
                    $extension = 'jpg';
                    break;
                case 'image/png':
                    $extension = 'png';
                    break;
                case 'image/gif':
                    $extension = 'gif';
                    break;
                default:
                    return abort(415, 'Unsupported Media Type');
            }

            // Prepare file name and response
            $fileName = 'image-' . time() . '.' . $extension;
            return response()->streamDownload(
                function () use ($fileData) {
                    echo $fileData;
                },
                $fileName,
                [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                ]
            );
        }
        return abort(404, 'Image not found');
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



    public function submitHR()
    {
        try {
            $fileContent = null;
            $mime_type = null;
            $file_name = null;
           $this->validate($this->rules);
            if ($this->file_path) {
                $fileContent = file_get_contents($this->file_path->getRealPath());
                $mime_type = $this->file_path->getMimeType();
                $file_name = $this->file_path->getClientOriginalName();
                // Validate and store the uploaded file
            }
            // Store the file as binary data


            if (  $fileContent  === false) {
                Log::error('Failed to read the uploaded file.', [
                    'file_path' => $this->file_path->getRealPath(),
                ]);
                session()->flash('error', 'Failed to read the uploaded file.');
                return;
            }

            // Check if the file content is too large
            if (strlen(  $fileContent ) > 16777215) { // 16MB for MEDIUMBLOB
                session()->flash('error', 'File size exceeds the allowed limit.');
                return;
            }

            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

            HelpDesks::create([
                'emp_id' => $this->employeeDetails->emp_id,
                'category' => $this->category,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path' =>   $fileContent , // Store the binary file data
                'file_name' => $file_name,
                'mime_type' => $mime_type,
                'cc_to' => $this->cc_to ?? '-',
                'priority' => $this->priority,
                'mail' => 'N/A',
                'mobile' => 'N/A',
                'distributor_name' => 'N/A',
            ]);

            session()->flash('message', 'Request created successfully.');
            return redirect()->to('/HelpDesk');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
        } catch (\Exception $e) {
            Log::error('Error creating request: ' . $e->getMessage(), [
                'category' => $this->category,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path_length' => isset($fileContent) ? strlen($fileContent) : null, // Log the length of the file content
            ]);
            session()->flash('error', 'An error occurred while creating the request. Please try again.');
        }
    }

    public function downloadFile($id)
    {
        // Fetch the HelpDesk record using the provided ID
        $helpDeskRecord = HelpDesks::findOrFail($id);

        // Check if the file_path has content
        if (!$helpDeskRecord->file_path) {
            return redirect()->back()->with('error', 'File not found.');
        }

        // Prepare the response for the file download
        $fileContent = $helpDeskRecord->file_path; // Retrieve binary content from the database
        $filename = 'document_' . $id; // You may want to generate a more meaningful filename

        return response()->stream(function () use ($fileContent) {
            echo $fileContent; // Output the file content
        }, 200, [
            'Content-Type' => 'application/octet-stream', // Change based on the actual file type
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    protected function resetInputFields()
    {
        $this->category = '';
        $this->subject = '';
        $this->description = '';
        $this->file_path = '';
        $this->cc_to = '';
        $this->priority = '';
        $this->image = '';
    }

    public function closePeoples()
    {
        $this->isRotated = false;
    }

    public function updatedSelectedPeople()
    {
        $this->cc_to = implode(', ', array_unique($this->selectedPeopleNames));
    }


    public function toggleRotation()
    {

        $this->isRotated = true;


        $this->selectedPeopleNames = [];

        $this->cc_to = '';
    }
    public function toggle()
    {

        $this->isRotated = true;


        $this->selectedPeopleNames = [];

        $this->cc_to = '';
    }
    public function filter()
    {

        $employeeId = auth()->guard('emp')->user()->emp_id;

        $companyId = Auth::user()->company_id;


        $this->peopleData = EmployeeDetails::where('first_name', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('emp_id', 'like', '%' . $this->searchTerm . '%')
            ->get();

        $this->filteredPeoples = $this->searchTerm ? $this->peoples : null;

        // Filter records based on category and search term
        $this->records = HelpDesks::with('emp')
            ->whereHas('emp', function ($query) {
                $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
            })

            ->orderBy('created_at', 'desc')
            ->get();
    }


    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $companyId = auth()->guard('emp')->user()->company_id;
        $this->peoples = EmployeeDetails::where('company_id', $companyId)->get();

        $peopleData = $this->filteredPeoples ? $this->filteredPeoples : $this->peoples;

        $this->peoples = EmployeeDetails::where('company_id', $companyId)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $searchData = $this->filterData ?: $this->records;
        $employeeName = auth()->user()->first_name . ' #(' . $employeeId . ')';

        $this->records = HelpDesks::with('emp')
            ->where(function ($query) use ($employeeId, $employeeName) {
                $query->where('emp_id', $employeeId)
                    ->orWhere('cc_to', 'LIKE', "%$employeeName%");
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Apply filtering based on the selected category
        if ($this->selectedCategory) {
            $this->records->where('request', function ($q) {
                $q->where('category', $this->selectedCategory);
            });
        }



        $query = HelpDesks::with('emp')
            ->where('emp_id', $employeeId);

        // Apply filtering based on the selected category

        $this->peoples = EmployeeDetails::where('company_id', $companyId)->get();
        // Initialize peopleData properly
        $peopleData = $this->filteredPeoples ?: $this->peoples;

        // Ensure peopleData is a collection, not null
        $peopleData = $peopleData ?: collect();

        return view('livewire.help-desk', [
            'records' => $this->records,
            'searchData' => $this->filterData ?: $this->records,
            'requestCategories' => $this->requestCategories,
            'peopleData' => $this->peopleData,
        ]);
    }
}
