<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserProfile extends Component
{
    use WithFileUploads;
    public $userDetails;
    public $fullName;
    public $profileImage;
    public $address;
    public $experienceStatus;
    public $availableToJoin;
    public $mobileNo;
    public $email;
    public $educationEntries = [];
    public $editing = false;
    public $selectedEntryIndex = null;

    public $editProfile = false;
    public function editProfileDetails()
    {
        $this->profileImage = $this->userDetails->image;
        $this->fullName = $this->userDetails->full_name;
        $this->address = $this->userDetails->address;
        $this->experienceStatus = $this->userDetails->experience_status;
        $this->availableToJoin = $this->userDetails->available_to_join;
        $this->mobileNo = $this->userDetails->mobile_no;
        $this->email = $this->userDetails->email;
        $this->editProfile = true;
    }
    public function cancelProfileDetails()
    {
        $this->editProfile = false;
    }

    public $editProfileSummary = false;
    public $profileSummary;
    public function cancelProfileSummary()
    {
        $this->editProfileSummary = false;
    }
    public function editProfileSummaryDetails()
    {
        $this->profileSummary = $this->userDetails->profile_summary;
        $this->editProfileSummary = true;
    }
    public function saveProfileSummary()
    {
        $user_id = auth()->guard('web')->user()->user_id;
        $this->userDetails = User::where('user_id', $user_id)->first();
        $this->userDetails->profile_summary = $this->profileSummary;
        $this->userDetails->update();
        $this->editProfileSummary = false;
    }

    public $editContactDetails = false;
    public $city;
    public $state;
    public $country;
    public function cancelContactInfo()
    {
        $this->editContactDetails = false;
    }
    public function editContactInfo()
    {
        $this->city = $this->userDetails->city;
        $this->state = $this->userDetails->state;
        $this->country = $this->userDetails->country;
        $this->email = $this->userDetails->email;
        $this->mobileNo = $this->userDetails->mobile_no;
        $this->editContactDetails = true;
    }
    public function saveContactInfo()
    {
        $user_id = auth()->guard('web')->user()->user_id;
        $this->userDetails = User::where('user_id', $user_id)->first();
        $this->userDetails->city = $this->city;
        $this->userDetails->state = $this->state;
        $this->userDetails->country = $this->country;
        $this->userDetails->email = $this->email;
        $this->userDetails->mobile_no = $this->mobileNo;
        $this->userDetails->update();
        $this->editContactDetails = false;
    }


    public $editCareerProfile = false;
    public $currentIndustry;
    public $roleCategory;
    public $desiredJobType;
    public $preferredShift;
    public $expectedSalary;
    public $department;
    public $jobRole;
    public $desiredEmploymentType;
    public $preferredWorkLocation;
    public function cancelCareerProfileDetails()
    {
        $this->editCareerProfile = false;
    }
    public function editCareerProfileDetails()
    {
        $this->currentIndustry = $this->userDetails->current_industry;
        $this->roleCategory = $this->userDetails->role_category;
        $this->desiredJobType = $this->userDetails->desired_job_type;
        $this->preferredShift = $this->userDetails->preferred_shift;
        $this->expectedSalary = $this->userDetails->expected_salary;
        $this->department = $this->userDetails->department;
        $this->jobRole = $this->userDetails->job_role;
        $this->desiredEmploymentType = $this->userDetails->desired_employment_type;
        $this->preferredWorkLocation = $this->userDetails->preferred_work_location;
        $this->editCareerProfile = true;
    }
    public function saveCareerProfileDetails()
    {
        $user_id = auth()->guard('web')->user()->user_id;
        $this->userDetails = User::where('user_id', $user_id)->first();
        $this->userDetails->current_industry = $this->currentIndustry;
        $this->userDetails->role_category = $this->roleCategory;
        $this->userDetails->desired_job_type = $this->desiredJobType;
        $this->userDetails->preferred_shift = $this->preferredShift;
        $this->userDetails->expected_salary = $this->expectedSalary;
        $this->userDetails->department = $this->department;
        $this->userDetails->job_role = $this->jobRole;
        $this->userDetails->desired_employment_type = $this->desiredEmploymentType;
        $this->userDetails->preferred_work_location = $this->preferredWorkLocation;
        $this->userDetails->update();
        $this->editCareerProfile = false;
    }



    public $editPersonalInfo = false;
    public $dateOfBirth;
    public $religion;
    public $differentlyAbled;
    public $careerBreak;

    public function cancelPersonalDetails()
    {
        $this->editPersonalInfo = false;
    }
    public function editPersonalDetails()
    {
        $this->dateOfBirth = $this->userDetails->date_of_birth;
        $this->religion = $this->userDetails->religion;
        $this->differentlyAbled = $this->userDetails->differently_abled;
        $this->careerBreak = $this->userDetails->career_break;
        $this->address = $this->userDetails->address;
        $this->editPersonalInfo = true;
    }
    public function savePersonalDetails()
    {
        $user_id = auth()->guard('web')->user()->user_id;
        $this->userDetails = User::where('user_id', $user_id)->first();
        $this->userDetails->date_of_birth = $this->dateOfBirth;
        $this->userDetails->religion = $this->religion;
        $this->userDetails->differently_abled = $this->differentlyAbled;
        $this->userDetails->career_break = $this->careerBreak;
        $this->userDetails->address = $this->address;
        $this->userDetails->update();
        $this->editPersonalInfo = false;
    }
    public $imagePath;
    public function saveProfileDetails()
    {
        if ($this->profileImage) {
            $this->imagePath = $this->profileImage->store('images', 'public');
        }

        $user_id = auth()->guard('web')->user()->user_id;
        $this->userDetails = User::where('user_id', $user_id)->first();
        $this->userDetails->full_name = $this->fullName;
        $this->userDetails->image = $this->imagePath;
        $this->userDetails->address = $this->address;
        $this->userDetails->experience_status = $this->experienceStatus;
        $this->userDetails->available_to_join = $this->availableToJoin;
        $this->userDetails->mobile_no = $this->mobileNo;
        $this->userDetails->email = $this->email;
        $this->userDetails->created_at = now();
        $this->userDetails->update();
        $this->editProfile = false;
    }
    public $technicalEntries = [];
    public $editingTechnical = false;
    public $selectedTechnicalIndex = null;
    public function loadTechnicalData()
    {
        $this->userDetails = User::where('user_id', auth()->guard('web')->user()->user_id)->first();

        $this->technicalEntries = $this->userDetails->technical_skills ?? [];
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/emplogin');
    }

    public function editTechnical($index)
    {
        $this->selectedTechnicalIndex = $index;
        $this->editingTechnical = true;
    }

    public function cancelTechnical()
    {
        $this->editingTechnical = false;
    }

    public function addTechnical()
    {

        $this->technicalEntries[] = [
            'skills' => '',
        ];
        $this->selectedTechnicalIndex = count($this->technicalEntries) - 1;
        $this->editingTechnical = true;
    }

    public function loadEducationData()
    {
        $this->userDetails = User::where('user_id', auth()->guard('web')->user()->user_id)->first();

        $this->educationEntries = $this->userDetails->education ?? [];
    }

    public function editEntry($index)
    {
        $this->selectedEntryIndex = $index;
        $this->editing = true;
    }

    public function cancelEntry()
    {
        $this->editing = false;
    }

    public function addEntry()
    {

        $this->educationEntries[] = [
            'degree' => '',
            'university' => '',
            'graduation_year' => '',
        ];
        $this->selectedEntryIndex = count($this->educationEntries) - 1;
        $this->editing = true;
    }

    public function saveTechnical()
    {
        $this->validate([
            'technicalEntries' => "array|min:1",
        ]);
        $user_id = auth()->guard('web')->user()->user_id;
        $this->userDetails = User::where('user_id', $user_id)->first();
        $this->userDetails->technical_skills = $this->technicalEntries;
        $this->userDetails->save();

        $this->editingTechnical = false;
    }

    public function deleteTechnical($index)
    {
        if (is_array($this->technicalEntries)) {
            unset($this->technicalEntries[$index]);

            $this->technicalEntries = array_values($this->technicalEntries);
        }

        $this->userDetails->technical_skills = $this->technicalEntries;
        $this->userDetails->save();
    }


    public function removeEntry($index)
    {
        if (is_array($this->educationEntries)) {
            unset($this->educationEntries[$index]);

            $this->educationEntries = array_values($this->educationEntries);
        }

        $this->userDetails->education = $this->educationEntries;
        $this->userDetails->save();
    }

    public function removeLanguage($index)
    {
        if (is_array($this->languageEntries)) {
            unset($this->languageEntries[$index]);

            $this->languageEntries = array_values($this->languageEntries);
        }

        $this->userDetails->languages = $this->languageEntries;
        $this->userDetails->save();
    }

    public function saveEducation()
    {
        $this->validate([
            'educationEntries' => "array|min:1",
        ]);
        $user_id = auth()->guard('web')->user()->user_id;
        $this->userDetails = User::where('user_id', $user_id)->first();
        $this->userDetails->education = $this->educationEntries;
        $this->userDetails->save();

        $this->editing = false;
    }





    public $languageEntries = [];

    public $editingLanguage = false;
    public $selectedLanguageIndex = null;

    public function cancelLanguage()
    {
        $this->editingLanguage = false;
    }
    public function loadLanguagesData()
    {
        $this->userDetails = User::where('user_id', auth()->guard('web')->user()->user_id)->first();

        $this->languageEntries = $this->userDetails->languages ?? [];
    }

    public function editLanguage($index)
    {
        $this->selectedLanguageIndex = $index;
        $this->editingLanguage = true;
    }
    public function addLanguage()
    {

        $this->languageEntries[] = [
            'language' => '',
            'proficiency' => '',
        ];
        $this->selectedLanguageIndex = count($this->languageEntries) - 1;
        $this->editingLanguage = true;
    }

    public function saveLanguage()
    {
        $this->validate([
            'languageEntries' => "array|min:1",
        ]);
        $user_id = auth()->guard('web')->user()->user_id;
        $this->userDetails = User::where('user_id', $user_id)->first();
        $this->userDetails->languages = $this->languageEntries;
        $this->userDetails->save();

        $this->editingLanguage = false;
    }
    public $user;
    public function render()
    {
        $this->user = auth()->user();

        $this->loadEducationData();
        $this->loadLanguagesData();
        $this->loadTechnicalData();
        $this->userDetails = User::where('user_id', auth()->guard('web')->user()->user_id)->first();
        return view('livewire.user-profile');
    }
}
