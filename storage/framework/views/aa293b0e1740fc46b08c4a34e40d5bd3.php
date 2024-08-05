<div>
    <!--[if BLOCK]><![endif]--><?php if($errorMessage): ?>
    <div id="errorMessage" class="alert alert-danger">
        <?php echo e($errorMessage); ?>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <div class="applyContainer bg-white">
        <!--[if BLOCK]><![endif]--><?php if($showinfoMessage): ?>
        <div class="hide-leave-info p-2 px-2 mb-2 mt-2 rounded d-flex justify-content-between align-items-center">
            <p class="mb-0" style="font-size:10px;">Leave is earned by an employee and granted by the employer to take time off work. The employee is free to<br>
                avail this leave in accordance with the company policy.</p>
            <p class="mb-0 hideInfo" wire:click="toggleInfo">Hide</p>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <div class="d-flex justify-content-between">
            <p class="applyingFor">Applying for Leave</p>
            <!--[if BLOCK]><![endif]--><?php if($showinfoButton): ?>
            <p class="info-paragraph" wire:click="toggleInfo">Info</p>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <form wire:submit.prevent="leaveApply" enctype="multipart/form-data">
            <div class="row d-flex align-items-center">
                <div class="col-md-7">
                    <div class="form-group ">
                        <label for="leaveType" style="color: #778899; font-size: 12px; font-weight: 500;">Leave Type <span class="requiredMark">*</span> </label> <br>
                        <div class="custom-select-wrapper" style="width: 50%;">
                            <select id="leaveType" class="form-control outline-none rounded placeholder-small" wire:click="selectLeave" wire:model.lazy="leave_type" wire:keydown.debounce.500ms="validateField('leave_type')" name="leaveType">
                                <option value="default">Select Type</option>
                                <option value="Casual Leave">Casual Leave</option>
                                <!--[if BLOCK]><![endif]--><?php if(($differenceInMonths < 6)): ?> <option value="Casual Leave Probation">Casual Leave Probation</option>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <option value="Loss of Pay">Loss of Pay</option>
                                    <option value="Marriage Leave">Marriage Leave</option>
                                    <!--[if BLOCK]><![endif]--><?php if($employeeGender && $employeeGender->gender === 'Female'): ?>
                                    <option value="Maternity Leave">Maternity Leave</option>
                                    <?php else: ?>
                                    <option value="Paternity Leave">Paternity Leave</option>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <option value="Sick Leave">Sick Leave</option>
                            </select>
                        </div>
                        <br>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['leave_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="pay-bal">
                            <span style=" font-size: 12px; font-weight: 500;color:#778899;">Balance :</span>
                            <!--[if BLOCK]><![endif]--><?php if(!empty($leaveBalances)): ?>
                            <div style="flex-direction:row; display: flex; align-items: center;justify-content:center;cursor:pointer;">
                                <!--[if BLOCK]><![endif]--><?php if($leave_type == 'Sick Leave'): ?>
                                <!-- Sick Leave -->
                                <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #e6e6fa; display: flex; align-items: center; justify-content: center; ">
                                    <span style="font-size: 10px; color: #50327c;font-weight:500;">SL</span>
                                </div>
                                <span style="font-size: 11px; font-weight: 500; color: #50327c; margin-left: 5px;" title="Sick Leave"><?php echo e($leaveBalances['sickLeaveBalance']); ?></span>
                                <?php elseif($leave_type == 'Casual Leave'): ?>
                                <!-- Casual Leave -->
                                <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #e7fae7; display: flex; align-items: center; justify-content: center; ">
                                    <span style="font-size: 10px; color: #1d421e;font-weight:500;">CL</span>
                                </div>
                                <span style="font-size: 11px; font-weight: 500; color: #1d421e; margin-left: 5px;" title="Casual Leave"><?php echo e($leaveBalances['casualLeaveBalance']); ?></span>
                                <?php elseif($leave_type == 'Casual Leave Probation'): ?>
                                <!-- Casual Leave Probation -->
                                <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #fff6e5; display: flex; align-items: center; justify-content: center; ">
                                    <span style="font-size: 9px; color: #e59400;font-weight:500;" title="Casual Leave Probation">CLP</span>
                                </div>
                                <span style="font-size: 11px; font-weight: 500; color: #1d421e; margin-left: 5px;"><?php echo e($leaveBalances['casualProbationLeaveBalance']); ?></span>
                                <?php elseif($leave_type == 'Loss of Pay'): ?>
                                <!-- Loss of Pay -->
                                <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; ">
                                    <span style="font-size: 10px; color: #890000;font-weight:500;" title="Loss of Pay">LP</span>
                                </div>
                                <span style="font-size: 11px; font-weight: 500; color: #890000; margin-left: 5px;"><?php echo e($leaveBalances['lossOfPayBalance']); ?></span>
                                <?php elseif($leave_type == 'Maternity Leave'): ?>
                                <!-- Loss of Pay -->
                                <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; ">
                                    <span style="font-size: 10px; color: #890000;font-weight:500;" title="Maternity Leave">ML</span>
                                </div>
                                <span style="font-size: 11px; font-weight: 500; color: #890000; margin-left: 5px;"><?php echo e($leaveBalances['maternityLeaveBalance']); ?></span>
                                <?php elseif($leave_type == 'Paternity Leave'): ?>
                                <!-- Loss of Pay -->
                                <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; ">
                                    <span style="font-size: 10px; color: #890000;font-weight:500;" title="Paternity Leave">PL</span>
                                </div>
                                <span style="font-size: 11px; font-weight: 500; color: #890000; margin-left: 5px;"><?php echo e($leaveBalances['paternityLeaveBalance']); ?></span>
                                <?php elseif($leave_type == 'Marriage Leave'): ?>
                                <!-- Loss of Pay -->
                                <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; ">
                                    <span style="font-size: 10px; color: #890000;font-weight:500;" title="Marriage Leave">MRL</span>
                                </div>
                                <span style="font-size: 11px; font-weight: 500; color: #890000; margin-left: 5px;"><?php echo e($leaveBalances['marriageLeaveBalance']); ?></span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        </div>
                        <div class="form-group mb-0">
                            <label for="numberOfDays" style="color: #778899; font-size: 12px; font-weight: 500;">Number of Days :</label>
                            <!--[if BLOCK]><![endif]--><?php if($showNumberOfDays): ?>
                            <span id="numberOfDays" style="font-size: 12px;color:#778899;">
                                <!-- Display the calculated number of days -->
                                <?php echo e($this->calculateNumberOfDays($from_date, $from_session, $to_date, $to_session)); ?>

                            </span>
                            <!-- Add a condition to check if the number of days exceeds the leave balance -->
                            <!--[if BLOCK]><![endif]--><?php if(!empty($leaveBalances)): ?>
                            <!-- Directly access the leave balance for the selected leave type -->
                            <?php
                            $calculatedNumberOfDays = $this->calculateNumberOfDays($from_date, $from_session, $to_date, $to_session);
                            ?>
                            <!--[if BLOCK]><![endif]--><?php if($leave_type == 'Casual Leave Probation'): ?>
                            <!-- Casual Leave Probation -->
                            <!--[if BLOCK]><![endif]--><?php if($calculatedNumberOfDays > $leaveBalances['casualProbationLeaveBalance']): ?>
                            <!-- Display an error message if the number of days exceeds the leave balance -->
                            <div class="error-message" style="position: absolute;  left: 0;">
                                <span style="color: red; font-weight: normal;font-size:12px;">Insufficient leave balance</span>
                            </div>
                            <?php
                            $insufficientBalance = true; ?>
                            <?php else: ?>
                            <span></span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <?php elseif($leave_type == 'Casual Leave'): ?>
                            <!-- Casual Leave Probation -->
                            <!--[if BLOCK]><![endif]--><?php if($calculatedNumberOfDays > $leaveBalances['casualLeaveBalance']): ?>
                            <!-- Display an error message if the number of days exceeds the leave balance -->
                            <div class="error-message" style="position: absolute;  left: 0;">
                                <span style="color: red; font-weight: normal;font-size:12px;">Insufficient leave balance</span>
                            </div>
                            <?php
                            $insufficientBalance = true; ?>
                            <?php else: ?>
                            <span></span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php elseif($leave_type == 'Sick Leave'): ?>
                            <!-- Casual Leave Probation -->
                            <!--[if BLOCK]><![endif]--><?php if($calculatedNumberOfDays > $leaveBalances['sickLeaveBalance']): ?>
                            <!-- Display an error message if the number of days exceeds the leave balance -->
                            <div class="error-message" style="position: absolute;  left: 0;">
                                <span style="color: red; font-weight: normal;font-size:12px;">Insufficient leave balance</span>
                            </div>
                            <?php
                            $insufficientBalance = true; ?>
                            <?php else: ?>
                            <span></span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php elseif($leave_type == 'Maternity Leave'): ?>
                            <!-- Casual Leave Probation -->
                            <!--[if BLOCK]><![endif]--><?php if($calculatedNumberOfDays > $leaveBalances['maternityLeaveBalance']): ?>
                            <!-- Display an error message if the number of days exceeds the leave balance -->
                            <div class="error-message" style="position: absolute;  left: 0;">
                                <span style="color: red; font-weight: normal;font-size:12px;">Insufficient leave balance</span>
                            </div>
                            <?php
                            $insufficientBalance = true; ?>
                            <?php else: ?>
                            <span></span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php elseif($leave_type == 'Paternity Leave'): ?>
                            <!-- Casual Leave Probation -->
                            <!--[if BLOCK]><![endif]--><?php if($calculatedNumberOfDays > $leaveBalances['paternityLeaveBalance']): ?>
                            <!-- Display an error message if the number of days exceeds the leave balance -->
                            <div class="error-message" style="position: absolute;  left: 0;">
                                <span style="color: red; font-weight: normal;font-size:12px;">Insufficient leave balance</span>
                            </div>
                            <?php
                            $insufficientBalance = true; ?>
                            <?php else: ?>
                            <span></span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php elseif($leave_type == 'Marriage Leave'): ?>
                            <!-- Casual Leave Probation -->
                            <!--[if BLOCK]><![endif]--><?php if($calculatedNumberOfDays > $leaveBalances['marriageLeaveBalance']): ?>
                            <!-- Display an error message if the number of days exceeds the leave balance -->
                            <div class="error-message" style="position: absolute;  left: 0;">
                                <span style="color: red; font-weight: normal;font-size:12px;">Insufficient leave balance</span>
                            </div>
                            <?php
                            $insufficientBalance = true; ?>
                            <?php else: ?>
                            <span></span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <!-- end of leavevtyopes -->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php else: ?>
                            <span class="normalText">0</span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                    </div>
                </div>
            </div>
            <div class="row d-flex mt-1">
                <div class="col-md-6">
                    <div class="form-group ">
                        <label for="fromDate" style="color: #778899; font-size: 12px; font-weight: 500;">From Date <span class="requiredMark">*</span> </label>
                        <input type="date" wire:model.lazy="from_date" wire:keydown.debounce.500ms="validateField('from_date')" class="form-control placeholder-small" id="fromDate" name="fromDate" style="color: #778899;font-size:12px;" wire:change="handleFieldUpdate('from_date')">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['from_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group ">
                        <label for="session" style="color: #778899; font-size: 12px; font-weight: 500;">Session</label> <br>
                        <div class="custom-select-wrapper">
                            <select class="form-control outline-none rounded placeholder-small" wire:model.lazy="from_session" wire:keydown.debounce.500ms="validateField('from_session')" name="session" style="font-size:12px;" wire:change="handleFieldUpdate('from_session')">
                                <option value="Session 1">Session 1</option>
                                <option value="Session 2">Session 2</option>
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['from_session'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>
            </div>
            <div class=" row d-flex mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="toDate" style="color: #778899; font-size: 12px; font-weight: 500;">To Date <span class="requiredMark">*</span> </label>
                        <input type="date" wire:model.lazy="to_date" class="form-control placeholder-small" wire:keydown.debounce.500ms="validateField('to_date')" name="toDate" style="color: #778899;font-size:12px;" wire:change="handleFieldUpdate('to_date')">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['to_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group ">
                        <label for="session" style="color: #778899; font-size: 12px; font-weight: 500;">Session</label> <br>
                        <div class="custom-select-wrapper">
                            <select class="form-control outline-none rounded placeholder-small" wire:model.lazy="to_session" wire:keydown.debounce.500ms="validateField('to_session')" name="session" style="font-size:12px;" wire:change="handleFieldUpdate('to_session')">
                                <option value="Session 1">Session 1</option>
                                <option value="Session 2">Session 2</option>
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['to_session'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <!--[if BLOCK]><![endif]--><?php if($showApplyingTo): ?>
                <div class="form-group mt-3" style="margin-top: 10px;">
                    <div style="display:flex; flex-direction:row;" wire:click="applyingTo">
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
                                            <i style="color:#fff;" class="bx bx-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 m-0 p-0">
                                <button wire:click="applyingTo" type="button" class="close rounded px-1 py-0" aria-label="Close" style="background-color: rgb(2,17,79);height:33px;width:33px;">
                                    <span aria-hidden="true" style="color: white; font-size: 24px;"><i class="bx bx-x"></i>
                                    </span>
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
                <label for="ccToText" id="applyingToText" name="applyingTo" style="color: #778899; font-size: 12px; font-weight: 500;">
                    CC To
                </label>
                <div class="control-wrapper d-flex align-items-center" style="flex-direction: row; gap: 10px;cursor:pointer;">
                    <a class="text-3 text-secondary control" aria-haspopup="true" wire:click="openCcRecipientsContainer" style="text-decoration: none;">
                        <div class="icon-container">
                            <i class="bx bx-plus" style="color: #778899;"></i>
                        </div>
                    </a>
                    <!-- Blade Template: your-component.blade.php -->
                    <span class="addText" wire:click="openCcRecipientsContainer">Add</span>

                    <!--[if BLOCK]><![endif]--><?php if(count($selectedCCEmployees) > 0): ?>
                    <ul class=" d-flex align-items-center mb-0" style="list-style-type: none;gap:10px;">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $selectedCCEmployees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recipient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <div class="px-2 py-1 " style=" border-radius: 25px; border: 2px solid #adb7c1; display: flex; justify-content: space-between; align-items: center;" title="<?php echo e(ucwords(strtolower( $recipient['first_name']))); ?> <?php echo e(ucwords(strtolower( $recipient['last_name']))); ?>">
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
                                        <i style="margin-right: 5px;" class="bx bx-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 m-0 p-0">
                            <button wire:click="closeCcRecipientsContainer" type="button" class="close rounded px-1 py-0" aria-label="Close" style="background-color: rgb(2,17,79);height:33px;width:33px;">
                                <span aria-hidden="true" style="color: white; font-size: 24px;"><i class="bx bx-x"></i></span>
                            </button>
                        </div>
                    </div>
                    <div class="scrollApplyingTO mb-2 mt-2">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $ccRecipients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div wire:key="<?php echo e($employee['emp_id']); ?>">
                            <div style="margin-top: 10px; display: flex; gap: 10px; text-transform: capitalize; align-items: center; cursor: pointer;" wire:click="toggleSelection('<?php echo e($employee['emp_id']); ?>')">
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
                        </divclass>
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
                    <label for="contactDetails" style="color: #778899; font-size: 12px; font-weight: 500;">Contact Details <span class="requiredMark">*</span> </label>
                    <input type="text" wire:model.lazy="contact_details" class="form-control placeholder-small" wire:keydown.debounce.500ms="validateField('contact_details')" name="contactDetails" style="color: #778899;width:50%;font-size:13px;">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['contact_details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div class="form-group mt-3">
                    <label for="reason" style="color: #778899; font-size: 12px; font-weight: 500;">Reason <span class="requiredMark">*</span> </label>
                    <textarea class="form-control placeholder-small" wire:model.lazy="reason" wire:keydown.debounce.500ms="validateField('reason')" name="reason" placeholder="Enter a reason" rows="4" style="color: #778899;font-size:13px;"></textarea>
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div class="form-group mt-3">
                    <input type="file" wire:model="files" wire:loading.attr="disabled" style="font-size: 12px;color:#778899;" multiple />
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['file_paths'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <div class="buttons-leave">
                    <button type="submit" class=" submit-btn" <?php if(isset($insufficientBalance)): ?> disabled <?php endif; ?>>Submit</button>
                    <button type="button" class=" cancel-btn" wire:click="cancelLeaveApplication" style="border:1px solid rgb(2, 17, 79);">Cancel</button>
                </div>
        </form>
    </div>
</div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/leave-apply.blade.php ENDPATH**/ ?>