<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class AdminDashboard extends Component
{
    public $show= false;
    public $totalEmployeeCount;
    public $totalNewEmployeeCount;
    public $totalNewEmployees;
    public $labels;
    public $data;
    public $departmentCount;
    public $colors;
    public $maleCount = 0;
    public $femaleCount = 0;
    public $employeeCountsByLocation;
    public function mount()
    {
        $companyId = Auth::user()->company_id;

         // Count total employees
        $this->totalEmployeeCount = EmployeeDetails::where('company_id', $companyId)->count();

        // Get total employees grouped by location
        $this->employeeCountsByLocation = EmployeeDetails::select('job_location', DB::raw('count(*) as count'))
        ->where('company_id', $companyId)
        ->groupBy('job_location')
        ->get();

        // Count new employees for the current year
        $this->totalNewEmployees = EmployeeDetails::where('company_id', $companyId)
            ->whereYear('hire_date', Carbon::now()->year)
            ->get();
        $this->totalNewEmployeeCount = $this->totalNewEmployees->count();

        $departmentNames = [];
        // Check if $newEmployees is not empty
        if ($this->totalNewEmployees->isNotEmpty()) {
            foreach ($this->totalNewEmployees as $employee) {
                $departmentNames[] = $employee->department;
            }
            $uniqueDepartments = array_unique($departmentNames);

            $this->departmentCount = count($uniqueDepartments);
        } else {
            $this->departmentCount = 0;
        }

        // Get gender distribution for the company
        $genderDistribution = EmployeeDetails::select('gender', DB::raw('count(*) as count'))
            ->where('company_id', $companyId)
            ->groupBy('gender')
            ->get();

        $this->labels = $genderDistribution->pluck('gender');
        $this->data = $genderDistribution->pluck('count');
        $this->colors = [
            'Male' => 'rgb(255, 99, 132)',
            'Female' => 'rgb(54, 162, 235)',
            'Not Active' => 'rgb(255, 205, 86)'
        ];

        // Loop through the gender distribution data to calculate male and female counts
        foreach ($genderDistribution as $distribution) {
            if ($distribution->gender === 'Male') {
                $maleCount = $distribution->count;
            } elseif ($distribution->gender === 'Female') {
                $femaleCount = $distribution->count;
            }
        }

        $this->maleCount = $maleCount;
        $this->femaleCount = $femaleCount;
    }

    public function open(){
        $this->show= true;
    }
    public function render()
    {
        return view('livewire.admin-dashboard',[
            'departmentCount' => $this->departmentCount,
        ]);
    }
}
