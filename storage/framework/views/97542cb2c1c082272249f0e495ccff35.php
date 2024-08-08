<div class="d-flex align-items-center gap-3">

    <div  id="notificationButton" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
        <a href="#" class="nav-link">
            <i class='bx bxs-bell icon'></i>
            <!--[if BLOCK]><![endif]--><?php if($totalnotificationscount > 0): ?>
            <span class="badge"><?php echo e($totalnotificationscount); ?></span>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </a>
    </div>
    <div>
        <a href="/users" class="nav-link">
            <i class='bx bxs-message-square-dots icon'></i>
            <!--[if BLOCK]><![endif]--><?php if($chatNotificationCount > 0): ?>
            <span class="badge">
                <?php echo e($chatNotificationCount); ?>

            </span>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            </i>
        </a>
    </div>
    <div class="offcanvas offcanvas-end notification-detail-container " style="width: 300px;" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header d-flex justify-content-between align-items-center">
            <h6 id="offcanvasRightLabel" class="offcanvasRightLabel">Notifications <span class="lableCount" id="notificationCount">
                    (<?php echo e($totalnotificationscount); ?>)</span> </h6>
            <button type="button" class="btn-close text-reset notification-close-btn" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="notification-horizontal-line"></div>
        <div class="offcanvas-body">

            <!--[if BLOCK]><![endif]--><?php if($totalnotifications->isEmpty()): ?>
            <div class="text-center mt-4">
                <p class="mb-0 notification-text">No Notifications</p>
            </div>
            <?php else: ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $totalnotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!--[if BLOCK]><![endif]--><?php if($notification->notification_type=='task'): ?>
            <div>
                <div class="border rounded bg-white p-2 mb-2 leave-request-container">
                    <p class="mb-0 notification-text-para"> <a href="#" class="notification-head" wire:click.prevent="reduceTaskCount('<?php echo e($notification->emp_id); ?>')">
                            <?php echo e(ucwords(strtolower($notification->first_name))); ?> <?php echo e(ucwords(strtolower($notification->last_name))); ?>

                            (#<?php echo e($notification->emp_id); ?>)
                        </a></p>
                    <!--[if BLOCK]><![endif]--><?php if($notification->details_count>1 && $notification->details_count<=10 ): ?> <p class="mb-0 notification-text-para"> Has assigned <?php echo e($notification->details_count); ?> tasks to you.
                        <?php elseif($notification->details_count>10): ?>
                        <p class="mb-0 notification-text-para"> Has assigned 10+ tasks to you.</p>
                        <?php else: ?>
                        <p class="mb-0 notification-text-para">Has assigned task to you. </p>
                        <div style="display: flex; justify-content:end">
                           <p style="margin-bottom: 0px;font-size:xx-small;color: #535f6b;"><?php echo e($notification->notify_time); ?></p>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                </div>
            </div>
            <?php elseif($notification->notification_type=='leave'): ?>
            <div>
                <div class="border rounded bg-white p-2 mb-2 leave-request-container" title="<?php echo e($notification->leave_type); ?>">
                    <p class="mb-0 notification-text"></p>
                    <a href="#" class="notification-head" wire:click.prevent="reduceLeaveRequestCount('<?php echo e($notification->emp_id); ?>')">
                        <?php echo e(ucwords(strtolower($notification->first_name))); ?> <?php echo e(ucwords(strtolower($notification->last_name))); ?>

                        (#<?php echo e($notification->emp_id); ?>)
                    </a>

                    <!--[if BLOCK]><![endif]--><?php if($notification->details_count>1 && $notification->details_count<=10 ): ?>
                        <p class="mb-0 notification-text-para"> Sent <?php echo e($notification->details_count); ?> leave requests.</p>
                        <?php elseif($notification->details_count>10): ?>
                        <p class="mb-0 notification-text-para"> Sent 10+ leave requests.</p>
                        <?php else: ?>
                        <p class="mb-0 notification-text-para"> Sent a leave request.</p>
                        <div style="display: flex; justify-content:end">
                           <p style="margin-bottom: 0px;font-size:xx-small;color: #535f6b;"><?php echo e($notification->notify_time); ?></p>
                        </div>
                     <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                </div>
            </div>
            <?php elseif($notification->notification_type=='message'): ?>
            <div class="border rounded bg-white p-2 mb-2">

                <p class="mb-0 notification-text-para">
                    <a href="#" wire:click.prevent="markAsRead(<?php echo e($notification->chatting_id); ?>)" class="notification-head">
                        <?php echo e(ucwords(strtolower($notification->first_name))); ?>

                        <?php echo e(ucwords(strtolower($notification->last_name))); ?> (#<?php echo e($notification->emp_id); ?>)

                    </a>
                </p>

                <!--[if BLOCK]><![endif]--><?php if($notification->details_count>1 && $notification->details_count<=10 ): ?> <p class="mb-0 notification-text-para"> sent <?php echo e($notification->details_count); ?> messages. </p>
                    <?php elseif($notification->details_count>10): ?>
                    <p class="mb-0 notification-text-para"> sent 10+ messages.</p>
                    <?php else: ?>
                    <p class="mb-0 notification-text-para"> sent a message.</p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <div style="display: flex; justify-content:end">
                        <p style="margin-bottom: 0px;font-size:xx-small;color: #535f6b;"><?php echo e($notification->notify_time); ?></p>
                    </div>
            </div>

            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/notification.blade.php ENDPATH**/ ?>