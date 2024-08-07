<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Salaryslip;
use App\Models\EmployeeDetails;
use App\Models\SalaryRevision;
use App\Models\EmpBankDetail;
use DateTime;
use Barryvdh\DomPDF\Facade\Pdf;
class SalarySlips extends Component
{
    public $employeeDetails;
    public $salaryRevision;
    public $empBankDetails;
    public $showDetails = true;
    public $selectedMonth;
    public $netPay;
    public function toggleDetails()
    {
        $this->showDetails = !$this->showDetails;
    }
    private function calculateNetPay()
    {
        $totalGrossPay = 0;
        $totalDeductions = 0;

        foreach ($this->salaryRevision as $revision) {
            $totalGrossPay += $revision->calculateTotalAllowance();
            $totalDeductions += $revision->calculateTotalDeductions();
        }

        return $totalGrossPay - $totalDeductions;
    }
    public function downloadPdf()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->get();
        $this->salaryRevision = SalaryRevision::where('emp_id', $employeeId)->get();
        $this->empBankDetails = EmpBankDetail::where('emp_id', $employeeId)->get();

        $data = [
            'employees' => $this->employeeDetails,
            'salaryRevision' => $this->salaryRevision,
            'empBankDetails' => $this->empBankDetails,
         
            'netPay' => $this->calculateNetPay()
        ];
       // Generate PDF using the fetched data
       $pdf = Pdf::loadView('download-pdf', [
        'employeeDetails' =>  $this->employeeDetails,
   
    ]);
    

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'salary-slips.pdf');
    }



    public function convertNumberToWords($number)
    {
        // Array to represent numbers from 0 to 19 and the tens up to 90
        $words = [
            0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five',
            6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten',
            11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen',
            20 => 'twenty', 30 => 'thirty', 40 => 'forty', 50 => 'fifty',
            60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
        ];

        // Handle special cases
        if ($number < 0) {
            return 'minus ' . $this->convertNumberToWords(-$number);
        }

        // Handle numbers less than 100
        if ($number < 100) {
            if ($number < 20) {
                return $words[$number];
            } else {
                $tens = $words[10 * (int) ($number / 10)];
                $ones = $number % 10;
                if ($ones > 0) {
                    return $tens . ' ' . $words[$ones];
                } else {
                    return $tens;
                }
            }
        }

        // Handle numbers greater than or equal to 100
        if ($number < 1000) {
            $hundreds = $words[(int) ($number / 100)] . ' hundred';
            $remainder = $number % 100;
            if ($remainder > 0) {
                return $hundreds . ' ' . $this->convertNumberToWords($remainder);
            } else {
                return $hundreds;
            }
        }

        // Handle larger numbers
        if ($number < 1000000) {
            $thousands = $this->convertNumberToWords((int) ($number / 1000)) . ' thousand';
            $remainder = $number % 1000;
            if ($remainder > 0) {
                return $thousands . ' ' . $this->convertNumberToWords($remainder);
            } else {
                return $thousands;
            }
        }

        // Handle even larger numbers
        if ($number < 1000000000) {
            $millions = $this->convertNumberToWords((int) ($number / 1000000)) . ' million';
            $remainder = $number % 1000000;
            if ($remainder > 0) {
                return $millions . ' ' . $this->convertNumberToWords($remainder);
            } else {
                return $millions;
            }
        }

        // Handle numbers larger than or equal to a billion
        return 'number too large to convert';
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

    return view('livewire.salary-slips', [
        'employees' => $this->employeeDetails,
        'salaryRevision' => $this->salaryRevision,
        'empBankDetails' => $this->empBankDetails,
        'options' => $options,
        'netPay' => $this->netPay
    ]);
    }

}
