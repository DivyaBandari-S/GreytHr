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

class Activities extends Component
{
    public $selectedEmoji ;
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
    public $emp_id;

    protected $rules = [
        'newComment' => 'required|string',
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

