<?php

namespace App\Livewire;

use App\Models\EmpBankDetail;
use App\Models\EmployeeDetails;
use App\Models\ITStatement;
use App\Models\SalaryRevision;

use DateTime;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

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
    public $itStatements;
    public $monthlyIncomeType ;

 
    public $filteredData;
   public $activePreview;
    public function mount()
    {
        // Retrieve data for the specified monthly_income_type
       // $this->filteredData = ITStatement::all('monthly_income_type', $this->monthlyIncomeType);

    }
 

    public function generatePDF()
    {
        $pdf = Pdf::loadView('pdf.ytdpayslip', compact('employees'));
        return $pdf->download('ytdpayslip.pdf');// Load the PDF view

        return $pdf->download('itform.pdf'); // Download the PDF
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
        // Get the current year and month
        
        $currentYear = date('Y');
        $currentMonth = date('n');

        // Generate options for months from January of the previous year to the current month of the current year
        $options = [];
        for ($year = $currentYear - 1; $year <= $currentYear; $year++) {
            $startMonth = ($year == $currentYear - 1) ? 1 : 13; // Start from January of the previous year or current month
            $endMonth = ($year == $currentYear) ? $currentMonth : 12; // End at the current month

            for ($month = $startMonth; $month <= $endMonth; $month++) {
                // Format the month and year to display
                $dateObj   = DateTime::createFromFormat('!m', $month);
                $monthName = $dateObj->format('F');
                $displayYear = ($month == 13) ? $year + 1 : $year; // Display next year for January of the next year

                $options["$year-$month"] = "$monthName $displayYear";
            }
        }

        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->get();
        $this->salaryRevision = SalaryRevision::where('emp_id', $employeeId)->get();
        $salaryRevision = new SalaryRevision();

        // Calculate total allowance and deductions
        $totalGrossPay = 0;
        $totalDeductions = 0;

        foreach ($this->salaryRevision as $revision) {
            $totalGrossPay += $revision->calculateTotalAllowance();
            $totalDeductions += $revision->calculateTotalDeductions();
        }

        $this->netPay = $totalGrossPay - $totalDeductions;
        $this->empBankDetails = EmpBankDetail::where('emp_id', $employeeId)->get();

        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails =  EmployeeDetails::where('emp_id', $employeeId)->get();
        $this->salaryRevision =  SalaryRevision::where('emp_id', $employeeId)->get();
        $this-> empBankDetails=  EmpBankDetail::where('emp_id', $employeeId)->get();
         $this->itStatements = ITStatement::all();
        // Fetch the data from the ITStatement model
        return view('livewire.ytdreport', [
            'employees' => $this->employeeDetails,
            'salaryRevision' => $this->salaryRevision,
            'empBankDetails' => $this->empBankDetails,
            'options' => $options,
            'netPay' => $this->netPay,
        ],);

    }
}