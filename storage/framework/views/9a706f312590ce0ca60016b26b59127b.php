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
        <div class="hide-leave-info p-2 px-2 mb-2 mt-2 rounded d-flex gap-2 align-items-center">
            <p class="mb-0" style="font-size:10px;">Leave is earned by an employee and granted by the employer to take time off work. The employee is free to
                avail this leave in accordance with the company policy.</p>
            <p class="mb-0 hideInfo" wire:click="toggleInfo">Hide</p>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <div class="d-flex justify-content-between">
            <p class="applyingFor">Applying for Leave</p>
            <!--[if BLOCK]><![endif]--><?php if($showinfoButton): ?>
            <p class="info-paragraph mb-0" wire:click="toggleInfo">Info</p>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
                            <span class="normalTextValue">Balance :</span>
                            <!--[if BLOCK]><![endif]--><?php if(!empty($leaveBalances)): ?>
                            <div class="d-flex align-items-center justify-content-center" style="cursor:pointer;">
                                <!--[if BLOCK]><![endif]--><?php if($leave_type == 'Sick Leave'): ?>
                                <!-- Sick Leave -->
                                <span class="sickLeaveBalance" title="Sick Leave"><?php echo e($leaveBalances['sickLeaveBalance']); ?></span>
                                <?php elseif($leave_type == 'Casual Leave'): ?>
                                <!-- Casual Leave -->
                                <span class="sickLeaveBalance" title="Casual Leave"><?php echo e($leaveBalances['casualLeaveBalance']); ?></span>
                                <?php elseif($leave_type == 'Casual Leave Probation'): ?>
                                <!-- Casual Leave Probation -->
                                <span class="sickLeaveBalance"><?php echo e($leaveBalances['casualProbationLeaveBalance']); ?></span>
                                <?php elseif($leave_type == 'Loss of Pay'): ?>
                                <!-- Loss of Pay -->
                                <span class="sickLeaveBalance"><?php echo e($leaveBalances['lossOfPayBalance']); ?></span>
                                <?php elseif($leave_type == 'Maternity Leave'): ?>
                                <!-- Loss of Pay -->
                                <span class="sickLeaveBalance"><?php echo e($leaveBalances['maternityLeaveBalance']); ?></span>
                                <?php elseif($leave_type == 'Paternity Leave'): ?>
                                <!-- Loss of Pay -->
                                <span class="sickLeaveBalance"><?php echo e($leaveBalances['paternityLeaveBalance']); ?></span>
                                <?php elseif($leave_type == 'Marriage Leave'): ?>
                                <!-- Loss of Pay -->
                                <span class="sickLeaveBalance"><?php echo e($leaveBalances['marriageLeaveBalance']); ?></span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        </div>
                        <div class="form-group mb-0">
                            <span class="normalTextValue">Number of Days :</span>
                            <!--[if BLOCK]><![endif]--><?php if($showNumberOfDays): ?>
                            <span id="numberOfDays" class="sickLeaveBalance">
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
                            <div class="error-message" style="position: absolute;  left: 10;">
                                <span class="Insufficient">Insufficient leave balance</span>
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
                            <div class="error-message" style="position: absolute;  left: 10;">
                                <span class="Insufficient">Insufficient leave balance</span>
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
                            <div class="error-message" style="position: absolute;  left: 10;">
                                <span class="Insufficient">Insufficient leave balance</span>
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
                            <div class="error-message" style="position: absolute;  left: 10;">
                                <span class="Insufficient">Insufficient leave balance</span>
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
                            <div class="error-message" style="position: absolute;  left: 10;">
                                <span class="Insufficient">Insufficient leave balance</span>
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
                            <div class="error-message" style="position: absolute;  left: 10;">
                                <span class="Insufficient">Insufficient leave balance</span>
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
            <div class="form-group mt-3">
                <label for="contactDetails">Contact Details <span class="requiredMark">*</span> </label>
                <input id="contactDetails" type="text" wire:model.lazy="contact_details" class="form-control placeholder-small" wire:keydown.debounce.500ms="validateField('contact_details')" name="contactDetails" style="width:50%;">
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
                <label for="reason">Reason <span class="requiredMark">*</span> </label>
                <textarea id="reason" class="form-control placeholder-small" wire:model.lazy="reason" wire:keydown.debounce.500ms="validateField('reason')" name="reason" placeholder="Enter a reason" rows="4"></textarea>
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
                <label for="file">Attachement </label> <br>
                <input id="file" type="file" wire:model="files" wire:loading.attr="disabled" style="font-size: 12px;" multiple />
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
</div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/leave-apply-page.blade.php ENDPATH**/ ?>