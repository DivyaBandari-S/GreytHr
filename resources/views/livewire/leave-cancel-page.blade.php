<div>
    @if (session()->has('message'))
    <div id="successMessage" class="alert alert-success text-align-center" wire:poll.5s="hideAlert">
        {{ session('message') }}
    </div>
    @elseif (session()->has('error'))
    <div id="errorMessage" class="alert alert-danger text-align-center" wire:poll.5s="hideAlert">
        {{ session('error') }}
    </div>
    @endif

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
                <div>
                    @if($showApplyingTo)
                    <div class="form-group mt-3">
                        <div class="d-flex " wire:click="applyingTo" >
                            <span class="normalTextValue" style="cursor: pointer;">
                                <img src="https://t4.ftcdn.net/jpg/05/35/51/31/360_F_535513106_hwSrSN1TLzoqdfjWpv1zWQR9Y5lCen6q.jpg" alt="" width="35px" height="32px" style="border-radius:50%;color:#778899;">
                                Applying To <span class="requiredMark">*</span>
                            </span>
                        </div>
                    </div>
                    @endif
                    <!-- Your Blade file -->
                    @if($show_reporting)
                    <div class="form-group mt-3">
                        <span class="normalTextValue"> Applying To</span>
                    </div>
                    <div class="reporting mb-2">
                        @if($selectedManagerDetails)
                        @if($selectedManagerDetails->image)
                        <div class="employee-profile-image-container">
                            <img height="40" width="40" src="{{ 'data:image/jpeg;base64,' . base64_encode($selectedManagerDetails->image)}}" style="border-radius:50%;">
                        </div>
                        @else
                        <div class="employee-profile-image-container">
                            <img src="{{ asset('images/user.jpg') }}" class="employee-profile-image-placeholder" style="border-radius:50%;" height="40" width="40" alt="Default Image">
                        </div>
                        @endif
                        <div class="center p-0 m-0">
                            <p id="reportToText" class="ellipsis mb-0">{{ ucwords(strtolower($selectedManagerDetails->first_name)) }} {{ ucwords(strtolower($selectedManagerDetails->last_name)) }}</p>
                            <p class="mb-0 normalTextValue" style="font-size: 10px !important;" id="managerIdText"><span class="remaining">#{{$selectedManagerDetails->emp_id}}</span></p>
                        </div>
                        @else
                        <div class="center p-0 m-0">
                            <p class="mb-0" style="font-size:10px;">N/A</p>
                            <p class="mb-0 normalTextValue" style="font-size: 10px !important;" id="managerIdText">#(N/A)</p>
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
                        <div class="row mb-2 py-0 ">
                            <div class="row m-0 p-0 d-flex align-items-center justify-content-between">
                                <div class="col-md-10 m-0">
                                    <div class="input-group">
                                        <input
                                            wire:model="searchQuery"
                                            id="searchInput"
                                            type="text"
                                            class="form-control placeholder-small"
                                            placeholder="Search...."
                                            aria-label="Search"
                                            aria-describedby="basic-addon1"
                                            style="font-size: 12px; border-radius: 5px 0 0 5px; cursor: pointer; width:50%;">
                                        <div class="input-group-append searchBtnBg d-flex align-items-center">
                                            <button
                                                type="button"
                                                class="search-btn"
                                                wire:click="getFilteredManagers">
                                                <i style="color:#fff;margin-left:10px;" class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 m-0 p-0">
                                    <button wire:click="toggleApplyingto" type="button" class="close rounded px-1 py-0" aria-label="Close" style="background-color: #ccc;border:#ccc;height:33px;width:33px;">
                                        <span aria-hidden="true" style="color: white; font-size: 18px;"><i class="fas fa-times "></i>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Your Blade file -->
                        <div class="scrollApplyingTO">
                            @if(!empty($managers))
                            @foreach($managers as $employee)
                            <div class="d-flex gap-4 align-items-center"
                                style="cursor: pointer; @if(in_array($employee['emp_id'], $selectedManager)) background-color: #d6dbe0; @endif"
                                wire:click="toggleManager('{{ $employee['emp_id'] }}')" wire:key="{{ $employee['emp_id'] }}">
                                @if($employee['image'])
                                <div class="employee-profile-image-container">
                                    <img height="35px" width="35px" src="{{ 'data:image/jpeg;base64,' . base64_encode($employee['image'])}}" style="border-radius:50%;">
                                </div>
                                @else
                                <div class="employee-profile-image-container">
                                    <img src="{{ asset('images/user.jpg') }}" class="employee-profile-image-placeholder" style="border-radius:50%;" height="35px" width="35px" alt="Default Image">
                                </div>
                                @endif
                                <div class="center d-flex flex-column mt-2 mb-2">
                                    <span class="ellipsis mb-0">{{ $employee['full_name'] }}</span>
                                    <span class="mb-0 normalTextValue" style="font-size:10px;"> #{{ $employee['emp_id'] }} </span>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <p class="mb-0 normalTextValue m-auto text-center">No managers found.</p>
                            @endif
                        </div>
                    </div>
                    @endif
                    @error('applying_to') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group mt-3">
                    <span class="normalTextValue">
                        CC To
                    </span>
                    <div class="control-wrapper d-flex align-items-center" style="gap: 10px;cursor:pointer;">
                        <a class="text-3 text-secondary control" aria-haspopup="true" wire:click="openCcRecipientsContainer" style="text-decoration: none;">
                            <div class="icon-container">
                                <i class="fa fa-plus" style="color: #778899;"></i>
                            </div>
                        </a>
                        <!-- Blade Template: your-component.blade.php -->
                        <span class="addText" wire:click="openCcRecipientsContainer">Add</span>

                        @if(count($selectedCCEmployees) > 0)
                        @php
                        $employeesCollection = collect($selectedCCEmployees);
                        $visibleEmployees = $employeesCollection->take(3);
                        $hiddenEmployees = $employeesCollection->slice(3);
                        @endphp

                        <ul class="d-flex align-items-center mb-0" style="list-style-type: none; gap:10px;">
                            @foreach($visibleEmployees as $recipient)
                            <li>
                                <div class="px-2 py-1 d-flex justify-content-between align-items-center" style="border-radius: 25px; border: 2px solid #adb7c1; gap:10px;" title="{{ ucwords(strtolower($recipient['first_name'])) }} {{ ucwords(strtolower($recipient['last_name'])) }}">
                                    <span style="color: #778899; font-size:12px;">{{ ucwords(strtolower($recipient['first_name'])) }} {{ ucwords(strtolower($recipient['last_name'])) }}</span>
                                    <i class="fas fa-times-circle cancel-icon d-flex align-items-center justify-content-end" style="cursor: pointer; color:#adb7c1;" wire:click="removeFromCcTo('{{ $recipient['emp_id'] }}')"></i>
                                </div>
                            </li>
                            @endforeach

                            @if(count($selectedCCEmployees) > 3)
                            <li>
                                <span type="button" wire:click="openModal" class="normalText">View More</span>
                            </li>
                            @endif
                        </ul>

                        <!-- Popup Modal -->
                        @if($showCCEmployees)
                        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" style="color:white;">More Recipients</h5>
                                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close"
                                            wire:click="openModal" style="background-color: white; height:10px;width:10px;">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="d-flex align-items-center mb-0" style="list-style-type: none; gap:10px;">
                                            @foreach($hiddenEmployees as $recipient)
                                            <li>
                                                <div class="px-2 py-1 d-flex justify-content-between align-items-center" style="border-radius: 25px; border: 2px solid #adb7c1; gap:10px;" title="{{ ucwords(strtolower($recipient['first_name'])) }} {{ ucwords(strtolower($recipient['last_name'])) }}">
                                                    <span style="color: #778899; font-size:12px;">{{ ucwords(strtolower($recipient['first_name'])) }} {{ ucwords(strtolower($recipient['last_name'])) }}</span>
                                                    <i class="fas fa-times-circle cancel-icon d-flex align-items-center justify-content-end" style="cursor: pointer; color:#adb7c1;" wire:click="removeFromCcTo('{{ $recipient['emp_id'] }}')"></i>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-backdrop fade show"></div>
                        @endif
                        @endif
                    </div>

                    @if($showCcRecipents)
                    <div class="ccContainer" x-data="{ open: @entangle('showCcRecipents') }" x-cloak @click.away="open = false">
                        <div class="row m-0 p-0 d-flex align-items-center justify-content-between">
                            <div class="col-md-10" style="margin: 0;padding:0 2px;">
                                <div class="input-group">
                                    <input wire:model.debounce.500ms="searchTerm" wire:input="searchCCRecipients" id="searchInput" style="font-size: 12px; border-radius: 5px 0 0 5px; cursor: pointer; width:50%;" type="text" class="form-control placeholder-small" placeholder="Search..." aria-label="Search" aria-describedby="basic-addon1" wire:keydown.enter.prevent="handleEnterKey">
                                    <div class="input-group-append searchBtnBg d-flex align-items-center">
                                        <button type="button" wire:click="searchCCRecipients" class="search-btn">
                                            <i style="margin-left: 10px;" class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 m-0 p-0">
                                <button wire:click="closeCcRecipientsContainer" type="button" class="close rounded px-1 py-0" aria-label="Close" style="background-color: #ccc;border:#ccc;height:33px;width:33px;">
                                    <span aria-hidden="true" style="color: white; font-size: 18px;"><i class="fas fa-times "></i></span>
                                </button>
                            </div>
                        </div>
                        <div class="scrollApplyingTO mb-2 mt-2">
                            @if(!empty($ccRecipients))
                            @foreach($ccRecipients as $employee)
                            <div wire:key="{{ $employee['emp_id'] }}">
                                <div class="d-flex align-items-center mt-2 align-items-center" style=" gap: 10px; text-transform: capitalize; cursor: pointer;" wire:click="toggleSelection('{{ $employee['emp_id'] }}')">
                                    <input type="checkbox" wire:model="selectedPeople.{{ $employee['emp_id'] }}" style="margin-right: 10px; cursor:pointer;" wire:click="handleCheckboxChange('{{ $employee['emp_id'] }}')">
                                    @if(!empty($employee['image']) && ($employee['image'] !== 'null'))
                                    <div class="employee-profile-image-container">
                                        <img height="35px" width="35px" src="{{ 'data:image/jpeg;base64,' . base64_encode($employee['image'])}}" style="border-radius: 50%;">
                                    </div>
                                    @else
                                    @if($employee['gender'] === "Male")
                                    <div class="employee-profile-image-container">
                                        <img src="{{ asset('images/male-default.png') }}" class="employee-profile-image-placeholder" style="border-radius: 50%;" height="33" width="33">
                                    </div>
                                    @elseif($employee['gender'] === "Female")
                                    <div class="employee-profile-image-container">
                                        <img src="{{ asset('images/female-default.jpg') }}" class="employee-profile-image-placeholder" style="border-radius: 50%;" height="33" width="33">
                                    </div>
                                    @else
                                    <div class="employee-profile-image-container">
                                        <img src="{{ asset('images/user.jpg') }}" class="employee-profile-image-placeholder" style="border-radius: 50%;" height="35px" width="35px">
                                    </div>
                                    @endif
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
                    <label for="leave_cancel_reason">Reason for Leave Cancel</label>
                    <textarea id="leave_cancel_reason" class="form-control placeholder-small" wire:model="leave_cancel_reason" name="leave_cancel_reason" placeholder="Enter Reason" rows="4"></textarea>
                    @error('leave_cancel_reason') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="cancelButtons d-flex align-items-center gap-2 justify-content-center mt-4">
                    <button type="submit" class="submit-btn">Submit</button>
                    <button type="button" class="cancel-btn" style="border:1px solid rgb(2,17,79);" wire:click="cancel">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>