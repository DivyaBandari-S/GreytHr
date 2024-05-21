<?php
 
namespace App\Livewire;
 
use App\Models\Chating;
use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
 
 
class Employee extends Component
{
    public $employees;
    public $peopleData;
   
    public $companyId;
 
    public $employeeId;
   
    public $conversations;
   
 
 
    public $search = '';
 
    public $searchTerm = '';
 
    public $isRotated = false;
    public $selectedPerson = null;
    public $peoples;
    public $filteredPeoples;
    public $peopleFound = true;
    public $category;
    public $subject;
    public $description;
    public $file_path;
    public $cc_to;
    public $priority;
    public $records;
    public $image;
    public $selectedPeopleNames = [];
    public $employeeDetails;
    public $showDialog = false;
    public $record;
    public function message($employeeId)
    {
        $authenticatedUserId = auth()->id();
        $userId= auth()->id();
    // $conversation= Chating::find(decrypt($id));
 
        // Check if conversation already exists
        $existingConversation = Chating::where(function ($query) use ($authenticatedUserId, $employeeId) {
            $query->where('sender_id', $authenticatedUserId)
                ->where('receiver_id', $employeeId);
        })->orWhere(function ($query) use ($authenticatedUserId, $employeeId) {
            $query->where('sender_id', $employeeId)
                ->where('receiver_id', $authenticatedUserId);
        })->first();
 
        if ($existingConversation) {
            // Conversation already exists, redirect to existing conversation
            return redirect()->route('chat', ['query' => $existingConversation->id]);
        }
 
        // Create new conversation
        $createdConversation = Chating::create([
            'sender_id' => $authenticatedUserId,
            'receiver_id' => $employeeId,
        ]);
 
        // Redirect to the chat component with the newly created conversation's ID
        return redirect()->route('chat', ['query' => $createdConversation->id]);
    }
    public function filter()
    {
        $companyId = Auth::user()->company_id;
   
        $trimmedSearchTerm = trim($this->searchTerm);
   
        $this->employeeDetails = EmployeeDetails::where('company_id', $companyId)
            ->where(function ($query) use ($trimmedSearchTerm) {
                $query->where('first_name', 'like', '%' . $trimmedSearchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $trimmedSearchTerm . '%')
                    ->orWhere('emp_id', 'like', '%' . $trimmedSearchTerm . '%');
            })
            ->get();
         
   
        $this->peopleFound = count($this->employeeDetails) > 0;
    }
   
 
    public function render()
    {
        $loggedInCompanyId = auth()->user()->company_id;
       
        // Fetching all employee details for the company
        $this->employeeDetails = EmployeeDetails::where('company_id', $loggedInCompanyId)->get();
       
        // Filter out the logged-in user
   // Filter out the logged-in user
// Filter out the logged-in user
$this->employeeDetails = $this->employeeDetails->reject(function ($employee) {
    return $employee->id == auth()->id() // Exclude by ID
        || $employee->emp_id == auth()->user()->emp_id // Exclude by emp_id
        || ($employee->first_name == auth()->user()->first_name && $employee->last_name == auth()->user()->last_name); // Exclude by first_name and last_name
});
 
        // Search functionality
        if ($this->searchTerm) {
            $this->filter();
        }
   
        return view('livewire.employee', [
            'employeeDetails' => $this->employeeDetails, // Change 'employees' to 'employeeDetails'
            'peopleData' => $this->filteredPeoples ? $this->filteredPeoples : $this->peoples,
        ]);
    }
}    
 