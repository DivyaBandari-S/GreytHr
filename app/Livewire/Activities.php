<?php
 
namespace App\Livewire;
 
use Livewire\Component;
use App\Models\Comment;
use App\Models\EmployeeDetails;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\EmojiReaction;
use App\Models\Employee;
use App\Models\Emoji;
use App\Models\Hr;
use App\Models\Post;
use Illuminate\Support\Facades\Session;

use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class Activities extends Component
{
    use WithFileUploads;

    public $selectedEmoji ;
    public $category;
    public $description;
    public $showAlert = false;
    public $file_path='';
    public $employeeId;
    public $employees;
    public $combinedData;
    public $monthAndDay;
    public $currentCardEmpId;
    public $emojis;
    public $comments = [];
    public $newComment = '';
    public $employeeDetails;
    public $isSubmitting = false;
    public $attachment;
    public $emp_id;
    public $image;
    public $message='';
    public $showFeedsDialog = false;
   
    public function addFeeds()
    {
        $this->showFeedsDialog = true;
    }
   
    public function closeFeeds()
    {
       
        $this->message = '';
        $this->showFeedsDialog = false;
    }
 

    protected $rules = [
        'newComment' => 'required|string',
    ];
    
    protected $newCommentRules = [
        'category' => 'required',
        'description' => 'required',
        'attachment' => 'nullable|file|max:10240',
    ];
 
    public function mount()
    {
       
        $companyId = Auth::user()->company_id;
   
        // Load employees with comments
        $this->employees = EmployeeDetails::with('comments')->where('company_id', $companyId)->get();
   
        // Combine and sort data
        $this->combinedData = $this->combineAndSortData($this->employees);
   
        // Fetch comments for the initial set of cards
        $this->comments = Comment::whereIn('emp_id', $this->employees->pluck('emp_id'))->get();
        $this->emojis = Emoji::all();
    }
   
 
    public function add_comment($emp_id)
{
    $user = Auth::user();
   
 
    $this->validate();
 
    Comment::create([
        'emp_id' => $emp_id,
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'comment' => $this->newComment ?? '',
    ]);
 
    // Clear the input field after adding the comment
    $this->reset(['newComment']);
 
    session()->flash('success', 'Comment added successfully.');
    $this->setCurrentCardEmpId($emp_id);
}
 
 
    public function setCurrentCardEmpId($empId)
    {
        // Set the current card's emp_id
        $this->currentCardEmpId = $empId;
   
        // Set the employeeDetails based on the current card's emp_id
        $this->employeeDetails = EmployeeDetails::where('emp_id', $empId)->first();
   
        // Fetch comments for the current card
        $this->comments = Comment::where('emp_id', $this->currentCardEmpId)->get();
    }
   
 
    public function saveEmojiReaction()
    {
        // Get the authenticated user's employee ID
        $employeeId = auth()->user()->id;
 
        // Check if selectedEmojiId is not null
        if ($this->selectedEmojiId !== null) {
            // Store the emoji reaction associated with the user's employee ID
            Emoji::create([
                'emp_id' => $employeeId,
                'emoji_id' => $this->selectedEmojiId,
            ]);
 
            // Log the successful reaction storage
            Log::info('Emoji reaction saved for employee: ' . $employeeId);
        } else {
            // Handle the case where selectedEmojiId is null
            Log::error('Selected emoji ID is null.');
            // You can also return an error message or perform other error handling actions here
        }
    }
 
    public function submit()
    {

        $validatedData = $this->validate($this->newCommentRules);
    
        try {
            // Validate the form data
           
            $fileContent = null;
            $mimeType = null;
            $fileName = null;
    
            // Process the uploaded file
       
            if ($this->file_path) {
                $fileContent = file_get_contents($this->file_path->getRealPath());
                $mimeType = $this->file_path->getMimeType();
                $fileName = $this->file_path->getClientOriginalName();
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

            // Get the authenticated user
            $user = Auth::user();
    
            // Get the authenticated employee ID and their details
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
    
            // Check if the authenticated employee is a manager
            $isManager = DB::table('employee_details')
                ->where('manager_id', $employeeId)
                ->exists();
    
            if (!$isManager) {
                // Allow employee to create the post but associate it with their manager
                $managerId = $employeeDetails->manager_id;
                if (!$managerId) {
                    session()->flash('error', 'No manager found for this employee. Cannot create post.');
                    return;
                }
            } else {
                $managerId = $employeeId; // If the user is a manager, they can create the post directly
            }
    
            // Create the post
            $post = Post::create([
                'hr_emp_id' => $hrDetails->hr_emp_id ?? '-',
                'manager_id' => $managerId, // Associate the post with the manager
                'category' => $this->category,
                'description' => $this->description,
                'file_path' => $fileContent, // Store binary data in the database
                'mime_type' => $mimeType,
                'file_name' => $fileName,
            ]);
         
            // Reset form fields and display success message
            $this->reset(['category', 'description', ]);
            $this->message = 'Post created successfully!';
            session()->flash('showAlert', true);
            $this->showFeedsDialog = false;
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
        } catch (\Exception $e) {
            Log::error('Error creating request: ' . $e->getMessage(), [
                'employee_id' => $employeeId ?? 'N/A',
                'file_path_length' => isset($fileContent) ? strlen($fileContent) : null,
            ]);
            session()->flash('error', 'An error occurred while creating the request. Please try again.');
        }
    }
    
    
    
    
   
    public function render()
{
    if (auth()->guard('hr')->check()) {
        $this->employeeDetails = Hr::where('hr_emp_id', Auth::user()->hr_emp_id)->first();
    } elseif (auth()->guard('emp')->check()) {
        $this->employeeDetails = EmployeeDetails::where('emp_id', Auth::user()->emp_id)->first();
    } 
    
    return view('livewire.activities', [
        'comments' => $this->comments,
        'employees' => $this->employeeDetails,
    ]);
}
 
    private function combineAndSortData($employees)
    {
        $combinedData = [];
 
        foreach ($employees as $employee) {
            if ($employee->date_of_birth) {
                $combinedData[] = [
                    'date' => Carbon::parse($employee->date_of_birth)->format('m-d'),
                    'type' => 'date_of_birth',
                    'employee' => $employee,
                ];
            }
 
            if ($employee->hire_date) {
                $combinedData[] = [
                    'date' => Carbon::parse($employee->hire_date)->format('m-d'),
                    'type' => 'hire_date',
                    'employee' => $employee,
                ];
            }
        }
        usort($combinedData, function ($a, $b) {
            return $b['date'] <=> $a['date']; // Sort in descending order
        });
 
        return $combinedData;
    }
}
 
 