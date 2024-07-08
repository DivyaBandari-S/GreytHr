<div class="container">
    <div class="container" style="width:auto;max-width:60rem;padding: 0.6rem; background-color:rgb(2,17,79);color:white; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);text-align:center">
        <b> Time Sheet Entries</b>
    </div>

    @if($tab=="timeSheet")
    <div class="container" style="margin-bottom: 0.1rem; background-color: #ffffff;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); padding: 0.8rem; max-width: 60rem;">
        <div class="row">
            <div class="col-md-3" style="display: flex; align-items: center">
                <label for="emp_id" class="input-label" style="font-weight: bold; font-size: 0.8rem; margin-right: 0.25rem;">Employee ID:</label>
                <label style="font-size:0.8rem">{{ $auth_empId }}</label>
            </div>


            <!-- Start Date -->
            <div class="col-md-3" style="display: flex; flex-direction: column; align-items: flex-start">
                @php
                $start_date_string = \Carbon\Carbon::parse($start_date_string)->format('Y-m-d');
                @endphp
                <div style="display: flex; align-items: center;">
                    <label for="start_date" class="input-label" style="font-weight: bold; font-size: 0.8rem; margin-right: 0.25rem;">Start Date:</label>
                    <input max="{{ now()->format('Y-m-d') }}" type="date" wire:change="addTask" wire:model.lazy="start_date_string" id="start_date" class="input-field" style="font-size: 0.8rem; width: 90px; border: 1px solid #ccc; margin-bottom: 5px;">
                    <input type="hidden" id="formatted_start_date" value="{{ \Carbon\Carbon::parse($start_date_string)->format('d-M-Y') }}">
                </div>
                @error('start_date_string')
                <span class="error-message" style="color: #e53e3e; font-size: 0.8rem; margin-top: 0.25rem; display: block;">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="col-md-6" style="display: flex; flex-direction: column; align-items: flex-start;">
                <div style="display: flex; align-items: center;">
                    <label for="time_sheet_type" class="input-label" style="font-weight: bold; font-size: 0.8rem; margin-right: 10px;">Time Sheet Type:</label>
                    <div style="display: flex; gap: 1rem;">
                        <label style="font-size: 0.8rem; display: flex; align-items: center;">
                            <input wire:change="addTask" wire:model="time_sheet_type" type="radio" name="time_sheet_type" value="weekly" style="margin-right: 0.25rem;"> Weekly
                        </label>
                        <label style="font-size: 0.8rem; display: flex; align-items: center;">
                            <input wire:change="addTask" wire:model="time_sheet_type" type="radio" name="time_sheet_type" value="semi-monthly" style="margin-right: 0.25rem;"> Semi-Monthly
                        </label>
                        <label style="font-size: 0.8rem; display: flex; align-items: center;">
                            <input wire:change="addTask" wire:model="time_sheet_type" type="radio" name="time_sheet_type" value="monthly" style="margin-right: 0.25rem;"> Monthly
                        </label>
                    </div>
                </div>
                @error('time_sheet_type')
                <span class="error-message" style="color: #e53e3e; font-size: 0.8rem; margin-top: 0.25rem; display: block;">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <!-- Time Sheet Type -->
        </div>
    </div>

    @if($defaultTimesheetEntry=="true")
    <div class="container" style="width:auto;max-width:{{ count($client_names) > 0 ? '60rem' : '60rem' }};padding: 0.6rem; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <div class="subTotalExceed">
            @php
            $subTotalExceed = false;
            @endphp

            @foreach ($default_date_and_day_with_tasks as $index => $task)
            @if(count($client_names)>=1)
            @php
            $totalHours = array_sum($task['hours']);
            $subTotalExceed = $totalHours > 24;
            @endphp
            @endif
            <div>
                @if (count($client_names)>=2)
                @if($subTotalExceed)
                <div style="text-align:center">
                    <span style="color: red; font-size: 0.8rem;">Subtotal hours cannot exceed 24.</span>
                </div>
                @endif
                @endif
            </div>
            @endforeach
        </div>

        @if (session()->has('message'))
        <div id="success-message" style="margin: 0.2rem;padding:0.25rem; background-color: #f0fff4; border: 1px solid #68d391;color: #38a169; border-radius: 0.25rem;text-align:center" class="success-message">
            {{ session('message') }}
        </div>
        @elseif (session()->has('message-e'))
        <div id="success-message" style="margin: 0.2rem;padding:0.25rem;  background-color: #f0fff4; border: 1px solid #68d391;color: #38a169; border-radius: 0.25rem;text-align:center" class="success-message">
            {{ session('message-e') }}
        </div>
        @endif

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    var message = document.getElementById('success-message');
                    if (message) {
                        message.style.display = 'none';
                    }
                }, 35000); // 5000 milliseconds = 5 seconds
            });
        </script>

        <form wire:submit.prevent="defaultSubmit">
            <div class="task-table-container">
                <table style="width: 100%; border-collapse: collapse;" class="task-table">
                    <thead style="background-color: rgba(2,17,79); color: white;">
                        <tr>
                            <th style="font-weight: normal; border: 1px solid #ddd; font-size: 0.8rem; padding: 0.3rem;text-align:center;width:40px">Date</th>
                            <th style="font-weight: normal; border: 1px solid #ddd; font-size: 0.8rem; padding: 0.3rem;text-align:center">Day</th>
                            @if(count($client_names) > 0)
                            <th style="font-weight: normal; border: 1px solid #ddd; font-size: 0.8rem; padding: 0.3rem;text-align:center">Client</th>
                            @endif
                            <th style="font-weight: normal; border: 1px solid #ddd; font-size: 0.8rem; padding: 0.3rem;text-align:center">Hours</th>
                            <th style="font-weight: normal; border: 1px solid #ddd; font-size: 0.8rem; padding: 0.3rem;text-align:center">Tasks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($default_date_and_day_with_tasks as $index => $task)
                        @php
                        $date = \Carbon\Carbon::parse($task['date']);
                        $formattedDate = $date->format('d-M-Y');
                        $isWeekend = $date->isWeekend();
                        $rowColor = $isWeekend ? 'rgb(255, 236, 248)' : ($index % 2 === 0 ? '#f7fafc' : '#edf2f7');
                        @endphp
                        <tr style="padding:0; background-color: {{ $rowColor }};">
                            <td style="border: 1px solid #ddd; padding: 0rem; text-align: center;width:40px">
                                <input type="text" value="{{ $formattedDate }}" style="text-align:center; padding: 0rem; border: none; background: transparent;" readonly>
                            </td>
                            <td style="border: 1px solid #ddd; padding: 0rem;">
                                <input type="text" readonly wire:model="default_date_and_day_with_tasks.{{ $index }}.day" style="width: 95px;text-align:center; padding: 0rem; border: none; background: transparent;">
                            </td>
                            @if(count($client_names) >= 1)
                            <td style="border: 1px solid #ddd; padding: 0rem;">
                                @foreach($task['clients'] as $client)
                                <input type="text" readonly value="{{ $client }}" style="text-align:center;width: 95px; padding: 0rem; border: none; background: transparent;">
                                @endforeach
                            </td>
                            @endif
                            <td style="border: 1px solid #ddd; padding: 0rem;">
                                @if(count($client_names) >= 1)
                                @foreach($default_date_and_day_with_tasks[$index]['hours'] as $hourIndex => $hour)
                                <input type="text" wire:model="default_date_and_day_with_tasks.{{ $index }}.hours.{{ $hourIndex }}" wire:change="defaultSaveTimeSheet" style=" width: 40px; padding: 0rem;text-align:center; border: none; background: transparent;" pattern="[0-9]*(\.[0-9]{1,2})?" title="Please enter a number between 0.0 and 24.0, with up to 2 decimal places." @error('date_and_day_with_tasks.'.$index.'.hours.'.$hourIndex) style="border: 1px solid red;" @enderror>
                                @error('default_date_and_day_with_tasks.'.$index.'.hours.'.$hourIndex)
                                <span style="color: red; font-size: 0.5rem; width: 50px;">{{ $message }}</span>
                                @enderror
                                @endforeach
                                @else
                                <input type="text" wire:model="default_date_and_day_with_tasks.{{ $index }}.hours" wire:change="defaultSaveTimeSheet" style="width: 40px;text-align:center;  padding: 0rem; border: none; background: transparent;" pattern="[0-9]*(\.[0-9]{1,2})?" title="Please enter a number between 0.0 and 24.0, with up to 2 decimal places." @error('date_and_day_with_tasks.'.$index.'.hours') style="border: 1px solid red;" @enderror>
                                @error('default_date_and_day_with_tasks.'.$index.'.hours')
                                <span style="color: red; font-size: 0.5rem; width: 50px;">{{ $message }}</span>
                                @enderror
                                @endif
                            </td>
                            <td style="border: 1px solid #ddd; padding: 0.2rem;">
                                @if(count($client_names) >= 1)
                                @foreach($default_date_and_day_with_tasks[$index]['tasks'] as $taskIndex => $taskDescription)
                                <textarea wire:model="default_date_and_day_with_tasks.{{ $index }}.tasks.{{ $taskIndex }}" wire:change="defaultSaveTimeSheet" style="height:15px;margin-left:8px;width: 480px;  padding: 0rem; border: none;border-radius:0; background: transparent;"></textarea><br>
                                @endforeach
                                @else
                                <textarea wire:model="default_date_and_day_with_tasks.{{ $index }}.tasks" wire:change="defaultSaveTimeSheet" style="height:15px;margin-left:8px;width: 580px;  padding: 0rem; border: none; background: transparent;border-radius:0;"></textarea><br>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            <div style="background-color: #f7fafc; border: 1px solid #ddd; border-radius: 0.25rem; display: flex; justify-content: space-between; align-items: center;padding:0.25rem">
                <div style="text-align: center; flex-grow: 1;">
                    <div class="row">
                        <div class="col">
                            <p style="font-size: 0.9rem; font-weight: bold;">Total days: {{ $defaultTotalDays }}</p>
                        </div>
                        <div class="col">
                            <p style="font-size: 0.9rem; font-weight: bold;">Total hours: {{ $allDefaultTotalHours }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div style="text-align: center;margin-top:1rem">
                <button type="submit" style="width: 10%; padding: 0.25rem; background-color: #3498db; color: #fff; border: none; border-radius: 0.25rem; cursor: pointer; transition: background-color 0.3s ease;font-size:0.8rem" class="submit-btn">Submit</button>
            </div>
        </form>

        <!-- Flash message for success -->

    </div>
    @elseif($defaultTimesheetEntry=="false")
    <div class="container" style="width:auto;max-width:{{ count($client_names) > 0 ? '60rem' : '60rem' }};padding: 0.6rem; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <div class="subTotalExceed">
            @php
            $subTotalExceed = false;
            @endphp

            @foreach ($date_and_day_with_tasks as $index => $task)
            @if(count($client_names)>=1)
            @php
            $totalHours = array_sum($task['hours']);
            $subTotalExceed = $totalHours > 24;
            @endphp
            @endif
            <div>
                @if (count($client_names)>=2)
                @if($subTotalExceed)
                <div style="text-align:center">
                    <span style="color: red; font-size: 0.8rem;">Subtotal hours cannot exceed 24.</span>
                </div>
                @endif
                @endif
            </div>
            @endforeach
        </div>

        @if (session()->has('message'))
        <div id="success-message" style="margin: 0.2rem;padding:0.25rem; background-color: #f0fff4; border: 1px solid #68d391;color: #38a169; border-radius: 0.25rem;text-align:center" class="success-message">
            {{ session('message') }}
        </div>
        @elseif (session()->has('message-e'))
        <div id="success-message" style="margin: 0.2rem;padding:0.25rem;  background-color: #f0fff4; border: 1px solid #68d391;color: #38a169; border-radius: 0.25rem;text-align:center" class="success-message">
            {{ session('message-e') }}
        </div>
        @endif

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    var message = document.getElementById('success-message');
                    if (message) {
                        message.style.display = 'none';
                    }
                }, 35000); // 5000 milliseconds = 5 seconds
            });
        </script>

        <form wire:submit.prevent="submit">
            <div class="task-table-container">
                <table style="width: 100%; border-collapse: collapse;" class="task-table">
                    <thead style="background-color: rgba(2,17,79); color: white;">
                        <tr>
                            <th style="font-weight: normal; border: 1px solid #ddd; font-size: 0.8rem; padding: 0.3rem;text-align:center;width:20px">Date</th>
                            <th style="font-weight: normal; border: 1px solid #ddd; font-size: 0.8rem; padding: 0.3rem;text-align:center;width:30px">Day</th>
                            @if(count($client_names) > 0)
                            <th style="font-weight: normal; border: 1px solid #ddd; font-size: 0.8rem; padding: 0.3rem;text-align:center">Client</th>
                            @endif
                            <th style="font-weight: normal; border: 1px solid #ddd; font-size: 0.8rem; padding: 0.3rem;text-align:center">Hours</th>
                            <th style="font-weight: normal; border: 1px solid #ddd; font-size: 0.8rem; padding: 0.3rem;text-align:center">Tasks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($date_and_day_with_tasks as $index => $task)
                        @php
                        $date = \Carbon\Carbon::parse($task['date']);
                        $formattedDate = $date->format('d-M-Y');
                        $isWeekend = $date->isWeekend();
                        $rowColor = $isWeekend ? 'rgb(255, 236, 248)' : ($index % 2 === 0 ? '#f7fafc' : '#edf2f7');
                        @endphp
                        <tr style="padding:0; background-color: {{ $rowColor }};">
                            <td style="border: 1px solid #ddd; padding: 0rem; text-align: center;width:20px">
                                <input type="text" value="{{ $formattedDate }}" style="text-align: center; padding: 0rem; border: none; background: transparent;" readonly>
                            </td>
                            <td style="border: 1px solid #ddd; padding: 0rem;width:30px;text-align:center;">
                                <input type="text" readonly wire:model="date_and_day_with_tasks.{{ $index }}.day" style="text-align:center; padding: 0rem; border: none; background: transparent;">
                            </td>
                            @if(count($client_names) >= 1)
                            <td style="border: 1px solid #ddd; padding: 0rem;">
                                @foreach($task['clients'] as $client)
                                <input type="text" readonly value="{{ $client }}" style="text-align:center;width: 95px; padding: 0rem; border: none; background: transparent;">
                                @endforeach
                            </td>
                            @endif
                            <td style="border: 1px solid #ddd; padding: 0rem;">
                                @if(count($client_names) >= 1)
                                @foreach($date_and_day_with_tasks[$index]['hours'] as $hourIndex => $hour)
                                <input type="text" wire:model="date_and_day_with_tasks.{{ $index }}.hours.{{ $hourIndex }}" wire:change="saveTimeSheet" style=" width: 40px; padding: 0rem;text-align:center; border: none; background: transparent;" pattern="[0-9]*(\.[0-9]{1,2})?" title="Please enter a number between 0.0 and 24.0, with up to 2 decimal places." @error('date_and_day_with_tasks.'.$index.'.hours.'.$hourIndex) style="border: 1px solid red;" @enderror>
                                @error('date_and_day_with_tasks.'.$index.'.hours.'.$hourIndex)
                                <span style="color: red; font-size: 0.5rem; width: 50px;">{{ $message }}</span>
                                @enderror
                                @endforeach
                                @else
                                <input type="text" wire:model="date_and_day_with_tasks.{{ $index }}.hours" wire:change="saveTimeSheet" style="width: 40px;text-align:center;  padding: 0rem; border: none; background: transparent;" pattern="[0-9]*(\.[0-9]{1,2})?" title="Please enter a number between 0.0 and 24.0, with up to 2 decimal places." @error('date_and_day_with_tasks.'.$index.'.hours') style="border: 1px solid red;" @enderror>
                                @error('date_and_day_with_tasks.'.$index.'.hours')
                                <span style="color: red; font-size: 0.5rem; width: 50px;">{{ $message }}</span>
                                @enderror
                                @endif
                            </td>
                            <td style="border: 1px solid #ddd; padding: 0.2rem;">
                                @if(count($client_names) >= 1)
                                @foreach($date_and_day_with_tasks[$index]['tasks'] as $taskIndex => $taskDescription)
                                <textarea wire:model="date_and_day_with_tasks.{{ $index }}.tasks.{{ $taskIndex }}" wire:change="saveTimeSheet" style="height:15px;margin-left:8px;width: 470px;  padding: 0rem; border: none;border-radius:0; background: transparent;"></textarea><br>
                                @endforeach
                                @else
                                <textarea wire:model="date_and_day_with_tasks.{{ $index }}.tasks" wire:change="saveTimeSheet" style="height:15px;margin-left:8px;width: 570px;  padding: 0rem; border: none; background: transparent;border-radius:0;"></textarea><br>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            <div style="background-color: #f7fafc; border: 1px solid #ddd; border-radius: 0.25rem; display: flex; justify-content: space-between; align-items: center;padding:0.25rem">
                <div style="text-align: center; flex-grow: 1;">
                    <div class="row">
                        <div class="col">
                            <p style="font-size: 0.9rem; font-weight: bold;">Total days: {{ $totalDays }}</p>
                        </div>
                        <div class="col">
                            <p style="font-size: 0.9rem; font-weight: bold;">Total hours: {{ $allTotalHours }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div style="text-align: center;margin-top:1rem">
                <button type="submit" style="width: 10%; padding: 0.25rem; background-color: #3498db; color: #fff; border: none; border-radius: 0.25rem; cursor: pointer; transition: background-color 0.3s ease;font-size:0.8rem" class="submit-btn">Submit</button>
            </div>
        </form>

        <!-- Flash message for success -->

    </div>
    @endif
    @endif

    <div class="modal fade" id="timesheetHistoryModal" tabindex="-1" role="dialog" aria-labelledby="timesheetHistoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="timesheetHistoryModalLabel" style="font-size:0.8rem">Time Sheet History
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @php
                    $auth_empId = auth()->guard('emp')->user()->emp_id;

                    // Fetch clients associated with the authenticated employee
                    $clients = \App\Models\ClientsEmployee::with('client')
                    ->where('emp_id', $auth_empId)
                    ->get();

                    // Extract client IDs from the collection
                    $clientIds = $clients->pluck('client_id')->toArray();

                    // Fetch client names based on the extracted client IDs
                    $client_names = \App\Models\Client::whereIn('client_id', $clientIds)
                    ->pluck('client_name')
                    ->toArray();
                    @endphp
                    <div class="history-card" style="padding: 0.6rem; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 0.5rem;">
                        <table style="border-collapse: collapse; width: 100%;" class="task-table">
                            <thead style="background-color: rgba(2, 17, 79); color: white;">
                                <tr>
                                    <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Start Date</th>
                                    <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        End Date</th>
                                    <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Time Sheet Type</th>
                                    @if(count($client_names) >0)
                                    <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Clients</th>
                                    @endif
                                    <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Time Sheet Details</th>
                                    <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Status</th>
                                    <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Approval for Manager</th>
                                    <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Approval for HR</th>
                                </tr>
                            </thead>
                            <tbody style="max-height: 400px; overflow-y: auto;">
                                @foreach($timesheets as $index => $timesheet)
                                @php
                                $start_date = \Carbon\Carbon::parse($timesheet->start_date)->format('d-m-y');
                                $end_date = \Carbon\Carbon::parse($timesheet->end_date)->format('d-m-y');
                                $tasks = json_decode($timesheet->date_and_day_with_tasks, true);
                                $totalDays = count($tasks);
                                $totalHours = 0;

                                // Calculate total hours based on scenario
                                if (count($tasks) > 0) {
                                if (isset($tasks[0]['clients']) && is_array($tasks[0]['clients']) &&
                                count($tasks[0]['clients']) > 0) {
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
                                <tr style="{{ $index % 2 === 0 ? 'background-color: #f7fafc;' : 'background-color: #edf2f7;' }}" class="{{ $index % 2 === 0 ? 'even-row' : 'odd-row' }}">
                                    <td style="border-bottom: 1px solid #ddd; width: 80px; font-size: 0.5rem;">
                                        {{ $start_date }}
                                    </td>
                                    <td style="border-bottom: 1px solid #ddd; width: 80px; font-size: 0.5rem;">
                                        {{ $end_date }}
                                    </td>
                                    <td style="border-bottom: 1px solid #ddd; width: 80px; font-size: 0.5rem; text-transform: capitalize;">
                                        {{ $timesheet->time_sheet_type }}
                                    </td>
                                    @if(count($client_names) >0 )
                                    <td style="border-bottom: 1px solid #ddd; width: 90px; font-size: 0.5rem; text-transform: capitalize; max-height: 50px; overflow: hidden; text-overflow: ellipsis;">
                                        @if(isset($task['clients']) && is_array($task['clients']) &&
                                        count($task['clients']) > 0)
                                        @foreach($task['clients'] as $index => $client)
                                        <div>{{ $index+1 }}. {{ $client }}</div>
                                        @endforeach
                                        @else
                                        {{ $task['clients'] == "" ? '--' : '*' . $task['clients'] }}
                                        @endif
                                    </td>
                                    @endif
                                    <td style="border-bottom: 1px solid #ddd; width: 350px">
                                        <div style=" height:200px;max-height: 100%; overflow-y: auto;overflow-x:hidden">
                                            <table style="border-collapse: collapse; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.5rem; background-color: rgba(2, 17, 79, 0.5); color: white;text-align:center">
                                                            Date</th>
                                                        <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.5rem; background-color: rgba(2, 17, 79, 0.5); color: white;text-align:center">
                                                            Day</th>
                                                        <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.5rem; background-color: rgba(2, 17, 79, 0.5); color: white;text-align:center">
                                                            Tasks</th>
                                                        <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.5rem; background-color: rgba(2, 17, 79, 0.5); color: white;text-align:center">
                                                            Hours</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($tasks as $task)
                                                    @php
                                                    $formattedDate =
                                                    \Carbon\Carbon::parse($task['date'])->format('d-m-y');
                                                    @endphp
                                                    <tr>
                                                        <td style="background-color: white; color: black; width: 80px; font-size: 0.5rem;">
                                                            {{ $formattedDate }}
                                                        </td>
                                                        <td style="background-color: white; color: black; width: 70px; font-size: 0.5rem;">
                                                            {{ $task['day'] }}
                                                        </td>
                                                        <td style="background-color: white; color: black; width: 120px; font-size: 0.5rem; text-transform: capitalize; overflow: hidden; text-overflow: ellipsis;">
                                                            @if(is_array($task['tasks']) && count($task['tasks']) > 0)
                                                            @foreach($task['tasks'] as $index => $taskItem)
                                                            <li>{{ $taskItem != "" ? $taskItem : '--' }}</li>
                                                            @endforeach
                                                            @else
                                                            {{ $task['tasks'] == "" ? '--' : $task['tasks'] }}
                                                            @endif
                                                        </td>
                                                        <td style="background-color: white; color: black; width: 90px; font-size: 0.5rem; text-transform: capitalize; overflow: hidden; text-overflow: ellipsis;">
                                                            @if(is_array($task['hours']) && count($task['hours']) > 0)
                                                            @foreach($task['hours'] as $index => $hours)
                                                            <li>{{ $hours }}</li>
                                                            @endforeach
                                                            @else
                                                            {{ $task['hours'] == "" ? '--' : $task['hours'] }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @if(is_array($task['hours']) && count($task['hours']) >= 1)
                                                    <tr style="border: 1px solid lightgrey;padding:0;margin:0">
                                                        <td colspan="{{ is_array($task['hours']) && count($task['hours']) > 0 ? '4':'0' }}" style="text-align:center;padding:0;margin:0">
                                                            <div style="font-size:0.5rem">Sub total hours :
                                                                {{array_sum($task['hours'])}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="8" style="background-color: lightgray; color: black; font-weight: bold; text-align: center;">
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
                                    <td style="border-bottom: 1px solid #ddd; width: 90px; text-transform: capitalize; font-size: 0.5rem;">
                                        {{ $timesheet->submission_status }}
                                    </td>
                                    <td style="border-bottom: 1px solid #ddd; width: 90px; text-transform: capitalize; font-size: 0.5rem;">
                                        {{ $timesheet->approval_status_for_manager }}
                                    </td>
                                    <td style="border-bottom: 1px solid #ddd; width: 90px; text-transform: capitalize; font-size: 0.5rem;">
                                        {{ $timesheet->approval_status_for_hr }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button style="font-size: 0.8rem;" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let startDateInput = document.getElementById('start_date');
        let formattedStartDateInput = document.getElementById('formatted_start_date');

        // Function to format date as d-M-Y
        function formatDate(d) {
            let day = ('0' + d.getDate()).slice(-2);
            let month = d.toLocaleString('default', {
                month: 'short'
            });
            let year = d.getFullYear();
            return `${day}-${month}-${year}`;
        }

        // Set initial value if not set
        if (!startDateInput.value) {
            let now = new Date();
            let day = now.getDay();
            let diff = now.getDate() - day + (day === 0 ? -6 : 1); // adjust when day is Sunday
            let monday = new Date(now.setDate(diff));

            let formattedDate = formatDate(monday);
            startDateInput.value = monday.toISOString().split('T')[0];
            formattedStartDateInput.value = formattedDate;
            startDateInput.dispatchEvent(new Event('change'));
        }

        // Update displayed date on change
        startDateInput.addEventListener('change', function() {
            let date = new Date(this.value);
            let formattedDate = formatDate(date);
            formattedStartDateInput.value = formattedDate;
            // Trigger Livewire update if needed
            formattedStartDateInput.dispatchEvent(new Event('input'));
        });
    });
</script>