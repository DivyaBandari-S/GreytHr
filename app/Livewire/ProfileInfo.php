<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Request;
use App\Models\EmpBankDetail;
use App\Models\EmployeeDetails;
use App\Models\ParentDetail;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\GoogleDriveService;


class ProfileInfo extends Component
{
    use WithFileUploads;

    public $parentDetails;
    public $father_last_name;
    public $empBankDetails;
    public $employeeDetails;
    public $image, $employee;
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
                if ($this->image instanceof \Illuminate\Http\UploadedFile) {
                    $imagePath = $this->image->store('employee_image', 'public');
                } else {
                    $imagePath = $this->image;
                }
                $employee->image = $imagePath;
                $employee->save();
            }
    
            $this->showSuccessMessage = true;
        } catch (\Exception $e) {
            \Log::error('Error in updateProfile method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while updating the profile. Please try again later.');
        }
    }
    
    public function render()
    {
        try {
            $this->employeeDetails = EmployeeDetails::where('emp_id', auth()->guard('emp')->user()->emp_id)->get() ?? [];
            $this->empBankDetails = EmpBankDetail::where('emp_id', auth()->guard('emp')->user()->emp_id)->get() ?? [];
            $this->parentDetails = ParentDetail::where('emp_id', auth()->guard('emp')->user()->emp_id)->get() ?? [];
    
            return view('livewire.profile-info');
        } catch (\Exception $e) {
            \Log::error('Error in render method: ' . $e->getMessage());
            return view('livewire.profile-info')->withErrors(['error' => 'An error occurred while loading the data. Please try again later.']);
        }
    }
}
