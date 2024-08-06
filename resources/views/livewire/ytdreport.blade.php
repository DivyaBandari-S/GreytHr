<div>
<style>
 
    .bg-white {
        background-color: white;
    }

    .d-flex {
        display: flex;
    }

    .text-center {
        text-align: center;
    }

    .ml-2 {
        margin-left: 0.5rem;
    }

    .ml-auto {
        margin-left: auto;
    }

    .income-containers {
        display: none;
    }

    .table-responsive {
        overflow-x: auto;
        width: 80%;
        margin: 0 auto;
    }
    .table-row{
        width: 150%;
    }

    .income-table {
        width: 90%; 
        margin: 0 auto;
        border-collapse: collapse;
        font-size: 11px;
     
        table-layout: fixed;
        
    }
    .income{
        width:90%;
    }

    .income-table th, .income-table td {
 
    padding: 10px;
    font-size: 10px;
}

.income-table th, .income-table td {
    width: 80px; /* Set a fixed width for each column */
    min-width: 80px; /* Ensure minimum width */
    max-width: 80px; /* Ensure maximum width */
}


    .table-header {
        background-color: rgb(2, 17, 79);
        color: white;
        font-weight: normal;
        height: 40px;
    }

    .table-row {
        background-color: white;
        color: black;
    }

  

    .report-name {
        font-weight: bold;
    }

    .ytd-links {
        display: flex;
        justify-content: center;
        margin: 20px;
    }

    .btn-group {
        display: flex;
    }

    .btn {
        padding: 10px 20px;
        border: 1px solid #ccc;
        background-color: #f8f8f8;
        color: #333;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #e0e0e0;
    }

    .btn.active {
        background-color:rgb(2, 17, 79);
        color: #fff;
    }

    .text-capitalize {
        text-transform: capitalize;
        font-size: 12px;
    }

    /* Optional: Add some margin between buttons */
    .btn + .btn {
        margin-left: -1px; /* Adjust to remove double border */
    }

    table {
        border-collapse: collapse;
        table-layout: fixed;
    }

    /* Content styles */
    .content {
        display: none;
        text-align: center;
        margin-top: 10px;
    }

    .content.active {
        display: block;
    }
</style>

<div style="width: 100%;"></div>
@if ($salaryRevision->isEmpty())
<div style="align-items:center;justify-content:center;">
<div class="homeCard1" style="width:80%;justify-content:center;align-items:center">
                            <div class="py-2 px-3" style="height:400px;justify-content:center">
                                <div class="d-flex justify-content-center">
                                    <p style="font-size:20px;color:#778899;font-weight:500;align-items:center">YTD Reports</p>
                                    
                                </div>

                                <div style="display:flex;align-items:center;flex-direction:column;">
                                        <img src="data:image/jpeg;base64,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" alt="" style="height:300px;width:300px;">
                                    <p style="color: #677A8E;  margin-bottom: 20px; font-size:12px;"> We are currently working on your YTD Reports!</p>
                                </div>
                            </div>
                        </div>
                        </div>
@else
    <div class="ytd-links">
        <div class="btn-group">
            <button class="btn btn-default {{ $activeTab === 'ytd' ? 'active' : '' }}" wire:click="showContent('ytd')"><span class="text-capitalize">YTD Statement</span></button>
            <button class="btn btn-default {{ $activeTab === 'pfytd' ? 'active' : '' }}" wire:click="showContent('pfytd')"><span class="text-capitalize">PF YTD Statement</span></button>
        </div>
    </div>
    <div class="row">
            <div class="col-md-11 d-flex justify-content-end">
                <a href="/ytdpayslip" id="pdfLink2023_4" class="pdf-download btn-primary px-3 rounded" download style="display: inline-block;background:rgb(2, 17, 79);">
                    <i class="fas fa-download"></i>
                </a>
                <div class="col-md-3">
                @php



    // Calculate the start and end year for the current fiscal year
    $currentFiscalYearStart = ($currentDate->month >= 4) ? $currentDate->year : $currentDate->year - 1;
    $currentFiscalYearEnd = $currentFiscalYearStart + 1;

    // Calculate the start and end year for the previous fiscal year
    $previousFiscalYearStart = $currentFiscalYearStart - 1;
    $previousFiscalYearEnd = $currentFiscalYearStart;

    // Generate the options array
    $options = [
        "{$previousFiscalYearStart}-04-01 - {$previousFiscalYearEnd}-03-31" => "April {$previousFiscalYearStart} - March {$previousFiscalYearEnd}",
        "{$currentFiscalYearStart}-04-01 - {$currentFiscalYearEnd}-03-31" => "April {$currentFiscalYearStart} - March {$currentFiscalYearEnd}"
    ];

    // Default to first option
    $selectedMonth = key($options); // Get the first option as default

    // Handle dropdown selection change
    if (request()->has('selectedMonth')) {
        $selectedMonth = request('selectedMonth');
    }

    // Parse selected fiscal year range
    $selectedYearRange = explode(" - ", $selectedMonth);
    $selectedStartDate = $selectedYearRange[0];
    $selectedEndDate = $selectedYearRange[1];

    // Function to calculate total based on selected fiscal year range
    function calculateTotalForFiscalYear($employee, $startMonth, $endMonth, $startYear, $endYear) {
        $total = 0;
        $currentMonth = date('n');
        $currentYear = date('Y'); // Initialize $currentYear here

        // Loop through months and calculate total
        for ($year = $startYear; $year <= $endYear; $year++) {
            for ($month = ($year == $startYear ? $startMonth : 1); $month <= ($year == $endYear ? $endMonth : 12); $month++) {
                if ($year < $currentYear || ($year == $currentYear && $month < $currentMonth)) {
                    $total += $employee;
                }
            }
        }

        return $total;
    }
@endphp


<div class="mx-2">
<form method="GET" action="">
            <select class="dropdown-salary bg-white px-3 py-1" name="selectedMonth" onchange="this.form.submit()">
                @foreach($options as $value => $label)
                    <option value="{{ $value }}" style="background-color: #fff; color: #333; font-size: 13px;" {{ $selectedMonth == $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </form>

</div>

                </div>
            </div>
        </div>
    <div id="ytd" class="content @if($activeTab === 'ytd') active @endif">
    @foreach($salaryRevision as $employee)
    <div style="display: flex; justify-content: center; align-items: center; ">
    <div class="ytd bg-white" style="width:80%; border-radius:1px; border:1px solid silver; height:40px; display:flex; align-items:center;">
        <b style="margin: 0; margin-left: 5px;">YTD Summary</b>
    </div>
</div>

<div class="table-responsive mt-3">
                    <table class="income-table" >
                        <thead>
                            <tr class="table-header">
                                <th class="report-header pl-3">Items</th>
                                <th class="report-header">Total</th>
                                @php
                            // Initialize an array for month names
                            $monthNames = [
                                4 => 'Apr', 5 => 'May', 6 => 'Jun',
                                7 => 'Jul', 8 => 'Aug', 9 => 'Sep',
                                10 => 'Oct', 11 => 'Nov', 12 => 'Dec',
                                1 => 'Jan', 2 => 'Feb', 3 => 'Mar'
                            ];

                            // Parse selected fiscal year range
                            $selectedStartYear = (int) substr($selectedStartDate, 0, 4);
                            $selectedEndYear = (int) substr($selectedEndDate, 0, 4);

                            // Get the current month and year
                            $currentMonth = date('n');
                            $currentYear = date('Y');

                            // Generate headers based on selected fiscal year range
                            for ($year = $selectedStartYear; $year <= $selectedEndYear; $year++) {
                                for ($month = ($year == $selectedStartYear ? 4 : 1); $month <= ($year == $selectedEndYear ? 3 : 12); $month++) {
                                    echo "<th class='report-header'>" . $monthNames[$month] . " " . ($month <= 12 ? $year : $year + 1) . "</th>";
                                }
                            }
                        @endphp
                        </thead>
                      
            <tr>
                <td colspan="16" class="text-center" >
                    <div class="income  d-flex align-items-center bg-white mt-8" style="height:50px; border-radius:2px; border:1px solid silver;margin-left:-15px">
                        <p id="expandButton" class="mt-3 ml-2" style="font-size: 14px;">+</p>
                        <span class="mx-3" style="font-size:14px">A. Income</span>
                    </div>
                   
                </td>
            </tr>
     
      
            <div class="b" style="width:100%">
            <tbody class="table-body" id="incomeContainers" class="income-containers" style="width:150%">
                           
            @php
                    // Helper function to calculate total up to the last month
                    function calculateTotal($employee, $startMonth, $endMonth, $currentMonth, $currentYear) {
                        $total = 0;
                        $year = $currentYear;
                        for ($month = $startMonth; $month <= 12; $month++) {
                            if ($year < $currentYear || ($year == $currentYear && $month < $currentMonth)) {
                                $total += $employee;
                            }
                        }
                        $year++;
                        for ($month = 1; $month <= $endMonth; $month++) {
                            if ($year < $currentYear || ($year == $currentYear && $month < $currentMonth)) {
                                $total += $employee;
                            }
                        }
                        return $total;
                    }
                @endphp

<tr style="background:white">
                        <td class="report-name">Basic</td>
                        <td class="report-value">
                            @php
                                echo number_format(calculateTotalForFiscalYear($employee->basic, 4, 3, $selectedStartYear, $selectedEndYear), 2);
                            @endphp
                        </td>
                        @for ($year = $selectedStartYear; $year <= $selectedEndYear; $year++)
                            @for ($month = ($year == $selectedStartYear ? 4 : 1); $month <= ($year == $selectedEndYear ? 3 : 12); $month++)
                                <td class="report-value">
                                    @if ($year < $currentYear || ($year == $currentYear && $month < $currentMonth))
                                        {{ number_format($employee->basic, 2) }}
                                    @else
                                        0.00
                                    @endif
                                </td>
                            @endfor
                        @endfor
                    </tr>
                    <!-- Repeat similar <tr> blocks for HRA, Conveyance, Medical, Special Allowance, etc. -->
                    <tr style="background:white">
                        <td class="report-name">HRA</td>
                        <td class="report-value">
                            @php
                                echo number_format(calculateTotalForFiscalYear($employee->hra, 4, 3, $selectedStartYear, $selectedEndYear), 2);
                            @endphp
                        </td>
                        @for ($year = $selectedStartYear; $year <= $selectedEndYear; $year++)
                            @for ($month = ($year == $selectedStartYear ? 4 : 1); $month <= ($year == $selectedEndYear ? 3 : 12); $month++)
                                <td class="report-value">
                                    @if ($year < $currentYear || ($year == $currentYear && $month < $currentMonth))
                                        {{ number_format($employee->hra, 2) }}
                                    @else
                                        0.00
                                    @endif
                                </td>
                            @endfor
                        @endfor
                    </tr>
                    <tr style="background:white">
                        <td class="report-name">Conveyance</td>
                        <td class="report-value">
                            @php
                                echo number_format(calculateTotalForFiscalYear($employee->conveyance, 4, 3, $selectedStartYear, $selectedEndYear), 2);
                            @endphp
                        </td>
                        @for ($year = $selectedStartYear; $year <= $selectedEndYear; $year++)
                            @for ($month = ($year == $selectedStartYear ? 4 : 1); $month <= ($year == $selectedEndYear ? 3 : 12); $month++)
                                <td class="report-value">
                                    @if ($year < $currentYear || ($year == $currentYear && $month < $currentMonth))
                                        {{ number_format($employee->conveyance, 2) }}
                                    @else
                                        0.00
                                    @endif
                                </td>
                            @endfor
                        @endfor
                    </tr>
                    <tr style="background:white">
                        <td class="report-name">Medical</td>
                        <td class="report-value">
                            @php
                                echo number_format(calculateTotalForFiscalYear($employee->medical, 4, 3, $selectedStartYear, $selectedEndYear), 2);
                            @endphp
                        </td>
                        @for ($year = $selectedStartYear; $year <= $selectedEndYear; $year++)
                            @for ($month = ($year == $selectedStartYear ? 4 : 1); $month <= ($year == $selectedEndYear ? 3 : 12); $month++)
                                <td class="report-value">
                                    @if ($year < $currentYear || ($year == $currentYear && $month < $currentMonth))
                                        {{ number_format($employee->medical, 2) }}
                                    @else
                                        0.00
                                    @endif
                                </td>
                            @endfor
                        @endfor
                    </tr>
                    <tr style="background:white">
                        <td class="report-name">Special Allowance</td>
                        <td class="report-value">
                            @php
                                echo number_format(calculateTotalForFiscalYear($employee->special, 4, 3, $selectedStartYear, $selectedEndYear), 2);
                            @endphp
                        </td>
                        @for ($year = $selectedStartYear; $year <= $selectedEndYear; $year++)
                            @for ($month = ($year == $selectedStartYear ? 4 : 1); $month <= ($year == $selectedEndYear ? 3 : 12); $month++)
                                <td class="report-value">
                                    @if ($year < $currentYear || ($year == $currentYear && $month < $currentMonth))
                                        {{ number_format($employee->special, 2) }}
                                    @else
                                        0.00
                                    @endif
                                </td>
                            @endfor
                        @endfor
                    </tr>
                    <tr style="background:white">
                        <td class="report-name">Total Allowance</td>
                        <td class="report-value">
                            @php
                                echo number_format(calculateTotalForFiscalYear($employee->calculateTotalAllowance(), 4, 3, $selectedStartYear, $selectedEndYear), 2);
                            @endphp
                        </td>
                        @for ($year = $selectedStartYear; $year <= $selectedEndYear; $year++)
                            @for ($month = ($year == $selectedStartYear ? 4 : 1); $month <= ($year == $selectedEndYear ? 3 : 12); $month++)
                                <td class="report-value">
                                    @if ($year < $currentYear || ($year == $currentYear && $month < $currentMonth))
                                        {{ number_format($employee->calculateTotalAllowance(), 2) }}
                                    @else
                                        0.00
                                    @endif
                                </td>
                            @endfor
                        @endfor
                    </tr>
                </tbody>
          </div>
      
            <tr >
                <td colspan="16" class="text-center;margin-top:10px" >
                    <div class="income  d-flex align-items-center bg-white mt-8" style="height:50px; border-radius:2px; border:1px solid silver;margin-left:-15px">
                        <p id="expandButton2" class="mt-3 ml-2" style="font-size: 14px;">+</p>
                        <span class="mx-3" style="font-size:14px">B.Deductions</span>
                    </div>
                   
                </td>
            </tr>
     
            <div class="c" style="width:150%">
    <tbody class="table-body" id="incomeContainer2" class="income-containers" style="width:150%">
        <tr style="background:white">
            <td class="report-name">PF</td>
            <td class="report-value">
                @php
                    echo number_format(calculateTotalForFiscalYear($employee->calculatePf(), 4, 3, $selectedStartYear, $selectedEndYear), 2);
                @endphp
            </td>
            @for ($year = $selectedStartYear; $year <= $selectedEndYear; $year++)
                @for ($month = ($year == $selectedStartYear ? 4 : 1); $month <= ($year == $selectedEndYear ? 3 : 12); $month++)
                    <td class="report-value">
                        @if ($year < $currentYear || ($year == $currentYear && $month < $currentMonth))
                            {{ number_format($employee->calculatePf(), 2) }}
                        @else
                            0.00
                        @endif
                    </td>
                @endfor
            @endfor
        </tr>

        <tr style="background:white">
            <td class="report-name">Prof Tax</td>
            <td class="report-value">
                @php
                    echo number_format(calculateTotalForFiscalYear(150, 4, 3, $selectedStartYear, $selectedEndYear), 2);
                @endphp
            </td>
            @for ($year = $selectedStartYear; $year <= $selectedEndYear; $year++)
                @for ($month = ($year == $selectedStartYear ? 4 : 1); $month <= ($year == $selectedEndYear ? 3 : 12); $month++)
                    <td class="report-value">
                        @if ($year < $currentYear || ($year == $currentYear && $month < $currentMonth))
                            {{ number_format(150, 2) }}
                        @else
                            0.00
                        @endif
                    </td>
                @endfor
            @endfor
        </tr>

        <tr style="background:white">
            <td class="report-name">Total</td>
            <td class="report-value">
                @php
                    echo number_format(calculateTotalForFiscalYear($employee->calculatePf() + 150, 4, 3, $selectedStartYear, $selectedEndYear), 2);
                @endphp
            </td>
            @for ($year = $selectedStartYear; $year <= $selectedEndYear; $year++)
                @for ($month = ($year == $selectedStartYear ? 4 : 1); $month <= ($year == $selectedEndYear ? 3 : 12); $month++)
                    <td class="report-value">
                        @if ($year < $currentYear || ($year == $currentYear && $month < $currentMonth))
                            {{ number_format($employee->calculatePf() + 150, 2) }}
                        @else
                            0.00
                        @endif
                    </td>
                @endfor
            @endfor
        </tr>
    </tbody>
</div>
</table>
    @endforeach
    </div>
    </div>

    <div id="pfytd" class="content @if($activeTab === 'pfytd') active @endif">
        
        <div class="row mt-5">
        <div class="col-md-7" style="background-color: white; height: 300px; border-radius: 5px; border: 1px solid silver; margin-left:40px">
         
        <div class="row" style="height: 40px; display: flex; justify-content: flex-start; align-items: center; border-bottom: 1px solid #ccc;">
    PF YTD SUMMARY
</div>

@php
  


    // Get the current date
    $currentDate = Carbon::now();

    // Calculate the start and end year for the current fiscal year
    $currentFiscalYearStart = ($currentDate->month >= 4) ? $currentDate->year : $currentDate->year - 1;
    $currentFiscalYearEnd = $currentFiscalYearStart + 1;

    // Function to get monthly details for PF summary
    function getMonthlyDetails($employee, $startMonth, $endMonth, $startYear, $endYear) {
        $details = [];
        $monthNames = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
        ];

        // Get the current date
        $currentDate = Carbon::now();
        $currentMonth = $currentDate->month;
        $currentYear = $currentDate->year;

        // Calculate start and end month based on current date
        $start = max($startMonth, 4); // Start from April
        $end = min($currentMonth - 1, $endMonth); // Up to last completed month or defined end month

        for ($year = $startYear; $year <= $endYear; $year++) {
            for ($month = ($year == $startYear ? $start : 1); $month <= ($year == $endYear ? $end : 12); $month++) {
                $isFutureMonth = ($year > $currentYear || ($year == $currentYear && $month > $currentMonth));
                if ($isFutureMonth) {
                    break 2; // Break both loops if it's a future month
                }
                $monthDetail = [
                    'month' => $monthNames[$month] . " " . $year,
                    'earnings' => $employee->basic, // Assuming earnings is basic for simplification
                    'vpf' => $employee->vpf ?? 0, // Assuming VPF value is present in employee object
                    'pf' => $employee->calculatePf() ?? 0  // Assuming PF value is present in employee object
                ];
                $details[] = $monthDetail;
            }
        }
        return $details;
    }

    // Get monthly details for the current fiscal year up to the last 3 completed months
    $monthlyDetails = getMonthlyDetails($employee, 4, 3, $currentFiscalYearStart, $currentFiscalYearEnd);
@endphp

<div class="row" style="height: 20px;"></div> <!-- One line space -->

<div class="table-responsive mt-3">
    <table class="income-table">
        <thead>
            <tr class="table-header">
                <th class="report-header pl-3">Month</th>
                <th class="report-header">Earnings</th>
                <th class="report-header">VPF</th>
                <th class="report-header">PF</th>
            </tr>
        </thead>
        <tbody class="table-body">
            @foreach($monthlyDetails as $detail)
                <tr style="background:white">
                    <td class="report-name">{{ $detail['month'] }}</td>
                    <td class="report-value">{{ number_format($detail['earnings'], 2) }}</td>
                    <td class="report-value">{{ number_format($detail['vpf'], 2) }}</td>
                    <td class="report-value">{{ number_format($detail['pf'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>




 
            </div>
            <div class="col-md-3 ml-3">
                <div class="employee-details-container  px-3  rounded" style="background-color: #ffffe8;">
                    <div class="mt-3 d-flex justify-content-between">
                        <h6 style="color: #778899;font-weight:500;">Employee details</h6>
                        <p style="font-size: 12px; cursor: pointer;color:deepskyblue;font-weight:500;" wire:click="toggleDetails">
                            {{ $Details ? 'Hide' : 'Info' }}
                        </p>
                    </div>
                    @if ($Details)
                    <div class="align-items-start">
    <div class="details-column d-flex flex-column align-items-start">
        @foreach($employees as $employee)
        <div class="detail align-items-start">
                <p class="emp-details-p">Employee ID <br>
                    <span class="emp-details-span">{{ ucwords(strtolower($employee->emp_id)) }} </span>
                </p>
            </div>
            <div class="detail align-items-start">
                <p class="emp-details-p">Full Name <br>
                    <span class="emp-details-span">{{ ucwords(strtolower($employee->first_name)) }} {{ ucwords(strtolower($employee->last_name)) }}</span>
                </p>
            </div>
            <div class="detail align-items-start">
                <p class="emp-details-p">Joining Date <br>
                    <span class="emp-details-span">{{ date('d M Y', strtotime($employee->hire_date)) }}</span>
                </p>
            </div>
            <div class="detail align-items-start">
                <p class="emp-details-p"> PF Number<br>
                    <span class="emp-details-span">{{ ucwords(strtolower($employee->pf_no ?? '-')) }}</span>
                </p>
            </div>
            @foreach($empBankDetails as $bankDetail)
                <div class="detail">
                    <p class="emp-details-p">Bank Name <br>
                        <span class="emp-details-span">
                            {{ empty($bankDetail->bank_name) ? 'N/A' : ucwords(strtolower($bankDetail->bank_name)) }}
                        </span>
                    </p>
                </div>
          
            @endforeach
        
        @endforeach
    </div>
</div>


                    @endif
                </div>
            </div>
  
    </div>
    </div>
    @endif
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('contentChanged', contentId => {
                var contents = document.querySelectorAll('.content');
                contents.forEach(function(content) {
                    if (content.id === contentId) {
                        content.classList.add('active');
                    } else {
                        content.classList.remove('active');
                    }
                });
            });
        });
   
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
 
</div>
