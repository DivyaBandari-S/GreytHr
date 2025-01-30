<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoansAndAdvances extends Component
{
    public $financialYears;
    public $employeeDetails;
    public $selectedFinancialYear;
    public function render()
    {
        return view('livewire.loans-and-advances');
    }
    public function mount(){
        $employeeId = Auth::user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first(); // Assuming Employee model has hire_date

        $joiningDate = $this->employeeDetails->hire_date ? Carbon::parse($this->employeeDetails->hire_date) : now();
        $currentDate = now();
        $currentYear = $currentDate->year;

        // Adjust start year based on the joining date
        $startYear = $joiningDate->month < 4 ? $joiningDate->year - 1 : $joiningDate->year;

        // Only include the current financial year if the month is greater than March
        $includeCurrentYear = $currentDate->month > 3;
        $endYear = $includeCurrentYear ? $currentYear : $currentYear - 1;

        // Generate financial years
        for ($year = $startYear; $year <= $endYear; $year++) {
            $this->financialYears[] = [
                'label' => "Apr $year - Mar " . ($year + 1),
                'start_date' => "$year-04-01",
                'end_date' => ($year + 1) . "-03-31",
            ];
        }
        // dd( $this->financialYears);

        // Reverse financial years for descending order
        $this->financialYears = array_reverse($this->financialYears);

        // Set the default selected financial year
        $this->selectedFinancialYear = $this->financialYears[0]['start_date'] . '|' . $this->financialYears[0]['end_date'];

    }
}

