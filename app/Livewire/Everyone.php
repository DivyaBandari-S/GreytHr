<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Auth;
class Everyone extends Component
{
    
    use WithFileUploads;
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
        $this->posts = Post::all();
    }
    public function closeFeeds()
    {
        
        $this->message = '';
        $this->showFeedsDialog = false;
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

    // Get the authenticated employee's ID
    $emp_id = auth()->guard('emp')->user()->emp_id;

    // Create the post with the provided emp_id
    $post = Post::create([
        'emp_id' => $emp_id,
        'category' => $this->category,
        'description' => $this->description,
    ]);

    if ($this->attachment) {
        // Store the attachment and update the post's attachment field
        $attachmentPath = $this->attachment->store('attachments', 'public');
        $post->update(['attachment' => $attachmentPath]);
    }
 
    // Reset form fields and display messages
    $this->reset(['category', 'description', 'attachment']);
    $this->message = 'Post created successfully!';
    $this->showFeedsDialog = false;
}

    public function render()
    {
        $this->employeeDetails = EmployeeDetails::where('emp_id', auth()->guard('emp')->user()->emp_id)->get();
        return view('livewire.everyone');
    }
}
