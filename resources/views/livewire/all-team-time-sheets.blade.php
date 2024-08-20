<div>
    <div class="all-team-time-sheet-container">
        @if (session('approve_status'))
        <div id="success-message" class="alert alert-success">
            {{ session('approve_status') }}
        </div>
        @endif
        <div class="filter-container">
            <div class="container-fluid filter-heading">Time Sheet Filters</div>
            <div class="team-time-sheet-filters p-2">
                <div class="filter-row">
                    <div>
                        <label for="emp_id">Employee ID</label>
                        <input class="employee-search" type="text" id="emp_id" wire:input="teamTimeSheetsFilter" wire:model.debounce.0ms="emp_id" placeholder="Search by employee ID">
                    </div>
                    <div>
                        <label for="first_name">First Name</label>
                        <input class="employee-search" type="text" id="first_name" wire:input="teamTimeSheetsFilter" wire:model.debounce.0ms="first_name" placeholder="Search by first name">
                    </div>
                    <div>
                        <label for="last_name">Last Name</label>
                        <input class="employee-search" type="text" id="last_name" wire:input="teamTimeSheetsFilter" wire:model.debounce.0ms="last_name" placeholder="Search by last name">
                    </div>

                </div>
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
                            <option value="submitted">Submitted</option>
                            <option value="saved">Saved</option>
                        </select>
                    </div>
                    <div>
                        <label for="manager_approval">Manager Approval Status</label>
                        <select id="manager_approval" wire:change="teamTimeSheetsFilter" wire:model="manager_approval">
                            <option value="">All</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                            <option value="pending">Pending</option>
                            <option value="re-submit">Re-Submit</option>
                        </select>
                    </div>
                    <div>
                        <label for="hr_approval">HR Approval Status</label>
                        <select id="hr_approval" wire:change="teamTimeSheetsFilter" wire:model="hr_approval">
                            <option value="">All</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                            <option value="pending">Pending</option>
                            <option value="re-submit">Re-Submit</option>
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
                        <th class="actions-header">Actions</th>
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

                    @if ($startDate != $previousStartDate || $endDate != $previousEndDate)
                    <!-- Timesheet Details Header -->
                    <tr>
                        <td colspan="11">
                            <div class="grouped-header"> Weekly Time Sheet Overview: {{ $startDate->format('d-M-Y') }} to {{ $endDate->format('d-M-Y') }} </div>
                        </td>

                    </tr>
                    @php
                    $previousStartDate = $startDate;
                    $previousEndDate = $endDate;
                    @endphp
                    @endif
                    <tr class="data-row" data-index="{{ $index }}">
                        <td class="accordion-icon">
                            <a href="#" class="toggle-icon" data-index="{{ $index }}">
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
                        <td class="submission-header">{{ $team->submission_status }}</td>
                        <td class="submission-header">{{ $team->approval_status_for_manager }}</td>
                        <td class="submission-header">{{ $team->approval_status_for_hr }}</td>
                        <td class="actions-header">
                            @if($team->approval_status_for_manager != "approved" && $team->approval_status_for_manager != "rejected" && $team->approval_status_for_manager != "re-submit")
                            <button class="approve-manager" wire:click="approve({{ $team->id }})">Approve</button>
                            <!-- Re-Submit Button -->

                            <button class="resubmit-manager" onclick="showReasonModal('resubmit', {{ $team->id }})">Re-submit</button>

                            <!-- Reject Button -->
                            <button class="reject-manager" onclick="showReasonModal('reject', {{ $team->id }})">Reject</button>
                            @elseif($team->approval_status_for_manager=="approved")
                            <div class="approved-manager">{{$team->approval_status_for_manager}}</div>
                            @elseif($team->approval_status_for_manager=="rejected")
                            <div class="rejected-manager">{{$team->approval_status_for_manager}}</div>
                            @elseif($team->approval_status_for_manager=="re-submit")
                            <div class="resubmitted-manager">{{$team->approval_status_for_manager}}</div>
                            @endif
                        </td>
                    </tr>

                    <!-- Details Row -->
                    <tr class="detail-row" id="details-{{ $index }}">
                        <td colspan="11">
                            <table>
                                <thead>
                                    <tr class="details-ts">
                                        <th>Dates</th>
                                        <th>Days</th>
                                        <th>Clients</th>
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
                        <td colspan="11">
                            No time sheets available.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

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

        /* Approve Button */
        .approve-manager {
            color: rgb(2, 17, 79);
            padding: 3px 8px;
            border-radius: 2px;
            cursor: pointer;
            border: none;
            font-size: 14px;
        }

        .approve-manager,
        .reject-manager,
        .resubmit-manager {
            width: 100px;
            margin-bottom: 2px
        }

        .grouped-header {
            color: rgb(2, 17, 79);
            font-weight: 600;
            text-align: start;
            font-size: 0.8rem;
            padding: 5px;
        }

        .approved-manager {
            color: green;
            text-transform: capitalize;
        }

        .approved-manager,
        .rejected-manager,
        .resubmitted-manager {
            font-size: 0.8rem;
            padding: 5px;
        }

        .rejected-manager {
            color: red;
            text-transform: capitalize;

        }

        .resubmitted-manager {
            color: orange;
            text-transform: capitalize;
        }

        /* Reject Button */
        .reject-manager {
            color: rgb(2, 17, 79);
            padding: 3px 8px;
            border-radius: 2px;
            cursor: pointer;
            border: none;
            font-size: 14px;
        }



        /* Re-submit Button */
        .resubmit-manager {
            color: rgb(2, 17, 79);
            padding: 3px 8px;
            border-radius: 2px;
            cursor: pointer;
            border: none;
            font-size: 14px;
        }

        /* Optional: Hover Effects */
        .approved-manager,
        .rejected-manager,
        .resubmitted-manager {
            width: 100px;
        }

        .approve-manager:hover,
        .reject-manager:hover,
        .resubmit-manager:hover {
            background-color: rgba(2, 17, 79);
            color: white;
        }

        .approve-manager:focus,
        .reject-manager:focus,
        .resubmit-manager:focus {
            outline: none;
        }

        .actions-header {
            text-transform: capitalize;
        }

        /* General Styles */

        .submission-header,
        .timesheet-type-header {
            width: 10%;
        }

        .date-header {
            width: 14%
        }

        .submission-header {
            text-transform: capitalize;
        }

        .day-header,
        .hours-header {
            width: 5%;
        }

        .employee-header {
            p {
                margin-bottom: 0px;
            }

            width: 25%;
        }

        .accordion-icon {
            width: 1%;
        }

        #success-message {
            display: flex;
            justify-content: center;
        }

        .all-team-time-sheet-container {
            width: 100%;
            font-size: 0.8rem;
            background-color: #fff;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
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

        /* Expandable row styles */
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
            border-radius: 8px;
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
            background-color: rgb(2, 17, 79);
            color: white;
            font-weight: 600;
            padding: 5px;
            text-align: center;
            border-radius: 5px
        }

        /* Add these styles to your CSS file or inside a <style> tag */
        @media (max-width: 600px) {
            #reason-modal {
                width: 90%;
                /* Adjust modal width for smaller screens */
                max-width: 400px;
                /* Ensure it doesn't grow too large */
                font-size: 0.9rem;
                /* Slightly larger font size for readability */
            }
        }

        #reason-modal {
            /* Common styles */
            box-sizing: border-box;
            max-width: 100%;
            /* Ensure modal does not exceed viewport width */
        }

        #overlay {
            /* Overlay styles */
            opacity: 0.5;
            /* Adjust overlay opacity for better visibility on mobile */
        }
    </style>
</div>

<script>
    // Modify event listener for better mobile compatibility
    document.querySelectorAll('.toggle-icon').forEach(function(icon) {
        icon.addEventListener('click', function(event) {
            event.preventDefault();
            var index = this.getAttribute('data-index');
            var detailRow = document.getElementById('details-' + index);

            if (detailRow.classList.contains('open')) {
                detailRow.classList.remove('open');
                this.classList.remove('open');
            } else {
                document.querySelectorAll('.detail-row').forEach(function(row) {
                    row.classList.remove('open');
                });
                document.querySelectorAll('.toggle-icon').forEach(function(icon) {
                    icon.classList.remove('open');
                });
                detailRow.classList.add('open');
                this.classList.add('open');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var message = document.getElementById('success-message');
            if (message) {
                message.style.display = 'none';
            }
        }, 5000);
    });

    function showReasonModal(action, teamId) {
        // Create a modal dynamically
        const modal = document.createElement('div');
        modal.id = 'reason-modal';
        modal.style.position = 'fixed';
        modal.style.top = '50%';
        modal.style.left = '50%';
        modal.style.transform = 'translate(-50%, -50%)';
        modal.style.backgroundColor = '#fff';
        modal.style.border = '1px solid #ddd';
        modal.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
        modal.style.padding = '20px';
        modal.style.zIndex = '1000';
        modal.style.width = '80%'; // Adjust width for responsiveness
        modal.style.maxWidth = '400px'; // Maximum width for large screens
        modal.style.borderRadius = '8px';
        modal.style.fontSize = '0.8rem';

        // Create the content of the modal
        const content = `
    <h3 style="margin-top: 0; font-size: 1rem; color: #333;">${action.charAt(0).toUpperCase() + action.slice(1)} Reason</h3>
    <textarea id="reason-text" rows="4" placeholder="Enter your reason here..." style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc; box-sizing: border-box; font-size: 0.8rem;"></textarea>
    <div style="margin-top: 10px; text-align: center;">
        <button onclick="submitReason('${action}', ${teamId})" style="background-color: #007bff; color: #fff; border: none; border-radius: 4px; padding: 8px 16px; cursor: pointer; font-size: 0.8rem; margin: 0 8px;">Submit</button>
        <button onclick="closeModal()" style="background-color: #6c757d; color: #fff; border: none; border-radius: 4px; padding: 8px 16px; cursor: pointer; font-size: 0.8rem; margin: 0 8px;">Cancel</button>
    </div>
`;
        modal.innerHTML = content;

        // Append the modal to the body
        document.body.appendChild(modal);

        // Add an overlay
        const overlay = document.createElement('div');
        overlay.id = 'overlay';
        overlay.style.position = 'fixed';
        overlay.style.top = '0';
        overlay.style.left = '0';
        overlay.style.width = '100%';
        overlay.style.height = '100%';
        overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
        overlay.style.zIndex = '999';
        document.body.appendChild(overlay);
    }

    function submitReason(action, teamId) {
        const reason = document.getElementById('reason-text').value;
        if (!reason) {
            alert('Please provide a reason.');
            return;
        }

        // Perform an action based on the reason and action type
        if (action === 'resubmit') {
            // Call your Livewire component method or make an AJAX request for resubmission
            @this.call('resubmit', teamId, reason);
        } else if (action === 'reject') {
            // Call your Livewire component method or make an AJAX request for rejection
            @this.call('reject', teamId, reason);
        }

        // Close the modal after submission
        closeModal();
    }

    function closeModal() {
        document.getElementById('reason-modal').remove();
        document.getElementById('overlay').remove();
    }
</script>