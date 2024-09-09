<?php

namespace App\Livewire;

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
use Illuminate\Support\Facades\Log;

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
    
    public function closeMessage()
    {
        $this->showSuccessMessage = false;
    }

    public function updateProfile()
    {
        try {
            $empId = Auth::guard('emp')->user()->emp_id;
            $employee = EmployeeDetails::where('emp_id', $empId)->first();

            $this->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:1024', // 1024 kilobytes = 1 megabyte
            ]);

            if ($this->image) {
                $imagePath = file_get_contents($this->image->getRealPath());
                $employee->image = $imagePath;
                $employee->save();
            }
            $this->showSuccessMessage = true;
        } catch (\Exception $e) {
            Log::error('Error in updateProfile method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while updating the profile. Please try again later.');
        }

    }
    public function showPopupModal()
    {
        $this->showModal = true;
    }
    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        try {
            $empId = auth()->guard('emp')->user()->emp_id;

            // Retrieve employee details and related information
            $this->employeeDetails = EmployeeDetails::with(['empBankDetails', 'empParentDetails', 'empPersonalInfo','empSpouseDetails'])
                ->where('emp_id', $empId)
                ->first();

                return view('livewire.profile-info');
        } catch (\Exception $e) {
            Log::error('Error in render method: ' . $e->getMessage());
            return view('livewire.profile-info')->withErrors(['error' => 'An error occurred while loading the data. Please try again later.']);
        }
    }
}
