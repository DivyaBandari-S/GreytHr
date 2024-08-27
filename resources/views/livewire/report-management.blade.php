<div class="row p-0 m-0 mt-3 p-2">
    <style>
        .search-bar {
            display: flex;
            padding: 0;
            justify-content: start;
            width: 250px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
            background: #fff;
        }

        .search-bar input[type="search"] {
            flex: 1;
            padding: 5px;
            border: none;
            outline: none;
            font-size: 14px;
            background: transparent;
        }

        /* Styling for the search icon */
        .search-bar::after {
            content: "\f002";
            /* Unicode for the search icon (font-awesome) */
            font-family: FontAwesome;
            /* Use an icon font library like FontAwesome */
            font-size: 16px;
            padding: 5px;
            color: #999;
            /* Icon color */
            cursor: pointer;
        }

        .search-bar input[type="search"]::placeholder {
            color: #999;
            /* Placeholder color */
        }

        .search-bar input[type="search"]::-webkit-search-cancel-button {
            display: none;
            /* Hide cancel button on Chrome */
        }

        .people-input-group-container {
            margin-top: 10px;
            width: 240px;
        }

        .people-search-input {
            font-size: 0.75rem !important;
            border-radius: 5px 0 0 5px;
            cursor: pointer;
            height: 32px;
        }


        .people-search-btn {
            height: 32px;
            width: 40px;
            position: relative;
            border-radius: 0 5px 5px 0;
            background-color: rgb(2, 17, 79);
            color: #fff;
            border: none;
        }

        .people-search-icon {
            position: absolute;
            top: 9px;
            left: 11px;
        }

        .date-container {
            display: flex;
            align-items: center;
            /* Vertically centers items */
            gap: 10px;
            /* Adjust gap as needed */
        }

        .date-container label {
            margin-right: 10px;
            /* Adjust space between label and input */
            font-size: 0.85rem;
            /* Adjust font size as needed */
            color: var(--label-color);
            /* Ensure color matches the rest of your form */
        }

        .date-container input {
            flex: 1;
            /* Allows the input to grow and fill available space */
        }
    </style>
    <div class="col-md-3">
        <div class="d-flex flex-column mb-2" style="line-height:2;">
            <span style="color:#b1b1b1;font-size:12px;" class="mt-2" class="mt-2" class="mt-2">HR Reports</span>
            <a class="px-1" wire:click="showContent('Employee Family Details')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color: var(--label-color);font-weight:500; font-size:12px;white-space: nowrap; {{ $currentSection === 'Employee Family Details' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color: var(--main-heading-color);font-size:12px;' : '' }}">
                Employee Family Details

            </a>
        </div>
        <div class="d-flex flex-column mb-2" style="line-height:2;">
            <span style="color:#b1b1b1;font-size:12px;" class="mt-2" class="mt-2" class="mt-2">Attendance</span>
            <a class="px-1" wire:click="showContent('Attendance Muster Report')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none;white-space: nowrap; margin-top:5px;cursor:pointer;color: var(--label-color);font-weight:500; font-size:12px; {{ $currentSection === 'Attendance Muster Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color: var(--main-heading-color);font-size:12px;' : '' }}">
                Attendance Muster Report

            </a>
            <a class="px-1" wire:click="showContent('Absent Report')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color: var(--label-color);font-weight:500; font-size:12px; {{ $currentSection === 'Absent Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color: var(--main-heading-color);font-size:12px;' : '' }}">
                Absent Report

            </a>
            <a class="px-1" wire:click="showContent('Shift Summary Report')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color: var(--label-color);font-weight:500; font-size:12px;white-space: nowrap; {{ $currentSection === 'Shift Summary Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color: var(--main-heading-color);font-size:12px;' : '' }}">
                Shift Summary Report

            </a>
            <a class="px-1" wire:click="showContent('Attendance Conslidate Report')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color: var(--label-color);font-weight:500; font-size:12px;white-space: nowrap; {{ $currentSection === 'Attendance Conslidate Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color: var(--main-heading-color);font-size:12px;' : '' }}">
                Attendance Conslidate Report

            </a>
            <a class="px-1" wire:click="showContent('Attendance Regularization Report')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color: var(--label-color);font-weight:500; font-size:12px; white-space: nowrap;{{ $currentSection === 'Attendance Regularization Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color: var(--main-heading-color);font-size:12px;' : '' }}">
                Attendance Regularization Report

            </a>
        </div>
        <div class="d-flex flex-column mb-2" style="line-height:2;">
            <span style="color:#b1b1b1;font-size:12px;" class="mt-2" class="mt-2" class="mt-2">Leave</span>
            <a class="px-1" wire:click="showContent('Leave Availed Report')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color: var(--label-color);font-weight:500; font-size:12px; white-space: nowrap; {{ $currentSection === 'Leave Availed Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color: var(--main-heading-color);font-size:12px;' : '' }}">
                Leave Availed Report

            </a>
            <a class="px-1" wire:click="showContent('Negative Leave Balance')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color: var(--label-color);font-weight:500; font-size:12px;white-space: nowrap; {{ $currentSection === 'Negative Leave Balance' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color: var(--main-heading-color);font-size:12px;' : '' }}">
                Negative Leave Balance

            </a>
            <a class="px-1" wire:click="showContent('Day Wise Leave Transation Report')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color: var(--label-color);font-weight:500; font-size:12px;white-space: nowrap; {{ $currentSection === 'Day Wise Leave Transation Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color: var(--main-heading-color);font-size:12px;' : '' }}">
                Day Wise Leave Transation Report

            </a>
            <a class="px-1" wire:click="showContent('Leave Balance As On A Day')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color: var(--label-color);font-weight:500; font-size:12px;white-space: nowrap; {{ $currentSection === 'Leave Balance As On A Day' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color: var(--main-heading-color);font-size:12px;' : '' }}">
                Leave Balance As On A Day

            </a>
            <a class="px-1" wire:click="showContent('Leave Transaction Report')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color: var(--label-color);font-weight:500; font-size:12px;white-space: nowrap; {{ $currentSection === 'Leave Transaction Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color: var(--main-heading-color);font-size:12px;' : '' }}">
                Leave Transaction Report

            </a>
        </div>

        @if ($currentSection == 'Employee Family Details')
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                            <h5 style="padding: 5px; color: white; font-size: 15px;margin-top:-8px;"
                                class="modal-title"><b>{{ $currentSection }}</b></h5>
                            <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close"
                                wire:click="close" style="background-color: white; height:10px;width:10px;">
                            </button>
                        </div>
                        @livewire('family-report')
                    </div>
                </div>
            </div>

            <div class="modal-backdrop fade show blurred-backdrop"></div>
        @elseif($currentSection == 'Attendance Muster Report')
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                            <h5 style="padding: 5px; color: white; font-size: 15px;margin-top:-8px;"
                                class="modal-title"><b>{{ $currentSection }}</b></h5>
                            <button type="button" class="btn-close btn-primary" data-dismiss="modal"
                                aria-label="Close" wire:click="close"
                                style="background-color: white; height:10px;width:10px;">
                            </button>
                        </div>
                        @livewire('attendance-muster-report')
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show blurred-backdrop"></div>
        @elseif($currentSection == 'Absent Report')
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                            <h5 style="padding: 5px; color: white; font-size: 15px;margin-top:-8px;"
                                class="modal-title"><b>{{ $currentSection }}</b></h5>
                            <button type="button" class="btn-close btn-primary" data-dismiss="modal"
                                aria-label="Close" wire:click="closeAbsentReport"
                                style="background-color: white; height:10px;width:10px;">
                            </button>
                        </div>
                        @livewire('absent-report')

                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show blurred-backdrop"></div>
        @elseif($currentSection == 'Shift Summary Report')
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                            <h5 style="padding: 5px; color: white; font-size: 15px;margin-top:-8px;"
                                class="modal-title"><b>{{ $currentSection }}</b></h5>
                            <button type="button" class="btn-close btn-primary" data-dismiss="modal"
                                aria-label="Close" wire:click="closeShiftSummaryReport"
                                style="background-color: white; height:10px;width:10px;">
                            </button>
                        </div>
                        @livewire('shift-summary-report')

                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show blurred-backdrop"></div>
        @elseif($currentSection == 'Attendance Conslidate Report')
            <p>Attendance Conslidate Report</p>
        @elseif($currentSection == 'Attendance Regularization Report')
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                            <h5 style="padding: 5px; color: white; font-size: 15px;margin-top:-8px;"
                                class="modal-title"><b>{{ $currentSection }}</b></h5>
                            <button type="button" class="btn-close btn-primary" data-dismiss="modal"
                                aria-label="Close" wire:click="close"
                                style="background-color: white; height:10px;width:10px;">
                            </button>
                        </div>
                        @livewire('attendance-regularisation-report')
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show blurred-backdrop"></div>
        @elseif($currentSection == 'Leave Availed Report')
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                            <h5 style="padding: 5px; color: white; font-size: 15px;margin-top:-8px;"
                                class="modal-title">
                                <b>{{ $currentSection }}</b>
                            </h5>
                            <button type="button" class="btn-close btn-primary" data-dismiss="modal"
                                aria-label="Close" wire:click="close"
                                style="background-color: white; height:10px;width:10px;">
                            </button>
                        </div>
                        <div class="modal-body" style="max-height:300px;overflow-y:auto;">


                            <div class="date-filters" style="padding: 15px;">
                                <!-- From Date -->
                                <div class="row">
                                    <div class="col-4">
                                        <label for="from-date"
                                            style="font-size: 0.8rem; color: var(--main-heading-color); font-weight: 500px;">From <span
                                                style="color: var(--requiredAlert);">*</span></label>
                                    </div>
                                    <div class="col-8" style="display: flex;flex-direction: column;">
                                        <input type="date" id="from-date" wire:model="fromDate"
                                            wire:change="updateFromDate" wire:model.lazy="fromDate"
                                            style="font-size: 0.785rem; color: var(--label-color); margin-right: 10px;width:45%">
                                        @error('fromDate')
                                            <span class="error"
                                                style="color: var(--requiredAlert);font-size:0.7rem;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- To Date -->
                                <div class="row">
                                    <div class="col-4">
                                        <label for="to-date" style="font-size: 0.8rem; color: var(--main-heading-color); font-weight: 500px;">To
                                            <span style="color: var(--requiredAlert);">*</span></label>
                                    </div>
                                    <div class="col-8" style="display: flex;flex-direction: column;">
                                        <input type="date" id="to-date" wire:model="toDate"
                                            wire:change="updateToDate" wire:model.lazy="toDate"
                                            style="font-size: 0.785rem; color: var(--label-color);width:45%">
                                        @error('toDate')
                                            <span class="error"
                                                style="color: var(--requiredAlert);font-size:0.7rem;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="to-date" style="font-size: 0.8rem; color: var(--main-heading-color); font-weight: 500px;">Leave
                                            Type </label>
                                    </div>
                                    <div class="col-8" style="display: flex;flex-direction: column;">
                                        <select id="leaveType" wire:model="leaveType" wire:change="updateLeaveType"
                                            wire:model.lazy="leaveType"
                                            style="font-size: 0.785rem; color: var(--label-color);width: 59%;height: 70%;">
                                            <option value="all">All Leaves</option>
                                            <option value="Loss Of Pay">Loss Of Pay</option>
                                            <option value="casual_leave">Casual Leave</option>
                                            <option value="earned_leave">Earned Leave</option>
                                            <option value="Sick Leave">Sick Leave</option>
                                            <option value="paternity">Paternity Leave</option>
                                            <option value="Casual Leave Probation">Casul Leave Probation</option>
                                            <option value="marriage_leave">Marriage Leave</option>

                                            <!-- Add other leave types as needed -->
                                        </select>
                                      
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="to-date"
                                            style="font-size: 0.8rem; color: var(--main-heading-color); font-weight: 500px;">Employee
                                            Type </label>
                                    </div>
                                    <div class="col-8" style="display: flex;flex-direction: column;">
                                        <select id="employeeType" wire:model="employeeType"
                                            style="font-size: 0.785rem; color: var(--label-color);width: 59%;height: 70%;">
                                            <option value="active" selected>Current Employees</option>
                                            <option value="past">Past Employees</option>

                                            <!-- Add other employee types as needed -->
                                        </select>
                                      
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="to-date" style="font-size: 0.8rem; color: var(--main-heading-color); font-weight: 500px;">Sort
                                            Order</label>
                                    </div>
                                    <div class="col-8">
                                        <select name="sortBy" wire:model="sortBy" wire:change="updateSortBy"
                                            id="sortBySelect"
                                            style="font-size: 0.785rem; color: var(--label-color);width: 59%;height: 70%;">

                                            <option value="newest_first" selected>Employee Number (Newest First)
                                            </option>
                                            <option value="oldest_first">Employee Number (Oldest First)
                                            </option>
                                        </select>
                                    </div>
                                </div>


                            </div>
                           <div class="mt-2" style="background-color: rgb(2, 17, 79); display: flex;justify-content: center; padding: 10px; gap: 15px;">
                                <button type="button" class="submit-btn" style="background-color: white; color: rgb(2, 17, 79);"
                                    wire:click="downloadLeaveAvailedReportInExcel">Run</button>
                                <button type="button" data-dismiss="modal" class="cancel-btn1"
                                    wire:click='resetFields'>Clear</button>

                            </div>

                        </div>



                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show blurred-backdrop"></div>
        @elseif($currentSection == 'Negative Leave Balance')
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                            <h5 style="padding: 5px; color: white; font-size: 15px;margin-top:-8px;"
                                class="modal-title">
                                <b>{{ $currentSection }}</b>
                            </h5>
                            <button type="button" class="btn-close btn-primary" data-dismiss="modal"
                                aria-label="Close" wire:click="close"
                                style="background-color: white; height:10px;width:10px;">
                            </button>
                        </div>
                        <div class="modal-body" style="max-height:300px;overflow-y:auto;">


                            <div class="date-filters" style="padding: 15px;">

                                <!-- Date Select -->
                                <div class="row">
                                    <div class="col-4">
                                        <label for="to-date"
                                            style="font-size: 0.8rem; color: var(--main-heading-color); font-weight: 500px;">Date<span
                                            style="color: var(--requiredAlert);">*</span></label>
                                    </div>
                                    <div class="col-8" style="display: flex;flex-direction: column;">
                                        <input type="date" id="to-date" wire:model="toDate"
                                            wire:change="updateToDate" 
                                            style="font-size: 0.785rem; color: var(--label-color);width:45%">
                                        @error('toDate')
                                            <span class="error"
                                                style="color: var(--requiredAlert);font-size:0.7rem;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="to-date" style="font-size: 0.8rem; color: var(--main-heading-color); font-weight: 500px;">Leave
                                            Type</label>
                                    </div>
                                    <div class="col-8" style="display: flex;flex-direction: column;">
                                        <select id="leaveType" wire:model="leaveType"
                                            style="font-size: 0.785rem; color: var(--label-color);width: 59%;height: 70%;">
                                            <option value="all">All Leaves</option>
                                            <option value="lop">Loss Of Pay</option>
                                            <option value="casual_leave">Casual Leave</option>
                                            <option value="sick">Sick Leave</option>
                                            <option value="petarnity">Petarnity Leave</option>
                                            <option value="maternity">Maternity Leave</option>
                                            <option value="casual_leave_probation">Casul Leave Probation</option>
                                            <option value="marriage_leave">Marriage Leave</option>

                                            <!-- Add other leave types as needed -->
                                        </select>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="to-date"
                                            style="font-size: 0.8rem; color: var(--main-heading-color); font-weight: 500px;">Employee
                                            Type</label>
                                    </div>
                                    <div class="col-8" style="display: flex;flex-direction: column;">
                                        <select id="employeeType" wire:model="employeeType"
                                            style="font-size: 0.785rem; color: var(--label-color);width: 59%;height: 70%;">
                                            <option value="active" selected>Current Employees</option>
                                            <option value="past">Past Employees</option>

                                            <!-- Add other employee types as needed -->
                                        </select>
                                        @error('employeeType')
                                            <span class="error"
                                                style="color: var(--requiredAlert);font-size:0.7rem;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="to-date" style="font-size: 0.8rem; color: var(--main-heading-color); font-weight: 500px;">Sort
                                            Order</label>
                                    </div>
                                    <div class="col-8">
                                        <select name="sortBy" wire:model="sortBy" wire:change="updateSortBy"
                                            id="sortBySelect"
                                            style="font-size: 0.785rem; color: var(--label-color);width: 59%;height: 70%;">

                                            <option value="newest_first" selected>Employee Number (Newest First)
                                            </option>
                                            <option value="oldest_first">Employee Number (Oldest First)</option>
                                        </select>
                                    </div>
                                </div>


                            </div>


                            
<div class="mt-2" style="background-color: rgb(2, 17, 79); display: flex;justify-content: center; padding: 10px; gap: 15px;">
                                <button type="button" class="submit-btn" style="background-color: white; color: rgb(2, 17, 79);"
                                    wire:click="downloadNegativeLeaveBalanceReport">Run</button>
                                <button type="button" data-dismiss="modal" class="cancel-btn1"
                                    wire:click='resetFields'>Clear</button>

                            </div>

                            

                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show blurred-backdrop"></div>
        @elseif($currentSection == 'Day Wise Leave Transation Report')
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                            <h5 style="padding: 5px; color: white; font-size: 15px;margin-top:-8px;"
                                class="modal-title">
                                <b>{{ $currentSection }}</b>
                            </h5>
                            <button type="button" class="btn-close btn-primary" data-dismiss="modal"
                                aria-label="Close" wire:click="close"
                                style="background-color: white; height:10px;width:10px;">
                            </button>
                        </div>

                        <div class="modal-body" style="max-height:300px;overflow-y:auto;">


                            <div class="date-filters" style="padding: 15px;">
                                <!-- From Date -->
                                <div class="row">
                                    <div class="col-4">
                                        <label for="from-date"
                                            style="font-size: 0.8rem; color: var(--main-heading-color); font-weight: 500px;">From<span
                                            style="color: var(--requiredAlert);">*</span></label>
                                    </div>
                                    <div class="col-8" style="display: flex;flex-direction: column;">
                                        <input type="date" id="from-date" wire:model="fromDate"
                                            wire:change="updateFromDate" wire:model.lazy="fromDate"
                                            style="font-size: 0.785rem; color: var(--label-color); margin-right: 10px;width:45%">
                                        @error('fromDate')
                                            <span class="error"
                                                style="color: var(--requiredAlert);font-size:0.7rem;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- To Date -->
                                <div class="row">
                                    <div class="col-4">
                                        <label for="to-date"
                                            style="font-size: 0.8rem; color: var(--main-heading-color); font-weight: 500px;">To<span
                                            style="color: var(--requiredAlert);">*</span></label>
                                    </div>
                                    <div class="col-8" style="display: flex;flex-direction: column;">
                                        <input type="date" id="to-date" wire:model="toDate"
                                            wire:change="updateToDate" wire:model.lazy="toDate"
                                            style="font-size: 0.785rem; color: var(--label-color);width:45%">
                                        @error('toDate')
                                            <span class="error"
                                                style="color: var(--requiredAlert);font-size:0.7rem;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="to-date"
                                            style="font-size: 0.8rem; color: var(--main-heading-color); font-weight: 500px;">Transaction
                                            Type</label>
                                    </div>
                                    <div class="col-8" style="display: flex;flex-direction: column;">
                                        <select id="transactionType" wire:model="transactionType"
                                            wire:change="updateTransactionType($event.target.value)"
                                            wire:model.lazy="transactionType"
                                            style="font-size: 0.785rem; color: var(--label-color);width: 59%;height: 70%;">
                                            <option value="all">All </option>
                                            <option value="approved">Availed</option>
                                            <!-- Add other leave types as needed -->
                                        </select>
                                      
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="to-date"
                                            style="font-size: 0.8rem; color: var(--main-heading-color); font-weight: 500px;">Employee
                                            Type</label>
                                    </div>
                                    <div class="col-8" style="display: flex;flex-direction: column;">
                                        <select id="employeeType" wire:model="employeeType"
                                            style="font-size: 0.785rem; color: var(--label-color);width: 59%;height: 70%;">
                                            <option value="active" selected>Current Employees</option>
                                            <option value="past">Past Employees</option>

                                            <!-- Add other employee types as needed -->
                                        </select>
                                      
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="to-date" style="font-size: 0.8rem; color: var(--main-heading-color); font-weight: 500px;">Sort
                                            Order</label>
                                    </div>
                                    <div class="col-8">
                                        <select name="sortBy" wire:model="sortBy" wire:change="updateSortBy"
                                            id="sortBySelect"
                                            style="font-size: 0.785rem; color: var(--label-color);width: 59%;height: 70%;">
                                            <option value="newest_first" selected>Employee Number (Newest First)
                                            </option>
                                            <option value="oldest_first">Employee Number (oldest First)
                                            </option>

                                        </select>
                                    </div>
                                </div>


                            </div>


                           
                           <div class="mt-2" style="background-color: rgb(2, 17, 79); display: flex;justify-content: center; padding: 10px; gap: 15px;">
                                <button type="button" class="submit-btn" style="background-color: white; color: rgb(2, 17, 79);"
                                    wire:click="dayWiseLeaveTransactionReport">Run</button>
                                <button type="button" data-dismiss="modal" class="cancel-btn1"
                                    wire:click='resetFields'>Clear</button>

                            </div>

                        </div>



                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show blurred-backdrop"></div>
        @elseif($currentSection == 'Leave Balance As On A Day')
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                            <h5 style="padding: 5px; color: white; font-size: 15px;margin-top:-8px;"
                                class="modal-title">
                                <b>{{ $currentSection }}</b>
                            </h5>
                            <button type="button" class="btn-close btn-primary" data-dismiss="modal"
                                aria-label="Close" wire:click="close"
                                style="background-color: white; height:10px;width:10px;">
                            </button>
                        </div>

                        <div class="modal-body">

                            <div class="date-filters mt-2">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="date-container">
                                            <label class="required-field label-style">Date<span
                                                style="color: var(--requiredAlert);">*</span></label>
                                            <div>
                                                <input type="date" wire:model="toDate" wire:change="updateToDate"
                                                    wire:model.lazy="toDate"
                                                    class="form-control input-placeholder-small" id="to-date"
                                                    name="toDate" style="color: var(--label-color); width: 190px;">
                                                @error('toDate')
                                                    <span class="error"
                                                        style="color: var(--requiredAlert); font-size:0.7rem; margin-right: 90px;">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="input-group people-input-group-container">
                                    <input wire:model="search" wire:change="searchfilterleave" type="text"
                                        class="form-control people-search-input" placeholder="Search..."
                                        aria-label="Search" aria-describedby="basic-addon1">
                                    <div class="input-group-append">
                                        <button wire:change="searchfilterleave" class="people-search-btn"
                                            type="button">
                                            <i class="fa fa-search people-search-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @if (session('error'))
                                <div class="alert alert-danger mt-2">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div style="overflow-y: auto; max-height: 200px; margin-top: 15px;">
                                <table class="swipes-table mt-2 border"
                                    style="width: 100%; max-height: 400px; overflow-y: auto;">
                                    <tr style="background-color: #f6fbfc;">
                                        <th
                                            style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color: var(--label-color);font-weight:500;white-space:nowrap;">
                                            Employee Name</th>
                                        <th
                                            style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color: var(--label-color);font-weight:500;white-space:nowrap;">
                                            Employee Number</th>

                                    </tr>
                                    @if ($filteredEmployees->isNotEmpty())
                                        @foreach ($filteredEmployees as $emp)
                                            <tr style="border:1px solid #ccc;">

                                                <td
                                                    style="width:50%;font-size: 10px; color: var(--label-color);text-align:start;padding:5px 10px;white-space:nowrap;">
                                                    <input type="checkbox" name="employeeCheckbox[]"
                                                        class="employee-swipes-checkbox" wire:model="leaveBalance"
                                                        value="{{ $emp->emp_id }}">
                                                    {{ ucwords(strtolower($emp->first_name)) }}&nbsp;{{ ucwords(strtolower($emp->last_name)) }}
                                                </td>
                                                <td
                                                    style="width:50%;font-size: 10px; color: var(--label-color);text-align:start;padding:5px 10px;white-space:nowrap;">
                                                    {{ $emp->emp_id }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr style="border:1px solid #ccc;">
                                            <td colspan="2"
                                                style="text-align: center;  padding: 10px; font-size: 10px; color: var(--label-color);">
                                                No employees found.
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            </div>

                           <div class="mt-2" style="background-color: rgb(2, 17, 79); display: flex;justify-content: center; padding: 10px; gap: 15px;">
                                <button type="button" class="submit-btn" style="background-color: white; color: rgb(2, 17, 79);"
                                    wire:click="leaveBalanceAsOnADayReport">Run</button>
                                <button type="button" data-dismiss="modal" class="cancel-btn1"
                                    wire:click='resetFields'>Clear</button>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show blurred-backdrop"></div>
        @elseif($currentSection == 'Leave Transaction Report')
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                            <h5 style="padding: 5px; color: white; font-size: 15px;margin-top:-8px;"
                                class="modal-title">
                                <b>{{ $currentSection }}</b>
                            </h5>
                            <button type="button" class="btn-close btn-primary" data-dismiss="modal"
                                aria-label="Close" wire:click="close"
                                style="background-color: white; height:10px;width:10px;">
                            </button>
                        </div>


                        <div class="modal-body" style="max-height:300px;overflow-y:auto;">


                            <div class="date-filters" style="padding: 15px;">
                                <!-- From Date -->
                                <div class="row">
                                    <div class="col-4">
                                        <label for="from-date"
                                            style="font-size: 0.8rem; color: var(--main-heading-color); font-weight: 500px;">From<span
                                            style="color: var(--requiredAlert);">*</span></label>
                                    </div>
                                    <div class="col-8" style="display: flex;flex-direction: column;">
                                        <input type="date" id="from-date" wire:model="fromDate"
                                            wire:change="updateFromDate" wire:model.lazy="fromDate"
                                            style="font-size: 0.785rem; color: var(--label-color); margin-right: 10px;width:45%">
                                        @error('fromDate')
                                            <span class="error"
                                                style="color: var(--requiredAlert);font-size:0.7rem;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- To Date -->
                                <div class="row">
                                    <div class="col-4">
                                        <label for="to-date"
                                            style="font-size: 0.8rem; color: var(--main-heading-color); font-weight: 500px;">To<span
                                            style="color: var(--requiredAlert);">*</span></label>
                                    </div>
                                    <div class="col-8" style="display: flex;flex-direction: column;">
                                        <input type="date" id="to-date" wire:model="toDate"
                                            wire:change="updateToDate" wire:model.lazy="toDate"
                                            style="font-size: 0.785rem; color: var(--label-color);width:45%">
                                        @error('toDate')
                                            <span class="error"
                                                style="color: var(--requiredAlert);font-size:0.7rem;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="to-date" style="font-size: 0.8rem; color: var(--main-heading-color); font-weight: 500px;">Leave
                                            Type</label>
                                    </div>
                                    <div class="col-8" style="display: flex;flex-direction: column;">
                                        <select id="leaveType" wire:model="leaveType" wire:change="updateLeaveType"
                                            wire:model.lazy="leaveType"
                                            style="font-size: 0.785rem; color: var(--label-color);width: 59%;height: 70%;">
                                            <option value="all">All Leaves</option>
                                            <option value="lop">Loss Of Pay</option>
                                            <option value="casual_leave">Casual Leave</option>
                                            <option value="sick">Sick Leave</option>
                                            <option value="petarnity">Petarnity Leave</option>
                                            <option value="maternity">Maternity Leave</option>
                                            <option value="casual_leave_probation">Casul Leave Probation</option>
                                            <option value="marriage_leave">Marriage Leave</option>

                                            <!-- Add other leave types as needed -->
                                        </select>
                                        {{-- @error('leaveType') <span class="error"
                                        style="color: var(--requiredAlert);font-size:0.7rem;">{{ $message }}</span> @enderror --}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="to-date" style="font-size: 0.8rem; color: var(--main-heading-color); font-weight: 500px;">Leave
                                            Transaction
                                        </label>
                                    </div>
                                    <div class="col-8" style="display: flex;flex-direction: column;">
                                        <select id="transactionType" wire:model="transactionType"
                                            style="font-size: 0.785rem; color: var(--label-color);width: 59%;height: 70%;">
                                            <option value="all">All</option>
                                            <option value="availed">Availed</option>
                                            <option value="withdrawn">Withdrawn</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                        {{-- @error('transactionType') <span class="error"
                                        style="color: var(--requiredAlert);font-size:0.7rem;">{{ $message }}</span> @enderror --}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="to-date"
                                            style="font-size: 0.8rem; color: var(--main-heading-color); font-weight: 500px;">Employee
                                            Type</label>
                                    </div>
                                    <div class="col-8" style="display: flex;flex-direction: column;">
                                        <select id="employeeType"  wire:model="employeeType"
                                            style="font-size: 0.785rem; color: var(--label-color);width: 59%;height: 70%;">
                                            <option value="active" selected>Current Employees</option>
                                            <option value="past">Past Employees</option>
                                           

                                            <!-- Add other employee types as needed -->
                                        </select>
                                        {{-- @error('employeeType')
                                            <span class="error"
                                                style="color: var(--requiredAlert);font-size:0.7rem;">{{ $message }}</span>
                                        @enderror --}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="to-date" style="font-size: 0.8rem; color: var(--main-heading-color); font-weight: 500px;">Sort
                                            Order</label>
                                    </div>
                                    <div class="col-8">
                                        <select name="sortBy" wire:model="sortBy" wire:change="updateSortBy"
                                            id="sortBySelect"
                                            style="font-size: 0.785rem; color: var(--label-color);width: 59%;height: 70%;">

                                            <option value="newest_first" selected>Employee Number (Newest First)
                                            </option>
                                            <option value="oldest_first">Employee Number (Oldest First)</option>
                                        </select>
                                    </div>
                                </div>


                            </div>


                          
                            <div class="mt-2" style="background-color: rgb(2, 17, 79); display: flex;justify-content: center; padding: 10px; gap: 15px;">
                                <button type="button" class="submit-btn" style="background-color: white; color: rgb(2, 17, 79);"
                                    wire:click="downloadLeaveTransactionReport">Run</button>
                                <button type="button" data-dismiss="modal" class="cancel-btn1"
                                    wire:click='resetFields'>Clear</button>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show blurred-backdrop"></div>
        @endif
    </div>
