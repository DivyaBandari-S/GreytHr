<div>
    <style>
        #remarks::placeholder {
            color: #a3b2c7;
            font-size: 12px;
        }

    </style>
    <!--[if BLOCK]><![endif]--><?php if(count($regularisations)>0): ?>
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $regularisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
    $regularisationEntries = json_decode($r->regularisation_entries, true);
    $numberOfEntries = count($regularisationEntries);
    $firstItem = reset($regularisationEntries); // Get the first item
    $lastItem = end($regularisationEntries); // Get the last item
    ?>
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $regularisationEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <!--[if BLOCK]><![endif]--><?php if(empty($r1['date'])): ?>
    <?php
    $numberOfEntries-=1;
    ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    <!--[if BLOCK]><![endif]--><?php if(session()->has('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
    <?php elseif(session()->has('success')): ?>
           <div class="alert alert-danger">
                <?php echo e(session('success')); ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div class="accordion bg-white border mb-3 rounded">
        <div class="accordion-heading rounded" onclick="toggleAccordion(this)">

            <div class="accordion-title p-2 rounded">

                <!-- Display leave details here based on $leaveRequest -->

                <div class="accordion-content col">

                    <span style="color: #778899; font-size: 12px; font-weight: 500;"><?php echo e(ucwords(strtolower($r->employee->first_name))); ?>&nbsp;<?php echo e(ucwords(strtolower($r->employee->last_name))); ?></span>

                    <span style="color: #36454F; font-size: 10px; font-weight: 500;"><?php echo e($r->emp_id); ?></span>

                </div>



                <div class="accordion-content col">

                    <span style="color: #778899; font-size: 12px; font-weight: 500;">No. of Days</span>

                    <span style="color: #36454F; font-size: 12px; font-weight: 500;">
                        <?php echo e($numberOfEntries); ?>

                    </span>

                </div>


                <!-- Add other details based on your leave request structure -->



                <div class="arrow-btn">
                    <i class="fa fa-angle-down"></i>
                </div>

            </div>

        </div>
        <div class="accordion-body m-0 p-0">

            <div style="width:100%; height:1px; border-bottom:1px solid #ccc;"></div>

            <div class="content px-4 py-2">

                <span style="color: #778899; font-size: 12px; font-weight: 500;">Dates Applied:</span>

                <span style="font-size: 11px;">
                    <!--[if BLOCK]><![endif]--><?php if($r->regularisation_entries_count>1): ?>
                    <span style="font-size: 11px; font-weight: 500;"></span>

                    <?php echo e(date('(d', strtotime($firstItem['date']))); ?> -

                    <span style="font-size: 11px; font-weight: 500;"></span>

                    <!--[if BLOCK]><![endif]--><?php if(!empty($lastItem['date'])): ?>
                    <?php echo e(date('d)', strtotime($lastItem['date']))); ?> <?php echo e(date('M Y', strtotime($lastItem['date']))); ?>

                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <?php else: ?>
                    <?php echo e(date('d', strtotime($firstItem['date']))); ?> <?php echo e(date('M Y', strtotime($lastItem['date']))); ?>

                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                </span>

            </div>



            <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>

            <div style="display:flex; flex-direction:row; justify-content:space-between;">

                <div class="content mb-2 mt-0 px-4">

                    <span style="color: #778899; font-size: 12px; font-weight: 500;">Applied on:</span>

                    <span style="color: #333; font-size:12px; font-weight: 500;"><?php echo e(\Carbon\Carbon::parse($r->created_at)->format('d M, Y')); ?>

                    </span>

                </div>

                <div class="content mb-2 px-4 d-flex gap-2">
                    <a href="<?php echo e(route('review-pending-regularation', ['id' => $r->id])); ?>" style="color:rgb(2,17,79);font-size:12px;margin-top:3px;">View Details</a>
                    <button class="rejectBtn"wire:click="openRejectModal">Reject</button>
                    <button class="approveBtn"wire:click="openApproveModal">Approve</button>
                </div>
                <!--[if BLOCK]><![endif]--><?php if($openRejectPopupModal==true): ?>
                <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #f5f5f5; height: 50px">
                                <h5 class="modal-title" id="rejectModalTitle"style="color:#778899;">Reject Request</h5>
                                <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="closeRejectModal" style="background-color: #f5f5f5;border-radius:20px;border:2px solid #778899;height:20px;width:20px;" >
                                </button>
                            </div>
                            <div class="modal-body" style="max-height:300px;overflow-y:auto">
                                    <p style="font-size:14px;">Are you sure you want to reject this application?</p>
                                    <div class="form-group">
                                            <label for="remarks" style="font-size:12px;color:#666;font-weight:400;">Remarks</label>
                                            <input type="text" class="form-control placeholder-small" id="remarks" placeholder="Enter reason here" wire:model="remarks" style="height: 100px; padding-bottom: 70px;">
                                    </div>

                            </div>
                            <div class="modal-footer">
                                    <button type=
                                    "button"class="approveBtn"wire:click="closeRejectModal">Cancel</button>
                                    <button type="button"class="rejectBtn"wire:click="reject(<?php echo e($r->id); ?>)">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-backdrop fade show blurred-backdrop"></div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <!--[if BLOCK]><![endif]--><?php if($openApprovePopupModal==true): ?>
                        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #f5f5f5; height: 50px">
                                        <h5 class="modal-title" id="approveModalTitle"style="color:#778899;">Approve Request</h5>
                                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="closeApproveModal" style="background-color: #f5f5f5;border-radius:20px;border:2px solid #778899;height:20px;width:20px;" >
                                        </button>
                                    </div>
                                    <div class="modal-body" style="max-height:300px;overflow-y:auto">
                                            <p style="font-size:14px;">Are you sure you want to approve this application?</p>
                                            <div class="form-group">
                                                    <label for="remarks" style="font-size:12px;color:#666;font-weight:400;">Remarks</label>
                                                    <input type="text" class="form-control" id="remarks" placeholder="Enter reason here" wire:model="remarks" style="height: 100px; padding-bottom: 70px;">
                                            </div>

                                    </div>
                                    <div class="modal-footer">
                                            <button type=
                                            "button"class="approveBtn"wire:click="closeApproveModal">Cancel</button>
                                            <button type="button"class="rejectBtn"wire:click="approve(<?php echo e($r->id); ?>)">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-backdrop fade show blurred-backdrop"></div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>



    </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    <?php else: ?>
    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                    <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
                    <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no regularization records to view
                    </p>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

</div>
<?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/view-regularisation-pending.blade.php ENDPATH**/ ?>