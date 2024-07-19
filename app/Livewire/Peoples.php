<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\StarredPeople;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Services\GoogleDriveService;
use Illuminate\Support\Facades\Log;

class Peoples extends Component
{
    public $searchTerm = '';
    public $peoples;
    public $selectedPerson = null;
    public $selectedMyTeamPerson = null;
    public $starredPerson = null;
    public $filteredPeoples;
    public $filteredMyTeamPeoples;
    public $activeTab = 'starred';
    public $peopleFound = true;
    public $employeeDetails;
    
    public function selectPerson($empId)
    {
        try {
            $this->selectedPerson = EmployeeDetails::where('emp_id', $empId)->first();
        } catch (\Exception $e) {
            Log::error('Error in selectPerson method: ' . $e->getMessage());
        }
    }
    public function selectMyTeamPerson($empId)
    {
        try {
            $this->selectedMyTeamPerson = EmployeeDetails::where('emp_id', $empId)->first();
        } catch (\Exception $e) {
            Log::error('Error in selectPerson method: ' . $e->getMessage());
        }
    }
    
    public $selectStarredPeoples;
    
    public function starredPersonById($id)
    {
        try {
            $this->selectStarredPeoples = StarredPeople::with('emp')->where('id', $id)->first();
        } catch (\Exception $e) {
            Log::error('Error in starredPersonById method: ' . $e->getMessage());
        }
    }
    
    public function filter()
    {
        try {
            $companyId = Auth::user()->company_id;
            $trimmedSearchTerm = trim($this->searchTerm);
    
            $this->filteredPeoples = EmployeeDetails::where('company_id', $companyId)
                ->where(function ($query) use ($trimmedSearchTerm) {
                    $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $trimmedSearchTerm . '%'])
                        ->orWhere('emp_id', 'LIKE', '%' . $trimmedSearchTerm . '%');
                })
                ->orderByRaw("CONCAT(first_name, ' ', last_name)")
                ->get();
    
            $this->peopleFound = count($this->filteredPeoples) > 0;
        } catch (\Exception $e) {
            Log::error('Error in filter method: ' . $e->getMessage());
        }
    }
    public function filterMyTeam()
    {
        try {
            $companyId = Auth::user()->company_id;
            $trimmedSearchTerm = trim($this->searchTerm);
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $managerId = EmployeeDetails::where('emp_id', $employeeId)->value('manager_id');
    
            $this->filteredMyTeamPeoples = EmployeeDetails::with('starredPeople')
            ->where('company_id', $companyId)
            ->where('manager_id', $managerId)
            ->where('employee_status', 'active')
                ->where(function ($query) use ($trimmedSearchTerm) {
                    $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $trimmedSearchTerm . '%'])
                        ->orWhere('emp_id', 'LIKE', '%' . $trimmedSearchTerm . '%');
                })
                ->orderByRaw("CONCAT(first_name, ' ', last_name)")
                ->get();
    
            $this->peopleFound = count($this->filteredMyTeamPeoples) > 0;
        } catch (\Exception $e) {
            Log::error('Error in filter method: ' . $e->getMessage());
        }
    }
    
    public $search;
    public $filteredStarredPeoples;
    
    public function starredFilter()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $companyId = Auth::user()->company_id;
            $trimmedSearchTerm = trim($this->search);
    
            $this->filteredStarredPeoples = StarredPeople::where('company_id', $companyId)
            ->where('emp_id', $employeeId)
                ->where(function ($query) use ($trimmedSearchTerm) {
                    $query->where('name', 'LIKE', '%' . $trimmedSearchTerm . '%')
                        ->orWhere('people_id', 'LIKE', '%' . $trimmedSearchTerm . '%');
                })
                ->get();
    
            $this->peopleFound = count($this->filteredStarredPeoples) > 0;
        } catch (\Exception $e) {
            Log::error('Error in starredFilter method: ' . $e->getMessage());
        }
    }
    
    public $employee;
    
    public function toggleStar($employeeId)
    {
        try {
            $this->employee = EmployeeDetails::find($employeeId);
            if ($this->employee) {
                $this->starredPerson = StarredPeople::where('people_id', $employeeId)
                    ->where('starred_status', 'starred')
                    ->where('emp_id', auth()->guard('emp')->user()->emp_id)
                    ->first();
                if ($this->starredPerson) {
                    $this->starredPerson->delete();
                } else {
                    $employeeId = auth()->guard('emp')->user()->emp_id;
                    $this->employeeDetails = EmployeeDetails::find($employeeId);
                    try {
                        StarredPeople::create([
                            'people_id' => $this->employee->emp_id,
                            'emp_id' => $this->employeeDetails->emp_id,
                            'company_id' => $this->employeeDetails->company_id,
                            'name' => $this->employee->first_name . ' ' . $this->employee->last_name,
                            'profile' => $this->employee->image,
                            'contact_details' => $this->employee->mobile_number,
                            'category' => $this->employee->job_title,
                            'location' => $this->employee->job_location,
                            'joining_date' => $this->employee->hire_date,
                            'date_of_birth' => $this->employee->date_of_birth,
                            'starred_status' => 'starred'
                        ]);
                    } catch (\Exception $e) {
                        $this->addError('duplicate', 'You have already starred this people.');
                    }
                }
            }
            return redirect()->to('/PeoplesList');
        } catch (\Exception $e) {
            Log::error('Error in toggleStar method: ' . $e->getMessage());
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
            }
    
            return redirect('/PeoplesList');
        } catch (\Exception $e) {
            Log::error('Error in removeToggleStar method: ' . $e->getMessage());
        }
    }
    
    public $starredPeoples;
    public $starredList;
    public $starredfirst;
    public $myTeam;

    public function render()
    {
        try {
            $companyId = Auth::user()->company_id;
            $this->peoples = EmployeeDetails::with('starredPeople')->where('company_id', $companyId)
            ->where('employee_status', 'active')
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->get();

            $employeeId = auth()->guard('emp')->user()->emp_id;
            $managerId = EmployeeDetails::where('emp_id', $employeeId)->value('manager_id');

            // Fetch all employees under the same manager, with the same company_id, and active status
            $this->myTeam = EmployeeDetails::with('starredPeople')
                ->where('company_id', $companyId)
                ->where('manager_id', $employeeId)
                ->where('employee_status', 'active')
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
            Log::error('Error in render method: ' . $e->getMessage());
            return view('livewire.peoples')->withErrors(['error' => 'An error occurred while loading the data. Please try again later.']);
        }
    }
}
