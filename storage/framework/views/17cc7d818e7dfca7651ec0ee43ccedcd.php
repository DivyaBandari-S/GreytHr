<!DOCTYPE html>
<html>
 
<head>
 
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
           
 
        }
 
        .container {
            margin: 0 auto;
            width: 80%;
        }
 
        .header {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }
 
        .info {
            margin-bottom: 20px;
        }
 
        table {
            width: 100%;
            border-collapse: collapse;
        }
 
        table, th, td {
            border: 1px solid #000;
        }
 
        th, td {
            padding: 10px;
            text-align: center;
        }
 
        th {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
<!--[if BLOCK]><![endif]--><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employeeData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $empBankDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="container" style="background:white;width:1000px;border:1px solid grey;border-radius:5px;font-size:14px;">
    <div style="display:flex">
    <div style="margin-left:210px;margin-top:10px">
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('company-logo');

$__html = app('livewire')->mount($__name, $__params, 'lw-1945642859-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    </div>
    <p style="margin-left: 20px; font-size: 25px; font-weight: 500; font-family: 'Montserrat', sans-serif;"><?php echo e($employeeData->company_name); ?></p>
 
    </div>
    <div class="header" style="margin-left:15px">
            Income Tax Computation For The Financial Year 2023
        </div>
 
        <div class="info" style="margin-left:15px">
        <table style="font-size:10px">
    <tr>
        <td>Employee No:<?php echo e($employeeData->emp_id); ?> </td>
        <td>Name:<?php echo e($employeeData->first_name); ?> <?php echo e($employeeData->last_name); ?></td>
        <td>PAN No.:<?php echo e($employeeData->pan_no); ?></td>
    </tr>
    <tr>
        <td>Gender: <?php echo e($employeeData->gender); ?> </td>
        <td>Location: <?php echo e($employeeData->job_location); ?> </td>
        <td>Date of Join:<?php echo e(date('d M Y', strtotime($employeeData->hire_date))); ?></td>
    </tr>
    <tr>
        <td>Date of Birth:  <?php echo e(date('d M Y', strtotime($employeeData->date_of_birth))); ?> </td>
        <td>Date of Leaving:</td>
        <td>Tax Regime: NEW</td>
    </tr>
   
</table>
 
        </div>
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $salaryRevision; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p style="margin-left:20px">A) Earnings</p>
        <table style="font-size:10px">
            <tr style="font-size:12px">
                <th style="font-size:10px">Pay Items</th>
                <th>Total</th>
                <th style="font-size:12px">Jan 2023</th>
                <th style="font-size:12px">Feb 2023</th>
                <th style="font-size:12px">Mar 2023</th>
                <th style="font-size:12px">Apr 2023</th>
                <th style="font-size:12px">May 2023</th>
                <th style="font-size:12px">Jun 2023</th>
                <th style="font-size:12px">Jul 2023</th>
                <th style="font-size:12px">Aug 2023</th>
                <th style="font-size:12px">Sep 2023</th>
                <th style="font-size:12px">Oct 2023</th>
                <th style="font-size:12px">Nov 2023</th>
                <th style="font-size:12px">Dec 2023</th>
                <!-- Add more months here -->
            </tr>
            <tr>
                <td>BASIC</td>
                <td><?php echo e(number_format($employee->basic*12, 2)); ?></td>
                <td><?php echo e(number_format($employee->basic, 2)); ?></td>
                <td><?php echo e(number_format($employee->basic, 2)); ?></td>
                <td><?php echo e(number_format($employee->basic, 2)); ?></td>
                <td><?php echo e(number_format($employee->basic, 2)); ?></td>
                <td><?php echo e(number_format($employee->basic, 2)); ?></td>
                <td><?php echo e(number_format($employee->basic, 2)); ?></td>
                <td><?php echo e(number_format($employee->basic, 2)); ?></td>
                <td><?php echo e(number_format($employee->basic, 2)); ?></td>
                <td><?php echo e(number_format($employee->basic, 2)); ?></td>
                <td><?php echo e(number_format($employee->basic, 2)); ?></td>
                <td><?php echo e(number_format($employee->basic, 2)); ?></td>
                <td><?php echo e(number_format($employee->basic, 2)); ?></td>
                <!-- Add more months here -->
            </tr>
            <tr>
                <td>HRA</td>
                <td><?php echo e(number_format($employee->hra*12, 2)); ?></td>
                <td><?php echo e(number_format($employee->hra, 2)); ?></td>
                <td><?php echo e(number_format($employee->hra, 2)); ?></td>
                <td><?php echo e(number_format($employee->hra, 2)); ?></td>
                <td><?php echo e(number_format($employee->hra, 2)); ?></td>
                <td><?php echo e(number_format($employee->hra, 2)); ?></td>
                <td><?php echo e(number_format($employee->hra, 2)); ?></td>
                <td><?php echo e(number_format($employee->hra, 2)); ?></td>
                <td><?php echo e(number_format($employee->hra, 2)); ?></td>
                <td><?php echo e(number_format($employee->hra, 2)); ?></td>
                <td><?php echo e(number_format($employee->hra, 2)); ?></td>
                <td><?php echo e(number_format($employee->hra, 2)); ?></td>
                <td><?php echo e(number_format($employee->hra, 2)); ?></td>
                <!-- Add more months here -->
            </tr>
            <tr>
                <td>Conveyance</td>
                <td><?php echo e(number_format($employee->conveyance*12, 2)); ?></td>
                <td><?php echo e(number_format($employee->conveyance, 2)); ?></td>
                <td><?php echo e(number_format($employee->conveyance, 2)); ?></td>
                <td><?php echo e(number_format($employee->conveyance, 2)); ?></td>
                <td><?php echo e(number_format($employee->conveyance, 2)); ?></td>
                <td><?php echo e(number_format($employee->conveyance, 2)); ?></td>
                <td><?php echo e(number_format($employee->conveyance, 2)); ?></td>
                <td><?php echo e(number_format($employee->conveyance, 2)); ?></td>
                <td><?php echo e(number_format($employee->conveyance, 2)); ?></td>
                <td><?php echo e(number_format($employee->conveyance, 2)); ?></td>
                <td><?php echo e(number_format($employee->conveyance, 2)); ?></td>
                <td><?php echo e(number_format($employee->conveyance, 2)); ?></td>
                <td><?php echo e(number_format($employee->conveyance, 2)); ?></td>
                <!-- Add more months here -->
            </tr>
            <tr>
                <td>Medical</td>
                <td><?php echo e(number_format($employee->medical*12, 2)); ?></td>
                <td><?php echo e(number_format($employee->medical, 2)); ?></td>
                <td><?php echo e(number_format($employee->medical, 2)); ?></td>
                <td><?php echo e(number_format($employee->medical, 2)); ?></td>
                <td><?php echo e(number_format($employee->medical, 2)); ?></td>
                <td><?php echo e(number_format($employee->medical, 2)); ?></td>
                <td><?php echo e(number_format($employee->medical, 2)); ?></td>
                <td><?php echo e(number_format($employee->medical, 2)); ?></td>
                <td><?php echo e(number_format($employee->medical, 2)); ?></td>
                <td><?php echo e(number_format($employee->medical, 2)); ?></td>
                <td><?php echo e(number_format($employee->medical, 2)); ?></td>
                <td><?php echo e(number_format($employee->medical, 2)); ?></td>
                <td><?php echo e(number_format($employee->medical, 2)); ?></td>
                <!-- Add more months here -->
            </tr>
            <tr>
                <td>Special Allowance</td>
                <td><?php echo e(number_format($employee->special*12, 2)); ?></td>
                <td><?php echo e(number_format($employee->special, 2)); ?></td>
                <td><?php echo e(number_format($employee->special, 2)); ?></td>
                <td><?php echo e(number_format($employee->special, 2)); ?></td>
                <td><?php echo e(number_format($employee->special, 2)); ?></td>
                <td><?php echo e(number_format($employee->special, 2)); ?></td>
                <td><?php echo e(number_format($employee->special, 2)); ?></td>
                <td><?php echo e(number_format($employee->special, 2)); ?></td>
                <td><?php echo e(number_format($employee->special, 2)); ?></td>
                <td><?php echo e(number_format($employee->special, 2)); ?></td>
                <td><?php echo e(number_format($employee->special, 2)); ?></td>
                <td><?php echo e(number_format($employee->special, 2)); ?></td>
                <td><?php echo e(number_format($employee->special, 2)); ?></td>
                <!-- Add more months here -->
            </tr>
            <tr>
                <td>Total</td>
                <td><?php echo e(number_format($employee->calculateTotalAllowance()*12, 2)); ?></td>
                <td><?php echo e(number_format($employee->calculateTotalAllowance(), 2)); ?></td>
                <td><?php echo e(number_format($employee->calculateTotalAllowance(), 2)); ?></td>
                <td><?php echo e(number_format($employee->calculateTotalAllowance(), 2)); ?></td>
                <td><?php echo e(number_format($employee->calculateTotalAllowance(), 2)); ?></td>
                <td><?php echo e(number_format($employee->calculateTotalAllowance(), 2)); ?></td>
                <td><?php echo e(number_format($employee->calculateTotalAllowance(), 2)); ?></td>
                <td><?php echo e(number_format($employee->calculateTotalAllowance(), 2)); ?></td>
                <td><?php echo e(number_format($employee->calculateTotalAllowance(), 2)); ?></td>
                <td><?php echo e(number_format($employee->calculateTotalAllowance(), 2)); ?></td>
                <td><?php echo e(number_format($employee->calculateTotalAllowance(), 2)); ?></td>
                <td><?php echo e(number_format($employee->calculateTotalAllowance(), 2)); ?></td>
                <td><?php echo e(number_format($employee->calculateTotalAllowance(), 2)); ?></td>
                <!-- Add more months here -->
            </tr>
            <!-- Add more pay items here -->
        </table>
        <p style="margin-left:20px">B Deductions</p>
        <table style="margin-top:20px;font-size:10px">
    <tr>
        <th>Pay Items</th>
        <th>Total</th>
        <th>Apr 2023</th>
        <th>May 2023</th>
        <th>Jun 2023</th>
        <th>Jul 2023</th>
        <th>Aug 2023</th>
        <th>Sep 2023</th>
        <th>Oct 2023</th>
        <th>Nov 2023</th>
        <th>Dec 2023</th>
        <th>Jan 2024</th>
        <th>Feb 2024</th>
        <th>Mar 2024</th>
    </tr>
    <tr>
        <td>PF</td>
        <td><?php echo e(number_format($employee->calculatePf() * 12 , 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf(), 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf(), 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf(), 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf(), 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf(), 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf(), 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf(), 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf(), 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf(), 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf(), 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf(), 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf(), 2)); ?></td>
    </tr>
    <tr>
        <td>PROF TAX</td>
        <td>1,800.00</td>
        <td>150.00</td>
        <td>150.00</td>
        <td>150.00</td>
        <td>150.00</td>
        <td>150.00</td>
        <td>150.00</td>
        <td>150.00</td>
        <td>150.00</td>
        <td>150.00</td>
        <td>150.00</td>
        <td>150.00</td>
        <td>150.00</td>
    </tr>
    <tr>
        <td>Total</td>
        <td>₹<?php echo e(number_format($employee->calculatePf() * 12 + 1800, 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf() + 150, 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf() + 150, 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf() + 150, 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf() + 150, 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf() + 150, 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf() + 150, 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf() + 150, 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf() + 150, 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf() + 150, 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf() + 150, 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf() + 150, 2)); ?></td>
        <td><?php echo e(number_format($employee->calculatePf() + 150, 2)); ?></td>
       
    </tr>
</table>
<p style="margin-left:20px">C) Perquisites</p>
<table class="perquisites-table" style="font-size:10px">
    <tr style="font-size:12px">
        <th>Pay Items</th>
        <th>Total</th>
        <th>Apr 2023</th>
        <th>May 2023</th>
        <th>Jun 2023</th>
        <th>July 2023</th>
        <th>Aug 2023</th>
        <th>Sep 2023</th>
        <th>Oct 2023</th>
        <th>Nov 2023</th>
        <th>Dec 2023</th>
        <th>Jan 2024</th>
        <th>Feb 2024</th>
        <th>Mar 2024</th>
    </tr>
    <tr>
        <td>Perquisite 1</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <!-- Add more rows for other perquisites if needed -->
</table>
 
 
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
 
 
        <!-- Repeat the above structure for Deduction and Perquisites sections -->
 
        <div class="footer">
            <p>D:) Gross Salary (A+C): <?php echo e(number_format($employee->calculateTotalAllowance()*12, 2)); ?> </p>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
</body>
</html>
 <?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/itform.blade.php ENDPATH**/ ?>