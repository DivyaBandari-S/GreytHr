<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >
 
</head>
 
<body style=" font-family: 'Montserrat', sans-serif;background: #f0f0f0;margin: 0;padding: 0;display: flex;justify-content: center;align-items: center;min-height: 50vh;font-size: 12px;">
    <div>
       
 
        <div class="salaryslip" style=" background: #fff;max-width: 800px; width: 100%; margin: 20px;  font-size: 12px;  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);border-radius: 5px;padding: 20px;">
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employeeData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $empBankDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="m-0 pb-2 pt-2 row"  style="border: 1px solid #000;">
                    <div class="col-3">
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('company-logo');

$__html = app('livewire')->mount($__name, $__params, 'lw-2712858520-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    </div>
                    <div class="col-9 m-auto" style="text-align: center">
                        <p class="mb-3" style="font-size:20px;font-weight:800"><?php echo e($employeeData->company_name); ?></p>
                        <p style="font-weight: 600">Payslip for the month of February 2024</p>
                    </div>
                </div>
                <div class="m-0 row" style="border: 1px solid #000; border-top: none;">
                    <div class="col-6 pb-2 pt-2" style="border-right: 1px solid #000;">
                        <div class="row m-0">
                            <div class="col-5 ps-0">
                                <p class="mb-1">Name:</p>
                            </div>
                            <div class="col-7 pe-0">
                                <p class="mb-1"><?php echo e($employeeData->first_name); ?> <?php echo e($employeeData->last_name); ?></p>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="col-5 ps-0 ">
                                <p class="mb-1">Mobile:</p>
                            </div>
                            <div class="col-7 pe-0">
                                <p class="mb-1"><?php echo e($employeeData->mobile_number); ?></p>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="col-5 ps-0 ">
                                <p class="mb-1">Designation:</p>
                            </div>
                            <div class="col-7 pe-0">
                                <p class="mb-1"><?php echo e($employeeData->job_title); ?></p>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="col-5 ps-0 ">
                                <p class="mb-1">Grade:</p>
                            </div>
                            <div class="col-7 pe-0">
                                <p class="mb-1">18</p>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="col-5 ps-0 ">
                                <p class="mb-1">Address:</p>
                            </div>
                            <div class="col-7 pe-0">
                                <p class="mb-1"><?php echo e($employeeData->address); ?></p>
                            </div>
                        </div>
                       
                    </div>
                    <div class="col-6 pb-2 pt-2">
                        <div class="row m-0">
                            <div class="col-5 ps-0 ">
                                <p class="mb-1">Bank Name:</p>
                            </div>
                            <div class="col-7 pe-0">
                                <p class="mb-1"><?php echo e($employee->bank_name); ?></p>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="col-5 ps-0 ">
                                <p class="mb-1">Branch Name:</p>
                            </div>
                            <div class="col-7 pe-0">
                                <p class="mb-1"><?php echo e($employee->bank_branch); ?></p>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="col-5 ps-0 ">
                                <p class="mb-1">Bank Account Number:</p>
                            </div>
                            <div class="col-7 pe-0">
                                <p class="mb-1"><?php echo e($employee->account_number); ?></p>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="col-5 ps-0 ">
                                <p class="mb-1">PAN No:</p>
                            </div>
                            <div class="col-7 pe-0">
                                <p class="mb-1"><?php echo e($employeeData->pan_no); ?></p>
                            </div>
                        </div>
                       
                        <div class="row m-0">
                            <div class="col-5 ps-0 ">
                                <p class="mb-1">PF Number:</p>
                            </div>
                            <div class="col-7 pe-0">
                                <p class="mb-1"><?php echo e($employeeData->pf_no); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $salaryRevision; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="m-0 row" style="border: 1px solid #000; border-top: none;">
                    <div class="col-6 pb-2 pt-2" style="border-right: 1px solid #000;">
                        <div class="row m-0">
                            <div class="col-6 ps-0" style="text-align:center">
                                <p class="mb-0" style="font-weight: 600">Earnings</p>
                            </div>
                            <div class="col-3" style="text-align:end">
                                <p class="mb-0" style="font-weight: 600">Full</p>
                            </div>
                            <div class="col-3 ps-0" style="text-align:end">
                                <p class="mb-0" style="font-weight: 600">Actual</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 pb-2 pt-2">
                        <div class="row m-0">
                            <div class="col-9 ps-0" style="text-align:center">
                                <p class="mb-0" style="font-weight: 600">Deductions</p>
                            </div>
                            <div class="col-3 ps-0" style="text-align:end">
                                <p class="mb-0" style="font-weight: 600">Actual</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-0 row" style="border: 1px solid #000; border-top: none;">
                    <div class="col-6 pb-2 pt-2" style="border-right: 1px solid #000;">
                        <div class="row m-0">
                            <div class="col-6 ps-0">
                                <p class="mb-1">BASIC SALARY</p>
                            </div>
                            <div class="col-3" style="text-align:end">
                                <p class="mb-1"></p>
                            </div>
                            <div class="col-3 ps-0" style="text-align:end">
                                <p class="mb-1"><?php echo e(number_format($employee->basic, 2)); ?></p>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="col-6 ps-0">
                                <p class="mb-1">HRA</p>
                            </div>
                            <div class="col-3" style="text-align:end">
                                <p class="mb-1"></p>
                            </div>
                            <div class="col-3 ps-0" style="text-align:end">
                                <p class="mb-1"><?php echo e(number_format($employee->hra, 2)); ?></p>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="col-6 ps-0">
                                <p class="mb-1">CONVEYANCE</p>
                            </div>
                            <div class="col-3" style="text-align:end">
                                <p class="mb-1"></p>
                            </div>
                            <div class="col-3 ps-0" style="text-align:end">
                                <p class="mb-1"><?php echo e(number_format($employee->conveyance, 2)); ?></p>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="col-6 ps-0">
                                <p class="mb-1">MEDICAL ALLOWANCE</p>
                            </div>
                            <div class="col-3" style="text-align:end">
                                <p class="mb-1"></p>
                            </div>
                            <div class="col-3 ps-0" style="text-align:end">
                                <p class="mb-1"><?php echo e(number_format($employee->medical, 2)); ?></p>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="col-6 ps-0">
                                <p class="mb-1">SPECIAL ALLOWANCE</p>
                            </div>
                            <div class="col-3" style="text-align:end">
                                <p class="mb-1"></p>
                            </div>
                            <div class="col-3 ps-0" style="text-align:end">
                                <p class="mb-1"><?php echo e(number_format($employee->special, 2)); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 pb-2 pt-2">
                        <div class="row m-0">
                            <div class="col-9 ps-0">
                                <p class="mb-1">PF</p>
                            </div>
                            <div class="col-3 ps-0" style="text-align:end">
                                <p class="mb-1"><?php echo e(number_format($employee->calculatePf(), 2)); ?></p>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="col-9 ps-0">
                                <p class="mb-1">ESI</p>
                            </div>
                            <div class="col-3 ps-0" style="text-align:end">
                                <p class="mb-1"><?php echo e(number_format($employee->calculateEsi(), 2)); ?></p>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="col-9 ps-0">
                                <p class="mb-1">PROF TAX</p>
                            </div>
                            <div class="col-3 ps-0" style="text-align:end">
                                <p class="mb-1">150</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-0 row" style="border: 1px solid #000; border-top: none;">
                    <div class="col-6 pb-2 pt-2" style="border-right: 1px solid #000;">
                        <div class="row m-0">
                            <div class="col-6 ps-0">
                                <p class="mb-1">Total Earnings</p>
                            </div>
                            <div class="col-3" style="text-align:end">
                                <p class="mb-1"></p>
                            </div>
                            <div class="col-3 ps-0" style="text-align:end">
                                <p class="mb-1"><?php echo e(number_format($employee->calculateTotalAllowance(), 2)); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 pb-2 pt-2">
                        <div class="row m-0">
                            <div class="col-9 ps-0">
                                <p class="mb-1">Total Deductions</p>
                            </div>
                            <div class="col-3 ps-0" style="text-align:end">
                                <p class="mb-1"><?php echo e(number_format($employee->calculateTotalDeductions(), 2)); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-0 row" style="border: 1px solid #000; border-top: none;">
                    <p class="mt-2">Net Pay for the month ( Total Earnings - Total Deductions): 78963</p>
                    <p>(Rupees Seventy Eight Thousand Nine Hundred Sixty Three Only)</p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            <div class="row m-0" style="text-align: center">
                <p>Currently we are working on payslip .</p>
            </div>
        </div>
       
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
 </html><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/download-pdf.blade.php ENDPATH**/ ?>