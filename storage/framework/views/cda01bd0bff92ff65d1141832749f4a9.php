<div>

<div class="col"  id="leavePending" style="width: 95%; padding: 0;border-radius: 5px; ">
   <!--[if BLOCK]><![endif]--><?php if(!empty($this->leaveApplications)): ?>
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->leaveApplications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leaveRequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="approved-leave-container mt-1 px-1"  style="border-radius: 5px; " >
                <div class="accordion rounded mb-4 p-0">
                    <div class="accordion-heading rounded m-0 p-0"  onclick="toggleAccordion(this)">
                        <div class="accordion-title rounded m-0 p-1">
                            <!-- Display leave details here based on $leaveRequest -->
                            <div class="col accordion-content">
                             <div class="accordion-profile" style="display:flex; gap:7px; margin:auto 0;align-items:center;justify-content:center;">
                                    <!--[if BLOCK]><![endif]--><?php if(isset($leaveRequest['leaveRequest']->image)): ?>
                                        <img src="<?php echo e(asset('storage/' . $leaveRequest['leaveRequest']->image)); ?>" alt="" style="background:#f3f3f3;border:1px solid #ccc;width: 40px; height: 40px; border-radius: 50%;">
                                        <?php else: ?>
                                        <img src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars.png" alt="" style="background:#f3f3f3;border:1px solid #ccc;width: 40px; height: 40px; border-radius: 50%;">
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <div>
                                            <!--[if BLOCK]><![endif]--><?php if(isset($leaveRequest['leaveRequest']->first_name)): ?>
                                            <p style="font-size: 12px; font-weight: 500; text-align: center; margin: auto; max-width: 90px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?php echo e(ucwords(strtolower($leaveRequest['leaveRequest']->first_name))); ?> <?php echo e(ucwords(strtolower($leaveRequest['leaveRequest']->last_name))); ?>">
                                                <?php echo e(ucwords(strtolower($leaveRequest['leaveRequest']->first_name))); ?> <?php echo e(ucwords(strtolower($leaveRequest['leaveRequest']->last_name))); ?>

                                            <br>
                                            <!--[if BLOCK]><![endif]--><?php if(isset($leaveRequest['leaveRequest']->emp_id)): ?>
                                                <span style="color: #778899; font-size: 11px; text-align: start;">#<?php echo e($leaveRequest['leaveRequest']->emp_id); ?> </span>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </p>
                                            <?php else: ?>
                                                <p style="font-size: 12px; font-weight: 500;">Name Not Available</p>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                 </div>
                            </div>
                         
                            <div class="col accordion-content" >
                                <p style="color: #778899; font-size: 12px; font-weight: 500; margin-bottom:0;">Leave Type <br>
                                <!--[if BLOCK]><![endif]--><?php if(isset($leaveRequest['leaveRequest']->leave_type)): ?>
                                    <span style="color: #36454F; font-size: 12px; font-weight: 500;"><?php echo e($leaveRequest['leaveRequest']->leave_type); ?></span>
                                <?php else: ?>
                                    <span style="color: #778899; font-size: 10px;">Leave Type Not Available</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </p>
                            </div>

                            <div class="col accordion-content" >
                                    <?php
                                        $numberOfDays = $this->calculateNumberOfDays($leaveRequest['leaveRequest']->from_date, $leaveRequest['leaveRequest']->from_session, $leaveRequest['leaveRequest']->to_date, $leaveRequest['leaveRequest']->to_session);
                                    ?>
                                    <p style="color: #778899; font-size: 12px; font-weight: 500; margin-bottom:0;">
                                        Period <br>
                                        <!--[if BLOCK]><![endif]--><?php if($numberOfDays == 1): ?>
                                        <span style="color: #333; font-size: 12px; font-weight: 600;">
                                            <!--[if BLOCK]><![endif]--><?php if(isset($leaveRequest['leaveRequest']->from_date)): ?>
                                               <?php echo e($leaveRequest['leaveRequest']->from_date->format('d M Y')); ?>

                                            <?php else: ?>
                                                Date Not Available
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </span> <br>
                                        <span style="color: #778899; font-size: 10px;">Full Day</span>
                                        <?php elseif($numberOfDays == 0.5): ?>
                                        <span style="color: #333; font-size: 12px; font-weight: 500;">
                                            <!--[if BLOCK]><![endif]--><?php if(isset($leaveRequest['leaveRequest']->from_date)): ?>
                                            <span style="font-size: 12px; font-weight: 600;"> <?php echo e($leaveRequest['leaveRequest']->from_date->format('d M Y')); ?><br><span style="color: #494F55;font-size:10px;font-weight:normal; "><?php echo e($leaveRequest['leaveRequest']->from_session); ?></span></span>
                                            <?php else: ?>
                                                Date Not Available
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </span> <br>
                                        <span style="color: #778899; font-size: 10px;">Half Day</span>
                                        <?php else: ?>
                                        <span style="color: #333; font-size: 12px; font-weight: 500;">
                                            <!--[if BLOCK]><![endif]--><?php if(isset($leaveRequest['leaveRequest']->from_date)): ?>
                                                <div class="d-flex gap-2">
                                                    <span style="font-size: 12px; font-weight: 600;"> <?php echo e($leaveRequest['leaveRequest']->from_date->format('d M Y')); ?><br><span style="color: #494F55;font-size:10px;font-weight:normal; "><?php echo e($leaveRequest['leaveRequest']->from_session); ?></span></span>
                                                    <span>-</span>
                                                    <span style="font-size: 12px; font-weight: 600;"> <?php echo e($leaveRequest['leaveRequest']->to_date->format('d M Y')); ?><br><span style="color: #494F55;font-size:10px;font-weight:normal; "><?php echo e($leaveRequest['leaveRequest']->to_session); ?></span></span>
                                                </div>
                                            <?php else: ?>
                                                Date Not Available
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </p>
                            </div>
                            <!-- Add other details based on your leave request structure -->
                            <div class="arrow-btn " >
                               <i class="fa fa-angle-down"></i>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-body p-0 m-0">
                      <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>
                        <div class="content1 px-2">
                           <span style="color: #333; font-size: 12px; font-weight: 500;">No. of days :</span>
                                <!--[if BLOCK]><![endif]--><?php if(isset($leaveRequest['leaveRequest']->from_date)): ?>
                                    <span style="color: #778899; font-size: 11px ;font-weight: 400;">
                                        <?php echo e($this->calculateNumberOfDays($leaveRequest['leaveRequest']->from_date, $leaveRequest['leaveRequest']->from_session, $leaveRequest['leaveRequest']->to_date, $leaveRequest['leaveRequest']->to_session)); ?>

                                    </span>
                                <?php else: ?>
                                    <span style="color: #778899; font-size: 12px; font-weight: 400;">No. of days not available</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        <div class="content1 px-2">
                          <span style="color: #333; font-size: 12px; font-weight: 500;">Reason :</span>
                          <!--[if BLOCK]><![endif]--><?php if(isset($leaveRequest['leaveRequest']->reason)): ?>
                                <span style="font-size: 11px; color:#778899"><?php echo e(ucfirst($leaveRequest['leaveRequest']->reason)); ?></span>
                            <?php else: ?>
                                <span style="font-size: 10px; color:#778899">Reason Not Available</span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                         <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>
                        <div style="display:flex; flex-direction:row; justify-content:space-between;">
                          <div class="content1 px-2">
                                <span style="color: #778899; font-size: 12px; font-weight: 500;">Applied On <br>
                                <!--[if BLOCK]><![endif]--><?php if(isset($leaveRequest['leaveRequest']->created_at)): ?>
                                    <span style="color: #333; font-size: 11px; font-weight: 500;">
                                        <?php echo e($leaveRequest['leaveRequest']->created_at->format('d M, Y')); ?>

                                   </span>
                                <?php else: ?>
                                    <span style="color: #333; font-size: 12px; font-weight: 400;">No. of days not available</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                               </span> 
                            </div>
                            <div class="content2">
                                <span style="color: #778899; font-size: 12px; font-weight: 500;">Leave Balance:</span>
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($leaveRequest['leaveBalances'])): ?>
                                        <div style=" flex-direction:row; display: flex; align-items: center;justify-content:center;">
                                        <!-- Sick Leave -->
                                            <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #e6e6fa; display: flex; align-items: center; justify-content: center; margin-left:15px;">
                                                <span style="font-size:10px; color: #50327c;font-weight:500;">SL</span>
                                        </div>
                                            <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;"><?php echo e($leaveRequest['leaveBalances']['sickLeaveBalance']); ?></span>

                                        <!-- Casual Leave -->
                                        <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #e7fae7; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                                <span style="font-size:10px; color: #1d421e;font-weight:500;">CL</span>
                                        </div>
                                        <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;"><?php echo e($leaveRequest['leaveBalances']['casualLeaveBalance']); ?></span>
                                        <!-- Casual Leave Probation-->
                                        <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #FDEBD0  ; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                                <span style="font-size:10px; color: #F39C12  ;font-weight:500;">CLP</span>
                                        </div>
                                            <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;"><?php echo e($leaveRequest['leaveBalances']['casualProbationLeaveBalance']); ?></span>
                                        <!-- Loss of Pay -->
                                        <!--[if BLOCK]><![endif]--><?php if($leaveRequest['leaveRequest']->leave_type === 'Loss of Pay'): ?>
                                        <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                                <span style="font-size:10px; color: #890000;font-weight:500;">LP</span>
                                        </div>
                                            <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;"><?php echo e($leaveRequest['leaveBalances']['lossOfPayBalance']); ?></span>
                                          <!-- marriage leave -->
                                        <?php elseif($leaveRequest['leaveRequest']->leave_type === 'Marriage Leave'): ?>
                                        <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                                <span style="font-size:10px; color: #890000;font-weight:500;">MRL</span>
                                        </div>
                                            <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;"><?php echo e($leaveRequest['leaveBalances']['marriageLeaveBalance']); ?></span>
                                        <?php elseif($leaveRequest['leaveRequest']->leave_type === 'Maternity Leave'): ?>
                                        <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                                <span style="font-size:10px; color: #890000;font-weight:500;">ML</span>
                                        </div>
                                            <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;"><?php echo e($leaveRequest['leaveBalances']['maternityLeaveBalance']); ?></span>
                                        <?php elseif($leaveRequest['leaveRequest']->leave_type === 'Petarnity Leave'): ?>
                                        <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                                <span style="font-size:10px; color: #890000;font-weight:500;">PL</span>
                                        </div>
                                            <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;"><?php echo e($leaveRequest['leaveBalances']['paternityLeaveBalance']); ?></span>

                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>


                            <div class="content1">
                                <a href="<?php echo e(route('view-details', ['leaveRequestId' => $leaveRequest['leaveRequest']->id])); ?>" style="color:#007BFF;font-size:11px;">View Details</a>
                                <button class="rejectBtn" wire:click="rejectLeave(<?php echo e($loop->index); ?>)">Reject</button>
                                <button class="rejectBtn" >Forward</button>
                                <button class="approveBtn btn-primary" wire:click="approveLeave(<?php echo e($loop->index); ?>)">Approve</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    <?php else: ?>
        <div class="leave-pending" style="margin-top:30px; background:#fff; margin-left:120px; display:flex; width:75%;flex-direction:column; text-align:center;justify-content:center; border:1px solid #ccc; padding:20px;gap:10px;">
            <img src="/images/pending.png" alt="Pending Image" style="width:60%; margin:0 auto;">
            <p style="color:#969ea9; font-size:12px; font-weight:400; ">There are no pending records of any leave transaction to Review</p>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<script>
      function toggleAccordion(element) {
            const accordionBody = element.nextElementSibling;
            if (accordionBody.style.display === 'block') {
                accordionBody.style.display = 'none';
                element.classList.remove('active'); // Remove active class
            } else {
                accordionBody.style.display = 'block';
                element.classList.add('active'); // Add active class
            }
        }
</script>

</div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/view-pending-details.blade.php ENDPATH**/ ?>