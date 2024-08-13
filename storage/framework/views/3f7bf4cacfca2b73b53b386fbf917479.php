<div>
    <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
    <div id="successMessage" class="alert alert-success">
        <?php echo e(session('message')); ?>

    </div>
    <?php elseif(session()->has('error')): ?>
    <div id="errorMessage" class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

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
        <!--[if BLOCK]><![endif]--><?php if($LeaveShowinfoMessage): ?>
        <div class="hide-info p-2 mb-2 mt-2 rounded d-flex justify-content-between align-items-center">
            <p class="mb-0" style="font-size:11px;">Leave Cancel enables you to apply for cancellation of approved leave applications. Please select a leave type to get started..</p>
            <p class="mb-0 hideInfo" wire:click="toggleInfoLeave">Hide</p>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <div class="d-flex justify-content-between">
            <p class="applyingFor">Applying for Leave Cancel</p>
            <!--[if BLOCK]><![endif]--><?php if($LeaveShowinfoButton): ?>
            <p class="info-paragraph" wire:click="toggleInfoLeave">Info</p>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
                            <!--[if BLOCK]><![endif]--><?php if($cancelLeaveRequests && $cancelLeaveRequests->count() > 0): ?>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $cancelLeaveRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leaveRequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td wire:click="applyingTo(<?php echo e($leaveRequest->id); ?>)"><input type="radio" name="leaveType"></td>
                                <td><?php echo e($leaveRequest->leave_type); ?></td>
                                <td><?php echo e($leaveRequest->from_date->format('d M, Y')); ?></td>
                                <td><?php echo e($leaveRequest->to_date->format('d M, Y')); ?></td>
                                <td><?php echo e($this->calculateNumberOfDays($leaveRequest->from_date, $leaveRequest->from_session, $leaveRequest->to_date, $leaveRequest->to_session)); ?></td>
                                <td><?php echo e($leaveRequest->reason); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            <?php else: ?>
                            <tr>
                                <td colspan="6">
                                    No data found.
                                </td>
                            </tr>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>
                    </table>
                </div>

                <!--[if BLOCK]><![endif]--><?php if($showApplyingTo): ?>
                <div class="form-group mt-3" style="margin-top: 10px;">
                    <div style="display:flex; flex-direction:row;">
                        <label for="applyingToText" id="applyingToText" name="applyingTo" style="cursor: pointer;">
                            <img src="https://t4.ftcdn.net/jpg/05/35/51/31/360_F_535513106_hwSrSN1TLzoqdfjWpv1zWQR9Y5lCen6q.jpg" alt="" width="35px" height="32px" style="border-radius:50%;color:#778899;">
                            Applying To
                        </label>
                    </div>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <!-- Your Blade file -->
                <!--[if BLOCK]><![endif]--><?php if($show_reporting): ?>
                <div class="form-group mt-3">
                    <label for="applyingTo"> Applying To</label>
                </div>
                <div class="reporting mb-2" wire:ignore.self>
                    <!--[if BLOCK]><![endif]--><?php if(!$loginEmpManagerProfile): ?>
                    <div class="employee-profile-image-container">
                        <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" class="employee-profile-image-placeholder" style="border-radius:50%;" height="40" width="40" alt="Default Image">
                    </div>
                    <?php elseif($managerDetails): ?>
                    <div class="employee-profile-image-container">
                        <img height="40" width="40" src="<?php echo e(asset('storage/' . $managerDetails->image)); ?>" style="border-radius:50%;">
                    </div>
                    <?php else: ?>
                    <div class="employee-profile-image-container">
                        <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" class="employee-profile-image-placeholder" style="border-radius:50%;" height="40" width="40" alt="Default Image">
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <div class="center p-0 m-0">
                        <!--[if BLOCK]><![endif]--><?php if(!$loginEmpManager): ?>
                        <p class="mb-0" style="font-size:10px;margin-bottom:0;">N/A</p>
                        <?php else: ?>
                        <p id="reportToText" class="ellipsis mb-0"><?php echo e(ucwords(strtolower($loginEmpManager))); ?></p>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <!--[if BLOCK]><![endif]--><?php if(!$loginEmpManagerId): ?>
                        <p class="mb-0" style="font-size:10px;margin-bottom:0;">#(N/A)</p>
                        <?php else: ?>
                        <p class="mb-0" style="color:#778899; font-size:10px;margin-bottom:0;" id="managerIdText"><span class="remaining">#<?php echo e($loginEmpManagerId); ?></span></p>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div class="downArrow" wire:click="applyingTo">
                        <i class="fas fa-chevron-down" style="cursor:pointer"></i>
                    </div>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                <!--[if BLOCK]><![endif]--><?php if($showApplyingToContainer): ?>
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
                        <!--[if BLOCK]><![endif]--><?php if(!empty($managerFullName)): ?>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $managerFullName; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="d-flex gap-4 align-items-center" style="cursor: pointer; <?php if(in_array($employee['emp_id'], $selectedManager)): ?> background-color: #d6dbe0; <?php endif; ?>" wire:click="toggleManager('<?php echo e($employee['emp_id']); ?>')" wire:key="<?php echo e($employee['emp_id']); ?>">
                            <!--[if BLOCK]><![endif]--><?php if($employee['image']): ?>
                            <div class="employee-profile-image-container">
                                <img height="35px" width="35px" src="<?php echo e(asset('storage/' . $employee['image'])); ?>" style="border-radius:50%;">
                            </div>
                            <?php else: ?>
                            <div class="employee-profile-image-container">
                                <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" class="employee-profile-image-placeholder" style="border-radius:50%;" height="35px" width="35px" alt="Default Image">
                            </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <div class="center d-flex flex-column mt-2 mb-2">
                                <span class="ellipsis mb-0" value="<?php echo e($employee['full_name']); ?>"><?php echo e($employee['full_name']); ?></span>
                                <span class="mb-0" style="color:#778899; font-size:10px;margin-bottom:0;" value="<?php echo e($employee['full_name']); ?>"> #<?php echo e($employee['emp_id']); ?> </span>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        <?php else: ?>
                        <p>No managers found.</p>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['applying_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="form-group mt-3">
                <label for="ccToText" id="applyingToText" name="applyingTo">
                    CC To
                </label>
                <div class="control-wrapper d-flex align-items-center" style="gap: 10px;cursor:pointer;">
                    <a class="text-3 text-secondary control" aria-haspopup="true" wire:click="openCcRecipientsContainer" style="text-decoration: none;">
                        <div class="icon-container">
                            <i class="fas fa-plus" style="color: #778899;"></i>
                        </div>
                    </a>
                    <!-- Blade Template: your-component.blade.php -->
                    <span class="addText" wire:click="openCcRecipientsContainer">Add</span>

                    <!--[if BLOCK]><![endif]--><?php if(count($selectedCCEmployees) > 0): ?>
                    <ul class=" d-flex align-items-center mb-0" style="list-style-type: none;gap:10px;">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $selectedCCEmployees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recipient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <div class="px-2 py-1 d-flex justify-content-between align-items-center" style=" border-radius: 25px; border: 2px solid #adb7c1;" title="<?php echo e(ucwords(strtolower( $recipient['first_name']))); ?> <?php echo e(ucwords(strtolower( $recipient['last_name']))); ?>">
                                <span style="text-transform: uppercase; color: #adb7c1;font-size:12px;"><?php echo e($recipient['initials']); ?></span>
                                <i class="fas fa-times-circle cancel-icon d-flex align-items-center justify-content-end" style="cursor: pointer;color:#adb7c1;" wire:click="removeFromCcTo('<?php echo e($recipient['emp_id']); ?>')"></i>
                            </div>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </ul>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <!--[if BLOCK]><![endif]--><?php if($showCcRecipents): ?>
                <div class="ccContainer" x-data="{ open: <?php if ((object) ('showCcRecipents') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showCcRecipents'->value()); ?>')<?php echo e('showCcRecipents'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showCcRecipents'); ?>')<?php endif; ?> }" x-cloak @click.away="open = false">
                    <div class="row m-0 p-0 d-flex align-items-center justify-content-between" style="padding: 0 ; margin:0;">
                        <div class="col-md-10" style="margin: 0px; padding: 0px">
                            <div class="input-group">
                                <input wire:model.debounce.500ms="searchTerm" wire:input="searchCCRecipients" id="searchInput" style="font-size: 12px; border-radius: 5px 0 0 5px; cursor: pointer; width:50%;" type="text" class="form-control placeholder-small" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1" wire:keydown.enter.prevent="handleEnterKey">
                                <div class="input-group-append searchBtnBg d-flex align-items-center">
                                    <button type="button" wire:click="searchCCRecipients" class="search-btn">
                                        <i style="margin-right: 5px;" class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 m-0 p-0">
                            <button wire:click="closeCcRecipientsContainer" type="button" class="close rounded px-1 py-0" aria-label="Close" style="background-color: rgb(2,17,79);height:33px;width:33px;">
                                <span aria-hidden="true" style="color: white; font-size: 24px;"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                    </div>
                    <div class="scrollApplyingTO mb-2 mt-2">
                        <!--[if BLOCK]><![endif]--><?php if(!empty($ccRecipients)): ?>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $ccRecipients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div wire:key="<?php echo e($employee['emp_id']); ?>">
                            <div class="d-flex align-items-center mt-2 align-items-center" style=" gap: 10px; text-transform: capitalize; cursor: pointer;" wire:click="toggleSelection('<?php echo e($employee['emp_id']); ?>')">
                                <input type="checkbox" wire:model="selectedPeople.<?php echo e($employee['emp_id']); ?>" style="margin-right: 10px; cursor:pointer;" wire:click="handleCheckboxChange('<?php echo e($employee['emp_id']); ?>')">

                                <!--[if BLOCK]><![endif]--><?php if($employee['image']): ?>
                                <div class="employee-profile-image-container">
                                    <img height="35px" width="35px" src="<?php echo e(asset('storage/' . $employee['image'])); ?>" style="border-radius: 50%;">
                                </div>
                                <?php else: ?>
                                <div class="employee-profile-image-container">
                                    <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" class="employee-profile-image-placeholder" style="border-radius: 50%;" height="35px" width="35px" alt="Default Image">
                                </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                <div class="center mb-2 mt-2">
                                    <p class="mb-0 empCcName"><?php echo e(ucwords(strtolower($employee['full_name']))); ?></p>
                                    <p class="mb-0 empIdStyle">#<?php echo e($employee['emp_id']); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        <?php else: ?>
                        <div class="mb-0 normalTextValue">
                            No data found
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['cc_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="form-group mt-3">
                <label for="reason">Reason for Leave</label>
                <textarea class="form-control placeholder-small" wire:model="reason" id="reason" name="reason" placeholder="Enter Reason" rows="4"></textarea>
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <div class="cancelButtons d-flex align-items-center gap-2 justify-content-center mt-4">
                <button type="submit" class="submit-btn">Submit</button>
                <button type="button" class="cancel-btn" style="border:1px solid rgb(2,17,79);">Cancel</button>
            </div>
        </form>
    </div>
</div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/leave-cancel.blade.php ENDPATH**/ ?>