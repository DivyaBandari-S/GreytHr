<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\PeopleList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
    

class Settings extends Component
{
    public $nickName;
    public $wishMeOn;
    public $selectedTimeZone;
    public $timeZones;
    public $biography;
    public $faceBook;
    public $twitter;
    public $linkedIn;
    public $editingNickName = false;
    public $editingTimeZone = false;
    public $editingBiography = false;
    public $editingSocialMedia = false;
    public $employees;
    public $employeeDetails;
    public $oldPassword;
    public $newPassword;
    public $confirmNewPassword;
    public $passwordChanged = false;
    public function editBiography()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
        $this->editingBiography = true;
        $this->biography = $this->employeeDetails->biography??'';
    }
 
    public function cancelBiography()
    {
        $this->editingBiography = false;
    }
 
    public function saveBiography()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
        $this->employeeDetails->biography = $this->biography;
        $this->employeeDetails->save();
 
        $this->editingBiography = false;
    }
    public function editSocialMedia()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
        $this->editingSocialMedia = true;
        $this->faceBook = $this->employeeDetails->facebook??'';
        $this->twitter = $this->employeeDetails->twitter??'';
        $this->linkedIn = $this->employeeDetails->linked_in??'';
    }
 
    public function cancelSocialMedia()
    {
        $this->editingSocialMedia = false;
    }
 
    public function saveSocialMedia()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
        $this->employeeDetails->facebook = $this->faceBook;
        $this->employeeDetails->twitter = $this->twitter;
        $this->employeeDetails->linked_in = $this->linkedIn;
        $this->employeeDetails->save();
        $this->editingSocialMedia = false;
    }
    public function editProfile()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
 
        $this->nickName = $this->employeeDetails->nick_name??'';
        $this->wishMeOn = $this->employeeDetails->date_of_birth??'';
        $this->editingNickName=true;
    }
 
    public function cancelProfile()
    {
        $this->editingNickName = false;
    }
    public function saveProfile()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
 
        $this->employeeDetails->nick_name = $this->nickName;
        $this->employeeDetails->date_of_birth = $this->wishMeOn;
        $this->employeeDetails->save();
        $this->editingNickName = false;
    }
 
    public function editTimeZone()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
        $this->editingTimeZone = true;
        $this->selectedTimeZone = $this->employeeDetails->time_zone??'';
    }
 
    public function cancelTimeZone()
    {
        $this->editingTimeZone = false;
    }
 
    public function saveTimeZone()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
        $this->employeeDetails->time_zone = $this->selectedTimeZone;
        $this->employeeDetails->save();
        $this->editingTimeZone = false;
    }
    public $showAlertDialog = false;
    public $showDialog = false;
 
    public function open()
    {
        $this->showAlertDialog = true;
    }
    public function show()
    {
        $this->resetForm();
        $this->showDialog = true;
 
    }
    public function remove()
    {
        $this->resetForm();
        $this->showDialog = false;
    }
    public function close()
    {
        $this->resetForm();
       $this->showAlertDialog = false;
    }
 
 
 
    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->oldPassword='';
        $this->newPassword='';
        $this->confirmNewPassword='';
    }
 
public function changePassword(){
        $this->validate([
 
            'oldPassword' => 'required',
            'newPassword' => 'required|min:8',
            'confirmNewPassword' => 'required|same:newPassword',
        ]);
 
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
         if (!Hash::check($this->oldPassword,  $this->employeeDetails->password)) {
            $this->addError('oldPassword', 'The old password is incorrect.');
           return;
        }
 
    // Update the password
    $this->employeeDetails->password = Hash::make($this->newPassword);
    $this->employeeDetails->save();
 
    session()->flash('success', 'Password changed successfully.');
    $this->resetForm();
    $this->showDialog = false;
    $this->passwordChanged =true;
    }
 
    public function render()
    {
        $this->timeZones = timezone_identifiers_list();
        $this->employees = EmployeeDetails::where('emp_id', auth()->guard('emp')->user()->emp_id)->get();
        return view('livewire.settings', ['employees' => $this->employees]);
    }
}
