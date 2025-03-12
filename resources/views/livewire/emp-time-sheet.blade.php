<div class="container">
    <style>
        @media (max-width: 768px) {

            .submission-header,
            .timesheet-type-header,
            .date-header,
            .day-header,
            .hours-header,
            .employee-header {
                width: 100%;
                /* Stack headers vertically on tablets */
                text-align: center;
            }

            .date-column,
            .day-column,
            .clients-column,
            .projects-column,
            .remarks-column,
            .hours-column,
            .tasks-column {
                width: 100%;
                /* Stack columns vertically on smaller screens */
                text-align: center;
            }
        }

        @media (max-width: 480px) {

            .team-time-sheets-table td,
            .team-time-sheets-table th {
                font-size: 0.8rem;
                /* Adjust font size for mobile */
                padding: 8px;
                /* Increase padding for touch targets */
            }

            .approve-manager,
            .reject-manager,
            .resubmit-manager {
                font-size: 16px;
                /* Increase font size for readability */
                padding: 10px;
                /* Increase padding for better touch interaction */
            }

            .toggle-icon {
                font-size: 24px;
                /* Larger toggle icon for better touch interaction */
            }
        }

        .team-time-sheets-table {
            width: 100%;
            border-collapse: collapse;
        }

        .team-time-sheets-table td,
        .team-time-sheets-table th {
            padding: 5px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .team-time-sheets-table th {
            font-size: 0.8rem;
            background-color: rgba(2, 17, 79);
            color: white;
            font-weight: 600;
        }

        .team-time-sheets-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .team-time-sheets-table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .team-time-sheets-table tbody tr:hover {
            background-color: #d0dbe5;
        }

        .team-time-sheets-table td {
            color: #333;
        }

        .data-row {
            cursor: pointer;
        }

        .toggle-icon {
            cursor: pointer;
            display: inline-block;
            font-size: 16px;
        }

        .toggle-icon i {
            transition: transform 0.3s;
        }

        .detail-row {
            display: none;
            background-color: #f9f9f9;
        }

        .detail-row.open {
            display: table-row;
        }

        .toggle-icon.open i {
            transform: rotate(45deg);
            color: red
        }

        .date-column,
        .day-column,
        .clients-column,
        .projects-column,
        .remarks-column,
        .hours-column,
        .tasks-column {
            padding: 0.5rem;
        }

        .date-column {
            width: 7%;
        }

        .day-column {
            width: 5%;
        }

        .clients-column {
            width: 10%;
        }

        .projects-column {
            width: 10%;
        }

        .remarks-column {
            width: 10%;
        }

        .hours-column {
            width: 5%;
        }

        .tasks-column {
            width: 20%;
        }

        .tasks-column,
        .remarks-column,
        .projects-column,
        .remarks-column,
        .clients-column,
        .clients-header,
        .projects-header,
        .tasks-header,
        .remarks-header {
            text-transform: capitalize
        }

        .filter-container {
            max-width: 100%;
            padding: 5px;
            background-color: #ffffff;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .filter-container h2 {
            padding: 5px;
            margin-top: 0;
            color: #333;
        }

        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            /* Space between form fields */
        }

        .filter-row>div {
            flex: 1;
            min-width: 100px;
            /* Adjust minimum width as needed */
        }

        .filter-container label {
            display: block;
            margin: 0;
            font-size: 0.8rem;
            font-weight: 600;
            color: #555;
            margin-bottom: 2px;
        }

        .filter-container input[type="text"],
        .filter-container input[type="date"],
        .filter-container select {
            width: 100%;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 8px;
            font-size: 0.8rem;
        }

        .filter-container input[type="text"]:focus,
        .filter-container input[type="date"]:focus,
        .filter-container select:focus {
            border-color: #007BFF;
            outline: none;
        }

        .filter-heading {
            color: rgb(2, 17, 79);
            font-weight: 600;
            font-size: 1rem;
            padding: 5px;
            text-align: center;
        }


        .totalHoursContainer {
            background-color: #f7fafc;
            border: 1px solid #ddd;
            border-radius: 0.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.25rem;
        }

        .totalDays {
            font-size: 0.8rem;
            font-weight: 500;
            color: #778899;
        }

        .btn-export {
            display: inline-block;
            font-size: 0.8rem;
            color: rgba(2, 17, 79, 0.5);
            padding: 0px;
            border: none;
            border-radius: 0.25rem;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        .btn-export i {
            margin-right: 0.1rem;
        }

        .timeValue {
            color: #000;
            font-weight: 500;
            font-size: 12px;
        }

        .task-table {
            width: 100%;
            border-collapse: collapse;
        }

        .task-table td {
            border: 1px solid #ddd;
            padding: 0px;
            color: #778899;
            text-align: center;
            font-size: 12px;
        }

        .task-table th {
            border: 1px solid #ddd;
            padding: 0.3rem;
            text-align: center;
            font-size: 0.8rem;
        }

        .task-table thead {
            background-color: rgba(2, 17, 79);
            color: white;
        }

        .task-table tbody tr:nth-child(even) {
            background-color: #f7fafc;
        }

        .task-table tbody tr:nth-child(odd) {
            background-color: #edf2f7;
        }

        .task-table tbody tr.weekend {
            background-color: #BAE0FF
        }

        .task-table input[type="text"] {
            text-align: center;
            padding: 5px;
            border: none;
            background: transparent;
            box-sizing: border-box;
        }

        .task-table textarea {
            text-align: center;
            padding: 0;
            height: 26px;
            border: none;
            background: transparent;
            box-sizing: border-box;
        }

        .task-table input[type="text"][readonly],
        .task-table textarea[readonly] {
            pointer-events: none;
        }

        .task-table input[type="text"]:invalid,
        .task-table textarea:invalid {
            border: 1px solid red;
        }

        .even-td {
            height: 100%;
            background-color: #e0f7fa;
            color: #333;
        }

        .odd-td {
            height: 100%;
            background-color: #b2ebf2;
            color: #333;
        }

        /* Base Styles */
        .timesheetContainer {
            width: 100%;
            max-width: 1200px;
            margin: auto;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            /* Adjusted for better spacing */
        }

        .input-label {
            font-size: 0.8rem;
            font-weight: 500;
            color: #778899;
            margin-bottom: 0.5rem;
        }

        .inputValue {
            margin-left: 0.5rem;
            font-size: 0.8rem;
            color: #000;
        }

        .error-message {
            color: #e53e3e;
            font-size: 0.8rem;
        }

        /* Flexbox Alignment */
        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        /* Responsive Styles */
        @media (max-width: 1200px) {
            .input-label {
                font-size: 0.8rem;
            }

            .inputValue {
                font-size: 0.8rem;
            }

            .error-message {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 992px) {
            .input-label {
                font-size: 0.75rem;
            }

            .inputValue {
                font-size: 0.75rem;
            }

            .error-message {
                font-size: 0.75rem;
            }

            .col-md-6,
            .col-md-3 {
                padding: 0;
                /* Adjusts padding for medium screens */
            }
        }

        @media (max-width: 768px) {
            .input-label {
                font-size: 0.7rem;
            }

            .inputValue {
                font-size: 0.7rem;
            }

            .error-message {
                font-size: 0.7rem;
            }

            .col-12 {
                margin-bottom: 1rem;
            }

            .row {
                gap: 0.5rem;
            }

        }

        @media (max-width: 576px) {
            .input-label {
                font-size: 0.65rem;
            }

            .inputValue {
                font-size: 0.65rem;
            }

            .error-message {
                font-size: 0.65rem;
            }

            .timesheetContainer {
                padding: 0.5rem;
            }

            .col-12 {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        .tabs-btn {
            padding: 0.5rem 1rem;
            border: 2px solid transparent;
            cursor: pointer;
            margin: 0 0.6rem;
            font-size: 0.8rem;
            font-weight: bold;
            border-radius: 8px;
            background: #f7f7f7;
            color: #333;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .tabs-btn.active {
            background: rgba(2, 17, 79, 1);
            color: white;
            border: 2px solid rgba(2, 17, 79, 1);
            box-shadow: 0 8px 16px rgba(2, 17, 79, 0.3);
            transform: translateY(-2px) scale(1.05);
        }

        .tabs-btn.inactive {
            background: white;
            color: #555;
            border: 2px solid #e0e0e0;
        }

        .tabs-btn:hover {
            background: rgba(2, 17, 79, 0.8);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 6px 12px rgba(2, 17, 79, 0.3);
        }

        .tabs-btn:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(2, 17, 79, 0.4);
        }

        .tabs-btn:active {
            transform: translateY(0);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
        }
    </style>


    <div class="row">
        <div style="text-align: center; margin-top: 1rem;">
            <button
                type="button"
                class="tabs-btn {{ $activeTab === 'timeSheets' ? 'active' : 'inactive' }}"
                wire:click="setActiveTab('timeSheets')">
                Time Sheet
            </button>
            <button
                type="button"
                class="tabs-btn {{ $activeTab === 'history' ? 'active' : 'inactive' }}"
                wire:click="setActiveTab('history')">
                History
            </button>
        </div>
    </div>
    <div class="timesheetContainer mt-2 bg-white p-2 mx-auto {{ $activeTab == 'timeSheets' ? '' : 'd-none' }}">
        <div class="row m-0 p-0">
            <!-- Employee Information -->
            <div class="col-12 col-md-5 d-flex flex-column flex-md-row align-items-start align-items-md-center  p-0 m-0">
                <label for="emp_id" class="input-label mb-2 mb-md-0">Employee :</label>
                @if ($employeeName)
                <div class="d-flex flex-column flex-md-row">
                    <span class="inputValue mb-1 mb-md-0">{{ ucwords(strtolower($employeeName->first_name)) }}
                        {{ ucwords(strtolower($employeeName->last_name)) }}</span>
                    <span class="inputValue">(#{{ $employeeName->emp_id }})</span>
                </div>
                @endif
            </div>

            <!-- Start Date -->
            <div class="col-12 col-md-3 d-flex flex-column flex-md-row align-items-start align-items-md-center p-0 m-0">
                <label for="start_date" class="input-label mb-2 mb-md-0">Start Date :</label>
                @php
                use Carbon\Carbon;
                $default_start_date = now()
                ->startOfWeek(Carbon::MONDAY)
                ->format('Y-m-d');
                @endphp
                <div class="d-flex flex-column flex-md-row align-items-start">
                    <input max="{{ now()->format('Y-m-d') }}" type="date" wire:change="addTask"
                        name="default_start_date" id="start_date"
                        class="inputValue border rounded py-1 px-2 outline-none"
                        value="{{ old('default_start_date', $default_start_date) }}" wire:model="start_date_string">
                    <input type="hidden" id="formatted_default_start_date"
                        value="{{ \Carbon\Carbon::parse($default_start_date)->format('d-m-Y') }}">
                </div>
                @error('start_date_string')
                <span class="error-message mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Time Sheet Type -->
            <div
                class="col-12 col-md-3 d-flex flex-column flex-md-row align-items-start align-items-md-center  p-0 m-0">
                <div class="d-flex flex-column flex-md-row align-items-start">
                    <label for="time_sheet_type" class="input-label mb-2 mb-md-0">Time Sheet Type :</label>
                    <div class="d-flex align-items-start">
                        <label class="d-flex align-items-center mb-0">
                            <div wire:change="addTask" wire:model="time_sheet_type" name="time_sheet_type"
                                value="weekly" class="inputValue mb-0"> Weekly</div>
                        </label>
                    </div>
                </div>
                @error('time_sheet_type')
                <span class="error-message mt-2">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    @if($activeTab == 'timeSheets')
    @if ($defaultTimesheetEntry == '')
    <div class="container"
        style="width:100%;max-width:{{ count($client_names) > 0 ? '100%' : '100%' }};padding: 0.6rem; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <div class="subTotalExceed">
            @php
            $subTotalExceed = false;
            @endphp
            @foreach ($default_date_and_day_with_tasks as $index => $task)
            @if (count($client_names) >= 1)
            @php
            $totalHours = array_sum($task['hours']);
            $subTotalExceed = $totalHours > 24;
            @endphp
            @endif
            <div>
                @if (count($client_names) >= 2)
                @if ($subTotalExceed)
                <div style="text-align:center">
                    <span style="color: red; font-size: 0.8rem;">Subtotal hours cannot exceed 24.</span>
                </div>
                @endif
                @endif
            </div>
            @endforeach
        </div>

        <form wire:submit.prevent="defaultSubmit">
            <div style="text-align: end; ">
                <a class="btn btn-export" wire:click="exportCSV">
                    <i class="fas fa-file-csv"></i> Export CSV
                </a>
                <a class="btn btn-export" wire:click="exportExcel">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
            </div>
            <div class="table-responsive">
                <table class="task-table">
                    <thead>
                        <tr>
                            <th class="date-header">Dates</th>
                            <th class="day-header">Days</th>
                            @if (count($client_names) > 0)
                            <th class="client-header">Clients</th>
                            @endif
                            @if (count($client_names) > 0 && count($dTasks) > 0)
                            <th class="project-header">Projects</th>
                            <th class="remarks-header">Remarks</th>
                            @endif
                            <th class="hours-header">Hours</th>
                            <th class="tasks-header">Tasks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($default_date_and_day_with_tasks as $index => $taskData)
                        @php
                        $date = \Carbon\Carbon::parse($taskData['date']);
                        $formattedDate = $date->format('d-M-Y');
                        $isWeekend = $date->isWeekend();
                        $rowColor = $isWeekend ? '#BAE0FF;' : ($index % 2 === 0 ? '#f7fafc' : '#edf2f7');
                        @endphp
                        <tr style="padding:0; background-color: {{ $rowColor }};">
                            <td class="date-header py-0">
                                <input type="text" value="{{ $formattedDate }}" readonly>
                            </td>
                            <td class="day-header py-0">
                                <input type="text" readonly
                                    wire:model="default_date_and_day_with_tasks.{{ $index }}.day">
                            </td>

                            <!-- Clients Column -->
                            @if (count($taskData['clients']) >= 1)
                            <td class="client-header py-0">
                                @foreach ($taskData['clients'] as $clientIndexForDTS => $client)
                                @php
                                // Retrieve the max height for this client
                                $clientHeightForDTS =
                                $taskData['maxHeights'][$clientIndexForDTS] ?? 'auto';
                                @endphp
                                @if (empty($clientHeightForDTS) || $clientHeightForDTS == '0')
                                <div class="{{ $clientIndexForDTS % 2 == 0 ? 'even-td' : 'odd-td' }}"
                                    style="height:30px;">
                                    <input type="text" readonly value="{{ $client }}">
                                </div>
                                @else
                                <div class="{{ $clientIndexForDTS % 2 == 0 ? 'even-td' : 'odd-td' }}"
                                    style="height: {{ $clientHeightForDTS }}px;">
                                    <input type="text" readonly value="{{ $client }}">
                                </div>
                                @endif
                                @endforeach
                            </td>
                            @endif

                            <!-- Projects Column -->
                            @if (isset($dTasks) && count($dTasks) > 0)
                            @if (isset($taskData['projects']) && count($taskData['projects']) > 0)
                            <td class="project-header py-0">
                                @foreach ($taskData['projects'] as $projectIndexForDTS => $projectArray)
                                @php
                                // Calculate height based on the number of projects
                                $projectHeightForDTS =
                                count($projectArray) > 0 ? count($projectArray) * 30 : 30; // Default to 50px if empty
                                @endphp
                                <div class="{{ $projectIndexForDTS % 2 == 0 ? 'even-td' : 'odd-td' }}"
                                    style="height: {{ $projectHeightForDTS }}px;">
                                    @if (empty($projectArray))
                                    <input type="text" readonly value="--">
                                    @else
                                    @foreach ($projectArray as $project)
                                    <input type="text" readonly
                                        value="{{ $project }}">
                                    @endforeach
                                    @endif
                                </div>
                                @endforeach
                            </td>
                            @endif

                            <!-- Remarks Column -->
                            @if (isset($taskData['remarks']) && count($taskData['remarks']) > 0)
                            <td class="remarks-header py-0">
                                @foreach ($taskData['remarks'] as $remarksIndexForDTS => $remarksArray)
                                @php
                                // Calculate height based on the number of remarks
                                $remarksHeightForDTS =
                                count($remarksArray) > 0 ? count($remarksArray) * 30 : 30; // Default to 20px if empty
                                @endphp
                                <div class="{{ $remarksIndexForDTS % 2 == 0 ? 'even-td' : 'odd-td' }}"
                                    style="height: {{ $remarksHeightForDTS }}px;">
                                    @if (empty($remarksArray))
                                    <input type="text" readonly value="--">
                                    @else
                                    @foreach ($remarksArray as $remark)
                                    <input type="text" readonly
                                        value="{{ $remark }}">
                                    @endforeach
                                    @endif
                                </div>
                                @endforeach
                            </td>
                            @endif
                            @endif

                            <!-- Hours Column -->
                            <td class="hours-header py-0">
                                @if (count($taskData['clients']) >= 1)
                                @foreach ($default_date_and_day_with_tasks[$index]['hours'] as $hourIndex => $hour)
                                <input type="text"
                                    wire:model="default_date_and_day_with_tasks.{{ $index }}.hours.{{ $hourIndex }}"
                                    wire:change="defaultSaveTimeSheet" pattern="[0-9]*(\.[0-9]{1,2})?"
                                    title="Please enter a number between 0.0 and 24, with up to 2 decimal places"
                                    @error('default_date_and_day_with_tasks.' . $index . '.hours.' . $hourIndex) class="error" @enderror>
                                @error('default_date_and_day_with_tasks.' . $index . '.hours.' .
                                $hourIndex)
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                                @endforeach
                                @else
                                <input type="text"
                                    wire:model="default_date_and_day_with_tasks.{{ $index }}.hours"
                                    wire:change="defaultSaveTimeSheet" pattern="[0-9]*(\.[0-9]{1,2})?"
                                    title="Please enter a number between 0.0 and 24, with up to 2 decimal places"
                                    @error('default_date_and_day_with_tasks.' . $index . '.hours' ) class="error" @enderror>
                                @error('default_date_and_day_with_tasks.' . $index . '.hours')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                                @endif
                            </td>

                            <!-- Tasks Column -->
                            <td class="tasks-header py-0">
                                @if (count($taskData['clients']) >= 1)
                                @foreach ($default_date_and_day_with_tasks[$index]['tasks'] as $taskIndex => $taskDescription)
                                <textarea style="text-align: left;margin-left:5px"
                                    wire:model="default_date_and_day_with_tasks.{{ $index }}.tasks.{{ $taskIndex }}"
                                    wire:change="defaultSaveTimeSheet" title="Enter tasks"
                                    @error('default_date_and_day_with_tasks.' . $index . '.tasks.' . $taskIndex) class="error" @enderror></textarea><br>
                                @endforeach
                                @else
                                <textarea style="text-align: left;margin-left:5px"
                                    wire:model="default_date_and_day_with_tasks.{{ $index }}.tasks" wire:change="defaultSaveTimeSheet"
                                    title="Enter tasks" @error('default_date_and_day_with_tasks.' . $index . '.tasks' ) class="error" @enderror></textarea><br>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="totalHoursContainer py-2">
                <div style="text-align: center; flex-grow: 1;">
                    <div class="row m-0 p-0 d-flex align-items-center">
                        <div class="col">
                            <p class="totalDays mb-0">Total days : <span
                                    class="timeValue">{{ $defaultTotalDays }}</span> </p>
                        </div>
                        <div class="col">
                            <p class="totalDays mb-0">Total hours : <span
                                    class="timeValue">{{ $allDefaultTotalHours }}</span> </p>
                        </div>
                    </div>
                </div>
            </div>

            @if ($timeSheetSubmitted==true)
            @else
            <div style="text-align: center; margin-top: 1rem;">
                <button type="button" wire:click="defaultSave" class="submit-btn">Save</button>
                <button type="submit" class="submit-btn">Submit</button>
            </div>
            @endif


        </form>

    </div>
    @elseif($defaultTimesheetEntry == 'ts')
    <div class="container"
        style="width:100%;max-width:{{ count($client_names) > 0 ? '100%' : '100%' }};padding: 0.6rem; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <div class="subTotalExceed">
            @php
            $subTotalExceed = false;
            @endphp
            @foreach ($date_and_day_with_tasks as $index => $task)
            @if (count($client_names) >= 1)
            @php
            $totalHours = array_sum($task['hours']);
            $subTotalExceed = $totalHours > 24;
            @endphp
            @endif
            <div>
                @if (count($client_names) >= 2)
                @if ($subTotalExceed)
                <div style="text-align:center">
                    <span style="color: red; font-size: 0.8rem;">Subtotal hours cannot exceed
                        24.</span>
                </div>
                @endif
                @endif

            </div>
            @endforeach
        </div>

        <form wire:submit.prevent="submit">
            <div style="text-align: end; ">
                <a class="btn btn-export" wire:click="exportCSV">
                    <i class="fas fa-file-csv"></i> Export CSV
                </a>
                <a class="btn btn-export" wire:click="exportExcel">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
            </div>
            <div class="table-responsive">
                <table class="task-table">
                    <thead>
                        <tr>
                            <th class="date-header">Dates</th>
                            <th class="day-header">Days</th>
                            @if (count($client_names) > 0)
                            <th class="client-header">Clients</th>
                            @endif
                            @if (count($client_names) > 0 && count($tasks) > 0)
                            <th class="project-header">Projects</th>
                            <th class="remarks-header">Remarks</th>
                            @endif
                            <th class="hours-header">Hours</th>
                            <th class="tasks-header">Tasks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($date_and_day_with_tasks as $index => $task)
                        @php
                        $date = \Carbon\Carbon::parse($task['date']);
                        $formattedDate = $date->format('d-M-Y');
                        $isWeekend = $date->isWeekend();
                        $rowColor = $isWeekend ? '#BAE0FF;' : ($index % 2 === 0 ? '#f7fafc' : '#edf2f7');
                        @endphp
                        <tr style="padding:0; background-color: {{ $rowColor }};">
                            <td class="date-header py-0">
                                <input type="text" value="{{ $formattedDate }}" readonly>
                            </td>
                            <td class="day-header py-0">
                                <input type="text" readonly
                                    wire:model="date_and_day_with_tasks.{{ $index }}.day">
                            </td>

                            <!-- Clients Column -->
                            @if (count($task['clients']) >= 1)
                            <td class="client-header py-0">
                                @foreach ($task['clients'] as $clientIndexForTs => $client)
                                @php
                                // Retrieve the max height for this client
                                $clientHeight = $task['maxHeights'][$clientIndexForTs] ?? 'auto';
                                @endphp
                                @if ($clientHeight === 'auto' || $clientHeight == '0')
                                <div class="{{ $clientIndexForTs % 2 == 0 ? 'even-td' : 'odd-td' }}"
                                    style="height: 30px;">
                                    <input type="text" readonly value="{{ $client }}">
                                </div>
                                @else
                                <div class="{{ $clientIndexForTs % 2 == 0 ? 'even-td' : 'odd-td' }}"
                                    style="height: {{ $clientHeight }}px;">
                                    <input type="text" readonly value="{{ $client }}">
                                </div>
                                @endif
                                @endforeach
                            </td>
                            @endif

                            <!-- Projects Column -->
                            @if (isset($tasks) && count($tasks) > 0)
                            @if (isset($task['projects']) && count($task['projects']) > 0)
                            <td class="project-header py-0">
                                @foreach ($task['projects'] as $projectIndexForTs => $projectArray)
                                @php
                                // Calculate height based on the number of projects
                                $projectHeight =
                                count($projectArray) > 0 ? count($projectArray) * 30 : 30; // Adjust 24px based on your styling needs
                                @endphp
                                <div class="{{ $projectIndexForTs % 2 == 0 ? 'even-td' : 'odd-td' }}"
                                    style="height: {{ $projectHeight }}px;">
                                    @if (empty($projectArray))
                                    <input type="text" readonly value="--">
                                    @else
                                    @foreach ($projectArray as $project)
                                    <input type="text" readonly
                                        value="{{ $project }}">
                                    @endforeach
                                    @endif
                                </div>
                                @endforeach
                            </td>
                            @endif
                            @endif

                            <!-- Remarks Column -->
                            @if (isset($tasks) && count($tasks) > 0)
                            @if (isset($task['remarks']) && count($task['remarks']) > 0)
                            <td class="remarks-header py-0">
                                @foreach ($task['remarks'] as $remarksIndexForTs => $remarksArray)
                                @php
                                // Calculate height based on the number of remarks
                                $remarksHeight =
                                count($remarksArray) > 0 ? count($remarksArray) * 30 : 30; // Adjust 24px based on your styling needs
                                @endphp
                                <div class="{{ $remarksIndexForTs % 2 == 0 ? 'even-td' : 'odd-td' }}"
                                    style="height: {{ $remarksHeight }}px;">
                                    @if (empty($remarksArray))
                                    <input type="text" readonly value="--">
                                    @else
                                    @foreach ($remarksArray as $remark)
                                    <input type="text" readonly
                                        value="{{ $remark }}">
                                    @endforeach
                                    @endif
                                </div>
                                @endforeach
                            </td>
                            @endif
                            @endif

                            <!-- Hours Column -->
                            <td class="hours-header py-0">
                                @if (count($client_names) >= 1)
                                @foreach ($date_and_day_with_tasks[$index]['hours'] as $hourIndex => $hour)
                                <input type="text"
                                    wire:model="date_and_day_with_tasks.{{ $index }}.hours.{{ $hourIndex }}"
                                    wire:change="saveTimeSheet" pattern="[0-9]*(\.[0-9]{1,2})?"
                                    title="Please enter a number between 0.0 and 24, with up to 2 decimal places"
                                    @error('date_and_day_with_tasks.' . $index . '.hours.' . $hourIndex) class="error" @enderror>
                                @error('date_and_day_with_tasks.' . $index . '.hours.' . $hourIndex)
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                                @endforeach
                                @else
                                <input type="text"
                                    wire:model="date_and_day_with_tasks.{{ $index }}.hours"
                                    wire:change="saveTimeSheet" pattern="[0-9]*(\.[0-9]{1,2})?"
                                    title="Please enter a number between 0.0 and 24, with up to 2 decimal places"
                                    @error('date_and_day_with_tasks.' . $index . '.hours' ) class="error" @enderror>
                                @error('date_and_day_with_tasks.' . $index . '.hours')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                                @endif
                            </td>

                            <!-- Tasks Column -->
                            <td class="tasks-header py-0">
                                @if (count($client_names) >= 1)
                                @foreach ($date_and_day_with_tasks[$index]['tasks'] as $taskIndex => $taskDescription)
                                <textarea style="text-align: left;margin-left:5px"
                                    wire:model="date_and_day_with_tasks.{{ $index }}.tasks.{{ $taskIndex }}" wire:change="saveTimeSheet"
                                    title="Enter tasks" @error('date_and_day_with_tasks.' . $index . '.tasks.' . $taskIndex) class="error" @enderror></textarea><br>
                                @endforeach
                                @else
                                <textarea style="text-align: left;margin-left:5px" wire:model="date_and_day_with_tasks.{{ $index }}.tasks"
                                    wire:change="saveTimeSheet" title="Enter tasks"
                                    @error('date_and_day_with_tasks.' . $index . '.tasks' ) class="error" @enderror></textarea><br>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="totalHoursContainer py-2">
                <div style="text-align: center; flex-grow: 1;">
                    <div class="row m-0 p-0 d-flex align-items-center">
                        <div class="col">
                            <p class="totalDays mb-0">Total days : <span
                                    class="timeValue">{{ $totalDays }}</span> </p>
                        </div>
                        <div class="col">
                            <p class="totalDays mb-0">Total hours : <span
                                    class="timeValue">{{ $allTotalHours }}</span> </p>
                        </div>
                    </div>
                </div>
            </div>

            @if ($timeSheetSubmitted=="true")
            @else
            <div style="text-align: center; margin-top: 1rem;">
                <button type="button" wire:click="save" class="submit-btn">Save</button>
                <button type="submit" class="submit-btn">Submit</button>
            </div>
            @endif
        </form>
    </div>
    @endif
    @endif
    @if($activeTab == 'history')
    <div class="filter-container mt-2">
        <div class="container-fluid filter-heading">Time Sheet Filters</div>

        <div class="team-time-sheet-filters p-2">
            <div class="filter-row">
                <div>
                    <label for="time_sheet_type">Time Sheet Type</label>
                    <select id="time_sheet_type" wire:change="teamTimeSheetsFilter" wire:model="time_sheet_type">
                        <option value="">All</option>
                        <option value="weekly">Weekly (Default)</option>
                        <option value="semi-monthly">Semi-Monthly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>
                <div>
                    <label for="start_date">Start Date</label>
                    <input type="date" id="start_date" wire:change="teamTimeSheetsFilter" wire:model.debounce.0ms="start_date">
                </div>
                <div>
                    <label for="end_date">End Date</label>
                    <input type="date" id="end_date" wire:change="teamTimeSheetsFilter" wire:model.debounce.0ms="end_date">
                </div>

            </div>
            <div class="filter-row">
                <div>
                    <label for="submission_status">Submission Status</label>
                    <select id="submission_status" wire:change="teamTimeSheetsFilter" wire:model="submission_status">
                        <option value="">All</option>
                        <option value="13">Submitted</option>
                        <option value="12">Saved</option>
                    </select>
                </div>
                <div>
                    <label for="manager_approval">Manager Approval Status</label>
                    <select id="manager_approval" wire:change="teamTimeSheetsFilter" wire:model="manager_approval">
                        <option value="">All</option>
                        <option value="2">Approved</option>
                        <option value="3">Rejected</option>
                        <option value="5">Pending</option>
                        <option value="14">Re-Submit</option>
                    </select>
                </div>
                <div>
                    <label for="hr_approval">HR Approval Status</label>
                    <select id="hr_approval" wire:change="teamTimeSheetsFilter" wire:model="hr_approval">
                        <option value="">All</option>
                        <option value="2">Approved</option>
                        <option value="3">Rejected</option>
                        <option value="5">Pending</option>
                        <option value="14">Re-Submit</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="team-time-sheets-table">
            <thead>
                <tr>
                    <th class="accordion-icon">Details</th>
                    <th class="date-header start-date-header">Start Date</th>
                    <th class="date-header">End Date</th>
                    <th class="employee-header">Employee</th>
                    <th class="timesheet-type-header">Time Sheet Type</th>
                    <th class="day-header">Total Days</th>
                    <th class="hours-header">Total Hours</th>
                    <th class="submission-header">Submission Status</th>
                    <th class="submission-header">Approval Status <p>(Manager)</p>
                    </th>
                    <th class="submission-header">Approval Status <p>(HR)</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                $previousStartDate = null;
                $previousEndDate = null;
                @endphp

                @forelse ($teamTimeSheets as $index => $team)
                @php
                $timeSheetData = json_decode($team->date_and_day_with_tasks, true);
                $totalDays = count($timeSheetData);
                $totalHours = 0;

                foreach ($timeSheetData as $dayData) {
                $hours = $dayData['hours'];
                if (is_array($hours)) {
                $totalHours += array_sum($hours);
                } else {
                $totalHours += (float) $hours;
                }
                }
                $startDate = \Carbon\Carbon::parse($team->start_date);
                $endDate = \Carbon\Carbon::parse($team->end_date);
                @endphp

                <tr class="data-row" data-index="{{ $index }}">
                    <td class="accordion-icon">
                        <a href="#" wire:click.prevent="toggleAccordion({{ $index }})" class="toggle-icon {{ $openAccordionIndex === $index ? 'open' : '' }}" data-index="{{ $index }}">
                            <i class="fas fa-plus"></i>
                        </a>
                    </td>
                    @php
                    $startDate = \Carbon\Carbon::parse($team->start_date);
                    $endDate = \Carbon\Carbon::parse($team->end_date);
                    @endphp

                    <td class="date-header">{{ $startDate->format('d-M-Y') }}</td>
                    <td class="date-header">{{ $endDate->format('d-M-Y') }}</td>


                    <td class="employee-header">{{ $team->employee->first_name }} {{ $team->employee->last_name }}
                        <p>({{ $team->employee->emp_id }})</p>
                    </td>
                    <td class="timesheet-type-header">Weekly</td>
                    <td class="day-header">{{ $totalDays }}</td>
                    <td class="hours-header">{{ number_format($totalHours, 2) }}</td>
                    <td class="submission-header">{{ $team->submissionStatus->status_name  }}</td>
                    <td class="submission-header">{{ $team->approvalStatusForManager->status_name }}</td>
                    <td class="submission-header">{{ $team->approvalStatusForHr->status_name  }}</td>
                </tr>

                <!-- Details Row -->
                <tr class="detail-row {{ $openAccordionIndex === $index ? 'open' : '' }}" id="details-{{ $index }}">
                    <td colspan="11">
                        <table>
                            <thead>
                                <tr class="details-ts">
                                    <th>Dates</th>
                                    <th>Days</th>
                                    <th>Customers</th>
                                    <th>Projects</th>
                                    <th>Remarks</th>
                                    <th>Hours</th>
                                    <th>Tasks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($timeSheetData as $dayData)
                                <tr>
                                    @php
                                    $date = new \DateTime($dayData['date']);
                                    @endphp

                                    <td class="date-column">{{ $date->format('d-M-Y') }}</td>
                                    <td class="day-column">{{ $dayData['day'] }}</td>
                                    <td class="clients-column">
                                        @if (!empty($dayData['clients']))
                                        @foreach ($dayData['clients'] as $client)
                                        {{ $client }}<br>
                                        @endforeach
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td class="projects-column">
                                        @php
                                        $projects = is_array($dayData['projects']) ? array_merge(...$dayData['projects']) : [];
                                        @endphp
                                        @if (!empty($projects))
                                        @foreach ($projects as $project)
                                        {{ $project }}<br>
                                        @endforeach
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td class="remarks-column">
                                        @php
                                        $remarks = is_array($dayData['remarks']) ? array_merge(...$dayData['remarks']) : [];
                                        @endphp
                                        @if (!empty($remarks))
                                        @foreach ($remarks as $remark)
                                        {{ $remark }}<br>
                                        @endforeach
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td class="hours-column">
                                        @if (is_array($dayData['hours']))
                                        @foreach ($dayData['hours'] as $hour)
                                        {{ $hour }}<br>
                                        @endforeach
                                        @else
                                        {{ $dayData['hours'] }}
                                        @endif
                                    </td>
                                    <td class="tasks-column">
                                        @if (is_array($dayData['tasks']))
                                        @if (empty($dayData['tasks']))
                                        --
                                        @else
                                        @foreach ($dayData['tasks'] as $task)
                                        {{ $task ?: '--' }}<br>
                                        @endforeach
                                        @endif
                                        @else
                                        {{ !empty($dayData['tasks']) ? $dayData['tasks'] : '--' }}
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10">
                        No time sheets available.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var message = document.getElementById('success-message');
                if (message) {
                    message.style.display = 'none';
                }
            }, 10000);
        });
    </script>

    <div class="modal fade" id="timesheetHistoryModal" tabindex="-1" role="dialog"
        aria-labelledby="timesheetHistoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="timesheetHistoryModalLabel" style="font-size:0.8rem">Time Sheet
                        History
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @php
                    $auth_empId = auth()->guard('emp')->user()->emp_id;
                    $clients = \App\Models\ClientsEmployee::with('client')->where('emp_id', $auth_empId)->get();
                    $clientIds = $clients->pluck('client_id')->toArray();
                    $client_names = \App\Models\Client::whereIn('client_id', $clientIds)
                    ->pluck('client_name')
                    ->toArray();
                    @endphp
                    <div class="history-card"
                        style="padding: 0.6rem; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 0.5rem;">
                        <table style="border-collapse: collapse; width: 100%;" class="task-table">
                            <thead style="background-color: rgba(2, 17, 79); color: white;">
                                <tr>
                                    <th
                                        style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Start Date</th>
                                    <th
                                        style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        End Date</th>
                                    <th
                                        style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Time Sheet Type</th>
                                    @if (count($client_names) > 0)
                                    <th
                                        style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Clients</th>
                                    @endif
                                    <th
                                        style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Time Sheet Details</th>
                                    <th
                                        style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Status</th>
                                    <th
                                        style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Approval for Manager</th>
                                    <th
                                        style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Approval for HR</th>
                                </tr>
                            </thead>
                            <tbody style="max-height: 400px; overflow-y: auto;">
                                @foreach ($timesheets as $index => $timesheet)
                                @php
                                $start_date = \Carbon\Carbon::parse($timesheet->start_date)->format('d-m-y');
                                $end_date = \Carbon\Carbon::parse($timesheet->end_date)->format('d-m-y');
                                $tasks = json_decode($timesheet->date_and_day_with_tasks, true);
                                $totalDays = count($tasks);
                                $totalHours = 0;

                                // Calculate total hours based on scenario
                                if (count($tasks) > 0) {
                                if (
                                isset($tasks[0]['clients']) &&
                                is_array($tasks[0]['clients']) &&
                                count($tasks[0]['clients']) > 0
                                ) {
                                // Scenario with clients
                                foreach ($tasks as $task) {
                                if (isset($task['hours']) && is_array($task['hours'])) {
                                foreach ($task['hours'] as $hours) {
                                $totalHours += $hours;
                                }
                                }
                                }
                                } else {
                                // Scenario without clients
                                $totalHours = array_sum(array_column($tasks, 'hours'));
                                }
                                }
                                @endphp
                                <tr style="{{ $index % 2 === 0 ? 'background-color: #f7fafc;' : 'background-color: #edf2f7;' }}"
                                    class="{{ $index % 2 === 0 ? 'even-row' : 'odd-row' }}">
                                    <td style="border-bottom: 1px solid #ddd; width: 80px; font-size: 0.5rem;">
                                        {{ $start_date }}
                                    </td>
                                    <td style="border-bottom: 1px solid #ddd; width: 80px; font-size: 0.5rem;">
                                        {{ $end_date }}
                                    </td>
                                    <td
                                        style="border-bottom: 1px solid #ddd; width: 80px; font-size: 0.5rem; text-transform: capitalize;">
                                        {{ $timesheet->time_sheet_type }}
                                    </td>
                                    @if (count($client_names) > 0)
                                    <td
                                        style="border-bottom: 1px solid #ddd; width: 90px; font-size: 0.5rem; text-transform: capitalize; max-height: 50px; overflow: hidden; text-overflow: ellipsis;">
                                        @if (isset($task['clients']) && is_array($task['clients']) && count($task['clients']) > 0)
                                        @foreach ($task['clients'] as $index => $client)
                                        <div>{{ $index + 1 }}. {{ $client }}</div>
                                        @endforeach
                                        @else
                                        {{ $task['clients'] == '' ? '--' : '*' . $task['clients'] }}
                                        @endif
                                    </td>
                                    @endif
                                    <td style="border-bottom: 1px solid #ddd; width: 350px">
                                        <div
                                            style=" height:200px;max-height: 100%; overflow-y: auto;overflow-x:hidden">
                                            <table style="border-collapse: collapse; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th
                                                            style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.5rem; background-color: rgba(2, 17, 79, 0.5); color: white;text-align:center">
                                                            Date</th>
                                                        <th
                                                            style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.5rem; background-color: rgba(2, 17, 79, 0.5); color: white;text-align:center">
                                                            Day</th>
                                                        <th
                                                            style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.5rem; background-color: rgba(2, 17, 79, 0.5); color: white;text-align:center">
                                                            Tasks</th>
                                                        <th
                                                            style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.5rem; background-color: rgba(2, 17, 79, 0.5); color: white;text-align:center">
                                                            Hours</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($tasks as $task)
                                                    @php
                                                    $formattedDate = \Carbon\Carbon::parse(
                                                    $task['date'],
                                                    )->format('d-m-y');
                                                    @endphp
                                                    <tr>
                                                        <td
                                                            style="background-color: white; color: black; width: 80px; font-size: 0.5rem;">
                                                            {{ $formattedDate }}
                                                        </td>
                                                        <td
                                                            style="background-color: white; color: black; width: 70px; font-size: 0.5rem;">
                                                            {{ $task['day'] }}
                                                        </td>
                                                        <td
                                                            style=" text-align: left; background-color: white; color: black; width: 120px; font-size: 0.5rem; text-transform: capitalize; overflow: hidden; text-overflow: ellipsis;">
                                                            @if (is_array($task['tasks']) && count($task['tasks']) > 0)
                                                            @foreach ($task['tasks'] as $index => $taskItem)
                                                            <li>{{ $taskItem != '' ? $taskItem : '--' }}
                                                            </li>
                                                            @endforeach
                                                            @else
                                                            {{ $task['tasks'] == '' ? '--' : $task['tasks'] }}
                                                            @endif
                                                        </td>
                                                        <td
                                                            style="background-color: white; color: black; width: 90px; font-size: 0.5rem; text-transform: capitalize; overflow: hidden; text-overflow: ellipsis;">
                                                            @if (is_array($task['hours']) && count($task['hours']) > 0)
                                                            @foreach ($task['hours'] as $index => $hours)
                                                            <li>{{ $hours }}</li>
                                                            @endforeach
                                                            @else
                                                            {{ $task['hours'] == '' ? '--' : $task['hours'] }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @if (is_array($task['hours']) && count($task['hours']) >= 1)
                                                    <tr
                                                        style="border: 1px solid lightgrey;padding:0;margin:0">
                                                        <td colspan="{{ is_array($task['hours']) && count($task['hours']) > 0 ? '4' : '0' }}"
                                                            style="text-align:center;padding:0;margin:0">
                                                            <div style="font-size:0.5rem">Sub total hours :
                                                                {{ array_sum($task['hours']) }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="8"
                                                            style="background-color: lightgray; color: black; font-weight: bold; text-align: center;">
                                                            <div class="row" style="font-size: 0.5rem;">
                                                                <div class="col">
                                                                    Total days : {{ $totalDays }}
                                                                </div>
                                                                <div class="col">
                                                                    Total hours : {{ $totalHours }}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                    <td
                                        style="border-bottom: 1px solid #ddd; width: 90px; text-transform: capitalize; font-size: 0.5rem;">
                                        {{ $timesheet->submission_status }}
                                    </td>
                                    <td
                                        style="border-bottom: 1px solid #ddd; width: 90px; text-transform: capitalize; font-size: 0.5rem;">
                                        {{ $timesheet->approval_status_for_manager }}
                                    </td>
                                    <td
                                        style="border-bottom: 1px solid #ddd; width: 90px; text-transform: capitalize; font-size: 0.5rem;">
                                        {{ $timesheet->approval_status_for_hr }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button style="font-size: 0.8rem;" type="button" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>