<?php

namespace App\Livewire;

use App\Models\ITStatement;
use Livewire\Component;
use App\Models\AddDeclaration;
use App\Models\Salaryslip;
use App\Models\EmployeeDetails;
use App\Models\EmpBankDetail;
use App\Models\EmpSalary;
use App\Models\EmpSalaryRevision;
use App\Models\IT;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Itstatement1 extends Component
{
    public $resumeData;
    public $employee;
    public $itStatements;
    public $monthlyIncomeType;
    public $employeeDetails;
    public $salaryRevision;
    public $empBankDetails;

    public $filteredData;
    public $activePreview;

    public $financialYears;
    public $selectedFinancialYear;
    public $start_date;
    public $end_date;
    public $salaryData;
    public $pfData;
    public $totals;
    public $pftotals;
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

        // Reverse financial years for descending order
        $this->financialYears = array_reverse($this->financialYears);

        // Set the default selected financial year
        $this->selectedFinancialYear = $this->financialYears[0]['start_date'] . '|' . $this->financialYears[0]['end_date'];

        // Fetch salary data
        $this->getSalaryData();
    }




    public function getSalaryData()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        list($startDate, $endDate) = explode('|', $this->selectedFinancialYear);
        $this->start_date = Carbon::parse($startDate)->format('Y');
        $this->end_date = Carbon::parse($endDate)->format('Y');
        $months = [];
        $currentMonth = Carbon::parse($startDate);
        while ($currentMonth <= Carbon::parse($endDate)) {
            $months[] = $currentMonth->format('Y-m');
            $currentMonth->addMonth();
        }


        $this->salaryRevision = EmpSalary::join('salary_revisions', 'emp_salaries.sal_id', '=', 'salary_revisions.id')
            ->where('salary_revisions.emp_id', $employeeId)
            ->whereBetween('month_of_sal', [$startDate, $endDate])
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->month_of_sal)->format('Y-m');
            });


        $this->salaryData = [];
        $this->pfData = [];
        $this->totals = [
            'basic' => 0,
            'hra' => 0,
            'conveyance' => 0,
            'medical_allowance' => 0,
            'special_allowance' => 0,
            'earnings' => 0,
            'gross' => 0,
            'pf' => 0,
            'esi' => 0,
            'professional_tax' => 0,
            'total_deductions' => 0,
            'net_pay' => 0,
            'working_days' => 0,
        ];
        $this->pftotals = [
            'basic' => 0,
            'pf' => 0,
            'vpf' => 0,
            'employeer_pf' => 0,
            'employeer_pension' => 0,
        ];

        foreach ($months as $month) {
            $currentDate = Carbon::now();
            $monthDate = Carbon::parse($month . '-01');

            if (isset($this->salaryRevision[$month])) {
                // Calculate salary components for the available month
                $salaryComponents = $this->salaryRevision[$month]->calculateSalaryComponents($this->salaryRevision[$month]->salary);
                $pfComponent = $this->salaryRevision[$month]->calculatePfComponents($this->salaryRevision[$month]->salary);
                $this->salaryData[$month] = $salaryComponents;
                $this->pfData[$month] = $pfComponent;

                // Add each component to the total
                foreach ($salaryComponents as $key => $value) {
                    if (isset($this->totals[$key])) {
                        $this->totals[$key] += is_numeric($value) ? $value : 0;
                    }
                }
                foreach ($pfComponent as $key => $value) {
                    if (isset($this->pftotals[$key])) {
                        $this->pftotals[$key] += is_numeric($value) ? $value : 0;
                    }
                }
            } elseif ($monthDate->isFuture()) {
                // For future dates, set all components to 0
                $this->salaryData[$month] = $this->zeroSalaryDetails();
                // $this->pfData[$month] = $this->zeroPfDetails();
            } elseif ($monthDate->isCurrentMonth()) {
                // For the current month, if no data, set all components to 0
                $this->salaryData[$month] = $this->zeroSalaryDetails();
                // $this->pfData[$month] = $this->zeroPfDetails();
            } else {
                // For missing past data, use empty salary details
                $this->salaryData[$month] = $this->emptySalaryDetails();
                $this->pfData[$month] = $this->emptyPfDetails();
            }
        }
        // Add total row to the salary data

        // dd($this->salaryData, $this->totals);

    }
    public function emptySalaryDetails()
    {
        return [
            'basic' => '-',
            'hra' => '-',
            'conveyance' => '-',
            'medical_allowance' => '-',
            'special_allowance' => '-',
            'earnings' => '-',
            'gross' => '-',
            'pf' => '-',
            'esi' => '-',
            'professional_tax' => '-',
            'total_deductions' => '-',
            'net_pay' => '-',
            'working_days' => '-',
        ];
    }
    public function emptyPfDetails()
    {
        return [
            'basic' => '-',
            'pf' => '-',
            'vpf' => '-',
            'employeer_pf' => '-',
            'employeer_pension' => '-',
        ];
    }

    public function zeroSalaryDetails()
    {
        return [
            'basic' => 0,
            'hra' => 0,
            'conveyance' => 0,
            'medical_allowance' => 0,
            'special_allowance' => 0,
            'earnings' => 0,
            'gross' => 0,
            'pf' => 0,
            'esi' => 0,
            'professional_tax' => 0,
            'total_deductions' => 0,
            'net_pay' => 0,
            'working_days' => 0,
        ];
    }

    public function generatePDF()
    {
        // Generate your PDF content using a PDF package like dompdf or TCPDF
        $pdf = PDF::loadView('pdf.itform'); // Load the PDF view

        return $pdf->download('itform.pdf'); // Download the PDF
    }


    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;

        try {
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->get();
        } catch (\Exception $e) {
            $this->employeeDetails = collect();
        }

        try {
            $this->salaryRevision = EmpSalaryRevision::where('emp_id', $employeeId)->get();
        } catch (\Exception $e) {
            $this->salaryRevision = collect();
        }

        try {
            $this->empBankDetails = EmpBankDetail::where('emp_id', $employeeId)->get();
        } catch (\Exception $e) {
            $this->empBankDetails = collect();
        }


        try {
            $this->itStatements = IT::all();
        } catch (\Exception $e) {
            $this->itStatements = collect();
        }

        return view('livewire.itstatement1', ['employees' => $this->employeeDetails], ['salaryRevision' => $this->salaryRevision], ['empBankDetails' => $this->empBankDetails], ['itStatements' => $this->itStatements],);
    }
}
