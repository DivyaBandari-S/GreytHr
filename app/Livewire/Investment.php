<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Investment extends Component
{
    public $showDetails = true;
    public $selectedItem = 'Section 80C';
    public $financialYears;
    public $employeeDetails;
    public $selectedFinancialYear;
    public $show_family_details = false;

    // family details
    public $familyMembers = [
        [
            'name' => 'KR Raghupathi',
            'relationship' => 'Father',
            'dob' => '1965-06-15',
            'dependent' => false,
        ],
        [
            'name' => 'K R Omshankar',
            'relationship' => 'Self',
            'dob' => '2001-01-03',
            'dependent' => true,
        ],

    ];

    public function addFamilyMember()
    {
        $this->familyMembers[] = [
            'name' => '',
            'relationship' => '',
            'dob' => '',
            'dependent' => false,
        ];
    }

    public function removeFamilyMember($index)
    {
        unset($this->familyMembers[$index]);
        $this->familyMembers = array_values($this->familyMembers); // Re-index the array
    }

    public function save()
    {
        // Here, you can handle saving logic, like storing in a database
        // session()->flash('success', 'Family details saved successfully!');
    }




    public function mount()
    {
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
    public function showFamilyDetails()
    {

        $this->show_family_details = true;
    }
    public function hideFamilyDetails()
    {
        $this->show_family_details = false;
    }


    public function selectItem($item)
    {
        $this->selectedItem = $item;
    }
    public function toggleDetails()
    {
        $this->showDetails = !$this->showDetails;
    }
    public function render()
    {
        return view('livewire.investment', ['items' => [
            'Section 80C',
            'Other Chapter VI-A Deductions',
            'House Rent Allowance',
            'Medical (Sec 80D)',
            'Income/loss from House Property',
            'Salary Allowance',
            'Other Income',
            'TCS/TDS Deduction'
        ],]);
    }
}
