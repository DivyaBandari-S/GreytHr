<div>
    <div class="container">
        <div class="row m-0 p-0">
            <div class="col-md-12 text-right d-flex justify-content-end">
                <select id="yearSelect" wire:change="selectYear($event.target.value)" class="dropdownPlaceholder">
                    <option class="optionDropdown" value="<?php echo e($previousYear); ?>" <?php echo e($selectedYear == $previousYear ? 'selected' : ''); ?>><?php echo e($previousYear); ?></option>
                    <option class="optionDropdown" value="<?php echo e($initialSelectedYear); ?>" <?php echo e($selectedYear == $initialSelectedYear ? 'selected' : ''); ?>><?php echo e($initialSelectedYear); ?></option>
                    <option class="optionDropdown" value="<?php echo e($nextYear); ?>" <?php echo e($selectedYear == $nextYear ? 'selected' : ''); ?>><?php echo e($nextYear); ?></option>
                </select>
            </div>
        </div>
    </div>

    <div class="hol-container" id="calendar<?php echo e($selectedYear); ?>">
        <div class="row m-0">
            <!--[if BLOCK]><![endif]--><?php if($calendarData && $calendarData->isNotEmpty()): ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $calendarData->sortBy('date')->groupBy(function($entry) {
            return date('F Y', strtotime($entry->date));
            }); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month => $entries): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-3">
                <div class="inner-container">
                    <div class="headerMonth">
                        <h6><?php echo e($month); ?></h6>
                    </div>
                    <!--[if BLOCK]><![endif]--><?php if($entries->isEmpty() || $entries->every(function ($entry) {
                    return empty($entry->festivals);
                    })): ?>
                    <div class="no-holidays">
                        <h6>No holidays</h6>
                    </div>
                    <?php else: ?>
                    <div class="group py-3 px-3">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="fest grid-container">
                            <div class="grid-item date-container">
                                <h5 class="p-0 m-0"><?php echo e(date('d', strtotime($entry->date))); ?></h5>
                                <p class="mb-0" style="font-size: 10px;"><?php echo e(substr($entry->day, 0, 3)); ?></p>
                            </div>
                            <div class="grid-item festivals">
                                <p class="mb-0" style="font-size: 12px;"><?php echo e($entry->festivals); ?></p>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            <?php else: ?>
            <div class="bg-white rounded border p-3 d-flex flex-column align-items-center" style="margin: 50px auto; width:80%;">
                <p style="font-size: 14px; color: #721c24; font-weight: bold;">No Data Available</p>
                <p style="font-size: 12px; color:#778899;">There is no data available for the selected year. Please check again later.</p>
            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
    <div style="text-align: center; margin: 30px auto;">
        <!--[if BLOCK]><![endif]--><?php if($selectedYear == $nextYear && $calendarData->where('year', $nextYear)->isEmpty()): ?>
        <div class="bg-white rounded border p-3" style="margin: 50px auto; width:80%;">
            <p style="font-size: 16px; color: #721c24; font-weight: bold;">It’s lonely here!</p>
            <p style="font-size: 12px; color:#778899;">HR department is yet to publish the holiday list for the year <?php echo e($nextYear); ?>, check again later.</p>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>


    <script>
        $(document).ready(function() {
            // Initially, show the calendar for the selected year
            var selectedYear = $("#yearSelect").val();
            $("#calendar" + selectedYear).show();

            $("#yearSelect").change(function() {
                var selectedYear = $(this).val();
                // Hide all calendars
                $(".hol-container").hide();
                // Show the calendar based on the selected year
                $("#calendar" + selectedYear).show();
            });
        });
    </script>
</div>
<?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/holiday-calender.blade.php ENDPATH**/ ?>