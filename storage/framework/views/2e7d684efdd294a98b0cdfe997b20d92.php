<div>
<!--[if BLOCK]><![endif]--><?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->    
    <!--[if BLOCK]><![endif]--><?php if($showAttendanceMusterReportDialog==true): ?>
    <div class="modal-body" style="max-height:300px;overflow-y:auto">

        <div class="date-filters mt-2">
            <label for="from-date" style="font-size: 11px; color: #778899;">From Date:</label>
            <input type="date" id="from-date" wire:model="fromDate" wire:change="updatefromDate" style="font-size: 11px; color: #778899; margin-right: 10px;">

            <label for="to-date" style="font-size: 11px; color: #778899;">To Date:</label>
            <input type="date" id="to-date" wire:model="toDate" wire:change="updatetoDate" style="font-size: 11px; color: #778899;">
        </div>

        <table class="swipes-table mt-2 border" style="width: 100%;">
            <tr style="background-color: #f6fbfc;">
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Name</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Number</th>

            </tr>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
           
            <tr style="border:1px solid #ccc;">

                <td style="width:50%;font-size: 10px; color: <?php echo ($emp->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 10px;white-space:nowrap;">

                    <input type="checkbox" wire:model="selectedEmployees" wire:click="$emit('employeeSelected', <?php echo e($emp->emp_id); ?>)" name="employee_checkbox[]" value="<?php echo e($emp->emp_id); ?>">

                    <?php echo e(ucwords(strtolower($emp->first_name))); ?>&nbsp;<?php echo e(ucwords(strtolower($emp->last_name))); ?>

                </td>
                <td style="width:50%;font-size: 10px; color: <?php echo ($emp->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 32px;white-space:nowrap;"><?php echo e($emp->emp_id); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </table>
        <div class="modal-footer mt-2"
                            style="background-color: rgb(2, 17, 79); display: flex;justify-content: space-around;;">
                            <button type="button"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;">Options</button>
                            <button type="button"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;"
                                wire:click="downloadAttendanceMusterReportInExcel">Run</button>
                            <button type="button" data-dismiss="modal"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;"
                                wire:click='resetFields'>Clear</button>

                        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

</div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/attendance-muster-report.blade.php ENDPATH**/ ?>