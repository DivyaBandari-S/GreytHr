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
    </style>
    <div class="col-md-3">
        <div class="d-flex flex-column mb-2" style="line-height:2;">
            <span style="color:#b1b1b1;font-size:12px;" class="mt-2" class="mt-2" class="mt-2">HR Reports</span>
            <a class="px-1" wire:click="showContent('Employee Family Details')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px;white-space: nowrap; <?php echo e($currentSection === 'Employee Family Details' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Employee Family Details

            </a>
        </div>
        <div class="d-flex flex-column mb-2" style="line-height:2;">
            <span style="color:#b1b1b1;font-size:12px;" class="mt-2" class="mt-2" class="mt-2">Attendance</span>
            <a class="px-1" wire:click="showContent('Attendance Muster Report')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none;white-space: nowrap; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px; <?php echo e($currentSection === 'Attendance Muster Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Attendance Muster Report

            </a>
            <a class="px-1" wire:click="showContent('Absent Report')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px; <?php echo e($currentSection === 'Absent Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Absent Report

            </a>
            <a class="px-1" wire:click="showContent('Shift Summary Report')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px;white-space: nowrap; <?php echo e($currentSection === 'Shift Summary Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Shift Summary Report

            </a>
            <a class="px-1" wire:click="showContent('Attendance Conslidate Report')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px;white-space: nowrap; <?php echo e($currentSection === 'Attendance Conslidate Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Attendance Conslidate Report

            </a>
            <a class="px-1" wire:click="showContent('Attendance Regularization Report')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px; white-space: nowrap;<?php echo e($currentSection === 'Attendance Regularization Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Attendance Regularization Report

            </a>
        </div>
        <div class="d-flex flex-column mb-2" style="line-height:2;">
            <span style="color:#b1b1b1;font-size:12px;" class="mt-2" class="mt-2" class="mt-2">Leave</span>
            <a class="px-1" wire:click="showContent('Leave Availed Report')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px; white-space: nowrap; <?php echo e($currentSection === 'Leave Availed Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Leave Availed Report

            </a>
            <a class="px-1" wire:click="showContent('Negative Leave Balance')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px;white-space: nowrap; <?php echo e($currentSection === 'Negative Leave Balance' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Negative Leave Balance

            </a>
            <a class="px-1" wire:click="showContent('Day Wise Leave Transation Report')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px;white-space: nowrap; <?php echo e($currentSection === 'Day Wise Leave Transation Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Day Wise Leave Transation Report

            </a>
            <a class="px-1" wire:click="showContent('Leave Balance As On A Day')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px;white-space: nowrap; <?php echo e($currentSection === 'Leave Balance As On A Day' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Leave Balance As On A Day

            </a>
            <a class="px-1" wire:click="showContent('Leave Transaction Report')" data-toggle="modal"
                data-target="#FamilyDetailsModal"
                style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px;white-space: nowrap; <?php echo e($currentSection === 'Leave Transaction Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Leave Transaction Report

            </a>
        </div>

        <!--[if BLOCK]><![endif]--><?php if($currentSection=='Employee Family Details'): ?>
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                        <h5 style="padding: 5px; color: white; font-size: 15px;margin-top:-8px;" class="modal-title"><b><?php echo e($currentSection); ?></b></h5>
                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="close" style="background-color: white; height:10px;width:10px;">
                        </button>
                    </div>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('family-report');

$__html = app('livewire')->mount($__name, $__params, 'lw-3524508938-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                </div>
            </div>
        </div>
        
        <div class="modal-backdrop fade show blurred-backdrop"></div>
        <?php elseif($currentSection=='Attendance Muster Report'): ?>
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                        <h5 style="padding: 5px; color: white; font-size: 15px;margin-top:-8px;" class="modal-title"><b><?php echo e($currentSection); ?></b></h5>
                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="close" style="background-color: white; height:10px;width:10px;">
                        </button>
                    </div>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('attendance-muster-report');

$__html = app('livewire')->mount($__name, $__params, 'lw-3524508938-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
        <?php elseif($currentSection=='Absent Report'): ?>
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                        <h5 style="padding: 5px; color: white; font-size: 15px;margin-top:-8px;" class="modal-title"><b><?php echo e($currentSection); ?></b></h5>
                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="closeAbsentReport" style="background-color: white; height:10px;width:10px;">
                        </button>
                    </div>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('absent-report');

$__html = app('livewire')->mount($__name, $__params, 'lw-3524508938-2', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
        <?php elseif($currentSection=='Shift Summary Report'): ?>
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                        <h5 style="padding: 5px; color: white; font-size: 15px;margin-top:-8px;" class="modal-title"><b><?php echo e($currentSection); ?></b></h5>
                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="closeShiftSummaryReport" style="background-color: white; height:10px;width:10px;">
                        </button>
                    </div>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('shift-summary-report');

$__html = app('livewire')->mount($__name, $__params, 'lw-3524508938-3', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
        <?php elseif($currentSection=='Attendance Conslidate Report'): ?>
        <p>Attendance Conslidate Report</p>
        <?php elseif($currentSection=='Attendance Regularization Report'): ?>
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                        <h5 style="padding: 5px; color: white; font-size: 15px;margin-top:-8px;" class="modal-title"><b><?php echo e($currentSection); ?></b></h5>
                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="close" style="background-color: white; height:10px;width:10px;">
                        </button>
                    </div>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('attendance-regularisation-report');

$__html = app('livewire')->mount($__name, $__params, 'lw-3524508938-4', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
        <?php elseif($currentSection=='Leave Availed Report'): ?>
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                        <h5 style="padding: 5px; color: white; font-size: 15px;margin-top:-8px;" class="modal-title">
                            <b><?php echo e($currentSection); ?></b>
                        </h5>
                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close"
                            wire:click="close" style="background-color: white; height:10px;width:10px;">
                        </button>
                    </div>
                    <div class="modal-body" style="max-height:300px;overflow-y:auto;">


                        <div class="date-filters" style="padding: 15px;">
                            <!-- From Date -->
                            <div class="row">
                                <div class="col-4">
                                    <label for="from-date"
                                        style="font-size: 0.785rem; color: rgb(2, 17, 79);">From <span style="color: red;">*</span></label>
                                </div>
                                <div class="col-8" style="display: flex;flex-direction: column;">
                                    <input type="date" id="from-date" wire:model="fromDate" wire:change="updateFromDate"
                                        wire:model.lazy="fromDate"
                                        style="font-size: 0.785rem; color: #778899; margin-right: 10px;width:45%">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fromDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"
                                        style="color: red;font-size:0.7rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                            <!-- To Date -->
                            <div class="row">
                                <div class="col-4">
                                    <label for="to-date" style="font-size: 0.785rem; color: rgb(2, 17, 79);">To <span style="color: red;">*</span></label>
                                </div>
                                <div class="col-8" style="display: flex;flex-direction: column;">
                                    <input type="date" id="to-date" wire:model="toDate" wire:change="updateToDate"
                                        wire:model.lazy="toDate" style="font-size: 0.785rem; color: #778899;width:45%">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['toDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"
                                        style="color: red;font-size:0.7rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <label for="to-date" style="font-size: 0.785rem;color:rgb(2, 17, 79);">Leave
                                        Type <span style="color: red;">*</span></label>
                                </div>
                                <div class="col-8" style="display: flex;flex-direction: column;">
                                    <select id="leaveType" wire:model="leaveType" wire:change="updateLeaveType"
                                        wire:model.lazy="leaveType"
                                        style="font-size: 0.785rem; color: #778899;width: 59%;height: 70%;">
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
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['leaveType'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"
                                        style="color: red;font-size:0.7rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <label for="to-date" style="font-size: 0.785rem;color: rgb(2, 17, 79);">Employee
                                        Type <span style="color: red;">*</span></label>
                                </div>
                                <div class="col-8" style="display: flex;flex-direction: column;">
                                    <select id="employeeType" wire:model="employeeType" wire:change="updateEmployeeType"
                                        wire:model.lazy="employeeType"
                                        style="font-size: 0.785rem; color: #778899;width: 59%;height: 70%;">
                                        <option value="">Select Employee Type</option>
                                        <option value="active">Current Employees</option>
                                        <option value="past">Past Employees</option>

                                        <!-- Add other employee types as needed -->
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['employeeType'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"
                                        style="color: red;font-size:0.7rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <label for="to-date" style="font-size: 0.785rem; rgb(2, 17, 79);">Sort Order</label>
                                </div>
                                <div class="col-8">
                                    <select name="sortBy" wire:model="sortBy" wire:change="updateSortBy"
                                        id="sortBySelect"
                                        style="font-size: 0.785rem; color: #778899;width: 59%;height: 70%;">

                                        <option value="newest_first" selected>Employee Number (Newest First)</option>
                                    </select>
                                </div>
                            </div>


                        </div>


                        <div class="modal-footer mt-2"
                            style="background-color: rgb(2, 17, 79); display: flex;justify-content: space-around;;">
                            <button type="button"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;">Options</button>
                            <button type="button"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;"
                                wire:click="downloadLeaveAvailedReportInExcel">Run</button>
                            <button type="button" data-dismiss="modal"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;"
                                wire:click='resetFields'>Clear</button>

                        </div>

                    </div>



                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
        <?php elseif($currentSection=='Negative Leave Balance'): ?>
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                        <h5 style="padding: 5px; color: white; font-size: 15px;margin-top:-8px;" class="modal-title">
                            <b><?php echo e($currentSection); ?></b>
                        </h5>
                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close"
                            wire:click="close" style="background-color: white; height:10px;width:10px;">
                        </button>
                    </div>
                    <div class="modal-body" style="max-height:300px;overflow-y:auto;">


                        <div class="date-filters" style="padding: 15px;">

                            <!-- Date Select -->
                            <div class="row">
                                <div class="col-4">
                                    <label for="to-date"
                                        style="font-size: 0.785rem; color: rgb(2, 17, 79);">Date</label>
                                </div>
                                <div class="col-8" style="display: flex;flex-direction: column;">
                                    <input type="date" id="to-date" wire:model="DateSelect"
                                        wire:change="updateDateSelect" wire:model.lazy="toDate"
                                        style="font-size: 0.785rem; color: #778899;width:45%">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['Date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"
                                        style="color: red;font-size:0.7rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <label for="to-date" style="font-size: 0.785rem;color:rgb(2, 17, 79);">Leave
                                        Type</label>
                                </div>
                                <div class="col-8" style="display: flex;flex-direction: column;">
                                    <select id="leaveType" wire:model="leaveType" wire:change="updateLeaveType"
                                        wire:model.lazy="leaveType"
                                        style="font-size: 0.785rem; color: #778899;width: 59%;height: 70%;">
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
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['leaveType'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"
                                        style="color: red;font-size:0.7rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <label for="to-date" style="font-size: 0.785rem;color: rgb(2, 17, 79);">Employee
                                        Type</label>
                                </div>
                                <div class="col-8" style="display: flex;flex-direction: column;">
                                    <select id="employeeType" wire:model="employeeType" wire:change="updateEmployeeType"
                                        wire:model.lazy="employeeType"
                                        style="font-size: 0.785rem; color: #778899;width: 59%;height: 70%;">
                                        <option value="">Select Employee Type</option>
                                        <option value="active">Current Employees</option>
                                        <option value="past">Past Employees</option>

                                        <!-- Add other employee types as needed -->
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['employeeType'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"
                                        style="color: red;font-size:0.7rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <label for="to-date" style="font-size: 0.785rem; rgb(2, 17, 79);">Sort Order</label>
                                </div>
                                <div class="col-8">
                                    <select name="sortBy" wire:model="sortBy" wire:change="updateSortBy"
                                        id="sortBySelect"
                                        style="font-size: 0.785rem; color: #778899;width: 59%;height: 70%;">

                                        <option value="newest_first" selected>Employee Number (Newest First)</option>
                                    </select>
                                </div>
                            </div>


                        </div>


                        <div class="modal-footer mt-2"
                            style="background-color: rgb(2, 17, 79); display: flex;justify-content: space-around;;">
                            <button type="button"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;">Options</button>
                            <button type="button"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;"
                                wire:click="downloadLeaveAvailedReportInExcel">Run</button>
                            <button type="button" data-dismiss="modal"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;"
                                wire:click='resetFields'>Clear</button>

                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
        <?php elseif($currentSection=='Day Wise Leave Transation Report'): ?>
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                        <h5 style="padding: 5px; color: white; font-size: 15px;margin-top:-8px;" class="modal-title">
                            <b><?php echo e($currentSection); ?></b>
                        </h5>
                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close"
                            wire:click="close" style="background-color: white; height:10px;width:10px;">
                        </button>
                    </div>

                    <div class="modal-body" style="max-height:300px;overflow-y:auto;">


                        <div class="date-filters" style="padding: 15px;">
                            <!-- From Date -->
                            <div class="row">
                                <div class="col-4">
                                    <label for="from-date"
                                        style="font-size: 0.785rem; color: rgb(2, 17, 79);">From</label>
                                </div>
                                <div class="col-8" style="display: flex;flex-direction: column;">
                                    <input type="date" id="from-date" wire:model="fromDate" wire:change="updateFromDate"
                                        wire:model.lazy="fromDate"
                                        style="font-size: 0.785rem; color: #778899; margin-right: 10px;width:45%">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fromDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"
                                        style="color: red;font-size:0.7rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                            <!-- To Date -->
                            <div class="row">
                                <div class="col-4">
                                    <label for="to-date" style="font-size: 0.785rem; color: rgb(2, 17, 79);">To</label>
                                </div>
                                <div class="col-8" style="display: flex;flex-direction: column;">
                                    <input type="date" id="to-date" wire:model="toDate" wire:change="updateToDate"
                                        wire:model.lazy="toDate" style="font-size: 0.785rem; color: #778899;width:45%">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['toDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"
                                        style="color: red;font-size:0.7rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <label for="to-date" style="font-size: 0.785rem;color:rgb(2, 17, 79);">Transaction
                                        Type</label>
                                </div>
                                <div class="col-8" style="display: flex;flex-direction: column;">
                                    <select id="transactionType" wire:model="transactionType"
                                        wire:change="updateTransactionType" wire:model.lazy="transactionType"
                                        style="font-size: 0.785rem; color: #778899;width: 59%;height: 70%;">
                                        <option value="all">All </option>
                                        <option value="Loss Of Pay">Availed</option>
                                        <!-- Add other leave types as needed -->
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['transactionType'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"
                                        style="color: red;font-size:0.7rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <label for="to-date" style="font-size: 0.785rem;color: rgb(2, 17, 79);">Employee
                                        Type</label>
                                </div>
                                <div class="col-8" style="display: flex;flex-direction: column;">
                                    <select id="employeeType" wire:model="employeeType" wire:change="updateEmployeeType"
                                        wire:model.lazy="employeeType"
                                        style="font-size: 0.785rem; color: #778899;width: 59%;height: 70%;">
                                        <option value="">Select Employee Type</option>
                                        <option value="active">Current Employees</option>
                                        <option value="past">Past Employees</option>

                                        <!-- Add other employee types as needed -->
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['employeeType'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"
                                        style="color: red;font-size:0.7rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <label for="to-date" style="font-size: 0.785rem; rgb(2, 17, 79);">Sort Order</label>
                                </div>
                                <div class="col-8">
                                    <select name="sortBy" wire:model="sortBy" wire:change="updateSortBy"
                                        id="sortBySelect"
                                        style="font-size: 0.785rem; color: #778899;width: 59%;height: 70%;">

                                        <option value="newest_first" selected>Employee Number (Newest First)</option>
                                    </select>
                                </div>
                            </div>


                        </div>


                        <div class="modal-footer mt-2"
                            style="background-color: rgb(2, 17, 79); display: flex;justify-content: space-around;;">
                            <button type="button"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;">Options</button>
                            <button type="button"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;"
                                wire:click="downloadLeaveAvailedReportInExcel">Run</button>
                            <button type="button" data-dismiss="modal"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;"
                                wire:click='resetFields'>Clear</button>

                        </div>

                    </div>



                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
        <?php elseif($currentSection=='Leave Balance As On A Day'): ?>
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                        <h5 style="padding: 5px; color: white; font-size: 15px;margin-top:-8px;" class="modal-title">
                            <b><?php echo e($currentSection); ?></b>
                        </h5>
                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close"
                            wire:click="close" style="background-color: white; height:10px;width:10px;">
                        </button>
                    </div>

                    <div class="modal-body" style="max-height:300px;overflow-y:auto">

                        <div class="date-filters mt-2">
                            <label for="from-date" style="font-size: 11px; color: #778899;">Date:</label>
                            <input type="date" id="from-date" wire:model="fromDate" wire:change="updatefromDate"
                                style="font-size: 11px; color: #778899; margin-right: 10px;">


                            <div class="search-bar">
                                <input type="text" wire:model="search" placeholder="Search..."
                                    wire:change="searchfilterleave">
                            </div>
                        </div>

                        <table class="swipes-table mt-2 border" style="width: 100%;">
                            <tr style="background-color: #f6fbfc;">
                                <th
                                    style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">
                                    Employee Name</th>
                                <th
                                    style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">
                                    Employee Number</th>

                            </tr>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $filteredEmployees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr style="border:1px solid #ccc;">

                                <td
                                    style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px;white-space:nowrap;">
                                    <input type="checkbox" name="employeeCheckbox[]" class="employee-swipes-checkbox"
                                        wire:model="shiftSummary" wire:change="updateshiftSummary"
                                        value="<?php echo e($emp->emp_id); ?>">
                                    <?php echo e(ucwords(strtolower($emp->first_name))); ?>&nbsp;<?php echo e(ucwords(strtolower($emp->last_name))); ?>

                                </td>
                                <td
                                    style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px;white-space:nowrap;">
                                    <?php echo e($emp->emp_id); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </table>
                            
        <div class="modal-footer mt-2"
                            style="background-color: rgb(2, 17, 79); display: flex;justify-content: space-around;;">
                            <button type="button"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;">Options</button>
                            <button type="button"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;"
                                >Run</button>
                            <button type="button" data-dismiss="modal"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;"
                                wire:click='resetFields'>Clear</button>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
        <?php elseif($currentSection=='Leave Transaction Report'): ?>
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                        <h5 style="padding: 5px; color: white; font-size: 15px;margin-top:-8px;" class="modal-title">
                            <b><?php echo e($currentSection); ?></b>
                        </h5>
                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close"
                            wire:click="close" style="background-color: white; height:10px;width:10px;">
                        </button>
                    </div>


                    <div class="modal-body" style="max-height:300px;overflow-y:auto;">


                        <div class="date-filters" style="padding: 15px;">
                            <!-- From Date -->
                            <div class="row">
                                <div class="col-4">
                                    <label for="from-date"
                                        style="font-size: 0.785rem; color: rgb(2, 17, 79);">From</label>
                                </div>
                                <div class="col-8" style="display: flex;flex-direction: column;">
                                    <input type="date" id="from-date" wire:model="fromDate" wire:change="updateFromDate"
                                        wire:model.lazy="fromDate"
                                        style="font-size: 0.785rem; color: #778899; margin-right: 10px;width:45%">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fromDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"
                                        style="color: red;font-size:0.7rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                            <!-- To Date -->
                            <div class="row">
                                <div class="col-4">
                                    <label for="to-date" style="font-size: 0.785rem; color: rgb(2, 17, 79);">To</label>
                                </div>
                                <div class="col-8" style="display: flex;flex-direction: column;">
                                    <input type="date" id="to-date" wire:model="toDate" wire:change="updateToDate"
                                        wire:model.lazy="toDate" style="font-size: 0.785rem; color: #778899;width:45%">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['toDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"
                                        style="color: red;font-size:0.7rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <label for="to-date" style="font-size: 0.785rem;color:rgb(2, 17, 79);">Leave
                                        Type</label>
                                </div>
                                <div class="col-8" style="display: flex;flex-direction: column;">
                                    <select id="leaveType" wire:model="leaveType" wire:change="updateLeaveType"
                                        wire:model.lazy="leaveType"
                                        style="font-size: 0.785rem; color: #778899;width: 59%;height: 70%;">
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
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['leaveType'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"
                                        style="color: red;font-size:0.7rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <label for="to-date" style="font-size: 0.785rem;color:rgb(2, 17, 79);">Leave
                                        Transaction
                                    </label>
                                </div>
                                <div class="col-8" style="display: flex;flex-direction: column;">
                                    <select id="transactionType" wire:model="transactionType"
                                        wire:change="updateTransactionType" wire:model.lazy="transactionType"
                                        style="font-size: 0.785rem; color: #778899;width: 59%;height: 70%;">
                                        <option value="all">All </option>
                                        <option value="Loss Of Pay">Availed</option>
                                        <!-- Add other leave types as needed -->
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['transactionType'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"
                                        style="color: red;font-size:0.7rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <label for="to-date" style="font-size: 0.785rem;color: rgb(2, 17, 79);">Employee
                                        Type</label>
                                </div>
                                <div class="col-8" style="display: flex;flex-direction: column;">
                                    <select id="employeeType" wire:model="employeeType" wire:change="updateEmployeeType"
                                        wire:model.lazy="employeeType"
                                        style="font-size: 0.785rem; color: #778899;width: 59%;height: 70%;">
                                        <option value="">Select Employee Type</option>
                                        <option value="active">Current Employees</option>
                                        <option value="past">Past Employees</option>

                                        <!-- Add other employee types as needed -->
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['employeeType'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"
                                        style="color: red;font-size:0.7rem;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <label for="to-date" style="font-size: 0.785rem; rgb(2, 17, 79);">Sort Order</label>
                                </div>
                                <div class="col-8">
                                    <select name="sortBy" wire:model="sortBy" wire:change="updateSortBy"
                                        id="sortBySelect"
                                        style="font-size: 0.785rem; color: #778899;width: 59%;height: 70%;">

                                        <option value="newest_first" selected>Employee Number (Newest First)</option>
                                    </select>
                                </div>
                            </div>


                        </div>


                        <div class="modal-footer mt-2"
                            style="background-color: rgb(2, 17, 79); display: flex;justify-content: space-around;;">
                            <button type="button"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;">Options</button>
                            <button type="button"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;"
                                wire:click="downloadLeaveAvailedReportInExcel">Run</button>
                            <button type="button" data-dismiss="modal"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;"
                                wire:click='resetFields'>Clear</button>

                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
<?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/report-management.blade.php ENDPATH**/ ?>