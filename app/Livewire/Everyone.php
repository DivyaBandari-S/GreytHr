<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\EmployeeDetails;
use App\Models\Hr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class Everyone extends Component
{
    
    use WithFileUploads;

    public $image;
    public $posts;



    public $category;
    public $description;
    public $attachment;
    public $employeeDetails;
    public $message = '';
    public $showFeedsDialog = false;
   

    protected $rules = [
        'category' => 'required',
        'description' => 'required',
        'attachment' => 'nullable|file|max:10240',
    ];

    public function addFeeds()
    {
        $this->showFeedsDialog = true;
    }
    public function mount()
    {
        // Retrieve posts data and assign it to the $posts property
        $this->posts = Post::orderBy('created_at', 'desc')->get();
        $user = Auth::user();
        if ($user) {
            $this->employeeDetails = $user->employeeDetails;
        }
    }
    public function closeFeeds()
    {
        
        $this->message = '';
        $this->showFeedsDialog = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->reset(['category', 'description', 'attachment', 'message', 'showFeedsDialog']);
    }

    public function upload()
    {
        $this->validate([
            'attachment' => 'required|file|max:10240',
        ]);

        $this->attachment->store('attachments');
        $this->message = 'File uploaded successfully!';
    }




    public function submit()
{
    $this->validate();
  
    $user = Auth::user();
        $employeeDetails = $user->employeeDetails;
        $this->employeeDetails = Hr::where('hr_emp_id', $user->hr_emp_id)->first();
       
     
        // Check if employee details exist and hr_emp_id is not null
        if (!$this->employeeDetails || !$this->employeeDetails->hr_emp_id) {
            // Handle case where hr_emp_id is null or not found
            Session::flash('error', 'Employees are not allowed to Post Feeds');
            return;
        }

    // Get the authenticated employee's ID
    $hr_emp_id = Auth::user()->hr_emp_id;

    // Create the post with the provided emp_id
    $post = Post::create([
        'hr_emp_id' => $hr_emp_id,
        'category' => $this->category,
        'description' => $this->description,
    ]);

    if ($this->attachment) {
        // Store the attachment and update the post's attachment field
        $attachmentPath = $this->attachment->store('attachments', 'public');
        $post->update(['attachment' => $attachmentPath]);
    }

    // Reset form fields and display success message
    $this->reset(['category', 'description', 'attachment']);
    $this->message = 'Post created successfully!';
    $this->showFeedsDialog = false;
}

    public function render()
    {

          if (auth()->guard('hr')->check()) {
            $this->employeeDetails = Hr::where('hr_emp_id', Auth::user()->hr_emp_id)->first();
        } elseif (auth()->guard('emp')->check()) {
            $this->employeeDetails = EmployeeDetails::where('emp_id', Auth::user()->emp_id)->first();
        } else {
            // Handle case where no guard is matched
            Session::flash('error', 'User is not authenticated as HR or Employee');
            return;
        }
        
        return view('livewire.everyone');
    }
}
