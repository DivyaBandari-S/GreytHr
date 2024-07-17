<div class="mx-2">
<x-loading-indicator />
    @if($errorMessage)
    <div id="errorMessage" class="alert alert-danger">
        {{ $errorMessage }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif


    <div class="applyContainer bg-white">
        @if($showinfoMessage)
        <div class="hide-leave-info p-2 px-2 mb-2 mt-2 rounded d-flex justify-content-between align-items-center">
            <p class="mb-0" style="font-size:10px;">Leave is earned by an employee and granted by the employer to take time off work. The employee is free to<br>
                avail this leave in accordance with the company policy.</p>
            <p class="mb-0 hideInfo" wire:click="toggleInfo">Hide</p>
        </div>
        @endif

        <div class="d-flex justify-content-between">
            <p class="applyingFor">Applying for Leave</p>
            @if($showinfoButton)
            <p class="info-paragraph" wire:click="toggleInfo">Info</p>
            @endif
        </div>
        <form wire:submit.prevent="leaveApply" enctype="multipart/form-data">
            <div class="form-row d-flex align-itmes-center mt-3">
                <div class="form-group col-md-7">
                    <label for="leaveType" style="color: #778899; font-size: 12px; font-weight: 500;">Leave Type <span class="requiredMark">*</span> </label> <br>
                    <select id="leaveType" class="dropdown p-2 outline-none rounded placeholder-small" wire:click="selectLeave" wire:model.lazy="leave_type" wire:keydown.debounce.500ms="validateField('leave_type')" name="leaveType" style="width: 50%; font-weight: 400; color: #778899; font-size: 12px;border:1px solid #ccc;">
                        <option value="default">Select Type</option>
                        @php
                        $managerInfo = DB::table('employee_details')
                        ->join('companies', 'employee_details.company_id', '=', 'companies.company_id')
                        ->where('employee_details.manager_id', $employeeId)
                        ->select('companies.company_logo', 'companies.company_name')
                        ->first();
                        @endphp
                        <option value="Casual Leave">Casual Leave</option>
                        @if (($differenceInMonths < 6) && ($employeeId !==$managerInfo->manager_id))
                            <option value="Casual Leave Probation">Casual Leave Probation</option>
                            @endif
                            <option value="Loss of Pay">Loss of Pay</option>
                            <option value="Marriage Leave">Marriage Leave</option>
                            @if($employeeGender && $employeeGender->gender === 'Female')
                            <option value="Maternity Leave">Maternity Leave</option>
                            @else
                            <option value="Paternity Leave">Paternity Leave</option>
                            @endif
                            <option value="Sick Leave">Sick Leave</option>
                    </select>
                    <br>
                    @error('leave_type') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-4 m-0 p-0">
                    <div class="pay-bal">
                        <span style=" font-size: 12px; font-weight: 500;color:#778899;">Balance :</span>
                        @if(!empty($this->leaveBalances))
                        <div style="flex-direction:row; display: flex; align-items: center;justify-content:center;cursor:pointer;">
                            @if($this->leave_type == 'Sick Leave')
                            <!-- Sick Leave -->
                            <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #e6e6fa; display: flex; align-items: center; justify-content: center; ">
                                <span style="font-size: 10px; color: #50327c;font-weight:500;">SL</span>
                            </div>
                            <span style="font-size: 11px; font-weight: 500; color: #50327c; margin-left: 5px;" title="Sick Leave">{{ $this->leaveBalances['sickLeaveBalance'] }}</span>
                            @elseif($this->leave_type == 'Casual Leave')
                            <!-- Casual Leave -->
                            <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #e7fae7; display: flex; align-items: center; justify-content: center; ">
                                <span style="font-size: 10px; color: #1d421e;font-weight:500;">CL</span>
                            </div>
                            <span style="font-size: 11px; font-weight: 500; color: #1d421e; margin-left: 5px;" title="Casual Leave">{{ $this->leaveBalances['casualLeaveBalance'] }}</span>
                            @elseif($this->leave_type == 'Casual Leave Probation')
                            <!-- Casual Leave Probation -->
                            <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #fff6e5; display: flex; align-items: center; justify-content: center; ">
                                <span style="font-size: 9px; color: #e59400;font-weight:500;" title="Casual Leave Probation">CLP</span>
                            </div>
                            <span style="font-size: 11px; font-weight: 500; color: #1d421e; margin-left: 5px;">{{ $this->leaveBalances['casualProbationLeaveBalance'] }}</span>
                            @elseif($this->leave_type == 'Loss of Pay')
                            <!-- Loss of Pay -->
                            <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; ">
                                <span style="font-size: 10px; color: #890000;font-weight:500;" title="Loss of Pay">LP</span>
                            </div>
                            <span style="font-size: 11px; font-weight: 500; color: #890000; margin-left: 5px;">{{ $this->leaveBalances['lossOfPayBalance'] }}</span>
                            @elseif($this->leave_type == 'Maternity Leave')
                            <!-- Loss of Pay -->
                            <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; ">
                                <span style="font-size: 10px; color: #890000;font-weight:500;" title="Maternity Leave">ML</span>
                            </div>
                            <span style="font-size: 11px; font-weight: 500; color: #890000; margin-left: 5px;">{{ $this->leaveBalances['maternityLeaveBalance'] }}</span>
                            @elseif($this->leave_type == 'Paternity Leave')
                            <!-- Loss of Pay -->
                            <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; ">
                                <span style="font-size: 10px; color: #890000;font-weight:500;" title="Paternity Leave">PL</span>
                            </div>
                            <span style="font-size: 11px; font-weight: 500; color: #890000; margin-left: 5px;">{{ $this->leaveBalances['paternityLeaveBalance'] }}</span>
                            @elseif($this->leave_type == 'Marriage Leave')
                            <!-- Loss of Pay -->
                            <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; ">
                                <span style="font-size: 10px; color: #890000;font-weight:500;" title="Marriage Leave">MRL</span>
                            </div>
                            <span style="font-size: 11px; font-weight: 500; color: #890000; margin-left: 5px;">{{ $this->leaveBalances['marriageLeaveBalance'] }}</span>
                            @endif
                        </div>
                        @endif

                    </div>
                    <div class="form-group">
                        <label for="numberOfDays" style="color: #778899; font-size: 12px; font-weight: 500;">Number of Days :</label>
                        @if($showNumberOfDays)
                        <span id="numberOfDays" style="font-size: 12px;color:#778899;">
                            <!-- Display the calculated number of days -->
                            {{ $this->calculateNumberOfDays($from_date, $from_session, $to_date, $to_session) }}
                        </span>
                        <!-- Add a condition to check if the number of days exceeds the leave balance -->
                        @if(!empty($this->leaveBalances))
                        <!-- Directly access the leave balance for the selected leave type -->
                        @php
                        $calculatedNumberOfDays = $this->calculateNumberOfDays($from_date, $from_session, $to_date, $to_session);
                        @endphp
                        @if($this->leave_type == 'Casual Leave Probation')
                        <!-- Casual Leave Probation -->
                        @if($calculatedNumberOfDays > $this->leaveBalances['casualProbationLeaveBalance'])
                        <!-- Display an error message if the number of days exceeds the leave balance -->
                        <div class="error-message" style="position: absolute;  left: 0;">
                            <span style="color: red; font-weight: normal;font-size:12px;">Insufficient leave balance</span>
                        </div>
                        @php
                        $insufficientBalance = true; @endphp
                        @else
                        <span></span>
                        @endif

                        @elseif($this->leave_type == 'Casual Leave')
                        <!-- Casual Leave Probation -->
                        @if($calculatedNumberOfDays > $this->leaveBalances['casualLeaveBalance'])
                        <!-- Display an error message if the number of days exceeds the leave balance -->
                        <div class="error-message" style="position: absolute;  left: 0;">
                            <span style="color: red; font-weight: normal;font-size:12px;">Insufficient leave balance</span>
                        </div>
                        @php
                        $insufficientBalance = true; @endphp
                        @else
                        <span></span>
                        @endif
                        @elseif($this->leave_type == 'Sick Leave')
                        <!-- Casual Leave Probation -->
                        @if($calculatedNumberOfDays > $this->leaveBalances['sickLeaveBalance'])
                        <!-- Display an error message if the number of days exceeds the leave balance -->
                        <div class="error-message" style="position: absolute;  left: 0;">
                            <span style="color: red; font-weight: normal;font-size:12px;">Insufficient leave balance</span>
                        </div>
                        @php
                        $insufficientBalance = true; @endphp
                        @else
                        <span></span>
                        @endif
                        @elseif($this->leave_type == 'Maternity Leave')
                        <!-- Casual Leave Probation -->
                        @if($calculatedNumberOfDays > $this->leaveBalances['maternityLeaveBalance'])
                        <!-- Display an error message if the number of days exceeds the leave balance -->
                        <div class="error-message" style="position: absolute;  left: 0;">
                            <span style="color: red; font-weight: normal;font-size:12px;">Insufficient leave balance</span>
                        </div>
                        @php
                        $insufficientBalance = true; @endphp
                        @else
                        <span></span>
                        @endif
                        @elseif($this->leave_type == 'Paternity Leave')
                        <!-- Casual Leave Probation -->
                        @if($calculatedNumberOfDays > $this->leaveBalances['paternityLeaveBalance'])
                        <!-- Display an error message if the number of days exceeds the leave balance -->
                        <div class="error-message" style="position: absolute;  left: 0;">
                            <span style="color: red; font-weight: normal;font-size:12px;">Insufficient leave balance</span>
                        </div>
                        @php
                        $insufficientBalance = true; @endphp
                        @else
                        <span></span>
                        @endif
                        @elseif($this->leave_type == 'Marriage Leave')
                        <!-- Casual Leave Probation -->
                        @if($calculatedNumberOfDays > $this->leaveBalances['marriageLeaveBalance'])
                        <!-- Display an error message if the number of days exceeds the leave balance -->
                        <div class="error-message" style="position: absolute;  left: 0;">
                            <span style="color: red; font-weight: normal;font-size:12px;">Insufficient leave balance</span>
                        </div>
                        @php
                        $insufficientBalance = true; @endphp
                        @else
                        <span></span>
                        @endif
                        <!-- end of leavevtyopes -->
                        @endif
                        @endif
                        @else
                        <span class="normalText">0</span>
                        @endif
                    </div>

                </div>
            </div>
            <div class="form-row d-flex mt-3">
                <div class="form-group col-md-6">
                    <label for="fromDate" style="color: #778899; font-size: 12px; font-weight: 500;">From Date <span class="requiredMark">*</span> </label>
                    <input type="date" wire:model.lazy="from_date" wire:keydown.debounce.500ms="validateField('from_date')" class="form-control placeholder-small" id="fromDate" name="fromDate" style="color: #778899;font-size:12px;" wire:change="handleFieldUpdate('from_date')">
                    @error('from_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="session" style="color: #778899; font-size: 12px; font-weight: 500;">Session</label> <br>
                    <select class="dropdown p-2 outline-none rounded placeholder-small w-100" wire:model.lazy="from_session" wire:keydown.debounce.500ms="validateField('from_session')" name="session" style="font-size:12px;border:1px solid #ccc;" wire:change="handleFieldUpdate('from_session')">
                        <option value="Session 1">Session 1</option>
                        <option value="Session 2">Session 2</option>
                    </select>
                    @error('from_session') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row d-flex  mt-3">
                <div class="form-group col-md-6">
                    <label for="toDate" style="color: #778899; font-size: 12px; font-weight: 500;">To Date <span class="requiredMark">*</span> </label>
                    <input type="date" wire:model.lazy="to_date" class="form-control placeholder-small" wire:keydown.debounce.500ms="validateField('to_date')" name="toDate" style="color: #778899;font-size:12px;" wire:change="handleFieldUpdate('to_date')">
                    @error('to_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="session" style="color: #778899; font-size: 12px; font-weight: 500;">Session</label> <br>
                    <select class="dropdown p-2 outline-none rounded placeholder-small w-100" wire:model.lazy="to_session" wire:keydown.debounce.500ms="validateField('to_session')" name="session" style="font-size:12px;border:1px solid #ccc;" wire:change="handleFieldUpdate('to_session')">
                        <option value="Session 1">Session 1</option>
                        <option value="Session 2">Session 2</option>
                    </select>
                    @error('to_session') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
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
                <label for="ccToText" id="applyingToText" name="applyingTo" style="color: #778899; font-size: 12px; font-weight: 500;">
                    CC To
                </label>
                <div class="control-wrapper d-flex align-items-center" style="flex-direction: row; gap: 10px;cursor:pointer;">
                    <a class="text-3 text-secondary control" aria-haspopup="true" wire:click="openCcRecipientsContainer" style="text-decoration: none;">
                        <div class="icon-container" style="display: flex; justify-content: center; align-items: center;">
                            <i class="fa-solid fa-plus" style="color: #778899;"></i>
                        </div>
                    </a>
                    <!-- Blade Template: your-component.blade.php -->
                    <span class="addText" wire:click="openCcRecipientsContainer">Add</span>

                    @if(count($selectedCCEmployees) > 0)
                    <ul class=" d-flex align-items-center mb-0" style="list-style-type: none;gap:10px;">
                        @foreach($selectedCCEmployees as $recipient)
                        <li>
                            <div class="px-2 py-1 " style=" border-radius: 25px; border: 2px solid #adb7c1; display: flex; justify-content: space-between; align-items: center;" title="{{ ucwords(strtolower( $recipient['first_name'])) }} {{ ucwords(strtolower( $recipient['last_name'])) }}">
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
                                        <i style="margin-right: 5px;" class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 m-0 p-0">
                            <button wire:click="closeCcRecipientsContainer" type="button" class="close rounded px-1 py-0" aria-label="Close" style="background-color: rgb(2,17,79);height:33px;width:33px;">
                                <span aria-hidden="true" style="color: white; font-size: 24px;">×</span>
                            </button>
                        </div>
                    </div>
                    <div class="scrollApplyingTO mb-2 mt-2">
                        @foreach($ccRecipients as $employee)
                        <div wire:key="{{ $employee['emp_id'] }}">
                            <div style="margin-top: 10px; display: flex; gap: 10px; text-transform: capitalize; align-items: center; cursor: pointer;" wire:click="toggleSelection('{{ $employee['emp_id'] }}')">
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
                        </divclass>
                    </div>
                    @endif
                    @error('cc_to') <span class="text-danger">{{ $message }}</span> @enderror
                </div>


                <div class="form-group">
                    <label for="contactDetails" style="color: #778899; font-size: 12px; font-weight: 500;">Contact Details <span class="requiredMark">*</span> </label>
                    <input type="text" wire:model.lazy="contact_details" class="form-control placeholder-small" wire:keydown.debounce.500ms="validateField('contact_details')" name="contactDetails" style="color: #778899;width:50%;font-size:13px;">
                    @error('contact_details') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="reason" style="color: #778899; font-size: 12px; font-weight: 500;">Reason <span class="requiredMark">*</span> </label>
                    <textarea class="form-control placeholder-small" wire:model.lazy="reason" wire:keydown.debounce.500ms="validateField('reason')" name="reason" placeholder="Enter a reason" rows="4" style="color: #778899;font-size:13px;"></textarea>
                    @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <input type="file" wire:model="files" wire:loading.attr="disabled" style="font-size: 12px;color:#778899;" multiple />
                    @error('file_paths') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="buttons-leave">
                    <button type="submit" class=" submit-btn" @if(isset($insufficientBalance)) disabled @endif>Submit</button>
                    <button type="button" class=" cancel-btn" wire:click="cancelLeaveApplication" style="border:1px solid rgb(2, 17, 79);">Cancel</button>
                </div>
        </form>
    </div>
</div>