<?php

namespace App\Livewire;

use App\Models\EmpBankDetail;
use App\Models\EmployeeDetails;
use App\Models\EmpSalary;
use App\Models\ITStatement;
use App\Models\EmpSalaryRevision;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class Ytdreport extends Component
{
    public $activeTab = 'ytd';
    public $employeeDetails;
    public $salaryRevision;
    public $empBankDetails;
    public $Details = true;
    public $selectedMonth;
    public $netPay;
    public $resumeData;
    public $employee;
    public $itStatements;
    public $monthlyIncomeType;


    public $filteredData;
    public $activePreview;

    public $financialYears = [];
    public $selectedFinancialYear;
    public $salaryData = [];
    public $pfData = [];
    public $totals;
    public $pftotals;
    public $start_date;
    public $end_date;

    public function mount()
    {
        $employeeId = Auth::user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first(); // Assuming Employee model has joining_date

        $joiningDate =  $this->employeeDetails->hire_date ? Carbon::parse($this->employeeDetails->hire_date) : now();
        $currentYear = now()->year;

        $startYear = $joiningDate->month < 4 ? $joiningDate->year - 1 : $joiningDate->year;

        for ($year = $startYear; $year <= $currentYear; $year++) {
            $this->financialYears[] = [
                'label' => "Apr $year -Mar " . ($year + 1),
                'start_date' => "$year-04-01",
                'end_date' => ($year + 1) . "-03-31",
            ];
        }
        $this->financialYears = array_reverse($this->financialYears);
        $this->selectedFinancialYear = $this->financialYears[0]['start_date'] . '|' . $this->financialYears[0]['end_date'];
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


    public function SelectedFinancialYear()
    {
        $this->getSalaryData();
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
    // public function zeroPfDetails()
    // {
    //     return [
    //         'basic' => 0,
    //         'pf' => 0,
    //         'vpf' => 0,
    //         'employeer_pf' => 0,
    //         'employeer_pension' => 0,
    //     ];
    // }

    public function downloadytd()
    {
        try {

            // $width = (842 + 595) / 2;  // Midpoint of A3 and A4 width
            // $height = (1191 + 842) / 2; // Midpoint of A3 and A4 height
            $width = 840;
            $height = 1100;

            if ($this->activeTab == 'ytd') {

                $pdf = Pdf::loadView('download-ytd-pdf', [
                    'employees' => $this->employeeDetails,
                    'empBankDetails' => $this->empBankDetails,
                    'salaryData' => $this->salaryData,
                    'salaryTotals' => $this->totals,
                    'startDate' => $this->start_date,
                    'endDate' => $this->end_date,
                ])
                    ->setPaper([0, 0, $width, $height]);

                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf->stream();
                }, 'YTDPayslip-' . $this->start_date . '-' . $this->end_date . '.pdf');
            }else if($this->activeTab == 'pfytd'){

                $pdf = Pdf::loadView('download-pfytd-pdf', [
                    'employees' => $this->employeeDetails,
                    'empBankDetails' => $this->empBankDetails,
                    'pfData' =>  $this->pfData,
                    'pfTotals' => $this->pftotals,
                    'startDate' => $this->start_date,
                    'endDate' => $this->end_date,
                ]);
                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf->stream();
                }, 'PF-YTD-Payslip-' . $this->start_date . '-' . $this->end_date . '.pdf');

            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showContent($contentId)
    {
        $this->activeTab = $contentId;
    }
    public function toggleDetails()
    {
        $this->Details = !$this->Details;
    }

    public function render()
    {


        $employeeId = auth()->guard('emp')->user()->emp_id;

        try {
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
        } catch (\Exception $e) {
            $this->employeeDetails = collect();
        }

        try {
            $this->getSalaryData();
           

        } catch (\Exception $e) {
            $this->salaryData = collect();
        }

        try {
            $this->empBankDetails = EmpBankDetail::where('emp_id', $employeeId)->first();
        } catch (\Exception $e) {
            $this->empBankDetails = collect();
        }

        return view('livewire.ytdreport', [
            'employees' => $this->employeeDetails,
            'salaryData' => $this->salaryData,
            'empBankDetails' => $this->empBankDetails,

        ]);
    }
}
