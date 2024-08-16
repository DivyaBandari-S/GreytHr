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
    public $showDialog = false;
    public $showViewFileDialog = false;
    public $showModal = false;
    public $employeeDetails;
    public $emp_id;
    public $task_name;
    public $assignee;
    public $priority = "";
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
  
    public function setActiveTab($tab)
    {
        if ($tab === 'open') {
            $this->activeTab = 'open';
            $this->search = '';
            $this->start = now()->startOfYear()->format('Y-m-d');
            $this->end = now()->endOfYear()->format('Y-m-d');
        } elseif ($tab === 'completed') {
            $this->activeTab = 'completed';
            $this->closedSearch = '';
            $this->start = now()->startOfYear()->format('Y-m-d');
            $this->end = now()->endOfYear()->format('Y-m-d');
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

    public function searchActiveTasks()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $query = Task::where(function($query) use ($employeeId) {
            $query->where('emp_id', $employeeId)
                  ->orWhereRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(assignee, '(', -1), ')', 1) = ?", [$employeeId]);
        })
        ->where('status', 'Open');


        if ($this->start && $this->end) {
            $query->whereBetween('created_at', [$this->start, $this->end]);
        }


        if ($this->search) {
            $query->where(function ($query) {
                $query->where('assignee', 'like', '%' . $this->search . '%')
                      ->orWhere('followers', 'like', '%' . $this->search . '%')
                      ->orWhereHas('emp', function ($query) {
                          $query->where('first_name', 'like', '%' . $this->search . '%')
                                ->orWhere('last_name', 'like', '%' . $this->search . '%');
                      })
                      ->orWhere('task_name', 'like', '%' . $this->search . '%')
                      ->orWhere('emp_id', 'like', '%' . $this->search . '%');
            });
        }

        $this->filterData = $query->orderBy('created_at', 'desc')->get();
        $this->peopleFound = count($this->filterData) > 0;
    }

    public function searchCompletedTasks()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;

        $query = Task::where(function($query) use ($employeeId) {
            $query->where('emp_id', $employeeId)
                  ->orWhereRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(assignee, '(', -1), ')', 1) = ?", [$employeeId]);
        })
         ->where('status', 'Completed');


        if ($this->start && $this->end) {
            $query->whereBetween('created_at', [$this->start, $this->end]);
        }


        if ($this->closedSearch) {
            $query->where(function ($query) {
                $query->where('assignee', 'like', '%' . $this->closedSearch . '%')
                      ->orWhere('followers', 'like', '%' . $this->closedSearch . '%')
                      ->orWhereHas('emp', function ($query) {
                          $query->where('first_name', 'like', '%' . $this->closedSearch . '%')
                                ->orWhere('last_name', 'like', '%' . $this->closedSearch . '%');
                      })
                      ->orWhere('task_name', 'like', '%' . $this->closedSearch . '%')
                      ->orWhere('emp_id', 'like', '%' . $this->closedSearch . '%');
            });
        }

        $this->filterData = $query->orderBy('created_at', 'desc')->get();
        $this->peopleFound = count($this->filterData) > 0;
    }


    public function updatedStart($value)
    {
        $this->start = $value;
        $this->loadTasks();
    }

    public function updatedEnd($value)
    {
        $this->end = $value;
        $this->loadTasks();
    }



    protected $rules = [
        'newComment' => 'required',
    ];
    protected $messages = [
        'newComment.required' => 'Comment is required.',

    ];
    public function validateField($field)
    {

        $this->validateOnly($field, $this->rules);
    }

    public string $year = '';
    public string $start = '';
    public string $end = '';

    protected $listeners = [
        'update',
        'updateStart', 'updateEnd'
    ];

    public function update($start, $end)
    {
        $this->year = carbon::parse($start)->format('Y');
        $this->start = $start;
        $this->end = $end;
    }

    public function changeYear()
    {
        $this->start = Carbon::parse($this->start)->year($this->year)->format('Y-m-d');
        $this->end = Carbon::parse($this->end)->year($this->year)->format('Y-m-d');
    }

    public function forAssignee()
    {
        $this->assigneeList = true;
    }
    public function closeAssignee()
    {
        $this->assigneeList = false;
    }

    public function forFollowers()
    {
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
        $this->selectedPersonClients = collect();
        $this->selectedPersonClientsWithProjects = collect();
        $this->year = Carbon::now()->format('Y');
        $this->start = now()->startOfYear()->format('Y-m-d');
        $this->end = now()->endOfYear()->format('Y-m-d');
        if (session()->has('showAlert')) {
            $this->showAlert = session('showAlert');
        }
    }

    public function selectPerson($personId)
    {
        $this->showRecipients = true;
        $this->selectedPerson = $this->peoples->where('emp_id', $personId)->first();
        $this->selectedPersonClients = ClientsEmployee::whereNotNull('emp_id')->where('emp_id', $this->selectedPerson->emp_id)->get();
        $this->selectedPeopleName = $this->selectedPerson->first_name . ' #(' . $this->selectedPerson->emp_id . ')';
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
    public $selectedPeopleForFollowers = [];
    public function selectPersonForFollowers($personId)
    {
        $selectedPerson = $this->peoples->where('emp_id', $personId)->first();

        if ($selectedPerson) {
            if (in_array($personId, $this->selectedPeopleForFollowers)) {
                $this->selectedPeopleNamesForFollowers[] = $selectedPerson->first_name . ' #(' . $selectedPerson->emp_id . ')';
            } else {
                $this->selectedPeopleNamesForFollowers = array_diff($this->selectedPeopleNamesForFollowers, [$selectedPerson->first_name . ' #(' . $selectedPerson->emp_id . ')']);
            }

            $this->followers = implode(', ', array_unique($this->selectedPeopleNamesForFollowers));
            $this->showFollowers = count($this->selectedPeopleNamesForFollowers) > 0;
        }
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
            $task->update(['status' => 'Open']);
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
                    'priority' => 'required|in:High,Medium,Low',
                ]);
            } else {
                $this->validate([
                    'due_date' => 'required',
                    'client_id' => 'required',
                    'project_name' => 'required',
                    'assignee' => 'required',
                    'task_name' => 'required',
                    'priority' => 'required|in:High,Medium,Low',
                ]);
            }
        }
    }
    

    public function submit()
    {
        $this->validate_tasks = true;
        $this->autoValidate();

        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
        $this->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:1024',
        ]);
        
        // Validate and upload the image file
        if ($this->image) {
            $this->isLoadingImage = true;
            $imagePath = file_get_contents($this->image->getRealPath());
            $this->image_path = $imagePath;
            $this->isLoadingImage = false;
        }


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
            'file_path' => $this->image_path,
            'status' => "Open",
        ]);
      

        Notification::create([
            'emp_id' => $this->employeeDetails->emp_id,
            'notification_type' => 'task',
            'task_name' => $this->task_name,
            'assignee' => $this->assignee,
        ]);

        $this->reset();
        session()->flash('message', 'Task created successfully!');
        session()->flash('showAlert', true);
        return redirect()->to('/tasks');
     
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
        $this->$recordId=$recordId;
        $this->viewrecord = Task::find($recordId);
        $this->showViewFileDialog = true;
    }
    public function closeViewFile()
    {
        $this->showViewFileDialog = false;
    }

    public function close()
    {
        $this->reset();

        $this->showDialog = false;
        $this->validate_tasks = false;
        return redirect('/tasks');
    }

    public function filter()
    {
        $companyId = Auth::user()->company_id;

        $trimmedSearchTerm = trim($this->searchTerm);

        $this->filteredPeoples = EmployeeDetails::where('company_id', $companyId)
            ->where(function ($query) use ($trimmedSearchTerm) {
                $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $trimmedSearchTerm . '%')
                    ->orWhere('emp_id', 'like', '%' . $trimmedSearchTerm . '%');
            })
            ->get();

        $this->peopleFound = count($this->filteredPeoples) > 0;
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
    public function render()
    {

        $this->fetchTaskComments($this->taskId);
        // Retrieve the authenticated employee's ID
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $companyId = Auth::user()->company_id;

        // Fetch employees, ensuring the authenticated employee is shown first
        $this->peoples = EmployeeDetails::where('company_id', $companyId)
            ->orderByRaw("FIELD(emp_id, ?) DESC", [$employeeId])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

            if ($this->activeTab === 'open') {
                $this->searchActiveTasks();
            } elseif ($this->activeTab === 'completed') {
                $this->searchCompletedTasks();
            }

        $peopleData = $this->filteredPeoples ? $this->filteredPeoples : $this->peoples;

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
            'peopleData' => $peopleData,
            'searchData' => $searchData,
            'taskComments' => $this->taskComments,
        ]);
    }
}
