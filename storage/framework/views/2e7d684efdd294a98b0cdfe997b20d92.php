<div>
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

                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px;white-space:nowrap;">

                    <input type="checkbox" wire:model="selectedEmployees" wire:click="$emit('employeeSelected', <?php echo e($emp->emp_id); ?>)" name="employee_checkbox[]" value="<?php echo e($emp->emp_id); ?>">

                    <?php echo e(ucwords(strtolower($emp->first_name))); ?>&nbsp;<?php echo e(ucwords(strtolower($emp->last_name))); ?>

                </td>
                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px;white-space:nowrap;"><?php echo e($emp->emp_id); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </table>
        <div class="modal-footer" style="background-color: rgb(2, 17, 79); height: 50px">
            <button type="button" style="background-color: white; height:30px;width:100px;border-radius:5px;border:none;">Options</button>
            <button type="button" style="background-color: white; height:30px;width:100px;border-radius:5px;border:none;" wire:click="downloadAttendanceMusterReportInExcel">Run</button>
            <button type="button" data-dismiss="modal"  style="background-color: white; height:30px;width:100px;border-radius:5px;border:none;">Close</button>

        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

</div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/attendance-muster-report.blade.php ENDPATH**/ ?>