<div>
    <div style="text-align: center;">
        <button class="button-dl {{ $tab === 'timeSheet' ? 'active' : '' }}" wire:click="$set('tab', 'timeSheet')">Time Sheets</button>
        <button class="button-dl {{ $tab === 'timesheetHistory' ? 'active' : '' }}" wire:click="$set('tab', 'timesheetHistory')">History</button>
    </div>
    @if($tab=="timeSheet")
    <div class="timeSheet">
        <div class="card" style="margin-bottom: 0.5rem; background-color: #ffffff; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); padding: 1.5rem; max-width: 31rem;">
            <div class="input-group" style="margin-bottom: 1.5rem;">
                <label for="emp_id" class="input-label" style="font-weight: bold; font-size: 0.8rem;">Employee ID: {{ $auth_empId }}</label>
            </div>
            <div class="input-group" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between;">
                <div>
                    <label for="start_date" class="input-label" style="font-weight: bold; font-size: 0.8rem;">Start Date:</label>
                    <input max="{{ now()->format('Y-m-d') }}" type="date" wire:model="start_date" id="start_date" class="input-field" style="font-size: 0.9rem; width: 100%; border: 1px solid #ccc; border-radius: 0.25rem; padding: 0.5rem;">
                </div>
                <div>
                    <label for="end_date" class="input-label" style="font-weight: bold; font-size: 0.8rem;">End Date:</label>
                    <input max="{{ now()->format('Y-m-d') }}" type="date" wire:model="end_date" id="end_date" class="input-field" style="font-size: 0.9rem; width: 100%; border: 1px solid #ccc; border-radius: 0.25rem; padding: 0.5rem;">
                </div>
            </div>
            @error('start_date') <span class="error-message" style="color: #e53e3e; font-size: 0.8rem;margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
            @error('end_date') <span class="error-message" style="color: #e53e3e; font-size: 0.8rem; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
        </div>
        <div style="max-width: 45rem;padding: 0.6rem; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 0.5rem;">
            <form wire:submit.prevent="submit">
                <!-- Task input fields -->
                <div class="task-table-container">
                    <table style="width: 100%; border-collapse: collapse;" class="task-table">
                        <thead style="background-color: rgba(2,17,79);color:white">
                            <tr>
                                <th style="padding: 0.75rem;font-weight:normal; border-bottom: 1px solid #ddd;font-size:0.8rem">Date</th>
                                <th style="padding: 0.75rem; font-weight:normal;border-bottom: 1px solid #ddd;font-size:0.8rem">Day</th>
                                <th style="padding: 0.75rem;font-weight:normal; border-bottom: 1px solid #ddd;font-size:0.8rem">Hours</th>
                                <th style="padding: 0.75rem;font-weight:normal; border-bottom: 1px solid #ddd;font-size:0.8rem">Tasks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($date_and_day_with_tasks as $index => $task)
                            <tr style="{{ $index % 2 === 0 ? 'background-color: #f7fafc;' : 'background-color: #edf2f7;' }}" class="{{ $index % 2 === 0 ? 'even-row' : 'odd-row' }}">
                                <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;width:5%"><input type="text" wire:model="date_and_day_with_tasks.{{ $index }}.date" style="width:120px; padding: 0.5rem; border: 1px solid #ccc; border-radius: 0.25rem;" readonly></td>
                                <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;width:45%"><input type="text" readonly wire:model="date_and_day_with_tasks.{{ $index }}.day" style="width: 120px; padding: 0.5rem; border: 1px solid #ccc; border-radius: 0.25rem;"></td>
                                <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;">
                                    <input type="text" wire:model="date_and_day_with_tasks.{{ $index }}.hours" wire:change="saveTimeSheet" style="width:120px; padding: 0.5rem; border: 1px solid #ccc; border-radius: 0.25rem" pattern="[0-9]*(\.[0-9]{1,2})?" title="Please enter a number between 0.0 and 24.0, with up to 2 decimal places." @error('date_and_day_with_tasks.'.$index.'.hours') style="border-color: red;" @enderror>

                                    <br> @error('date_and_day_with_tasks.'.$index.'.hours')
                                    <span style="color: red; font-size: 0.5rem; width: 50px;">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;"><textarea wire:model="date_and_day_with_tasks.{{ $index }}.tasks" wire:change="saveTimeSheet" style="width: 250px; padding: 0.5rem; border: 1px solid #ccc; border-radius: 0.25rem;"></textarea><br>
                                    @error('date_and_day_with_tasks.'.$index.'.tasks')
                                    <span style="color: red; font-size: 0.5rem; width: 50px;">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                <div style="margin-top: 1rem; padding: 0.75rem; background-color: #f7fafc; border: 1px solid #ddd; border-radius: 0.25rem; display: flex; justify-content: space-between; align-items: center;">
                    <div style="text-align: center; flex-grow: 1;">
                        <div class="row">
                            <div class="col">
                                <p style="font-size: 0.9rem; font-weight: bold;">Total Days: {{ $totalDays }}</p>
                            </div>
                            <div class="col">
                                <p style="font-size: 0.9rem; font-weight: bold;">Total Hours: {{ $totalHours }}</p>
                            </div>
                        </div>
                    </div>
                    <button type="button" wire:click="addTask" style="padding: 0.5rem; background-color: #27ae60; color: #fff; border: none; border-radius: 0.25rem; cursor: pointer; transition: background-color 0.3s ease; font-size: 0.8rem; margin-left: 10px;" class="add-task-btn">Add Task</button>
                </div>


                <div style="text-align: center;margin-top:8px">
                    <button type="submit" style="width: 15%; padding: 0.55rem; background-color: #3498db; color: #fff; border: none; border-radius: 0.25rem; cursor: pointer; transition: background-color 0.3s ease;font-size:0.8rem" class="submit-btn">Submit</button>
                </div>
                <!-- Button to add a new task -->
            </form>

            <!-- Flash message for success -->
            @if (session()->has('message'))
            <div style="margin-top: 1rem; padding: 0.75rem; background-color: #f0fff4; border: 1px solid #68d391;color: #38a169; border-radius: 0.25rem;text-align:center" class="success-message">{{ session('message') }}</div>
            @endif
        </div>
    </div>
    @endif

    @if($tab=="timesheetHistory")
    <div class="history-card" style="max-width: 60rem; padding: 0.6rem; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 0.5rem;margin-left:25px">
        <table style="width: 100%; border-collapse: collapse;" class="task-table">
            <thead style="background-color: rgba(2,17,79);color:white">
                <tr>
                    <th style="padding: 0.75rem;font-weight:normal; border-bottom: 1px solid #ddd;font-size:0.8rem">Start Date</th>
                    <th style="padding: 0.75rem;font-weight:normal; border-bottom: 1px solid #ddd;font-size:0.8rem">End Date</th>
                    <th style="padding: 0.75rem;font-weight:normal; border-bottom: 1px solid #ddd;font-size:0.8rem">Time Sheet Details</th>
                    <th style="padding: 0.75rem;font-weight:normal; border-bottom: 1px solid #ddd;font-size:0.8rem">Status</th>
                    <th style="padding: 0.75rem;font-weight:normal; border-bottom: 1px solid #ddd;font-size:0.8rem">Approval for Manager</th>
                    <th style="padding: 0.75rem;font-weight:normal; border-bottom: 1px solid #ddd;font-size:0.8rem">Approval for HR</th>
                </tr>
            </thead>
            <tbody>
                @foreach($timesheets as $index=> $timesheet)
                <tr style="{{ $index % 2 === 0 ? 'background-color: #f7fafc;' : 'background-color: #edf2f7;' }}" class="{{ $index % 2 === 0 ? 'even-row' : 'odd-row' }}">
                    <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;width:100px">{{ $timesheet->start_date }}</td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;width:100px"> {{ $timesheet->end_date }}</td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid #ddd; width: 250px; height: 200px; max-height: 250px;">
                        @php
                        $tasks = json_decode($timesheet->date_and_day_with_tasks, true);
                        @endphp

                        <div style="overflow-y: auto; height: 100%;">
                            <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
                                <thead>
                                    <tr>
                                        <th style="padding: 0.75rem; font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.8rem; background-color: rgba(2, 17, 79, 0.5); color: white">Date</th>
                                        <th style="padding: 0.75rem; font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.8rem; background-color: rgba(2, 17, 79, 0.5); color: white">Day</th>
                                        <th style="padding: 0.75rem; font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.8rem; background-color: rgba(2, 17, 79, 0.5); color: white">Tasks</th>
                                        <th style="padding: 0.75rem; font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.8rem; background-color: rgba(2, 17, 79, 0.5); color: white">Hours</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                    <tr>
                                        <td style="background-color: white; color: black">{{ $task['date'] }}</td>
                                        <td style="background-color: white; color: black">{{ $task['day'] }}</td>
                                        <td style="background-color: white; color: black;text-transform:capitalize">{{ $task['tasks'] }}</td>
                                        <td style="background-color: white; color: black">{{ $task['hours'] }}</td>
                                    </tr>
                                    @endforeach
                                    @php
                                    $totalDays = array_reduce($tasks, function ($carry, $task) {
                                    if (isset($task['day'])) {
                                    return $carry + 1;
                                    }
                                    return $carry;
                                    }, 0);

                                    $totalHours = array_reduce($tasks, function ($carry, $task) {
                                    if (isset($task['hours'])) {
                                    return $carry + $task['hours'];
                                    }
                                    return $carry;
                                    }, 0);
                                    @endphp
                                    <tr>
                                        <td colspan="4" style="background-color: lightgray; color: black; font-weight: bold;text-align:center">
                                            <div class="row">
                                                <div class="col">
                                                    Total Days : {{ $totalDays }}
                                                </div>
                                                <div class="col">
                                                    Total Hours :{{ $totalHours }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;width:100px;text-transform:capitalize">{{ $timesheet->submission_status }}
                    </td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;width:100px;text-transform:capitalize">{{ $timesheet->approval_status_for_manager }}</td>
                    <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;width:100px;text-transform:capitalize">{{ $timesheet->approval_status_for_hr }}</td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
    @endif
</div>