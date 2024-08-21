<div>
    @if($showerrorMessage)
    <div id="errorMessage" class="alert alert-danger" wire:poll.2s="hideAlert">
        {{ $errorMessage }}
        <button type="button" wire:click="hideAlert" class="close" style="background:none;border:none;" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">x</span>
        </button>
    </div>
    @endif

    <div class="applyContainer bg-white position-relative">
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
            <p class="info-paragraph mb-0" wire:click="toggleInfo">Info</p>
            @endif
        </div>
        <form wire:submit.prevent="leaveApply" enctype="multipart/form-data">
            <div class="row d-flex align-items-center">
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="leave_type">Leave Type <span class="requiredMark">*</span> </label> <br>
                        <div class="custom-select-wrapper" style="width: 50%;">
                            <select id="leave_type" class="form-control outline-none rounded placeholder-small" wire:click="selectLeave" wire:model.lazy="leave_type" wire:keydown.debounce.500ms="validateField('leave_type')" name="leave_type">
                                <option value="default">Select Type</option>
                                <option value="Casual Leave">Casual Leave</option>
                                @if($showCasualLeaveProbation)
                                <option value="Casual Leave Probation">Casual Leave Probation</option>
                                @endif
                                <option value="Loss of Pay">Loss of Pay</option>
                                <option value="Marriage Leave">Marriage Leave</option>
                                @if($employeeGender && $employeeGender->gender === 'Female')
                                <option value="Maternity Leave">Maternity Leave</option>
                                @elseif($employeeGender && $employeeGender->gender === 'Male')
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
                            <span class="normalTextValue">Balance :</span>
                            @if(!empty($leaveBalances))
                            <div class="d-flex align-items-center justify-content-center" style="cursor:pointer;">
                                @if($leave_type == 'Sick Leave')
                                <!-- Sick Leave -->
                                <span class="sickLeaveBalance" title="Sick Leave">{{ $leaveBalances['sickLeaveBalance'] }}</span>
                                @elseif($leave_type == 'Casual Leave')
                                <!-- Casual Leave -->
                                <span class="sickLeaveBalance" title="Casual Leave Probation">{{ $leaveBalances['casualLeaveBalance'] }}</span>
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
                            @else
                            <span class="normalText"></span>
                            @endif

                        </div>
                        <div class="form-group mb-0">
                            <span class="normalTextValue">Number of Days :</span>
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
                            <div class="error-message">
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
                            <div class="error-message">
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
                            <div class="error-message">
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
                            <div class="error-message">
                                <div class="alert-danger Insufficient">Insufficient leave balance</div>
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
                            <div class="error-message">
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
                            <div class="error-message">
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
                        <label for="from_date">From Date <span class="requiredMark">*</span> </label>
                        <input id="from_date" type="date" wire:model.lazy="from_date" wire:keydown.debounce.500ms="validateField('from_date')" class="form-control placeholder-small" name="from_date" wire:change="handleFieldUpdate('from_date')">
                        @error('from_date') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    @if($showSessionDropdown)
                    <div class="form-group">
                        <label for="fromSession">Session</label> <br>
                        <div class="custom-select-wrapper">
                            <select id="fromSession" class="form-control outline-none rounded placeholder-small" wire:model="from_session" wire:keydown.debounce.500ms="validateField('from_session')" name="fromSession" wire:change="handleFieldUpdate('from_session')">
                                <option value="">Select a session</option> <!-- Placeholder option -->
                                <option value="Session 1">Session 1</option>
                                <option value="Session 2">Session 2</option>
                            </select>
                            @error('from_session') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class=" row d-flex mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="toDate">To Date <span class="requiredMark">*</span> </label>
                        <input id="toDate" type="date" wire:model.lazy="to_date" class="form-control placeholder-small" wire:keydown.debounce.500ms="validateField('to_date')" name="toDate" wire:change="handleFieldUpdate('to_date')">
                        @error('to_date') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                @if($showSessionDropdown)
                    <div class="form-group ">
                        <label for="to_session">Session</label> <br>
                        <div class="custom-select-wrapper">
                            <select id="to_session" class="form-control outline-none rounded placeholder-small" wire:model="to_session" wire:keydown.debounce.500ms="validateField('to_session')" name="toSession" wire:change="handleFieldUpdate('to_session')">
                                <option value="">Select a session</option> <!-- Placeholder option -->
                                <option value="Session 2">Session 2</option>
                                <option value="Session 1">Session 1</option>
                            </select>
                            @error('to_session') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div>
                @if($showApplyingTo)
                <div class="form-group mt-3">
                    <div class="d-flex " wire:click="applyingTo">
                        <span class="normalTextValue" style="cursor: pointer;">
                            <img src="https://t4.ftcdn.net/jpg/05/35/51/31/360_F_535513106_hwSrSN1TLzoqdfjWpv1zWQR9Y5lCen6q.jpg" alt="" width="35px" height="32px" style="border-radius:50%;color:#778899;">
                            Applying To
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
                                <button wire:click="applyingTo" type="button" class="close rounded px-1 py-0" aria-label="Close" style="background-color: #ccc;border:#ccc;height:33px;width:33px;">
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
                <label for="contactDetails">Contact Details <span class="requiredMark">*</span> </label>
                <input id="contactDetails" type="text" wire:model.lazy="contact_details" class="form-control placeholder-small" wire:keydown.debounce.500ms="validateField('contact_details')" name="contactDetails" style="width:50%;">
                @error('contact_details') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group mt-3">
                <label for="reason">Reason <span class="requiredMark">*</span> </label>
                <textarea id="reason" class="form-control placeholder-small" wire:model.lazy="reason" wire:keydown.debounce.500ms="validateField('reason')" name="reason" placeholder="Enter a reason" rows="4"></textarea>
                @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group mt-3">
                <label for="file">Attachments</label> <br>
                <input id="file" type="file" wire:model="file_paths" wire:loading.attr="disabled" multiple style="font-size: 12px;" /> <br>
                @error('file_paths.*') <span class="text-danger">{{ $message }}</span> @enderror
                <span class="normalTextValue mt-2" style="font-weight: normal;">File type : jpg,png</span>
            </div>

            <div class="buttons-leave">
                <button type="submit" class=" submit-btn" @if(isset($insufficientBalance)) disabled @endif>Submit</button>
                <button type="button" class=" cancel-btn" wire:click="resetFields" style="border:1px solid rgb(2, 17, 79);">Cancel</button>
            </div>
        </form>
    </div>
</div>