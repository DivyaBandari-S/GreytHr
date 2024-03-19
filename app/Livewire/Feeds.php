<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\EmployeeDetails;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Http\Request; 
use App\Models\EmojiReaction;
use App\Models\Employee;
use App\Models\Emoji;


use App\Models\Addcomment;


class Feeds extends Component
{

  
    public $showEmojiPicker = false;
    public $employeeId;
    public $employees;
    public $combinedData;
    public $monthAndDay;
    public $currentCardEmpId;
  
    public $comments = [];
    public $newComment = '';
    public $employeeDetails;
    public $isSubmitting = false;
    public $emp_id;
    public $addcomments;

    public $selectedEmoji = null;
    public $emojis = ['😀', '😃', '😄', '😁', '😆', '😅', '😂', '🤣', '😊', '😇', '🙂', '🙃', '😉', '😌', '😍', '😘', '😗', '😙', '😚', '😋', '😛', '😝', '😜', '🤪', '🤨', '🧐', '🤓', '😎', '🤩', '😏', '😒', '😞', '😔', '😟', '😕', '🙁', '😣', '😖', '😫', '😩', '😤', '😠', '😡', '🤬', '😈', '👿', '💀', '☠️', '💩', '🤡', '👹', '👺', '👻', '👽', '👾', '🤖', '🎃', '😺', '😸', '😹', '😻', '😼', '😽', '🙀', '😿', '😾'];

    protected $rules = [
        'newComment' => 'required|string',
    ];
    public function toggleEmojiPicker()
    {
        $this->showEmojiPicker = !$this->showEmojiPicker;
    }

    public function selectEmoji($emoji)
    {
        $this->selectedEmoji = $emoji;
        $this->showEmojiPicker = false; // Hide emoji picker after selection
    }
    public function mount()
    {
        
        $companyId = Auth::user()->company_id;
    
        // Load employees with comments
        $this->employees = EmployeeDetails::with('comments')->where('company_id', $companyId)->get();
    
        // Combine and sort data
        $this->combinedData = $this->combineAndSortData($this->employees);
    
        // Fetch comments for the initial set of cards
        $this->comments = Comment::whereIn('emp_id', $this->employees->pluck('emp_id'))->get();
        $this->addcomments = Addcomment::whereIn('emp_id', $this->employees->pluck('emp_id'))->get();
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
         'image'   => $user->image,
        'comment' => $this->newComment ?? '',
    ]);

    // Clear the input field after adding the comment
    $this->reset(['newComment']);
    $this->isSubmitting = false;
    $this->comments = Comment::whereIn('emp_id', $this->employees->pluck('emp_id'))->get();

    session()->flash('success', 'Comment added successfully.');
    $this->setCurrentCardEmpId($emp_id);
}

public function employee()
{
    return $this->belongsTo(EmployeeDetails::class, 'emp_id');
}
public function createcomment($emp_id)
{
    $this->isSubmitting = true; // Set submitting flag to true

    // Validate the input fields
    $this->validate();
   
    // Create a new comment record using the Addcomment model
    Addcomment::create([
        'emp_id' => $emp_id,
        'first_name' => auth()->user()->first_name,
        'last_name' => auth()->user()->last_name,
        'image' => auth()->user()->image,
        'addcomment' => $this->newComment ?? '',
    ]);

    // Clear the input field after adding the comment
    $this->reset(['newComment']);

    $this->isSubmitting = false; // Set submitting flag to false
    $this->addcomments = Addcomment::whereIn('emp_id', $this->employees->pluck('emp_id'))->get();

    // Flash a success message
    session()->flash('success', 'Comment added successfully.');
}

    public function setCurrentCardEmpId($empId)
    {
        // Set the current card's emp_id
        $this->currentCardEmpId = $empId;
    
        // Set the employeeDetails based on the current card's emp_id
        $this->employeeDetails = EmployeeDetails::where('emp_id', $empId)->first();
    
        // Fetch comments for the current card
        $this->comments = Comment::where('emp_id', $this->currentCardEmpId)->get();
        $this->addcomments = Addcomment::where('emp_id', $this->currentCardEmpId)->get();
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
            \Log::info('Emoji reaction saved for employee: ' . $employeeId);
        } else {
            // Handle the case where selectedEmojiId is null
            \Log::error('Selected emoji ID is null.');
            // You can also return an error message or perform other error handling actions here
        }
    }

    
        
    
    public function render()
{
    $this->employeeDetails = EmployeeDetails::where('emp_id', auth()->guard('emp')->user()->emp_id)->get();
    $emojis = Emoji::all();
   
    return view('livewire.feeds', [
        'comments' => $this->comments,
        'addcomments'=>$this->addcomments,
        'employees' => $this->employeeDetails,'emojis' => $emojis
    ]);
}


    public function saveEmoji()
    {
        // Save the selected emoji to the database
        if ($this->selectedEmoji) {
            Emoji::create(['code' => $this->selectedEmoji]);
            $this->selectedEmoji = null; // Clear selected emoji after saving
        }
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