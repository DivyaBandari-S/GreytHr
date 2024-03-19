<?php

namespace App\Livewire;

use App\Models\AppliedJob;
use App\Models\Company;
use App\Models\Job;
use Livewire\Component;

class PostJobs extends Component
{
    public $title;
    public $description;
    public $location;
    public $salary;
    public $company_name;
    public $employment_type;
    public $expire_date;
    public $vacancies;
    public $education_requirement;
    public $experience_requirement;
    public $skills_required;
    public $is_featured = false;
    public $is_active = true;
    public $application_link;
    public $job_type = 'Full-time';
    public $responsibilities;
    public $benefits;
    public $application_instructions;
    public $company_details;
    public $job_id;
    public $company_id;
    public $companies;

    public $companyDetails;
    public function submitJob()
    {

        $this->validate([
            'company_id' => 'required',
            'company_name' => 'required',
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'salary' => 'required',
            'expire_date' => 'required',
            'education_requirement' => 'required',
            'experience_requirement' => 'required',
            'vacancies' => 'required',
            'skills_required' => 'required',
            'job_type' => 'required',
            'is_active' => 'required',
            'is_featured' => 'required'
        ]);

        $company_id = auth()->guard('com')->user()->company_id;
        $this->companyDetails = Company::where('company_id', $company_id)->first();

        Job::create([
            'company_id' => $this->company_id,
            'contact_email' => $this->companyDetails->contact_email,
            'hr_name' => $this->companyDetails->hr_name,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'salary' => $this->salary,
            'company_name' => $this->company_name,
            'expire_date' => $this->expire_date,
            'contact_phone' => $this->companyDetails->contact_phone,
            'vacancies' => $this->vacancies,
            'education_requirement' => $this->education_requirement,
            'experience_requirement' => $this->experience_requirement,
            'skills_required' => $this->skills_required,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
            'application_link' => $this->application_link,
            'job_type' => $this->job_type,
            'responsibilities' => $this->responsibilities,
            'benefits' => $this->benefits,
            'application_instructions' => $this->application_instructions,
        ]);

        session()->flash('success', "Job Posted Successfully!");

        $this->reset();
    }

    public function logout()
    {
        auth()->guard('com')->logout();
        return redirect('/Login&Register');
    }
    public function selectedCompanyId()
    {
        $selectedCompany = $this->companies->firstWhere('company_id', $this->company_id);
        $this->company_name = $selectedCompany ? $selectedCompany->company_name : null;
    }
    public $hrDetails;
    public $appliedJobs;
    public function render()
    {
        $hrEmail = auth()->guard('com')->user()->contact_email;
        $hrCompanies = Company::where('contact_email', $hrEmail)->get();
        $hrDetails = Company::where('contact_email', $hrEmail)->first();
        $this->companies = $hrCompanies;
        $this->hrDetails = $hrDetails;
     
        return view('livewire.post-jobs');
    }
}
