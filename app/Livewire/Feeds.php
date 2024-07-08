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
use Livewire\WithFileUploads;
use App\Services\GoogleDriveService;
use App\Models\Addcomment;
use App\Models\Company;
use App\Models\Post;

class Feeds extends Component
{

    use WithFileUploads;

    public $category;
    public $description;


    public $showEmojiPicker = false;
    public $employeeId;
    public $open = false;

    public $emojis;

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
    public $data;

    public $selectedEmoji = null;

    public $selectedEmojiReaction;
    public $message = '';
    public $attachment;
    public $storedemojis;

    public $showFeedsDialog = false;
    public $showMessage = true;
    public $empCompanyLogoUrl;
    public function closeMessage()
    {
        $this->showMessage = false;
    }
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



    public function toggleEmojiPicker()
    {
        $this->showEmojiPicker = !$this->showEmojiPicker;
    }


    public function mount()
    {

        $companyId = Auth::user()->company_id;
        // Load employees with comments
        $this->employees = EmployeeDetails::with('comments')->where('company_id', $companyId)->get();

        // Combine and sort data
        $this->combinedData = $this->combineAndSortData($this->employees);

        // Fetch comments for the initial set of cards
        $this->comments = Comment::with('employee')->whereIn('emp_id', $this->employees->pluck('emp_id'))->get();
        $this->addcomments = Addcomment::with('employee')->whereIn('emp_id', $this->employees->pluck('emp_id'))->get();
        $this->storedemojis = Emoji::whereIn('emp_id', $this->employees->pluck('emp_id'))->get();
        $this->emojis = EmojiReaction::whereIn('emp_id', $this->employees->pluck('emp_id'))->get();
        // Retrieve and set the company logo URL for the current employee
        $this->empCompanyLogoUrl = $this->getEmpCompanyLogoUrl();
    }
    public $isEmojiListVisible = false;
    public function showEmojiList()
    {
        // Toggle the visibility of the emoji list
        $this->isEmojiListVisible = !$this->isEmojiListVisible;
    }

    public function toggleEmojiList()
    {
        // Toggle the visibility of the emoji list
        $this->isEmojiListVisible = !$this->isEmojiListVisible;
    }
    // Method to select an emoji
    public function selectEmoji($emoji, $emp_id)
    {
        // Check if an emoji is already selected
        if ($this->selectedEmoji !== $emoji) {
            // Update the selected emoji property
            $this->selectedEmoji = $emoji;
            // Call the add_emoji method with emp_id
            $this->add_emoji($emp_id);
        }
    }
    public function addEmoji($emoji_reaction, $emp_id)
    {
        // Check if an emoji is already selected
        if ($this->selectedEmojiReaction !== $emoji_reaction) {

            $this->selectedEmojiReaction = $emoji_reaction;

            // Call the add_emoji method with emp_id
            $this->createemoji($emp_id);
        }
    }


    // Method to add emoji
    public function add_emoji($emp_id)
    {
        // Get the current user
        $user = Auth::user();

        // Validate if needed

        // Create emoji record
        Emoji::create([
            'emp_id' => $emp_id, // Assuming emp_id is available in the user object
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'emoji' => $this->selectedEmoji ?? '',
        ]);


        // Optionally, toggle emoji list visibility off
        $this->isEmojiListVisible = false;
        $this->storedemojis = Emoji::whereIn('emp_id', $this->employees->pluck('emp_id'))->get();
        // Optionally, show a flash message
        session()->flash('success', 'Emoji added successfully.');
    }
    public function createemoji($emp_id)
    {
        // Get the current user
        $user = Auth::user();

        // Validate if needed

        // Create emoji record
        EmojiReaction::create([
            'emp_id' => $emp_id, // Assuming emp_id is available in the user object
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'emoji_reaction' => $this->selectedEmojiReaction ?? '',
        ]);


        // Optionally, toggle emoji list visibility off
        $this->isEmojiListVisible = false;
        $this->emojis = EmojiReaction::whereIn('emp_id', $this->employees->pluck('emp_id'))->get();
        // Optionally, show a flash message
        session()->flash('message', 'Emoji added successfully.');
    }

    public function add_comment($emp_id)
    {
        $user = Auth::user();

        $this->validate();
        $employeeId = auth()->guard('emp')->user()->emp_id;
        Comment::create([
            'card_id' => $emp_id,
            'emp_id' => $employeeId,
            'comment' => $this->newComment ?? '',
        ]);
        // Clear the input field after adding the comment
        $this->reset(['newComment']);
        $this->isSubmitting = false;
        $this->comments = Comment::with('employee')
            ->whereIn('emp_id', $this->employees->pluck('emp_id'))
            ->orderByDesc('created_at')
            ->get();
        session()->flash('message', 'Comment added successfully.');
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
        $employeeId = auth()->guard('emp')->user()->emp_id;
        // Create a new comment record using the Addcomment model
        Addcomment::create([
            'emp_id' => $employeeId,
            'card_id' => $emp_id,
            'addcomment' => $this->newComment ?? '',
        ]);

        // Clear the input field after adding the comment
        $this->reset(['newComment']);

        $this->isSubmitting = false; // Set submitting flag to false
        $this->addcomments = Addcomment::with('employee')
            ->whereIn('emp_id', $this->employees->pluck('emp_id'))
            ->orderByDesc('created_at')
            ->get();
        // Flash a success message
        session()->flash('message', 'Comment added successfully.');
        $this->combinedData = $this->combineAndSortData($this->employees);
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
        $this->validate($this->newCommentRules);
        // Get the authenticated employee's ID
        $emp_id = Auth::user()->emp_id;

        // Create the post with the provided emp_id and category
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
    public function setCurrentCardEmpId($empId)
    {
        // Set the current card's emp_id
        $this->currentCardEmpId = $empId;

        // Set the employeeDetails based on the current card's emp_id
        $this->employeeDetails = EmployeeDetails::where('emp_id', $empId)->first();

        // Fetch comments for the current card
        $this->comments = Comment::where('card_id', $this->currentCardEmpId)->get();
        $this->addcomments = Addcomment::where('card_id', $this->currentCardEmpId)->get();
        $this->storedemojis = Emoji::where('emp_id', $this->currentCardEmpId)->get();
        $this->emojis = EmojiReaction::where('emp_id', $this->currentCardEmpId)->get();
    }



    public function toggleOpen()
    {
        $this->open = !$this->open;
    }

    public $fileId;

    // Method to fetch the company logo URL for the current employee
    private function getEmpCompanyLogoUrl()
    {
        // Get the current authenticated employee's company ID
        $empCompanyId = auth()->guard('emp')->user()->company_id;

        // Assuming you have a Company model with a 'company_logo' attribute
        $company = Company::where('company_id', $empCompanyId)->first();

        // Return the company logo URL, or a default if not found
        return $company ? $company->company_logo : asset('user.jpg');
    }

    public function render()
    {

        $this->employeeDetails = EmployeeDetails::where('emp_id', auth()->guard('emp')->user()->emp_id)->get();
        $storedEmojis = Emoji::where('emp_id', auth()->guard('emp')->user()->emp_id)->get();
        $emojis = EmojiReaction::where('emp_id', auth()->guard('emp')->user()->emp_id)->get();

        return view('livewire.feeds', [
            'comments' => $this->comments,
            'addcomments' => $this->addcomments,
            'empCompanyLogoUrl' => $this->empCompanyLogoUrl,
            'employees' => $this->employeeDetails, 'emojis' => $emojis, 'storedEmojis' => $storedEmojis,
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
        $currentDate = Carbon::now();

        foreach ($employees as $employee) {
            if ($employee->date_of_birth) {
                $dateOfBirth = Carbon::parse($employee->date_of_birth);
                // Check if the date of birth is within the current month and up to the current date
                if ($dateOfBirth->month <= $currentDate->month && $dateOfBirth->day <= $currentDate->day) {
                    $combinedData[] = [
                        'date' => $dateOfBirth->format('m-d'),
                        'type' => 'date_of_birth',
                        'employee' => $employee,
                    ];
                }
            }

            if ($employee->hire_date) {
                $hireDate = Carbon::parse($employee->hire_date);
                // Check if the hire date is within the current month and up to the current date
                if ($hireDate->month <= $currentDate->month && $hireDate->day <= $currentDate->day) {
                    $combinedData[] = [
                        'date' => $hireDate->format('m-d'),
                        'type' => 'hire_date',
                        'employee' => $employee,
                    ];
                }
            }
        }


        // Sort the combined data by date in descending order
        usort($combinedData, function ($a, $b) {
            return $b['date'] <=> $a['date']; // Sort in descending order
        });

        return $combinedData;
    }
}
