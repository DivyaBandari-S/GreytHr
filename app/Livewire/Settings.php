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

use App\Helpers\FlashMessageHelper;
use App\Models\Admin;
use App\Models\Company;
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
use Carbon\Carbon;

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
    public $companyName;
    public $isLoading = false;
    public function editBiography()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::with(['empPersonalInfo'])
                ->where('emp_id', $employeeId)->first();
            $this->biography = $this->employeeDetails->empPersonalInfo->biography ?? '';
            $this->editingBiography = true;
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('Error in editBiography method:');

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
                    'email' => null,
                    'mobile_number' => null,
                    'alternate_mobile_number' => null,
                ]);
            }
            $this->editingBiography = false;
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('Error in saveBiography method: ');
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
            FlashMessageHelper::flashError('Error in editSocialMedia method: ');
        }
    }


    public function cancelSocialMedia()
    {
        $this->editingSocialMedia = false;
    }



    public function saveSocialMedia()
    {
        $this->validate($this->additionalRules);
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
                    'email' => null,
                    'mobile_number' => null,
                    'alternate_mobile_number' => null,
                ]);
            }
            $this->editingSocialMedia = false;
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('Error in saveSocialMedia method: ');
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
            FlashMessageHelper::flashError('Error in editProfile method: ');
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
            $empPersonalInfo->nick_name = !empty($this->nickName) ? $this->nickName : null;
            $empPersonalInfo->date_of_birth = !empty($this->wishMeOn) ? $this->wishMeOn : null;
            $empPersonalInfo->save();
        } else {
            $empPersonalInfo = EmpPersonalInfo::create([
                'emp_id' => $employeeId,
                'nick_name' => !empty($this->nickName) ? $this->nickName : null,
                'date_of_birth' => !empty($this->wishMeOn) ? $this->wishMeOn : null,
                'email' => null,
                'alternate_mobile_number' => null,
            ]);
        }

        $this->editingNickName = false;
    } catch (\Exception $e) {
        // Log::error('Error in saveProfile method for employee ID: ' . $employeeId . ' - ' . $e->getMessage());
        FlashMessageHelper::flashError('Error in saveProfile method: ');
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
            FlashMessageHelper::flashError('Error in editTimeZone method: ');
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
            FlashMessageHelper::flashError('Error in saveTimeZone method: ');
        }
    }


    public $showAlertDialog = false;
    public $showDialog = false;


    public function loginfo()
    {
        $this->fetchLoginHistory();
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
    protected function messages()
    {
        return [
            'oldPassword.required' => 'Please enter your current password.',
            'newPassword.required' => 'Please enter your new password.',
            'newPassword.string' => 'The new password must be a valid string.',
            'newPassword.min' => 'Your password must be at least 8 characters long.',
            'newPassword.regex' => 'Your password must contain at least one capital letter, one lowercase letter, one digit, and one special character.',
            'newPassword.different' => 'The new password must be different from the old password.',
            'confirmNewPassword.required' => 'Please enter your confirm new password.',
            'confirmNewPassword.same' => 'The new password and confirmation do not match.',
        ];
    }

    protected $additionalRules = [
        'facebook' => 'nullable|url|max:255',
        'twitter' => 'nullable|url|max:255',
        'linkedIn' => 'nullable|url|max:255',
    ];




    public function updated($propertyName)
    {
        if (in_array($propertyName, array_keys($this->rules))) {
            $this->validateOnly($propertyName);
        } elseif (in_array($propertyName, array_keys($this->additionalRules))) {
            $this->validateOnly($propertyName, $this->additionalRules);
        }
    }

    public function changePassword()
    {
        $this->isLoading = true; // Set loading state to true
        $this->validate();

        try {

            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
            $companyId = $this->employeeDetails->company_id;
            // Fetch the company details using company_id
            $company = Company::where('company_id', $companyId)->first();
            $this->companyName = $company->company_name;
            // Check if company details were found
            if (!Hash::check($this->oldPassword, $this->employeeDetails->password)) {
                $this->addError('oldPassword', 'The old password is incorrect.');
                return;
            }

            // Update the password
            $this->employeeDetails->password = Hash::make($this->newPassword);
            $this->employeeDetails->save();
            // Send password change notification
            if ($this->employeeDetails && !empty($this->employeeDetails->email)) {
                $this->employeeDetails->notify(new \App\Notifications\PasswordChangedNotification($this->companyName));
            }

            FlashMessageHelper::flashSuccess('Your Password changed successfully.');
            $this->resetForm();
            $this->showDialog = false;
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('Error in changePassword method: ');
        } finally {
            $this->isLoading = false; // Set loading state to false after processing
        }
    }


    public function fetchLoginHistory()
    {
        $userId = Auth::user()->emp_id;
        // Fetch last login, last login failure, and last password changed dates
        $this->lastLogin = DB::table('sessions')
            ->where('user_id', $userId)
            // ->where('type', 'login')
            ->orderBy('created_at', 'desc')
            ->value('created_at');
        $this->lastLogin = $this->lastLogin ? Carbon::parse($this->lastLogin)->format('d M Y H:i:s') : 'N/A';
        $this->lastLoginFailure = DB::table('sessions')
            ->where('user_id', $userId)
            // ->where('type', 'failure')
            ->orderBy('created_at', 'desc')
            ->value('created_at');
        $this->lastLoginFailure = $this->lastLoginFailure ? Carbon::parse($this->lastLoginFailure)->format('d M Y H:i:s') : 'N/A';

        $this->lastPasswordChanged = DB::table('employee_details')
            ->where('emp_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->value('updated_at');
        $this->lastPasswordChanged =  $this->lastPasswordChanged ? Carbon::parse($this->lastPasswordChanged)->format('d M Y H:i:s') : 'N/A';
        // Fetch login history
        $this->loginHistory = DB::table('sessions')
            ->where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->orderBy('created_at', 'desc')
            ->get([
                'ip_address',
                'user_agent',
                'device_type',
                DB::raw("CONCAT_WS(', ', city,state_name,country,postal_code) as location"),
                'created_at'
            ]);
    }



    public function render()
    {
        try {
            $this->timeZones = timezone_identifiers_list();
            $this->employees = EmployeeDetails::with(['empPersonalInfo', 'empDepartment'])
                ->where('emp_id', auth()->guard('emp')->user()->emp_id)->get();
            return view('livewire.settings', ['employees' => $this->employees]);
        } catch (\Exception $e) {

            FlashMessageHelper::flashError('Error in render method: ');
            return view('livewire.settings')->withErrors(['error' => 'An error occurred while loading the data. Please try again later.']);
        }
    }
}
