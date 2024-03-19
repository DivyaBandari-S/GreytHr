<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\StarredPeople;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Peoples extends Component
{
    public $searchTerm = '';
    public $peoples;
    public $selectedPerson = null;
    public $starredPerson = null;
    public $filteredPeoples;
    public $activeTab = 'starred';
    public $peopleFound = true;
    public $employeeDetails;

    public function selectPerson($empId)
    {
        $this->selectedPerson = EmployeeDetails::where('emp_id', $empId)->first();
    }

    public $selectStarredPeoples;

    public function starredPersonById($id)
    {
        $this->selectStarredPeoples = StarredPeople::with('emp')->where('id', $id)->first();
    }


    public function filter()
    {
        $companyId = Auth::user()->company_id;
        $trimmedSearchTerm = trim($this->searchTerm);

        $this->filteredPeoples = EmployeeDetails::where('company_id', $companyId)
            ->where(function ($query) use ($trimmedSearchTerm) {
                $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $trimmedSearchTerm . '%'])
                    ->orWhere('emp_id', 'LIKE', '%' . $trimmedSearchTerm . '%');
            })
            ->get();

        $this->peopleFound = count($this->filteredPeoples) > 0;
    }

    public $search;
    public $filteredStarredPeoples;

    public function starredFilter()
    {
        $companyId = Auth::user()->company_id;
        $trimmedSearchTerm = trim($this->search);

        $this->filteredStarredPeoples = StarredPeople::where('company_id', $companyId)
            ->where(function ($query) use ($trimmedSearchTerm) {
                $query->where('name', 'LIKE', '%' . $trimmedSearchTerm . '%')
                    ->orWhere('people_id', 'LIKE', '%' . $trimmedSearchTerm . '%');
            })
            ->get();

        $this->peopleFound = count($this->filteredStarredPeoples) > 0;
    }

    public $employee;

    public function toggleStar($employeeId)
    {
        $this->employee = EmployeeDetails::find($employeeId);

        if ($this->employee) {
            $this->starredPerson = StarredPeople::where('people_id', $employeeId)
                ->where('starred_status', 'starred') // corrected the syntax here
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
    }



    public function removeToggleStar($personId)
    {
        $starredPerson = StarredPeople::where('people_id', $personId)
            ->where('emp_id', auth()->guard('emp')->user()->emp_id)
            ->first();

        if ($starredPerson) {
            $starredPerson->delete();
        }

        return redirect('/PeoplesList');
    }


    public $starredPeoples;
    public $starredList;


    public $starredfirst;
    public function render()
    {
        $companyId = Auth::user()->company_id;

        $this->peoples = EmployeeDetails::with('starredPeople')->where('company_id', $companyId)->get();

        $employeeId = auth()->guard('emp')->user()->emp_id;

        $this->starredList = StarredPeople::with('emp')->where('emp_id', $employeeId)->orderBy('created_at', 'desc')->get();

        $peopleData = $this->filteredPeoples ?: $this->peoples;
        $this->starredPeoples = $this->filteredStarredPeoples ?: $this->starredList;

        return view('livewire.peoples', [
            'peopleData' => $peopleData,
        ]);
    }
}
