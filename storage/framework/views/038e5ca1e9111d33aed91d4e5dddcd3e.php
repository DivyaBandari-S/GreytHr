<div>
    <!--[if BLOCK]><![endif]--><?php if(session()->has('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <style>
        .table thead {
            border: none;
        }

        .table .text {
            font-size: 0.875rem;
            color: #778899;
            font-weight: 600;
        }

        .table th {
            text-align: center;
            height: 15px;
            border: none;
        }

        .table td:hover {
            background-color: #ecf7fe;
            cursor: pointer;
        }

        .table tbody td {
            width: 75px;
            height: 80px;
            border-color: #c5cdd4;
            font-weight: 500;
            font-size: 13px;
            vertical-align: top;
            position: relative;
            text-align: left;
        }
    </style>

    <div class="container-leave">
        <div class="sidebar-cal" style="width: <?php echo e($showDialog ? '250px' : '0'); ?>;display: flex; flex-direction: column; height: 100vh;">
            <div class="header">
                <a href="javascript:void(0)" class="closebtn" wire:click="close" style="margin-right: 10px;">×</a>
                <h6>Apply Filter</h6>
            </div>
            <div class="main-content">
                <label for="locations" style="font-size: 0.825rem; color: #778899; font-weight: 500; margin-top: 20px; margin-right: 10px;">Location</label>
                <div wire:click="openLocations" class="loc-dropdown">
                    <div style="position: relative;">
                        <div style="display: flex;justify-content:space-between; align-items: center;">
                            <p>
                                <!--[if BLOCK]><![endif]--><?php if($this->isSelectedAll()): ?>
                                All
                                <?php else: ?>
                                <?php echo e(implode(', ', $selectedLocations)); ?>

                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </p>
                            <!-- Solid down arrow -->
                            <svg width="15" height="15" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 13L6 9H14L10 13Z" fill="#778899" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!--[if BLOCK]><![endif]--><?php if($showLocations): ?>
                <div class="locations">
                    <div style="display: flex;justify-content:space-between; text-align:center;align-items: center;padding:0;height:40px;position:relative;">
                        <p style="font-size:0.725rem; padding:0;color:#148aff;font-weight:500;">Select Location</p>
                        <a href="#" wire:click="closeLocations" style="top:-5px; right:5px;position:absolute;">×</a>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:10px;">
                        <label>
                            <input type="checkbox" wire:click="toggleSelection('All')" wire:model="selectedLocations" value="All"> All
                        </label>
                        <label>
                            <input type="checkbox" wire:click="toggleSelection('Hyderabad')" wire:model="selectedLocations" value="Hyderabad"> Hyderabad
                        </label>
                        <label>
                            <input type="checkbox" wire:click="toggleSelection('Udaipur')" wire:model="selectedLocations" value="Udaipur"> Udaipur
                        </label>
                        <label>
                            <input type="checkbox" wire:click="toggleSelection('Rajasthan')" wire:model="selectedLocations" value="Rajasthan"> Rajasthan
                        </label>
                    </div>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!-- Department -->
                <label for="departments" style="font-size: 0.825rem; color: #778899; font-weight: 500; margin-top: 20px; margin-right: 10px;">Department</label>
                <div wire:click="openDept" class="loc-dropdown">
                    <div style="position: relative;">
                        <div style="display: flex;justify-content:space-between; align-items: center;">
                            <p>
                                <!--[if BLOCK]><![endif]--><?php if($this->isSelectedAllDept()): ?>
                                All
                                <?php else: ?>
                                <?php echo e(implode(', ', $selectedDepartments)); ?>

                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </p>
                            <!-- Solid down arrow -->
                            <svg width="15" height="15" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 13L6 9H14L10 13Z" fill="#778899" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!--[if BLOCK]><![endif]--><?php if($showDepartment): ?>
                <div class="departments">
                    <div style="display: flex;justify-content:space-between; text-align:center;align-items: center;padding:0;height:40px;position:relative">
                        <p style="font-size:0.725rem;padding:0;color:#148aff;font-weight:500;">Select Department</p>
                        <a href="#" wire:click="closeDept" style="top:-5px; right:5px;position:absolute;">×</a>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:10px;">
                        <label>
                            <input type="checkbox" wire:click="toggleDeptSelection('All')" wire:model="selectedDepartments" value="All"> All
                        </label>
                        <label>
                            <input type="checkbox" wire:click="toggleDeptSelection('Development')" wire:model="selectedDepartments" value="Development"> Development
                        </label>
                        <label>
                            <input type="checkbox" wire:click="toggleDeptSelection('Sales')" wire:model="selectedDepartments" value="Sales"> Sales
                        </label>
                        <label>
                            <input type="checkbox" wire:click="toggleDeptSelection('IT')" wire:model="selectedDepartments" value="IT"> IT
                        </label>
                    </div>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                <!-- Buttons -->
                <div style="margin-top: 30px;">
                    <button class="btn-1" wire:click="searchData">Apply</button>
                    <button class="btn-2" wire:click="resetFilter">Reset</button>
                </div>
            </div>
        </div>

        <div class="button-container">
            <!-- Dropdown for filter selection -->
            <div class="filter-container">
                <label for="filterType" style="color: #778899; font-size: 0.825rem;font-weight:500;">Filter Type:</label>
                <select style="font-size:0.855rem;padding:2px 10px;cursor:pointer;outline:none;" wire:model.lazy="filterCriteria" id="filterType" class="filter-dropdown" wire:change="filterBy($event.target.value)">
                    <option style="font-size:0.825rem;padding:10px 15px;" value="Me" <?php if($filterCriteria==='Me' ): ?> selected <?php endif; ?>>Me</option>
                    <option style="font-size:0.825rem;padding:10px 15px;" value="MyTeam" <?php if($filterCriteria==='MyTeam' ): ?> selected <?php endif; ?>>My Team</option>
                    <!-- Add more options as needed -->
                </select>
            </div>


            <button class="submit-btn px-4">
                <i class="bx bx-download" aria-hidden="true" wire:click="downloadexcelforLeave" style="font-size:16px;"></i>
            </button>
        </div>
        <div class="row" style="margin:0;padding:0;">
            <div class="col-md-7">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="calendar-heading-container">
                        <button wire:click="previousMonth" class="nav-btn">&lt; Prev</button>
                        <h5><?php echo e(date('F Y', strtotime("$year-$month-1"))); ?></h5>
                        <button wire:click="nextMonth" class="nav-btn">Next &gt;</button>
                    </div>
                </div>
                <!-- Calendar -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text">Sun</th>
                                <th class="text">Mon</th>
                                <th class="text">Tue</th>
                                <th class="text">Wed</th>
                                <th class="text">Thu</th>
                                <th class="text">Fri</th>
                                <th class="text">Sat</th>
                            </tr>
                        </thead>
                        <tbody id="calendar-body">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $calendar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $week; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $carbonDate = \Carbon\Carbon::createFromDate($year, $month, $day['day']);
                                $isCurrentMonth = $day['isCurrentMonth'];
                                $isWeekend = in_array($carbonDate->dayOfWeek, [0, 6]); // 0 for Sunday, 6 for Saturday
                                $isActiveDate = ($selectedDate === $carbonDate->toDateString());
                                ?>
                                <td wire:click="dateClicked($event.target.textContent)" class="calendar-date<?php echo e($selectedDate === $day['day'] ? ' active-date' : ''); ?>" data-date="<?php echo e($day['day']); ?>" style="color: <?php echo e($isCurrentMonth ? ($isWeekend ? '#9da4a9' : 'black') : '#9da4a9'); ?>;">

                                    <!--[if BLOCK]><![endif]--><?php if($day): ?>
                                    <div>
                                        <!--[if BLOCK]><![endif]--><?php if($day['isToday']): ?>
                                        <div style="background-color: #007bff; color: white; border-radius: 50%; width: 24px; height: 24px; text-align: center; line-height: 24px; ">
                                            <?php echo e(str_pad($day['day'], 2, '0', STR_PAD_LEFT)); ?>

                                        </div>
                                        <?php else: ?>
                                        <?php echo e(str_pad($day['day'], 2, '0', STR_PAD_LEFT)); ?>

                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <div class="circle-holiday<?php echo e($day['isPublicHoliday'] ? ' IRIS' : ''); ?>">
                                            <!-- Render your content -->
                                        </div>
                                        <?php
                                        $leaveCount = $filterCriteria === 'Me' ? $day['leaveCountMe'] : $day['leaveCountMyTeam'];
                                        ?>
                                        <!--[if BLOCK]><![endif]--><?php if($leaveCount > 0): ?>
                                        <div class="circle-greys">
                                            <!-- Render your grey circle -->
                                            <span style="display: flex; justify-content: center; align-items: center;width:20px;height:20px;border-radius:50%;">
                                                <?php echo e($leaveCount); ?>

                                            </span>
                                        </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>

                    </table>

                </div>

                <div class="tol-calendar-legend mt-1 mb-3">
                    <div>
                        Team on Leave
                        <span class="legend-circle" style="background: #ccc; font-size: 0.75rem;">
                            0
                        </span>
                    </div>
                    <div>
                        Restricted Holiday
                        <span class="legend-circle circle-pale-yellow" style="vertical-align: middle; display: inline-block; width: 12px; height: 12px; border-radius: 50%;"></span>
                    </div>
                    <div>
                        General Holiday
                        <span class="legend-circle circle-pale-pink" style="vertical-align: middle; display: inline-block; width: 12px; height: 12px; border-radius: 50%;"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <!-- Inside the event-container div -->
                <div class="event-details">
                    <!--[if BLOCK]><![endif]--><?php if($holidays->count() > 0): ?>
                    <div class="date-day">
                        <span style="font-weight:500;"><?php echo e(\Carbon\Carbon::parse($selectedDate)->format('D')); ?> <br>
                            <span style="font-weight:normal;font-size:0.825rem;margin-top:-5px;"><?php echo e(\Carbon\Carbon::parse($selectedDate)->format('d')); ?></span>
                        </span>

                    </div>
                    <div class="holiday-con">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $holidays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $holiday): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span style="font-weight:normal;font-size:0.825rem; color:#778899;">General Holiday <br>
                            <span style="font-weight:500;font-size:0.895rem;color:#333;"><?php echo e($holiday->festivals); ?></span>
                        </span>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <!-- end -->
                <div class="cont d-flex justify-content-end  mt-4 ">
                    <div class="search-container d-flex">
                        <div class="form-group">
                            <div class="search-input-leave">
                                <div class="search-cont ">
                                    <input wire:model.debounce.500ms="searchTerm" type="text" placeholder="Search Employee">
                                    <!-- Search button -->
                                    <button class="btn-3" wire:click="searchData"><i class="bx bx-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter-container1">
                        <div id="main" style="margin-left: <?php echo e($showDialog ? '250px' : '0'); ?>">
                            <button class="openbtn" wire:click="open">
                                <i class="bx bx-filter-alt" style="color:#778899;"></i>
                            </button>
                        </div>

                    </div>
                </div>

                <div class="accordion rounded mt-3">
                    <div class="accordion-heading active rounded">
                        <div class="accordion-title p-2">
                            <div class="accordion-content ">
                                <span style="font-size: 14px; font-weight: 500;color:#778899;">Leave transactions(<?php echo e(count($this->leaveTransactions)); ?>)</span>
                            </div>
                            <div class="arrow-btn" onclick="toggleAccordion(this)">
                                <i class="bx bx-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-body rounded p-0 m-0">
                        <div class="col-md-12 scroll-tabel" style="overflow-y:auto;max-height:320px; min-height:320px;padding:0;">
                            <table class="leave-table p-2" style="width: 100%; border-collapse: collapse; ;overflow: auto;">
                                <thead style="background-color: #ecf7fc; text-align:start;  width:100%;">
                                    <tr>
                                        <th style="padding:7px 5px; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc;color:#778899;font-size:12px;font-weight:normal;width: 40%;">Employee ID</th>
                                        <th style="padding:7px 5px; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc;color:#778899;font-size:12px;font-weight:normal;width: 20%;">No of days</th>
                                        <th style="padding:7px 5px; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc;color:#778899;font-size:12px;font-weight:normal;width: 40%;">From-To </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--[if BLOCK]><![endif]--><?php if(empty($this->leaveTransactions)): ?>
                                    <tr>
                                        <td colspan="3">
                                            <p>No data found</p>
                                        </td>
                                    </tr>`
                                    <?php else: ?>
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($selectedDate)): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $this->leaveTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr style="border-bottom: 1px solid #ccc; font-size:12px;text-align:start;">
                                        <td style="padding: 20px 5px; border-top: 1px solid #ccc; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;width: 40%;">
                                            <span style="color: black; font-size: 12px; font-weight: 500;cursor:pointer;" title="<?php echo e(ucwords(strtolower($transaction->employee->first_name))); ?> <?php echo e(ucwords(strtolower($transaction->employee->last_name))); ?>: <?php echo e($transaction->emp_id); ?>">
                                                <?php echo e(ucwords(strtolower($transaction->employee->first_name))); ?> <?php echo e(ucwords(strtolower($transaction->employee->last_name))); ?> <span style="font-size: 11px; color: #778899;">(#<?php echo e($transaction->emp_id); ?>)</span>
                                            </span> <br>
                                            <span style="font-size: 11px; color: #778899;white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;cursor:pointer;" title="<?php echo e($transaction->employee->job_location); ?>, <?php echo e($transaction->employee->job_title); ?>">
                                                <?php echo e($transaction->employee->job_location); ?>, <?php echo e($transaction->employee->job_title); ?>

                                            </span>
                                        </td>

                                        <td style=" padding:20px 5px;border-top: 1px solid #ccc;font-weight:500;width: 20%;"><?php echo e($this->calculateNumberOfDays($transaction->from_date, $transaction->from_session, $transaction->to_date, $transaction->to_session)); ?></td>
                                        <td style=" padding:20px 5px;border-top: 1px solid #ccc;width: 40%;">

                                            <!--[if BLOCK]><![endif]--><?php if($transaction->from_date === $transaction->to_date): ?>
                                            <span style="color:black;font-size:12px;font-weight:500;"><?php echo e(\Carbon\Carbon::parse($transaction->from_date)->format('d M')); ?></span>
                                            <?php else: ?>
                                            <span style="color:black;font-size:12px;font-weight:500;">
                                                <?php echo e(\Carbon\Carbon::parse($transaction->from_date)->format('d M')); ?> - <?php echo e(\Carbon\Carbon::parse($transaction->to_date)->format('d M')); ?>

                                            </span><br>
                                            <span style="font-size:10px;color:#778899;">
                                                <?php echo e($transaction->from_session); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo e($transaction->to_session); ?>

                                            </span>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                        </td>
                                    </tr>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="3">
                                            <div class="leave-trans" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                                <img src="/images/pending.png" alt="Pending Image" style=" margin: 0 auto;">
                                                <span style="font-size: 0.75rem; font-weight: 500; color:#778899;">No Employees are on leave</span>
                                            </div>
                                        </td>
                                    </tr>

                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                    <?php else: ?>
                                    <tr>
                                        <td colspan="3">
                                            <div class="leave-trans" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                                <img src="/images/pending.png" alt="Pending Image" style="width: 100%; margin: 0 auto;">
                                                <span style="font-size: 0.75rem; font-weight: 500; color:#778899;">No Employees are on leave</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>
            function toggleAccordion(element) {
                const accordionBody = element.closest('.accordion').querySelector('.accordion-body');
                const arrowIcon = element.querySelector('i');
                const isOpen = accordionBody.style.display === 'block';
                if (isOpen) {
                    accordionBody.style.display = 'none';
                    arrowIcon.classList.remove('bx-chevron-up');
                    arrowIcon.classList.add('bx-chevron-down');
                    localStorage.setItem('accordionState', 'closed');
                } else {
                    accordionBody.style.display = 'block';
                    arrowIcon.classList.remove('bx-chevron-down');
                    arrowIcon.classList.add('bx-chevron-up');
                    localStorage.setItem('accordionState', 'open');
                }

            }

            // Check the accordion state on page load and set it accordingly
            window.addEventListener('load', function() {
                const accordionState = localStorage.getItem('accordionState');
                const accordionBodies = document.querySelectorAll('.accordion-body');

                if (accordionState === 'closed') {
                    accordionBodies.forEach(body => {
                        body.style.display = 'none';
                        const arrowIcon = body.previousElementSibling.querySelector('i');
                        arrowIcon.classList.remove('bx-chevron-up');
                        arrowIcon.classList.add('bx-chevron-down');
                    });
                } else {
                    accordionBodies.forEach(body => {
                        body.style.display = 'block';
                        const arrowIcon = body.previousElementSibling.querySelector('i');
                        arrowIcon.classList.remove('bx-chevron-down');
                        arrowIcon.classList.add('bx-chevron-up');
                    });
                }
            });
        </script>



    </div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/leave-calender.blade.php ENDPATH**/ ?>