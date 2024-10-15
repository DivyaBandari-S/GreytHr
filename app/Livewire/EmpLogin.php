<?php

// File Name                       : EmpLogin.php
// Description                     : This file contains the implementation multi guard login
// Creator                         : Saragada Siva Kumar
// Email                           :
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : EmployeeDetails,Hr,Finance,Admin,IT

namespace App\Livewire;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Admin;
use App\Models\Finance;
use App\Models\IT;
use App\Models\EmployeeDetails;
use App\Models\Hr;
use Illuminate\Validation\ValidationException;

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Mail\PasswordChanged;
use App\Models\Company;
use App\Models\EmpPersonalInfo;
use App\Notifications\ResetPasswordLink;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Helpers\FlashMessageHelper;

class EmpLogin extends Component
{
    public $showDialog = false;
    public $email;
    public $company_email;
    public $dob;
    public $companyName;
    public $newPassword;
    public $newPassword_confirmation;
    public $verified = false;
    public $showSuccessModal = false;
    public $showErrorModal = false;
    public $showLoader = false;
    public $passwordChangedModal = false;
    public $empIdMessageType;
    public $emp_id;
    public $form = [
        'emp_id' => '',
        'password' => '',
    ];
    public $error = '';
    public $verify_error = '';
    public $pass_change_error = '';
    public $showAlert = false;
    public $alertMessage = '';
    protected $rules = [
        'form.emp_id' => 'required',
        'form.password' => 'required',
    ];
    protected $passwordRules = [
        'newPassword' => [
            'required',
            'min:8',
            'max:50',
            'regex:/[A-Z]/',
            'regex:/[!@#$%^&*(),.?":{}|<>]/',
            'regex:/[0-9]/'
        ],
        'newPassword_confirmation' => 'required|same:newPassword',
    ];
    protected $forgotPasswordRules =  [
        'email' => ['nullable', 'email', 'required_without:company_email'],
        'company_email' => ['nullable', 'email', 'required_without:email'],
        'dob' => ['required', 'date'],
    ];
    protected $messages = [
        'form.emp_id.required' => 'ID / Mail is required.',
        'form.password.required' => 'Password is required.',
        'newPassword.required' => 'New Password is required.',
        'newPassword.min' => 'New Password should be at least 8 characters.',
        'newPassword.max' => 'New Password should not exceed 50 characters.',
        'newPassword.regex' => 'New Password must contain at least one uppercase letter and one special character, and one digit.',
        'newPassword_confirmation.required' => 'Confirm Password is required.',
        'newPassword_confirmation.same' => 'New Password and Confirm Password should be same.',
        'email.required_without' => 'Email is required.',
        'dob.required' => 'Date of Birth is required.',
        'email.email' => 'Please enter a valid email.',

    ];

    public function jobs()
    {
        return redirect()->to('/Login&Register');
    }
    public function createCV()
    {
        return redirect()->to('/CreateCV');
    }
    public function validateField($field)
    {
        if (in_array($field, ['email', 'company_email', 'dob'])) {
            $this->validateOnly($field, $this->forgotPasswordRules);
        } elseif (in_array($field, ['newPassword', 'newPassword_confirmation'])) {
            $this->validateOnly($field, $this->passwordRules);
        } else {
            $this->validateOnly($field, $this->rules);
        }
    }
    public function login()
    {
        $this->error = '';
    }

    public function empLogin()
    {
        $this->validate($this->rules);

        try {
            // $this->showLoader = true;
            $user = EmployeeDetails::where('emp_id', $this->form['emp_id'])
                ->orWhere('email', $this->form['emp_id'])
                ->first();
            // Check if user exists and is inactive
            if ($user && !$user->status) {

                // sweetalert()->addError('Your account is inactive. Please contact support.');
                // is_active == false
                ################################### this is also working by using dispatch event call from in the blade using javascript
                // Dispatch event to trigger a SweetAlert on the frontend
                $this->dispatch('inactive-user-alert', ['message' => 'Your account is inactive. Please contact support.']);
                $this->resetForm();
                $this->reset('form'); // Reset the entire form

            } else if (Auth::guard('emp')->attempt(['emp_id' => $this->form['emp_id'], 'password' => $this->form['password'], 'status' => 1])) {
                session(['post_login' => true]);
                return redirect('/');
            } elseif (Auth::guard('emp')->attempt(['email' => $this->form['emp_id'], 'password' => $this->form['password'], 'status' => 1])) {
                session(['post_login' => true]);
                return redirect('/');
            } else {
                FlashMessageHelper::flashError("Invalid ID or Password. Please try again.");
                $this->resetForm();
                $this->reset('form'); // Reset the entire form
            }
        } catch (ValidationException $e) {
            FlashMessageHelper::flashError('There was a problem with your input. Please check and try again.');
            $this->resetForm();
            $this->reset('form'); // Reset the entire form
        } catch (\Illuminate\Database\QueryException $e) {
            FlashMessageHelper::flashError('We are experiencing technical difficulties. Please try again later.');
            $this->resetForm();
            $this->reset('form'); // Reset the entire form
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            FlashMessageHelper::flashError('There is a server error. Please try again later.');
            $this->resetForm();
            $this->reset('form'); // Reset the entire form
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('An unexpected error occurred. Please try again.');
            $this->resetForm();
            $this->reset('form'); // Reset the entire form
        }
    }


    // protected function flashError($message)
    // {
    //     $this->showLoader = false;
    //     ########################################## both flash are working now ############################################################################################################
    //     flash(
    //         message: $message,
    //         type: 'error',
    //         options: [
    //             // 'timeout' => 3000, // 3 seconds
    //             'position' => 'top-center',
    //         ]
    //     );
    //     // flash()->addFlash(
    //     //     message: $message,
    //     //     type: 'error',
    //     //     options: [
    //     //         'timeout' => 3000, // 3 seconds
    //     //         'position' => 'top-center',
    //     //     ]
    //     // );
    //     ################################################ adding info by using this function ###################################################
    //     // flash()->addInfo(
    //     //     message: $message,
    //     //     options: [
    //     //         // 'timeout' => 3000, // 3 seconds
    //     //         'position' => 'top-center',
    //     //     ]
    //     // );
    // }


    public function resetForm()
    {
        $this->emp_id = '';
        $this->email = '';
        $this->dob = '';
        $this->newPassword = '';
        $this->newPassword_confirmation = '';
        $this->verified = false;
        $this->verify_error = '';
        $this->form = ['emp_id' => '', 'password' => '']; // Resetting the form
        $this->resetValidation();
    }

    public function show()
    {
        $this->resetForm();
        $this->resetValidation();
        $this->showDialog = true;
    }
    public function remove()
    {
        $this->resetForm();
        $this->showDialog = false;
    }

    public function closeSuccessModal()
    {
        $this->showSuccessModal = false;
    }
    public function closeErrorModal()
    {
        $this->showErrorModal = false;
    }
    public function closePasswordChangedModal()
    {
        $this->passwordChangedModal = false;
    }
    public function forgotPassword()
    {
        $this->verify_error = '';
    }
    public function updatedFormEmpId($value)
    {
        $this->form['emp_id'] = strtoupper($value);
    }


    // public function verifyEmailAndDOB()
    // {
    //     $this->validate(
    //         [
    //             'email' => ['nullable', 'email', 'required_without:company_email'],
    //             'company_email' => ['nullable', 'email', 'required_without:email'],
    //             'dob' => ['required', 'date'],
    //         ],

    //     );
    //     try {
    //         // Custom validation rule to ensure either email or company_email is present

    //         if (!$this->email) {
    //             throw new \Exception('Either email or company email must be provided.');
    //         }
    //         $userInEmployeeDetails = EmpPersonalInfo::where('emp_id', EmployeeDetails::where('email', $this->email)->value('emp_id'))
    //             ->where('date_of_birth', $this->dob)
    //             ->first();
    //         $user = EmployeeDetails::where('email', $this->email)->first();
    //         // $token = Password::getRepository()->create($user);
    //         $token = Password::createToken($user);
    //         $user->notify(new ResetPasswordLink($token));
    //         if ($userInEmployeeDetails) {
    //             $this->verified = true;
    //             if ($this->verified) {
    //                 $this->verified = false;
    //                 $this->verify_error = false;
    //                 $this->showSuccessModal = true;
    //             }
    //         } else {
    //             // Invalid email or DOB, show an error message or handle accordingly.
    //             // $this->addError('email', 'Invalid email or date of birth');
    //             $this->verify_error = "Invalid Email or Date of Birth... Please try again!";
    //         }
    //     } catch (ValidationException $e) {
    //         // Handle validation errors
    //         //$this->showErrorModal = true;
    //         // $this->addError('email', 'There was a problem with your input. Please check and try again.');
    //         $this->verify_error = "There was a problem with your input. Please check and try again.";
    //     } catch (\Illuminate\Database\QueryException $e) {
    //         // Handle database errors
    //         //$this->showErrorModal = true;
    //         // $this->addError('email', 'We are experiencing technical difficulties. Please try again later.');
    //         $this->verify_error = 'We are experiencing technical difficulties. Please try again later.';
    //     } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
    //         // Handle server errors
    //         // $this->showErrorModal = true;
    //         // $this->addError('email', 'There is a server error. Please try again later.');
    //         $this->verify_error = 'There is a server error. Please try again later.';
    //     } catch (\Exception $e) {
    //         // Handle general errors
    //         // $this->showErrorModal = true;
    //         // $this->addError('email', 'An unexpected error occurred. Please try again.');
    //         $this->verify_error = 'An unexpected error occurred. Please try again.';
    //     }
    // }

    public function verifyLoginId()
    {
        // Validate Employee ID
        $this->validate(
            [
                'emp_id' => 'required|exists:employee_details,emp_id',
            ],
            [
                'emp_id.required' => 'Enter your employee ID.',
                'emp_id.exists' => 'The entered Employee ID does not exist.',
            ]
        );

        try {
            // Fetch the employee using emp_id
            $employee = EmployeeDetails::where('emp_id', $this->emp_id)->firstOrFail();
            // Check if the employee has an email
            if (empty($employee->email)) {
                // Handle case when employee email does not exist
                $this->verify_error = 'The employee does not have an associated email address. Please update your email for this ID: ' . $this->emp_id;
                $this->emp_id = null;
                return;
            }

            // Generate a custom token
            $token = Str::random(60); // or use your own custom token generation logic

            // Store the token in the password_reset_tokens table
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $employee->email], // Check for existing email
                [
                    'token' => $token,
                    'created_at' => now(),
                ]
            );

            // Here, you should create the email and send it with the link.
            // For example:
            $employee->notify(new ResetPasswordLink($token));

            // Flash a message to the session
            FlashMessageHelper::flashSuccess('Password reset link sent successfully to ' . $employee->email);
            $this->remove();
        } catch (\Exception $e) {
            // If any exception occurs, catch and set an error message
            FlashMessageHelper::flashError('There was an error processing your request: ' . $e->getMessage());
        }
    }





    public function showPasswordChangeModal()
    {
        $this->verified = true;
        $this->showSuccessModal = false;
    }


    public function createNewPassword()
    {
        // Validate the new password and its confirmation
        $this->validate([
            'newPassword' => ['required', 'min:8', 'max:50'],
            'newPassword_confirmation' => ['required', 'same:newPassword'],
        ]);

        try {
            // Check if email is provided
            if (!$this->email) {
                throw new \Exception('Email must be provided.');
            }

            // Fetch employee details using email and date of birth
            $userInEmployeeDetails = EmpPersonalInfo::where('emp_id', EmployeeDetails::where('email', $this->email)->value('emp_id'))
                ->where('date_of_birth', $this->dob)
                ->first()
                ? EmployeeDetails::where('emp_id', EmployeeDetails::where('email', $this->email)->value('emp_id'))->first()
                : null;


            if ($userInEmployeeDetails) {
                // Get company ID and fetch company details
                $companyId = $userInEmployeeDetails->company_id;
                $company = Company::where('company_id', $companyId)->first();
                $this->companyName = $company->company_name ?? 'Unknown Company';

                // Update the user's password
                $userInEmployeeDetails->update(['password' => bcrypt($this->newPassword)]);

                // Notify the user of password change
                $userInEmployeeDetails->notify(new \App\Notifications\PasswordChangedNotification($this->companyName));

                // Set modal and reset fields after success
                $this->passwordChangedModal = true;
                $this->reset(['newPassword', 'newPassword_confirmation', 'verified']);
                $this->showDialog = false;
            } else {
                // Handle user not found
                $this->addError('newPassword', 'User not found.');
                $this->passwordChangedModal = false;
            }
        } catch (ValidationException $e) {
            // Log validation errors
            Log::error('Validation error: ' . $e->getMessage());
            $this->pass_change_error = 'There was a problem with your input. Please check and try again.';
        } catch (\Illuminate\Database\QueryException $e) {
            // Log database errors
            Log::error('Database error: ' . $e->getMessage());
            $this->pass_change_error = 'We are experiencing technical difficulties. Please try again later.';
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            // Log server (HTTP) errors
            Log::error('HTTP error: ' . $e->getMessage());
            $this->pass_change_error = 'There is a server error. Please try again later.';
        } catch (\Exception $e) {
            // Log general errors
            Log::error('Password change error: ' . $e->getMessage());
            $this->pass_change_error = 'An unexpected error occurred. Please try again.';
        }
    }


    public function hideAlert()
    {
        $this->showAlert = false;
    }


    public function render()
    {
        if (Session::has('success')) {
            $this->showAlert = true;
            $this->alertMessage = Session::get('success');
        }

        return view('livewire.emp-login');
    }
}
