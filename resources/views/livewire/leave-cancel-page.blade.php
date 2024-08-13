<div>
    @if (session()->has('message'))
    <div id="successMessage" class="alert alert-success">
        {{ session('message') }}
    </div>
    @elseif (session()->has('error'))
    <div id="errorMessage" class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <script>
        // Auto dismiss after 5 seconds
        setTimeout(function() {
            const successMessage = document.getElementById('successMessage');
            const errorMessage = document.getElementById('errorMessage');

            if (successMessage) {
                successMessage.style.display = 'none';
            }
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }, 5000); // 5000 milliseconds = 5 seconds
    </script>
    <div class="applyContainer">
        @if($LeaveShowinfoMessage)
        <div class="hide-info p-2 mb-2 mt-2 rounded d-flex justify-content-between align-items-center">
            <p class="mb-0" style="font-size:11px;">Leave Cancel enables you to apply for cancellation of approved leave applications. Please select a leave type to get started..</p>
            <p class="mb-0 hideInfo" wire:click="toggleInfoLeave">Hide</p>
        </div>
        @endif
        <div class="d-flex justify-content-between">
            <p class="applyingFor">Applying for Leave Cancel</p>
            @if($LeaveShowinfoButton)
            <p class="info-paragraph" wire:click="toggleInfoLeave">Info</p>
            @endif
        </div>
        <form wire:submit.prevent="markAsLeaveCancel">
            <div>
                <div class="table-responsive">
                    <table class="LeaveCancelTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Leave Type</th>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Days</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($cancelLeaveRequests && $cancelLeaveRequests->count() > 0)
                            @foreach($cancelLeaveRequests as $leaveRequest)
                            <tr>
                                <td wire:click="applyingTo({{ $leaveRequest->id }})"><input type="radio" name="leaveType"></td>
                                <td>{{ $leaveRequest->leave_type }}</td>
                                <td>{{ $leaveRequest->from_date->format('d M, Y') }}</td>
                                <td>{{ $leaveRequest->to_date->format('d M, Y') }}</td>
                                <td>{{ $this->calculateNumberOfDays($leaveRequest->from_date, $leaveRequest->from_session, $leaveRequest->to_date, $leaveRequest->to_session) }}</td>
                                <td>{{ $leaveRequest->reason }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6">
                                    No data found.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- inputs fields -->
                @if($showApplyingTo)
                <div class="form-group mt-3" style="margin-top: 10px;">
                    <div style="display:flex; flex-direction:row;">
                        <span class="normalTextValue" style="cursor: pointer;">
                            <img src="https://t4.ftcdn.net/jpg/05/35/51/31/360_F_535513106_hwSrSN1TLzoqdfjWpv1zWQR9Y5lCen6q.jpg" alt="" width="35px" height="32px" style="border-radius:50%;color:#778899;">
                            Applying To
                        </span>
                    </div>
                </div>
                @endif
                @if($show_reporting)
                <div class="form-group mt-3">
                    <span class="normalTextValue">Applying To</span>
                </div>
                <div class="reporting mb-2" wire:ignore.self>
                    @if($managerDetails)
                    <div class="employee-profile-image-container">
                        @if($managerDetails['image'])
                        <img height="40" width="40" src="{{ asset('storage/' . $managerDetails['image']) }}" style="border-radius:50%;">
                        @else
                        <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" class="employee-profile-image-placeholder" style="border-radius:50%;" height="40" width="40" alt="Default Image">
                        @endif
                    </div>
                    <div class="center p-0 m-0">
                        <p id="reportToText" class="ellipsis mb-0">{{ ucwords(strtolower($managerDetails['report_to'])) }}</p>
                        <p class="mb-0" style="color:#778899; font-size:10px;margin-bottom:0;" id="managerIdText">
                            <span class="remaining">#{{ $managerDetails['manager_id'] }}</span>
                        </p>
                    </div>
                    @else
                    <div class="employee-profile-image-container">
                        <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" class="employee-profile-image-placeholder" style="border-radius:50%;" height="40" width="40" alt="Default Image">
                    </div>
                    <div class="center p-0 m-0">
                        <p class="mb-0" style="font-size:10px;margin-bottom:0;">N/A</p>
                        <p class="mb-0" style="font-size:10px;margin-bottom:0;">#(N/A)</p>
                    </div>
                    @endif
                    <div class="downArrow" wire:click="toggleApplyingto">
                        <i class="fas fa-chevron-down" style="cursor:pointer"></i>
                    </div>
                </div>
                @endif

                @if($showApplyingToContainer)
                <div class="searchContainer">
                    <!-- Content for the search container -->
                    <div class="row" style="padding: 0 15px; margin-bottom: 10px;">
                        <div class="row m-0 p-0 d-flex align-items-center justify-content-between" style="padding: 0 ; margin:0;">
                            <div class="col-md-10" style="margin: 0px; padding: 0px">
                                <div class="input-group">
                                    <input wire:model="filter" id="searchInput" style="font-size: 12px; border-radius: 5px 0 0 5px; cursor: pointer; width:50%;" type="text" class="form-control placeholder-small" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1" wire:keydown.enter.prevent="handleEnterKey">
                                    <div class="input-group-append searchBtnBg d-flex align-items-center">
                                        <button type="button" wire:click="searchEmployees" class="search-btn">
                                            <i style="margin-right: 5px;" class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 m-0 p-0">
                                <button wire:click="toggleApplyingto" type="button" class="close rounded px-1 py-0" aria-label="Close" style="background-color: rgb(2,17,79);height:33px;width:33px;">
                                    <span aria-hidden="true" style="color: white; font-size: 24px;">×</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Your Blade file -->
                    <div class="scrollApplyingTO">
                        @if(!empty($managerFullName))
                        @foreach($managerFullName as $employee)
                        <div class="d-flex gap-4 align-items-center" style="cursor: pointer; @if(in_array($employee['emp_id'], $selectedManager)) background-color: #d6dbe0; @endif" wire:click="toggleManager('{{ $employee['emp_id'] }}')" wire:key="{{ $employee['emp_id'] }}">
                            @if($employee['image'])
                            <div class="employee-profile-image-container">
                                <img height="35px" width="35px" src="{{ asset('storage/' . $employee['image']) }}" style="border-radius:50%;">
                            </div>
                            @else
                            <div class="employee-profile-image-container">
                                <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" class="employee-profile-image-placeholder" style="border-radius:50%;" height="35px" width="35px" alt="Default Image">
                            </div>
                            @endif
                            <div class="center d-flex flex-column mt-2 mb-2">
                                <span class="ellipsis mb-0" value="{{ $employee['full_name'] }}">{{ $employee['full_name'] }}</span>
                                <span class="mb-0" style="color:#778899; font-size:10px;margin-bottom:0;" value="{{ $employee['full_name'] }}"> #{{ $employee['emp_id'] }} </span>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <p class="normalTextValue mb-0 text-center">No managers found.</p>
                        @endif

                    </div>
                </div>
                @endif
                <div class="form-group mt-3">
                    <span class="normalTextValue">
                        CC To
                    </span>
                    <div class="control-wrapper d-flex align-items-center" style="gap: 10px;cursor:pointer;">
                        <a class="text-3 text-secondary control" aria-haspopup="true" wire:click="openCcRecipientsContainer" style="text-decoration: none;">
                            <div class="icon-container">
                                <i class="fas fa-plus" style="color: #778899;"></i>
                            </div>
                        </a>
                        <!-- Blade Template: your-component.blade.php -->
                        <span class="addText" wire:click="openCcRecipientsContainer">Add</span>

                        @if(count($selectedCCEmployees) > 0)
                        <ul class=" d-flex align-items-center mb-0" style="list-style-type: none;gap:10px;">
                            @foreach($selectedCCEmployees as $recipient)
                            <li>
                                <div class="px-2 py-1 d-flex justify-content-between align-items-center" style=" border-radius: 25px; border: 2px solid #adb7c1;" title="{{ ucwords(strtolower( $recipient['first_name'])) }} {{ ucwords(strtolower( $recipient['last_name'])) }}">
                                    <span style="text-transform: uppercase; color: #adb7c1;font-size:12px;">{{ $recipient['initials'] }}</span>
                                    <i class="fas fa-times-circle cancel-icon d-flex align-items-center justify-content-end" style="cursor: pointer;color:#adb7c1;" wire:click="removeFromCcTo('{{ $recipient['emp_id'] }}')"></i>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>

                    @if($showCcRecipents)
                    <div class="ccContainer" x-data="{ open: @entangle('showCcRecipents') }" x-cloak @click.away="open = false">
                        <div class="row m-0 p-0 d-flex align-items-center justify-content-between" style="padding: 0 ; margin:0;">
                            <div class="col-md-10" style="margin: 0px; padding: 0px">
                                <div class="input-group">
                                    <input wire:model.debounce.500ms="searchTerm" wire:input="searchCCRecipients" id="searchInput" style="font-size: 12px; border-radius: 5px 0 0 5px; cursor: pointer; width:50%;" type="text" class="form-control placeholder-small" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1" wire:keydown.enter.prevent="handleEnterKey">
                                    <div class="input-group-append searchBtnBg d-flex align-items-center">
                                        <button type="button" wire:click="searchCCRecipients" class="search-btn">
                                            <i style="margin-right: 5px;" class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 m-0 p-0">
                                <button wire:click="closeCcRecipientsContainer" type="button" class="close rounded px-1 py-0" aria-label="Close" style="background-color: rgb(2,17,79);height:33px;width:33px;">
                                    <span aria-hidden="true" style="color: white; font-size: 24px;"><i class="fas fa-times"></i></span>
                                </button>
                            </div>
                        </div>
                        <div class="scrollApplyingTO mb-2 mt-2">
                            @if(!empty($ccRecipients))
                            @foreach($ccRecipients as $employee)
                            <div wire:key="{{ $employee['emp_id'] }}">
                                <div class="d-flex align-items-center mt-2 align-items-center" style=" gap: 10px; text-transform: capitalize; cursor: pointer;" wire:click="toggleSelection('{{ $employee['emp_id'] }}')">
                                    <input type="checkbox" wire:model="selectedPeople.{{ $employee['emp_id'] }}" style="margin-right: 10px; cursor:pointer;" wire:click="handleCheckboxChange('{{ $employee['emp_id'] }}')">

                                    @if($employee['image'])
                                    <div class="employee-profile-image-container">
                                        <img height="35px" width="35px" src="{{ asset('storage/' . $employee['image']) }}" style="border-radius: 50%;">
                                    </div>
                                    @else
                                    <div class="employee-profile-image-container">
                                        <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" class="employee-profile-image-placeholder" style="border-radius: 50%;" height="35px" width="35px" alt="Default Image">
                                    </div>
                                    @endif

                                    <div class="center mb-2 mt-2">
                                        <p class="mb-0 empCcName">{{ ucwords(strtolower($employee['full_name'])) }}</p>
                                        <p class="mb-0 empIdStyle">#{{ $employee['emp_id'] }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="mb-0 normalTextValue">
                                No data found
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    @error('cc_to') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="reason">Reason for Leave</label>
                    <textarea id="reason" class="form-control placeholder-small" wire:model="reason" id="reason" name="reason" placeholder="Enter Reason" rows="4"></textarea>
                    @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="cancelButtons d-flex align-items-center gap-2 justify-content-center mt-4">
                    <button type="submit" class="submit-btn">Submit</button>
                    <button type="button" class="cancel-btn" style="border:1px solid rgb(2,17,79);">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>