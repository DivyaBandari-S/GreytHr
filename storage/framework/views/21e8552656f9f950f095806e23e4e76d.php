<div class="container-fluid my-1">
    <div class="row">
        <!-- Left Side: Department Dropdown -->
        <div class="col-md-3 border-end bg-white" style="height: 100vh; overflow-y: auto;">
            <div class="bg-white" style="height: 100%;"> <!-- Set background color and full height -->
                <div class="d-flex flex-column mb-2">
                    <h6 class="text-start text-5xl font-bold py-3 px-4">Departments</h6>
                    <select class="form-control mb-4" wire:model="selectedDepartment"  wire:change="filter">
                        <option value="">All Departments</option>
                      
                    </select>
                </div>
            </div>
        </div>

        <!-- Right Side: Search and Employee Details -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between mb-2">
                <div class="col-md-6">
                    <h6 class="text-start text-5xl font-bold py-3 px-4 employees-details-chat">Users</h6>
                </div>
                <div class="col-md-6 input-group">
                    <input type="text" class="form-control3" placeholder="Search..."
                        wire:model="searchTerm" aria-label="Search" aria-describedby="search-addon" style="width:220px;height:40px;border-radius:5px; border: 1px solid #ced4da;padding: 0 10px;"
                        wire:input="filter">
                    <button class="submit-btn" wire:click="filter" id="search-addon"
                        style="height:40px; line-height: 2;">Search</button>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 gap-5 justify-content-center"
                style="overflow-y: auto; height: 100vh;">
                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $employeeDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-lg-3 mb-6"> <!-- Increase width to col-lg-4 -->
                        <div class="card" style="width: 200px;">
                            <div class="col d-flex align-items-center justify-content-center mt-4">
                        
                            <!--[if BLOCK]><![endif]--><?php if($employee->image_url): ?>
    <img src="<?php echo e($employee->image_url); ?>" height="50" width="50" style="border-radius:50%;" alt="Employee Image">
<?php elseif($employee->gender == 'Male'): ?>
    <img src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" height="50" width="50" style="border-radius:50%;" alt="Default Male Profile">
<?php elseif($employee->gender == 'Female'): ?>
    <img src="https://th.bing.com/th/id/OIP.16PsNaosyhVxpn3hmvC46AHaHa?w=199&h=199&c=7&r=0&o=5&dpr=1.5&pid=1.7" height="50" width="50" style="border-radius:50%;" alt="Default Female Profile">
<?php else: ?>
    <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" height="50" width="50" style="border-radius:50%;" alt="Default Profile Image">
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                            </div>
                            <div class="card-body text-center">
                                <div class="chat-employee-name">
                                    <?php echo e(ucwords(strtolower($employee->first_name))); ?>&nbsp;<?php echo e(ucwords(strtolower($employee->last_name))); ?>

                                </div>
                                <?php
                                    $jobTitle = $employee->job_title;
                                    $convertedTitle = preg_replace('/\bII\b/', 'I', $jobTitle);
                                    $convertedTitle = preg_replace('/\bII\b/', 'II', $jobTitle);
                                    $convertedTitle = preg_replace('/\bIII\b/', 'III', $convertedTitle);
                                ?>
                                <p class="card-text px-4 mb-0" style="display: inline-block;"><?php echo e($convertedTitle); ?></p>
                                <div class="d-flex justify-content-between mt-3">
                                    <div class="chat-emp-head d-flex flex-column align-items-start gap-1">
                                        <span>Employee Id</span>
                                        <span>Department</span>
                                        <span>Join Date</span>

                                    </div>
                                    <div class="chat-emp-details d-flex flex-column align-items-end gap-1">
                                        <span><?php echo e($employee->emp_id); ?></span>
                                        <span><?php echo e($employee->department); ?></span>
                                        <span><?php echo e(\Carbon\Carbon::parse($employee->hire_date)->format('d M, Y')); ?></span>

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex gap-4 justify-content-center">
                                <!-- Call Icon -->
                                <button class="cancel-btn px-4 d-flex align-items-center justify-content-center"
                                    style="border:1px solid rgb(12,17,79); border-radius: 10px; width: 30px; height: 30px;cursor:pointer;">
                                    <i class="fas fa-phone-alt fa-rotate-90" style="font-size: 13px;padding:5px;"></i>
                                </button>
                                <!-- Chat Icon -->
                                <button class="submit-btn px-4 d-flex align-items-center justify-content-center"
                                    style="border-radius: 10px; width: 30px; height: 30px;cursor:pointer;"
                                    wire:click="message('<?php echo e($employee->emp_id); ?>')">
                                    <i class="fas fa-comment" style="font-size: 14px;padding:5px;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="col text-center">No employees found.</p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/chat/employee-list.blade.php ENDPATH**/ ?>