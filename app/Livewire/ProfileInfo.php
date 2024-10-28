<?php

namespace App\Livewire;

use App\Models\EmpResignations;
use Illuminate\Support\Facades\Request;
use App\Models\EmpBankDetail;
use App\Models\EmployeeDetails;
use App\Models\EmpParentDetails;
use App\Models\EmpPersonalInfo;
use App\Models\EmpSpouseDetails;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\GoogleDriveService;
use Livewire\Features\SupportFileUploads\FileNotPreviewableException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Helpers\FlashMessageHelper;

class ProfileInfo extends Component
{
    use WithFileUploads;

    public $parentDetails;
    public $personalDetails;
    public $father_last_name;
    public $empBankDetails;
    public $employeeDetails;
    public $image, $employee;
    public $showModal = false;
    public $showSuccessMessage = false;
    public $resignation_date;
    public  $reason;
    public $fileName = 'No File Choosen';
    public  $last_working_date;
    public  $approvedOn;
    public $comments;
    public $signature;
    public $isResigned;
    public $filecontents,$mime_types;
    public $resignId = '';
    public $showAlert = false;
    public $isUploading = false;
    public $qualifications = [];
    protected $rules = [

        // 'last_working_day' => 'required|date|after_or_equal:resignation_date',
        'reason' => 'required|string|max:255',
        // 'comments' => 'nullable|string',
        'signature' => 'nullable|file|mimes:jpg,jpeg,png,pdf|:1024',
    ];
    // Custom validation messages (optional)
    protected $messages = [
        'resignation_date.after_or_equal' => 'Resignation date must be today or later.',
        'resignation_date.required' => 'Resignation date is required.',
        'last_working_date.required' => 'Last working day must be the same as or after the resignation date.',
        'reason' => 'Reason required',
        'signature.max' => 'Signature field must not be greater than 1 MB.',
        'signature.mimes' => 'Signature field must be a file of type: jpg, jpeg, png, pdf, doc, docx.'
    ];
    public function validateFields($propertyName)
    {
        if ($propertyName == 'signature') {
            // dd();
            if ($this->signature) {
                // dd( $this->signature);
                $this->fileName = $this->signature->getClientOriginalName();
                // dd( $this->fileName);
            }
        }
        $this->validateOnly($propertyName);
    }
    public function updatedSignature()
    {
        $this->validateOnly('signature');
    }
    public function mount()
    {
        $empId = Auth::guard('emp')->user()->emp_id;

        $this->updateProfile();
        $this->getResignationDetails();
        $this->qualifications = $this->getEducationData($empId);
    }
    public function getResignationDetails()
    {
        $empId = Auth::guard('emp')->user()->emp_id;
        $resig_requests = EmpResignations::where('emp_id', $empId)->whereIn('status', ['5', '2'])->first();
        // dd($resig_requests);
        if ($resig_requests) {
            $this->resignId = $resig_requests->id;
            $this->resignation_date = $resig_requests->resignation_date;
            $this->reason = $resig_requests->reason;
            $this->fileName = $resig_requests->file_name;
            $this->mime_types=$resig_requests->mime_type;
            if ($resig_requests->status == '5') {
                $this->isResigned = 'Pending';
            } elseif($resig_requests->status == '2') {
                $this->isResigned = 'Approved';
                $this->last_working_date = EmployeeDetails::where('emp_id', $empId)->value('last_working_date');
                $this->approvedOn = EmployeeDetails::where('emp_id', $empId)->value('resignation_date');
                // dd( $this->last_working_date);
            }
            elseif($resig_requests->status == '2') {
                $this->isResigned = 'Rejected';
            }
        }else{
            $this->isResigned = '';
        }
    }
    protected function getEducationData($empId)
    {
        $info = EmpPersonalInfo::where('emp_id', $empId)->first();
        return $info ? json_decode($info->qualification, true) : [];
    }

    public function updateProfile()

    {

        try {

            $this->isUploading = true;

            $empId = Auth::guard('emp')->user()->emp_id;

            $employee = EmployeeDetails::where('emp_id', $empId)->first();



            // Validation rules

            $this->validate([

                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:1024',

            ]);

            // Proceed with file processing

            if ($this->image) {

                $imagePath = base64_encode(file_get_contents($this->image->getRealPath()));
                $employee->image = $imagePath;

                $employee->save();

                $this->showSuccessMessage = true;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation exceptions
            FlashMessageHelper::flashError('The uploaded file must be an image');
            $this->showAlert = true;
        } catch (\Exception $e) {

            FlashMessageHelper::flashError('An error occurred while updating the profile. Please try again later.');

            $this->showAlert = true;
        } finally {

            $this->isUploading = false; // Reset uploading state

            $this->showAlert = true;
        }
    }

    public function applyForResignation()
    {
        // Perform validation for the inputs
        if ($this->resignId == '') {
            $this->validate([
                'resignation_date' => 'required|date|after_or_equal:today',
            ]);
        }

        $this->validate();

        // Manually validate the file size

        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            if ($this->resignId == '') {
                $fileContent = null;
                $mime_type = null;
                $file_name = null;

            }else{
                $resig_requests = EmpResignations::where('emp_id', $employeeId)->where('status', ['5', '2'])->first();
                if ($resig_requests) {
                    if ($resig_requests->status == '5') {
                        $fileContent= $resig_requests->signature;
                        $mime_type = $this->mime_types;
                        $file_name = $this->fileName;
                    }
                }

            }


            if ($this->signature) {
                $fileContent = file_get_contents($this->signature->getRealPath());

                if ($fileContent === false) {
                    Log::error('Failed to read the uploaded file.', [
                        'file_path' => $this->signature->getRealPath(),
                    ]);
                    session()->flashError('error', 'Failed to read the uploaded file.');
                    return;
                }
                // Check if the file content is too large
                $mime_type = $this->signature->getMimeType();
                $file_name = $this->signature->getClientOriginalName();
            }

            // Create a new EmpResignation record
            $data = EmpResignations::updateorCreate(
                ['id' => $this->resignId],
                [
                    'emp_id' => $employeeId,
                    'resignation_date' => $this->resignation_date,
                    'file_name' => $file_name,
                    'mime_type' => $mime_type,
                    // 'last_working_day' => $this->last_working_day,
                    'reason' => $this->reason,
                    // 'comments' => $this->comments,
                    'signature' => $fileContent,
                ]
            );

            if ($this->isResigned == 'Pending') {
                FlashMessageHelper::flashSuccess('Resignation request have been updated successfully.');
            } else {
                FlashMessageHelper::flashSuccess('Resignation request have been submitted successfully.');
            }


            // $this->resetInputFields();
            $this->showModal = false;
            $this->getResignationDetails();
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') { // Integrity constraint violation code
                // Check if the error message contains 'Duplicate entry'
                if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    $this->addError('general', 'You have already applied for resignation.');
                    $this->showAlert = true;
                    return;
                }
            }
            FlashMessageHelper::flashError('A database error occurred:');
            $this->showAlert = true;
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->addError('validation', 'Validation failed: ' . $e->getMessage());
            $this->showAlert = true;
        } catch (\Illuminate\Database\QueryException $e) {
            FlashMessageHelper::flashError('Database error:');
            $this->showAlert = true;
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('An unexpected error occurred:');
            $this->showAlert = true;
        }
    }
    public function withdrawResignation(){
        try {
            // Find the resignation request by ID
            $resignationRequest = EmpResignations::findOrFail($this->resignId);

            // Update the status to 'withdrawn'
            $resignationRequest->status = '4';
            $resignationRequest->save();
            $this->showModal = false;
            $this->getResignationDetails();
            $this->resetInputFields();
            FlashMessageHelper::flashSuccess('Resignation request withdrawn successfully.');
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            FlashMessageHelper::flashError('An error occured, please try after some time.');
        }

    }

    public function resetInputFields()
    {

        $this->resignation_date = '';
        $this->reason = '';
        $this->signature = '';
        $this->resetErrorBag();
        $this->fileName='No File Choosen';
    }
    public function closeModel()
    {
        $this->showModal = false;
        if ($this->isResigned == '') {
            $this->reset(['resignation_date', 'reason', 'signature']);
            $this->resetErrorBag();
        }
    }
    public function closeMessage()
    {
        $this->showSuccessMessage = false;
    }
    public function showPopupModal()
    {
        $this->showModal = true;
    }
    public function closeModal()
    {
        $this->showModal = false;
    }
    public function hideAlert()
    {
        $this->showAlert = false;
    }
    public function render()
    {
        try {
            $empId = auth()->guard('emp')->user()->emp_id;

            // Retrieve employee details and related information
            $this->employeeDetails = EmployeeDetails::with(['empBankDetails', 'empParentDetails', 'empPersonalInfo', 'empSpouseDetails'])
                ->where('emp_id', $empId)
                ->first();


            return view('livewire.profile-info');
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('An error occurred. Please try again later.');
        }
    }
}
