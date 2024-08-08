<div>
<!--[if BLOCK]><![endif]--><?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <div class="modal-body" style="max-height:300px;overflow-y:auto">
        <div class="search-bar">
            <input type="text" wire:model="search" placeholder="Search..." wire:change="searchfilter">
        </div>
        

        <table class="swipes-table mt-2 border" style="width: 100%;">
            <tr style="background-color: #f6fbfc;">
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Name</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Number</th>
            </tr>


            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $Employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr style="border:1px solid #ccc;">
                
                                 
           
                <td style="width:50%;font-size: 10px; color:  <?php echo ($emp->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 10px">
                <input type="checkbox" name="employeeCheckbox[]" class="employee-swipes-checkbox" wire:model="EmployeeId" wire:change="updateEmployeeId" value="<?php echo e($emp->emp_id); ?>">
                       <?php echo e(ucwords(strtolower($emp->first_name))); ?>&nbsp;<?php echo e(ucwords(strtolower($emp->last_name))); ?>

                </td>
                <td style="width:50%;font-size: 10px;color: <?php echo ($emp->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 32px"><?php echo e($emp->emp_id); ?></td>
              
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->


        </table>
    </div>
    <div class="modal-footer mt-2"
                            style="background-color: rgb(2, 17, 79); display: flex;justify-content: space-around;;">
                            <button type="button"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;">Options</button>
                            <button type="button"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;"
                                wire:click="downloadInExcel">Run</button>
                            <button type="button" data-dismiss="modal"
                                style="background-color: white; height:30px;width:4.875rem;border-radius:5px;border:none;font-size: 0.785rem;"
                                wire:click='resetFields'>Clear</button>

                        </div>
</div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/family-report.blade.php ENDPATH**/ ?>