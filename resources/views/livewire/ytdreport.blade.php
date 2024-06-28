<div style="width: 800px;">
<style>
    .row {
        margin-left: 0; /* Remove extra margin */
        margin-right: 0; /* Remove extra margin */
    }

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
    use Carbon\Carbon;

    // Get the current date
    $currentDate = Carbon::now();

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
        <div class="col-md-8" style="background-color: white; height: 300px; border-radius: 5px; border: 1px solid silver;">
         
        <div class="row" style="height: 40px; display: flex; justify-content: flex-start; align-items: center; border-bottom: 1px solid #ccc; ">
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
