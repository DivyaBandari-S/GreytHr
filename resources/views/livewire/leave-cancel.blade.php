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

    <style>
        .LeaveCancelTable {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .LeaveCancelTable th,
        .LeaveCancelTable td {
            border-bottom: 1px solid #ccc;
            padding: 8px;
            font-size: 12px;
            text-align: center;
        }

        /* Define specific widths for columns */
        .LeaveCancelTable th:first-child,
        .LeaveCancelTable td:first-child {
            width: 10%;
            /* First column takes 10% */
        }

        .LeaveCancelTable th:last-child,
        .LeaveCancelTable td:last-child {
            width: 30%;
        }

        /* Divide remaining width equally among other columns */
        .LeaveCancelTable th:not(:first-child):not(:last-child),
        .LeaveCancelTable td:not(:first-child):not(:last-child) {
            width: calc((100% - 40%) / 4);
        }

        .LeaveCancelTable th {
            background-color: rgb(2, 17, 79);
            color: #fff !important;
            font-weight: 500;
            font-size: 0.75rem;
        }

        @media screen and (max-width: 768px) {
            .LeaveCancelTable {
                table-layout: auto;
            }
        }
    </style>
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
        <form wire:submit.prevent="markAsLeaveCancel" enctype="multipart/form-data">
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

                @if($showApplyingTo)
                <div class="form-group" style="margin-top: 10px;">
                    <div style="display:flex; flex-direction:row;" wire:click="applyingTo">
                        <label for="applyingToText" id="applyingToText" name="applyingTo" style="color: #778899; font-size: 12px; font-weight: 500; cursor: pointer;">
                            <img src="https://t4.ftcdn.net/jpg/05/35/51/31/360_F_535513106_hwSrSN1TLzoqdfjWpv1zWQR9Y5lCen6q.jpg" alt="" width="35px" height="32px" style="border-radius:50%;color:#778899;">
                            Applying To
                        </label>
                    </div>
                </div>
                @endif
                <!-- Your Blade file -->
                @if($show_reporting)
                <div class="form-group">
                    <label for="applyingTo"> Applying To</label>
                </div>
                <div class="reporting mb-2" wire:ignore.self>
                    @if(!$loginEmpManagerProfile)
                    <div class="employee-profile-image-container">
                        <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" class="employee-profile-image-placeholder" style="border-radius:50%;" height="40" width="40" alt="Default Image">
                    </div>
                    @elseif($managerDetails)
                    <div class="employee-profile-image-container">
                        <img height="40" width="40" src="{{ asset('storage/' . $managerDetails->image) }}" style="border-radius:50%;">
                    </div>
                    @else
                    <div class="employee-profile-image-container">
                        <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" class="employee-profile-image-placeholder" style="border-radius:50%;" height="40" width="40" alt="Default Image">
                    </div>
                    @endif
                    <div class="center p-0 m-0">
                        @if(!$loginEmpManager)
                        <p class="mb-0" style="font-size:10px;margin-bottom:0;">N/A</p>
                        @else
                        <p id="reportToText" class="ellipsis mb-0">{{ ucwords(strtolower($loginEmpManager)) }}</p>
                        @endif

                        @if(!$loginEmpManagerId)
                        <p class="mb-0" style="font-size:10px;margin-bottom:0;">#(N/A)</p>
                        @else
                        <p class="mb-0" style="color:#778899; font-size:10px;margin-bottom:0;" id="managerIdText"><span class="remaining">#{{$loginEmpManagerId}}</span></p>
                        @endif
                    </div>
                    <div class="downArrow" wire:click="applyingTo">
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
                                <button wire:click="applyingTo" type="button" class="close rounded px-1 py-0" aria-label="Close" style="background-color: rgb(2,17,79);height:33px;width:33px;">
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
                        <p>No managers found.</p>
                        @endif
                    </div>
                </div>
                @endif
                @error('applying_to') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="ccToText" wire:model="from_date" id="applyingToText" name="applyingTo" style="color: #778899; font-size: 12px; font-weight: 500;">
                    CC to
                </label>
                <div class="control-wrapper" style="display: flex; flex-direction: row; gap: 10px;">
                    <a href="javascript:void(0);" class="text-3 text-secondary control" aria-haspopup="true" style="text-decoration: none;">
                        <div class="icon-container" style="display: flex; justify-content: center; align-items: center;">
                            <i class="fa-solid fa-plus" style="color: #778899;"></i>
                        </div>
                    </a>
                    <span class="text-2 text-secondary placeholder" id="ccPlaceholder" style="margin-top: 5px; background: transparent; color: #ccc; pointer-events: none;">Add</span>
                    <div id="addedEmails" style="display: flex; gap: 10px; "></div>

                </div>
                <div class="ccContainer" style="display:none;">
                    <!-- Content for the search container -->
                    <div class="row" style="padding: 0 15px; margin-bottom: 10px;">
                        <div class="col" style="margin: 0px; padding: 0px">
                            <div class="input-group">
                                <input wire:model="searchTerm" style="font-size: 10px; border-radius: 5px 0 0 5px; cursor: pointer; width:50%;" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <button style="height: 29px; border-radius: 0 5px 5px 0; background-color: #007BFF; color: #fff; border: none; align-items: center; display: flex;" class="btn" type="button" wire:click="searchOnClick">
                                        <i style="margin-right: 5px;" class="fa fa-search"></i> <!-- Adjust margin-right as needed -->
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach($ccRecipients as $employee)
                    <div style="display:flex; gap:10px;" onclick="addEmail('{{ $employee['full_name'] }}')">
                        <input type="checkbox" wire:model="selectedPeople" value="{{ $employee['emp_id'] }}">
                        <img src="{{ $employee['image'] ? $employee['image'] : 'https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars.png' }}" alt="User Image" style="width: 40px; height: 40px; border-radius: 50%;">
                        <div class="center">
                            <p style="font-size: 0.875rem; font-weight: 500;">{{ $employee['full_name'] }}</p>
                            <p style="margin-top: -15px; color: #778899; font-size: 0.69rem;">#{{ $employee['emp_id'] }}</p>
                        </div>

                    </div>
                    @endforeach
                </div>
                @error('cc_to') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="reason" style="color: #778899; font-size: 12px; font-weight: 500;">Reason for Leave</label>
                <textarea class="form-control" wire:model="reason" id="reason" name="reason" placeholder="Enter Reason" rows="4"></textarea>
                @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="cancelButtons d-flex align-items-center gap-2 justify-content-center">
                <button type="submit" class="submit-btn">Submit</button>
                <button type="button" class="cancel-btn" style="border:1px solid rgb(2,17,79);">Cancel</button>
            </div>
        </form>
    </div>
</div>