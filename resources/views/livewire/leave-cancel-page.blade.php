<div>
    @if (session()->has('message'))
    <div id="successMessage" class="alert alert-success text-align-center" wire:poll.5s="hideAlert">
        {{ session('message') }}
    </div>
    @elseif (session()->has('error'))
    <div id="errorMessage" class="alert alert-danger text-align-center" wire:poll.2s="hideAlert">
        {{ session('error') }}
    </div>
    @endif

    <div class="applyContainer">
        @if($LeaveShowinfoMessage)
        <div class="hide-info p-2 mb-2 mt-2 rounded d-flex justify-content-between align-items-center">
            <p class="mb-0 normalTextSmall">Leave Cancel enables you to apply for cancellation of approved leave applications. Please select a leave type to get started..</p>
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
                                <td wire:click="applyingTo({{ $leaveRequest->id }})"><input type="radio" name="leaveType" wire:model="selectedLeaveType"></td>
                                <td>{{ $leaveRequest->leave_type }}</td>
                                <td>{{ $leaveRequest->from_date->format('d M, Y') }}</td>
                                <td>{{ $leaveRequest->to_date->format('d M, Y') }}</td>
                                <td>{{ $this->calculateNumberOfDays($leaveRequest->from_date, $leaveRequest->from_session, $leaveRequest->to_date, $leaveRequest->to_session,$leaveRequest->leave_type) }}</td>
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
                        <div class="downArrow d-flex">
                            <span class="normalTextValue">
                                <img class="rounded-circle" src="https://t4.ftcdn.net/jpg/05/35/51/31/360_F_535513106_hwSrSN1TLzoqdfjWpv1zWQR9Y5lCen6q.jpg" alt="" width="35px" height="32px">
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
                            <img class="rounded-circle navProfileImg" src="data:image/jpeg;base64,{{($selectedManagerDetails->image)}}">
                        </div>
                        @else
                        <div class="employee-profile-image-container">
                            <img src="{{ asset('images/user.jpg') }}" class="employee-profile-image-placeholder rounded-circle" height="40" width="40" alt="Default Image">
                        </div>
                        @endif
                        <div class=" p-0 m-0">
                            <p id="reportToText" class="ellipsis mb-0">{{ ucwords(strtolower($selectedManagerDetails->first_name)) }} {{ ucwords(strtolower($selectedManagerDetails->last_name)) }}</p>
                            <p class="mb-0 normalTextSmall" id="managerIdText"><span class="remaining">#{{$selectedManagerDetails->emp_id}}</span></p>
                        </div>
                        @else
                        <div class=" p-0 m-0">
                            <p class="mb-0 normalTextSmall">N/A</p>
                            <p class="mb-0 normalTextSmall" id="managerIdText">#(N/A)</p>
                        </div>
                        @endif
                        <div class="downArrow " wire:click="toggleApplyingto">
                            <i class="fas fa-chevron-down "></i>
                        </div>
                    </div>
                    @endif


                    @if($showApplyingToContainer)
                    <div class="searchContainer">
                        <!-- Content for the search container -->
                        <div class="row mb-2 py-0 ">
                            <div class="row d-flex align-items-center justify-content-between">
                                <div class="col-md-10 m-0 py-0 px-2">
                                    <div class="input-group">
                                        <input
                                            wire:model="searchQuery"
                                            id="searchInput"
                                            type="text"
                                            class="form-control searchBar placeholder-small"
                                            placeholder="Search...."
                                            aria-label="Search"
                                            aria-describedby="basic-addon1">
                                        <div class="input-group-append searchBtnBg d-flex align-items-center">
                                            <button
                                                type="button"
                                                class="search-btn-leave"
                                                wire:click="getFilteredManagers">
                                                <i class="fas fa-search "></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 m-0 p-0">
                                    <button wire:click="toggleApplyingto" type="button" class="close rounded px-1 py-0" aria-label="Close">
                                        <span aria-hidden="true" class="closeIcon"><i class="fas fa-times "></i>
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
                                @if(!empty($employee['image']) && ($employee['image'] !== 'null') && $employee['image'] !== null && $employee['image'] != "Null" && $employee['image'] != "")
                                <div class="employee-profile-image-container">
                                    <img class="rounded-circle navProfileImg" src="data:image/jpeg;base64,{{($employee['image'])}}">
                                </div>
                                @else
                                @if($employee['gender'] === "Male")
                                <div class="employee-profile-image-container">
                                    <img src="{{ asset('images/male-default.png') }}" class="employee-profile-image-placeholder rounded-circle" height="33" width="33">
                                </div>
                                @elseif($employee['gender'] === "Female")
                                <div class="employee-profile-image-container">
                                    <img src="{{ asset('images/female-default.jpg') }}" class="employee-profile-image-placeholder rounded-circle" height="33" width="33">
                                </div>
                                @else
                                <div class="employee-profile-image-container">
                                    <img src="{{ asset('images/user.jpg') }}" class="employee-profile-image-placeholder rounded-circle" height="35px" width="35px">
                                </div>
                                @endif
                                @endif
                                <div class="d-flex flex-column mt-2 mb-2">
                                    <span class="ellipsis mb-0">{{ $employee['full_name'] }}</span>
                                    <span class="mb-0 normalTextSmall"> #{{ $employee['emp_id'] }} </span>
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
                    <div class="control-wrapper d-flex align-items-center">
                        <a class="text-3 text-secondary control no-underline" aria-haspopup="true" wire:click="openCcRecipientsContainer">
                            <div class="icon-container">
                                <i class="fa fa-plus"></i>
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

                        <ul class="d-flex align-items-center list-unstyled mb-0 gap-3">
                            @foreach($visibleEmployees as $recipient)
                            <li>
                                <div class="px-2 py-1 d-flex justify-content-between align-items-center rounded-pill gap-3" style="border:2px solid #adb7c1;" title="{{ ucwords(strtolower($recipient['first_name'])) }} {{ ucwords(strtolower($recipient['last_name'])) }}">
                                    <span class="normalTextValue fw-normal">{{ ucwords(strtolower($recipient['first_name'])) }} {{ ucwords(strtolower($recipient['last_name'])) }}</span>
                                    <i class="fas fa-times-circle cancel-icon d-flex align-items-center justify-content-end " style="color:#adb7c1;cursor:pointer;" wire:click="removeFromCcTo('{{ $recipient['emp_id'] }}')"></i>
                                </div>
                            </li>
                            @endforeach

                            @if(count($selectedCCEmployees) > 3)
                            <li>
                                <span type="button" wire:click="openModal" class="anchorTagDetails">View More</span>
                            </li>
                            @endif
                        </ul>

                        <!-- Popup Modal -->
                        @if($showCCEmployees)
                        <div class="modal d-block" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">CC to</h5>
                                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close"
                                            wire:click="openModal">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="d-flex align-items-center mb-0 list-unstyled gap-3">
                                            @foreach($hiddenEmployees as $recipient)
                                            <li>
                                                <div class="px-2 py-1 d-flex justify-content-between align-items-center rounded-pill gap-3" style=" border: 2px solid #adb7c1;" title="{{ ucwords(strtolower($recipient['first_name'])) }} {{ ucwords(strtolower($recipient['last_name'])) }}">
                                                    <span class="normalTextValue">{{ ucwords(strtolower($recipient['first_name'])) }} {{ ucwords(strtolower($recipient['last_name'])) }}</span>
                                                    <i class="fas fa-times-circle cancel-icon d-flex align-items-center justify-content-end " style="color:#adb7c1;cursor:pointer;" wire:click="removeFromCcTo('{{ $recipient['emp_id'] }}')"></i>
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
                    <div class="ccContainer " x-data="{ open: @entangle('showCcRecipents') }" x-cloak @click.away="open = false">
                        @if(session()->has('error'))
                        <div class="alert alert-danger mb-2 position-absolute " wire:poll.2s="hideAlert" style="right:0;left:0;margin:0 10px;z-index:100;">{{ session('error') }}</div>
                        @endif
                        <div class="row  d-flex align-items-center justify-content-between">
                            <div class="col-md-10 m-0 py-0 px-2">
                                <div class="input-group">
                                    <input wire:model.debounce.500ms="searchTerm" wire:input="searchCCRecipients" id="searchInput" type="text" class="form-control placeholder-small" placeholder="Search..." aria-label="Search" aria-describedby="basic-addon1" wire:keydown.enter.prevent="handleEnterKey">
                                    <div class="input-group-append searchBtnBg d-flex align-items-center">
                                        <button type="button" wire:click="searchCCRecipients" class="search-btn-leave">
                                            <i class="fas fa-search "></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 m-0 p-0">
                                <button wire:click="closeCcRecipientsContainer" type="button" class="close rounded px-1 py-0" aria-label="Close">
                                    <span aria-hidden="true" class="closeIcon"><i class="fas fa-times "></i></span>
                                </button>
                            </div>
                        </div>
                        <div class="scrollApplyingTO  mb-2 mt-2 ">
                            @if($ccRecipients->isNotEmpty())
                            @foreach($ccRecipients as $employee)
                            <div class="borderContainer px-2 mb-2 rounded">
                                <div class="downArrow d-flex align-items-center text-capitalize" wire:click="toggleSelection('{{ $employee->emp_id }}')">
                                    <label class="custom-checkbox">
                                        <input type="checkbox"
                                            wire:model="selectedPeople.{{ $employee->emp_id }}"
                                            @if(isset($selectedPeople[$employee->emp_id])) checked @endif
                                        wire:click.prevent="toggleSelection('{{ $employee->emp_id }}')" />
                                        <span class="checkmark"></span>
                                    </label>

                                    <div class="d-flex align-items-center gap-2" wire:key="{{ $employee->emp_id }}">
                                        <div>
                                            @if(!empty($employee->image) && $employee->image !== 'null')
                                            <div class="employee-profile-image-container">
                                                <img class="navProfileImg rounded-circle" src="data:image/jpeg;base64,{{ $employee->image }}">
                                            </div>
                                            @else
                                            @if($employee->gender === "Male")
                                            <div class="employee-profile-image-container">
                                                <img src="{{ asset('images/male-default.png') }}" class="employee-profile-image-placeholder rounded-circle" height="33" width="33">
                                            </div>
                                            @elseif($employee->gender === "Female")
                                            <div class="employee-profile-image-container">
                                                <img src="{{ asset('images/female-default.jpg') }}" class="employee-profile-image-placeholder rounded-circle" height="33" width="33">
                                            </div>
                                            @else
                                            <div class="employee-profile-image-container">
                                                <img src="{{ asset('images/user.jpg') }}" class="employee-profile-image-placeholder rounded-circle" height="35px" width="35px">
                                            </div>
                                            @endif
                                            @endif
                                        </div>
                                        <div class="mb-2 ms-2 mt-2">
                                            <p class="mb-0 empCcName">{{ ucwords(strtolower($employee->full_name)) }}</p>
                                            <p class="mb-0 empIdStyle">#{{ $employee->emp_id }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            @else
                            <div class="mb-0 normalTextValue">
                                No found
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
                    <button type="button" class="cancel-btn" wire:click="cancel">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>