<?php
// File Name                       : Catalog.php
// Description                     : This file contains the information about various IT requests related to the catalog. 
//                                   It includes functionality for adding members to distribution lists and mailboxes, requesting IT accessories, 
//                                   new ID cards, MMS accounts, new distribution lists, laptops, new mailboxes, and DevOps access. 
// Creator                         : Ashannagari Archana
// Email                           : archanaashannagari@gmail.com
// Organization                    : PayG.
// Date                            : 2023-09-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : HelpDesk,EmployeeDetails

namespace App\Livewire;

use Livewire\Component;
use App\Models\EmployeeDetails;
use App\Models\PeopleList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Models\HelpDesks;
use Illuminate\Support\Facades\Log;
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
    public $attachment;

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
    protected $rules = [
        'subject' => 'required|string|max:255',
        'mail' => 'required|email|unique:help_desks',
        'mobile' => 'required|string|max:15',
        'description' => 'required|string',
        'mail' => 'required|email|unique:help_desks',
        'mobile' => 'required|string|max:15',
        'selected_equipment' => 'required|in:keyboard,mouse,headset,monitor',

    ];
    protected $messages = [
        'distributor_name' => 'Distributor name  is required.',
        'subject.required' => 'Subject  is required.',
        'mail.required' => ' Email  is required.',
        'mail.email' => ' Email must be a valid email address.',
        'mobile.required' => ' Mobile number is required.',
        'mobile.max' => ' Mobile number must not exceed 15 characters.',
        'description.required' => ' Description  is required.',
        'selected_equipment.required' => 'You must select at least one equipment.',

    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
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

    public function closeItRequestaccess()
    {
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment','cc_to','category','file_path','selectedPeople','selectedPeopleNames']);
        $this->ItRequestaceessDialog = false;
    }

    public function closeAddRequestaccess()
    {
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment','cc_to','category','file_path','selectedPeople','selectedPeopleNames']);
        $this->AddRequestaceessDialog = false;
    }
    
    public function closeDesktopRequestaccess()
    {
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment','cc_to','category','file_path','selectedPeople','selectedPeopleNames']);
        $this->DesktopRequestaceessDialog = false;
    }
    
    public function closeDistributionRequestaccess()
    {
 
        $this->DistributionRequestaceessDialog = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment','cc_to','category','file_path','distributor_name','selectedPeople','selectedPeopleNames']);
    }
    
    public function closeDevopsRequestaccess()
    {
       
        $this->DevopsRequestaceessDialog = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment','cc_to','category','file_path','distributor_name','selectedPeople','selectedPeopleNames']);
    }
    
    public function closeLapRequestaccess()
    {
        $this->reset();
        $this->LapRequestaceessDialog = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment','cc_to','category','file_path','distributor_name','selectedPeople','selectedPeopleNames']);
    }
    
    public function closeIdRequestaccess()
    {
      
        $this->IdRequestaceessDialog = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment','cc_to','category','file_path','distributor_name','selectedPeople','selectedPeopleNames']);
    }
    
    public function closeMailRequestaccess()
    {
      
        $this->MailRequestaceessDialog = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment','cc_to','category','file_path','distributor_name','selectedPeople','selectedPeopleNames']);
    }
    
    public function closeMMSRequestaccess()
    {
     
        $this->MmsRequestaceessDialog = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment','cc_to','category','file_path','distributor_name','selectedPeople','selectedPeopleNames']);
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
        try {
            $selectedPerson = $this->peoples->where('emp_id', $personId)->first();

            if ($selectedPerson) {
                if (in_array($personId, $this->selectedPeople)) {
                    $this->selectedPeopleNames[] =  ucwords(strtolower($selectedPerson->first_name)) . ' ' . ucwords(strtolower($selectedPerson->last_name)) . ' #(' . $selectedPerson->emp_id . ')';
                } else {
                    $this->selectedPeopleNames = array_diff($this->selectedPeopleNames, [ucwords(strtolower($selectedPerson->first_name)) . ' ' . ucwords(strtolower($selectedPerson->last_name)) . ' #(' . $selectedPerson->emp_id . ')']);
                }
                $this->cc_to = implode(', ', array_unique($this->selectedPeopleNames));
            }
        } catch (\Exception $e) {
            // Log the exception message or handle it as needed
            Log::error('Error selecting person: ' . $e->getMessage());
            // Optionally, you can set an error message to display to the user
            $this->dispatchBrowserEvent('error', ['message' => 'An error occurred while selecting the person. Please try again.']);
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
        $messages = [
            'subject.required' => 'Business Justification is required',
            'distributor_name.required' => 'Distributor name is required',
            'description' => 'Specific Information is required',
            'mail.required' => ' Email  is required.',
            'mail.email' => ' Email must be a valid email address.',
            'mobile' =>'Mobile number is required'
        ];
        $this->validate([
            'subject' => 'required|string|max:255',
            'mail' => 'required|email|unique:help_desks',
            'mobile' => 'required|string|max:15',
            'description' => 'required|string',
        ],$messages);

        try {


            if ($this->image) {
                $fileName = uniqid() . '_' . $this->image->getClientOriginalName();
                $this->image->storeAs('uploads/help-desk-images', $fileName, 'public');
                $filePath = 'uploads/help-desk-images/' . $fileName;
            } else {
                $filePath = 'N/A';
            }
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

            HelpDesks::create([
                'emp_id' => $this->employeeDetails->emp_id,
                'mail' => $this->mail,
                'mobile' => $this->mobile,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path' => $filePath ?? '-',
                'cc_to' => $this->cc_to ?? '-',
                'category' => $this->category,
                'distributor_name' => 'N/A',
            ]);

            session()->flash('message', 'Request created successfully.');
            $this->reset();
            return redirect()->to('/HelpDesk');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
        } catch (\Exception $e) {
            Log::error('Error creating request: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while creating the request. Please try again.');
        }
    }

    public function Request()
    {

        $messages=[
            'subject.required' => 'Business Justification is required',
        
            'description' => 'Specific Information is required',
            'mail.required' => ' Email  is required.',
            'mail.email' => ' Email must be a valid email address.',
           
        ];
        $this->validate([
            'subject' => 'required|string|max:255',
            'mail' => 'required|email|unique:help_desks',
            'description' => 'required|string',
          
        ],$messages);
      
        try {


            if ($this->image) {
                $fileName = uniqid() . '_' . $this->image->getClientOriginalName();
                $this->image->storeAs('uploads/help-desk-images', $fileName, 'public');
                $filePath = 'uploads/help-desk-images/' . $fileName;
            } else {
                $filePath = 'N/A';
            }

            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

            HelpDesks::create([
                'emp_id' => $this->employeeDetails->emp_id,
                'mail' => $this->mail,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path' => $filePath,
                'cc_to' => $this->cc_to ?? '-',
                'category' => $this->category,
                'mobile' => 'N/A',
                'distributor_name' => 'N/A',
            ]);
     

            session()->flash('message', 'Request created successfully.');
            $this->reset();
            return redirect()->to('/HelpDesk');
        } catch (\Exception $e) {
            Log::error('Error creating request: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while creating the request. Please try again.');
        }
    }

    public function DistributorRequest()
    {
        $messages = [
            'subject.required' => 'Business Justification is required',
            'distributor_name' => 'Distributor name is required',
            'description' => 'Specific Information is required',
           
        ];

        $this->validate([
            'distributor_name' => 'required|string',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
          
        ],$messages);
        try {


            if ($this->image) {
                $fileName = uniqid() . '_' . $this->image->getClientOriginalName();
                $this->image->storeAs('uploads/help-desk-images', $fileName, 'public');
                $filePath = 'uploads/help-desk-images/' . $fileName;
            } else {
                $filePath = 'N/A';
            }

            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

            HelpDesks::create([
                'emp_id' => $this->employeeDetails->emp_id,
                'distributor_name' => $this->distributor_name,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path' => $filePath,
                'cc_to' => $this->cc_to ?? '-',
                'category' => $this->category,
                'mail' => 'N/A',
                'mobile' => 'N/A',
            ]);

            session()->flash('message', 'Request created successfully.');
            $this->reset();
            return redirect()->to('/HelpDesk');
        } catch (\Exception $e) {
            Log::error('Error creating request: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while creating the request. Please try again.');
        }
    }


    public function submit()
    {
        // Validate the input data
        $messages=[
           'subject' =>'Business Justification is required',
           'description'=>'Specific Information is required',
             'selected_equipment'=>'Selected equipment is required'
        ];
        $this->validate([
            'subject' => 'required|string',
            'description' => 'required|string',
            'selected_equipment' => 'required|in:keyboard,mouse,headset,monitor',
        ],$messages);

        try {
     
            // Handle file upload
            if ($this->image) {
                $fileName = uniqid() . '_' . $this->image->getClientOriginalName();
                $this->image->storeAs('uploads/help-desk-images', $fileName, 'public');
                $filePath = 'uploads/help-desk-images/' . $fileName;
            } else {
                $filePath = 'N/A';
            }

            // Get the employee details
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

            // Create the HelpDesk request

         
            HelpDesks::create([
                'emp_id' => $this->employeeDetails->emp_id,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path' => $filePath,
                'cc_to' => $this->cc_to ?? '-',
               
                'category' => $this->category ?? '-',
                'mail' => 'N/A',
                'mobile' => 'N/A',
                'distributor_name' => 'N/A',
            ]);

            // Log after successful creation
            Log::info('HelpDesk request created successfully.');

            session()->flash('message', 'Request for IT Accessories created successfully.');

          
          
         
            // Reset the form fields
            $this->reset();
            return redirect()->to('/HelpDesk');
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error creating IT Accessories request: ' . $e->getMessage());

            // Flash error message
            session()->flash('error', 'An error occurred while creating the request. Please try again.');
        }
    }



    protected $listeners = ['closeModal'];

    public function closeModal()
    {
        // Handle modal closing logic here
        $this->showModal = false;
    }
   
    public function closecatalog()
    {
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment','cc_to','category','file_path','distributor_name','selectedPeopleNames','image','selectedPeople', 
        'selectedPeople' ,]);
      
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
