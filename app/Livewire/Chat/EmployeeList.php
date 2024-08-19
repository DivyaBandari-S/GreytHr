<?php
 
namespace App\Livewire\Chat;
 
use Livewire\Component;
use App\Models\Chating;
use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
// use Hashids;
// use Hashids\Hashids;
use Vinkla\Hashids\Facades\Hashids;
class EmployeeList extends Component
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
    public $selectedDepartment;
 
    public function message($employeeId)
    {
        // $hashids = new Hashids('default-salt', 50);
        $authenticatedUserId = auth()->id();
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
            //$ExistingConversationEncryptedId = Crypt::encryptString($existingConversation->id);
            $ExistingConversationEncryptedId = Hashids::encode($existingConversation->id);
            return redirect()->route('chat', ['query' => $ExistingConversationEncryptedId]);
        }
 
        // Create new conversation
        $createdConversation = Chating::create([
            'sender_id' => $authenticatedUserId,
            'receiver_id' => $employeeId,
        ]);
        // $encryptedId = Crypt::encryptString($createdConversation->id);
          $encryptedId = Hashids::encode($createdConversation->id);
        // Redirect to the chat component with the newly created conversation's ID
        return redirect()->route('chat', ['query' => $encryptedId]);
    }
    public function filter()
    {
        $companyId = Auth::user()->company_id;
        $trimmedSearchTerm = trim($this->searchTerm);
        $query = EmployeeDetails::select('employee_details.*', 'emp_departments.department')
        ->leftJoin('emp_departments', 'employee_details.dept_id', '=', 'emp_departments.dept_id')
        ->where('employee_details.company_id', $companyId);
 
    // Filter by selected department if one is selected
    if ($this->selectedDepartment) {
        $query->where('department', $this->selectedDepartment);
    }
 
    $this->employeeDetails = $query->where(function ($query) use ($trimmedSearchTerm) {
            $query->where('first_name', 'like', '%' . $trimmedSearchTerm . '%')
                ->orWhere('last_name', 'like', '%' . $trimmedSearchTerm . '%')
                ->orWhere('emp_id', 'like', '%' . $trimmedSearchTerm . '%');
        })
        ->orderBy('first_name', 'asc')->get();
      
        $this->peopleFound = $this->employeeDetails->isNotEmpty();
    }
 
 
 
    public function render()
    {
        $loggedInCompanyId = auth()->user()->company_id;
 
        // Fetching all employee details for the company
        $this->employeeDetails = EmployeeDetails::select('employee_details.*', 'emp_departments.department')
        ->leftJoin('emp_departments', 'employee_details.dept_id', '=', 'emp_departments.dept_id')
        ->where('employee_details.company_id', $loggedInCompanyId)
        ->orderBy('employee_details.first_name', 'asc')
        ->get();
 
    // Ensure every employee has department_name even if the department is missing
    $this->employeeDetails->each(function ($employee) {
        if (!$employee->department) {
            $employee->department = 'No Department';
        }
    });
        // Filter out the logged-in user
        $this->employeeDetails = $this->employeeDetails->reject(function ($employee) {
            return $employee->id == auth()->id() // Exclude by ID
                || $employee->emp_id == auth()->user()->emp_id // Exclude by emp_id
                || ($employee->first_name == auth()->user()->first_name && $employee->last_name == auth()->user()->last_name); // Exclude by first_name and last_name
        });
 
        // Search functionality
        if ($this->searchTerm || $this->selectedDepartment) {
            $this->filter();
        }
 
        return view('livewire.chat.employee-list', [
            'employeeDetails' => $this->employeeDetails, // Change 'employees' to 'employeeDetails'
            'peopleData' => $this->filteredPeoples ? $this->filteredPeoples : $this->peoples,
        ]);
}
 
}
 
