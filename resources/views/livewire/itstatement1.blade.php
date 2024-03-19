<div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap">
    <script src="{{ asset('livewire/livewire.js') }}" defer></script>
</head>

<div class="con" >
<div style="margin-left:-40px">
<div class="button-container" style="padding: 2px; margin-bottom:15px; background-color:#3eb0f7; color: #fff; width:100px;margin-left:650px; height:40px; border: none;border-radius: 4px;cursor: pointer;" >
    <a href="/itform" id="pdfLink2024" class="custom-button" download style="margin-left:410px">
        <i class="fa fa-download" aria-hidden="true" style="margin-left:-370px;color:white;margin-top:15px"></i>
    </a>
</div>
 
 
    </div>
 
<div class="row" style="display: flex">
    <div class="column" style="width: 170px; height: 100px; border: 1px solid silver; border-radius: 5px; background: white; margin-top: 40px; margin-left: 20px">
        <p style="font-size: 10px;margin-top:5px;margin-left:10px">TAX CALCULATED AS PER</p>
        <div style="border:1px solid silver ;height:1px;width:117%;margin-top:-10px;margin-left:-12px"></div>
        <p style="color:#41CD2A;font-size:13px;margin-top:20px;margin-left:10px">NEW TAX REGIME</p>
    </div>
    <div class="column" style="width: 170px; height: 100px; border: 1px solid silver; border-radius: 5px; background: white; margin-top: 40px; margin-left: 10px">
        <p style="font-size: 11px;margin-top:5px;margin-left:30px">NET TAX IN ₹</p>
        <div style="border:1px solid silver ;height:1px;width:117%;margin-top:-10px;margin-left:-12px"></div>
        <p style="font-size:24px;margin-top:10px;margin-left:40px">0.00</p>
    </div>
    <div class="column" style="width: 170px; height: 100px; border: 1px solid silver; border-radius: 5px; background: white; margin-top: 40px; margin-left: 10px">
        <p style="font-size: 11px;margin-top:5px;margin-left:30px">TOTAL TAX DUE IN ₹</p>
        <div style="border:1px solid silver ;height:1px;width:117%;margin-top:-10px;margin-left:-12px"></div>
        <p style="font-size:24px;margin-top:10px;margin-left:40px">0.00</p>
    </div>
    <div class="column" style="width: 170px; height: 100px; border: 1px solid silver; border-radius: 5px; background: white; margin-top: 40px; margin-left: 10px">
        <p style="font-size: 9px;margin-top:5px;margin-left:30px">TAX DEDUCTIBLE PER MONTH IN ₹</p>
        <div style="border:1px solid silver ;height:1px;width:117%;margin-top:-10px;margin-left:-12px"></div>
        <p style="font-size:24px;margin-top:10px;margin-left:40px">0.00</p>
    </div>
    <!-- <div class="column" style="width: 170px; height: 100px; border: 1px solid silver; border-radius: 5px; background: white; margin-top: 40px; margin-left: 10px">
        <p style="font-size: 11px;margin-top:5px;margin-left:30px">REMAINING MONTHS (SEP 2023 ONWARDS)</p>
        <div style="border:1px solid silver ;height:1px;width:117%;margin-top:-10px;margin-left:-12px"></div>
        <p style="font-size:24px;margin-top:10px;margin-left:40px">7</p>
    </div> -->
</div>
@foreach($salaryRevision as $employee)
<div class="row" style="display:flex">
<div _ngcontent-ffh-c446="" class="expand-collapse">
  <p style="margin-left:750px;margin-bottom:70px">Value in ₹</p>
</div>
<div class="row" style="width: 850px; height: 50px; border-radius: 5px; border: 1px solid silver; margin-left: 15px; background: white; margin-top: -50px;">
    <div class="column" style="display:flex">
        <p id="expandButton" style="font-size: 14px; margin-top: 15px; padding-left: 10px; cursor: pointer;">+</p>
        <p style="font-weight: normal;margin-top: 12px;margin-left:5px;font-size:14px ">A. Income </p>
        <p style="font-weight: normal;margin-top: 14px; margin-left: 600px;">₹{{ number_format($employee->calculateTotalAllowance()*12, 2) }} </p>
    </div>
</div>
 
<div id="incomeContainers" class="income-container" style="display: none; width: 850px;">
    <div class="row" style="display: flex; width: 106%;">
        <div class="column header-column" style="height: 40px; background: #AFC8ED; width: 102%; margin-left: 10px; display: flex; margin-top: 10px;">
            <p class="item-label" style="margin-top: 12px; margin-left: 20px; font-size: 10px;">Items</p>
            <p class="total-label" style="margin-top: 12px; margin-left: 100px; font-size: 10px;">Total</p>
            <div class="column" style="display: flex; white-space: nowrap; width: 100%; margin-left: 40px;">
                <table class="header-table" style="width: 100%;">
                    <tr class="header-row" style="width: 100%;">
                        <td class="header-cell" style="font-size: 10px; margin-top: 12px; margin-left: 40px;">Jan 2023</td>
                        <td class="header-cell" style="font-size: 10px; margin-top: 12px; margin-left: 10px;">Feb 2023</td>
                        <td class="header-cell" style="font-size: 10px; margin-top: 12px; margin-left: 10px;">Mar 2023</td>
                        <td class="header-cell" style="font-size: 10px; margin-top: 12px; margin-left: 10px;">Apr 2023</td>
                        <td class="header-cell" style="font-size: 10px; margin-top: 12px; margin-left: 10px;">May 2023</td>
                        <td class="header-cell" style="font-size: 10px; margin-top: 12px; margin-left: 10px;">Jun 2023</td>
                        <td class="header-cell" style="font-size: 10px; margin-top: 12px; margin-left: 10px;">Jul 2023</td>
                        <td class="header-cell" style="font-size: 10px; margin-top: 12px; margin-left: 10px;">Aug 2023</td>
                        <td class="header-cell" style="font-size: 10px; margin-top: 12px; margin-left: 10px;">Sep 2023</td>
                        <td class="header-cell" style="font-size: 10px; margin-top: 12px; margin-left: 10px;">Oct 2023</td>
                        <td class="header-cell" style="font-size: 10px; margin-top: 12px; margin-left: 10px;">Nov 2023</td>
                        <td class="header-cell" style="font-size: 10px; margin-top: 12px; margin-left: 10px;">Dec 2023</td>
                        <!-- Add more months here -->
                    </tr>
                </table>
            </div>
        </div>
        <p class="monthly-income-label" style="font-weight: normal; margin-top: 4px; background: white; height: 40px; width: 890px; margin-left: 10px;">Monthly Income</p>
    </div>
    <div class="row" style="height: 250px; width: 106%; display: flex; background: white; margin-left: -2px; margin-top: -14px;">
        <div class="column" style="display: flex; margin-top: -5px; margin-right: 10px;">
            <div class="column data-column" style="display: flex; white-space: nowrap; width: 100%; margin-left: 25px; margin-top: 5px;">
                <table class="data-S" style="width: 100%; margin-top: 5px; margin-left: -15px;">
                    <tr class="data-row" style="width: 100%; margin-left: 80px;">
                        <tr class="data-row" style="font-size: 10px; margin-left: 25px;">
                            <td class="data-cell" style="font-size: 12px;">Basic</td>
                            <td class="data-cell">{{ number_format($employee->basic*12, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->basic, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->basic, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->basic, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->basic, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->basic, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->basic, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->basic, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->basic, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->basic, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->basic, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->basic, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->basic, 2) }}</td>
                        </tr>
                        <tr class="data-row" style="font-size: 10px;">
                            <td class="data-cell" style="font-size: 12px;">HRA</td>
                            <td class="data-cell">{{ number_format($employee->hra*12, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->hra, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->hra, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->hra, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->hra, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->hra, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->hra, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->hra, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->hra, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->hra, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->hra, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->hra, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->hra, 2) }}</td>
                        </tr>
                        <tr class="data-row" style="font-size: 10px;">
                            <td class="data-cell" style="font-size: 12px;">Conveyance</td>
                            <td class="data-cell">{{ number_format($employee->conveyance*12, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->conveyance, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->conveyance, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->conveyance, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->conveyance, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->conveyance, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->conveyance, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->conveyance, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->conveyance, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->conveyance, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->conveyance, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->conveyance, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->conveyance, 2) }}</td>
                        </tr>
                        <tr class="data-row" style="font-size: 10px;">
                            <td class="data-cell" style="font-size: 12px;">Medical</td>
                            <td class="data-cell">{{ number_format($employee->medical*12, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->medical, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->medical, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->medical, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->medical, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->medical, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->medical, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->medical, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->medical, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->medical, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->medical, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->medical, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->medical, 2) }}</td>
                        </tr>
                        <tr class="data-row" style="font-size: 10px;">
                            <td class="data-cell" style="font-size: 12px;">Special Allowance</td>
                            <td class="data-cell">{{ number_format($employee->special*12, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->special, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->special, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->special, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->special, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->special, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->special, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->special, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->special, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->special, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->special, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->special, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->special, 2) }}</td>
                        </tr>
                        <tr class="data-row" style="font-size: 10px; background: #C3C7CD; width: 110%; font-size: 800;">
                            <td class="data-cell" style="font-size: 12px;">Total Allowance</td>
                            <td class="data-cell">{{ number_format($employee->calculateTotalAllowance()*12, 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                            <td class="data-cell">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                        </tr>
                    </tr>
                </table>
            </div>
        </div>
    </div>
 
 
 
</div>
@endforeach
 
<div class="container-w" style="width: 106%; margin-left: -10px; margin-top: 5px;">
    <div class="row" style="width: 850px; height: 50px; border-radius: 5px; border: 1px solid silver; margin-left: 12px; background: white; margin-top: 20px;">
        <div class="column" style="display: flex;">
            <p id="expandButton2" class="expand-button" style="font-size: 14px; margin-top: 15px; padding-left: 10px; cursor: pointer;">+</p>
            <p class="deduction-label" style="font-weight: normal; margin-top: 14px; margin-left: 20px;">B. Deductions</p>
            <p class="total-amount" style="font-weight: normal; margin-top: 14px; margin-left: 540px;">₹{{ number_format($employee->calculatePf() * 12 + 1800, 2) }}</p>
        </div>
       
        <div id="incomeContainer2" class="income-container" style="display: none; width: 850px;">
            <div class="row" style="display: flex; width: 103%;">
                <div class="column" style="height: 40px; background: #AFC8ED; width: 103%; margin-left: 0; display: flex; margin-top: -3px;">
                    <p class="items-label" style="margin-top: 12px; margin-left: 20px; font-size: 10px;">Items</p>
                    <p class="total-label" style="margin-top: 12px; margin-left: 100px; font-size: 10px;">Total</p>
                    <div class="column" style="display: flex; white-space: nowrap; width: 100%; margin-left: 30px;">
                        <table class="I" style="width: 100%;">
                            <tr style="width: 100%;">
                                <td class="date-td" style="font-size: 10px; margin-top: 12px; margin-left: 40px;">Jan 2023</td>
                                <td class="date-td" style="font-size: 10px; margin-top: 12px; margin-left: 10px;">Feb 2023</td>
                                <td class="date-td" style="font-size: 10px; margin-top: 12px; margin-left: 10px;">Mar 2023</td>
                                <td class="date-td" style="font-size: 10px; margin-top: 12px; margin-left: 20px;">Apr 2023</td>
                                <td class="date-td" style="font-size: 10px; margin-top: 12px; margin-left: 20px;">May 2023</td>
                                <td class="date-td" style="font-size: 10px; margin-top: 12px; margin-left: 20px;">Jun 2023</td>
                                <td class="date-td" style="font-size: 10px; margin-top: 12px; margin-left: 20px;">July 2023</td>
                                <td class="date-td" style="font-size: 10px; margin-top: 12px; margin-left: 20px;">Aug 2023</td>
                                <td class="date-td" style="font-size: 10px; margin-top: 12px; margin-left: 20px;">Sep 2023</td>
                                <td class="date-td" style="font-size: 10px; margin-top: 12px; margin-left: 20px;">Oct 2023</td>
                                <td class="date-td" style="font-size: 10px; margin-top: 12px; margin-left: 20px;">Nov 2023</td>
                                <td class="date-td" style="font-size: 10px; margin-top: 12px; margin-left: 30px;">Dec 2023</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div style="border: 1px solid silver; height: 1px; width: 98%;"></div>
                <div class="row" style="height: 120px; width: 100%; margin-left: 0; display: flex; background: white;">
                    <div class="column" style="display: flex; margin-top: 5px; margin-left: 0;">
                        <p class="item-label" style="margin-top: 23px; margin-left: 20px; font-size: 13px; width: 100px;">PF</p>
                        <p class="amount" style="margin-top: 24px; margin-left: 20px; font-size: 10px; width: 50px;">{{ number_format($employee->calculatePf()*12, 2) }}</p>
                        <div class="column" style="display: flex; white-space: nowrap; width: 100%; margin-left: 30px; margin-top: 10px;">
                            <table class="K" style="width: 100%;">
                                <tr style="width: 100%;">
                                    <td class="amount-td" style="font-size: 10px; margin-top: 3px; margin-left: 10px;">{{ number_format($employee->calculatePf(), 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 3px; margin-left: 10px;">{{ number_format($employee->calculatePf(), 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 3px; margin-left: 10px;">{{ number_format($employee->calculatePf(), 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 3px; margin-left: 20px;">{{ number_format($employee->calculatePf(), 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 3px; margin-left: 20px;">{{ number_format($employee->calculatePf(), 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 3px; margin-left: 20px;">{{ number_format($employee->calculatePf(), 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 3px; margin-left: 20px;">{{ number_format($employee->calculatePf(), 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 3px; margin-left: 20px;">{{ number_format($employee->calculatePf(), 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 3px; margin-left: 20px;">{{ number_format($employee->calculatePf(), 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 3px; margin-left: 20px;">{{ number_format($employee->calculatePf(), 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 3px; margin-left: 20px;">{{ number_format($employee->calculatePf(), 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 3px; margin-left: 20px;">{{ number_format($employee->calculatePf(), 2) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="column" style="display: flex; margin-top: 5px; margin-left: 0;">
                        <p class="item-label" style="margin-top: 23px; margin-left: 9px; font-size: 13px; width: 100px;">PROTAX</p>
                        <p class="amount" style="margin-top: 24px; margin-left: 30px; font-size: 10px; width: 50px;">1800.00</p>
                        <div class="column" style="display: flex; white-space: nowrap; width: 100%; margin-left: 30px; margin-top: 10px;">
                            <table class="L" style="width: 100%;">
                                <tr style="width: 100%;">
                                    <td class="amount-td" style="font-size: 10px; margin-top: 5px; margin-left: 10px;">150.00</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 5px; margin-left: 10px;">150.00</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 5px; margin-left: 10px;">150.00</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 5px; margin-left: 20px;">150.00</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 5px; margin-left: 20px;">150.00</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 5px; margin-left: 20px;">150.00</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 5px; margin-left: 20px;">150.00</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 5px; margin-left: 20px;">150.00</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 5px; margin-left: 20px;">150.00</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 5px; margin-left: 20px;">150.00</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 5px; margin-left: 20px;">150.00</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 5px; margin-left: 30px;">150.00</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row" style="height: 40px; width: 105%; background: #C3C7CD; ">
                    <div class="column" style="display: flex; margin-top: 2px; margin-left: -8px; width: 1000px;">
                        <p class="item-label" style="margin-top: 13px; margin-left: 40px; font-size: 13px; width: 110px;">Total</p>
                        <p class="amount" style="margin-top: 13px; margin-left: 20px; font-size: 10px; width: 120px;">₹{{ number_format($employee->calculatePf() * 12 + 1800, 2) }}</p>
                        <div class="column" style="display: flex; white-space: nowrap; width: 100%; margin-top: -10px;">
                            <table class="N" style="width: 100%;">
                                <tr style="width: 100%;">
                                    <td class="amount-td" style="font-size: 10px; margin-top: 12px; margin-left: -80px;">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 12px; margin-left: -20px;">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 12px; margin-left: 10px;">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 12px; margin-left: 30px;">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 12px; margin-left: 30px;">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 12px; margin-left: 30px;">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 12px; margin-left: 30px;">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 12px; margin-left: 50px;">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 12px; margin-left: 30px;">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 12px; margin-left: 30px;">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 12px; margin-left: 30px;">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                    <td class="amount-td" style="font-size: 10px; margin-top: 12px; margin-left: 30px;">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   
                <div class="container" style="width: 106%; margin-left: -30px;margin-top:5px">
    <div class="row" style="width: 840px; height: 50px; border-radius: 5px; border: 1px solid silver; margin-left: 13px; background: white; margin-top: 20px;">
        <div class="column" style="display: flex">
            <p id="expandButton3" style="font-size: 14px; margin-top: 15px; padding-left: 10px; cursor: pointer;">+</p>
            <p style="font-weight: normal; margin-top: 14px; margin-left: 20px;">C. Perquisites</p>
            <p style="font-weight: normal; margin-top: 14px; margin-left: 590px;">₹0.00</p>
        </div>
       
        <div id="incomeContainer3" style="display: none; width: 850px;">
            <div class="row" style="display: flex; width: 103%;">
               
           
                <div class="row" style="height:40px; width: 100%; margin-left: 0; display: flex; background: white;">
                    <div class="column" style="display: flex; margin-top: 5px;;">
                        <p style=" margin-left: 270px; font-size: 12px; ">No data to display !!!</p>
                       
                    </div>
                   
 
    </div>
</div>
   
</div>
<div class="container" style="width: 106%; margin-left: -30px;margin-top:20px">
    <div class="row" style="width: 840px; height: 50px; border-radius: 5px; border: 1px solid silver; margin-left: 13px; background: white; margin-top: 20px;">
        <div class="column" style="display: flex">
            <p id="expandButton4" style="font-size: 10px; margin-top: 15px; padding-left: 10px; cursor: pointer;">+</p>
            <p style="font-weight: normal; margin-top: 14px; margin-left: 20px;font-size:13px">
D. Income Excluded From Tax</p>
            <p style="font-weight: normal; margin-top: 14px; margin-left: 500px;">₹0.00</p>
        </div>
       
        <div id="incomeContainer4" style="display: none; width: 850px;">
            <div class="row" style="display: flex; width: 103%;">
               
           
                <div class="row" style="height:40px; width: 100%; margin-left: 0; display: flex; background: white;">
                    <div class="column" style="display: flex; margin-top: 5px;;">
                        <p style=" margin-left: 270px; font-size: 12px; ">No data to display !!!</p>
                       
                    </div>
    </div>
</div>
 
 
 
</div>
<div class="row" style="height:50px;width:850px;border-radius:5px;border:1px soloid silver;background:#DCDEE0;margin-left:5px;margin-top:15px">
<b style="font-size:14px;margin-left:20px;margin-top:12px">E. Gross Salary (A + C - D)</b>
<p style="font-size:14px;margin-left:720px;margin-top:-17px">₹{{ number_format($employee->calculateTotalAllowance()*12, 2) }} </p>
</div>
</div>
</div>
 
<div class="container" style="width: 106%; margin-left: -16px; margin-top: 100px;">
    <div class="row" style="width: 850px; height: 50px; border-radius: 5px; border: 1px solid silver; margin-left: 12px; background: white; margin-top: 20px;">
        <div class="column" style="display: flex;">
            <p id="expandButton5" style="font-size: 14px; margin-top: 15px; padding-left: 10px; cursor: pointer;">+</p>
            <p style="font-weight: normal; margin-top: 14px; margin-left: 20px;">G. Income From Previous Employer</p>
            <p style="font-weight: normal; margin-top: 14px; margin-left: 450px;">₹0.00</p>
        </div>
       
        <div id="incomeContainer5" style="display: none; width: 850px;">
            <div class="row" style="display: flex; width: 103%;">
                <div class="column" style="height: 40px; background: #AFC8ED; width: 103%; margin-left: 0; display: flex; margin-top: -3px;">
                    <p style="margin-top: 12px; margin-left: 20px; font-size: 13px;">Items</p>
                    <p style="margin-top: 12px; margin-left: 680px; font-size: 13px;">Total</p>
                   
                </div>
                <div style="border: 1px solid silver; height: 1px; width: 98%;"></div>
                <div class="row" style="height: 150px; width: 100%; margin-left: 0; display: flex; background: white;">
                    <div class="column" style="display: flex; margin-top: -5px;">
                        <p style="margin-top: 23px; margin-left: 20px; font-size: 13px; width: 100px;">TOTAL INCOME</p>
                        <p style="margin-top: 24px; margin-left: 620px; font-size: 14px; width: 50px;">0</p>
   
                    </div>
                    <div class="column" style="display: flex; margin-top: -30px;">
                        <p style="margin-top: 23px; margin-left: 18px; font-size: 13px; width: 100px;">INCOME TAX</p>
                        <p style="margin-top: 24px; margin-left: 620px; font-size: 13px; width: 50px;">0</p>
 
                    </div>
                    <div class="column" style="display: flex; margin-top: -30px;">
                        <p style="margin-top: 23px; margin-left: 18px; font-size: 13px; width: 170px;">PROFESSIONAL TAX</p>
                        <p style="margin-top: 24px; margin-left: 550px; font-size: 13px; width: 50px;">0</p>
 
                    </div>
                    <div class="column" style="display: flex; margin-top: -30px;">
                        <p style="margin-top: 23px; margin-left: 18px; font-size: 13px; width: 170px;">PROVIDENT FUND</p>
                        <p style="margin-top: 24px; margin-left: 550px; font-size: 13px; width: 50px;">0</p>
 
                    </div>
                </div>
          </div>
               
 
 
                   
                </div>
             
</div>
</div>
 
</div>
 
 
 
</div>
</div>
</div>
</div>
 
<script>
    function toggleVisibility(buttonId, containerId) {
        const button = document.getElementById(buttonId);
        const container = document.getElementById(containerId);
 
        button.addEventListener('click', function () {
            if (container.style.display === 'none' || container.style.display === '') {
                container.style.display = 'block';
                button.textContent = '-';
            } else {
                container.style.display = 'none';
                button.textContent = '+';
            }
        });
    }
 
    // Call the function for each button-container pair
    toggleVisibility('expandButton', 'incomeContainers');
    toggleVisibility('expandButton2', 'incomeContainer2');
    toggleVisibility('expandButton3', 'incomeContainer3');
    toggleVisibility('expandButton4', 'incomeContainer4');
    toggleVisibility('expandButton5', 'incomeContainer5');
</script>
 
 
</html>
</div>