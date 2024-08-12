<div>
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
                            <span class="normalTextValue">Balance :</span>
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
                        <input id="fromDate" type="date" wire:model.lazy="from_date" wire:keydown.debounce.500ms="validateField('from_date')" class="form-control placeholder-small" id="fromDate" name="fromDate" wire:change="handleFieldUpdate('from_date')">
                        @error('from_date') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group ">
                        <label for="fromSession">Session</label> <br>
                        <div class="custom-select-wrapper">
                            <select id="fromSession" class="form-control outline-none rounded placeholder-small" wire:model.lazy="from_session" wire:keydown.debounce.500ms="validateField('from_session')" name="fromSession" wire:change="handleFieldUpdate('from_session')">
                                <option value="Session 1">Session 1</option>
                                <option value="Session 2">Session 2</option>
                            </select>
                            @error('from_session') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
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
                <label for="file">Attachement </label> <br>
                <input id="file" type="file" wire:model="files" wire:loading.attr="disabled" style="font-size: 12px;" multiple />
                @error('file_paths') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="buttons-leave">
                <button type="submit" class=" submit-btn" @if(isset($insufficientBalance)) disabled @endif>Submit</button>
                <button type="button" class=" cancel-btn" wire:click="cancelLeaveApplication" style="border:1px solid rgb(2, 17, 79);">Cancel</button>
            </div>
        </form>
    </div>
</div>