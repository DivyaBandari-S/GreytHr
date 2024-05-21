<?php

// File Name                       : AddEmployeeDetails.php
// Description                     : This file contains the implementation of the Adding employee details (onboarding process).....,
// Creator                         : Bandari Divya
// Email                           : bandaridivya1@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : EmployeeDetails,Company -->

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use App\Models\EmpBankDetail;

class AddEmployeeDetails extends Component
{
    use WithFileUploads;

    public $emp_id;
    public $first_name;
    public $last_name;
    public $date_of_birth;
    public $gender;
    public $email;
    public $company_name;
    public $company_email;
    public $mobile_number;
    public $alternate_mobile_number;
    public $address;
    public $city;
    public $state;
    public $postal_code;
    public $country;
    public $hire_date;
    public $employee_type;
    public $department;
    public $job_title;
    public $manager_id;
    public $report_to;

    public $emergency_contact;
    public $password;
    public $image;
    public $blood_group;
    public $nationality;
    public $religion;
    public $marital_status;
    public $spouse;
    public $physically_challenge;
    public $inter_emp;
    public $job_location;
    public $education;
    public $experience;
    public $pan_no;
    public $aadhar_no;
    public $pf_no;
    public $employee_status;

    public $nick_name;
    public $time_zone;
    public $biography;
    public $facebook;
    public $twitter;
    public $linked_in;
    public $company_id;
    public $is_starred;
    public $skill_set;
    public $savedImage;

    public $companies;
    public $hrDetails;
    public $managerIds = [];
    public $managerName;
    public $companyName;
    public $employeeId;
    public $imagePath;
    public $empId;
    public $reportTos, $selectedEmployee, $employee;
    public $selectedId;
    public $companieIds;

    public  $selectedEmployees;


    public function register()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'email' => 'required|email|unique:employee_details',
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email',
            'mobile_number' => 'required|string|max:15',
            'alternate_mobile_number' => 'nullable|string|max:15',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'hire_date' => 'required|date',
            'department' => 'required|string|max:255',
            'company_id' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'inter_emp' => 'required',
            'marital_status' => 'required',
            'employee_type'=>'required',
            'nationality'=>'required',
            'religion'=>'required',
            'blood_group'=>'required',
            'job_location'=>'required'
        ]);

        $imagePath = $this->image->store('employee_image', 'public');
        EmployeeDetails::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'email' => $this->email,
            'company_name' => $this->company_name,
            'company_email' => $this->company_email,
            'mobile_number' => $this->mobile_number,
            'alternate_mobile_number' => $this->alternate_mobile_number,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
            'country' => $this->country,
            'hire_date' => $this->hire_date,
            'employee_type' => $this->employee_type,
            'manager_id' => $this->manager_id,
            'report_to' => $this->report_to,
            'department' => $this->department,
            'job_title' => $this->job_title,
            'employee_status' => $this->employee_status,
            'emergency_contact' => $this->emergency_contact,
            'password' => $this->password,
            'image' => $imagePath, // Example storage for image upload
            'blood_group' => $this->blood_group,
            'nationality' => $this->nationality,
            'religion' => $this->religion,
            'marital_status' => $this->marital_status,
            'spouse' => $this->spouse,
            'physically_challenge' => $this->physically_challenge,
            'inter_emp' => $this->inter_emp,
            'job_location' => $this->job_location,
            'education' => $this->education,
            'experience' => $this->experience,
            'pan_no' => $this->pan_no,
            'aadhar_no' => $this->aadhar_no,
            'pf_no' => $this->pf_no,
            'nick_name' => $this->nick_name,
            'time_zone' => $this->time_zone,
            'biography' => $this->biography,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'linked_in' => $this->linked_in,
            'company_id' => $this->company_id,
            'is_starred' => $this->is_starred,
        ]);


        session()->flash('emp_success', 'Employee registered successfully!');

        // Clear the form fields
        $this->reset();
        return redirect('/update-employee-details');

    }

    public function logout()
    {
        auth()->guard('com')->logout();
        return redirect('/Login&Register');
    }


    public function selectedCompany()
    {
        if ($this->company_id) {
            $this->selectedId = Company::find($this->company_id);
            $this->company_name = $this->selectedId->company_name;
            $this->companyName = $this->company_name;
            $this->selectedEmployees = EmployeeDetails::where('company_id', $this->company_id)->get();
            if ($this->selectedEmployees->isNotEmpty()) {
                foreach ($this->selectedEmployees as $employee) {
                    // Fetch unique manager_ids
                    if (!in_array($employee->manager_id, $this->managerIds)) {
                        $this->managerIds[] = $employee->manager_id;
                    }
                }
            }
        }
    }
    
    public function fetchReportTo()
    {
        // Code to fetch report_to based on the selected manager_id
        if ($this->manager_id) {
            $managerDetails = EmployeeDetails::where('emp_id', $this->manager_id)->first();
    
            if ($managerDetails) {
                $this->managerName = $managerDetails->first_name . ' ' . $managerDetails->last_name;
            } else {
                $this->managerName = null;
            }
        } else {
            $this->managerName = null;
        }
    
        $this->report_to = $this->managerName; // Set report_to property as managerName
    }
    
    
    public function mount()
    {
        // Set default values if the properties are not set
        $this->employee_status = $this->employee_status ?? 'active';
        $this->employee_type = $this->employee_type ?? 'full-time';
        $this->physically_challenge = $this->physically_challenge ?? 'No';
        $this->inter_emp = $this->inter_emp ?? 'no';
        $empId = request()->query('emp_id');

        if ($empId) {
            $this->editEmployee($empId);
        }      
    }
    public function editEmployee($employeeId)
    {
        $employee = EmployeeDetails::find($employeeId);
       
        if ($employee) {
            // Assign fetched employee details to the respective properties
            $this->first_name = $employee->first_name;
            $this->last_name = $employee->last_name;
            $this->date_of_birth = $employee->date_of_birth;
            $this->gender = $employee->gender;
            $this->email = $employee->email;
            $this->company_name = $employee->company_name;
            $this->company_email = $employee->company_email;
            $this->mobile_number = $employee->mobile_number;
            $this->alternate_mobile_number = $employee->alternate_mobile_number;
            $this->address = $employee->address;
            $this->city = $employee->city;
            $this->state = $employee->state;
            $this->postal_code = $employee->postal_code;
            $this->country = $employee->country;
            $this->hire_date = $employee->hire_date;
            $this->employee_type = $employee->employee_type;
            $this->manager_id = $employee->manager_id;
            $this->report_to = $employee->report_to;
            $this->department = $employee->department;
            $this->job_title = $employee->job_title;
            $this->employee_status = $employee->employee_status;
            $this->emergency_contact = $employee->emergency_contact;
            $this->password = $employee->password;
            $this->image = $employee->image;  // Example storage for image upload
            $this->blood_group = $employee->blood_group;
            $this->nationality = $employee->nationality;
            $this->religion = $employee->religion;
            $this->marital_status = $employee->marital_status;
            $this->spouse = $employee->spouse;
            $this->physically_challenge = $employee->physically_challenge;
            $this->inter_emp = $employee->inter_emp;
            $this->job_location = $employee->job_location;
            $this->education = $employee->education;
            $this->experience = $employee->experience;
            $this->pan_no = $employee->pan_no;
            $this->aadhar_no = $employee->adhar_no;
            $this->pf_no = $employee->pf_no;
            $this->nick_name = $employee->nick_name;
            $this->time_zone = $employee->time_zone;
            $this->biography = $employee->biography;
            $this->facebook = $employee->facebook;
            $this->twitter = $employee->twitter;
            $this->linked_in = $employee->linked_in;
            $this->company_id = $employee->company_id;
            $this->is_starred = $employee->is_starred;
            $this->employeeId = $employeeId;
        } 
    }
    public function updateEmployee()
    {
        $employee = EmployeeDetails::find($this->employeeId);
        // Update the employee details
        if ($employee) {
            if ($this->image instanceof \Illuminate\Http\UploadedFile) {
                $imagePath = $this->image->store('employee_image', 'public');
            } else {
                $imagePath = $this->image; // Already a path, use as is
            }
            $employee->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'email' => $this->email,
            'company_name' => $this->company_name,
            'company_email' => $this->company_email,
            'mobile_number' => $this->mobile_number,
            'alternate_mobile_number' => $this->alternate_mobile_number,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
            'country' => $this->country,
            'hire_date' => $this->hire_date,
            'employee_type' => $this->employee_type,
            'manager_id' => $this->manager_id,
            'report_to' => $this->report_to,
            'department' => $this->department,
            'job_title' => $this->job_title,
            'employee_status' => $this->employee_status,
            'emergency_contact' => $this->emergency_contact,
            'password' => $this->password,
            'image' => $imagePath,
            'blood_group' => $this->blood_group,
            'nationality' => $this->nationality,
            'religion' => $this->religion,
            'marital_status' => $this->marital_status,
            'spouse' => $this->spouse,
            'physically_challenge' => $this->physically_challenge,
            'inter_emp' => $this->inter_emp,
            'job_location' => $this->job_location,
            'education' => $this->education,
            'experience' => $this->experience,
            'pan_no' => $this->pan_no,
            'aadhar_no' => $this->aadhar_no,
            'pf_no' => $this->pf_no,
            'nick_name' => $this->nick_name,
            'time_zone' => $this->time_zone,
            'biography' => $this->biography,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'linked_in' => $this->linked_in,
            'company_id' => $this->company_id,
            'is_starred' => $this->is_starred,
        ]);
            // Show success message
            session()->flash('emp_success', 'Employee updated successfully!');

            // Redirect to the employee list or any other desired route
            return redirect('/update-employee-details');
        }
    }
    
    public function render()
    {

        $hrEmail = auth()->guard('hr')->user()->company_id;
        $this->companieIds = Company::where('company_id', $hrEmail)->get();
        $hrEmail = auth()->guard('hr')->user()->company_id;
        $hrCompanies = Company::where('company_id', $hrEmail)->get();
        $hrDetails = Company::where('company_id', $hrEmail)->first();
        $this->companies = $hrCompanies;
        $this->hrDetails = $hrDetails;
        return view('livewire.add-employee-details',[
            'managerName' => $this->managerName,
            'companyName' => $this->company_name,
        ]);
    }
 
}