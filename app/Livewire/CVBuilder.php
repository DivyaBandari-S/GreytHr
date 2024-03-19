<?php

namespace App\Livewire;

use App\Models\CVEntrie;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class CVBuilder extends Component
{
    use WithFileUploads;

    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $country;
    public $city;
    public $address;
    public $date_of_birth;
    public $image;
    public $technical_skills;
    public $summary;
    public $languages;
    public $educationEntries = [];
    public $workExperienceEntries = [];
    public $userDetails;

    public function addEducation()
    {
        $this->educationEntries[] = [
            'degree' => '',
            'university' => '',
            'graduation_year' => '',
        ];
    }
    public function removeEducation($index)
    {
        unset($this->educationEntries[$index]);
        $this->educationEntries = array_values($this->educationEntries);
    }

    public function addWorkExperience()
    {
        $this->workExperienceEntries[] = [
            'job_title' => '',
            'company' => '',
            'start_date' => '',
            'end_date' => '',
        ];
    }

    public function removeWorkExperience($index)
    {
        unset($this->workExperienceEntries[$index]);
        $this->workExperienceEntries = array_values($this->workExperienceEntries);
    }

    public function preview()
    {
        $this->validate([
            'first_name' => 'required|min:6',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'country' => 'required',
            'city' => 'required',
            'address' => 'required',
            'date_of_birth' => ['required', 'date', function ($attribute, $value, $fail) {
                $birthdate = \Carbon\Carbon::parse($value); // Parse the date of birth using the Carbon library
                $currentDate = \Carbon\Carbon::now(); // Get the current date

                $age = $birthdate->diffInYears($currentDate); // Calculate the age

                if ($age < 19) {
                    $fail("You must be at least 19 years old to proceed.");
                }
            }],
            'image' => 'nullable|image',
            'educationEntries' => 'array|min:1',
            'workExperienceEntries' => 'array|min:1',
            'technical_skills' => 'required',
            'summary' => 'required',
            'languages' => 'required',
        ]);
    }


    public function submit()
    {
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'country' => 'required',
            'city' => 'required',
            'address' => 'required',
            'date_of_birth' => ['required', 'date', function ($attribute, $value, $fail) {
                $birthdate = \Carbon\Carbon::parse($value);
                $currentDate = \Carbon\Carbon::now();
                $age = $birthdate->diffInYears($currentDate);
                if ($age < 19) {
                    $fail("You must be at least 19 years old to proceed.");
                }
            }],
            'image' => 'nullable|image',
            'educationEntries' => 'array|min:1',
            'workExperienceEntries' => 'array|min:1',
            'technical_skills' => 'required',
            'summary' => 'required',
            'languages' => 'required',
        ]);

        CVEntrie::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'country' => $this->country,
            'city' => $this->city,
            'address' => $this->address,
            'date_of_birth' => $this->date_of_birth,
            'image' => $this->image->store('images'),
            'technical_skills' => $this->technical_skills,
            'summary' => $this->summary,
            'languages' => $this->languages,
            'education' => $this->educationEntries,
            'work_experience' => $this->workExperienceEntries,
        ]);

        session()->flash('message', 'CV created successfully.');
        $this->reset();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/emplogin');
    }
    public $user;
    public function render()
    {
        $this->user = auth()->user();

        return view('livewire.c-v-builder');
    }
}
