<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


</head>

<body style=" font-family: 'Montserrat', sans-serif;background: #f0f0f0;margin: 0;padding: 0;display: flex;justify-content: center;align-items: center;min-height: 50vh;font-size: 12px;">
    <div>
        @foreach($employees as $employeeData)
        @foreach($empBankDetails as  $employee)

        <div class="salaryslip" style=" background: #fff;max-width: 800px; width: 100%; margin: 20px;  font-size: 12px;  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);border-radius: 5px;padding: 20px;">
            <table class="employeedetails">
                <tr class="backgroundpdf">
                    <td colspan='3'>
                        @livewire('company-logo')
                    </td>
                    <td colspan='3'>
                        <p style="margin-left:20px;font-size:20px;font-weight:800">{{ $employeeData->company_name }}</p>
                    </td>
                </tr>
                <tr>
                    <th style="padding: 8px;font-size: 12px;">Name</th>
                    <td style="padding: 8px;font-size: 12px;">{{ $employeeData->first_name }} {{ $employeeData->last_name }}</td>
                    <th style="padding: 8px;font-size: 12px;">Bank Branch</th>
                    <td style="padding: 8px;font-size: 12px;">{{ $employee->bank_branch }}</td>
                    <th style="padding: 8px;font-size: 12px;">Branch Name</th>
                    <td style="padding: 8px;font-size: 12px;">{{ $employee->bank_name }}</td>
                </tr>
            <tr>
                <th style="padding: 8px;font-size: 12px;">PF Number</th>
                <td style="padding: 8px;font-size: 12px;">{{ $employeeData->pf_no }}</td>
                <th style="padding: 8px;font-size: 12px;">Bank Name</th>
                <td style="padding: 8px;font-size: 12px;">{{ $employee->bank_name }}</td>
                <th style="padding: 8px;font-size: 12px;">Bank Account Number</th>
                <td style="padding: 8px;font-size: 12px;">{{ $employee->account_number }}</td>
            </tr>
           
            <tr>
                <th>Mobile</th>
                <td>{{ $employeeData->mobile_number }}</td>
                <th>Bank A/C no.</th>
                <td style="margin-left:50px"> {{ $employee->account_number }}</td>
                <th style="margin-left:50px">Address</th>
                <td>{{ $employeeData->address }}</td>
            </tr>
            <tr>
                <th style="padding: 8px;font-size: 12px;">Grade:</th>
                <td style="padding: 8px;font-size: 12px;">18</td>
                <th style="padding: 8px;font-size: 12px;">Designation</th>
                <td style="padding: 8px;font-size: 12px;">{{ $employeeData->job_title }}</td>
                <th style="margin-left:50px;padding: 8px;font-size: 12px;">PAN No:</th>
                <td style="padding: 8px;font-size: 12px;">{{ $employeeData->pan_no }}</td>
            </tr>
        </table>
    </div>
    @endforeach
    @endforeach
    @foreach($salaryRevision as $employee)
        <div class="salaryslip" style=" background: #fff;max-width: 800px; width: 100%; margin: 20px;  font-size: 12px;  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);border-radius: 5px;padding: 20px;">
            <table class="employeedetails">
                <tr class="backgroundpdf" style="width: 100%;font-size: 12px;">
                    <th colspan="2" style="padding: 8px;font-size: 12px;">Payments</th>
                    <th style="padding: 8px;font-size: 12px;">Particulars</th>
                    <th style="padding: 8px;font-size: 12px;" class="align-right">Amount (Rs.)</th>
                    <th style="padding: 8px;font-size: 12px;"  colspan="2">Deductions</th>
                    <th style="padding: 8px;font-size: 12px;">Particulars</th>
                    <th style="padding: 8px;font-size: 12px;" class="align-right">Amount (Rs.)</th>
                </tr>
            <tr>
                <th colspan="2" style="padding: 8px;font-size: 12px;">Basic Salary</th>
                <td style="padding: 8px;font-size: 12px;"></td>
                <td style="padding: 8px;font-size: 12px;" class="myAlign">{{ number_format($employee->basic, 2) }}</td>
                <th colspan="2" style="padding: 8px;font-size: 12px;">PF</th>
                <td style="padding: 8px;font-size: 12px;"></td>
                <td style="padding: 8px;font-size: 12px;" class="myAlign">{{ number_format($employee->calculatePf(), 2) }}</td>
            </tr>
            <tr>
                <th colspan="2" style="padding: 8px;font-size: 12px;">HRA</th>
                <td style="padding: 8px;font-size: 12px;"></td>
                <td style="padding: 8px;font-size: 12px;" class="myAlign">{{ number_format($employee->hra, 2) }}</td>
                <th style="padding: 8px;font-size: 12px;" colspan="2">ESI</th>
                <td style="padding: 8px;font-size: 12px;"></td>
                <td style="padding: 8px;font-size: 12px;" class="myAlign">{{ number_format($employee->calculateEsi(), 2) }}</td>
            </tr>
            <tr>
                <th style="padding: 8px;font-size: 12px;"  colspan="2">CONVEYANCE</th>
                <td style="padding: 8px;font-size: 12px;"></td>
                <td style="padding: 8px;font-size: 12px;" class="myAlign">{{ number_format($employee->conveyance, 2) }}</td>
                <th style="padding: 8px;font-size: 12px;"  colspan="2">PROF TAX</th>
                <td style="padding: 8px;font-size: 12px;"></td>
                <td style="padding: 8px;font-size: 12px;" class="myAlign">150</td>
            </tr>
            <tr>
                <th style="padding: 8px;font-size: 12px;" colspan="2">MEDICAL ALLOWANCE</th>
                <td style="padding: 8px;font-size: 12px;"></td>
                <td style="padding: 8px;font-size: 12px;" class="myAlign">{{ number_format($employee->medical, 2) }}</td>
            </tr>
            <tr>
                <th style="padding: 8px;font-size: 12px;" colspan="2">SPECIAL ALLOWANCE</th>
                <td style="padding: 8px;font-size: 12px;"></td>
                <td style="padding: 8px;font-size: 12px;" class="myAlign">{{ number_format($employee->special, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 8px;font-size: 12px;" colspan="8"></td>
            </tr>
            <tr class="myBackground">
                <th colspan="3" style="padding: 8px;font-size: 12px;">Total Payments</th>
                <td class="myAlign total" style="padding: 8px;font-size: 12px;">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                <th colspan="3" style="padding: 8px;font-size: 12px;">Total Deductions</th>
                <td class="myAlign total" style="padding: 8px;font-size: 12px;">{{ number_format($employee->calculateTotalDeductions(), 2) }}</td>
            </tr>
        </table>
    </div>
    @endforeach
</div>
 </html>