<?php
 
namespace App\Livewire;
 
use Illuminate\Validation\Rule;
use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Admin;
use Illuminate\Validation\ValidationException;

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Mail\PasswordChanged;
use Illuminate\Support\Facades\Mail;
 
class EmpLogin extends Component
{
    public $showDialog = false;
    public $email;
    public $dob;
    public $newPassword;
    public $newPassword_confirmation;
    public $verified = false;
    public $showSuccessModal = false;
    public $showErrorModal = false;
    public $showLoader = false; 
    public $passwordChangedModal = false;
    public $form = [
        'emp_id' => '',
        'password' => '',
    ];
    public $error = '';
    protected $messages = [
        'form.emp_id.required' => 'ID is required.',
        'form.password.required' => 'Password is required.',
    ];
    
    public function jobs()
    {
        return redirect()->to('/Login&Register');
    }
    public function createCV()
    {
        return redirect()->to('/CreateCV');
    }
    public function empLogin()
    {
 
        try {
            $this->validate([
                "form.emp_id" => 'required',
                "form.password" => "required"
            ]);

            $this->showLoader = true;
 
            if (Auth::guard('emp')->attempt(['emp_id' => $this->form['emp_id'], 'password' => $this->form['password']])) {
                return redirect('/');
            } elseif (Auth::guard('emp')->attempt(['email' => $this->form['emp_id'], 'password' => $this->form['password']])) {
                return redirect('/');
            } elseif (Auth::guard('hr')->attempt(['hr_emp_id' => $this->form['emp_id'], 'password' => $this->form['password']])) {
                return redirect('/home-dashboard');
            } elseif (Auth::guard('hr')->attempt(['email' => $this->form['emp_id'], 'password' => $this->form['password']])) {
                return redirect('/home-dashboard');
            } elseif (Auth::guard('finance')->attempt(['fi_emp_id' => $this->form['emp_id'], 'password' => $this->form['password']])) {
                return redirect('/financePage');
            } elseif (Auth::guard('finance')->attempt(['email' => $this->form['emp_id'], 'password' => $this->form['password']])) {
                return redirect('/financePage');
            } elseif (Auth::guard('it')->attempt(['it_emp_id' => $this->form['emp_id'], 'password' => $this->form['password']])) {
                return redirect('/itPage');
            } elseif (Auth::guard('admins')->attempt(['admin_emp_id' => $this->form['emp_id'], 'password' => $this->form['password']])) {
                return redirect('/adminPage');
            } elseif (Auth::guard('it')->attempt(['email' => $this->form['emp_id'], 'password' => $this->form['password']])) {
                return redirect('/itPage');
            } else {
                $this->error = "ID / Mail or Password Wrong!!";
            }
        } catch (ValidationException $e) {
            // Handle validation errors
            $this->showLoader = false; // Hide loader if validation fails
        }catch (\Exception $e) {
            // Debugging
            $this->showLoader = false;
            $this->error = "ID / Mail or Password Wrong!!";
        }
    }
 
    public function resetForm()
    {
        $this->email = '';
        $this->dob = '';
        $this->newPassword = '';
        $this->newPassword_confirmation = '';
        $this->verified = false;
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
    public function verifyEmailAndDOB()
    {
        $this->validate([
            'email' => ['required', 'email'],
            'dob' => ['required', 'date'],
        ]);
        // Implement your logic to verify email and DOB here.
        // Example: Check if the email and DOB match a user's stored values in your database.
        $user = EmployeeDetails::where('email', $this->email)->where('date_of_birth', $this->dob)->first();
        if ($user) {
                $this->verified = true;
                if($this->verified){
                    $this->verified = false;
                    $this->showSuccessModal = true;
                }
 
            } else {
                // Invalid email or DOB, show an error message or handle accordingly.
                $this->addError('email', 'Invalid email or date of birth');
                $this->showErrorModal = true;
            }
 
    }
 
    public function showPasswordChangeModal()
    {
        $this->verified = true;
        $this->showSuccessModal = false;
    }
    public function createNewPassword()
    {
        //dd($this->newPassword,$this->newPassword_confirmation);
        $this->validate([
            'newPassword' => ['required', 'min:8', 'max:50', 'confirmed'],
        ]);
        // dd($this->newPassword,$this->newPassword_confirmation);
        // Implement your logic to create a new password here.
        // Example: Update the user's password in your database.
        if ($this->newPassword === $this->newPassword_confirmation) {
            $user = EmployeeDetails::where('email', $this->email)->first();
            if ($user) {
               // dd($user->email);
                // Update the user's password in the database.
                $user->update(['password' => bcrypt($this->newPassword)]);
                $this->passwordChangedModal = true;
 
                // Reset form fields and state after successful password update.
                $this->reset(['newPassword', 'newPassword_confirmation', 'verified']);
 
                $this->showDialog = false;
            }
        } else {
            // Passwords do not match, show an error message.
            $this->addError('newPassword', 'Passwords do not match');
            $this->passwordChangedModal = false;
        }
    }
 
    public function render()
    {
        return view('livewire.emp-login');
    }
}
 