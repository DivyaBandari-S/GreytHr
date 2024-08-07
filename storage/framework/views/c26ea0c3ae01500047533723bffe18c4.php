<div>
    <style>
        .people-input-group-container {
            width: 230px;
        }

        .people-search-input {
            font-size: 0.75rem;
            border-radius: 5px 0 0 5px;
            cursor: pointer;
            height: 32px;
        }


        .people-search-btn {
            height: 32px;
            width: 40px;
            position: relative;
            border-radius: 0 5px 5px 0;
            background-color: rgb(2, 17, 79);
            color: #fff;
            border: none;
            margin-right: 10px;
        }

        .people-search-icon {
            position: absolute;
            top: 9px;
            left: 11px;
            color: #fff;
        }

        .task-date-range-picker {
            width: 240px;
            margin-left: -20px;
        }

        @media (max-width: 548px) {
            .task-date-range-picker {
                margin-left: 0px;
            }
        }
    </style>

    <div class="container"
        style="margin-top:15px;width:100%; height: 600px; border: 1px solid silver; border-radius: 5px;background-color:white; overflow-x: hidden;padding-bottom: 15px;">

        <div class="nav-buttons d-flex justify-content-center" style="margin-top: 15px;">
            <ul class="nav custom-nav-tabs border">
                <li class="custom-item m-0 p-0 flex-grow-1">
                    <a href="#" style="border-top-left-radius:5px;border-bottom-left-radius:5px;"
                        class="custom-nav-link <?php echo e($activeTab === 'open' ? 'active' : ''); ?>"
                        wire:click.prevent="setActiveTab('open')">Open</a>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1">
                    <a href="#" style="border-top-right-radius:5px;border-bottom-right-radius:5px;"
                        class="custom-nav-link <?php echo e($activeTab === 'completed' ? 'active' : ''); ?>"
                        wire:click.prevent="setActiveTab('completed')">Closed</a>
                </li>
            </ul>
        </div>







        <div style="display: flex; justify-content: center; align-items: center;margin-top:5px">
            <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
                <div id="flash-message"
                    style="width: 90%; margin: 0.2rem; padding: 0.25rem; background-color: #f0fff4; border: 1px solid #68d391; color: #38a169; border-radius: 0.25rem; text-align: center;"
                    class="success-message">
                    <?php echo e(session('message')); ?>

                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    var flashMessage = document.getElementById('flash-message');

                    if (flashMessage) {
                        flashMessage.style.transition = 'opacity 0.5s ease';
                        flashMessage.style.opacity = '0';
                        setTimeout(function() {
                            flashMessage.remove();
                        }, 500); // Delay to allow the fade-out effect
                    }
                }, 5000); // 5000 milliseconds = 5 seconds
            });


            $(document).ready(function() {
                $('#date_range').datepicker({
                    format: 'yyyy-mm-dd',
                    startDate: '-30d',
                    endDate: '+0d',
                    todayHighlight: true,
                    multidateSeparator: ' to ',
                    inputs: $('#start_date, #end_date'), // Adding this line to link both inputs
                    inputs: {
                        start: $('#start_date'),
                        end: $('#end_date')
                    },
                    clearBtn: true,
                    autoclose: true,
                    toggleActive: true
                }).on('changeDate', function(e) {
                    var startDate = $('#start_date').val();
                    var endDate = $('#end_date').val();
                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('start_date', startDate);
                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('end_date', endDate);
                });
            });
        </script>

        <div style="display:flex; justify-content:flex-end;">
            <button wire:click="show"
                style="background-color:rgb(2, 17, 79); border: none; border-radius: 5px; color: white; font-size: 0.75rem; height: 30px; cursor: pointer; margin-top: 15px; margin-right: 20px;width:100px; margin-bottom: 15px;">Add
                New Task</button>
        </div>


        <!--[if BLOCK]><![endif]--><?php if($activeTab == 'open'): ?>
            <div class="filter-section" style="padding-bottom: 15px; border-radius: 5px;">
                <form class="form-inline row" style="margin-bottom: -15px;">
                    <!-- Search Box -->
                    <div class="input-group people-input-group-container">
                        <input wire:model="search" type="text" class="form-control people-search-input"
                            placeholder="Search anything.." aria-label="Search" aria-describedby="basic-addon1">
                        <div class="input-group-append">
                            <button wire:click="searchActiveTasks" class="people-search-btn" type="button">
                                <i class="fa fa-search people-search-icon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group task-date-range-picker">
                        <!-- <label for="drp" class="form-label">DateRangePicker</label> -->
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('date-component', ['start' => $start,'end' => $end]);

$__html = app('livewire')->mount($__name, $__params, ''.e('drp-' . uniqid()).'', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    </div>
                </form>
            </div>
            <div class="card-body"
                style="background-color:white;width:100%;border-radius:5px;max-height:400px;overflow-y:auto;overflow-x:hidden;margin-top: 10px;">

                <div class="table-responsive">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: rgb(2, 17, 79); color: white;">
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 7%">
                                    <i class="fa fa-angle-down" style="color: white; padding-left: 8px;"></i>
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 12%">Assignee
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: center; width: 13%">Followers
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 12%">Assigned By
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 10%">Task Name
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 12%">Due Date
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 12%">Assigned
                                    Date
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: center; width: 22%">Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php if($searchData->isEmpty()): ?>
                                <tr>
                                    <td colspan="8" style="text-align: center;">
                                        <img style="width: 10em; margin: 20px;"
                                            src="https://media.istockphoto.com/id/1357284048/vector/no-item-found-vector-flat-icon-design-illustration-web-and-mobile-application-symbol-on.jpg?s=612x612&w=0&k=20&c=j0V0ww6uBl1LwQLH0U9L7Zn81xMTZCpXPjH5qJo5QyQ="
                                            alt="No items found">
                                    </td>
                                </tr>
                            <?php else: ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $searchData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <!--[if BLOCK]><![endif]--><?php if($record->status == 'Open'): ?>
                                        <tr>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 7%;">
                                                <div class="arrow-btn" onclick="toggleAccordion(this)">
                                                    <i class="fa fa-angle-down"></i>
                                                </div>
                                            </td>

                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 12%">
                                                <?php echo e(ucfirst($record->assignee)); ?>

                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: <?php echo e($record->followers ? 'start' : 'center'); ?>; width: 13%">
                                                <?php echo e(ucfirst($record->followers) ?: '-'); ?>

                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 12%">
                                                <?php echo e(ucwords(strtolower($record->emp->first_name))); ?>

                                                <?php echo e(ucwords(strtolower($record->emp->last_name))); ?>

                                            </td>
                                            <td
                                                style="padding: 10px; border:none;font-size: 0.75rem; text-align: start; width: 10%">
                                                <?php echo e(ucfirst($record->task_name)); ?>

                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 12%;">
                                                <?php echo e(\Carbon\Carbon::parse($record->due_date)->format('d M, Y')); ?>

                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 12%">
                                                <?php echo e(\Carbon\Carbon::parse($record->created_at)->format('d M, Y')); ?>

                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: center; width: 22%">
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $record->comments ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo e($comment->comment); ?>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                <!-- Add Comment link to trigger modal -->
                                                <button type="button"
                                                    wire:click.prevent="openAddCommentModal('<?php echo e($record->id); ?>')"
                                                    class="submit-btn" data-toggle="modal"
                                                    data-target="#exampleModalCenter">Comment</button>
                                                <button wire:click="openForTasks('<?php echo e($record->id); ?>')"
                                                    style="border:1px solid rgb(2, 17, 79);width:80px; padding: 5px 0.75rem;"
                                                    class="cancel-btn">Close</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" class="m-0 p-0"
                                                style="background-color: #fff; padding: 0; margin: 0;">
                                                <div class="accordion-content mt-0"
                                                    style="display: none; padding: 0 10px;margin-bottom:20px;">
                                                    <!-- Content for accordion body -->
                                                    <table class="rounded border"
                                                        style="margin-top: 20px; width: 100%; border-collapse: collapse;">
                                                        <thead class="py-0"
                                                            style="background-color: #ecf9ff; box-shadow: 1px 0px 2px 0px rgba(0, 0, 0, 0.2); border-bottom: 1px solid #ccc; padding: 5px;">
                                                            <tr style="color: #778899;">
                                                                <th
                                                                    style="font-weight: 500; width: 22%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    Priority</th>
                                                                <th
                                                                    style="font-weight: 500; width: 18%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    Due Date</th>
                                                                <th
                                                                    style="font-weight: 500; width: 18%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    Subject</th>
                                                                <th
                                                                    style="font-weight: 500; width: 15%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    Description</th>
                                                                <th
                                                                    style="font-weight: 500; width: 38%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    Attach</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td
                                                                    style="border: none; width: 22%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    <?php echo e($record->priority); ?>

                                                                </td>
                                                                <td
                                                                    style="border: none; width: 18%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    <?php echo e(\Carbon\Carbon::parse($record->due_date)->format('d M, Y')); ?>

                                                                </td>
                                                                <td
                                                                    style="border: none; width: 18%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    <?php echo e(ucfirst($record->subject ?? '-')); ?>

                                                                </td>
                                                                <td
                                                                    style="border: none; width: 15%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    <?php echo e(ucfirst($record->description ?? '-')); ?>

                                                                </td>
                                                                <td
                                                                    style="border: none; width: 38%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    <!--[if BLOCK]><![endif]--><?php if($record->file_path): ?>
                                                                        <a href="<?php echo e(asset('storage/' . $record->file_path)); ?>"
                                                                            target="_blank"
                                                                            style="text-decoration: none; color: #007BFF;">View
                                                                            File</a>
                                                                    <?php else: ?>
                                                                        N/A
                                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <!--[if BLOCK]><![endif]--><?php if($activeTab == 'completed'): ?>
            <div class="filter-section" style="padding-bottom: 15px; border-radius: 5px;">
                <form wire:submit.prevent="applyFilters" class="form-inline row" style="margin-bottom: -15px;">
                    <!-- Search Box -->
                    <div class="input-group people-input-group-container">
                        <input wire:model="closedSearch" type="text" class="form-control people-search-input"
                            placeholder="Search anything.." aria-label="Search" aria-describedby="basic-addon1">
                        <div class="input-group-append">
                            <button wire:click="searchCompletedTasks" class="people-search-btn" type="button">
                                <i class="fa fa-search people-search-icon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group task-date-range-picker">

                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('date-component', ['start' => $start,'end' => $end]);

$__html = app('livewire')->mount($__name, $__params, ''.e('drp-' . uniqid()).'', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    </div>


                </form>
            </div>
            <div class="card-body"
                style="background-color:white;width:100%;border-radius:5px;max-height:300px;overflow-y:auto;overflow-x:hidden;margin-top: 10px;">

                <div class="table-responsive">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: rgb(2, 17, 79); color: white;">
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 7%">
                                    <i class="fa fa-angle-down" style="color: white; padding-left: 8px;"></i>
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 10%">Assignee
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: center; width: 10%">Followers
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 10%">Assigned By
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 10%">Task Name
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 10%">Due Date
                                </th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 10%">Assigned
                                    Date</th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: start; width: 10%">Closed
                                    Date</th>
                                <th style="padding: 7px; font-size: 0.75rem; text-align: center; width: 23%">Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php if($searchData->isEmpty()): ?>
                                <tr>
                                    <td colspan="9" style="text-align: center;">
                                        <img style="width: 10em; margin: 20px;"
                                            src="https://media.istockphoto.com/id/1357284048/vector/no-item-found-vector-flat-icon-design-illustration-web-and-mobile-application-symbol-on.jpg?s=612x612&w=0&k=20&c=j0V0ww6uBl1LwQLH0U9L7Zn81xMTZCpXPjH5qJo5QyQ="
                                            alt="No items found">
                                    </td>
                                </tr>
                            <?php else: ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $searchData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <!--[if BLOCK]><![endif]--><?php if($record->status == 'Completed'): ?>
                                        <tr>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 7%;">
                                                <div class="arrow-btn" onclick="toggleAccordion(this)">
                                                    <i class="fa fa-angle-down"></i>
                                                </div>
                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 10%">
                                                <?php echo e(ucfirst($record->assignee)); ?>

                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: <?php echo e($record->followers ? 'start' : 'center'); ?>; width: 10%">
                                                <?php echo e(ucfirst($record->followers) ?: '-'); ?>

                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 10%">
                                                <?php echo e(ucwords(strtolower($record->emp->first_name))); ?>

                                                <?php echo e(ucwords(strtolower($record->emp->last_name))); ?>

                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 10%">
                                                <?php echo e(ucfirst($record->task_name)); ?>

                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 10%; color: <?php echo e(\Carbon\Carbon::parse($record->updated_at)->startOfDay()->gt(\Carbon\Carbon::parse($record->due_date)->startOfDay())? 'red': 'inherit'); ?>;">
                                                <?php echo e(\Carbon\Carbon::parse($record->due_date)->format('d M, Y')); ?>

                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 10%">
                                                <?php echo e(\Carbon\Carbon::parse($record->created_at)->format('d M, Y')); ?>

                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: start; width: 10%">
                                                <?php echo e(\Carbon\Carbon::parse($record->updated_at)->format('d M, Y')); ?>

                                            </td>
                                            <td
                                                style="padding: 10px; border:none; font-size: 0.75rem; text-align: center; width: 23%">
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $record->comments ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo e($comment->comment); ?>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                <!-- Add Comment link to trigger modal -->
                                                <button type="button"
                                                    wire:click.prevent="openAddCommentModal('<?php echo e($record->id); ?>')"
                                                    class="submit-btn" data-toggle="modal"
                                                    data-target="#exampleModalCenter">Comment</button>
                                                <button wire:click="closeForTasks('<?php echo e($record->id); ?>')"
                                                    style="border:1px solid rgb(2,17,79); width: 80px;  padding: 5px 0.75rem;"
                                                    class="cancel-btn1">Reopen</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="9" class="m-0 p-0"
                                                style="background-color: #fff; padding: 0; margin: 0;">
                                                <div class="accordion-content mt-0"
                                                    style="display: none; padding: 0 10px;margin-bottom:20px;">
                                                    <!-- Content for accordion body -->
                                                    <table class="rounded border"
                                                        style="margin-top: 20px; width: 100%; border-collapse: collapse;">
                                                        <thead class="py-0"
                                                            style="background-color: #ecf9ff; box-shadow: 1px 0px 2px 0px rgba(0, 0, 0, 0.2); border-bottom: 1px solid #ccc; padding: 5px;">
                                                            <tr style="color: #778899;">
                                                                <th
                                                                    style="font-weight: 500; width: 20%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    Priority</th>
                                                                <th
                                                                    style="font-weight: 500; width: 20%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    Due Date</th>
                                                                <th
                                                                    style="font-weight: 500; width: 20%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    Subject</th>
                                                                <th
                                                                    style="font-weight: 500; width: 20%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    Description</th>
                                                                <th
                                                                    style="font-weight: 500; width: 20%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    Attach</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td
                                                                    style="border: none; width: 20%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    <?php echo e($record->priority); ?>

                                                                </td>
                                                                <td
                                                                    style="border: none; width: 20%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    <?php echo e(\Carbon\Carbon::parse($record->due_date)->format('d M, Y')); ?>

                                                                </td>
                                                                <td
                                                                    style="border: none; width: 20%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    <?php echo e(ucfirst($record->subject ?? '-')); ?>

                                                                </td>
                                                                <td
                                                                    style="border: none; width: 20%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    <?php echo e(ucfirst($record->description ?? '-')); ?>

                                                                </td>
                                                                <td
                                                                    style="border: none; width: 20%; padding: 10px; font-size: 0.75rem; text-align: center;">
                                                                    <!--[if BLOCK]><![endif]--><?php if($record->file_path): ?>
                                                                        <a href="<?php echo e(asset('storage/' . $record->file_path)); ?>"
                                                                            target="_blank"
                                                                            style="text-decoration: none; color: #007BFF;">View
                                                                            File</a>
                                                                    <?php else: ?>
                                                                        N/A
                                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>
                    </table>
                </div>

            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <!--[if BLOCK]><![endif]--><?php if($showDialog): ?>
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-between"
                            style="background-color: rgb(2, 17, 79); color: white; height: 40px; padding: 8px;">
                            <h5 class="modal-title" style="font-size: 15px; margin: 0;"><b>Add Task</b></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                wire:click="close"
                                style="background: none; border: none; color: white; font-size: 30px; cursor: pointer;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="task-container">
                                <!-- Task Name -->
                                <div class="form-group" style="margin-bottom: 10px;">
                                    <label for="task_name" style="font-size: 13px; color: #778899;">Task Name*</label>
                                    <input type="text" wire:model.debounce.0ms="task_name"
                                        wire:input="autoValidate" class="placeholder-small"
                                        placeholder="Enter task name"
                                        style="width: 100%; font-size: 0.75rem; padding: 5px; outline: none; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['task_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger">Task name is required</span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>


                                <!-- Assignee -->
                                <div wire:click="forAssignee" class="form-group"
                                    style="color:grey;font-size:0.75rem;cursor:pointer; margin-bottom: 10px;">
                                    <label for="assignee"
                                        style="font-size: 13px;color:#778899; margin-bottom: 10px;">Assignee*</label>
                                    <br>
                                    <i wire:change="autoValidate" class="fa fa-user icon" id="profile-icon"></i>
                                    <!--[if BLOCK]><![endif]--><?php if($showRecipients): ?>
                                        <strong style="font-size: 12;">Selected assignee:
                                        </strong><?php echo e($selectedPeopleName); ?>

                                    <?php else: ?>
                                        <a class="hover-link" style="color:black;cursor:pointer"> Add Assignee</a>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]--> <br>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['assignee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger">Assignee is required</span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <!--[if BLOCK]><![endif]--><?php if($assigneeList): ?>
                                    <div
                                        style="border-radius:5px;background-color:grey;padding:8px;width:350px;max-height:250px;overflow-y:auto; ">
                                        <div class="input-group d-flex" style="margin-bottom: 10px;">
                                            <div class="input-group people-input-group-container"
                                                style="width: 300px;padding-left: 10px;">
                                                <input wire:input="filter" wire:model.debounce.0ms="searchTerm"
                                                    type="text" class="form-control people-search-input"
                                                    placeholder="Search employee name / Id" aria-label="Search"
                                                    aria-describedby="basic-addon1">
                                                <div class="input-group-append">
                                                    <button wire:change="autoValidate" wire:click="filter"
                                                        class="people-search-btn" type="button">
                                                        <i class="fa fa-search people-search-icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div wire:change="autoValidate" wire:click="closeAssignee"
                                                aria-label="Close">
                                                <i class="fa fa-times"
                                                    style="font-size: 20px;margin-top: 5px;color: #fff; cursor: pointer;"
                                                    aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php if($peopleData->isEmpty()): ?>
                                            <div class="container"
                                                style="text-align: center; color: white; font-size: 0.75rem;">No People
                                                Found
                                            </div>
                                        <?php else: ?>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $peopleData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $people): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div wire:click="selectPerson('<?php echo e($people->emp_id); ?>')"
                                                    class="container"
                                                    style="cursor: pointer; background-color: darkgrey; padding: 5px; margin-bottom: 8px; width: 300px; border-radius: 5px;">
                                                    <div class="row align-items-center">
                                                        <label for="person-<?php echo e($people->emp_id); ?>"
                                                            style="width: 100%; display: flex; align-items: center; margin: 0;">
                                                            <div class="col-auto">
                                                                <input type="radio"
                                                                    id="person-<?php echo e($people->emp_id); ?>"
                                                                    wire:change="autoValidate" wire:model="assignee"
                                                                    value="<?php echo e($people->emp_id); ?>">
                                                            </div>
                                                            <div class="col-auto">
                                                                <img class="profile-image" style="margin-left: 10px;"
                                                                    src="<?php echo e(!is_null($people->image) && filter_var($people->image, FILTER_VALIDATE_URL)
                                                                        ? $people->image
                                                                        : (!empty($people->image)
                                                                            ? Storage::url($people->image)
                                                                            : ($people->gender == 'Male'
                                                                                ? 'https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png'
                                                                                : 'https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0'))); ?>"
                                                                    alt="">
                                                            </div>
                                                            <div class="col">
                                                                <h6 class="username"
                                                                    style="font-size: 0.75rem; color: white;">
                                                                    <?php echo e(ucwords(strtolower($people->first_name))); ?>

                                                                    <?php echo e(ucwords(strtolower($people->last_name))); ?>

                                                                </h6>
                                                                <p class="mb-0"
                                                                    style="font-size: 0.75rem; color: white;">
                                                                    (#<?php echo e($people->emp_id); ?>)
                                                                </p>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <!--[if BLOCK]><![endif]--><?php if($selectedPersonClients->isEmpty()): ?>
                                        <?php else: ?>
                                            <div style="margin-bottom: 10px;">
                                                <label style="font-size: 13px;color:#778899" for="clientSelect">Select
                                                    Client*</label>
                                                <select wire:change="showProjects"
                                                    style="width: 100%;font-size:0.75rem;padding:5px;outline:none;border:1px solid #ccc;border-radius:5px;"
                                                    id="clientSelect" wire:model="client_id">
                                                    <option value="">Select client</option>
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $selectedPersonClients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option style="color:#778899;"
                                                            value="<?php echo e($client->client->client_id); ?>">
                                                            <?php echo e($client->client->client_name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                </select>
                                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="text-danger">Client ID is required</span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                    </div>
                                    <div class="col-md-6">
                                        <!--[if BLOCK]><![endif]--><?php if($selectedPersonClientsWithProjects->isEmpty()): ?>
                                        <?php else: ?>
                                            <div style="margin-bottom: 10px;">
                                                <label style="font-size: 13px;color:#778899" for="clientSelect">Select
                                                    Project*</label>
                                                <select wire:change="autoValidate"
                                                    style="width: 100%;font-size:0.75rem;padding:5px;outline:none;border:1px solid #ccc;border-radius:5px;"
                                                    id="clientSelect" wire:model="project_name">
                                                    <option value="">Select project</option>
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $selectedPersonClientsWithProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option style="color:#778899;"
                                                            value="<?php echo e($project->project_name); ?>">
                                                            <?php echo e($project->project_name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                </select>
                                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['project_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="text-danger">Project name is
                                                        required</span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

                                            </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>

                                <!-- Priority -->
                                <div class="priority-container" style="margin-top: 0px;">
                                    <div class="row ">
                                        <div class="col-md-4">
                                            <label for="priority"
                                                style="font-size: 13px;color:#778899; margin-left: 0px; margin-top: 0px; padding: 0 10px 0 0;">Priority*</label>
                                        </div>
                                        <div class="col-md-8 mt-1">
                                            <div id="priority"
                                                style="display: flex; align-items: center; margin-top: 0px;">
                                                <div class="priority-option" style="margin-left: 0px; padding: 0;">
                                                    <input type="radio" id="low-priority" name="priority"
                                                        wire:change="autoValidate" wire:model="priority"
                                                        value="Low">
                                                    <span
                                                        style="font-size: 0.75rem;color:#778899; padding: 0;margin-left:5px"
                                                        class="text-xs">Low</span>
                                                </div>
                                                <div class="priority-option" style="margin-left: 20px; padding: 0;">
                                                    <input type="radio" id="medium-priority" name="priority"
                                                        wire:change="autoValidate" wire:model="priority"
                                                        value="Medium">
                                                    <span
                                                        style="font-size: 0.75rem;color:#778899; padding: 0;margin-left:5px"
                                                        class="text-xs">Medium</span>
                                                </div>
                                                <div class="priority-option" style="margin-left: 20px; padding: 0;">
                                                    <input type="radio" id="high-priority" name="priority"
                                                        wire:change="autoValidate" wire:model="priority"
                                                        value="High">
                                                    <span
                                                        style="font-size: 0.75rem;color:#778899; padding: 0;margin-left:5px"
                                                        class="text-xs">High</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger">Priority is
                                        required</span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                <!-- Due Date -->
                                <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="form-label"
                                                style="font-size: 13px;color:#778899; margin-left: 0px; margin-top: 0px; padding: 0 10px 0 0;">Due
                                                Date*</label>
                                            <br>
                                            <input wire:change="autoValidate" type="date" wire:model="due_date"
                                                class="placeholder-small"
                                                style="width: 100%;font-size:0.75rem;padding:5px;outline:none;border:1px solid #ccc;border-radius:5px;"
                                                min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>">
                                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['due_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger">Due date is required</span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

                                        </div>
                                    </div>
                                    <div class="col">
                                        <!-- Tags -->
                                        <div class="form-group">
                                            <label for="tags"
                                                style="font-size: 13px;color:#778899; margin-left: 0px; margin-top: 0px; padding: 0 10px 0 0;">Tags</label>

                                            <input wire:change="autoValidate" type="text" wire:model="tags"
                                                placeholder="Enter tags" class="placeholder-small"
                                                style="width: 100%;font-size:0.75rem;padding:6px;outline:none;border:1px solid #ccc;border-radius:5px;margin-top: 5px;">
                                        </div>
                                    </div>
                                </div>

                                <div wire:click="forFollowers" class="form-group"
                                    style=" color: grey; font-size: 0.75rem">
                                    <label for="assignee"
                                        style="font-size: 13px;color:#778899; margin-left: 0px; margin-top: 0px; padding: 0 10px 0 0;">Followers</label>
                                    <br>
                                    <i wire:change="autoValidate" style="margin-top: 10px; cursor: pointer" class="fas fa-user icon"
                                        id="profile-icon"></i>
                                    <!--[if BLOCK]><![endif]--><?php if($showFollowers): ?>
                                        <strong style="font-size: 12;">Selected Followers:
                                        </strong><?php echo e(implode(', ', array_unique($selectedPeopleNamesForFollowers))); ?>

                                    <?php else: ?>
                                        <a class="hover-link" style="color:black;cursor:pointer"> Add Followers</a>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <!--[if BLOCK]><![endif]--><?php if($followersList): ?>
                                    <div
                                        style="border-radius:5px;background-color:grey;padding:8px;width:350px;max-height:250px;overflow-y:auto; ">
                                        <div class="input-group d-flex" style="margin-bottom: 10px;">
                                            <div class="input-group people-input-group-container"
                                                style="width: 300px;padding-left: 10px;">
                                                <input wire:input="filter" wire:model.debounce.0ms="searchTerm"
                                                    type="text" class="form-control people-search-input"
                                                    placeholder="Search employee name / Id" aria-label="Search"
                                                    aria-describedby="basic-addon1">
                                                <div class="input-group-append">
                                                    <button wire:change="autoValidate" wire:click="filter"
                                                        class="people-search-btn" type="button">
                                                        <i class="fa fa-search people-search-icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div wire:change="autoValidate" wire:click="closeFollowers"
                                                aria-label="Close">
                                                <i class="fa fa-times"
                                                    style="font-size: 20px;margin-top: 5px;color: #fff; cursor: pointer;"
                                                    aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php if($peopleData->isEmpty()): ?>
                                            <div class="container"
                                                style="text-align: center; color: white; font-size: 0.75rem;">No People
                                                Found
                                            </div>
                                        <?php else: ?>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $peopleData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $people): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div wire:model="cc_to"
                                                    wire:click="selectPersonForFollowers('<?php echo e($people->emp_id); ?>')"
                                                    class="container"
                                                    style="cursor: pointer; background-color: darkgrey; padding: 5px; margin-bottom: 8px; width: 300px; border-radius: 5px;">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <input type="checkbox"
                                                                wire:model="selectedPeopleForFollowers"
                                                                value="<?php echo e($people->emp_id); ?>">
                                                        </div>
                                                        <div class="col-auto">
                                                            <img class="profile-image"
                                                                src="<?php echo e(!is_null($people->image) && filter_var($people->image, FILTER_VALIDATE_URL)
                                                                    ? $people->image
                                                                    : (!empty($people->image)
                                                                        ? Storage::url($people->image)
                                                                        : ($people->gender == 'Male'
                                                                            ? 'https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png'
                                                                            : 'https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0'))); ?>"
                                                                alt="">
                                                        </div>
                                                        <div class="col">
                                                            <h6 class="username"
                                                                style="font-size: 0.75rem; color: white;">
                                                                <?php echo e(ucwords(strtolower($people->first_name))); ?>

                                                                <?php echo e(ucwords(strtolower($people->last_name))); ?>

                                                            </h6>
                                                            <p class="mb-0"
                                                                style="font-size: 0.75rem; color: white;">
                                                                (#<?php echo e($people->emp_id); ?>)
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                                <div class="form-group">
                                    <label for="Subject"
                                        style="font-size: 13px;color:#778899; margin-left: 0px; margin-top: 10px; padding: 0 10px 0 0;">Subject</label>
                                    <br>
                                    <input wire:change="autoValidate" wire:model="subject" class="placeholder-small"
                                        placeholder="Enter subject" rows="4"
                                        style="width: 100%;font-size:0.75rem;padding:5px;outline:none;border:1px solid #ccc;border-radius:5px;margin-top: 5px;"></input>
                                </div>
                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description"
                                        style="font-size: 13px;color:#778899; margin-left: 0px; margin-top: 10px; padding: 0 10px 0 0;">Description</label>
                                    <br>
                                    <textarea wire:change="autoValidate" wire:model="description" class="placeholder-small"
                                        placeholder="Add description" rows="4"
                                        style="width: 100%;font-size:0.75rem;padding:5px;outline:none;border:1px solid #ccc;border-radius:5px;margin-top: 5px;"></textarea>
                                </div>

                                <!-- File Input -->
                                <div id="flash-message-container" style="display: none;" class="alert alert-success"
                                    role="alert"></div>
                                <div class="row">
                                    <div class="col">
                                        <label for="fileInput"
                                            style="cursor: pointer; font-size: 13px;color:#778899; margin-left: 0px; margin-top: 0px; padding: 0 10px 0 0;">
                                            Attach Image
                                        </label>
                                    </div>
                                </div>


                                <input wire:change="autoValidate" style="font-size: 0.75rem;" wire:model="image"
                                    type="file" accept="image/*" onchange="handleImageChange()">

                                <div style="text-align: center;margin-bottom:10px">
                                    <button style="margin-top: 5px;" wire:click="submit" class="submit-btn"
                                        type="button" name="link">Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="modal-backdrop fade show blurred-backdrop"></div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <!-- Add Comment Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showModal): ?>
        <div wire:ignore.self class="modal fade show" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display:block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #eceff3;">
                        <h6 class="modal-title" id="exampleModalLongTitle">Add Comment</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            wire:click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php if(session()->has('comment_message')): ?>
                        <div id="flash-comment-message"
                            style="margin: 0.2rem; padding: 0.25rem; background-color: #f0fff4; border: 1px solid #68d391; color: #38a169; border-radius: 0.25rem; text-align: center;">
                            <?php echo e(session('comment_message')); ?>

                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <div class="modal-body">
                        <form wire:submit.prevent="addComment">
                            <div class="form-group">
                                <label for="comment"
                                    style="color: #778899;font-size:13px;font-weight:500;">Comment:</label>
                                <p>
                                    <textarea class="form-control" id="comment" wire:model.lazy="newComment"
                                        wire:keydown.debounce.500ms="validateField('newComment')"></textarea>
                                </p>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['newComment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="submit-btn" style="font-size:0.75rem;">Submit</button>
                            </div>
                        </form>
                        <div style="max-height: 300px;overflow-y:auto;">
                            <!--[if BLOCK]><![endif]--><?php if($taskComments->count() > 0): ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $taskComments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="comment mb-4 mt-2">
                                        <div class="d-flex align-items-center gap-5">
                                            <div class="col-md-4 p-0 comment-details">
                                                <p style="color: #000;font-size:0.75rem;font-weight:500;margin-bottom:0;"
                                                    class="truncate-text"
                                                    title="<?php echo e($comment->employee->full_name); ?>">
                                                    <?php echo e($comment->employee->full_name); ?>

                                                </p>
                                            </div>
                                            <div class=" col-md-3 p-0 comment-time">
                                                <span
                                                    style="color: #778899;font-size:10px;font-weight:normal;margin-left:15px;"><?php echo e($comment->created_at->diffForHumans()); ?></span>
                                            </div>
                                            <!--[if BLOCK]><![endif]--><?php if(Auth::guard('emp')->user()->emp_id == $comment->emp_id): ?>
                                                <div class="col-md-2 p-0 comment-actions">
                                                    <button class="comment-btn"
                                                        wire:click="openEditCommentModal(<?php echo e($comment->id); ?>)">
                                                        <i class="fas fa-edit"
                                                            style="color: #778899;height:7px;width:7px;"></i>
                                                    </button>
                                                    <button class="comment-btn"
                                                        wire:click="deleteComment(<?php echo e($comment->id); ?>)">
                                                        <i class="fas fa-trash"
                                                            style="color: #778899;height:7px;width:7px;"></i>
                                                    </button>
                                                </div>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <div class="col p-0 comment-content">
                                            <!--[if BLOCK]><![endif]--><?php if($editCommentId == $comment->id): ?>
                                                <!-- Input field for editing -->
                                                <input class="form-control" wire:model.defer="newComment"
                                                    type="text">
                                                <!-- Button to update comment -->
                                                <button class="update-btn p-1"
                                                    wire:click="updateComment(<?php echo e($comment->id); ?>)">Update</button>
                                                <button class="btn btn-secondary p-1 m-0" wire:click="cancelEdit"
                                                    style="font-size: 0.75rem;">Cancel</button>
                                            <?php else: ?>
                                                <!-- Display comment content -->
                                                <p style="margin-bottom: 0;font-size:0.75rem;color:#515963;">
                                                    <?php echo e(ucfirst($comment->comment)); ?>

                                                </p>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>




<script>
    function toggleAccordion(element) {
        const accordionContent = element.closest('tr').nextElementSibling.querySelector('.accordion-content');
        const arrowIcon = element.querySelector('i');

        if (accordionContent.style.display === 'none') {
            accordionContent.style.display = 'block';
            arrowIcon.classList.remove('fa-angle-down');
            arrowIcon.classList.add('fa-angle-up');
            element.classList.add('active');
        } else {
            accordionContent.style.display = 'none';
            arrowIcon.classList.remove('fa-angle-up');
            arrowIcon.classList.add('fa-angle-down');
            element.classList.remove('active');
        }
    }

    function handleImageChange() {
        // Display a flash message
        showFlashMessage('Image uploaded successfully!');
    }

    function showFlashMessage(message) {
        const container = document.getElementById('flash-message-container');
        container.textContent = message;
        container.style.fontSize = '0.75rem';
        container.style.display = 'block';

        // Hide the message after 3 seconds
        setTimeout(() => {
            container.style.display = 'none';
        }, 3000);
    }
</script>
</div>
<?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/tasks.blade.php ENDPATH**/ ?>