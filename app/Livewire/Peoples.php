<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\StarredPeople;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Services\GoogleDriveService;
use Illuminate\Support\Facades\Log;
use App\Helpers\FlashMessageHelper;

class Peoples extends Component
{
    public $searchTerm = '';
    public $searchValue = '';
    public $peoples;
    public $selectedPerson = null;
    public $selectedMyTeamPerson = null;
    public $starredPerson = null;
    public $filteredPeoples;
    public $filteredMyTeamPeoples;
    public $activeTab = 'starred';
    public $peopleFound = true;
    public $employeeDetails;

    public function setActiveTab($tab)
    {
        
        if ($tab === 'starred') {
            $this->activeTab = 'starred';
        } elseif ($tab === 'myteam') {
            $this->activeTab = 'myteam';
            $this->selectedPerson=null;
        }else{
            $this->activeTab = 'everyone';
            $this->selectedPerson=null;
        }
    }

    public function selectPerson($empId)
    {
        try {
            $this->selectedPerson = EmployeeDetails::where('emp_id', $empId)->first();
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('An error occurred while creating the request. Please try again.');
        }
    }
    public function selectMyTeamPerson($empId)
    {
        try {
            $this->selectedMyTeamPerson = EmployeeDetails::where('emp_id', $empId)->first();
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('An error occurred while creating the request. Please try again.');            
        }
    }

    public $selectStarredPeoples;

    public function starredPersonById($id)
    {
        try {
            $this->selectStarredPeoples = StarredPeople::with('emp')->where('id', $id)->first();
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('An error occurred while creating the request. Please try again.');
        }
    }

    public function filter()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;

            // Fetch the company_ids for the logged-in employee
            $companyIds = EmployeeDetails::where('emp_id', $employeeId)->value('company_id');

            // Check if companyIds is an array; decode if it's a JSON string
            $companyIdsArray = is_array($companyIds) ? $companyIds : json_decode($companyIds, true);
            $trimmedSearchTerm = trim($this->searchTerm);

                $this->filteredPeoples = EmployeeDetails::where(function($query) use ($companyIdsArray) {
                    foreach ($companyIdsArray as $companyId) {
                        $query->orWhereJsonContains('company_id', $companyId);
                    }
                })
                    ->where(function ($query) use ($trimmedSearchTerm) {
                        $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $trimmedSearchTerm . '%'])
                            ->orWhere('emp_id', 'LIKE', '%' . $trimmedSearchTerm . '%');
                    })
                    ->orderByRaw("CONCAT(first_name, ' ', last_name)")
                    ->get();


            $this->peopleFound = count($this->filteredPeoples) > 0;
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('An error occurred while creating the request. Please try again.');
        }
    }
    public function filterMyTeam()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;

            // Fetch the company_ids for the logged-in employee
            $companyIds = EmployeeDetails::where('emp_id', $employeeId)->value('company_id');

            // Check if companyIds is an array; decode if it's a JSON string
            $companyIdsArray = is_array($companyIds) ? $companyIds : json_decode($companyIds, true);
            $trimmedSearchTerm = trim($this->searchValue);
            $managerId = EmployeeDetails::where('emp_id', $employeeId)->value('manager_id');
            // Loop through each company ID and find employees


                $this->filteredMyTeamPeoples = EmployeeDetails::with('starredPeople')
                    ->where(function($query) use ($companyIdsArray) {
                        foreach ($companyIdsArray as $companyId) {
                            $query->orWhereJsonContains('company_id', $companyId);
                        }
                    })
                    ->where('manager_id', $employeeId)
                    ->where(function ($query) use ($trimmedSearchTerm) {
                        $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $trimmedSearchTerm . '%'])
                            ->orWhere('emp_id', 'LIKE', '%' . $trimmedSearchTerm . '%');
                    })
                    ->orderByRaw("CONCAT(first_name, ' ', last_name)")
                    ->get();


            $this->peopleFound = count($this->filteredMyTeamPeoples) > 0;
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('An error occurred while creating the request. Please try again.');
        }
    }

    public $search;
    public $filteredStarredPeoples;

    public function starredFilter()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $companyIds = EmployeeDetails::where('emp_id', $employeeId)->value('company_id');
            $companyIdsArray = is_array($companyIds) ? $companyIds : json_decode($companyIds, true);
            $trimmedSearchTerm = trim($this->search);


                $this->filteredStarredPeoples = StarredPeople::where(function($query) use ($companyIdsArray) {
                    foreach ($companyIdsArray as $companyId) {
                        $query->orWhereJsonContains('company_id', $companyId);
                    }
                })
                    ->where('emp_id', $employeeId)
                    ->where(function ($query) use ($trimmedSearchTerm) {
                        $query->where('name', 'LIKE', '%' . $trimmedSearchTerm . '%')
                            ->orWhere('people_id', 'LIKE', '%' . $trimmedSearchTerm . '%');
                    })
                    ->get();


            $this->peopleFound = count($this->filteredStarredPeoples) > 0;
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('An error occurred while creating the request. Please try again.');
        }
    }

    public $employee;
    
    public function toggleStar($employeeId)
{
    try {
        
        $this->employee = EmployeeDetails::with('empPersonalInfo')->find($employeeId);
        
        if ($this->employee) {
            
            if ($this->employee->employee_status === 'terminated' || $this->employee->employee_status === 'resigned') {
                // Flash error message and prevent starring
                FlashMessageHelper::flashError('You cannot star this employee as they have been terminated or resigned.');
                return; // Exit the function early if the status is terminated or resigned
            }

            $this->starredPerson = StarredPeople::where('people_id', $employeeId)
                ->where('starred_status', 'starred')
                ->where('emp_id', auth()->guard('emp')->user()->emp_id)
                ->first();

            if ($this->starredPerson) {
                $this->starredPerson->delete();
                FlashMessageHelper::flashSuccess('Star removed successfully!'); 
            } else {
                $employeeId = auth()->guard('emp')->user()->emp_id;
                $this->employeeDetails = EmployeeDetails::find($employeeId);
                try {
                    $category = $this->employee->job_role ?? '';
                    $joiningDate = $this->employee->hire_date ? \Carbon\Carbon::parse($this->employee->hire_date)->format('Y-m-d H:i:s') : null;
                    $dateOfBirth = $this->employee->empPersonalInfo ? \Carbon\Carbon::parse($this->employee->empPersonalInfo->date_of_birth)->format('Y-m-d H:i:s') : null;

                    
                    $this->starredPerson = StarredPeople::create([
                        'people_id' => $this->employee->emp_id,
                        'emp_id' => $this->employeeDetails->emp_id,
                        'company_id' => is_array($this->employee->company_id) ? json_encode($this->employee->company_id) : $this->employee->company_id,
                        'name' => $this->employee->first_name . ' ' . $this->employee->last_name ?? '',
                        'profile' => $this->employee->image ?? 'null',
                        'contact_details' => $this->employee->emergency_contact ?? '',
                        'category' => $category,
                        'location' => $this->employee->job_location ?? '',
                        'joining_date' => $joiningDate,
                        'date_of_birth' => $dateOfBirth,
                        'starred_status' => 'starred'
                    ]);
                    FlashMessageHelper::flashSuccess('Star Added successfully!');
                    // $this->activeTab = 'starred';
                } catch (\Exception $e) {
                    FlashMessageHelper::flashError('An error occurred while creating the request. Please try again.');
                    $this->addError('duplicate', 'You have already starred this person.');
                }
            }
            $currentTab = $this->activeTab;
            $this->reset();
            $this->activeTab = $currentTab;
        } 
        
        // return redirect()->to('/PeoplesList');
    } catch (\Exception $e) {
        // Log::error("An error occurred: " . $e->getMessage());
        FlashMessageHelper::flashError('An error occurred while creating the request. Please try again.');
    }
}

    public function removeToggleStar($personId)
    {
        try {
            $starredPerson = StarredPeople::where('people_id', $personId)
                ->where('emp_id', auth()->guard('emp')->user()->emp_id)
                ->first();

            if ($starredPerson) {
                $starredPerson->delete();
            
            $this->selectStarredPeoples = null; // or select a default person
            FlashMessageHelper::flashSuccess('Star removed successfully!');
        } else {
            FlashMessageHelper::flashError('Person not found in your starred list!');
        }

            // return redirect('/PeoplesList');
        } catch (\Exception $e) {
           
            FlashMessageHelper::flashError('An error occurred while creating the request. Please try again.');
        }
    }

    public $starredPeoples;
    public $starredList;
    public $starredfirst;
    public $myTeam;

    public function render()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;

            // Fetch the company_ids for the logged-in employee
            $companyIds = EmployeeDetails::where('emp_id', $employeeId)->value('company_id');

            // Check if companyIds is an array; decode if it's a JSON string
            $companyIdsArray = is_array($companyIds) ? $companyIds : json_decode($companyIds, true);


                $this->peoples = EmployeeDetails::with('starredPeople')->where(function($query) use ($companyIdsArray) {
                    foreach ($companyIdsArray as $companyId) {
                        $query->orWhereJsonContains('company_id', $companyId);
                    }
                })
                    ->orderBy('first_name')
                    ->orderBy('last_name')
                    ->get();




            $managerId = EmployeeDetails::where('emp_id', $employeeId)->value('manager_id');


                $this->myTeam = EmployeeDetails::with('starredPeople')
                    ->where(function($query) use ($companyIdsArray) {
                        foreach ($companyIdsArray as $companyId) {
                            $query->orWhereJsonContains('company_id', $companyId);
                        }
                    })
                    ->where('manager_id', $employeeId)
                    ->orderBy('first_name')
                    ->orderBy('last_name')
                    ->get();


            $this->starredList = StarredPeople::with('emp')->where('emp_id', $employeeId)->orderBy('created_at', 'desc')->get();

            $peopleData = $this->filteredPeoples ?: $this->peoples;
            $myTeamData = $this->filteredMyTeamPeoples ?: $this->myTeam;
            $this->starredPeoples = $this->filteredStarredPeoples ?: $this->starredList;

            return view('livewire.peoples', [
                'peopleData' => $peopleData,
                'myTeamData' => $myTeamData,
            ]);
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('An error occurred while creating the request. Please try again.');
            return false;
        }
    }
}
