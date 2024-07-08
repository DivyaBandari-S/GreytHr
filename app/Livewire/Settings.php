<?php

// File Name                       : EmpLogin.php
// Description                     : This file contains the implementation after login change theire password,nick name etc.
// Creator                         : Saragada Siva Kumar and Asapu Kiran Kumar
// Email                           :
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : EmployeeDetails,Hr,Finance,Admin,IT



namespace App\Livewire;

use App\Models\Admin;
use App\Models\EmployeeDetails;
use App\Models\Finance;
use App\Models\Hr;
use App\Models\IT;
use App\Models\PeopleList;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

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
    public $error = '';
    public function editBiography()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
            $this->editingBiography = true;
            $this->biography = $this->employeeDetails->biography ?? '';
        } catch (\Exception $e) {
            \Log::error('Error in editBiography method: ' . $e->getMessage());
        }
    }


    public function cancelBiography()
    {
        $this->editingBiography = false;
    }


    public function saveBiography()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
            $this->employeeDetails->biography = $this->biography;
            $this->employeeDetails->save();
            $this->editingBiography = false;
        } catch (\Exception $e) {
            \Log::error('Error in saveBiography method: ' . $e->getMessage());
        }
    }

    public function editSocialMedia()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
            $this->editingSocialMedia = true;
            $this->faceBook = $this->employeeDetails->facebook ?? '';
            $this->twitter = $this->employeeDetails->twitter ?? '';
            $this->linkedIn = $this->employeeDetails->linked_in ?? '';
        } catch (\Exception $e) {
            \Log::error('Error in editSocialMedia method: ' . $e->getMessage());
        }
    }


    public function cancelSocialMedia()
    {
        $this->editingSocialMedia = false;
    }


    public function saveSocialMedia()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
            $this->employeeDetails->facebook = $this->faceBook;
            $this->employeeDetails->twitter = $this->twitter;
            $this->employeeDetails->linked_in = $this->linkedIn;
            $this->employeeDetails->save();
            $this->editingSocialMedia = false;
        } catch (\Exception $e) {
            \Log::error('Error in saveSocialMedia method: ' . $e->getMessage());
        }
    }

    public function editProfile()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
            $this->nickName = $this->employeeDetails->nick_name ?? '';
            $this->wishMeOn = $this->employeeDetails->date_of_birth ?? '';
            $this->editingNickName = true;
        } catch (\Exception $e) {
            \Log::error('Error in editProfile method: ' . $e->getMessage());
        }
    }


    public function cancelProfile()
    {
        $this->editingNickName = false;
    }

    public function saveProfile()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
            $this->employeeDetails->nick_name = $this->nickName;
            $this->employeeDetails->date_of_birth = $this->wishMeOn;
            $this->employeeDetails->save();
            $this->editingNickName = false;
        } catch (\Exception $e) {
            \Log::error('Error in saveProfile method: ' . $e->getMessage());
        }
    }


    public function editTimeZone()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
            $this->editingTimeZone = true;
            $this->selectedTimeZone = $this->employeeDetails->time_zone ?? '';
        } catch (\Exception $e) {
            \Log::error('Error in editTimeZone method: ' . $e->getMessage());
        }
    }


    public function cancelTimeZone()
    {
        $this->editingTimeZone = false;
    }


    public function saveTimeZone()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
            $this->employeeDetails->time_zone = $this->selectedTimeZone;
            $this->employeeDetails->save();
            $this->editingTimeZone = false;
        } catch (\Exception $e) {
            \Log::error('Error in saveTimeZone method: ' . $e->getMessage());
        }
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
        $this->showAlertDialog = false;
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->oldPassword = '';
        $this->newPassword = '';
        $this->confirmNewPassword = '';
        $this->oldPassword = '';
        $this->newPassword = '';
        $this->confirmNewPassword = '';
    }

    public function changePassword()
    {
        try {
            $this->validate([
                'oldPassword' => 'required',
                'newPassword' => 'required|min:8',
                'confirmNewPassword' => 'required|same:newPassword',
            ]);

            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
            if (!Hash::check($this->oldPassword, $this->employeeDetails->password)) {
                $this->addError('oldPassword', 'The old password is incorrect.');
                return;
            }

            // Update the password
            $this->employeeDetails->password = Hash::make($this->newPassword);
            $this->employeeDetails->save();

            session()->flash('success', 'Password changed successfully.');
            $this->resetForm();
            $this->showDialog = false;
            $this->passwordChanged = true;
        } catch (\Exception $e) {
            \Log::error('Error in changePassword method: ' . $e->getMessage());
        }
    }

    public function render()
    {
        try {
            $this->timeZones = timezone_identifiers_list();
            $this->employees = EmployeeDetails::where('emp_id', auth()->guard('emp')->user()->emp_id)->get();
            return view('livewire.settings', ['employees' => $this->employees]);
        } catch (\Exception $e) {
            \Log::error('Error in render method: ' . $e->getMessage());
            return view('livewire.settings')->withErrors(['error' => 'An error occurred while loading the data. Please try again later.']);
        }
    }
}
