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
            <a class="px-1" wire:click="showContent('Employee Family Details')" data-toggle="modal" data-target="#FamilyDetailsModal" style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px;white-space: nowrap; <?php echo e($currentSection === 'Employee Family Details' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Employee Family Details

            </a>
        </div>
        <div class="d-flex flex-column mb-2" style="line-height:2;">
            <span style="color:#b1b1b1;font-size:12px;" class="mt-2" class="mt-2" class="mt-2">Attendance</span>
            <a class="px-1" wire:click="showContent('Attendance Muster Report')" data-toggle="modal" data-target="#FamilyDetailsModal" style="text-decoration:none;white-space: nowrap; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px; <?php echo e($currentSection === 'Attendance Muster Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Attendance Muster Report

            </a>
            <a class="px-1" wire:click="showContent('Absent Report')" data-toggle="modal" data-target="#FamilyDetailsModal" style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px; <?php echo e($currentSection === 'Absent Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Absent Report

            </a>
            <a class="px-1" wire:click="showContent('Shift Summary Report')" data-toggle="modal" data-target="#FamilyDetailsModal" style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px;white-space: nowrap; <?php echo e($currentSection === 'Shift Summary Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Shift Summary Report

            </a>
            <a class="px-1" wire:click="showContent('Attendance Conslidate Report')" data-toggle="modal" data-target="#FamilyDetailsModal" style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px;white-space: nowrap; <?php echo e($currentSection === 'Attendance Conslidate Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Attendance Conslidate Report

            </a>
            <a class="px-1" wire:click="showContent('Attendance Regularization Report')" data-toggle="modal" data-target="#FamilyDetailsModal" style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px; white-space: nowrap;<?php echo e($currentSection === 'Attendance Regularization Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Attendance Regularization Report

            </a>
        </div>
        <div class="d-flex flex-column mb-2" style="line-height:2;">
            <span style="color:#b1b1b1;font-size:12px;" class="mt-2" class="mt-2" class="mt-2">Leave</span>
            <a class="px-1" wire:click="showContent('Leave Availed Report')" data-toggle="modal" data-target="#FamilyDetailsModal" style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px; white-space: nowrap; <?php echo e($currentSection === 'Leave Availed Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Leave Availed Report

            </a>
            <a class="px-1" wire:click="showContent('Negative Leave Balance')" data-toggle="modal" data-target="#FamilyDetailsModal" style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px;white-space: nowrap; <?php echo e($currentSection === 'Negative Leave Balance' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Negative Leave Balance

            </a>
            <a class="px-1" wire:click="showContent('Day Wise Leave Transation Report')" data-toggle="modal" data-target="#FamilyDetailsModal" style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px;white-space: nowrap; <?php echo e($currentSection === 'Day Wise Leave Transation Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Day Wise Leave Transation Report

            </a>
            <a class="px-1" wire:click="showContent('Leave Balance As On A Day')" data-toggle="modal" data-target="#FamilyDetailsModal" style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px;white-space: nowrap; <?php echo e($currentSection === 'Leave Balance As On A Day' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Leave Balance As On A Day

            </a>
            <a class="px-1" wire:click="showContent('Leave Transaction Report')" data-toggle="modal" data-target="#FamilyDetailsModal" style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px;white-space: nowrap; <?php echo e($currentSection === 'Leave Transaction Report' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : ''); ?>">
                Leave Transaction Report

            </a>
        </div>

        <!--[if BLOCK]><![endif]--><?php if($currentSection=='Employee Family Details'): ?>
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                        <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b><?php echo e($currentSection); ?></b></h5>
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
                        <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b><?php echo e($currentSection); ?></b></h5>
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
                        <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b><?php echo e($currentSection); ?></b></h5>
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
                        <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b><?php echo e($currentSection); ?></b></h5>
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
                        <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b><?php echo e($currentSection); ?></b></h5>
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
                        <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b><?php echo e($currentSection); ?></b></h5>
                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="close" style="background-color: white; height:10px;width:10px;">
                        </button>
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
                        <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b><?php echo e($currentSection); ?></b></h5>
                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="close" style="background-color: white; height:10px;width:10px;">
                        </button>
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
                        <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b><?php echo e($currentSection); ?></b></h5>
                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="close" style="background-color: white; height:10px;width:10px;">
                        </button>
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
                        <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b><?php echo e($currentSection); ?></b></h5>
                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="close" style="background-color: white; height:10px;width:10px;">
                        </button>
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
                        <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b><?php echo e($currentSection); ?></b></h5>
                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="close" style="background-color: white; height:10px;width:10px;">
                        </button>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/report-management.blade.php ENDPATH**/ ?>