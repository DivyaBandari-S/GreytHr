<div class="container">
    <style>
        .timesheetContainer {
            width: 90%;
        }

        .totalHoursContainer {
            background-color: #f7fafc;
            border: 1px solid #ddd;
            border-radius: 0.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.25rem;
        }

        .totalDays {
            font-size: 0.8rem;
            font-weight: 500;
            color: #778899;
        }

        .timeValue {
            color: #000;
            font-weight: 500;
            font-size: 12px;
        }

        .task-table {
            width: 100%;
            border-collapse: collapse;
        }

        .task-table td {
            border: 1px solid #ddd;
            padding: 0px;
            color: #778899;
            text-align: center;
            font-size: 12px;
        }

        .task-table th {
            border: 1px solid #ddd;
            padding: 0.3rem;
            text-align: center;
            font-size: 0.8rem;
        }

        .task-table thead {
            background-color: rgba(2, 17, 79);
            color: white;
        }

        .task-table tbody tr:nth-child(even) {
            background-color: #f7fafc;
        }

        .task-table tbody tr:nth-child(odd) {
            background-color: #edf2f7;
        }

        .task-table tbody tr.weekend {
            background-color: rgb(255, 236, 248);
        }

        .task-table input[type="text"] {
            text-align: center;
            padding: 5px;
            border: none;
            background: transparent;
            width: 100%;
            box-sizing: border-box;
        }

        .task-table textarea {
            text-align: center;
            padding: 0;
            height: 26px;
            border: none;
            background: transparent;
            width: 100%;
            box-sizing: border-box;
        }

        .task-table input[type="text"][readonly],
        .task-table textarea[readonly] {
            pointer-events: none;
        }

        .task-table input[type="text"]:invalid,
        .task-table textarea:invalid {
            border: 1px solid red;
        }

        .error-message {
            color: red;
            font-size: 0.5rem;
            width: 50px;
        }

        .date-header,
        .day-header,
        .client-header,
        .hours-header {
            width: 15%;
        }

        .tasks-header {
            width: 40%;
        }

        .input-label {
            font-weight: 500;
            font-size: 0.8rem;
            margin-right: 0.25rem;
            color: #778899;
        }

        .inputValue {
            font-size: 0.8rem;
            color: #000;
            font-weight: normal;
        }
    </style>
    <!--[if BLOCK]><![endif]--><?php if($tab=="timeSheet"): ?>
    <div class="timesheetContainer mt-2 bg-white p-4 m-auto">
        <div class="row m-0 p-0">
            <div class="col-md-5 d-flex align-items-center">
                <label for="emp_id" class="input-label mb-0">Employee ID :</label>
                <!--[if BLOCK]><![endif]--><?php if($employeeName): ?>
                <label class="inputValue mb-0"><?php echo e(ucwords(strtolower($employeeName->first_name ))); ?> <?php echo e(ucwords(strtolower($employeeName->last_name ))); ?>  (#<?php echo e($employeeName->emp_id); ?>)  </label>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <!-- Start Date -->
            <div class="col-md-4 d-flex align-items-center">
                <?php
                $start_date_string = \Carbon\Carbon::parse($start_date_string)->format('Y-m-d');
                ?>
                <div style="display: flex; align-items: center;">
                    <label for="start_date" class="input-label mb-0">Start Date :</label>
                    <input max="<?php echo e(now()->format('Y-m-d')); ?>" type="date" wire:change="addTask" wire:model.lazy="start_date_string" id="start_date" class="inputValue mb-0 border rounded py-1 px-2 outline-none">
                    <input type="hidden" class="form-control placeholder-small" id="formatted_start_date" value="<?php echo e(\Carbon\Carbon::parse($start_date_string)->format('d-M-Y')); ?>">
                </div>
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['start_date_string'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="error-message" style="color: #e53e3e; font-size: 0.8rem; margin-top: 0.25rem; display: block;">
                    <?php echo e($message); ?>

                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="col-md-3 d-flex align-items-center">
                <div class="d-flex align-items-center">
                    <label for="time_sheet_type" class="input-label mb-0">Time Sheet Type :</label>
                    <div class="d-flex align-items-center">
                        <label class="d-flex align-items-center mb-0" style="font-size: 0.8rem;">
                            <div wire:change="addTask" wire:model="time_sheet_type" name="time_sheet_type" value="weekly" class="inputValue mb-0"> Weekly</div>
                        </label>

                    </div>
                </div>
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['time_sheet_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="error-message" style="color: #e53e3e; font-size: 0.8rem; margin-top: 0.25rem; display: block;">
                    <?php echo e($message); ?>

                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <!-- Time Sheet Type -->
        </div>
    </div>

    <!--[if BLOCK]><![endif]--><?php if($defaultTimesheetEntry=="true"): ?>
    <div class="container" style="width:90%;max-width:<?php echo e(count($client_names) > 0 ? '90%' : '90%'); ?>;padding: 0.6rem; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <div class="subTotalExceed">
            <?php
            $subTotalExceed = false;
            ?>

            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $default_date_and_day_with_tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!--[if BLOCK]><![endif]--><?php if(count($client_names)>=1): ?>
            <?php
            $totalHours = array_sum($task['hours']);
            $subTotalExceed = $totalHours > 24;
            ?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <div>
                <!--[if BLOCK]><![endif]--><?php if(count($client_names)>=2): ?>
                <!--[if BLOCK]><![endif]--><?php if($subTotalExceed): ?>
                <div style="text-align:center">
                    <span style="color: red; font-size: 0.8rem;">Subtotal hours cannot exceed 24.</span>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
        <div id="success-message" style="margin: 0.2rem;padding:0.25rem; background-color: #f0fff4; border: 1px solid #68d391;color: #38a169; border-radius: 0.25rem;text-align:center" class="success-message">
            <?php echo e(session('message')); ?>

        </div>
        <?php elseif(session()->has('message-e')): ?>
        <div id="success-message" style="margin: 0.2rem;padding:0.25rem;  background-color: #f0fff4; border: 1px solid #68d391;color: #38a169; border-radius: 0.25rem;text-align:center" class="success-message">
            <?php echo e(session('message-e')); ?>

        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    var message = document.getElementById('success-message');
                    if (message) {
                        message.style.display = 'none';
                    }
                }, 35000); // 5000 milliseconds = 5 seconds
            });
        </script>

        <form wire:submit.prevent="defaultSubmit">
            <div class="task-table-container">
                <table class="task-table">
                    <thead>
                        <tr>
                            <th class="date-header">Date</th>
                            <th class="day-header">Day</th>
                            <?php if(count($client_names) > 0): ?>
                            <th class="client-header">Client</th>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <th class="hours-header">Hours</th>
                            <th class="tasks-header">Tasks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $default_date_and_day_with_tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $date = \Carbon\Carbon::parse($task['date']);
                        $formattedDate = $date->format('d-M-Y');
                        $isWeekend = $date->isWeekend();
                        $rowColor = $isWeekend ? 'rgb(255, 236, 248)' : ($index % 2 === 0 ? '#f7fafc' : '#edf2f7');
                        ?>
                        <tr style="padding:0; background-color: <?php echo e($rowColor); ?>;">
                            <td class="date-header py-0">
                                <input type="text" value="<?php echo e($formattedDate); ?>"  readonly>
                            </td>
                            <td class="day-header py-0">
                                <input type="text" readonly wire:model="default_date_and_day_with_tasks.<?php echo e($index); ?>.day" >
                            </td>
                            <?php if(count($client_names) >= 1): ?>
                            <td class="client-header py-0">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $task['clients']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input type="text" readonly value="<?php echo e($client); ?>" >
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </td>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <td class="hours-header py-0">
                                <?php if(count($client_names) >= 1): ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $default_date_and_day_with_tasks[$index]['hours']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hourIndex => $hour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input type="text" wire:model="default_date_and_day_with_tasks.<?php echo e($index); ?>.hours.<?php echo e($hourIndex); ?>" wire:change="defaultSaveTimeSheet"  pattern="[0-9]*(\.[0-9]{1,2})?" title="Please enter a number between 0.0 and 24.0, with up to 2 decimal places." <?php $__errorArgs = ['date_and_day_with_tasks.'.$index.'.hours.'.$hourIndex];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> style="border: 1px solid red;" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['default_date_and_day_with_tasks.'.$index.'.hours.'.$hourIndex];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span style="color: red; font-size: 0.5rem; width: 50px;"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?>
                                <input type="text" wire:model="default_date_and_day_with_tasks.<?php echo e($index); ?>.hours" wire:change="defaultSaveTimeSheet"  pattern="[0-9]*(\.[0-9]{1,2})?" title="Please enter a number between 0.0 and 24.0, with up to 2 decimal places." <?php $__errorArgs = ['date_and_day_with_tasks.'.$index.'.hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> style="border: 1px solid red;" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['default_date_and_day_with_tasks.'.$index.'.hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span style="color: red; font-size: 0.5rem; width: 50px;"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>
                            <td class="class-header py-0">
                                <?php if(count($client_names) >= 1): ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $default_date_and_day_with_tasks[$index]['tasks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taskIndex => $taskDescription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <textarea wire:model="default_date_and_day_with_tasks.<?php echo e($index); ?>.tasks.<?php echo e($taskIndex); ?>" wire:change="defaultSaveTimeSheet" ></textarea><br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?>
                                <textarea wire:model="default_date_and_day_with_tasks.<?php echo e($index); ?>.tasks" wire:change="defaultSaveTimeSheet"></textarea><br>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>

            </div>

            <div class="totalHoursContainer py-2">
                <div style="text-align: center; flex-grow: 1;">
                    <div class="row m-0 p-0 d-flex align-items-center">
                        <div class="col">
                            <p class="mb-0 totalDays"> Total days : <span class="timeValue">  <?php echo e($defaultTotalDays); ?></span></p>
                        </div>
                        <div class="col">
                            <p class="mb-0 totalDays"> Total days : <span class="timeValue"><?php echo e($allDefaultTotalHours); ?> </span> </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-align-center mt-4">
                <button type="submit" class="submit-btn">Submit</button>
            </div>
        </form>

        <!-- Flash message for success -->

    </div>
    <?php elseif($defaultTimesheetEntry=="false"): ?>
    <div class="container" style="width:90%;max-width:<?php echo e(count($client_names) > 0 ? '90%' : '90%'); ?>;padding: 0.6rem; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <div class="subTotalExceed">
            <?php
            $subTotalExceed = false;
            ?>

            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $date_and_day_with_tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!--[if BLOCK]><![endif]--><?php if(count($client_names)>=1): ?>
            <?php
            $totalHours = array_sum($task['hours']);
            $subTotalExceed = $totalHours > 24;
            ?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <div>
                <!--[if BLOCK]><![endif]--><?php if(count($client_names)>=2): ?>
                <!--[if BLOCK]><![endif]--><?php if($subTotalExceed): ?>
                <div style="text-align:center">
                    <span style="color: red; font-size: 0.8rem;">Subtotal hours cannot exceed 24.</span>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
        <div id="success-message" style="margin: 0.2rem;padding:0.25rem; background-color: #f0fff4; border: 1px solid #68d391;color: #38a169; border-radius: 0.25rem;text-align:center" class="success-message">
            <?php echo e(session('message')); ?>

        </div>
        <?php elseif(session()->has('message-e')): ?>
        <div id="success-message" style="margin: 0.2rem;padding:0.25rem;  background-color: #f0fff4; border: 1px solid #68d391;color: #38a169; border-radius: 0.25rem;text-align:center" class="success-message">
            <?php echo e(session('message-e')); ?>

        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    var message = document.getElementById('success-message');
                    if (message) {
                        message.style.display = 'none';
                    }
                }, 35000); // 5000 milliseconds = 5 seconds
            });
        </script>

        <form wire:submit.prevent="submit">
            <div class="task-table-container">
                <table class="task-table">
                    <thead>
                        <tr>
                            <th class="date-header">Date</th>
                            <th class="day-header">Day</th>
                            <?php if(count($client_names) > 0): ?>
                            <th class="client-header">Client</th>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <th class="hours-header">Hours</th>
                            <th class="tasks-header">Tasks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $date_and_day_with_tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $date = \Carbon\Carbon::parse($task['date']);
                        $formattedDate = $date->format('d-M-Y');
                        $isWeekend = $date->isWeekend();
                        $rowClass = $isWeekend ? 'weekend' : ($index % 2 === 0 ? 'even' : 'odd');
                        ?>
                        <tr class="<?php echo e($rowClass); ?>">
                            <td class="date-header py-0">
                                <input type="text" value="<?php echo e($formattedDate); ?>" readonly>
                            </td>
                            <td class="day-header py-0">
                                <input type="text" readonly wire:model="date_and_day_with_tasks.<?php echo e($index); ?>.day">
                            </td>
                            <?php if(count($client_names) >= 1): ?>
                            <td class="client-header py-0">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $task['clients']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input type="text" readonly value="<?php echo e($client); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </td>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <td class="hours-header py-0">
                                <?php if(count($client_names) >= 1): ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $date_and_day_with_tasks[$index]['hours']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hourIndex => $hour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input type="text" wire:model="date_and_day_with_tasks.<?php echo e($index); ?>.hours.<?php echo e($hourIndex); ?>" wire:change="saveTimeSheet" pattern="[0-9]*(\.[0-9]{1,2})?" title="Please enter a number between 0.0 and 24.0, with up to 2 decimal places." <?php $__errorArgs = ['date_and_day_with_tasks.'.$index.'.hours.'.$hourIndex];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> class="error" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['date_and_day_with_tasks.'.$index.'.hours.'.$hourIndex];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error-message"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?>
                                <input type="text" wire:model="date_and_day_with_tasks.<?php echo e($index); ?>.hours" wire:change="saveTimeSheet" pattern="[0-9]*(\.[0-9]{1,2})?" title="Please enter a number between 0.0 and 24.0, with up to 2 decimal places." <?php $__errorArgs = ['date_and_day_with_tasks.'.$index.'.hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> class="error" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['date_and_day_with_tasks.'.$index.'.hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error-message"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>
                            <td class="tasks-header py-0">
                                <?php if(count($client_names) >= 1): ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $date_and_day_with_tasks[$index]['tasks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taskIndex => $taskDescription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <textarea wire:model="date_and_day_with_tasks.<?php echo e($index); ?>.tasks.<?php echo e($taskIndex); ?>" wire:change="saveTimeSheet" title="Enter tasks" <?php $__errorArgs = ['date_and_day_with_tasks.'.$index.'.tasks.'.$taskIndex];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> class="error" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>></textarea><br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?>
                                <textarea wire:model="date_and_day_with_tasks.<?php echo e($index); ?>.tasks" wire:change="saveTimeSheet" title="Enter tasks" <?php $__errorArgs = ['date_and_day_with_tasks.'.$index.'.tasks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> class="error" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>></textarea><br>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>

            </div>

            <div class="totalHoursContainer py-2">
                <div style="text-align: center; flex-grow: 1;">
                    <div class="row m-0 p-0 d-flex align-items-center">
                        <div class="col">
                            <p class="totalDays mb-0">Total days : <span class="timeValue"><?php echo e($totalDays); ?></span> </p>
                        </div>
                        <div class="col">
                            <p class="totalDays mb-0">Total hours : <span class="timeValue"><?php echo e($allTotalHours); ?></span> </p>
                        </div>
                    </div>
                </div>
            </div>

            <div style="text-align: center;margin-top:1rem">
                <button type="submit" class="submit-btn">Submit</button>
            </div>
        </form>

        <!-- Flash message for success -->

    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div class="modal fade" id="timesheetHistoryModal" tabindex="-1" role="dialog" aria-labelledby="timesheetHistoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="timesheetHistoryModalLabel" style="font-size:0.8rem">Time Sheet History
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                    $auth_empId = auth()->guard('emp')->user()->emp_id;

                    // Fetch clients associated with the authenticated employee
                    $clients = \App\Models\ClientsEmployee::with('client')
                    ->where('emp_id', $auth_empId)
                    ->get();

                    // Extract client IDs from the collection
                    $clientIds = $clients->pluck('client_id')->toArray();

                    // Fetch client names based on the extracted client IDs
                    $client_names = \App\Models\Client::whereIn('client_id', $clientIds)
                    ->pluck('client_name')
                    ->toArray();
                    ?>
                    <div class="history-card" style="padding: 0.6rem; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 0.5rem;">
                        <table style="border-collapse: collapse; width: 100%;" class="task-table">
                            <thead style="background-color: rgba(2, 17, 79); color: white;">
                                <tr>
                                    <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Start Date</th>
                                    <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        End Date</th>
                                    <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Time Sheet Type</th>
                                    <?php if(count($client_names) >0): ?>
                                    <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Clients</th>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Time Sheet Details</th>
                                    <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Status</th>
                                    <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Approval for Manager</th>
                                    <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.6rem;text-align:center">
                                        Approval for HR</th>
                                </tr>
                            </thead>
                            <tbody style="max-height: 400px; overflow-y: auto;">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $timesheets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $timesheet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $start_date = \Carbon\Carbon::parse($timesheet->start_date)->format('d-m-y');
                                $end_date = \Carbon\Carbon::parse($timesheet->end_date)->format('d-m-y');
                                $tasks = json_decode($timesheet->date_and_day_with_tasks, true);
                                $totalDays = count($tasks);
                                $totalHours = 0;

                                // Calculate total hours based on scenario
                                if (count($tasks) > 0) {
                                if (isset($tasks[0]['clients']) && is_array($tasks[0]['clients']) &&
                                count($tasks[0]['clients']) > 0) {
                                // Scenario with clients
                                foreach ($tasks as $task) {
                                if (isset($task['hours']) && is_array($task['hours'])) {
                                foreach ($task['hours'] as $hours) {
                                $totalHours += $hours;
                                }
                                }
                                }
                                } else {
                                // Scenario without clients
                                $totalHours = array_sum(array_column($tasks, 'hours'));
                                }
                                }
                                ?>
                                <tr style="<?php echo e($index % 2 === 0 ? 'background-color: #f7fafc;' : 'background-color: #edf2f7;'); ?>" class="<?php echo e($index % 2 === 0 ? 'even-row' : 'odd-row'); ?>">
                                    <td style="border-bottom: 1px solid #ddd; width: 80px; font-size: 0.5rem;">
                                        <?php echo e($start_date); ?>

                                    </td>
                                    <td style="border-bottom: 1px solid #ddd; width: 80px; font-size: 0.5rem;">
                                        <?php echo e($end_date); ?>

                                    </td>
                                    <td style="border-bottom: 1px solid #ddd; width: 80px; font-size: 0.5rem; text-transform: capitalize;">
                                        <?php echo e($timesheet->time_sheet_type); ?>

                                    </td>
                                    <?php if(count($client_names) >0 ): ?>
                                    <td style="border-bottom: 1px solid #ddd; width: 90px; font-size: 0.5rem; text-transform: capitalize; max-height: 50px; overflow: hidden; text-overflow: ellipsis;">
                                        <!--[if BLOCK]><![endif]--><?php if(isset($task['clients']) && is_array($task['clients']) &&
                                        count($task['clients']) > 0): ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $task['clients']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div><?php echo e($index+1); ?>. <?php echo e($client); ?></div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php else: ?>
                                        <?php echo e($task['clients'] == "" ? '--' : '*' . $task['clients']); ?>

                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <td style="border-bottom: 1px solid #ddd; width: 350px">
                                        <div style=" height:200px;max-height: 100%; overflow-y: auto;overflow-x:hidden">
                                            <table style="border-collapse: collapse; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.5rem; background-color: rgba(2, 17, 79, 0.5); color: white;text-align:center">
                                                            Date</th>
                                                        <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.5rem; background-color: rgba(2, 17, 79, 0.5); color: white;text-align:center">
                                                            Day</th>
                                                        <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.5rem; background-color: rgba(2, 17, 79, 0.5); color: white;text-align:center">
                                                            Tasks</th>
                                                        <th style="font-weight: normal; border-bottom: 1px solid #ddd; font-size: 0.5rem; background-color: rgba(2, 17, 79, 0.5); color: white;text-align:center">
                                                            Hours</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                    $formattedDate =
                                                    \Carbon\Carbon::parse($task['date'])->format('d-m-y');
                                                    ?>
                                                    <tr>
                                                        <td style="background-color: white; color: black; width: 80px; font-size: 0.5rem;">
                                                            <?php echo e($formattedDate); ?>

                                                        </td>
                                                        <td style="background-color: white; color: black; width: 70px; font-size: 0.5rem;">
                                                            <?php echo e($task['day']); ?>

                                                        </td>
                                                        <td style="background-color: white; color: black; width: 120px; font-size: 0.5rem; text-transform: capitalize; overflow: hidden; text-overflow: ellipsis;">
                                                            <!--[if BLOCK]><![endif]--><?php if(is_array($task['tasks']) && count($task['tasks']) > 0): ?>
                                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $task['tasks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $taskItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li><?php echo e($taskItem != "" ? $taskItem : '--'); ?></li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                            <?php else: ?>
                                                            <?php echo e($task['tasks'] == "" ? '--' : $task['tasks']); ?>

                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </td>
                                                        <td style="background-color: white; color: black; width: 90px; font-size: 0.5rem; text-transform: capitalize; overflow: hidden; text-overflow: ellipsis;">
                                                            <!--[if BLOCK]><![endif]--><?php if(is_array($task['hours']) && count($task['hours']) > 0): ?>
                                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $task['hours']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $hours): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li><?php echo e($hours); ?></li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                            <?php else: ?>
                                                            <?php echo e($task['hours'] == "" ? '--' : $task['hours']); ?>

                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </td>
                                                    </tr>
                                                    <?php if(is_array($task['hours']) && count($task['hours']) >= 1): ?>
                                                    <tr style="border: 1px solid lightgrey;padding:0;margin:0">
                                                        <td colspan="<?php echo e(is_array($task['hours']) && count($task['hours']) > 0 ? '4':'0'); ?>" style="text-align:center;padding:0;margin:0">
                                                            <div style="font-size:0.5rem">Sub total hours :
                                                                <?php echo e(array_sum($task['hours'])); ?>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                    <tr>
                                                        <td colspan="8" style="background-color: lightgray; color: black; font-weight: bold; text-align: center;">
                                                            <div class="row" style="font-size: 0.5rem;">
                                                                <div class="col">
                                                                    Total days : <?php echo e($totalDays); ?>

                                                                </div>
                                                                <div class="col">
                                                                    Total hours : <?php echo e($totalHours); ?>

                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                    <td style="border-bottom: 1px solid #ddd; width: 90px; text-transform: capitalize; font-size: 0.5rem;">
                                        <?php echo e($timesheet->submission_status); ?>

                                    </td>
                                    <td style="border-bottom: 1px solid #ddd; width: 90px; text-transform: capitalize; font-size: 0.5rem;">
                                        <?php echo e($timesheet->approval_status_for_manager); ?>

                                    </td>
                                    <td style="border-bottom: 1px solid #ddd; width: 90px; text-transform: capitalize; font-size: 0.5rem;">
                                        <?php echo e($timesheet->approval_status_for_hr); ?>

                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button style="font-size: 0.8rem;" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let startDateInput = document.getElementById('start_date');
        let formattedStartDateInput = document.getElementById('formatted_start_date');

        // Function to format date as d-M-Y
        function formatDate(d) {
            let day = ('0' + d.getDate()).slice(-2);
            let month = d.toLocaleString('default', {
                month: 'short'
            });
            let year = d.getFullYear();
            return `${day}-${month}-${year}`;
        }

        // Set initial value if not set
        if (!startDateInput.value) {
            let now = new Date();
            let day = now.getDay();
            let diff = now.getDate() - day + (day === 0 ? -6 : 1); // adjust when day is Sunday
            let monday = new Date(now.setDate(diff));

            let formattedDate = formatDate(monday);
            startDateInput.value = monday.toISOString().split('T')[0];
            formattedStartDateInput.value = formattedDate;
            startDateInput.dispatchEvent(new Event('change'));
        }

        // Update displayed date on change
        startDateInput.addEventListener('change', function() {
            let date = new Date(this.value);
            let formattedDate = formatDate(date);
            formattedStartDateInput.value = formattedDate;
            // Trigger Livewire update if needed
            formattedStartDateInput.dispatchEvent(new Event('input'));
        });
    });
</script><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/emp-time-sheet.blade.php ENDPATH**/ ?>