<?php
 
namespace App\Livewire;

use App\Helpers\FlashMessageHelper;
use Livewire\Component;
use App\Models\Comment;
use App\Models\Company;
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
    public $file_path;
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
    public $empCompanyLogoUrl;

    public $emp_id;
    public $isManager;
    public $image;
    public $message='';
    public $posts;
    public $showFeedsDialog = false;
   
    public function addFeeds()
    {
        $this->showFeedsDialog = true;
    }
    public function openPost($postId)
    {
        $post = Post::find($postId);
    
        if ($post) {
            $post->update(['status' => 'Open']);
        }
    
        return redirect()->to('/feeds'); // Redirect to the appropriate route
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
        $this->posts  = Post::where('status', 'Closed')
             ->orderBy('updated_at', 'desc')
             ->get();
             $this->empCompanyLogoUrl = $this->getEmpCompanyLogoUrl();
        // Fetch comments for the initial set of cards
        $this->comments = Comment::whereIn('emp_id', $this->employees->pluck('emp_id'))->get();
        $this->emojis = Emoji::all();
        $employeeId = Auth::guard('emp')->user()->emp_id;
        $this->isManager = DB::table('employee_details')
            ->where('manager_id', $employeeId)
            ->exists();
    }
    private function getEmpCompanyLogoUrl()
    {
        // Get the current authenticated employee's company ID
        if (auth()->guard('emp')->check()) {
            // Get the current authenticated employee's company ID
            $empCompanyId = auth()->guard('emp')->user()->company_id;
    
            // Assuming you have a Company model with a 'company_logo' attribute
            $company = Company::where('company_id', $empCompanyId)->first();
    
            // Return the company logo URL, or a default if company not found
            return $company ? $company->company_logo : asset('user.jpg');
        } elseif (auth()->guard('hr')->check()) {
            $empCompanyId = auth()->guard('hr')->user()->company_id;
    
            // Assuming you have a Company model with a 'company_logo' attribute
            $company = Company::where('company_id', $empCompanyId)->first();
            return $company ? $company->company_logo : asset('user.jpg');
        }
    

        
      
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
   
    public function handleRadioChange($value)
    {
        // Define the URLs based on the radio button value
        $urls = [
            'posts' => '/everyone',
            'activities' => '/Feeds',
            'post-requests'=>'/emp-post-requests'
            // Add more mappings if necessary
        ];
    
        // Redirect to the correct URL
        if (array_key_exists($value, $urls)) {
            return redirect()->to($urls[$value]);
        }
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
        // Update validation to only allow image files
        $validatedData = $this->validate([
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'file_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048', // Only allow image files with a max size of 2MB
        ]);
    
        try {
            $fileContent = null;
            $mimeType = null;
            $fileName = null;
    
            // Process the uploaded image file
            if ($this->file_path) {
                // Validate file is an image
                if (!in_array($this->file_path->getMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'])) {
                    session()->flash('error', 'Only image files (jpeg, png, gif, svg) are allowed.');
                    return;
                }
    
                $fileContent = file_get_contents($this->file_path->getRealPath());
                $mimeType = $this->file_path->getMimeType();
                $fileName = $this->file_path->getClientOriginalName();
            }
    
            // Check if the file content is valid
            if ($fileContent === false) {
                Log::error('Failed to read the uploaded file.', [
                    'file_path' => $this->file_path->getRealPath(),
                ]);
                FlashMessageHelper::flashError( 'Failed to read the uploaded file.');
                return;
            }
    
            // Check if the file content is too large (16MB limit for MEDIUMBLOB)
            if (strlen($fileContent) > 16777215) {
                FlashMessageHelper::flashWarning('File size exceeds the allowed limit.');
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
    
            // If not a manager, set `emp_id` instead of `manager_id`
            $postStatus = $isManager ? 'Closed' : 'Pending'; // Set to 'Closed' if the user is a manager
            $managerId = $isManager ? $employeeId : null;
            $empId = $isManager ? null : $employeeId;
    
            // Retrieve the HR details if applicable
            $hrDetails = Hr::where('hr_emp_id', $user->hr_emp_id)->first();
    
            // Create the post
            $post = Post::create([
                'hr_emp_id' => $hrDetails->hr_emp_id ?? '-',
                'manager_id' => $managerId, // Set manager_id only if the user is a manager
                'emp_id' => $empId,          // Set emp_id only if the user is an employee
                'category' => $this->category,
                'description' => $this->description,
                'file_path' => $fileContent, // Store binary data in the database
                'mime_type' => $mimeType,
                'file_name' => $fileName,
                'status' => $postStatus,
            ]);
    
            // Reset form fields and display success message
            $this->reset(['category', 'description', 'file_path']);
            FlashMessageHelper::flashSuccess( 'Post created successfully!');
            $this->showFeedsDialog = false;
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
        } catch (\Exception $e) {
            Log::error('Error creating request: ' . $e->getMessage(), [
                'employee_id' => $employeeId ?? 'N/A',
                'file_path_length' => isset($fileContent) ? strlen($fileContent) : null,
            ]);
            FlashMessageHelper::flashError('An error occurred while creating the request. Please try again.');
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
        'employees' => $this->employeeDetails,    'isManager' => $this->isManager,
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
 
 