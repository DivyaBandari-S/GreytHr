<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Adddeclaration;
use App\Models\otherchapter;
use App\Models\medical;
use App\Models\EmployeeDetails;
use App\Livewire\Session;

class PlanA extends Component
{
    public $employeeDetails;
    public $emp_id;
    public $EmployeeDetails;
    public $showMedicalDialog = false; // Property for the Medical (Sec 80D) modal
    public $showMedicalSec80CDialog = false;
    public $showSec80CDialog = false;
    public $showVIDeductions = false;
    public $showIncomeDialog = false;
    public $showOtherIncome = false;
    public $showTcsTdsDeductions = false;

    public $showSalayAllowance = false;
    public $total;
    public $totaldeductions;


    public $houses = [];
    public $selectedHouseIndex = 0;

    public function mount()
    {
        $this->houses = [
            ['from' => '', 'to' => '', 'monthly_rent' => '', 'address' => ''],
        ];
    }

    public function addHouse()
    {
        $this->houses[] = ['from' => '', 'to' => '', 'monthly_rent' => '', 'address' => ''];
        $this->selectedHouseIndex = count($this->houses) - 1; // Switch to the new house
    }

    public function removeHouse($index)
    {
        array_splice($this->houses, $index, 1);
        $this->selectedHouseIndex = max(0, $this->selectedHouseIndex - 1); // Adjust selected index
    }

    public function selectHouse($index)
    {
        $this->selectedHouseIndex = $index;
    }

    public function addMedical()
    {
        $this->showMedicalDialog = true; // Open the Medical (Sec 80D) modal
    }
    public function addSalayAllowance()
    {
        $this->showSalayAllowance = true; // Open the Medical (Sec 80D) modal
    }
    public function addshowOtherIncome()
    {
        $this->showOtherIncome = true; // Open the Medical (Sec 80D) modal
    }
    public function addSec80()
    {
        $this->showSec80CDialog = true; // Open the Medical (Sec 80D) modal
    }
    public function addMedicalSec80()
    {

        $this->showMedicalSec80CDialog = true; // Open the Medical (Sec 80D) modal
    }
    public function addshowVIDeductions()
    {
        $this->showVIDeductions = true; // Open the Medical (Sec 80D) modal
    }
    public function addIncome()
    {
        $this->showIncomeDialog = true; // Open the Medical (Sec 80D) modal
    }

    public function openshowOtherIncome()
    {
        $this->showOtherIncome = true; // Open the Sec 80C modal
    }
    public function addTcsTdsDeductions()
    {
        $this->showTcsTdsDeductions = true; // Open the Sec 80C modal
    }
    public function openSalayAllowance()
    {
        $this->showSalayAllowance = true; // Open the Sec 80C modal
    }

    public function openSec80C()
    {
        $this->showSec80CDialog = true; // Open the Sec 80C modal
    }
    public function openshowVIDeductions()
    {
        $this->showVIDeductions = true; // Open the Sec 80C modal
    }
    public function openMedical()
    {
        $this->showMedicalDialog = true; // Open the Sec 80C modal
    }
    public function closeshowVIDeductions()
    {
        $this->showVIDeductions = false; // Open the Sec 80C modal
    }
    public function closeMedicalSec80()
    {
        $this->showMedicalSec80CDialog = false; // Open the Sec 80C modal
    }
    public function closeSalayAllowance()
    {
        $this->showSalayAllowance = false; // Open the Sec 80C modal
    }
    public function closeshowOtherIncome()
    {
        $this->showOtherIncome = false; // Open the Sec 80C modal
    }
    public function openIncome()
    {
        $this->showIncomeDialog = true; // Open the Medical (Sec 80D) modal
    }

    public function closeMedical()
    {
        $this->showMedicalDialog = false; // Close the Medical (Sec 80D) modal
    }


    public function closeSec80C()
    {
        $this->showSec80CDialog = false; // Close the Sec 80C modal
    }
    public function closeTcsTdsDeductions()
    {
        $this->showTcsTdsDeductions = false; // Close the Sec 80C modal
    }

    public function closeIncome()
    {
        $this->showIncomeDialog = false; // Open the Medical (Sec 80D) modal
    }
    public $fields = [
        '5_years_fixed_deposit',
        '5_years_deposit',
        'contribution_to_pension_fund',
        'deposit_in_nsc',
        'deposit_in_nss',
        'interest_on_nsc_reinvested',
        'equity',
        'life_insurance',

    ];

    public function submitsec80()
    {

        if (auth()->check()) {
            // Get the authenticated user
            $user = auth()->user();

            // Access the user's emp_id
            $emp_id = $user->emp_id;
            if (session()->has('form_submitted')) {
                return redirect()->back()->with('error', 'You have already submitted the form.');
            }

            // Set a default value for '5_years_fixed_deposit' if not provided by the user
            if (!isset($this->fields['5_years_fixed_deposit'])) {
                $this->fields['5_years_fixed_deposit'] = 0; // You can change 0 to the appropriate default value.
            }

            $rules = [
                'fields.5_years_fixed_deposit' => 'numeric|between:0,50000',
                'fields.5_years_deposit' => 'numeric|between:0,50000',
                'fields.contribution_to_pension_fund' => 'numeric|between:0,50000',
                'fields.deposit_in_nsc' => 'numeric|between:0,50000',
                'fields.deposit_in_nss' => 'numeric|between:0,50000',
                'fields.interest_on_nsc_reinvested' => 'numeric|between:0,50000',
                'fields.equity' => 'numeric|between:0,50000',
                'fields.life_insurance' => 'numeric|between:0,50000',
            ];

            $customMessages = [
                'between' => 'The :attribute must be between :min and :max.',
            ];

            $this->validate($rules, $customMessages);

            // Set the 'emp_id' with the retrieved value
            $this->fields['emp_id'] = $emp_id;

            // Calculate the total value
            $this->total = array_sum($this->fields);

            adddeclaration::create($this->fields);
        } else {
        }
        session(['form_submitted' => true]);
    }


    public $fieldsdeductions = [

        'intrest_on_housing',
        'intrest_on_loan',
        'contribution_to_pension_fund',
        'deposit_in_nsc',
        'deposit_in_nss',
        'interest_on_nsc_reinvested',
        'superannuation',
        'donation',
    ];
    public function submitotherdeductions()
    {
        if (auth()->check()) {
            // Get the authenticated user
            $user = auth()->user();

            // Access the user's emp_id
            $emp_id = $user->emp_id;
            if (session()->has('submitted')) {
                return redirect()->back()->with('error', 'You have already submitted the form.');
            }
            $rules = [
                'fieldsdeductions.intrest_on_housing' => 'required|numeric|between:0,50000',
                'fieldsdeductions.intrest_on_loan' => 'required|numeric|between:0,50000',
                'fieldsdeductions.contribution_to_pension_fund' => 'required|numeric|between:0,50000',
                'fieldsdeductions.deposit_in_nsc' => 'required|numeric|between:0,50000',
                'fieldsdeductions.deposit_in_nss' => 'required|numeric|between:0,50000',
                'fieldsdeductions.interest_on_nsc_reinvested' => 'required|numeric|between:0,50000',
                'fieldsdeductions.superannuation' => 'required|numeric|between:0,50000',
                'fieldsdeductions.donation' => 'required|numeric|between:0,50000',
            ];

            $customMessages = [
                'between' => 'The :attribute must be between :min and :max.',
            ];

            $this->validate($rules, $customMessages);


            $this->validate($rules, $customMessages);

            // Set the 'emp_id' with the retrieved value
            $this->fieldsdeductions['emp_id'] = $emp_id;

            $this->totaldeductions = array_sum($this->fieldsdeductions);

            otherchapter::create($this->fieldsdeductions);
        } else {
        }
        session(['submitted' => true]);
    }



    public $fieldsmedical = [

        'medical' => null,
        'Health Checkup' => null,
        'Dependant Parents' => null,
    ];


    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails =  EmployeeDetails::where('emp_id', $employeeId)->get();
        return view('livewire.plan-a', ['employees' => $this->employeeDetails]);
    }
}
