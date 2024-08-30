<div class="container">
    <style>
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

            /* .d-flex {
                flex-direction: column;
                align-items: flex-start;
            } */
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
    </style>


    <div class="timesheetContainer mt-2 bg-white p-2 mx-auto">
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


    @if (session()->has('message'))
        <div id="success-message" class="container"
            style="width:100%;max-width:{{ count($client_names) > 0 ? '100%' : '100%' }};padding: 0.6rem; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <div style="margin: 0.2rem;padding:0.25rem; background-color: #f0fff4; border: 1px solid #68d391;color: #38a169; border-radius: 0.25rem;text-align:center"
                class="success-message">
                {{ session('message') }}
            </div>
        </div>
    @elseif (session()->has('message-e'))
        <div id="success-message" class="container"
            style="width:100%;max-width:{{ count($client_names) > 0 ? '100%' : '100%' }};padding: 0.6rem; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <div style="margin: 0.2rem;padding:0.25rem;  background-color: #f0fff4; border: 1px solid #68d391;color: #38a169; border-radius: 0.25rem;text-align:center"
                class="success-message">
                {{ session('message-e') }}
            </div>
        </div>
    @elseif (session()->has('message-u'))
        <div id="success-message" class="container"
            style="width:100%;max-width:{{ count($client_names) > 0 ? '100%' : '100%' }};padding: 0.6rem; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <div style="margin: 0.2rem;padding:0.25rem;  background-color: #f0fff4; border: 1px solid #68d391;color: #38a169; border-radius: 0.25rem;text-align:center"
                class="success-message">
                Time sheet updated successfully!
            </div>
        </div>
    @elseif (session()->has('message-s'))
        <div id="success-message" class="container"
            style="width:100%;max-width:{{ count($client_names) > 0 ? '100%' : '100%' }};padding: 0.6rem; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <div style="margin: 0.2rem;padding:0.25rem;  background-color: #f0fff4; border: 1px solid #68d391;color: #38a169; border-radius: 0.25rem;text-align:center"
                class="success-message">
                Time sheet saved successfully!
            </div>
        </div>
    @elseif (session()->has('message-us'))
        <div id="success-message" class="container"
            style="width:100%;max-width:{{ count($client_names) > 0 ? '100%' : '100%' }};padding: 0.6rem; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <div style="margin: 0.2rem;padding:0.25rem;  background-color: #f0fff4; border: 1px solid #68d391;color: #38a169; border-radius: 0.25rem;text-align:center"
                class="success-message">
                Time sheet status has been updated to "Submitted".
            </div>
        </div>
    @elseif (session()->has('error-dr'))
        <div id="success-message" class="container"
            style="width:100%;max-width:{{ count($client_names) > 0 ? '100%' : '100%' }};padding: 0.6rem; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <div style="margin: 0.2rem;padding:0.25rem; background-color: #FFF6F0; border: 1px solid red;color: #A15038; border-radius: 0.25rem;text-align:center"
                class="success-message">
                Time sheet filling is not yet complete, you cannot submit at this time.
            </div>
        </div>
    @elseif(session()->has('message-aets'))
        <div id="success-message" class="container"
            style="width:100%;max-width:{{ count($client_names) > 0 ? '100%' : '100%' }};padding: 0.6rem; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <div style="margin: 0.2rem;padding:0.25rem; background-color: #FFF6F0; border: 1px solid red;color: #A15038; border-radius: 0.25rem;text-align:center"
                class="success-message">
                Time sheet already exists for the selected date range.
            </div>
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
                                                    title="Please enter a number between 0.0 and 24.0, with up to 2 decimal places."
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
                                                title="Please enter a number between 0.0 and 24.0, with up to 2 decimal places."
                                                @error('default_date_and_day_with_tasks.' . $index . '.hours') class="error" @enderror>
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
                                                title="Enter tasks" @error('default_date_and_day_with_tasks.' . $index . '.tasks') class="error" @enderror></textarea><br>
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

                @if (session()->has('message-aets'))
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
                                                    title="Please enter a number between 0.0 and 24.0, with up to 2 decimal places."
                                                    @error('date_and_day_with_tasks.' . $index . '.hours.' . $hourIndex) class="error" @enderror>
                                                @error('date_and_day_with_tasks.' . $index . '.hours.' . $hourIndex)
                                                    <span class="error-message">{{ $message }}</span>
                                                @enderror
                                            @endforeach
                                        @else
                                            <input type="text"
                                                wire:model="date_and_day_with_tasks.{{ $index }}.hours"
                                                wire:change="saveTimeSheet" pattern="[0-9]*(\.[0-9]{1,2})?"
                                                title="Please enter a number between 0.0 and 24.0, with up to 2 decimal places."
                                                @error('date_and_day_with_tasks.' . $index . '.hours') class="error" @enderror>
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
                                                @error('date_and_day_with_tasks.' . $index . '.tasks') class="error" @enderror></textarea><br>
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

                @if (session()->has('message-aets'))
                @else
                    <div style="text-align: center; margin-top: 1rem;">
                        <button type="button" wire:click="save" class="submit-btn">Save</button>
                        <button type="submit" class="submit-btn">Submit</button>
                    </div>
                @endif


            </form>
            <!-- Flash message for success -->

        </div>
    @endif
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
</div>a
