<?php

namespace App\Livewire;

use App\Models\LeaveRequest;
use App\Models\LetterRequest;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\GenerateLetter;
use Carbon\Carbon;
use App\Models\EmployeeDetails;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class DocumentCenterLetters extends Component
{
    public $tab = "Letters List";
    public $jumpToTab = "Confirmation Letter";
    public $activeTab = "Apply";
    public $hasAppointmentOrder = false;

    public $letter_type;
    public  $priority;
    public $reason;
    public $lastUpdated = null;
    public $showDetails = false;
    public $hasConfirmationLetter = false;
    public $confirmationLastUpdated = null;
    public $letters;
    public $template_name; 

    protected $rules = [
        'letter_type' => 'required',
        'priority' => 'required',
        'reason' => 'required',
    ];

    protected $messages = [
        'letter_type.required' => 'Letter type is required',
        'priority.required' => 'Priority is required',
        'reason.required' => 'Reason is required',
    ];
    public $previewLetter=null;

    public function validateField($field)
    {
        $this->validateOnly($field);
    }
    public function toggleDetails()
    {
        $this->showDetails = !$this->showDetails;
    }
    public function mount()
    {
        $loggedInEmpId = Auth::user()->emp_id;
        $appointmentOrder = GenerateLetter::whereJsonContains('employees', ['id' => $loggedInEmpId])
        ->where('template_name', 'Appointment Order')
        ->latest('updated_at')
        ->first();
    
    if ($appointmentOrder) {
        $this->hasAppointmentOrder = true;
        $this->lastUpdated = Carbon::parse($appointmentOrder->updated_at)->format('d M, Y');
    }

    // Fetch the latest Confirmation Letter
    $confirmationLetter = GenerateLetter::whereJsonContains('employees', ['id' => $loggedInEmpId])
        ->where('template_name', 'Confirmation Letter')
        ->latest('updated_at')
        ->first();

    if ($confirmationLetter) {
        $this->hasConfirmationLetter = true;
        $this->confirmationLastUpdated = Carbon::parse($confirmationLetter->updated_at)->format('d M, Y');
    }
    }
    public function submitRequest()
    {
        $this->validate();

        $employeeId = auth()->guard('emp')->user()->emp_id;

        LetterRequest::create([
            'emp_id' => $employeeId,
            'letter_type' => $this->letter_type,
            'priority' => $this->priority,
            'reason' => $this->reason,
        ]);

        // Reset Livewire component properties
        $this->reset();

        session()->flash('success', 'Request letter submitted successfully!');

        return redirect('/document-center-letters');
    }
//     public function viewLetter($letterId)
// {
//     $letter = GenerateLetter::find($letterId);
   

//     if (!$letter) {
//         session()->flash('error', 'Letter not found.');
//         return;
//     }

//     // Generate letter content dynamically
//     $employee = EmployeeDetails::with('personalInfo')->where('emp_id', $letter->employee_id)->first();
//     if (!$employee) {
//         session()->flash('error', 'Employee details not found.');
//         return;
//     }
//     $this->template_name = $letter->template_name;

//     $this->previewLetter = $this->generateLetterContent($employee,$letter);
   

// }

public $showLetterModal = false; 
public $letter;
public $employeeName, $employeeId, $employeeAddress, $fullName, $signature, $designation;
public function viewLetter($letterId)
{
    try {
        // Fetch the letter details
        $this->letter = GenerateLetter::find($letterId);
        

        // Check if the letter exists
        if (!$this->letter) {
            session()->flash('error', 'Letter not found.');
            return;
        }

        // Get employee data from the JSON field
        $employees = json_decode($this->letter->employees, true);

        // If there are no employees, show an error message
        if (!$employees || count($employees) == 0) {
            session()->flash('error', 'Employee details not found.');
            return;
        }

        // Get employee details (assuming you are dealing with the first employee)
        $this->employeeName = $employees[0]['name']; // Get the name of the first employee
        $this->employeeAddress = $employees[0]['address'];
        $this->employeeId = $employees[0]['id'];

        // Get authorized signatory details
        $authorizedSignatory = json_decode($this->letter->authorized_signatory, true);
        
       
        $this->fullName = $authorizedSignatory['name'];
        $this->designation = $authorizedSignatory['designation'];
        $this->signature = $authorizedSignatory['signature'];

        // Set modal visibility flag to true
        $this->showLetterModal = true;
      

    } catch (\Exception $e) {
        // Log the exception message (optional)
        Log::error("Error in viewLetter: " . $e->getMessage());

        // Flash an error message to the session
        session()->flash('error', 'An error occurred while fetching the letter details. Please try again.');

        // Optionally, you could also return a view with a more generic error message or redirect
        // return redirect()->route('letters.index'); // Example redirection to list page
    }
}
public function downloadLetter($letterId)
{
    try {
       
        // Fetch the letter and employee details
        $letter = GenerateLetter::find($letterId);
       

        if (!$letter) {
            session()->flash('error', 'Letter not found.');
            return;
        }

        $employees = json_decode($letter->employees, true);
        $employee = $employees[0];

        // If there are no employees, show an error message
        if (!$employee || count($employee) == 0) {
            session()->flash('error', 'Employee details not found.');
            return;
        }

        
       

        // Prepare the data to pass to the Blade view
        $previewLetter = $letter; // assuming previewLetter is the same as letter data
        $authorizedSignatory = json_decode($previewLetter->authorized_signatory, true); // true returns an associative array

        if (!$authorizedSignatory) {
            // Handle the error case if decoding fails
            session()->flash('error', 'Authorized Signatory data not found.');
            return;
        }
        
        // Access the individual fields from the decoded authorized_signatory
        $signatoryName = $authorizedSignatory['name'] ?? 'N/A';
        $signatoryDesignation = $authorizedSignatory['designation'] ?? 'N/A';
        $signatorySignature = $authorizedSignatory['signature'] ?? '';

        // Render the Blade view content
        $pdfContent = view('download_letter', compact('employee', 'previewLetter', 'signatoryName', 'signatoryDesignation', 'signatorySignature'))->render();

        // Generate PDF from the rendered content
        $pdf = Pdf::loadHTML($pdfContent);

        // Return the PDF as a downloadable response
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "{$letter->template_name}_{$employee['id']}.pdf");

    } catch (\Exception $e) {
        // Log the error
        Log::error('Error generating letter PDF: ' . $e->getMessage(), [
            'letterId' => $letterId,
            'employeeId' => $employee->emp_id ?? 'N/A'
        ]);

        // Provide a user-friendly error message
        session()->flash('error', 'There was an error while generating the letter. Please try again later.');

        // Optionally, you could redirect or do additional error handling here
        // return redirect()->route('letters.index');
    }
}


// public function downloadLetter($letterId)
// {
//     $letter = GenerateLetter::find($letterId);
  
    
//     if (!$letter) {
//         session()->flash('error', 'Letter not found.');
//         return;
//     }

//     $employee = EmployeeDetails::with('personalInfo')->where('emp_id', $letter->employee_id)->first();
    
//     if (!$employee) {
//         session()->flash('error', 'Employee details not found.');
//         return;
//     }

//     // Generate PDF content
//     $letterContent = $this->generateLetterContent($employee,$letter);
    
//     $pdf = Pdf::loadHTML($letterContent);
//     return response()->streamDownload(
//         fn () => print($pdf->output()),
//         "Confirmation_Letter_{$employee->emp_id}.pdf"
//     );
// }
private function generateLetterContent($employee,$letter)
{
    $authorizedSignatory = json_decode($letter['authorized_signatory'], true);

    // Extract the required fields
    $fullName = $authorizedSignatory['name'];
    $designation = $authorizedSignatory['designation'];
    $signature = '';
    if (!empty($authorizedSignatory['signature'])) {
       
        $signature = 'data:image/png;base64,' . base64_encode($authorizedSignatory['signature']);
       
    }
   
   

 
    $date = now()->format('d M Y');

    switch ($letter->template_name) {
      
        case 'Appointment Order':
            return "
                <div class='container'>
                    <div class='header' style='display:flex; flex-direction: column; text-align: center;'>
                        <p>Xsilica Software Solutions Pvt. Ltd.</p>
                        <p>Unit No - 4, Kapil Kavuri Hub, 3rd floor, Nanakramguda, <br>
                        Serilingampally, Ranga Reddy, Telangana-500032.</p>
                    </div>
                    
                    <p style='text-align: left;'>{$date}</p>
                    
                    <p>To,<br>
                    {$employee->first_name} {$employee->last_name}<br>
                    Employee ID: {$employee->emp_id}<br>
                    {$employee->address}</p>
        
                    <p class='text-align-center' style='font-size: 16px;'> <strong>Sub: Appointment Order</strong></p>
        
                    <p><strong>Dear</strong> {$employee->first_name},</p>
        
                    <p>We are pleased to offer you the position of <strong>Software Engineer I</strong> at Xsilica Software Solutions Pvt. Ltd., as per the discussion we had with you. Below are the details of your appointment:</p>
        
                    <p><strong>1. Start Date:</strong> 02 Jan 2023 (Your appointment will be considered withdrawn if you do not report to our office on this date.)</p>
                    <p><strong>2. Compensation:</strong> Your Annual Gross Compensation is Rs. 2,40,000/- (subject to statutory deductions).</p>
                    <p><strong>3. Probation Period:</strong> You will be under probation for six calendar months from your date of joining.</p>
                    <p><strong>4. Confirmation of Employment:</strong> Upon successful completion of probation, you will be confirmed in employment.</p>
                    <p><strong>5. Performance Reviews:</strong> You will undergo annual performance reviews and appraisals.</p>
                    <p><strong>6. Absence from Duty:</strong> Unauthorized absence for 8 consecutive days will lead to termination of service.</p>
                    <p><strong>7. Leave Policy:</strong> You are entitled to leave as per law and company policy, including one sick leave per month.</p>
                    <p><strong>8. Confidentiality:</strong> Any products or materials developed during your employment will remain the property of Xsilica.</p>
                    <p><strong>9. Termination of Employment:</strong> Voluntary resignation requires a 60-day notice period. Immediate termination can occur for consistent underperformance or providing incorrect information.</p>
        
                    <p><strong>We are excited to have you as a part of our team and look forward to your contribution!</strong></p>
        
                    <p>Thank you.</p>
        
                     <div class='signature'>
                        <p>Yours faithfully,</p>
                        <p>For <strong>Xsilica Software Solutions Pvt. Ltd.</strong></p>
                       <p style='font-size: 12px;'><strong>{$fullName}</strong></p>
                         " . (!empty($signature) ? "<img src='{$signature}' alt='Signature' style='width:150px; height:auto;'>" : "") . "
                         <p style='font-size: 12px;'> <strong>{$designation}</strong></p>
            </div>
        
                    <div class='cc'>
                        <p><strong>Cc:</strong></p>
                        <p>1. Reporting Manager</p>
                        <p>2. Personal File</p>
                    </div>
                </div>
            ";

        case 'Confirmation Letter':
         
            return "
            <div class='container'>
                        <div class='header' style='display:flex; flex-direction: column; text-align: center;'>
                            <p>Xsilica Software Solutions Pvt. Ltd.</p>
                            <p>Unit No - 4, Kapil Kavuri Hub, 3rd floor, Nanakramguda, <br>
                            Serilingampally, Ranga Reddy, Telangana-500032.</p>
                            
                        </div>
                        
                        <p style='text-align: left;'>{$date}</p>
                        
                        <p>To,<br>
                        {$employee->first_name} {$employee->last_name}<br>
                        Employee ID: {$employee->emp_id}<br>
                        {$employee->address}</p>
        
                        <p class='text-align-center' style='font-size: 16px;'> <strong>Sub: Confirmation Letter</strong></p>
        
                        <p><strong>Dear</strong> {$employee->first_name},</p>
        
                        <p>Further to your appointment/joining dated <strong>{$employee->joining_date}</strong>, 
                        your employment with us is confirmed with effect from <strong>{$date}</strong>.</p>
        
                        <p>All the terms mentioned in the Offer/Appointment letter will remain unaltered.</p>
        
                        <p>We thank you for your contribution so far and hope that you will continue to 
                        perform equally well in the future.</p>
        
                        <p><strong>We wish you the best of luck!</strong></p>
                        
        
                        <p>Thank you.</p>
        
                        <div class='signature'>
                        <p>Yours faithfully,</p>
                        <p>For <strong>Xsilica Software Solutions Pvt. Ltd.</strong></p>
                       <p style='font-size: 12px;'><strong>{$fullName}</strong></p>
                        " . (!empty($signature) ? "<img src='{$signature}' alt='Signature' style='width:150px; height:auto;'>" : "") . "
                         <p style='font-size: 12px;'> <strong>{$designation}</strong></p>
            </div>
        
        
                        <div class='cc'>
                            <p><strong>Cc:</strong></p>
                            <p>1. Reporting Manager</p>
                            <p>2. Personal File</p>
                        </div>
                    </div>
                ";

        default:
            return "<p>Invalid template selected.</p>";
    }
}



    public $allRequests;
    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $appointmentOrder = GenerateLetter::whereJsonContains('employees', ['id' => $employeeId])
        ->where('template_name', 'Appointment Order')
        ->latest('updated_at')
        ->first();
       
        $confirmationLetter = GenerateLetter::whereJsonContains('employees', ['id' => $employeeId])
        ->where('template_name', 'Confirmation Letter')
        ->latest('updated_at')
        ->first();
      
        $this->allRequests = LetterRequest::where('emp_id', $employeeId)->orderBy('created_at', 'desc')->get();
        return view('livewire.document-center-letters', [
            'appointmentOrder' => $appointmentOrder,  // Pass appointmentOrder
            'confirmationLetter' => $confirmationLetter,
            'letter' => $this->letter,
            'employeeId' => $this->employeeId,
        ]);
    }
    public function closeLetterModal()
{
    // Hide the modal when the close button is clicked
    $this->showLetterModal = false;
}
}
