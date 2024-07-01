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
    public $mobile;
    public $showModal = true;
    public $selected_equipment;
    public $ItRequestaceessDialog = false;
    public $MailRequestaceessDialog = false;
    public $closeMailRequestaccess = false;
    public $openMailRequestaccess = false;
    public $closeItRequestaccess = false;
    public $openItRequestaccess = false;
    public $closeDevopsRequestaccess = false;
    public $openDevopsRequestaccess = false;

    public $isNames = false;
    public $record;
    public $mail;
    public $subject;
    public $distributor_name;
    public $description;

    public $priority;
    public $activeTab = 'active';
    public $image;
    public $employeeDetails;

    public $selectedPerson = null;
    public $cc_to;
    public $peoples;
    public $category;
    public $filteredPeoples;
    public $selectedPeopleNames = [];
    public $selectedPeople = [];
    public $records;
    public $peopleFound = true;

    public $file_path;
    public $DevopsRequestaceessDialog = false;

    public $closeMmsRequestaccess = false;
    public $openMmsRequestaccess = false;
    public $DistributionRequestaceessDialog = false;
    public $closeDistributionRequestaccess = false;
    public $openDistributionRequestaccess = false;
    public $closeAddRequestaccess = false;
    public $openAddRequestaccess = false;
    public $DesktopRequestaceessDialog = false;

    public $closeDesktopRequestaccess = false;
    public $openDesktopRequestaccess = false;
    public $IdRequestaceessDialog = false;
    public $MmsRequestaceessDialog = false;
    public $LapRequestaceessDialog = false;
    public $AddRequestaceessDialog = false;
    public $justification;
    public $information;
    public function ItRequest()
    {
        $this->ItRequestaceessDialog = true; // Open the Medical (Sec 80D) modal
        $this->showModal = true;
        $this->reset(['category']);
        $this->category = ' Request For IT';
    }
    public function AddRequest()
    {

        $this->AddRequestaceessDialog = true; // Open the Medical (Sec 80D) modal
        $this->showModal = true;
        $this->reset(['category']);
        $this->category = 'Distribution List Request';
    }
    public function LapRequest()
    {
        $this->reset(['category']);
        $this->showModal = true;

        $this->category = 'New Laptop';
        $this->LapRequestaceessDialog = true;
    }
    public function DistributionRequest()
    {
        $this->DistributionRequestaceessDialog = true; // Open the Medical (Sec 80D) modal
        $this->reset(['category']);
        $this->showModal = true;

        $this->category = 'New Distribution Request';
    }
    public function MailRequest()
    {
        $this->MailRequestaceessDialog = true; // Open the Medical (Sec 80D) modal
        $this->reset(['category']);
        $this->showModal = true;

        $this->category = 'New Mailbox Request';
    }
    public function DevopsRequest()
    {
        $this->DevopsRequestaceessDialog = true; // Open the Medical (Sec 80D) modal

        $this->reset(['category']);
        $this->showModal = true;

        $this->category = 'Devops Access Request';
    }
    public function IdRequest()
    {
        $this->IdRequestaceessDialog = true; // Open the Medical (Sec 80D) modal
        $this->reset(['category']);
        $this->showModal = true;

        $this->category = 'New ID Card';
    }
    public function MmsRequest()
    {
        $this->MmsRequestaceessDialog = true; // Open the Medical (Sec 80D) modal
        $this->reset(['category']);
        $this->showModal = true;

        $this->category = 'MMS Request';
    }


    public function DesktopRequest()
    {
        $this->DesktopRequestaceessDialog = true; // Open the Medical (Sec 80D) modal
        $this->reset(['category']);
        $this->showModal = true;

        $this->category = 'Desktop Request';
    }
    public function openItRequestaccess()
    {
        $this->ItRequestaceessDialog = true; // Open the Sec 80C modal
    }
    public function openAddRequestaccess()
    {
        $this->AddRequestaceessDialog = true; // Open the Sec 80C modal
    }
    public function openLapRequestaccess()
    {
        $this->LapRequestaceessDialog = true; // Open the Sec 80C modal
    }


    public function openDevopsRequestaccess()
    {
        $this->DevopsRequestaceessDialog = true; // Open the Sec 80C modal
    }
    public function openIdRequestaccess()
    {
        $this->IdRequestaceessDialog = true; // Open the Sec 80C modal
    }
    public function openMailRequestaccess()
    {
        $this->MailRequestaceessDialog = true; // Open the Sec 80C modal
    }
    public function openMMSRequestaccess()
    {
        $this->MmsRequestaceessDialog = true; // Open the Sec 80C modal
    }
    public function openDesktopRequestaccess()
    {
        $this->DesktopRequestaceessDialog = true;
    }
    public function openDistributionRequestaccess()
    {
        $this->DistributionRequestaceessDialog = true;
    }
    public function closeMMSRequestaccess()
    {
        $this->MmsRequestaceessDialog = false; // Open the Sec 80C modal
    }
    public function closeItRequestaccess()
    {
        $this->ItRequestaceessDialog = false; // Open the Sec 80C modal
    }
    public function closeAddRequestaccess()
    {
        $this->AddRequestaceessDialog = false; // Open the Sec 80C modal
    }
    public function closeDesktopRequestaccess()
    {
        $this->DesktopRequestaceessDialog = false; // Open the Sec 80C modal
    }
    public function closeDistributionRequestaccess()
    {
        $this->DistributionRequestaceessDialog = false; // Open the Sec 80C modal
    }
    public function closeDevopsRequestaccess()
    {
        $this->DevopsRequestaceessDialog = false; // Open the Sec 80C modal
    }
    public function closeLapRequestaccess()
    {
        $this->LapRequestaceessDialog = false; // Open the Sec 80C modal
    }
    public function closeIdRequestaccess()
    {
        $this->IdRequestaceessDialog = false; // Open the Sec 80C modal
    }
    public function closeMailRequestaccess()
    {
        $this->MailRequestaceessDialog = false; // Open the Sec 80C modal
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


    public function selectPerson($personId)
    {
        $selectedPerson = $this->peoples->where('emp_id', $personId)->first();

        if ($selectedPerson) {
            if (in_array($personId, $this->selectedPeople)) {
                $this->selectedPeopleNames[] = $selectedPerson->first_name . $selectedPerson->last_name . ' #(' . $selectedPerson->emp_id . ')';
            } else {
                $this->selectedPeopleNames = array_diff($this->selectedPeopleNames, [$selectedPerson->first_name . $selectedPerson->last_name . ' #(' . $selectedPerson->emp_id . ')']);
            }
            $this->cc_to = implode(', ', array_unique($this->selectedPeopleNames));
        }
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


    public function Devops()
    {

        $this->validate([

            'subject' => 'required|string|max:255',
            'mail' => 'required|email|unique:help_desks',
            'mobile' => 'required|string|max:15',
            'description' => 'required|string',
            'file_path' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx,txt,ppt,pptx,gif,jpg,jpeg,png|max:2048',
            'cc_to' => 'required',
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
            'mail' => $this->mail,
            'mobile' => $this->mobile,
            'subject' => $this->subject,
            'description' => $this->description,
            'file_path' => $this->image,
            'cc_to' => $this->cc_to,
            'category' => $this->category,
            'distributor_name' => 'N/A',

        ]);

        session()->flash('message', ' Request created successfully.');

        $this->reset();
    }


    public function Request()
    {

        $this->validate([

            'subject' => 'required|string|max:255',
            'mail' => 'required|email|unique:help_desks',
            'description' => 'required|string',
            'file_path' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx,txt,ppt,pptx,gif,jpg,jpeg,png|max:2048',
            'cc_to' => 'required',


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
            'mail' => $this->mail,
            'subject' => $this->subject,
            'description' => $this->description,
            'file_path' => $this->image,
            'cc_to' => $this->cc_to,
            'category' => $this->category,
            'mobile' => 'N/A',
            'distributor_name' => 'N/A',

        ]);

        session()->flash('message', 'Request created successfully.');
        $this->reset();
    }


    public function DistributorRequest()
    {

        $this->validate([

            'distributor_name' => 'required',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'file_path' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx,txt,ppt,pptx,gif,jpg,jpeg,png|max:2048',
            'cc_to' => 'required',


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
            'distributor_name' => $this->distributor_name,
            'subject' => $this->subject,
            'description' => $this->description,
            'file_path' => $this->image,
            'cc_to' => $this->cc_to,
            'category' => $this->category,
            'mail' => 'N/A',
            'mobile' => 'N/A',
        ]);
        session()->flash('message', 'Request created successfully.');


        $this->reset();
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
            'selected_equipment' => $this->selected_equipment,
            'category' => $this->category,
            'mail' => 'N/A',
            'mobile' => 'N/A',
            'distributor_name' => 'N/A',
        ]);

        session()->flash('message', 'Request for IT Accessories created successfully.');
        $this->reset();
    }


    protected $listeners = ['closeModal'];

    public function closeModal()
    {
        // Handle modal closing logic here
        $this->showModal = false;
    }
    public function closecatalog()
    {
        $this->showModal = false;
    }


    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $companyId = auth()->guard('emp')->user()->company_id;
        $this->peoples = EmployeeDetails::where('company_id', $companyId)->get();
        $peopleData = $this->filteredPeoples ? $this->filteredPeoples : $this->peoples;
        $this->record = HelpDesks::all();
        $employee = auth()->guard('emp')->user();
        $employeeId = $employee->emp_id;
        $employeeName = $employee->first_name . ' ' . $employee->last_name . ' #(' . $employeeId . ')';


        $this->records = HelpDesks::with('emp')
            ->where(function ($query) use ($employeeId, $employeeName) {
                $query->where('emp_id', $employeeId)
                    ->orWhere('cc_to', 'LIKE', "%$employeeName%");
            })
            ->orderBy('created_at', 'desc')
            ->get();
        $records = HelpDesks::all();
        return view('livewire.catalog', [
            'peopleData' => $peopleData, 'records' => $records
        ]);
    }
}
