<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\ClientsEmployee;
use App\Models\ClientsWithProjects;
use App\Models\EmployeeDetails;
use App\Models\Task;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskComment;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Session;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Tasks extends Component
{
    use WithFileUploads;
    public $status = false;
    public $searchTerm = '';
    public $searchTermFollower = '';
    public $showDialog = false;
    public $showViewFileDialog = false;
    public $showModal = false;
    public $employeeDetails;
    public $emp_id;
    public $task_name;
    public $assignee;
    public $priority = "Low";
    public $due_date;
    public $tags;
    public $followers;
    public $subject;
    public $description;
    public $file_path;
    public $image;
    public $peoples;
    public $records;
    public $filteredPeoples;
    public $assigneeList;
    public $peopleFound = true;
    public $activeTab = 'open';
    public $employeeIdToComplete;
    public $record;
    public $isLoadingImage = false;

    public $followersList = false;
    public $selectedPeopleNames = [];
    public $selectedPeopleNamesForFollowers = [];
    public $newComment = '';
    public $taskId;
    public $commentId;
    public $commentAdded = false;
    public $showAddCommentModal = false;
    public $editCommentId = null;
    public $search = '';
    public $closedSearch = '';
    public $filterData;
    public $showAlert = false;
    public $openAccordions = [];
    public function toggleAccordion($recordId)
    {
        if (in_array($recordId, $this->openAccordions)) {
            $this->openAccordions = array_filter($this->openAccordions, function ($id) use ($recordId) {
                return $id !== $recordId;
            });
        } else {
            $this->openAccordions[] = $recordId;
        }
    }
    public function setActiveTab($tab)
    {
        if ($tab === 'open') {
            $this->activeTab = 'open';
            $this->search = '';
            $this->filterPeriod = 'all';
        } elseif ($tab === 'completed') {
            $this->activeTab = 'completed';
            $this->closedSearch = '';
            $this->filterPeriod = 'all';
        }
        $this->loadTasks();
    }
    public function hideAlert()
    {
        $this->showAlert = false;
        session()->forget('showAlert');
    }

    public function loadTasks()
    {
        if ($this->activeTab === 'open') {
            $this->searchActiveTasks();
        } elseif ($this->activeTab === 'completed') {
            $this->searchCompletedTasks();
        }
    }
    public $filterPeriod = 'all';


    public function searchActiveTasks()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $query = Task::where(function ($query) use ($employeeId) {
            $query->where('emp_id', $employeeId)
                ->orWhereRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(assignee, '(', -1), ')', 1) = ?", [$employeeId]);
        })
            ->where('status', 'Open');

        // Filter by period
        switch ($this->filterPeriod) {
            case 'this_week':
                $startOfWeek = now()->startOfWeek()->toDateString();
                $endOfWeek = now()->endOfWeek()->toDateString();
                $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                break;
            case 'this_month':
                $startOfMonth = now()->startOfMonth()->toDateString();
                $endOfMonth = now()->endOfMonth()->toDateString();
                $query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                break;
            case 'last_month':
                $startOfLastMonth = now()->subMonth()->startOfMonth()->toDateString();
                $endOfLastMonth = now()->subMonth()->endOfMonth()->toDateString();
                $query->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth]);
                break;
            case 'this_year':
                $startOfYear = now()->startOfYear()->toDateString();
                $endOfYear = now()->endOfYear()->toDateString();
                $query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                break;
            case 'all':
                break;
        }

        if ($this->search) {
            $searchTerm = trim($this->search); // Trim any extra whitespace
            $searchTerm = strtolower($searchTerm); // Convert to lowercase for case-insensitivity

            $query->where(function ($query) use ($searchTerm) {
                $query->whereRaw('LOWER(assignee) LIKE ?', ["%{$searchTerm}%"])
                    ->orWhereRaw('LOWER(followers) LIKE ?', ["%{$searchTerm}%"])
                    ->orWhereHas('emp', function ($query) use ($searchTerm) {
                        $query->whereRaw('LOWER(first_name) LIKE ?', ["%{$searchTerm}%"])
                            ->orWhereRaw('LOWER(last_name) LIKE ?', ["%{$searchTerm}%"]);
                    })
                    ->orWhereRaw('LOWER(task_name) LIKE ?', ["%{$searchTerm}%"])
                    ->orWhereRaw('LOWER(emp_id) LIKE ?', ["%{$searchTerm}%"])
                    ->orWhereRaw('LOWER(CONCAT("T-", id)) LIKE ?', ["%{$searchTerm}%"]);
            });
        }


        $this->filterData = $query->orderBy('created_at', 'desc')->get();
        $this->peopleFound = count($this->filterData) > 0;
    }

    public function searchCompletedTasks()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;

        $query = Task::where(function ($query) use ($employeeId) {
            $query->where('emp_id', $employeeId)
                ->orWhereRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(assignee, '(', -1), ')', 1) = ?", [$employeeId]);
        })
            ->where('status', 'Completed');


        switch ($this->filterPeriod) {
            case 'this_week':
                $startOfWeek = now()->startOfWeek()->toDateString();
                $endOfWeek = now()->endOfWeek()->toDateString();
                $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                break;
            case 'this_month':
                $startOfMonth = now()->startOfMonth()->toDateString();
                $endOfMonth = now()->endOfMonth()->toDateString();
                $query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                break;
            case 'last_month':
                $startOfLastMonth = now()->subMonth()->startOfMonth()->toDateString();
                $endOfLastMonth = now()->subMonth()->endOfMonth()->toDateString();
                $query->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth]);
                break;
            case 'this_year':
                $startOfYear = now()->startOfYear()->toDateString();
                $endOfYear = now()->endOfYear()->toDateString();
                $query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                break;
            case 'all':
                break;
        }


        if ($this->closedSearch) {
            $searchTerm = trim($this->closedSearch); // Trim any extra whitespace
            $searchTerm = strtolower($searchTerm); // Convert to lowercase for case-insensitivity

            $query->where(function ($query) use ($searchTerm) {
                $query->whereRaw('LOWER(assignee) LIKE ?', ["%{$searchTerm}%"])
                    ->orWhereRaw('LOWER(followers) LIKE ?', ["%{$searchTerm}%"])
                    ->orWhereHas('emp', function ($query) use ($searchTerm) {
                        $query->whereRaw('LOWER(first_name) LIKE ?', ["%{$searchTerm}%"])
                            ->orWhereRaw('LOWER(last_name) LIKE ?', ["%{$searchTerm}%"]);
                    })
                    ->orWhereRaw('LOWER(task_name) LIKE ?', ["%{$searchTerm}%"])
                    ->orWhereRaw('LOWER(emp_id) LIKE ?', ["%{$searchTerm}%"])
                    ->orWhereRaw('LOWER(CONCAT("T-", id)) LIKE ?', ["%{$searchTerm}%"]);
            });
        }

        $this->filterData = $query->orderBy('created_at', 'desc')->get();
        $this->peopleFound = count($this->filterData) > 0;
    }

    protected $rules = [
        'newComment' => 'required',
    ];
    protected $messages = [
        'newComment.required' => 'Comment is required.',
        'image.image' => 'File must be an image.',
        'image.max' => 'Image size must not exceed 2MB.',
        'file_path.mimes' => 'File must be a document of type: pdf, xls, xlsx, doc, docx, txt, ppt, pptx, gif, jpg, jpeg, png.',
        'file_path.max' => 'Document size must not exceed 2MB.',

    ];
    public function validateField($field)
    {

        $this->validateOnly($field, $this->rules);
    }

    public function forAssignee()
    {
        $this->searchTerm = '';
        $this->assigneeList = true;
    }
    public function closeAssignee()
    {
        $this->assigneeList = false;
    }

    public function forFollowers()
    {
        $this->searchTermFollower = '';
        $this->followersList = true;
    }
    public function closeFollowers()
    {
        $this->followersList = false;
    }

    public $showRecipients = false;
    public $selectedPeople = [];
    public $selectedPeopleName, $selectedPerson, $selectedPersonClients, $selectedPersonClientsWithProjects;
    public function mount()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->selectedPersonClients = collect();
        $this->selectedPersonClientsWithProjects = collect();
        $this->loadTasks();
        if (session()->has('showAlert')) {
            $this->showAlert = session('showAlert');
        }

        // TO reduce notification count by making as read related to  task

        DB::table('notifications')
            ->whereRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(notifications.assignee, '(', -1), ')', 1) = ?", [$employeeId])
            ->where('notification_type', 'task')
            ->delete();
    }
    public function updatedFilterPeriod()
    {
        $this->loadTasks();
    }

    public function selectPerson($personId)
    {
        $this->showRecipients = true;
        $this->selectedPerson = $this->peoples->where('emp_id', $personId)->first();
        $this->selectedPersonClients = ClientsEmployee::whereNotNull('emp_id')->where('emp_id', $this->selectedPerson->emp_id)->get();
        $this->selectedPeopleName = $this->selectedPerson->first_name . ' ' . $this->selectedPerson->last_name . ' #(' . $this->selectedPerson->emp_id . ')';
        $this->assignee = $this->selectedPeopleName;


        if ($this->selectedPersonClients->isEmpty()) {
            $this->selectedPersonClientsWithProjects = collect();
        }
        $this->assigneeList = false;
    }

    public function showProjects()
    {
        $this->selectedPersonClientsWithProjects = ClientsWithProjects::where('client_id', $this->client_id)->get();

        if ($this->validate_tasks == "true") {

            $this->autoValidate();
        }
    }
    public $showFollowers = false;

    public function updateCheckbox($personId)
    {

        if (in_array($personId, $this->selectedPeopleForFollowers)) {
            $this->selectedPeopleForFollowers = array_diff($this->selectedPeopleForFollowers, [$personId]);
        } else {

            $this->selectedPeopleForFollowers[] = $personId;
        }

        $this->updateFollowers();
        if (count($this->selectedPeopleForFollowers) > $this->maxFollowers) {
            $this->validationFollowerMessage = "You can only select up to 5 followers.";
        } else {
            $this->validationFollowerMessage = '';
        }
    }

    public $selectedPeopleForFollowers = [];

    public function togglePersonSelection($personId)
    {
        if (in_array($personId, $this->selectedPeopleForFollowers)) {
            // Deselect the person
            $this->selectedPeopleForFollowers = array_diff($this->selectedPeopleForFollowers, [$personId]);
        } else {

            // Select the person
            $this->selectedPeopleForFollowers[] = $personId;
        }

        // Ensure state is updated correctly

        $this->updateFollowers();
        if (count($this->selectedPeopleForFollowers) > $this->maxFollowers) {
            $this->validationFollowerMessage = "You can only select up to 5 followers.";
        } else {
            $this->validationFollowerMessage = '';
        }
    }


    // public function updateFollowers()
    // {

    //     $this->selectedPeopleNamesForFollowers = array_map(function ($id) {
    //         $selectedPerson = $this->peoples->where('emp_id', $id)->first();
    //         return $selectedPerson ? $selectedPerson->first_name . ' ' . $selectedPerson->last_name . ' #(' . $selectedPerson->emp_id . ')' : '';
    //     }, $this->selectedPeopleForFollowers);

    //     $this->followers = implode(', ', array_unique($this->selectedPeopleNamesForFollowers));

    //     $this->showFollowers = count($this->selectedPeopleNamesForFollowers) > 0;
    // }
    public function updateFollowers()
{
    $this->selectedPeopleNamesForFollowers = array_map(function ($id) {
        $selectedPerson = $this->peoples->where('emp_id', $id)->first();
        return $selectedPerson ? $selectedPerson->first_name . ' ' . $selectedPerson->last_name . ' #(' . $selectedPerson->emp_id . ')' : '';
    }, $this->selectedPeopleForFollowers);

    // Filter out any empty results
    $this->selectedPeopleNamesForFollowers = array_filter($this->selectedPeopleNamesForFollowers);

    // Convert to a string for display
    $this->followers = implode(', ', array_unique($this->selectedPeopleNamesForFollowers));

    $this->showFollowers = count($this->selectedPeopleNamesForFollowers) > 0;
}


    public function openForTasks($taskId)
    {
        $task = Task::find($taskId);

        if ($task) {
            $task->update(['status' => 'Completed']);
        }
        session()->flash('message', 'Task closed successfully!');
        session()->flash('showAlert', true);

        return redirect()->to('/tasks');
    }

    public function closeForTasks($taskId)
    {
        $task = Task::find($taskId);

        if ($task) {
            $task->update([
                'status' => 'Open',
                'reopened_date' => now()
            ]);
        }

        session()->flash('message', 'Task has been Re-Opened.');
        session()->flash('showAlert', true);

        return redirect()->to('/tasks');
    }

    public function autoValidate()
    {
        if ($this->validate_tasks) {
            if (is_null($this->client_id)) {
                $this->validate([
                    'due_date' => 'required',
                    'assignee' => 'required',
                    'task_name' => 'required',
                ]);
            } else {
                $this->validate([
                    'due_date' => 'required',
                    'client_id' => 'required',
                    'project_name' => 'required',
                    'assignee' => 'required',
                    'task_name' => 'required',
                ]);
            }
        }
    }
    public $maxFollowers = 5;
    public $validationFollowerMessage = '';


    public function submit()
    {
        try {
            $this->validate_tasks = true;
            $this->autoValidate();
            if (count($this->selectedPeopleForFollowers) > $this->maxFollowers) {
                session()->flash('error', 'You can only select up to 5 followers.');
                return;
            }

            // Validate and store the uploaded file
            $this->validate([
                'file_path' => 'nullable|file|mimes:xls,csv,xlsx,pdf,jpeg,png,jpg,gif|max:40960', // Adjust max size as needed
            ]);
            $fileContent = null;
            $mimeType = null;
            $fileName = null;

            // Store the file as binary data
            if ($this->file_path) {


                $fileContent = file_get_contents($this->file_path->getRealPath());
                if ($fileContent === false) {
                    Log::error('Failed to read the uploaded file.', [
                        'file_path' => $this->file_path->getRealPath(),
                    ]);
                    session()->flash('error', 'Failed to read the uploaded file.');
                    return;
                }

                // Check if the file content is too large
                if (strlen($fileContent) > 16777215) { // 16MB for MEDIUMBLOB
                    session()->flash('error', 'File size exceeds the allowed limit.');
                    return;
                }


                $mimeType = $this->file_path->getMimeType();
                $fileName = $this->file_path->getClientOriginalName();
            }

            $employeeId = auth()->guard('emp')->user()->emp_id;

            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();


            Task::create([
                'emp_id' => $this->employeeDetails->emp_id,
                'task_name' => $this->task_name,
                'assignee' => $this->assignee,
                'client_id' => $this->client_id ?? "",
                'project_name' => $this->project_name,
                'priority' => $this->priority,
                'due_date' => $this->due_date,
                'tags' => $this->tags,
                'followers' => $this->followers,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path' => $fileContent,
                'file_name' => $fileName,
                'mime_type' => $mimeType,
                'status' => "Open",
            ]);
            // $this->showRecipients = false;

            // $this->selectedPeopleName=null;


            preg_match('/\((.*?)\)/', $this->assignee, $matches);
            $extracted = isset($matches[1]) ? $matches[1] : $this->assignee;


            if ($extracted != $this->employeeDetails->emp_id) {

                Notification::create([
                    'emp_id' => $this->employeeDetails->emp_id,
                    'notification_type' => 'task',
                    'task_name' => $this->task_name,
                    'assignee' => $this->assignee,
                ]);
            }

            session()->flash('showAlert', true);
            session()->flash('message', 'Task created successfully!');
            $this->resetFields();

            return redirect()->to('/tasks');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
        } catch (\Exception $e) {
            Log::error('Error creating request: ' . $e->getMessage(), [
                'employee_id' => $employeeId,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path_length' => isset($fileContent) ? strlen($fileContent) : null,
            ]);
            session()->flash('error', 'An error occurred while creating the request. Please try again.');
        }
    }
    public function resetFields()
    {
        $this->task_name = null;
        $this->assignee = null;
        $this->client_id = null;
        $this->project_name = null;
        $this->priority = 'Low';
        $this->due_date = null;
        $this->tags = null;
        $this->followers = null;
        $this->subject = null;
        $this->description = null;
        $this->selectedPeopleName = null;
        $this->selectedPeopleNamesForFollowers = [];
        $this->showRecipients = false;
        $this->showFollowers = false;
        $this->file_path = null;
    }

    public $client_id, $project_name, $image_path;

    public $validate_tasks = false;

    public function show()
    {
        $this->showDialog = true;
    }
    public $recordId;
    public $viewrecord;
    public function showViewFile($recordId)
    {
        $this->$recordId = $recordId;
        $this->viewrecord = Task::find($recordId);
        $this->showViewFileDialog = true;
    }
    public function closeViewFile()
    {
        $this->showViewFileDialog = false;
    }

    public function close()
    {
        $this->resetErrorBag();
        $this->resetFields();

        $this->showDialog = false;
        $this->validate_tasks = false;
    }

    public function filter()
    {
        // Fetch the company_ids for the logged-in employee
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $companyIds = EmployeeDetails::where('emp_id', $employeeId)->value('company_id');

        // Check if companyIds is an array; decode if it's a JSON string
        $companyIdsArray = is_array($companyIds) ? $companyIds : json_decode($companyIds, true);

        $trimmedSearchTerm = trim($this->searchTerm);


            $this->filteredPeoples = EmployeeDetails::where(function($query) use ($companyIdsArray) {
                foreach ($companyIdsArray as $companyId) {
                    $query->orWhereJsonContains('company_id', $companyId);
                }
            })
            ->where(function($query) {
                $query->where('employee_status', 'active')
                      ->orWhere('employee_status', 'on-probation');
            })
                ->where(function ($query) use ($trimmedSearchTerm) {
                    $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $trimmedSearchTerm . '%')
                        ->orWhere('emp_id', 'like', '%' . $trimmedSearchTerm . '%');
                })
                ->orderByRaw("FIELD(emp_id, ?) DESC", [$employeeId])
->orderBy('first_name')
->orderBy('last_name')
                ->get();
              


        $this->peopleFound = count($this->filteredPeoples) > 0;
    }
    public $filteredFollowers;
    public function filterFollower()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;

        // Fetch the company_ids for the logged-in employee
        $companyIds = EmployeeDetails::where('emp_id', $employeeId)->value('company_id');

        // Check if companyIds is an array; decode if it's a JSON string
        $companyIdsArray = is_array($companyIds) ? $companyIds : json_decode($companyIds, true);

        $trimmedSearchTerm = trim($this->searchTermFollower);

            $this->filteredFollowers = EmployeeDetails::where(function($query) use ($companyIdsArray) {
                foreach ($companyIdsArray as $companyId) {
                    $query->orWhereJsonContains('company_id', $companyId);
                }
            })
            ->where(function($query) {
                $query->where('employee_status', 'active')
                      ->orWhere('employee_status', 'on-probation');
            })
                ->where(function ($query) use ($trimmedSearchTerm) {
                    $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $trimmedSearchTerm . '%')
                        ->orWhere('emp_id', 'like', '%' . $trimmedSearchTerm . '%');
                })
                ->orderByRaw("FIELD(emp_id, ?) DESC", [$employeeId])
->orderBy('first_name')
->orderBy('last_name')
                ->get();


        $this->peopleFound = count($this->filteredFollowers) > 0;
    }
    public function openAddCommentModal($taskId)
    {
        $this->taskId = $taskId;
        $this->newComment = '';
        $this->resetErrorBag('newComment');
        $this->showModal = true;
        $this->fetchTaskComments($taskId);
    }
    public function closeModal()
    {
        $this->showModal = false;
    }
    public function openEditCommentModal($commentId)
    {
        $this->editCommentId = $commentId;
        $this->newComment = TaskComment::findOrFail($commentId)->comment;
        $this->fetchTaskComments($this->taskId); // Fetch task comments again
    }


    public function updateComment($commentId)
    {
        $this->validate([
            'newComment' => 'required|string',
        ]);

        $comment = TaskComment::findOrFail($commentId);
        $comment->update([
            'comment' => $this->newComment,
        ]);

        session()->flash('comment_message', 'Comment updated successfully.');
        $this->showAlert = true;


        // Reset the edit state
        $this->editCommentId = null;
        $this->fetchTaskComments($this->taskId);
    }
    public function addComment()
    {
        $this->validate([
            'newComment' => 'required|string',
        ]);
        $employeeId = auth()->guard('emp')->user()->emp_id;
        TaskComment::create([
            'emp_id' => $employeeId,
            'task_id' => $this->taskId,
            'comment' => $this->newComment,
        ]);

        $this->commentAdded = true; // Set the flag to indicate that a comment has been added
        $this->newComment = '';
        $this->showModal = false;
        session()->flash('message', 'Comment added successfully.');
        $this->showAlert = true;
    }
    public function updatedNewComment($value)
    {
        $this->newComment = ucfirst($value); // Capitalize the first letter
    }

    // Delete a comment
    public function deleteComment($commentId)
    {
        try {
            $comment = TaskComment::findOrFail($commentId);
            $comment->delete();
            session()->flash('comment_message', 'Comment deleted successfully.');
            $this->showAlert = true;
            $this->fetchTaskComments($this->taskId);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the deletion process
            session()->flash('error', 'Failed to delete comment: ' . $e->getMessage());
        }
    }
    public function cancelEdit()
    {
        $this->editCommentId = null;
    }

    public $taskComments = []; // Variable to hold comments for the modal

    public function fetchTaskComments($taskId)
    {
        if ($this->commentAdded) {
            // If a new comment has been added, reset the flag and fetch the comments again
            $this->commentAdded = false;
        }
        $this->taskComments = TaskComment::with(['employee' => function ($query) {
            $query->select(DB::raw("CONCAT(first_name, ' ', last_name) AS full_name"), 'emp_id');
        }])
            ->whereHas('employee', function ($query) {
                $query->whereColumn('emp_id', 'task_comments.emp_id');
            })
            ->where('task_id', $taskId)
            ->latest()
            ->get();
    }

    public function downloadImage()
    {
        if ($this->viewrecord && !empty($this->viewrecord->file_path)) {
            $fileData = $this->viewrecord->file_path;

            // Determine the MIME type and file extension based on the data URL prefix
            $mimeType = 'application/octet-stream'; // Fallback MIME type
            $fileExtension = 'bin'; // Fallback file extension

            // Check the file's magic number or content to determine MIME type and file extension
            if (strpos($fileData, "\xFF\xD8\xFF") === 0) {
                $mimeType = 'image/jpeg';
                $fileExtension = 'jpg';
            } elseif (strpos($fileData, "\x89PNG\r\n\x1A\n") === 0) {
                $mimeType = 'image/png';
                $fileExtension = 'png';
            } elseif (strpos($fileData, "GIF87a") === 0 || strpos($fileData, "GIF89a") === 0) {
                $mimeType = 'image/gif';
                $fileExtension = 'gif';
            } else {
                return abort(415, 'Unsupported Media Type');
            }

            $fileName = 'image-' . $this->viewrecord->id . '.' . $fileExtension;
            return response()->stream(
                function () use ($fileData) {
                    echo $fileData;
                },
                200,
                [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                ]
            );
        }

        return abort(404, 'Image not found');
    }

    public function render()
    {

        $this->fetchTaskComments($this->taskId);
        // Retrieve the authenticated employee's ID
        $employeeId = auth()->guard('emp')->user()->emp_id;
        // $companyId = Auth::user()->company_id;
        // Fetch the company_ids for the logged-in employee
        $companyIds = EmployeeDetails::where('emp_id', $employeeId)->value('company_id');

        // Check if companyIds is an array; decode if it's a JSON string
        $companyIdsArray = is_array($companyIds) ? $companyIds : json_decode($companyIds, true);

        // Fetch employees, ensuring the authenticated employee is shown first


            $this->peoples = EmployeeDetails::where(function($query) use ($companyIdsArray) {
                foreach ($companyIdsArray as $companyId) {
                    $query->orWhereJsonContains('company_id', $companyId);
                }
            })
            ->where(function($query) {
                $query->where('employee_status', 'active')
                      ->orWhere('employee_status', 'on-probation');
            })
                ->orderByRaw("FIELD(emp_id, ?) DESC", [$employeeId])
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->get();
        
        $peopleAssigneeData = $this->filteredPeoples ? $this->filteredPeoples : $this->peoples;
        $peopleFollowerData = $this->filteredFollowers ? $this->filteredFollowers : $this->peoples;

        $this->record = Task::all();
        $employeeName = auth()->user()->first_name . ' #(' . $employeeId . ')';
        $this->records = Task::with('emp')
            ->where(function ($query) use ($employeeId, $employeeName) {
                $query->where('emp_id', $employeeId)
                    ->orWhere('assignee', 'LIKE', "%$employeeName%");
            })
            ->orderBy('created_at', 'desc')
            ->get();
        $searchData = $this->filterData ?: $this->records;
        return view('livewire.tasks', [
            'peopleAssigneeData' => $peopleAssigneeData,
            'peopleFollowerData' => $peopleFollowerData,
            'searchData' => $searchData,
            'taskComments' => $this->taskComments,
        ]);
    }
}
