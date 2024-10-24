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
    public $fileName;
    public  $last_working_day;
    public $comments;
    public $signature;
    public $isResigned;
    public $showAlert = false;
    public $isUploading = false;
    public $qualifications = [];
    protected $rules = [
        'resignation_date' => 'required|date|after_or_equal:today',
        // 'last_working_day' => 'required|date|after_or_equal:resignation_date',
        'reason' => 'required|string|max:255',
        // 'comments' => 'nullable|string',
        'signature' => 'nullable|file|mimes:jpg,jpeg,png,pdf|:1024',
    ];
    // Custom validation messages (optional)
    protected $messages = [
        'resignation_date.after_or_equal' => 'Resignation date must be today or later.',
        'resignation_date.required' => 'Resignation date is required.',
        'last_working_day.required' => 'Last working day must be the same as or after the resignation date.',
        'reason' => 'Reason required',
        'signature.max' => 'Signature field must not be greater than 1 MB.',
        'signature.mimes' => 'Signature field must be a file of type: jpg, jpeg, png, pdf, doc, docx.'
    ];
    public function validateFields($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function updatedSignature()
    {
        $this->validateOnly('signature');
    }
    public $activeTab = 'personalDetails';

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }
    public function mount()
    {
        $this->updateProfile();
        $empId = Auth::guard('emp')->user()->emp_id;
        $resig_requests=EmpResignations::where('emp_id', $empId)->where('status',['5','2'])->first();
// dd($resig_requests);
        if($resig_requests){
            if($resig_requests->status =='5'){
                $this->isResigned='pending';
                $this->resignation_date=$resig_requests->resignation_date;
                $this->reason=$resig_requests->reason;
                $this->fileName=$resig_requests->file_name;
            }else{
                $this->isResigned='approved';
            }
        }
        $this->qualifications = $this->getEducationData($empId);
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
        $this->validate();

        // Manually validate the file size

        try {

            $fileContent = null;
            $mime_type = null;
            $file_name = null;

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

            $employeeId = auth()->guard('emp')->user()->emp_id;
            // Create a new EmpResignation record
            $data = EmpResignations::create([
                'emp_id' => $employeeId,
                'resignation_date' => $this->resignation_date,
                'file_name' => $file_name,
                'mime_type' => $mime_type,
                // 'last_working_day' => $this->last_working_day,
                'reason' => $this->reason,
                // 'comments' => $this->comments,
                'signature' => $fileContent,
            ]);
            FlashMessageHelper::flashSuccess('Resignation details have been submitted successfully.');

            $this->showAlert = true;
            $this->resetInputFields();
           $this->showModal = false;
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

    public function resetInputFields()
    {

        $this->resignation_date = '';
        $this->reason = '';
        $this->signature = '';
        $this->resetErrorBag();
    }
    public function closeModel(){

        $this->showModal = false;
        $this->reset(['resignation_date', 'reason', 'signature']);
        $this->resetErrorBag();
    }
    public function closeMessage()
    {
        $this->showSuccessMessage = false;
    }
    public function showPopupModal()
    {
        $this->showModal = true;
        $this->activeTab ='employeeJobDetails';   
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
