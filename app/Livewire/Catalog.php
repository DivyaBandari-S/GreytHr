<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EmployeeDetails;
use App\Models\PeopleList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Models\HelpDesks;
use Livewire\WithFileUploads;

class Catalog extends Component
{

    use WithFileUploads;
    public $searchTerm = '';
    public $selected_equipment;
    public $ItRequestaceessDialog=false;
  public $closeItRequestaccess =false;
  public $openItRequestaccess=false;
  public $isNames = false;
  public $record;

  public $subject;
  public $description;

  public $priority;
  public $activeTab = 'active';
  public $image;
  public $employeeDetails;
  
  public $selectedPerson = null;
  public $cc_to;
  public $peoples;
  public $filteredPeoples;
  public $selectedPeopleNames = [];
  public $selectedPeople=[];
  public $records;
  public $peopleFound = true;
 
  public $file_path;

 
  public $justification;
  public $information;
  public function ItRequest() {
    $this->ItRequestaceessDialog = true; // Open the Medical (Sec 80D) modal
}
public function openItRequestaccess()
{
$this->ItRequestaceessDialog = true; // Open the Sec 80C modal
}
public function closeItRequestaccess()
{
    $this->ItRequestaceessDialog = false; // Open the Sec 80C modal
}
public function closePeoples()
{
    $this->isNames = false;
}
protected function resetInputFields()
{
    $this->subject = '';
    $this->description = '';
    $this->file_path = '';
    $this->cc_to = '';
  
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

public function updatedSelectedPeople()
{
    $this->cc_to = implode(', ', array_unique($this->selectedPeopleNames));
}
public function NamesSearch()
{
    $this->isNames = true;

   
    $this->selectedPeopleNames = [];
    $this->cc_to = '';
  
}
public function submit()
{
   
    $this->validate([
     
        'subject' => 'required|string|max:255',
        'description' => 'required|string',
        'file_path' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx,txt,ppt,pptx,gif,jpg,jpeg,png|max:2048',
        'cc_to' => 'required',
        'selected_equipment' => 'required|in:keyboard,mouse,headset,monitor',
       
        'image' => 'image|max:2048',
    ]);
    if ($this->image) {
        $fileName = uniqid() . '_' . $this->image->getClientOriginalName();

        $this->image->storeAs('public/help-desk-images', $fileName);

        $this->image = 'help-desk-images/' . $fileName;
    }
    $employeeId = auth()->guard('emp')->user()->emp_id;
    $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

    HelpDesks::create([
        'emp_id' => $this->employeeDetails->emp_id,
        'subject' => $this->subject,
        'description' => $this->description,
        'file_path' => $this->image,
        'cc_to' => $this->cc_to,
        'selected_equipment' =>$this->selected_equipment,
       
    ]);


    $this->reset();
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
        $this->cc_to = implode(', ', array_unique($this->selectedPeopleNames));
    }
}

    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $companyId = auth()->guard('emp')->user()->company_id;
        $this->peoples = EmployeeDetails::where('company_id', $companyId)->get();
        $peopleData = $this->filteredPeoples ? $this->filteredPeoples : $this->peoples;
        $this->record = HelpDesks::all();
        $employeeName = auth()->guard('emp')->user()->first_name . ' #(' . $employeeId . ')';

        $this->records = HelpDesks::with('emp')
            ->where(function ($query) use ($employeeId, $employeeName) {
                $query->where('emp_id', $employeeId)
                    ->orWhere('cc_to', 'LIKE', "%$employeeName%");
            })
            ->orderBy('created_at', 'desc')
            ->get();
            $records = HelpDesks::all();
        return view('livewire.catalog', [
            'peopleData' => $peopleData,'records' => $records
        ]);
    }
}
