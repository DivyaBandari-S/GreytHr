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
                        <label for="applyingToText" id="applyingToText" name="applyingTo" style="color: #778899; font-size: 12px; font-weight: 500; cursor: pointer;">
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

                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $ccRecipients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="display:flex; gap:10px;" onclick="addEmail('<?php echo e($employee['full_name']); ?>')">
                        <input type="checkbox" wire:model="selectedPeople" value="<?php echo e($employee['emp_id']); ?>">
                        <img src="<?php echo e($employee['image'] ? $employee['image'] : 'https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars.png'); ?>" alt="User Image" style="width: 40px; height: 40px; border-radius: 50%;">
                        <div class="center">
                            <p style="font-size: 0.875rem; font-weight: 500;"><?php echo e($employee['full_name']); ?></p>
                            <p style="margin-top: -15px; color: #778899; font-size: 0.69rem;">#<?php echo e($employee['emp_id']); ?></p>
                        </div>

                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
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
                <label for="reason" style="color: #778899; font-size: 12px; font-weight: 500;">Reason for Leave</label>
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

            <div class="cancelButtons d-flex align-items-center gap-2 justify-content-center">
                <button type="submit" class="submit-btn">Submit</button>
                <button type="button" class="cancel-btn" style="border:1px solid rgb(2,17,79);">Cancel</button>
            </div>
        </form>
    </div>
</div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/leave-cancel.blade.php ENDPATH**/ ?>