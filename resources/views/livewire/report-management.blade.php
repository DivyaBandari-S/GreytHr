<div class="row p-0 m-0 mt-3 p-2 position-relative">
    <div class="position-absolute" wire:loading
        wire:target="downloadLeaveAvailedReportInExcel,close,resetFields,downloadNegativeLeaveBalanceReport,dayWiseLeaveTransactionReport,downloadLeaveTransactionReport,leaveBalanceAsOnADayReport">
        <div class="loader-overlay">
            <div class="loader">
                <div></div>
            </div>
        </div>
    </div>
    <style>
        .report-search-input {
            font-size: 0.75rem !important;
            border-radius: 5px 0 0 5px;
            height: 32px;
        }


        .report-search-btn {
            height: 32px;
            width: 40px;
            position: relative;
            border-radius: 0 5px 5px 0;
            background-color: rgb(2, 17, 79);
            color: #fff;
            border: none;
        }

        .report-search-icon {
            position: absolute;
            top: 9px;
            left: 11px;
        }

        .report-select-all-text {
            font-size: var(--normal-font-size);
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
            <!-- <a class="px-1" wire:click="showContent('Attendance Conslidate Report')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color: var(--label-color);font-weight:500; font-size:12px;white-space: nowrap; {{ $currentSection === 'Attendance Conslidate Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color: var(--main-heading-color);font-size:12px;' : '' }}">
                Attendance Conslidate Report

            </a> -->
            <a class="px-1" wire:click="showContent('Attendance Regularization Report')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color: var(--label-color);font-weight:500; font-size:12px; white-space: nowrap;{{ $currentSection === 'Attendance Regularization Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color: var(--main-heading-color);font-size:12px;' : '' }}">
                Attendance Regularization Report

            </a>
            <a class="px-1" wire:click="showContent('Swipe Data Report')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color: var(--label-color);font-weight:500; font-size:12px; white-space: nowrap;{{ $currentSection === 'Swipe Data Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color: var(--main-heading-color);font-size:12px;' : '' }}">
                Swipe Data Report

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
            <div wire:ignore.self class="modal fade show" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display:block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h5 class="modal-title"><b>{{ $currentSection }}</b></h5>
                            <button type="button" class="btn-close " data-dismiss="modal" aria-label="Close"
                                wire:click="close">
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
                        <div class="modal-header">
                            <h5 class="modal-title"><b>{{ $currentSection }}</b></h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"
                                wire:click="close">
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
                        <div class="modal-header">
                            <h5 class="modal-title"><b>{{ $currentSection }}</b></h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"
                                wire:click="closeAbsentReport">
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
                        <div class="modal-header">
                            <h5 class="modal-title"><b>{{ $currentSection }}</b></h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"
                                wire:click="closeShiftSummaryReport">
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
                        <div class="modal-header">
                            <h5 class="modal-title"><b>{{ $currentSection }}</b></h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"
                                wire:click="close">
                            </button>
                        </div>
                        @livewire('attendance-regularisation-report')
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show blurred-backdrop"></div>
            @elseif($currentSection == 'Swipe Data Report')
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><b>{{ $currentSection }}</b></h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"
                                wire:click="close">
                            </button>
                        </div>
                        @livewire('swipe-data-report')
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show blurred-backdrop"></div>    
        @elseif($currentSection == 'Leave Availed Report')
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <b>{{ $currentSection }}</b>
                            </h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"
                                wire:click="close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-6 mb-2">
                                    <label for="fromDate">From <span
                                            style="color: var(--requiredAlert);">*</span></label>
                                    <input type="date" class="form-control placeholder-small"
                                        wire:change="updateFromDate" id="fromDate" wire:model="fromDate">
                                    @error('fromDate')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 mb-2">
                                    <label for="toDate">To <span
                                            style="color: var(--requiredAlert);">*</span></label>
                                    <input type="date" class="form-control placeholder-small"
                                        wire:change="updateToDate" wire:model="toDate" id="toDate">
                                    @error('toDate')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 mb-2">
                                    <label for="leaveType">Leave
                                        Type</label>
                                    <select id="leaveType" wire:change="updateLeaveType" wire:model="leaveType"
                                        class="form-select placeholder-small">
                                        <option value="all">All Leaves</option>
                                        <option value="lop">Loss Of Pay</option>
                                        <option value="casual_leave">Casual Leave</option>
                                        <option value="earned_leave">Earned Leave</option>
                                        <option value="sick">Sick Leave</option>
                                        <optiorn value="petarnity">Paternity Leave</optiorn>
                                        <option value="maternity">Maternity Leave</option>
                                        <option value="casual_leave_probation">Casul Leave Probation</option>
                                        <option value="marriage_leave">Marriage Leave</option>

                                        <!-- Add other leave types as needed -->
                                    </select>
                                </div>
                                <div class="form-group col-md-6 mb-2">
                                    <label for="to-date">Employee
                                        Type</label>
                                    <select id="employeeType" wire:model="employeeType"
                                        class="form-select placeholder-small">
                                        <option value="active" selected>Current Employees</option>
                                        <option value="past">Past Employees</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 mb-2">
                                    <label for="to-date">Sort
                                        Order</label>
                                    <select name="sortBy" wire:model="sortBy" wire:change="updateSortBy"
                                        id="sortBySelect" class="form-select placeholder-small">
                                        <option value="newest_first" selected>Employee Number (Newest First)
                                        </option>
                                        <option value="oldest_first">Employee Number (Oldest First)
                                        </option>
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" class="submit-btn"
                                wire:click="downloadLeaveAvailedReportInExcel">Run</button>
                            <button type="button" class="cancel-btn" wire:click="resetFields"
                                style="border:1px solid rgb(2,17,79);">Clear</button>
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
                <div class="modal-header">
                    <h5 class="modal-title">
                        <b>{{ $currentSection }}</b>
                    </h5>
                    <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close"
                        wire:click="close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label for="to-date">Date <span style="color: var(--requiredAlert);">*</span></label>
                            <input type="date" class="form-control placeholder-small" wire:model="toDate"
                                wire:change="updateToDate">
                            @error('toDate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="to-date">Leave Type</label>
                            <select id="leaveType" wire:model="leaveType" class="form-select placeholder-small">
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
                        <div class="form-group col-md-6 mb-2">
                            <label for="to-date">Employee
                                Type</label>
                            <select id="employeeType" wire:model="employeeType"
                                class="form-select placeholder-small">
                                <option value="active" selected>Current Employees</option>
                                <option value="past">Past Employees</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="to-date">Sort
                                Order</label>
                            <select name="sortBy" wire:model="sortBy" wire:change="updateSortBy" id="sortBySelect"
                                class="form-select placeholder-small">
                                <option value="newest_first" selected>Employee Number (Newest First)
                                </option>
                                <option value="oldest_first">Employee Number (Oldest First)
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="submit-btn"
                            wire:click="downloadNegativeLeaveBalanceReport">Run</button>
                        <button type="button" class="cancel-btn" wire:click="resetFields"
                            style="border:1px solid rgb(2,17,79);">Clear</button>
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
                <div class="modal-header">
                    <h5 class="modal-title">
                        <b>{{ $currentSection }}</b>
                    </h5>
                    <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close"
                        wire:click="close">
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label for="from-date">From <span style="color: var(--requiredAlert);">*</span></label>
                            <input type="date" class="form-control placeholder-small" wire:model="fromDate"
                                wire:change="updateFromDate" wire:model.lazy="fromDate">
                            @error('fromDate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="to-date">To <span style="color: var(--requiredAlert);">*</span></label>
                            <input type="date" class="form-control placeholder-small" wire:model="toDate"
                                wire:change="updateToDate" wire:model.lazy="toDate">
                            @error('toDate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="to-date">Transaction
                                Type</label>
                            <select id="transactionType" wire:change="updateTransactionType($event.target.value)"
                                wire:model.lazy="transactionType" class="form-select placeholder-small">
                                <option value="all">All Transactions</option>
                                <option value="granted">Granted</option>
                                <option value="availed">Availed</option>
                                <option value="lapsed">Lapsed</option>
                                <option value="withdrawn">Withdrawn</option>
                                <option value="rejected">Rejected</option>


                                <!-- Add other leave types as needed -->
                            </select>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="to-date">Employee
                                Type</label>
                            <select id="employeeType" wire:model="employeeType"
                                class="form-select placeholder-small">
                                <option value="active" selected>Current Employees</option>
                                <option value="past">Past Employees</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="to-date">Sort
                                Order</label>
                            <select name="sortBy" wire:model="sortBy" wire:change="updateSortBy" id="sortBySelect"
                                class="form-select placeholder-small">
                                <option value="newest_first" selected>Employee Number (Newest First)
                                </option>
                                <option value="oldest_first">Employee Number (Oldest First)
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="submit-btn"
                            wire:click="dayWiseLeaveTransactionReport">Run</button>
                        <button type="button" class="cancel-btn" wire:click="resetFields"
                            style="border:1px solid rgb(2,17,79);">Clear</button>
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
                <div class="modal-header">
                    <h5 class="modal-title">
                        <b>{{ $currentSection }}</b>
                    </h5>
                    <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close"
                        wire:click="close">
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label for="to-date">Date <span style="color: var(--requiredAlert);">*</span></label>
                            <input type="date" class="form-control placeholder-small" wire:model="toDate"
                                wire:change="updateToDate" wire:model.lazy="toDate">
                            @error('toDate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-2">
                        {{-- <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll" wire:model="selectAll" wire:click="toggleSelectAll">
                                        <label class="form-check-label report-select-all-text" for="selectAll">
                                            Select All
                                        </label>
                                    </div>
                                </div> --}}
                        <div class="col-md-6">
                            <div class="input-group">
                                <input wire:model="search" wire:change="searchfilterleave" type="text"
                                    class="form-control report-search-input" placeholder="Search..."
                                    aria-label="Search" aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <button wire:change="searchfilterleave" class="report-search-btn" type="button">
                                        <i class="fa fa-search report-search-icon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>


                    </div>
                    @if (session('error'))
                        <div class="alert alert-danger mt-2">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div style="overflow-y: auto; max-height: 200px; ">
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
                            @php
                                // Sorting alphabetically by first_name and then last_name
                                $sortedEmployees = $this->filteredEmployees->sortBy(function ($employee) {
                                    return strtolower($employee->first_name . ' ' . $employee->last_name); // Combine first and last name for sorting
                                });

                            @endphp

                            @if ($sortedEmployees->isNotEmpty())
                                @foreach ($sortedEmployees as $emp)
                                    <tr style="border:1px solid #ccc;"
                                        class="@if (in_array(strtolower($emp->employee_status), ['terminated', 'resigned'])) text-danger @endif">

                                        <td style="width:50%; font-size: 10px; text-align:start; padding:5px 10px; 
                                           white-space:nowrap; display: flex; align-items: center;"
                                            class="@if (in_array(strtolower($emp->employee_status), ['terminated', 'resigned'])) text-danger @endif">

                                            <label class="custom-checkbox" style="margin-right: 5px;">
                                                <input type="checkbox" name="employeeCheckbox[]"
                                                    class="employee-swipes-checkbox" wire:model="leaveBalance"
                                                    value="{{ $emp->emp_id }}">
                                                <span class="checkmark"></span>
                                            </label>

                                            {{ ucwords(strtolower($emp->first_name)) }}&nbsp;{{ ucwords(strtolower($emp->last_name)) }}
                                        </td>

                                        <td style="width:50%; font-size: 10px; text-align:start; padding:5px 10px; 
                                           white-space:nowrap;"
                                            class="@if (in_array(strtolower($emp->employee_status), ['terminated', 'resigned'])) text-danger @endif">
                                            {{ $emp->emp_id }}
                                        </td>
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
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="submit-btn"
                            wire:click="leaveBalanceAsOnADayReport">Run</button>
                        <button type="button" class="cancel-btn" wire:click="resetFields"
                            style="border:1px solid rgb(2,17,79);">Clear</button>
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
                <div class="modal-header">
                    <h5 class="modal-title">
                        <b>{{ $currentSection }}</b>
                    </h5>
                    <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close"
                        wire:click="close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label for="from-date">From <span style="color: var(--requiredAlert);">*</span></label>
                            <input type="date" class="form-control placeholder-small" wire:model="fromDate"
                                wire:change="updateFromDate" wire:model.lazy="fromDate">
                            @error('fromDate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="to-date">To <span style="color: var(--requiredAlert);">*</span></label>
                            <input type="date" class="form-control placeholder-small" wire:model="toDate"
                                wire:change="updateToDate" wire:model.lazy="toDate">
                            @error('toDate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="to-date">Leave
                                Type</label>
                            <select id="leaveType" wire:model="leaveType" wire:change="updateLeaveType"
                                wire:model.lazy="leaveType" class="form-select placeholder-small">
                                <option value="all">All Leaves</option>
                                <option value="lop">Loss Of Pay</option>
                                <option value="casual_leave">Casual Leave</option>
                                <option value="sick">Sick Leave</option>
                                <option value="petarnity">Petarnity Leave</option>
                                <option value="maternity">Maternity Leave</option>
                                <option value="casual_leave_probation">Casul Leave Probation</option>
                                <option value="marriage_leave">Marriage Leave</option>
                                <option value="earned_leave">Earned Leave</option>

                                <!-- Add other leave types as needed -->
                            </select>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="to-date">Leave
                                Transaction</label>
                            <select id="transactionType" wire:model="transactionType"
                                class="form-select placeholder-small">
                                <option value="all">All</option>
                                <option value="granted">Granted</option>
                                <option value="availed">Availed</option>
                                <option value="withdrawn">Withdrawn</option>
                                <option value="rejected">Rejected</option>
                                <option value="lapsed">Lapsed</option>

                                <!-- Add other leave types as needed -->
                            </select>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="to-date">Employee
                                Type</label>
                            <select id="employeeType" wire:model="employeeType"
                                class="form-select placeholder-small">
                                <option value="active" selected>Current Employees</option>
                                <option value="past">Past Employees</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="to-date">Sort
                                Order</label>
                            <select name="sortBy" wire:model="sortBy" wire:change="updateSortBy" id="sortBySelect"
                                class="form-select placeholder-small">
                                <option value="newest_first" selected>Employee Number (Newest First)
                                </option>
                                <option value="oldest_first">Employee Number (Oldest First)
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="submit-btn"
                            wire:click="downloadLeaveTransactionReport">Run</button>
                        <button type="button" class="cancel-btn" wire:click="resetFields"
                            style="border:1px solid rgb(2,17,79);">Clear</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show blurred-backdrop"></div>
    @endif
</div>
