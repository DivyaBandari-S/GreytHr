<div>
    <!--[if BLOCK]><![endif]--><?php if(session()->has('emp_error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('emp_error')); ?>

    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <!--[if BLOCK]><![endif]--><?php if(auth()->guard('emp')->check()): ?>
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="profile-container">
        <div>
            <!--[if BLOCK]><![endif]--><?php if($employee->image): ?>
            <div class="employee-profile-image-container">
                <img height="35px" width="35px" src="<?php echo e(asset('storage/' . $employee->image)); ?>" style="border-radius:50%;border:2px solid green;">
            </div>
            <?php else: ?>
            <div class="employee-profile-image-container">
                <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" class="employee-profile-image-placeholder" style="border-radius:50%;" height="35px" width="35px" alt="Default Image">
            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <div class="emp-name p-0">
            <p style="font-size: 13px; color: white; max-width: 110px; word-wrap: break-word; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;margin-left:10px;" class="username">
               Hi &nbsp;<?php echo e(ucwords(strtolower($employee->first_name))); ?>

            </p>

            <a href="<?php echo e(route('profile.info')); ?>" class="nav-item-1" style="text-decoration: none;color: #EC9B3B;font-weight:500;font-size: 11px;margin-left:10px;" onclick="changePageTitle()">View My Info</a>

        </div>

        <div class="p-0 m-0">

            <a href="/Settings" onclick="changePageTitle123()">

                <i style="color: white;    width: 16px;height: 16px;  margin-left: 10px;" class="fas fa-cog"></i>

            </a>

        </div>

    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <!--[if BLOCK]><![endif]--><?php if(auth()->guard('hr')->check()): ?>
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $hrDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="profile-container">
        <img class="profile-image" src="<?php echo e(Storage::url($employee->image)); ?>">
        <div class="emp-name">

            <p style="font-size: 12px; color: white; max-width: 130px; word-wrap: break-word;" class="username"><?php echo e($employee->employee_name); ?></p>

            <a href="#" class="nav-item-1" style="text-decoration: none;" onclick="changePageTitle()">View My Info</a>

        </div>

        <div>

            <a href="#" onclick="changePageTitle123()">

                <i style="color: white;" class="fas fa-cog"></i>

            </a>

        </div>

    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if(auth()->guard('it')->check()): ?>
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $itDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="profile-container">

        <img class="profile-image" src="<?php echo e(Storage::url($employee->image)); ?>">
        <div class="emp-name">

            <p style="font-size: 12px; color: white; max-width: 130px; word-wrap: break-word;" class="username"><?php echo e($employee->employee_name); ?></p>

            <a href="#" class="nav-item-1" style="text-decoration: none;" onclick="changePageTitle()">View My Info</a>

        </div>

        <div>

            <a href="#" onclick="changePageTitle123()">

                <i style="color: white;" class="fas fa-cog"></i>

            </a>

        </div>

    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if(auth()->guard('finance')->check()): ?>
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $financeDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="profile-container">


        <img class="profile-image" src="<?php echo e(Storage::url($employee->image)); ?>">




        <div class="emp-name">

            <p style="font-size: 12px; color: white; max-width: 130px; word-wrap: break-word;" class="username"><?php echo e($employee->employee_name); ?></p>

            <a href="#" class="nav-item-1" style="text-decoration: none;" onclick="changePageTitle()">View My Info</a>

        </div>

        <div>

            <a href="#" onclick="changePageTitle123()">

                <i style="color: white;" class="fas fa-cog"></i>

            </a>

        </div>

    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/profile-card.blade.php ENDPATH**/ ?>