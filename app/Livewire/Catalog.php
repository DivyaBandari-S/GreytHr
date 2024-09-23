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
    public $selected_equipment;

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
     
        'mobile' => 'required|string|max:15',
        'description' => 'required|string',
        'mail' => 'required|email',
     
     'distributor_name'=>'required|string|max:15',
     'selected_equipment'=>'required',
        'file_path' => 'nullable|file|mimes:xls,csv,xlsx,pdf,jpeg,png,jpg,gif|max:40960',
    ];
  

    protected $messages = [
   'distributor_name' =>'Distributor name is required',
   'selected_equipment'=>'Selected Equipment is required ',
        'subject.required' => 'Subject  is required.',
        'mail.required' => ' Email  is required.',
        'mail.email' => ' Email must be a valid email address.',
        'mobile.required' => ' Mobile number is required.',
        'mobile.max' => ' Mobile number must not exceed 15 characters.',
        'description.required' => ' Description  is required.',
       

    ];
    public function mount()
{
    $this->selected_equipment = '';  // Initialize with a default value if needed
}

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function validateField($field)
    {
        if (in_array($field, ['mail', 'description', 'subject','category','selected_equipment','distributor_name','mobile'])) {
            $this->validateOnly($field, $this->rules);
        } 
    }
    public function resetDialogs() {
        // Close all dialogs
        $this->ItRequestaceessDialog = false;
        $this->AddRequestaceessDialog = false;
        $this->LapRequestaceessDialog = false;
        $this->DistributionRequestaceessDialog = false;
        $this->MailRequestaceessDialog = false;
        $this->DevopsRequestaceessDialog = false;
        $this->IdRequestaceessDialog = false;
        $this->MmsRequestaceessDialog = false;
        $this->DesktopRequestaceessDialog = false;
    }
    
    public function ItRequest()
    {
        $this->resetDialogs(); // Close other dialogs
        $this->ItRequestaceessDialog = true; 
        $this->showModal = true;
        $this->reset(['category']);
        $this->category = 'Request For IT';
    }
    
    public function AddRequest()
    {
        $this->resetDialogs(); // Close other dialogs
        $this->AddRequestaceessDialog = true; 
        $this->showModal = true;
        $this->reset(['category']);
        $this->category = 'Distribution List Request';
    }
    
    public function LapRequest()
    {
        $this->resetDialogs(); // Close other dialogs
        $this->LapRequestaceessDialog = true;
        $this->showModal = true;
        $this->reset(['category']);
        $this->category = 'Laptop Request';
    }
    
    public function DistributionRequest()
    {
        $this->resetDialogs(); // Close other dialogs
        $this->DistributionRequestaceessDialog = true; 
        $this->showModal = true;
        $this->reset(['category']);
        $this->category = 'New Distribution Request';
    }
    
    public function MailRequest()
    {
        $this->resetDialogs(); // Close other dialogs
        $this->MailRequestaceessDialog = true; 
        $this->showModal = true;
        $this->reset(['category']);
        $this->category = 'New Mailbox Request';
    }
    
    public function DevopsRequest()
    {
        $this->resetDialogs(); // Close other dialogs
        $this->DevopsRequestaceessDialog = true; 
        $this->showModal = true;
        $this->reset(['category']);
        $this->category = 'Devops Access Request';
    }
    
    public function IdRequest()
    {
        $this->resetDialogs(); // Close other dialogs
        $this->IdRequestaceessDialog = true; 
        $this->showModal = true;
        $this->reset(['category']);
        $this->category = 'New ID Card';
    }
    
    public function MmsRequest()
    {
        $this->resetDialogs(); // Close other dialogs
        $this->MmsRequestaceessDialog = true;
        $this->showModal = true;
        $this->reset(['category']);
        $this->category = 'MMS Request';
    }
    
    public function DesktopRequest()
    {
        $this->resetDialogs(); // Close other dialogs
        $this->DesktopRequestaceessDialog = true; 
        $this->showModal = true;
        $this->reset(['category']);
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
       
       
        $this->ItRequestaceessDialog = false;

        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation();
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment','cc_to','category','file_path','selectedPeople','selectedPeopleNames']);
       
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
  public function DistributorRequest()
{
    $messages = [
        'subject.required' => 'Business Justification is required',
        'distributor_name.required' => 'Distributor name is required',
        'description.required' => 'Specific Information is required',
    ];

    $this->validate([
        'distributor_name' => 'required|string',
        'subject' => 'required|string|max:255',
        'description' => 'required|string',
        'file_path' => 'nullable|file|mimes:xls,csv,xlsx,pdf,jpeg,png,jpg,gif|max:40960',
    ], $messages);

    try {
        $fileContent = null;
        $mimeType = null;
        $fileName = null;

        if ($this->file_path) {
            $fileContent = file_get_contents($this->file_path->getRealPath());
            if ($fileContent === false) {
                Log::error('Failed to read the uploaded file.', [
                    'file_path' => $this->file_path->getRealPath(),
                ]);
                session()->flash('error', 'Failed to read the uploaded file.');
                return;
            }

            if (strlen($fileContent) > 16777215) { // 16MB for MEDIUMBLOB
                session()->flash('error', 'File size exceeds the allowed limit.');
                return;
            }

            $mimeType = $this->file_path->getMimeType();
            $fileName = $this->file_path->getClientOriginalName();
        }

        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

        HelpDesks::create([
            'emp_id' => $this->employeeDetails->emp_id,
            'distributor_name' => $this->distributor_name,
            'subject' => $this->subject,
            'description' => $this->description,
            'file_path' => $fileContent,
            'file_name' => $fileName,
            'mime_type' => $mimeType,
            'cc_to' => $this->cc_to ?? '-',
            'category' => $this->category,
            'mail' => 'N/A',
            'mobile' => 'N/A',
        ]);

        session()->flash('message', 'Request created successfully.');
        $this->reset();
        return redirect()->to('/HelpDesk');
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Do not reset here, just set the error bag
        $this->setErrorBag($e->validator->getMessageBag());
    } catch (\Exception $e) {
        Log::error('Error creating request: ' . $e->getMessage(), [
            'employee_id' => $this->employeeDetails->emp_id,
            'category' => $this->category,
            'subject' => $this->subject,
            'description' => $this->description,
            'file_path_length' => isset($fileContent) ? strlen($fileContent) : null,
        ]);
        session()->flash('error', 'An error occurred while creating the request. Please try again.');
    }
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
            'mail' => 'required|email',
            'mobile' => 'required|string|max:15',
            'description' => 'required|string',
            'file_path' => 'nullable|file|mimes:xls,csv,xlsx,pdf,jpeg,png,jpg,gif|max:40960', // Adjust max size as needed
        ],$messages);
        try {
      
    // Store the file as binary data
     
    $fileContent=null;
    $mimeType = null;
    $fileName = null;
    if ($this->file_path) {
   
        $fileContent = file_get_contents($this->file_path->getRealPath());
        if ($fileContent === false) {
            Log::error('Failed to read the uploaded file.', [
                'file_path' => $this->file_path->getRealPath(),
            ]);
            session()->flash('error', 'Failed to read the uploaded file.');
            return;
        }

        // Check if the file content is too large
        if (strlen($fileContent) > 16777215) { // 16MB for MEDIUMBLOB
            session()->flash('error', 'File size exceeds the allowed limit.');
            return;
        }


        $mimeType = $this->file_path->getMimeType();
        $fileName = $this->file_path->getClientOriginalName();
    }
   
        $employeeId = auth()->guard('emp')->user()->emp_id;
        
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();


            HelpDesks::create([
                'emp_id' => $this->employeeDetails->emp_id,
                'distributor_name' => $this->distributor_name??'-',
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path' =>  $fileContent ,
                'file_name' => $fileName,
                'mime_type' => $mimeType,
                'cc_to' => $this->cc_to ?? '-',
                'category' => $this->category,
                'mail' => $this->mail,
                'mobile' => $this->mobile,
            ]);

            session()->flash('message', 'Request created successfully.');
            $this->reset();
            return redirect()->to('/HelpDesk');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
        } catch (\Exception $e) {
            Log::error('Error creating request: ' . $e->getMessage(), [
                'employee_id'=> $this->employeeDetails->emp_id,
                'category' => $this->category,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path_length' => isset($fileContent) ? strlen($fileContent) : null, // Log the length of the file content
            ]);
            session()->flash('error', 'An error occurred while creating the request. Please try again.');
        }
    }

    public function Request()
    {
        try {
            $messages=[
                'subject.required' => 'Business Justification is required',
            
                'description' => 'Specific Information is required',
                'mail.required' => ' Email  is required.',
                'mail.email' => ' Email must be a valid email address.',
               
            ];
            $this->validate([
                'subject' => 'required|string|max:255',
                'mail' => 'required|email',
                'description' => 'required|string',
                'file_path' => 'nullable|file|mimes:xls,csv,xlsx,pdf,jpeg,png,jpg,gif|max:40960', // Adjust max size as needed
              
            ],$messages);

    // Store the file as binary data
    $fileContent=null;
    $mimeType = null;
    $fileName = null;
    if ($this->file_path) {
    
    
        $fileContent = file_get_contents($this->file_path->getRealPath());
        if ($fileContent === false) {
            Log::error('Failed to read the uploaded file.', [
                'file_path' => $this->file_path->getRealPath(),
            ]);
            session()->flash('error', 'Failed to read the uploaded file.');
            return;
        }

        // Check if the file content is too large
        if (strlen($fileContent) > 16777215) { // 16MB for MEDIUMBLOB
            session()->flash('error', 'File size exceeds the allowed limit.');
            return;
        }


        $mimeType = $this->file_path->getMimeType();
        $fileName = $this->file_path->getClientOriginalName();
    }
   
        $employeeId = auth()->guard('emp')->user()->emp_id;
        
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();


            HelpDesks::create([
                'emp_id' => $this->employeeDetails->emp_id,
                'mail' => $this->mail,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path' =>  $fileContent ,
                'file_name' => $fileName,
                'mime_type' => $mimeType,
                'cc_to' => $this->cc_to ?? '-',
                'category' => $this->category,
                'mobile' => 'N/A',
                'distributor_name' => 'N/A',
            ]);

            session()->flash('message', 'Request created successfully.');
            $this->reset();
            return redirect()->to('/HelpDesk');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
        } catch (\Exception $e) {
            Log::error('Error creating request: ' . $e->getMessage(), [
                'employee_id' => $this->employeeDetails->emp_id,
                'category' => $this->category,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path_length' => isset($fileContent) ? strlen($fileContent) : null, // Log the length of the file content
            ]);
            session()->flash('error', 'An error occurred while creating the request. Please try again.');
        }
    }

    public function submit()
    {
        try {
            $messages=[
                'subject' =>'Business Justification is required',
                'description'=>'Specific Information is required',
                  'selected_equipment'=>'Selected equipment is required'
             ];
             $this->validate([
                 'subject' => 'required|string',
                 'description' => 'required|string',
                 'selected_equipment' => 'required|in:keyboard,mouse,headset,monitor',
                 'file_path' => 'nullable|file|mimes:xls,csv,xlsx,pdf,jpeg,png,jpg,gif|max:40960',
             ],$messages);
     

             $fileContent=null;
             $mimeType = null;
             $fileName = null;
    // Store the file as binary data
    if ($this->file_path) {
    
        $fileContent = file_get_contents($this->file_path->getRealPath());
        if ($fileContent === false) {
            Log::error('Failed to read the uploaded file.', [
                'file_path' => $this->file_path->getRealPath(),
            ]);
            session()->flash('error', 'Failed to read the uploaded file.');
            return;
        }

        // Check if the file content is too large
        if (strlen($fileContent) > 16777215) { // 16MB for MEDIUMBLOB
            session()->flash('error', 'File size exceeds the allowed limit.');
            return;
        }


        $mimeType = $this->file_path->getMimeType();
        $fileName = $this->file_path->getClientOriginalName();
    }
   
        $employeeId = auth()->guard('emp')->user()->emp_id;
        
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();



        HelpDesks::create([
            'emp_id' => $this->employeeDetails->emp_id,
            'subject' => $this->subject,
            'description' => $this->description,
            'selected_equipment' => $this->selected_equipment, // Ensure this is correctly referenced
            'file_path' => $fileContent,
            'file_name' => $fileName ,
            'mime_type' => $mimeType,
            'cc_to' => $this->cc_to ?? '-',
            'category' => $this->category ?? '-',
            'mail' => 'N/A',
            'mobile' => 'N/A',
            'distributor_name' => 'N/A',
        ]);

            session()->flash('message', 'Request created successfully.');
            $this->reset();
            return redirect()->to('/HelpDesk');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
        } catch (\Exception $e) {
            Log::error('Error creating request: ' . $e->getMessage(), [
                'employee_id' => $this->employeeDetails->emp_id,
                'category' => $this->category,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path_length' => isset($fileContent) ? strlen($fileContent) : null, // Log the length of the file content
            ]);
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
        $this->showModal = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment','cc_to','category','file_path','distributor_name','selectedPeopleNames','image','selectedPeople', 
        'selectedPeople' ,]);
      
    

 
      
       
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