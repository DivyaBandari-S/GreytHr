<?php
 
namespace App\Livewire;
 
use App\Models\HelpDesks;
use Livewire\Component;
 
use App\Models\Delegate;
use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Features\SupportFileUploads\WithFileUploads;
class Delegates extends Component
{
    use WithFileUploads;
    protected $debug = true;
   
    public $searchTerm = '';
    public $workflow;
    public $fromDate;
    public $toDate;
    public $delegate;
   
    public $employeeDetails;
    public $isNames = false;
    public $record;
  public $mail;
    public $subject;
    public $distributor_name;
    public $description;
 
    public $priority;
    public $activeTab = 'active';
    public $image;
 
    public $selectedPerson = null;
    public $cc_to;
    public $peoples;
    public $filteredPeoples;
    public $selectedPeopleNames = [];
    public $selectedPeople=[];
    public $records;
    public $peopleFound = true;
    public $isRotated = false;

   
    public $file_path;
    public $retrievedData = [];

 
    protected $rules = [
     
        'workflow' => 'required',
        'fromDate' => 'required|date',
        'toDate' => 'required|date|after_or_equal:fromDate',
        'delegate' => 'required',
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function filter()
    {
        $companyId = Auth::user()->company_id;
   
        $trimmedSearchTerm = trim($this->searchTerm);
   
        $this->filteredPeoples = EmployeeDetails::where('company_id', $companyId)
            ->where(function ($query) use ($trimmedSearchTerm) {
                $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $trimmedSearchTerm . '%')
                    ->orWhere('emp_id', 'like', '%' . $trimmedSearchTerm . '%');
            })
            ->get();
   
        $this->peopleFound = count($this->filteredPeoples) > 0;
    }
   
  
    public function closePeoples()
{
 
    $this->isRotated = false;
    
}
    public function NamesSearch()
    {
        $this->isNames = true;
   
       
        $this->selectedPeopleNames = [];
        $this->delegate = '';
     
    }
    public function toggleRotation()
    {
        $this->isRotated = true;

        $this->selectedPeopleNames = [];
        $this->delegate = '';
    }
   
    public function selectPerson($personId)
    {
       
    
        $selectedPerson = $this->peoples->where('emp_id', $personId)->first();

        if ($selectedPerson) {
            if (in_array($personId, $this->selectedPeople)) {
                $this->selectedPeopleNames[] = ucwords(strtolower($selectedPerson->first_name)) . ' ' . ucwords(strtolower($selectedPerson->last_name)) . ' #(' . $selectedPerson->emp_id . ')';
            } else {
                $this->selectedPeopleNames = array_diff($this->selectedPeopleNames, [ucwords(strtolower($selectedPerson->first_name)) . ' ' . ucwords(strtolower($selectedPerson->last_name)) . ' #(' . $selectedPerson->emp_id . ')']);
            }
            $this->delegate = implode(', ', array_unique($this->selectedPeopleNames));
        }
    }


    public function updatedSelectedPeople()
    {
        $this->selectedPeopleNames = [];
        foreach ($this->selectedPeople as $personId) {
            $selectedPerson = $this->peoples->where('emp_id', $personId)->first();
            if ($selectedPerson) {
                $this->selectedPeopleNames[] = ucwords(strtolower($selectedPerson->first_name)) . ' ' . ucwords(strtolower($selectedPerson->last_name)) . ' #(' . $selectedPerson->emp_id . ')';
            }
        }
        sort($this->selectedPeopleNames);
        $this->delegate = implode(', ', array_unique($this->selectedPeopleNames));
    }
 
    public function submitForm()
{
 
     
        $this->validate($this->rules);
 
        // Use the correct property name to get the authenticated user's ID
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->retrievedData = Delegate::where('emp_id', $employeeId)->first();
 
 
        // Create a new record in the database
        Delegate::create([
            'emp_id' => $employeeId,
            'workflow' => $this->workflow,
            'from_date' => $this->fromDate,
            'to_date' => $this->toDate,
            'delegate' => $this->delegate,
        ]);
 
 
        // Clear the form inputs
        $this->resetForm();
        return redirect()->to('/delegates');
 
 
        // Optionally, redirect to a success page
     
    }
 
   
    private function resetForm()
    {
        $this->workflow = ''; // Reset workflow
        $this->fromDate = ''; // Reset from date
        $this->toDate = '';   // Reset to date
        $this->delegate = ''; // Reset delegate
        $this->selectedPeople = []; // Reset selected people
    }
 
    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
    
        // Fetch records where emp_id or delegate contains the logged-in user's emp_id
        $this->retrievedData = Delegate::where(function ($query) use ($employeeId) {
            $query->where('emp_id', $employeeId)
                  ->orWhere('delegate', 'like', "%$employeeId%");
        })->orderBy('created_at', 'desc')->get();
    
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->get();
        $companyId = auth()->guard('emp')->user()->company_id;
        $this->peoples = EmployeeDetails::where('company_id', $companyId)->get();
        $peopleData = $this->filteredPeoples ? $this->filteredPeoples : $this->peoples;
        $peopleData = $peopleData->sortBy(function ($person) {
            return strtolower($person->first_name);
        });
        $this->record = Delegate::all();
        
        return view('livewire.delegates', [
            'employees' => $this->employeeDetails,
            'retrievedData' => $this->retrievedData,
            'peopleData' => $peopleData,
            'records' => $this->records
        ]);
    }
}    