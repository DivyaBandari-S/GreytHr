<?php
// File Name                       : Feeds.php
// Description                     : This file contains the information about Activities and Posts in this implemented functionality for adding comments and emojis.
// Creator                         : Ashannagari Archana
// Email                           : archanaashannagari@gmail.com
// Organization                    : PayG.
// Date                            : 2023-09-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : Comment,AddComment,Emoji,EmojiReaction,EmployeeDetails
namespace App\Livewire;

use App\Helpers\FlashMessageHelper;
use App\Models\Comment;
use App\Models\EmployeeDetails;
use App\Models\Notification;
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
use App\Models\Hr;
use Illuminate\Support\Facades\Session;
use App\Models\Post;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Feeds extends Component
{

    use WithFileUploads;
   public $image;
   public $currentCardEmojis;
   public $card_id;
   public $file_path;
   public $description = '';
    public $category;

    public $search;


    public $showEmojiPicker = false;
    public $employeeId;
    public $showAlert = false;
    public $open = false;

    public $emojis;

    public $employees;
    public $hr;

    public $dropdownVisible = false;
    public $monthAndDay;
    public $currentCardEmpId;

    public $comments = [];

    public $sortType='newest';
    public $newComment = '';
    public $employeeDetails;
    public $status;
    public $postStatus;
    public $isSubmitting = false;
    public $emp_id;
    public $addcomments;
    public $allEmojis;
    public $data;

    public $selectedEmoji = null;

    public $selectedEmojiReaction;
    public $message = '';
    public $isManager;
    public $flashMessage = '';
      public $storedemojis;
      public $showDialog = false;
      public $showDialogEmoji=false;

    public $showFeedsDialog = false;
    public $showMessage = true;
    public $empCompanyLogoUrl;

    public $combinedData = [];
    public function closeMessage()
    {
        $this->showMessage = false;
    }
    public function openPost($postId)
{
    $post = Post::find($postId);

    if ($post) {
        $post->update(['status' => 'Open']);
    }

    return redirect()->to('/feeds'); // Redirect to the appropriate route
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
        'file_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:40960',
    ];
    protected $messages = [
        'category.required' => 'Category is required.',

        'description.required' => 'Description is required.',

    ];


    public function toggleEmojiPicker()
    {
        $this->showEmojiPicker = !$this->showEmojiPicker;
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        // Get the authenticated user's company ID
        $authCompanyId = Auth::user()->company_id;

        // Fetch the parent company where is_parent is 'yes'
        $company = DB::table('companies')
            ->where('company_id', $authCompanyId)
            ->where('is_parent', 'yes')
            ->first();


        // Check if a parent company was found
        if ($company) {
            // Debugging: Print the raw company_id from the database (assumed to be a JSON string)


            // No need to decode company_id as an array; treat it as a string
            $companyId = $company->company_id;


            // Ensure the company ID is not null or empty
            if (!empty($companyId)) {
                // Load employees where the company_id JSON field in employee_details matches the parent company_id string
                $this->employees = EmployeeDetails::whereRaw("JSON_CONTAINS(company_id, '\"$companyId\"')")->get();
                $this->comments = Comment::with('employee')->whereIn('emp_id', $this->employees->pluck('emp_id'))->get();
                $this->addcomments = Addcomment::with('employee')->whereIn('emp_id', $this->employees->pluck('emp_id'))->get();
                $this->storedemojis = Emoji::whereIn('emp_id', $this->employees->pluck('emp_id'))->get();
                $this->emojis = EmojiReaction::whereIn('emp_id', $this->employees->pluck('emp_id'))->get();
                $this->allEmojis = Emoji::whereIn('emp_id', $this->employees->pluck('emp_id'))->get();
                $this->combinedData = $this->combineAndSortData($this->employees);
                $this->empCompanyLogoUrl = $this->getEmpCompanyLogoUrl();
                $this->loadComments();
      $employeeId = Auth::guard('emp')->user()->emp_id;
      $this->isManager = DB::table('employee_details')
          ->where('manager_id', $employeeId)
          ->exists();


            }
        } else {
            // If no parent company is found

        }
        $today=now();
        $currentDate = $today->toDateString();
        $birthdayRecord = Notification::where('body', $currentDate)
        ->where('assignee',$authCompanyId[0])
        ->where('notification_type', 'birthday')
        ->first();
        if ($birthdayRecord) {
            // Decode the JSON field into a PHP array
            $isBirthdayRead = json_decode($birthdayRecord->is_birthday_read, true);

            // Check if the employee ID exists in the array and update it
            if (isset($isBirthdayRead[$employeeId])) {
                $isBirthdayRead[$employeeId] = 1;  // Mark as read (1)
            }

            // Encode the updated array back into JSON
            $birthdayRecord->is_birthday_read = json_encode($isBirthdayRead);

            // Save the updated record back to the database
            $birthdayRecord->save();
        }


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

    public function openDialog($emp_id)
    {
        logger()->info('openDialog method called with emp_id: ' . $emp_id);  // Log the method call


        $this->emp_id = $emp_id;
        $this->currentCardEmojis = Emoji::where('emp_id', $emp_id)->get();
        $this->allEmojis = Emoji::where('emp_id', $emp_id)->get();


        $this->showDialog = true;
          // Fetch the latest emoji reactions for the specific employee

    }
    public function openEmojiDialog($emp_id)
    {
        logger()->info('openDialog method called with emp_id: ' . $emp_id);  // Log the method call

        $this->emp_id = $emp_id;
        $this->currentCardEmojis = Emoji::where('emp_id', $emp_id)->get();


 $this->allEmojis = Emoji::where('emp_id', $emp_id)->get();
        $this->showDialogEmoji = true;
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

    public function closeEmojiDialog()
    {
        $this->showDialogEmoji = false;
    }
    public function closeDialog()
    {
        $this->showDialog = false;
    }
    public function removeEmojiReaction($emojiId)
    {
        try {
            // Locate the emoji based on ID
            $emoji_reaction = EmojiReaction::find($emojiId);
            
            if ($emoji_reaction && $emoji_reaction->emp_id === auth()->user()->emp_id) { // Check if the emoji belongs to the logged-in user
                $emoji_reaction->delete();
    
                // Dispatch a success message
                FlashMessageHelper::flashSuccess('You have removed your reaction.');
    
                // Remove the deleted emoji from $allEmojis
                $this->allEmojis = collect($this->allEmojis)->reject(fn($item) => $item->id === $emojiId);
                $this->dispatch('emojiRemoved', ['emojiId' => $emojiId]);
            } else {
                throw new \Exception('You can only remove your own reactions.');
            }
        } catch (\Exception $e) {
            FlashMessageHelper::flashError($e->getMessage());
        }
    }

    public function removeReaction($emojiId)
    {
        try {
            // Locate the emoji based on ID
            $emoji = Emoji::find($emojiId);
            
            if ($emoji && $emoji->emp_id === auth()->user()->emp_id) { // Check if the emoji belongs to the logged-in user
                $emoji->delete();
    
                // Dispatch a success message
                FlashMessageHelper::flashSuccess('You have removed your reaction.');
    
                // Remove the deleted emoji from $allEmojis
                $this->allEmojis = collect($this->allEmojis)->reject(fn($item) => $item->id === $emojiId);
                $this->dispatch('emojiRemoved', ['emojiId' => $emojiId]);
            } else {
                throw new \Exception('You can only remove your own reactions.');
            }
        } catch (\Exception $e) {
            FlashMessageHelper::flashError($e->getMessage());
        }
    }

    public function handleEmojiRemoval($emojiId)
    {
        // Handle the emoji removal logic (e.g., remove it from the list)
        $this->allEmojis = $this->allEmojis->reject(fn($item) => $item->id === $emojiId);
    }

    // Method to add emoji
    public function add_emoji($emp_id)
    {
        // Get the current user
        $user = Auth::user();

        // Validate if needed
        $employeeId = null;
        $hrId = null;

        if (auth()->guard('emp')->check()) {
            // Get the current authenticated employee's emp_id
            $employeeId = auth()->guard('emp')->user()->emp_id;
        } elseif (auth()->guard('hr')->check()) {
            // Get the current authenticated HR's emp_id
            $hrEmployee = auth()->guard('hr')->user();
            $hrId = $hrEmployee->emp_id;
        }

        // Ensure that either $employeeId or $hrId is set
        if (is_null($employeeId) && is_null($hrId)) {
            FlashMessageHelper::flashError( 'Employee ID cannot be null.');
            return;
        }

        // Create the comment based on the authenticated role
        if ($employeeId) {
        // Create emoji record
        Emoji::create([
            'card_id' => $emp_id,
            'emp_id' =>  $employeeId, // Assuming emp_id is available in the user object
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'emoji' => $this->selectedEmoji ?? '',
        ]);

    }
        // Optionally, toggle emoji list visibility off
        $this->isEmojiListVisible = false;
        $this->storedemojis = Emoji::whereIn('emp_id', $this->employees->pluck('emp_id'))->get();

    }
    public function createemoji($emp_id)
    {
        // Get the current user
        $user = Auth::user();
        $employeeId = null;
        $hrId = null;

        if (auth()->guard('emp')->check()) {
            // Get the current authenticated employee's emp_id
            $employeeId = auth()->guard('emp')->user()->emp_id;
        } elseif (auth()->guard('hr')->check()) {
            // Get the current authenticated HR's emp_id
            $hrEmployee = auth()->guard('hr')->user();
            $hrId = $hrEmployee->emp_id;
        }

        // Ensure that either $employeeId or $hrId is set
        if (is_null($employeeId) && is_null($hrId)) {
            FlashMessageHelper::flashError('Employee ID cannot be null.');
            return;
        }

        // Create the comment based on the authenticated role
        if ($employeeId) {
        // Validate if needed

        // Create emoji record
        EmojiReaction::create([
            'card_id' => $emp_id,
            'emp_id' =>  $employeeId, // Assuming emp_id is available in the user object
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'emoji_reaction' => $this->selectedEmojiReaction ?? '',
        ]);
    }

        // Optionally, toggle emoji list visibility off
        $this->isEmojiListVisible = false;
        $this->emojis = EmojiReaction::whereIn('emp_id', $this->employees->pluck('emp_id'))->get();


    }

    public function getComments($sortType)
    {
        $query = Comment::query();

        if ($sortType === 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sortType === 'interacted') {
            $query->orderBy('updated_at', 'desc');
        }

        $currentCardComments = $query->get();

        return view('feeds', compact('currentCardComments', 'sortType'));
    }

    public function add_comment($emp_id)
    {
        $this->validate();

        $employeeId = null;
        $hrId = null;

        if (auth()->guard('emp')->check()) {
            // Get the current authenticated employee's emp_id
            $employeeId = auth()->guard('emp')->user()->emp_id;
        } elseif (auth()->guard('hr')->check()) {
            // Get the current authenticated HR's emp_id
            $hrEmployee = auth()->guard('hr')->user();
            $hrId = $hrEmployee->emp_id;
        }

        // Ensure that either $employeeId or $hrId is set
        if (is_null($employeeId) && is_null($hrId)) {
            FlashMessageHelper::flashError( 'Employee ID cannot be null.');
            return;
        }

        // Create the comment based on the authenticated role
        if ($employeeId) {
            Comment::create([
                'card_id' => $emp_id,
                'emp_id' => $employeeId,
                'hr_emp_id' => null,
                'comment' => $this->newComment ?? '',
            ]);
        } elseif ($hrId) {
            Comment::create([
                'card_id' => $emp_id,
                'emp_id' => $employeeId,
                'hr_emp_id' => $hrId,
                'comment' => $this->newComment ?? '',
            ]);
        }


        // Clear the input field after adding the comment
        $this->reset(['newComment']);
        $this->isSubmitting = false;

        $this->comments = Comment::with('employee','hr')
            ->whereIn('emp_id', $this->employees->pluck('emp_id'))
            ->orWhereIn('hr_emp_id', $this->employees->pluck('emp_id'))
            ->orderByDesc('created_at')
            ->get();


    }
    public function createcomment($emp_id)
    {
        $this->validate();

        $employeeId = null;
        $hrId = null;

        if (auth()->guard('emp')->check()) {
            // Get the current authenticated employee's emp_id
            $employeeId = auth()->guard('emp')->user()->emp_id;
        } elseif (auth()->guard('hr')->check()) {
            // Get the current authenticated HR's emp_id
            $hrEmployee = auth()->guard('hr')->user();
            $hrId = $hrEmployee->emp_id;
        }

        // Ensure that either $employeeId or $hrId is set
        if (is_null($employeeId) && is_null($hrId)) {
            FlashMessageHelper::flashError('Employee ID cannot be null.');
            return;
        }

        // Create the comment based on the authenticated role
        if ($employeeId) {
           AddComment::create([
                'card_id' => $emp_id,
                'emp_id' => $employeeId,

                'addcomment' => $this->newComment ?? '',
            ]);
        } elseif ($hrId) {
            AddComment::create([
                'card_id' => $emp_id,
                'emp_id' => $employeeId,

                'addcomment' => $this->newComment ?? '',
            ]);
        }


        // Clear the input field after adding the comment
        $this->reset(['newComment']);
        $this->isSubmitting = false;


            $this->addcomments = Addcomment::with('employee')
            ->whereIn('emp_id', $this->employees->pluck('emp_id'))
            ->orderByDesc('created_at')
            ->get();



    }
    protected $listeners = ['updateSortType','emojiRemoved' => 'handleEmojiRemoval'];
    // Toggle dropdown visibility
    public function toggleDropdown()
    {
        $this->dropdownVisible = !$this->dropdownVisible;
    }


    public function updateSortType($sortType)
    {
        $this->sortType = $sortType;

        $this->loadComments();


    }

    public function loadComments()
{
    // Fetch all comments initially
    $commentsQuery = Comment::with('employee', 'hr')
        ->whereIn('emp_id', $this->employees->pluck('emp_id'))
        ->orWhereIn('hr_emp_id', $this->employees->pluck('emp_id'));

    // Fetch all comments
    $allComments = $commentsQuery->get();

    // Group comments by card_id and filter card_ids with more than 2 comments
    $cardIdsWithMoreThanTwoComments = $allComments->groupBy('card_id')
        ->filter(function ($comments) {
            return $comments->count() > 2;
        })
        ->keys();

    // Fetch comments only for those card IDs
    $filteredCommentsQuery = $commentsQuery->whereIn('card_id', $cardIdsWithMoreThanTwoComments);

    // Sort the filtered comments based on the sortType
    if ($this->sortType === 'interacted') {
        $filteredCommentsQuery = $filteredCommentsQuery->orderByDesc('updated_at');
    } else {
        $filteredCommentsQuery = $filteredCommentsQuery->orderByDesc('created_at');
    }

    $this->comments = $filteredCommentsQuery->get();


}
public function loadaddComments()
{
    // Fetch all comments initially
    $commentsQuery = Comment::with('employee', 'hr')
        ->whereIn('emp_id', $this->employees->pluck('emp_id'))
        ->orWhereIn('hr_emp_id', $this->employees->pluck('emp_id'));

    // Fetch all comments
    $allComments = $commentsQuery->get();

    // Group comments by card_id and filter card_ids with more than 2 comments
    $cardIdsWithMoreThanTwoComments = $allComments->groupBy('card_id')
        ->filter(function ($comments) {
            return $comments->count() > 2;
        })
        ->keys();

    // Fetch comments only for those card IDs
    $filteredCommentsQuery = $commentsQuery->whereIn('card_id', $cardIdsWithMoreThanTwoComments);

    // Sort the filtered comments based on the sortType
    if ($this->sortType === 'interacted') {
        $filteredCommentsQuery = $filteredCommentsQuery->orderByDesc('updated_at');
    } else {
        $filteredCommentsQuery = $filteredCommentsQuery->orderByDesc('created_at');
    }

    $this->addcomments  = $filteredCommentsQuery->get();


}



    public function employee()
    {
        return $this->belongsTo(EmployeeDetails::class, 'emp_id');
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
                FlashMessageHelper::flashError('Failed to read the uploaded file.');
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
            FlashMessageHelper::flashSuccess ( 'Post created successfully!');
            $this->showFeedsDialog = false;

        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
        } catch (\Exception $e) {
            Log::error('Error creating request: ' . $e->getMessage(), [
                'employee_id' => $employeeId ?? 'N/A',
                'file_path_length' => isset($fileContent) ? strlen($fileContent) : null,
            ]);
            FlashMessageHelper::flashError ('An error occurred while creating the request. Please try again.');
        }
    }




    public function setCurrentCardEmpId($empId)
    {
        // Set the current card's emp_id
        $this->currentCardEmpId = $empId;

        // Set the employeeDetails based on the current card's emp_id
        $this->employeeDetails = EmployeeDetails::where('emp_id', $empId)->first();

        // Fetch comments for the current card
        $this->comments = Comment::with('employee', 'hr')
        ->where('card_id', $empId)
        ->orderByDesc('created_at')
        ->get();

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
        if (auth()->guard('emp')->check()) {
            // Get the current authenticated employee's company ID
            $empCompanyId = auth()->guard('emp')->user()->company_id;
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $employeeDetails = DB::table('employee_details')
            ->where('emp_id', $employeeId)
            ->select('company_id') // Select only the company_id
            ->first();
 
            // Assuming you have a Company model with a 'company_logo' attribute
              $companyIds = json_decode($employeeDetails->company_id);
            $company = DB::table('companies')
            ->where('company_id', $companyIds)
            ->where('is_parent', 'yes')
            ->first();
            // Return the company logo URL, or a default if company not found
            return $company ? $company->company_logo : asset('user.jpg');
        } elseif (auth()->guard('hr')->check()) {
            $empCompanyId = auth()->guard('hr')->user()->company_id;
 
            // Assuming you have a Company model with a 'company_logo' attribute
            $company = Company::where('company_id', $empCompanyId)->first();
            return $company ? $company->company_logo : asset('user.jpg');
        }
 
 
 
 
    }

    public function render()
    {
        // Initialize variables
        $this->employeeDetails = collect();
        $this->hr = collect();
        $storedEmojis = collect();
        $emojis = collect();
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

        // $isManager = DB::table('employee_details')
      //     ->where('manager_id', $employeeId)
      //     ->exists();
      $isManager = DB::table('employee_details')
      ->where('manager_id', $employeeId)  // Assuming $employeeId is the manager's ID
      ->get();

        // Check if 'emp' guard is authenticated
        if (auth()->guard('emp')->check()) {
            $this->employeeDetails = EmployeeDetails::with('personalInfo') // Eager load personal info
                ->where('emp_id', auth()->guard('emp')->user()->emp_id)
                ->get();

            $storedEmojis = Emoji::where('emp_id', auth()->guard('emp')->user()->emp_id)->get();
            $emojis = EmojiReaction::where('emp_id', auth()->guard('emp')->user()->emp_id)->get();

            // Check if no employee details are found
            if ($this->employeeDetails->isEmpty()) {
                // Redirect or handle the case where no employee details are found
                return redirect()->route('Feeds'); // Redirect to a route for no employee details
            }
        }
        // Check if 'hr' guard is authenticated
        elseif (auth()->guard('hr')->check()) {
            $this->employeeDetails = Hr::where('hr_emp_id', auth()->guard('hr')->user()->hr_emp_id)->get();

            // Check if no employee details are found
            if ($this->employeeDetails->isEmpty()) {
                // Redirect or handle the case where no employee details are found
                return redirect()->route('no-employee-details'); // Redirect to a route for no employee details
            }
        }

        // Return the view with the necessary data
        return view('livewire.feeds', [
            'comments' => $this->comments,
            'addcomments' => $this->addcomments,
            'empCompanyLogoUrl' => $this->empCompanyLogoUrl,
            'hr' => $this->employeeDetails,
            'employees' => $this->employeeDetails,
            'emojis' => $emojis,
            'isManager' => $this->isManager,
            'storedEmojis' => $storedEmojis
        ]);
    }

public function showEmployee($id)
{
    $employee = EmployeeDetails::find($id);
    $comments = Comment::with(['employee', 'hr'])
                        ->where('card_id', $employee->emp_id)
                        ->orWhere('hr_emp_id', $employee->emp_id)
                        ->orderBy('created_at', 'desc')
                        ->get();

    return view('yourview', compact('employee', 'comments'));
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
            if ($employee->personalInfo && !empty($employee->personalInfo->date_of_birth)) {
                $dateOfBirth = Carbon::parse($employee->personalInfo->date_of_birth);

                // Check if the date of birth is within the current month and up to the current date
                if ($dateOfBirth->month < $currentDate->month ||
                    ($dateOfBirth->month === $currentDate->month && $dateOfBirth->day <= $currentDate->day)) {
                    $combinedData[] = [
                        'date' => $dateOfBirth->format('m-d'), // Format date as needed
                        'type' => 'date_of_birth',
                        'employee' => $employee,
                    ];
                }
            }

            if ($employee->hire_date) {
                $hireDate = Carbon::parse($employee->hire_date);

                // Check if the hire date is within the current month and up to the current date
                if ($hireDate->month < $currentDate->month ||
                    ($hireDate->month === $currentDate->month && $hireDate->day <= $currentDate->day)) {
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
