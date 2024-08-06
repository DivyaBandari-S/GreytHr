<div>
    <style>
        .form-label {
            color: #778899;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .btn-add-row {
            background-color: rgb(2,17,79);
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.75rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-save {
            background-color: #17a2b8;
            color: #fff;
            border: none;
            padding: 5px 10px;
            font-size: 0.75rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-send-email, .btn-send-after {
            background-color: rgb(2,17,79);
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 0.75rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-updated:active, .btn-add-row:active, .btn-save:active, .btn-send-email:active, .btn-send-after:active {
            background-color: #0056b3;
        }

        .text-danger {
            font-size: 12px;
        }

        .toAddress {
            font-size: 0.785rem;
        }
    </style>

    <div class="row m-0 p-0">
        <!-- Left column: Table -->
        <div class="col-9">
            <div class="p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <h6>Client Data</h6>
                    <p class="mb-0 text-red">Note : <span>This Data will be sent to client on Friday: <?php echo e($nextFridayDate); ?></span></p>
                </div>
                <div class="table-frame px-2 py-1">
                    <div class="table-container">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width:40px;">#</th>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = ['employee_name', 'employee_title', 'project_title', 'employee_email', 'work_location', 'project_manager', 'access_network', 'po_number', 'hourly_paid', 'mark_up', 'hourly_max', 'start_date', 'sow_end_date', 'background_check', 'on_site_resource', 'vaccination_status']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th style="width:150px;"><?php echo e(str_replace('_', ' ', ucfirst($field))); ?></th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <th style="width:100px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $dataEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="width:40px;"><?php echo e($index + 1); ?></td>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = ['employee_name', 'employee_title', 'project_title', 'employee_email', 'work_location', 'project_manager', 'access_network', 'po_number', 'hourly_paid', 'mark_up', 'hourly_max', 'start_date', 'sow_end_date', 'background_check', 'on_site_resource', 'vaccination_status']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td wire:click="editCell(<?php echo e($index); ?>, '<?php echo e($field); ?>')" class="table-cell" style="width:150px;">
                                        <!--[if BLOCK]><![endif]--><?php if($editIndex === $index && $editField === $field): ?>
                                        <!--[if BLOCK]><![endif]--><?php if(in_array($field, ['start_date', 'sow_end_date'])): ?>
                                        <!-- Check if field is a date field -->
                                        <input type="date" class="form-control" wire:model="dataEntries.<?php echo e($index); ?>.<?php echo e($field); ?>" wire:blur="updateRow(<?php echo e($index); ?>)">
                                        <?php else: ?>
                                        <input type="text" class="form-control" wire:model="dataEntries.<?php echo e($index); ?>.<?php echo e($field); ?>" wire:blur="updateRow(<?php echo e($index); ?>)">
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php else: ?>
                                        <!--[if BLOCK]><![endif]--><?php if(in_array($field, ['start_date', 'sow_end_date'])): ?>
                                        <?php echo e(isset($entry[$field]) ? \Carbon\Carbon::parse($entry[$field])->format('d M, Y') : ''); ?>

                                        <?php else: ?>
                                        <?php echo e($entry[$field]); ?>

                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                                    <td class="action-buttons" style="width:50px;">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button class="btn-update" wire:click="updateRow(<?php echo e($index); ?>)" style="font-size: 0.65rem;padding:1px 5px;">
                                                Update
                                            </button>
                                            <button class="btn-delete" wire:click="deleteRow(<?php echo e($index); ?>)" style="font-size: 0.65rem;padding:1px 5px;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center align-items-center gap-3">
                    <button wire:click="addRow" class="btn-add-row">Add Row</button>
                    <button wire:click="save" class="btn-save">Save</button>
                </div>
            </div>
        </div>
        <!-- Right column: Email fields -->
        <div class="col-3 mt-4">
            <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="myAlert">
                <?php echo e(session('message')); ?>

                <button type="button" class="close" aria-label="Close" onclick="closeAlert()">
                    <span class="d-flex justify-content-between" aria-hidden="true">&times;</span>
                </button>
            </div>
            <script>
                function closeAlert() {
                    var alert = document.getElementById('myAlert');
                    alert.style.display = 'none';
                }
            </script>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <div class="p-4 mt-4">
                <div class="mb-3 mt-2">
                    <label for="toEmail" class="form-label">To </label>
                    <br>
                    <!--[if BLOCK]><![endif]--><?php if($showEditToAddress): ?>
                    <input type="email" class="form-control" id="toEmail" wire:model.lazy="to_email" style="font-size: 0.75rem;">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['to_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger">To is required</span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    <?php else: ?>
                    <span class="toAddress"><?php echo e($to_email); ?> </span>
                    <i class="fas fa-edit" wire:click="editToAddress" style="margin-left:10px;font-size:0.75rem;cursor:pointer;color:#778899;"></i>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div class="mb-3">
                    <label for="ccEmail" class="form-label">Add CC</label>
                    <i class="fas fa-plus-circle" wire:click="editCCAddress" style="font-size:0.75rem;cursor:pointer;color:#778899;"></i> <br>
                    <!--[if BLOCK]><![endif]--><?php if($showCCAddress): ?>
                    <input type="email" class="form-control" id="ccEmail" wire:model.lazy="cc_email" style="font-size: 0.75rem;">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['cc_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger">CC is required</span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div class="mb-4">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" wire:model.lazy="subject" style="font-size: 0.75rem;">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger">Subject is required</span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div class="mb-4">
                    <label for="scheduledTime" class="form-label">Scheduled Time</label>
                    <input type="text" class="form-control flatpickr-datetime" id="scheduledTime" wire:model.lazy="scheduled_time" style="font-size: 0.75rem;">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['scheduled_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger">Scheduled time is required</span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div class="col d-flex justify-content-center align-items-center gap-3 ">
                    <button wire:click="sendEmailsAndStoreData" class="btn-send-email">Send Email</button>
                    <button wire:click="scheduleEmails" class="btn-send-after">Send After</button>
                    <button wire:click="scheduleEmailDefault" class="btn-send-email">Send Default</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr('.flatpickr-datetime', {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
            });
        });
    </script>
</div>
<?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/data-entry-for-email.blade.php ENDPATH**/ ?>