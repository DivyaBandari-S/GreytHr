<div>
    @if($errorMessage)
    <div id="errorMessage" class="alert alert-danger">
        {{ $errorMessage }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <!-- Assuming you are using Blade templates in Laravel -->
    @if (session('popupMessage') || $showPopupMessage)
    <div class="error-message">
        {{ session('popupMessage') }}
    </div>
    @endif

    <div class="applyContainer bg-white">
        @if($showinfoMessage)
        <div class="hide-leave-info p-2 px-2 mb-2 mt-2 rounded d-flex gap-2 align-items-center">
            <p class="mb-0" style="font-size:10px;">Leave is earned by an employee and granted by the employer to take time off work. The employee is free to
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
            <div class="row d-flex align-items-center">
                <div class="col-md-7">
                    <div class="form-group ">
                        <label for="leaveType">Leave Type <span class="requiredMark">*</span> </label> <br>
                        <div class="custom-select-wrapper" style="width: 50%;">
                            <select id="leaveType" class="form-control outline-none rounded placeholder-small" wire:click="selectLeave" wire:model.lazy="leave_type" wire:keydown.debounce.500ms="validateField('leave_type')" name="leaveType">
                                <option value="default">Select Type</option>
                                <option value="Casual Leave">Casual Leave</option>
                                @if (($differenceInMonths < 6)) <option value="Casual Leave Probation">Casual Leave Probation</option>
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
                        </div>
                        <br>
                        @error('leave_type') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="pay-bal">
                            <label>Balance :</label>
                            @if(!empty($leaveBalances))
                            <div class="d-flex align-items-center justify-content-center" style="cursor:pointer;">
                                @if($leave_type == 'Sick Leave')
                                <!-- Sick Leave -->
                                <span class="sickLeaveBalance" title="Sick Leave">{{ $leaveBalances['sickLeaveBalance'] }}</span>
                                @elseif($leave_type == 'Casual Leave')
                                <!-- Casual Leave -->
                                <span class="sickLeaveBalance" title="Casual Leave">{{ $leaveBalances['casualLeaveBalance'] }}</span>
                                @elseif($leave_type == 'Casual Leave Probation')
                                <!-- Casual Leave Probation -->
                                <span class="sickLeaveBalance">{{ $leaveBalances['casualProbationLeaveBalance'] }}</span>
                                @elseif($leave_type == 'Loss of Pay')
                                <!-- Loss of Pay -->
                                <span class="sickLeaveBalance">{{ $leaveBalances['lossOfPayBalance'] }}</span>
                                @elseif($leave_type == 'Maternity Leave')
                                <!-- Loss of Pay -->
                                <span class="sickLeaveBalance">{{ $leaveBalances['maternityLeaveBalance'] }}</span>
                                @elseif($leave_type == 'Paternity Leave')
                                <!-- Loss of Pay -->
                                <span class="sickLeaveBalance">{{ $leaveBalances['paternityLeaveBalance'] }}</span>
                                @elseif($leave_type == 'Marriage Leave')
                                <!-- Loss of Pay -->
                                <span class="sickLeaveBalance">{{ $leaveBalances['marriageLeaveBalance'] }}</span>
                                @endif
                            </div>
                            @endif

                        </div>
                        <div class="form-group mb-0">
                            <label for="numberOfDays">Number of Days :</label>
                            @if($showNumberOfDays)
                            <span id="numberOfDays" class="sickLeaveBalance">
                                <!-- Display the calculated number of days -->
                                {{ $this->calculateNumberOfDays($from_date, $from_session, $to_date, $to_session) }}
                            </span>
                            <!-- Add a condition to check if the number of days exceeds the leave balance -->
                            @if(!empty($leaveBalances))
                            <!-- Directly access the leave balance for the selected leave type -->
                            @php
                            $calculatedNumberOfDays = $this->calculateNumberOfDays($from_date, $from_session, $to_date, $to_session);
                            @endphp
                            @if($leave_type == 'Casual Leave Probation')
                            <!-- Casual Leave Probation -->
                            @if($calculatedNumberOfDays > $leaveBalances['casualProbationLeaveBalance'])
                            <!-- Display an error message if the number of days exceeds the leave balance -->
                            <div class="error-message" style="position: absolute;  left: 10;">
                                <span class="Insufficient">Insufficient leave balance</span>
                            </div>
                            @php
                            $insufficientBalance = true; @endphp
                            @else
                            <span></span>
                            @endif

                            @elseif($leave_type == 'Casual Leave')
                            <!-- Casual Leave Probation -->
                            @if($calculatedNumberOfDays > $leaveBalances['casualLeaveBalance'])
                            <!-- Display an error message if the number of days exceeds the leave balance -->
                            <div class="error-message" style="position: absolute;  left: 10;">
                                <span class="Insufficient">Insufficient leave balance</span>
                            </div>
                            @php
                            $insufficientBalance = true; @endphp
                            @else
                            <span></span>
                            @endif
                            @elseif($leave_type == 'Sick Leave')
                            <!-- Casual Leave Probation -->
                            @if($calculatedNumberOfDays > $leaveBalances['sickLeaveBalance'])
                            <!-- Display an error message if the number of days exceeds the leave balance -->
                            <div class="error-message" style="position: absolute;  left: 10;">
                                <span class="Insufficient">Insufficient leave balance</span>
                            </div>
                            @php
                            $insufficientBalance = true; @endphp
                            @else
                            <span></span>
                            @endif
                            @elseif($leave_type == 'Maternity Leave')
                            <!-- Casual Leave Probation -->
                            @if($calculatedNumberOfDays > $leaveBalances['maternityLeaveBalance'])
                            <!-- Display an error message if the number of days exceeds the leave balance -->
                            <div class="error-message" style="position: absolute;  left: 10;">
                                <span class="Insufficient">Insufficient leave balance</span>
                            </div>
                            @php
                            $insufficientBalance = true; @endphp
                            @else
                            <span></span>
                            @endif
                            @elseif($leave_type == 'Paternity Leave')
                            <!-- Casual Leave Probation -->
                            @if($calculatedNumberOfDays > $leaveBalances['paternityLeaveBalance'])
                            <!-- Display an error message if the number of days exceeds the leave balance -->
                            <div class="error-message" style="position: absolute;  left: 10;">
                                <span class="Insufficient">Insufficient leave balance</span>
                            </div>
                            @php
                            $insufficientBalance = true; @endphp
                            @else
                            <span></span>
                            @endif
                            @elseif($leave_type == 'Marriage Leave')
                            <!-- Casual Leave Probation -->
                            @if($calculatedNumberOfDays > $leaveBalances['marriageLeaveBalance'])
                            <!-- Display an error message if the number of days exceeds the leave balance -->
                            <div class="error-message" style="position: absolute;  left: 10;">
                                <span class="Insufficient">Insufficient leave balance</span>
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
            </div>
            <div class="row d-flex mt-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fromDate">From Date <span class="requiredMark">*</span> </label>
                        <input type="date" wire:model.lazy="from_date" wire:keydown.debounce.500ms="validateField('from_date')" class="form-control placeholder-small" id="fromDate" name="fromDate" wire:change="handleFieldUpdate('from_date')">
                        @error('from_date') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group ">
                        <label for="session">Session</label> <br>
                        <div class="custom-select-wrapper">
                            <select class="form-control outline-none rounded placeholder-small" wire:model.lazy="from_session" wire:keydown.debounce.500ms="validateField('from_session')" name="session" wire:change="handleFieldUpdate('from_session')">
                                <option value="Session 1">Session 1</option>
                                <option value="Session 2">Session 2</option>
                            </select>
                            @error('from_session') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class=" row d-flex mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="toDate">To Date <span class="requiredMark">*</span> </label>
                        <input type="date" wire:model.lazy="to_date" class="form-control placeholder-small" wire:keydown.debounce.500ms="validateField('to_date')" name="toDate" wire:change="handleFieldUpdate('to_date')">
                        @error('to_date') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group ">
                        <label for="session">Session</label> <br>
                        <div class="custom-select-wrapper">
                            <select class="form-control outline-none rounded placeholder-small" wire:model.lazy="to_session" wire:keydown.debounce.500ms="validateField('to_session')" name="session" wire:change="handleFieldUpdate('to_session')">
                                <option value="Session 1">Session 1</option>
                                <option value="Session 2">Session 2</option>
                            </select>
                            @error('to_session') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div>
                @if($showApplyingTo)
                <div class="form-group mt-3">
                    <div class="d-flex " wire:click="applyingTo">
                        <label for="applyingToText" id="applyingToText" name="applyingTo" style="cursor: pointer;">
                            <img src="https://t4.ftcdn.net/jpg/05/35/51/31/360_F_535513106_hwSrSN1TLzoqdfjWpv1zWQR9Y5lCen6q.jpg" alt="" width="35px" height="32px" style="border-radius:50%;color:#778899;">
                            Applying To
                        </label>
                    </div>
                </div>
                @endif
                <!-- Your Blade file -->
                @if($show_reporting)
                <div class="form-group mt-3">
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
                        <p class="mb-0" style="font-size:10px;">N/A</p>
                        @else
                        <p id="reportToText" class="ellipsis mb-0">{{ ucwords(strtolower($loginEmpManager)) }}</p>
                        @endif

                        @if(!$loginEmpManagerId)
                        <p class="mb-0 normalTextValue">#(N/A)</p>
                        @else
                        <p class="mb-0 normalTextValue" style="font-size: 10px !important;" id="managerIdText"><span class="remaining">#{{$loginEmpManagerId}}</span></p>
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
                    <div class="row mb-2 py-0 ">
                        <div class="row m-0 p-0 d-flex align-items-center justify-content-between">
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input wire:model="filter" id="searchInput" style="font-size: 12px; border-radius: 5px 0 0 5px; cursor: pointer; width:50%;" type="text" class="form-control placeholder-small" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1" wire:keydown.enter.prevent="handleEnterKey">
                                    <div class="input-group-append searchBtnBg d-flex align-items-center">
                                        <button type="button" wire:click="searchEmployees" class="search-btn">
                                            <i style="color:#fff;margin-left:10px;" class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 m-0 p-0">
                                <button wire:click="applyingTo" type="button" class="close rounded px-1 py-0" aria-label="Close" style="background-color: rgb(2,17,79);height:33px;width:33px;">
                                    <span aria-hidden="true" style="color: white; font-size: 18px;"><i class="fas fa-times "></i>
                                    </span>
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
                                <img height="35px" width="35px" src="{{ $employee['image'] }}" style="border-radius:50%;">
                            </div>
                            @else
                            <div class="employee-profile-image-container">
                                <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" class="employee-profile-image-placeholder" style="border-radius:50%;" height="35px" width="35px" alt="Default Image">
                            </div>
                            @endif
                            <div class="center d-flex flex-column mt-2 mb-2">
                                <span class="ellipsis mb-0" value="{{ $employee['full_name'] }}">{{ $employee['full_name'] }}</span>
                                <span class="mb-0 normalTextValue" style="font-size:10px;" value="{{ $employee['full_name'] }}"> #{{ $employee['emp_id'] }} </span>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <p class="mb-0 normalTextValue m-auto ">No managers found.</p>
                        @endif
                    </div>
                </div>
                @endif
                @error('applying_to') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group mt-3">
                <label for="ccToText" id="applyingToText" name="applyingTo">
                    CC To
                </label>
                <div class="control-wrapper d-flex align-items-center" style="gap: 10px;cursor:pointer;">
                    <a class="text-3 text-secondary control" aria-haspopup="true" wire:click="openCcRecipientsContainer" style="text-decoration: none;">
                        <div class="icon-container">
                            <i class="fa fa-plus" style="color: #778899;"></i>
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
                                        <i style="margin-right: 10px;" class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 m-0 p-0">
                            <button wire:click="closeCcRecipientsContainer" type="button" class="close rounded px-1 py-0" aria-label="Close" style="background-color: rgb(2,17,79);height:33px;width:33px;">
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
                <label for="contactDetails">Contact Details <span class="requiredMark">*</span> </label>
                <input type="text" wire:model.lazy="contact_details" class="form-control placeholder-small" wire:keydown.debounce.500ms="validateField('contact_details')" name="contactDetails" style="width:50%;">
                @error('contact_details') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group mt-3">
                <label for="reason">Reason <span class="requiredMark">*</span> </label>
                <textarea class="form-control placeholder-small" wire:model.lazy="reason" wire:keydown.debounce.500ms="validateField('reason')" name="reason" placeholder="Enter a reason" rows="4"></textarea>
                @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group mt-3">
                <input type="file" wire:model="file_paths" wire:loading.attr="disabled" style="font-size: 12px;" multiple accept=".jpg,.png,.pdf,.xlsx,.xls" />
                @error('file_paths')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="buttons-leave">
                <button type="submit" class=" submit-btn" @if(isset($insufficientBalance)) disabled @endif>Submit</button>
                <button type="button" class=" cancel-btn" wire:click="cancelLeaveApplication" style="border:1px solid rgb(2, 17, 79);">Cancel</button>
            </div>
        </form>
    </div>
</div>