<div>
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            overflow-y: hidden;
            right: -255px;
            height: 100%;
            width: 245px;
            /* Adjust width as needed */
            background-color: #fff;
            /* Adjust background color */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Optional box shadow */
            /* Add vertical scrollbar if needed */
            z-index: 1000;
            /* Adjust z-index */
            /* Add any other styles you need */
        }

        /* Adjust the close button position if needed */
        #closeSidebar {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .sidebar .sidebar-header {
            background-color: #e9edf1;
            padding: 10px;
            text-align: center;
        }

        .down-arrow-reg {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #5473e3;
            margin-right: 5px;
        }

        .down-arrow-ove {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #e2b7ff;
            margin-right: 5px;
        }

        .down-arrow-ign {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid;
            margin-right: 5px;
        }

        .legendsIcon {
            padding: 1px 6px;
            font-weight: 500;
        }

        .down-arrow-afd {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #7dd4ff;
            margin-right: 5px;
        }

        .down-arrow-ded {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #ff9595;
            margin-right: 5px;
        }

        .sidebar .sidebar-header h2 {
            color: #7f8fa4;
            font-size: 24px;
            margin: 0;
        }

        .sidebar-content h3 {
            color: #7f8fa4;
            margin-left: 30px;
        }

        .sidebar-content p {
            color: #7f8fa4;
            font-size: 12px;
            margin-left: 30px;
        }

        .search-bar {
            display: flex;
            padding: 0;
            justify-content: start;
            width: 250px;
            /* Adjust width as needed */
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
            background: #fff;
        }

        .holidayIcon {
            background-color: #f7f7f7;
        }

        .custom-button {
            padding: 2px;
            margin-bottom: 15px;
            background-color: #3eb0f7;
            color: #fff;
            width: 100px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Styling for the input */
        .search-bar input[type="search"] {
            flex: 1;
            padding: 5px;
            border: none;
            outline: none;
            font-size: 14px;
            background: transparent;
        }

        /* Styling for the search icon */
        .search-bar::after {
            content: "\f002";
            /* Unicode for the search icon (font-awesome) */
            font-family: FontAwesome;
            /* Use an icon font library like FontAwesome */
            font-size: 16px;
            padding: 5px;
            color: #999;
            /* Icon color */
            cursor: pointer;
        }

        .presentIcon {
            border: 1px solid #6c757d;
        }

        .absentIcon {
            border: 1px solid #6c757d;
        }

        .offIcon {
            border: 1px solid #6c757d;
        }

        .restIcon {
            border: 1px solid #6c757d;
        }

        .down-arrow-gra {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #ffe8de;
            margin-left: -5px;
        }

        /* Styling for the search icon (optional) */
        .search-bar input[type="search"]::placeholder {
            color: #999;
            /* Placeholder color */
        }

        .search-bar input[type="search"]::-webkit-search-cancel-button {
            display: none;
            /* Hide cancel button on Chrome */
        }

        .summary {
            border: 1px solid #ccc;
            background: #ebf5ff;
            padding: 0;
        }

        .Attendance {
            border: 1px solid #ccc;
            background: #ebf5ff;
            padding: 0;
            max-width: 800px;
            overflow-x: auto;
            scrollbar-width: thin;
            /* For Firefox */
            scrollbar-color: #dce0e5;
            /* For Firefox */
        }

        /* For Webkit-based browsers (Chrome, Safari, Edge) */
        .Attendance::-webkit-scrollbar {
            width: 2px;
            /* Width of the scrollbar */
            height: 8px;
        }

        /* Track (the area where the scrollbar sits) */
        .Attendance::-webkit-scrollbar-track {
            background: #fff;
            /* Background color of the track */
        }

        /* Handle (the draggable part of the scrollbar) */
        .Attendance::-webkit-scrollbar-thumb {
            background: #dce0e5;
            /* Color of the scrollbar handle */
            border-radius: 2px;
            /* Border radius of the handle */
        }

        /* Handle on hover */
        .Attendance::-webkit-scrollbar-thumb:hover {
            background: #dce0e5;
            /* Color of the scrollbar handle on hover */
        }

        .Attendance th,
        .Attendance td {
            width: auto;
            white-space: nowrap;
            /* Prevent content from wrapping */
        }

        .table {
            background: #fff;
            margin: 0;
        }

        td {
            font-size: 0.795rem;
        }

        .table tbody td {
            border-right: 1px solid #d5d5d5;
            /* Vertical border color and width */
        }

        /* Remove right border for the last cell in each row to avoid extra border */
        .summary .table tbody tr td:last-child {
            border-right: none;
            background: #f2f2f2;
        }

        .Attendance .table tbody tr td:last-child {
            border-right: none;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-top: -5px;
            /* Adjust as needed for spacing */
        }

        .accordion {
            background-color: #dae0f7;
            color: #444;
            cursor: pointer;
            padding: 21px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
            margin-top: 10px;
            border: 1px solid #cecece;
        }

        .active,
        .accordion:hover {
            background-color: #02114f;
            color: #fff;
        }

        .panel {
            display: none;
            background-color: white;
            overflow: hidden;
            border: 1px solid #cecece;
            font-size: 14px;
        }

        .accordion:after {
            content: '\02795';
            font-size: 13px;
            color: #fff;
            float: right;
            margin-left: 5px;
        }

        .active:after {
            content: "\2796";
            /* Unicode character for "minus" sign (-) */
        }

        .legendsIcon {
            padding: 1px 6px;
            font-weight: 500;
            color: #778899;
            font-size: 12px;
        }

        .presentIcon {
            background-color: #edfaed;
        }

        .absentIcon {
            background-color: #fcf0f0;
            color: #ff6666;
        }

        .offDayIcon {
            background-color: #f7f7f7;
        }

        .leaveIcon {
            background-color: #fcf2ff;
        }

        .onDutyIcon {
            background-color: #fff7eb;
        }

        .holidayIcon {
            background-color: #f2feff;
        }

        .alertForDeIcon {
            background-color: #edf3ff;
        }

        .deductionIcon {
            background-color: #fcd2ca;
        }

        .down-arrow-reg {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #f09541;
            margin-right: 5px;
        }

        .down-arrow-gra {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #5473e3;
            margin-right: 5px;
        }

        .down-arrow-ign-attendance-info {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #677a8e;
            margin-right: 5px;
        }

        .emptyday {
            color: #aeadad;
            pointer-events: none;
        }
    </style>
    <?php
    $present=0;
    $count=0;
    $flag=0;
    $isFilter=1;
    $isHoliday=0;
    $todayYear = date('Y');
    $leaveTake=0;
    $currentMonth=date('n');
    if(isset($attendanceYear) && $attendanceYear !== null) {
    $currentYear = intval($attendanceYear);
    } else {
    // Set a default value if $attendanceYear is not set
    $currentYear = 2023;
    }
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
    ?>
    <!--[if BLOCK]><![endif]--><?php for($i = 1; $i <= $daysInMonth; $i++): ?> <?php $timestamp=mktime(0, 0, 0, $currentMonth, $i, $currentYear); $dayName=date('D', $timestamp); $fullDate=date('Y-m-d', $timestamp); ?> <?php endfor; ?><!--[if ENDBLOCK]><![endif]--> <div class="row">
        <div class="search-bar" style="margin-left:30px;">
            <input type="text" wire:model="search" placeholder="Search..." wire:change="searchfilter">
        </div>
        <div class="col" style="text-align:end;">
            <button class="btn btn-primary" wire:click="downloadExcel">
                <i class="fa fa-download" aria-hidden="true"></i>
            </button>
            <select name="year" wire:model="selectedYear" wire:change="updateselectedYear">
                <option value="<?php echo e($todayYear-1); ?>"><?php echo e($todayYear-1); ?></option>
                <option value="<?php echo e($todayYear); ?>"><?php echo e($todayYear); ?></option>
                <option value="<?php echo e($todayYear+1); ?>"><?php echo e($todayYear+1); ?></option>
            </select>
            <?php
            $attendanceYearAsNumber = intval($attendanceYear);
            ?>
        </div>
</div>

<div class="row m-0">

    <div class="col-md-12">


        <button class="accordion">Legend</button>
        <div class="panel">
            <div class="row m-0 mt-3 mb-3">
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <span class="legendsIcon presentIcon">P</span>
                    </p>
                    <p class="m-0 legend-text">Present</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <span class="legendsIcon absentIcon">A</span>
                    </p>
                    <p class="m-0 legend-text">Absent</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <span class="legendsIcon offDayIcon">O</span>
                    </p>
                    <p class="m-0 legend-text">Off Day</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <span class="legendsIcon offDayIcon">R</span>
                    </p>
                    <p class="m-0 legend-text">Rest Day</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <span class="legendsIcon leaveIcon">L</span>
                    </p>
                    <p class="m-0 legend-text">Leave</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <span class="legendsIcon onDutyIcon">OD</span>
                    </p>
                    <p class="m-0 legend-text">On Duty</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <span class="legendsIcon holidayIcon">H</span>
                    </p>
                    <p class="m-0 legend-text">Holiday</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <span class="legendsIcon deductionIcon">&nbsp;&nbsp;</span>
                    </p>
                    <p class="m-0 legend-text" style="word-break: break-all;"> Deduction</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <span class="legendsIcon alertForDeIcon">&nbsp;&nbsp;</span>
                    </p>
                    <p class="m-0 legend-text">Allert for Deduction</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <span class="legendsIcon absentIcon">?</span>
                    </p>
                    <p class="m-0 legend-text">Status Unknown</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <i class="far fa-clock"></i>
                    </p>
                    <p class="m-0 legend-text">Overtime</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <i class="far fa-edit"></i>
                    </p>
                    <p class="m-0 legend-text">Override</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                    <div class="down-arrow-ign-attendance-info"></div>
                    </p>
                    <p class="m-0 legend-text">Ignored</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                    <div class="down-arrow-gra"></div>
                    </p>
                    <p class="m-0 legend-text">Grace</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                    <div class="down-arrow-reg"></div>
                    </p>
                    <p class="m-0 legend-text">Regularized</p>
                </div>
            </div>
            <div class="row m-0 mb-3">
                <h6 class="m-0 p-2 mb-2" style="background-color: #f1f4f7;font-size:12px;">Day Type</h6>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="mb-0">
                        <i class="fas fa-mug-hot" style="color: #778899;"></i>
                    </p>
                    <p class="m-1 legend-text">Rest Day</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="mb-0">
                        <i class="fas fa-tv" style="color: #778899;"></i>
                    </p>
                    <p class="m-1 legend-text">Off Day</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="mb-0">
                        <i class="fas fa-umbrella" style="color: #778899;"></i>
                    </p>
                    <p class="m-1 legend-text">Holiday</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="mb-0">
                        <i class="fas fa-calendar-day" style="color: #778899;"></i>
                    </p>
                    <p class="m-1 legend-text">Half Day</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="mb-0">
                        <i class="fas fa-battery-empty" style="color: #778899;"></i>
                    </p>
                    <p class="m-1  legend-text">IT Maintanance</p>
                </div>
            </div>
        </div>
    </div>



</div>
<div class="m-3 mt-4 row" style="margin-top:20px;">
    <div class="summary col-md-3">
        <p style="background:#ebf5ff;padding:5px 15px;font-size:0.755rem;">Summary</p>
        <table class="table">
            <thead>
                <tr>
                    <th style="width:75%;background:#ebf5ff;color:#778899;font-weight:500;line-height:2;font-size:0.825rem;">
                        Employee Name</th>
                    <th style="width:25%;background:#ebf5ff;color:#778899;font-weight:500;line-height:2;font-size:0.8255rem;">
                        P</th>
                    <!-- Add more headers as needed -->
                </tr>
            </thead>

            <tbody>
                <!-- Add table rows and data for Summary -->
                <!--[if BLOCK]><![endif]--><?php if($notFound): ?>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $Employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                $isFilter=1;
                ?>
                <tr>

                    <td style="max-width: 200px;font-weight:400; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        <?php echo e(ucwords(strtolower($emp->first_name))); ?>&nbsp;<?php echo e(ucwords(strtolower($emp->last_name))); ?><span class="text-muted">(#<?php echo e($emp->emp_id); ?>)</span><br /><span class="text-muted" style="font-size:11px;"><?php echo e(ucfirst($emp->job_title)); ?>,<?php echo e(ucfirst($emp->city)); ?></span>
                    </td>
                    <?php
                    $found = false;
                    ?>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $DistinctDatesMapCount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empId=>$d1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <!--[if BLOCK]><![endif]--><?php if($empId ==$emp->emp_id): ?>

                    <td><?php echo e($d1['date_count']); ?></td>
                    <?php
                    $found = true;
                    ?>

                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php if(!$found): ?>
                    <td>0</td>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                <?php else: ?>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $Employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>

                    <td style="max-width: 200px;font-weight:400; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        <?php echo e(ucwords(strtolower($emp->first_name))); ?>&nbsp;<?php echo e(ucwords(strtolower($emp->last_name))); ?><span class="text-muted">(#<?php echo e($emp->emp_id); ?>)</span><br /><span class="text-muted" style="font-size:11px;"><?php echo e(ucfirst($emp->job_title)); ?>,<?php echo e(ucfirst($emp->city)); ?></span>
                    </td>
                    <?php
                    $found = false;

                    ?>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $DistinctDatesMapCount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empId=>$d1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <!--[if BLOCK]><![endif]--><?php if($empId ==$emp->emp_id): ?>

                    <td><?php echo e($d1['date_count']); ?></td>
                    <?php
                    $found = true;
                    ?>

                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php if(!$found): ?>
                    <td>0</td>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <!-- Add more rows as needed -->
            </tbody>

        </table>
    </div>
    <div class="Attendance col-md-9">
        <!--[if BLOCK]><![endif]--><?php if($attendanceYear==0): ?>
        <p style="background:#ebf5ff; padding:5px 15px;font-size:0.755rem;">Attendance for <?php echo e(date("M", mktime(0, 0, 0, $currentMonth, 1))); ?>,<?php echo e($todayYear); ?></p>
        <?php else: ?>
        <p style="background:#ebf5ff; padding:5px 15px;font-size:0.755rem;">Attendance for <?php echo e(date("M", mktime(0, 0, 0, $currentMonth, 1))); ?>,<?php echo e($currentYear); ?></p>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <table class="table">
            <?php
            // Get current month and year
            $currentMonth = date('n');
            // Total number of days in the current month
            if(isset($attendanceYear) && $attendanceYear !== null) {
            $currentYear = intval($attendanceYear);
            } else {
            // Set a default value if $attendanceYear is not set
            $currentYear = 2024;
            }

            // Total number of days in the current month
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

            ?>

            <thead>
                <tr>

                    <!--[if BLOCK]><![endif]--><?php for($i = 1; $i <= $daysInMonth; $i++): ?> 
                        <?php 
                            $timestamp=mktime(0, 0, 0, $currentMonth, $i, $currentYear); 
                            $dayName=date('D', $timestamp); // Get the abbreviated day name (e.g., Sun, Mon) 
                            $fullDate=date('Y-m-d', $timestamp); // Full date in 'YYYY-MM-DD' format 
                        ?> 
                        <th style="width:75%; background:#ebf5ff; color:#778899; font-weight:500; text-align:center;">
                        <div style="font-size:0.825rem;line-height:0.8;font-weight:500;">
                            <?php echo e(str_pad($i, 2, '0', STR_PAD_LEFT)); ?>

                        </div>
                        <div style="margin-top:-5px; font-size:0.625rem;margin-top:1px;"><?php echo e($dayName); ?></div>
                        </th>

                        <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                </tr>
            </thead>

            <tbody>
                <!-- Add table rows and data for Attendance -->
                <!--[if BLOCK]><![endif]--><?php if($isFilter==1): ?>




                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $Employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <?php
                $currentYear = date('Y');
                ?>

                <!--[if BLOCK]><![endif]--><?php if($attendanceYear<=$currentYear): ?> <tr style="height:14px;background-color:#fff;">
                    <?php
                    // Get the current day of the month
                    $currentYear = date('Y');
                    $currentDay = $daysInMonth;

                    // Check if $attendanceYear is greater than the current year
                            if ($attendanceYear == $currentYear) {
                            $currentDay = date('j');
                            }
                            elseif($attendanceYear == 0) {
                            $currentDay = date('j');
                            }
                    ?>

                    <!--[if BLOCK]><![endif]--><?php for($i = 1; $i <= $currentDay; $i++): ?> 
                       <?php 
                          $timestamp=mktime(0, 0, 0, $currentMonth, $i, $SelectedYear); 
                          $dayName=date('D', $timestamp); // Get the abbreviated day name (e.g., Sun, Mon) 
                          $fullDate=date('Y-m-d', $timestamp); // Full date in 'YYYY-MM-DD' format 
                      ?> 
                    <td style="height:20px;">




                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $DistinctDatesMap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empId => $distinctDates): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                        <!--[if BLOCK]><![endif]--><?php if($empId==$e->emp_id): ?>

                        <?php

                        foreach ($distinctDates as $distinctDate) {

                        // Extract date part from created_at and distinctDate

                        $createdAtDate = date('Y-m-d', strtotime($e->created_at));


                        // Your logic for each distinct date
                        if ($distinctDate === $fullDate) {

                        $present=1;

                        }
                        }
                        ?>

                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $ApprovedLeaveRequests1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empId => $leaveDetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                        <!--[if BLOCK]><![endif]--><?php if($empId==$e->emp_id): ?>
                        <p>
                            <?php
                            foreach ($leaveDetails['dates'] as $date)
                            {
                            if($date == $fullDate)
                            {
                            $leaveTake=1;

                            }
                            }
                            ?>
                        </p>

                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $Holiday; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <!--[if BLOCK]><![endif]--><?php if($h==$fullDate): ?>

                        <?php
                        $isHoliday=1;
                        break;
                        ?>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                        <!--[if BLOCK]><![endif]--><?php if($dayName === 'Sat' || $dayName === 'Sun'): ?>
                        <p style="color:#666;font-weight:500;">O</p>

                        <?php elseif($isHoliday==1): ?>
                        <p style=" color:#666;font-weight:500;">H</p>
                        <?php elseif($leaveTake==1): ?>
                        <p style=" color:#666;font-weight:500;">L</p>
                        <?php elseif($present==1): ?>
                        <p style=" color:#666;font-weight:500;">P</p>


                        <?php else: ?>

                        <p style=" color: #f66;font-weight:500;">A</p>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        </td>

                        <?php
                        $present=0;
                        $isHoliday=0;
                        $leaveTake=0;

                        ?>

                        <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->

                        <?php
                        $EmployeesCount--;

                        ?>



                        </tr>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if($notFound): ?>
                        <td colspan="20" style="text-align: center;font-size:12px">Record not found</td>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php
                        $currentYear=date('Y');
                        ?>
                        <!--[if BLOCK]><![endif]--><?php if($attendanceYear>$currentYear): ?>
                        <div style="text-align: center; font-size: 12px;">

                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            </tbody>
        </table>
    </div>
</div>

</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleSidebarButton = document.getElementById("toggleSidebar");
        const sidebar = document.querySelector(".sidebar");

        toggleSidebarButton.addEventListener("click", function() {
            if (sidebar.style.right === "0px" || sidebar.style.right === "") {
                sidebar.style.right = "-250px"; // Hide the sidebar
            } else {
                sidebar.style.right = "0px"; // Show the sidebar
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        const toggleSidebarButton = document.getElementById("toggleSidebar");
        const closeSidebarButton = document.getElementById("closeSidebar");
        const sidebar = document.querySelector(".sidebar");

        toggleSidebarButton.addEventListener("click", function() {
            sidebar.style.right = "0px"; // Show the sidebar
        });

        closeSidebarButton.addEventListener("click", function() {
            sidebar.style.right = "-250px"; // Hide the sidebar
        });
    });
</script>
<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }

    // September 2023
</script>
</div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/attendence-master-data-new.blade.php ENDPATH**/ ?>