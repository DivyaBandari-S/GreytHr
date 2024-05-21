<?php
 
namespace App\Livewire;
 
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
    public $retrievedData;
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
   
    public $file_path;
 
    protected $rules = [
     
        'workflow' => 'required',
        'fromDate' => 'required|date',
        'toDate' => 'required|date|after_or_equal:fromDate',
        'delegate' => 'required',
    ];
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
   
    public function updatedSelectedPeople()
    {
        $this->delegate = implode(', ', array_unique($this->selectedPeopleNames));
    }
    public function closePeoples()
{
    $this->isNames = false;
}
    public function NamesSearch()
    {
        $this->isNames = true;
   
       
        $this->selectedPeopleNames = [];
        $this->delegate = '';
     
    }
    public function selectPerson($personId)
{
    $selectedPerson = $this->peoples->where('emp_id', $personId)->first();
 
    if ($selectedPerson) {
        if (in_array($personId, $this->selectedPeople)) {
            $this->selectedPeopleNames[] = $selectedPerson->first_name . ' #(' . $selectedPerson->emp_id . ')';
        } else {
            $this->selectedPeopleNames = array_diff($this->selectedPeopleNames, [$selectedPerson->first_name . ' #(' . $selectedPerson->emp_id . ')']);
        }
        $this->delegate = implode(', ', array_unique($this->selectedPeopleNames));
    }
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
        $this->retrievedData = Delegate::all();
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->get();
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $companyId = auth()->guard('emp')->user()->company_id;
        $this->peoples = EmployeeDetails::where('company_id', $companyId)->get();
        $peopleData = $this->filteredPeoples ? $this->filteredPeoples : $this->peoples;
        $this->record = Delegate::all();
        $employeeName = auth()->guard('emp')->user()->first_name . ' #(' . $employeeId . ')';
 
        $this->records = Delegate::with('emp')
            ->where(function ($query) use ($employeeId, $employeeName) {
                $query->where('emp_id', $employeeId)
                    ->orWhere('delegate', 'LIKE', "%$employeeName%");
            })
            ->orderBy('created_at', 'desc')
            ->get();
            $records = Delegate::all();
   
        return view('livewire.delegates', [
            'employees' => $this->employeeDetails,
            'retrievedData' => $this->retrievedData, 'peopleData' => $peopleData,'records' => $records
        ]);
    }
}