<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use Livewire\Component;

use Livewire\WithFileUploads;

use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use App\Models\EmpBankDetail;
use App\Models\Job;

class EmpUpdate extends Component
{
    use WithFileUploads;
    public $companieIds, $managerIds;
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
    public $empId;
    public $selectedId;
    public $reportTos, $selectedEmployees, $selectedEmployee;
    public function mount($empId)
    {

        $this->selectedEmployee = EmployeeDetails::find($empId);
        if ($this->selectedEmployee) {
            $this->first_name = $this->selectedEmployee->first_name;
            $this->last_name = $this->selectedEmployee->last_name;
            $this->date_of_birth = $this->selectedEmployee->date_of_birth;
            $this->gender = $this->selectedEmployee->gender;
            $this->email = $this->selectedEmployee->email;
            $this->company_name = $this->selectedEmployee->company_name;
            $this->company_email = $this->selectedEmployee->company_email;
            $this->mobile_number = $this->selectedEmployee->mobile_number;
            $this->alternate_mobile_number = $this->selectedEmployee->alternate_mobile_number;
            $this->address = $this->selectedEmployee->address;
            $this->city = $this->selectedEmployee->city;
            $this->state = $this->selectedEmployee->state;
            $this->postal_code = $this->selectedEmployee->postal_code;
            $this->country = $this->selectedEmployee->country;
            $this->hire_date = $this->selectedEmployee->hire_date;
            $this->employee_type = $this->selectedEmployee->employee_type;
            $this->manager_id = $this->selectedEmployee->manager_id;
            $this->report_to = $this->selectedEmployee->report_to;
            $this->department = $this->selectedEmployee->department;
            $this->job_title = $this->selectedEmployee->job_title;
            $this->employee_status = $this->selectedEmployee->employee_status;
            $this->emergency_contact = $this->selectedEmployee->emergency_contact;
            $this->password = $this->selectedEmployee->password;
            $this->image =  $this->selectedEmployee->image; // Example storage for image upload
            $this->blood_group = $this->selectedEmployee->blood_group;
            $this->nationality = $this->selectedEmployee->nationality;
            $this->religion = $this->selectedEmployee->religion;
            $this->marital_status = $this->selectedEmployee->marital_status;
            $this->spouse = $this->selectedEmployee->spouse;
            $this->physically_challenge = $this->selectedEmployee->physically_challenge;
            $this->inter_emp = $this->selectedEmployee->inter_emp;
            $this->job_location = $this->selectedEmployee->job_location;
            $this->education = $this->selectedEmployee->education;
            $this->experience = $this->selectedEmployee->experience;
            $this->pan_no = $this->selectedEmployee->pan_no;
            $this->aadhar_no = $this->selectedEmployee->adhar_no;
            $this->pf_no = $this->selectedEmployee->pf_no;
            $this->nick_name = $this->selectedEmployee->nick_name;
            $this->time_zone = $this->selectedEmployee->time_zone;
            $this->biography = $this->selectedEmployee->biography;
            $this->facebook = $this->selectedEmployee->facebook;
            $this->twitter = $this->selectedEmployee->twitter;
            $this->linked_in = $this->selectedEmployee->linked_in;
            $this->company_id = $this->selectedEmployee->company_id;
            $this->is_starred = $this->selectedEmployee->is_starred;
            $this->skill_set = $this->selectedEmployee->skill_set;
        }
    }
    public function logout()
    {
        auth()->guard('com')->logout();
        return redirect('/Login&Register');
    }
    public $imagePath;
    public function update()
    {


        if ($this->image && is_object($this->image)) {
            // Assuming $this->image is an instance of a class that handles file uploads
            $this->imagePath = $this->image->store('employee_image', 'public');
        } else {
            // If no new image is provided or $this->image is not an object, retain the existing image path
            $this->imagePath = $this->selectedEmployee->image;
        }

        if ($this->selectedEmployee) {

            $this->selectedEmployee->update([
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
                'image' => $this->imagePath ?? $this->selectedEmployee->image,
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
                'skill_set' => $this->skill_set,
            ]);
        }


        session()->flash('emp_success', 'Employee data updated successfully!');

        // Clear the form fields
        $this->reset();
        return redirect('/emplist');
    }





    public function selectedCompany()
    {
        if ($this->company_id) {
            $this->selectedId = Company::find($this->company_id);
            $this->company_name = $this->selectedId->company_name;
            $this->selectedEmployees = EmployeeDetails::where('company_id', $this->company_id)->first();
            if ($this->selectedEmployees->emp_id != null) {
                $this->managerIds = EmployeeDetails::where('emp_id', $this->selectedEmployees->emp_id)->get();
            }
            if ($this->manager_id != null) {
                $this->reportTos = EmployeeDetails::where('emp_id', $this->manager_id)->first();
                $this->report_to = $this->reportTos->first_name . ' ' . $this->reportTos->last_name . ' ' . $this->reportTos->emp_id;
            }
        }
    }

    public function render()
    {
        $hrEmail = auth()->guard('com')->user()->contact_email;
        $this->companieIds = Company::where('contact_email', $hrEmail)->get();

        $hrEmail = auth()->guard('com')->user()->contact_email;
        $hrCompanies = Company::where('contact_email', $hrEmail)->get();
        $hrDetails = Company::where('contact_email', $hrEmail)->first();
        $this->companies = $hrCompanies;
        $this->hrDetails = $hrDetails;
        return view('livewire.emp-update');
    }
}
