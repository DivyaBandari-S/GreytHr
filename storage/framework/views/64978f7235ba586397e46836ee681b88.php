<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
 
</head>
 <style>
   .ytd-table {
        width: 100%;
        font-size:10px;
        border-collapse: collapse;
        border: 1px solid #ccc; /* Table border */
    }

    .ytd-header, .ytd-name, .ytd-value {
        text-align: center;
        padding: 10px;
        font-size:10px;
        border: 1px solid #ccc; /* Cell border */
    }




 </style>
<body style=" font-family: 'Montserrat', sans-serif;background: #f0f0f0;margin: 0;padding: 0;display: flex;justify-content: center;align-items: center;min-height: 50vh;font-size: 12px;">
    <div>
       
 
        <div class="ytdslip" style=" background: #fff;max-width: 1000px; width: 100%; margin: 20px;  font-size: 12px;  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);border-radius: 5px;padding: 20px;">
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employeeData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $empBankDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="m-0 pb-2 pt-2 row"  style="border: 1px solid #000;">
                    <div class="col-3">
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('company-logo');

$__html = app('livewire')->mount($__name, $__params, 'lw-1021519206-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    </div>
                    <div class="col-9 m-auto" style="text-align: center">
                    <?php
    // Get the current year and month
    $currentYear = date('Y');
    $currentMonth = date('n');

    // Determine the starting year and month for YTD summary (April of the current year)
    if ($currentMonth < 4) {
        $startYear = $currentYear - 1;
        $startMonth = 4;
    } else {
        $startYear = $currentYear;
        $startMonth = 4;
    }

    // Determine the ending year and month for YTD summary (March of the next year)
    $endYear = $startYear + 1;
    $endMonth = 3;
    ?>
       
                        <p class="mb-3" style="font-size:20px;font-weight:800"><?php echo e($employeeData->company_name); ?></p>
                        <p style="font-weight: 600">YTD Summary for the year <?php echo $startYear; ?> - <?php echo $endYear; ?></p>
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
                                <p class="mb-1">Bank Name:</p>
                            </div>
                            <div class="col-7 pe-0">
                                <p class="mb-1"><?php echo e($employeeData->bank_name); ?></p>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="col-5 ps-0 ">
                                <p class="mb-1">Date of joining:</p>
                            </div>
                            <div class="col-7 pe-0">
                                <p class="mb-1"><?php echo e($employeeData->hire_date); ?></p>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-6 pb-2 pt-2">
                    <div class="row m-0">
                            <div class="col-5 ps-0 ">
                                <p class="mb-1">Employee Number:</p>
                            </div>
                            <div class="col-7 pe-0">
                                <p class="mb-1"><?php echo e($employeeData->emp_id); ?></p>
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
                       
                      
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $salaryRevision; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="m-0 row" style="border: 1px solid #000; border-top: none;width:100%;font-size:12px">
                <table class="ytd-table">
        <thead>
            <tr class="ytd-header">
                <th class="ytd-header pl-3">Items</th>
           
                                <?php
                        // Determine the current month and year
                        $currentMonth = date('n');
                        $currentYear = date('Y');

                        // Initialize an array for month names
                        $monthNames = [
                            4 => 'Apr', 5 => 'May', 6 => 'Jun',
                            7 => 'Jul', 8 => 'Aug', 9 => 'Sep',
                            10 => 'Oct', 11 => 'Nov', 12 => 'Dec',
                            1 => 'Jan', 2 => 'Feb', 3 => 'Mar'
                        ];

                        // Generate headers starting from April of current year to March of next year
                        $startMonth = 4; // April
                        $endMonth = 3;   // March of next year

                        // Display headers
                        for ($month = $startMonth; $month <= 12; $month++) {
                            echo "<th class='ytd-header'>" . $monthNames[$month] . " " . ($month <= 12 ? $currentYear : $currentYear + 1) . "</th>";
                        }
                        for ($month = 1; $month <= $endMonth; $month++) {
                            echo "<th class='ytd-header'>" . $monthNames[$month] . " " . ($month <= 12 ? $currentYear + 1 : $currentYear + 2) . "</th>";
                        }
                    ?>
                  
                      
      

                <th class="ytd-header">Grand Total</th>
            </tr>
        </thead>
        <tbody>
        <?php
                    // Helper function to calculate total up to the last month
                    function calculateTotal($employee, $startMonth, $endMonth, $currentMonth, $currentYear) {
                        $total = 0;
                        $year = $currentYear;
                        for ($month = $startMonth; $month <= 12; $month++) {
                            if ($year < $currentYear || ($year == $currentYear && $month < $currentMonth)) {
                                $total += $employee;
                            }
                        }
                        $year++;
                        for ($month = 1; $month <= $endMonth; $month++) {
                            if ($year < $currentYear || ($year == $currentYear && $month < $currentMonth)) {
                                $total += $employee;
                            }
                        }
                        return $total;
                    }
                ?>

                <tr style="background:white">
                    <td class="ytd-name">Basic</td>
                 
                    <!--[if BLOCK]><![endif]--><?php for($month = 4; $month <= 12; $month++): ?>
                        <td class="ytd-value">
                            <!--[if BLOCK]><![endif]--><?php if($currentYear == date('Y') && $month < $currentMonth): ?>
                                <?php echo e(number_format($employee->basic, 2)); ?>

                            <?php else: ?>
                                0.00
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>
                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php for($month = 1; $month <= 3; $month++): ?>
                        <td class="ytd-value">
                            0.00
                        </td>
                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                    <td class="ytd-value">
                        <?php
                            echo number_format(calculateTotal($employee->basic, 4, 3, $currentMonth, $currentYear), 2);
                        ?>
                    </td>
                </tr>
              
                <tr style="background:white">
                    <td class="ytd-name">HRA</td>
             
                    <!--[if BLOCK]><![endif]--><?php for($month = 4; $month <= 12; $month++): ?>
                        <td class="ytd-value">
                            <!--[if BLOCK]><![endif]--><?php if($currentYear == date('Y') && $month < $currentMonth): ?>
                                <?php echo e(number_format($employee->hra, 2)); ?>

                            <?php else: ?>
                                0.00
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>
                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php for($month = 1; $month <= 3; $month++): ?>
                        <td class="ytd-value">
                            0.00
                        </td>
                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                    <td class="ytd-value">
                        <?php
                            echo number_format(calculateTotal($employee->hra, 4, 3, $currentMonth, $currentYear), 2);
                        ?>
                    </td>
                </tr>
              
                <tr style="background:white">
                    <td class="ytd-name">Conveyance</td>
              
                    <!--[if BLOCK]><![endif]--><?php for($month = 4; $month <= 12; $month++): ?>
                        <td class="ytd-value">
                            <!--[if BLOCK]><![endif]--><?php if($currentYear == date('Y') && $month < $currentMonth): ?>
                                <?php echo e(number_format($employee->conveyance, 2)); ?>

                            <?php else: ?>
                                0.00
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>
                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php for($month = 1; $month <= 3; $month++): ?>
                        <td class="ytd-value">
                            0.00
                        </td>
                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                    <td class="ytd-value">
                        <?php
                            echo number_format(calculateTotal($employee->conveyance, 4, 3, $currentMonth, $currentYear), 2);
                        ?>
                    </td>
                </tr>
              
                <tr style="background:white">
                    <td class="ytd-name">Medical</td>
               
                    <!--[if BLOCK]><![endif]--><?php for($month = 4; $month <= 12; $month++): ?>
                        <td class="ytd-value">
                            <!--[if BLOCK]><![endif]--><?php if($currentYear == date('Y') && $month < $currentMonth): ?>
                                <?php echo e(number_format($employee->medical, 2)); ?>

                            <?php else: ?>
                                0.00
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>
                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php for($month = 1; $month <= 3; $month++): ?>
                        <td class="ytd-value">
                            0.00
                        </td>
                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                    <td class="ytd-value">
                        <?php
                            echo number_format(calculateTotal($employee->medical, 4, 3, $currentMonth, $currentYear), 2);
                        ?>
                    </td>
                </tr>
                <tr style="background:white">
                    <td class="ytd-name">Special Allowance</td>
              
                    <!--[if BLOCK]><![endif]--><?php for($month = 4; $month <= 12; $month++): ?>
                        <td class="ytd-value">
                            <!--[if BLOCK]><![endif]--><?php if($currentYear == date('Y') && $month < $currentMonth): ?>
                                <?php echo e(number_format($employee->special, 2)); ?>

                            <?php else: ?>
                                0.00
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>
                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php for($month = 1; $month <= 3; $month++): ?>
                        <td class="ytd-value">
                            0.00
                        </td>
                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                    <td class="ytd-value">
                        <?php
                            echo number_format(calculateTotal($employee->special, 4, 3, $currentMonth, $currentYear), 2);
                        ?>
                    </td>
                </tr>
                <tr style="background:white">
                    <td class="ytd-name">Total Allowance</td>
                   
                    <!--[if BLOCK]><![endif]--><?php for($month = 4; $month <= 12; $month++): ?>
                        <td class="ytd-value">
                            <!--[if BLOCK]><![endif]--><?php if($currentYear == date('Y') && $month < $currentMonth): ?>
                                <?php echo e(number_format($employee->calculateTotalAllowance(), 2)); ?>

                            <?php else: ?>
                                0.00
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>
                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php for($month = 1; $month <= 3; $month++): ?>
                        <td class="ytd-value">
                            0.00
                        </td>
                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                    <td class="ytd-value">
                        <?php
                            echo number_format(calculateTotal($employee->calculateTotalAllowance(), 4, 3, $currentMonth, $currentYear), 2);
                        ?>
                    </td>
                </tr>
        </tbody>
    </table>
                  
                </div>
                <div class="m-0 row" style="border: 1px solid #000; border-top: none;">
              
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        
        </div>
       
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
 </html><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/ytdpayslip.blade.php ENDPATH**/ ?>