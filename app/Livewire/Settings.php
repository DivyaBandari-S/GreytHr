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
use App\Models\EmpPersonalInfo;
use App\Models\Finance;
use App\Models\Hr;
use App\Models\IT;
use App\Models\PeopleList;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Settings extends Component
{
    public $nickName;
    public $wishMeOn;
    public $selectedTimeZone;
    public $timeZones;
    public $biography;
    public $facebook;
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
    public $loginHistory;
    public $lastLogin;
    public $lastLoginFailure;
    public $lastPasswordChanged;
    public function editBiography()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::with(['empPersonalInfo'])
                ->where('emp_id', $employeeId)->first();
            $this->biography = $this->employeeDetails->empPersonalInfo->biography ?? '';
            $this->editingBiography = true;
        } catch (\Exception $e) {
            Log::error('Error in editBiography method: ' . $e->getMessage());
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
            $empPersonalInfo = EmpPersonalInfo::where('emp_id', $employeeId)->first();
            if ($empPersonalInfo) {
                $empPersonalInfo->biography = $this->biography;
                $empPersonalInfo->save();
            } else {
                $empPersonalInfo = EmpPersonalInfo::create([
                    'emp_id' => $employeeId,
                    'biography' => $this->biography,
                    'first_name' => '',
                    'last_name' => '',
                    'gender' => '',
                    'email' => '',
                    'mobile_number' => '',
                    'alternate_mobile_number' => '',
                ]);
            }
            $this->editingBiography = false;
        } catch (\Exception $e) {
            Log::error('Error in saveBiography method: ' . $e->getMessage());
        }
    }

    public function editSocialMedia()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;

            $this->employeeDetails = EmployeeDetails::with(['empPersonalInfo'])
                ->where('emp_id', $employeeId)->first();
            $this->facebook = $this->employeeDetails->empPersonalInfo->facebook ?? '';
            $this->twitter = $this->employeeDetails->empPersonalInfo->twitter ?? '';
            $this->linkedIn = $this->employeeDetails->empPersonalInfo->linked_in ?? '';
            $this->editingSocialMedia = true;
        } catch (\Exception $e) {
            Log::error('Error in editSocialMedia method: ' . $e->getMessage());
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
            $empPersonalInfo = EmpPersonalInfo::where('emp_id', $employeeId)->first();
            if ($empPersonalInfo) {

                $empPersonalInfo->facebook = $this->facebook;
                $empPersonalInfo->twitter = $this->twitter;
                $empPersonalInfo->linked_in = $this->linkedIn;
                $empPersonalInfo->save();
            } else {

                $empPersonalInfo = EmpPersonalInfo::create([
                    'emp_id' => $employeeId,
                    'facebook' => $this->facebook,
                    'twitter' => $this->twitter,
                    'linked_in' => $this->linkedIn,
                    'first_name' => '',
                    'last_name' => '',
                    'gender' => '',
                    'email' => '',
                    'mobile_number' => '',
                    'alternate_mobile_number' => '',
                ]);
            }
            $this->editingSocialMedia = false;
        } catch (\Exception $e) {
            Log::error('Error in saveSocialMedia method: ' . $e->getMessage());
        }
    }

    public function editProfile()
    {
        try {

            $employeeId = auth()->guard('emp')->user()->emp_id;

            $this->employeeDetails = EmployeeDetails::with(['empPersonalInfo'])
                ->where('emp_id', $employeeId)->first();
            $this->nickName = $this->employeeDetails->empPersonalInfo->nick_name ?? '';
            $this->wishMeOn = $this->employeeDetails->empPersonalInfo->date_of_birth ?? '';
            $this->editingNickName = true;
        } catch (\Exception $e) {
            Log::error('Error in editProfile method: ' . $e->getMessage());
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
            $empPersonalInfo = EmpPersonalInfo::where('emp_id', $employeeId)->first();
            if ($empPersonalInfo) {
                $empPersonalInfo->nick_name = $this->nickName;
                $empPersonalInfo->date_of_birth = $this->wishMeOn;
                $empPersonalInfo->save();
            } else {
                $empPersonalInfo = EmpPersonalInfo::create([
                    'emp_id' => $employeeId,
                    'nick_name' => $this->nickName,
                    'date_of_birth' => $this->wishMeOn,
                    'first_name' => '',
                    'last_name' => '',
                    'gender' => '',
                    'email' => '',
                    'mobile_number' => '',
                    'alternate_mobile_number' => '',
                ]);
            }

            $this->editingNickName = false;
        } catch (\Exception $e) {
            Log::error('Error in saveProfile method: ' . $e->getMessage());
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
            Log::error('Error in editTimeZone method: ' . $e->getMessage());
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
            Log::error('Error in saveTimeZone method: ' . $e->getMessage());
        }
    }


    public $showAlertDialog = false;
    public $showDialog = false;


    public function loginfo()
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
    }

    protected $rules = [
        'oldPassword' => 'required|current_password',  // Validates that oldPassword is the user's current password
        'newPassword' => [
            'required',
            'string',
            'min:8',               // At least 8 characters
            'regex:/[A-Z]/',       // Must contain at least one uppercase letter
            'regex:/[a-z]/',       // Must contain at least one lowercase letter
            'regex:/[0-9]/',       // Must contain at least one digit
            'regex:/[@$!%*#?&]/',  // Must contain at least one special character
            'different:oldPassword', // Must be different from oldPassword
        ],
        'confirmNewPassword' => 'required|same:newPassword',  // Confirms that confirmNewPassword matches newPassword
    ];


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function changePassword()
    {

        $this->validate();

        try {

            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
            if (!Hash::check($this->oldPassword, $this->employeeDetails->password)) {
                $this->addError('oldPassword', 'The old password is incorrect.');
                return;
            }

            // Update the password
            $this->employeeDetails->password = Hash::make($this->newPassword);

            $this->employeeDetails->save();


            session()->flash('password', 'Your Password changed successfully.');
            $this->resetForm();
            $this->showDialog = false;
            // $this->passwordChanged = true;
        } catch (\Exception $e) {
            Log::error('Error in changePassword method: ' . $e->getMessage());
        }
    }


    public function fetchLoginHistory()
    {
        $userId = Auth::user()->id;

        // Fetch last login, last login failure, and last password changed dates
        $this->lastLogin = DB::table('sessions')
            ->where('user_id', $userId)
            // ->where('type', 'login')
            ->orderBy('created_at', 'desc')
            ->value('created_at');

        $this->lastLoginFailure = DB::table('sessions')
            ->where('user_id', $userId)
            // ->where('type', 'failure')
            ->orderBy('created_at', 'desc')
            ->value('created_at');

        $this->lastPasswordChanged = DB::table('password_resets')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->value('created_at');

        // Fetch login history
        $this->loginHistory = DB::table('sessions')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get(['ip_address', 'user_agent', 'location', 'created_at']);
    }



    public function render()
    {
        try {
            $this->timeZones = timezone_identifiers_list();
            $this->employees = EmployeeDetails::with(['empPersonalInfo', 'empDepartment'])
                ->where('emp_id', auth()->guard('emp')->user()->emp_id)->get();
            return view('livewire.settings', ['employees' => $this->employees]);
        } catch (\Exception $e) {
            Log::error('Error in render method: ' . $e->getMessage());
            return view('livewire.settings')->withErrors(['error' => 'An error occurred while loading the data. Please try again later.']);
        }
    }
}
