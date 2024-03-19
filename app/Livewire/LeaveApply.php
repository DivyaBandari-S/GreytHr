<?php
// File Name                       : LeaveApply.php
// Description                     : This file contains the implementation of Applying for a leave
// Creator                         : Bandari Divya
// Email                           : bandaridivya1@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : LeaveRequest,EmployeeDetails.
namespace App\Livewire;

use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\LeaveRequest;
use App\Models\EmployeeDetails;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Mail\LeaveApplicationNotification;
use Illuminate\Support\Facades\Mail;

class LeaveApply extends Component
{
    use WithFileUploads, WithPagination;

    public $leave_type;
    public $emp_id;
    public $from_date;
    public $from_session;
    public $to_session;
    public $to_date;
    public $applying_to;
    public $contact_details;
    public $reason;
    public $reportTo;
    public $report_to;
    public $managerId;
    public $employeeId;
    public $file_paths;
     public $filePaths=[];
    public $defaultApplyingTo;
    public $cc_to ;
    public $searchTerm = '';
    public $selectedEmployeeNames = [];
    public $selectedPeople = [];
    public $selectedManager = [];
    public $first_name;
    public $employeeDetails = [];
    public $ccRecipients =[];
    public $applyingToDetails =[];
    public $files =[];
    public $filteredEmployees =[];
    public $has;
    public $isOpen = false;
    public $leaveDetails;
    private $createdLeaveRequest;
    private $dynamicFromAddress;
    public $items = [];
    public $selectedItems = [];
    public $managerFullName;
    public $loginEmpManagerId;
    public $loginEmpManager;


    public function mount()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->applying_to = EmployeeDetails::where('emp_id', $employeeId)->first();
        if ($this->applying_to) {

            $this->loginEmpManagerId = $this->applying_to->manager_id;

            // Retrieve the corresponding employee details for the manager
            $managerDetails = EmployeeDetails::where('emp_id', $this->loginEmpManagerId)->first();

            if ($managerDetails) {
                // Concatenate first_name and last_name to create the full name
                $fullName = ucfirst(strtolower($managerDetails->first_name)) . ' ' . ucfirst(strtolower($managerDetails->last_name));

                // Assign the full name to a property for later use
                $this->loginEmpManager = $fullName;
            } else {

                $this->loginEmpManager = $this->applying_to->report_to;
            }
        }
        $this->searchEmployees();
        $this->searchCCRecipients();
    }
    // Add this method to your Livewire component
    public function searchEmployees()
    {
        // Fetch employees based on the search term
        $this->employeeDetails = EmployeeDetails::where('company_id', $this->applying_to->company_id)
            ->where(function ($query) {
                $query->where('company_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('emp_id', 'like', '%' . $this->searchTerm . '%');
            })
            ->select('manager_id')
            ->groupBy('manager_id')
            ->distinct()
            ->get();

        $managers = [];
        foreach ($this->employeeDetails as $employee) {
            // Retrieve employee details based on manager_id
            $employeeDetails = EmployeeDetails::where('emp_id', $employee->manager_id)->first();

            // Check if employee details exist and concatenate first name and last name
            if ($employeeDetails) {
                $fullName = ucwords(strtolower($employeeDetails->first_name)) . ' ' . ucwords(strtolower($employeeDetails->last_name));
                $managers[] = [
                    'emp_id' => $employeeDetails->emp_id,
                    'full_name' => $fullName
                ];
            }
        }
        usort($managers, function($a, $b) {
            return strcmp($a['full_name'], $b['full_name']);
        });
        $this->managerFullName = $managers;
    }
    public function searchCCRecipients()
    {
        // Fetch employees based on the search term for CC To
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->ccRecipients = EmployeeDetails::where('company_id', $this->applying_to->company_id)
            ->where('emp_id', '!=', $employeeId) // Exclude the current user
            ->where(function ($query) {
                $query->where('company_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('emp_id', 'like', '%' . $this->searchTerm . '%');
            })
            ->groupBy('emp_id')
            ->select(
                'emp_id',
                DB::raw('MIN(CONCAT(first_name, " ", last_name)) as full_name')
            )
            ->orderBy('full_name')
            ->get();
    }
    public function filterCcData()
    {
        $this->searchCCRecipients();
    }
    public function filterData()
    {
        $this->searchEmployees();
    }
    //method to apply for a leave
    public function leaveApply(){
        $this->validate([
            'leave_type' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'from_session' => 'required',
            'to_session' => 'required',
            'reason' => 'required',
            'applying_to' => 'required',
            'files.*' => 'required|mimes:pdf,excel,png,jpg|max:2048',
            'contact_details' =>'required',
        ]);
    
        $filePaths = [];
    
        if (isset($this->files)) {
            foreach ($this->files as $file) {
                $fileName = uniqid() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/help-desk-files', $fileName);
                $filePaths[] = 'help-desk-files/' . $fileName;
            }
        }
    
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
      
        $ccToDetails = [];
        foreach ($this->selectedPeople as $selectedEmployeeId) {
            // Fetch additional details from EmployeeDetails table
            $employeeDetails = EmployeeDetails::where('emp_id', $selectedEmployeeId)->first();
    
            // Concatenate first_name and last_name to get the full name
            $fullName = $employeeDetails->first_name . ' ' . $employeeDetails->last_name;
    
            $ccToDetails[] = [
                'emp_id' => $selectedEmployeeId,
                'full_name' => $fullName,
            ];
    
        }
    
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $applyingToDetails = [];
        
        if (empty($this->selectedManager)) {
            // No manager is selected, use default values
            $applyingToDetails[] = [
                'manager_id' => $this->loginEmpManagerId,
                'report_to' => $this->loginEmpManager,
            ];
        } else {
            // Managers are selected, fetch details for each selected manager
            foreach ($this->selectedManager as $selectedManagerId) {
                $employeeDetails = EmployeeDetails::where('emp_id', $selectedManagerId)->first();
                if ($employeeDetails) {
                    $applyingToDetails[] = [
                        'manager_id' => $selectedManagerId,
                        'report_to' => $employeeDetails->report_to,
                    ];
                }
            }
        }
        $this->createdLeaveRequest = LeaveRequest::create([
            'emp_id' => $employeeId,
            'leave_type' => $this->leave_type,
            'from_date' => $this->from_date,
            'from_session' => $this->from_session,
            'to_session' => $this->to_session,
            'to_date' => $this->to_date,
            'applying_to' => json_encode($applyingToDetails),
            'file_paths' => json_encode($filePaths),
            'cc_to' => json_encode($ccToDetails),
            'contact_details' => $this->contact_details,
            'reason' => $this->reason,
        ]);

        logger('LeaveRequest created successfully', ['leave_request' => $this->createdLeaveRequest]);

        // Check if emp_id is set on the $createdLeaveRequest object
        if ($this->createdLeaveRequest && $this->createdLeaveRequest->emp_id) {
            // Reset the component
            $this->reset();
    
            session()->flash('message', 'Leave application submitted successfully!');
            return redirect()->to('/leave-page');
        } else {
            // Log an error if there's an issue with creating the LeaveRequest
            logger('Error creating LeaveRequest', ['emp_id' => $employeeId]);
    
            session()->flash('error', 'Error submitting leave application. Please try again.');
            return redirect()->to('/leave-page');
        }
    
    }

    private function sendLeaveApplicationNotification($leaveRequest)
    {
        // Retrieve the manager's email
        $managerEmail = $this->getManagersEmail($leaveRequest->emp_id);
        
        // Ensure $leaveRequest is an instance of LeaveRequest
        if (!$leaveRequest instanceof \App\Models\LeaveRequest) {
            logger('Invalid $leaveRequest instance', ['leave_request' => $leaveRequest]);
            return;
        }
    
        // Extract necessary details from $leaveRequest
        $leaveDetails = [
            'leave_type' => $leaveRequest->leave_type,
            'from_date' => $leaveRequest->from_date,
            // Add more details as needed
        ];
        // Set the sender and receiver dynamically
$senderEmail =  $this->applying_to->email;
$receiverEmail = $managerEmail;  // Set this based on your application logic

// Set the sender and receiver in the mail configuration
config([
    'mail.from.address' => $senderEmail,
    'mail.from.username' => $senderEmail,
]);

// Example usage in your Livewire component
$mail = new LeaveApplicationNotification($leaveRequest, $receiverEmail);
Mail::to($receiverEmail)->send($mail);

    }
    
    private function getManagersEmail($employeeId)
    {
        // Fetch the employee details
        $employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
    
        // Check if the applying_to field is not null and is an array
        if ($employeeDetails && $employeeDetails->applying_to && is_array($employeeDetails->applying_to)) {
            // Decode the applying_to field
            $applyingToDetails = json_decode($employeeDetails->applying_to[]);
    
            // Loop through applyingToDetails to find the manager's email
            foreach ($applyingToDetails as $applyingToDetail) {
                if ($applyingToDetail->manager_id === $employeeId) {
                    // Manager's email found
                    return $this->getManagerEmailById($applyingToDetail->manager_id);
                }
            }
        }
    
        // Default placeholder email or handle the situation when manager's email is not found
        return 'bandaridivya1@gmail.com';
    }
    

    private function getManagerEmailById($managerId)
    {
        // Fetch manager's email from the database based on $managerId
        $managerDetails = EmployeeDetails::where('emp_id', $managerId)->first();
        
        // Assuming you have an email field in the EmployeeDetails model
        return $managerDetails ? $managerDetails->email : 'bandaridivya1@gmail.com';
    }

    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $employeeGender = EmployeeDetails::where('emp_id', $employeeId)->select('gender')->first();
        return view('livewire.leave-apply',[
           'employeeGender' => $employeeGender
        ]);
    }

 
}

