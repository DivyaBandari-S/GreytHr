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
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
        $this->editingBiography = true;
        $this->biography = $this->employeeDetails->biography ?? '';
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
        $this->faceBook = $this->employeeDetails->facebook ?? '';
        $this->twitter = $this->employeeDetails->twitter ?? '';
        $this->linkedIn = $this->employeeDetails->linked_in ?? '';
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

        $this->nickName = $this->employeeDetails->nick_name ?? '';
        $this->wishMeOn = $this->employeeDetails->date_of_birth ?? '';
        $this->editingNickName = true;
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
        $this->selectedTimeZone = $this->employeeDetails->time_zone ?? '';
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
        $this->oldPassword = '';
        $this->newPassword = '';
        $this->confirmNewPassword = '';
    }

    public function changePassword()
    {
        $this->validate([

            'oldPassword' => 'required',
            'newPassword' => 'required|min:8',
            'confirmNewPassword' => 'required|same:newPassword',
        ]);

        try {

            // $employeeId = auth()->guard('emp')->user()->emp_id;
            // DB::connection()->getPdo();


            // $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
            // if (!Hash::check($this->oldPassword,  $this->employeeDetails->password)) {
            //     $this->addError('oldPassword', 'The old password is incorrect.');
            //     return;
            // }

            // // Update the password
            // $this->employeeDetails->password = Hash::make($this->newPassword);
            // $this->employeeDetails->save();


            // Define an array of guards with their respective models and ID fields
            $guards = [
                'emp' => [EmployeeDetails::class, 'emp_id'],
                'hr' => [Hr::class, 'hr_emp_id'],
                'it' => [It::class, 'it_emp_id'],
                'finance' => [Finance::class, 'fi_emp_id'],
                'admins' => [Admin::class, 'admin_emp_id']
            ];


            $user = null;

            // Loop through each guard to find the authenticated user
            foreach ($guards as $guard => [$model, $idField]) {
                if (auth()->guard($guard)->check()) {
                    $userId = auth()->guard($guard)->user()->{$idField};
                    $user = $model::where($idField, $userId)->first();
                    break;
                }
            }
            if (!$user) {
                throw new \Exception('User details not found.');
            }

            if (!Hash::check($this->oldPassword, $user->password)) {
                $this->addError('oldPassword', 'The old password is incorrect.');
                return;
            }

            // Update the password
            $user->password = Hash::make($this->newPassword);
            $user->save();

            session()->flash('success', 'Password changed successfully.');
            $this->resetForm();
            $this->showDialog = false;
            $this->passwordChanged = true;
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            $this->error='There was an issue with your input. Please check and try again.';
        } catch (\Illuminate\Auth\AuthenticationException $e) {
            // Handle authentication errors
            $this->error= 'Authentication failed. Please try logging in again.';
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database query errors
            $this->error='There was a problem with the database query. Please try again later.';
        } catch (\PDOException $e) {
            // Handle database connection errors
            $this->error='Unable to connect to the database. Please check your database credentials and connection.';
        } catch (\Exception $e) {
            // Handle general errors
            $this->error='An unexpected error occurred. Please try again later.';
        }
    }

    public function render()
    {
        $this->timeZones = timezone_identifiers_list();
        $this->employees = EmployeeDetails::where('emp_id', auth()->guard('emp')->user()->emp_id)->get();
        return view('livewire.settings', ['employees' => $this->employees]);
    }
}
