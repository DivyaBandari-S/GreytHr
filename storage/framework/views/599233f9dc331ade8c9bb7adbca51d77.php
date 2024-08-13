<div class="leavePageContent">
    <div class="d-flex mt-1 mb-3 gap-4 align-items-center position-relative">
        <a type="button" class="submit-btn" href="<?php echo e(route('home')); ?>" style="text-decoration:none;">Back</a>
        <!-- leave-page.blade.php -->
        <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
        <div class="alert alert-success w-50 position-absolute m-auto p-1" style=" font-size: 12px;right:25%;" id="success-alert">
            <?php echo e(session('message')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <script>
            // Auto-dismiss alert messages after 3 seconds
            setTimeout(function() {
                $('#success-alert').fadeOut('slow');
            }, 3000); // 3 seconds 3000); // 3 seconds
        </script>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <?php if(session()->has('error')): ?>
        <div class="alert alert-danger position-absolute p-1" style="font-size: 12px;right:25%;" id="error-alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <script>
            setTimeout(function() {
                $('#error-alert').fadeOut('slow');
            }, 3000); // 3 seconds
        </script>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
    <div class="toggle-container">
        <!-- Navigation Buttons -->
        <div class="nav-buttons d-flex justify-content-center">
            <ul class="nav custom-nav-tabs border">
                <li class="custom-item m-0 p-0 flex-grow-1">
                    <div style="border-top-left-radius:5px;border-bottom-left-radius:5px;" class="custom-nav-link  <?php echo e($activeSection === 'applyButton' ? 'active' : ''); ?>" wire:click.prevent="toggleSection('applyButton')">
                        Apply
                    </div>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1" style="border-left:1px solid #ccc;border-right:1px solid #ccc;">
                    <a href="#" style="border-radius:none;" class="custom-nav-link <?php echo e($activeSection === 'pendingButton' ? 'active' : ''); ?>" wire:click.prevent="toggleSection('pendingButton')">
                        Pending
                    </a>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1">
                    <a href="#" style="border-top-right-radius:5px;border-bottom-right-radius:5px;" class="custom-nav-link <?php echo e($activeSection === 'historyButton' ? 'active' : ''); ?>" wire:click.prevent="toggleSection('historyButton')">
                        History
                    </a>
                </li>
            </ul>
        </div>




        
        <div class="row m-0 p-0" style="<?php echo e($activeSection === 'applyButton' ? '' : 'display:none;'); ?>">
            <!-- Side Container with Sections -->
            <div class="containerWidth">
                <div id="cardElement" class="side">
                    <div>
                        <a href="#" class="side-nav-link <?php echo e(($activeSection === 'applyButton' && $showLeaveApply) ? 'active' : ''); ?>" wire:click.prevent="toggleSideSection('leave')">Leave</a>
                    </div>
                    <div class="line"></div>
                    <div>
                        <a href="#" class="side-nav-link <?php echo e(($activeSection === 'applyButton' && $showRestricted) ? 'active' : ''); ?>" wire:click.prevent="toggleSideSection('restricted')">Restricted Holiday</a>
                    </div>
                    <div class="line"></div>
                    <div>
                        <a href="#" class="side-nav-link <?php echo e(($activeSection === 'applyButton' && $showLeaveCancel) ? 'active' : ''); ?>" wire:click.prevent="toggleSideSection('leaveCancel')">Leave Cancel</a>
                    </div>
                    <div class="line"></div>
                    <div>
                        <a href="#" class="side-nav-link <?php echo e(($activeSection === 'applyButton' && $showCompOff) ? 'active' : ''); ?>" wire:click.prevent="toggleSideSection('compOff')">Comp Off Grant</a>
                    </div>
                </div>
            </div>
            <!-- content -->
            <div id="leave" class="row mt-2 align-items-center " style="<?php echo e($showLeave ? '' : 'display:none;'); ?>">

                <div class="containerWidth"><?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('leave-form-page');

$__html = app('livewire')->mount($__name, $__params, 'lw-2915565573-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?> </div>

            </div>

            <div id="restricted" class="row mt-2 align-items-center" style="<?php echo e($showRestricted ? '' : 'display:none;'); ?>">
                <div class="containerWidth">
                    <div class="leave-pending rounded">
                        <!--[if BLOCK]><![endif]--><?php if($resShowinfoMessage): ?>
                        <div class="hide-info p-2 mb-2 mt-2 rounded d-flex justify-content-between align-items-center">
                            <p class="mb-0" style="font-size:10px;">Restricted Holidays (RH) are a set of holidays allocated by the
                                company that are optional for the employee to utilize. The company sets a limit on the
                                amount of holidays that can be used.</p>
                            <p class="mb-0 hideInfo" wire:click="toggleInfoRes">Hide</p>
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <div class="d-flex justify-content-between">
                            <p class="applyingFor">Applying for
                                Restricted Holiday</p>
                            <!--[if BLOCK]><![endif]--><?php if($resShowinfoButton): ?>
                            <p class="info-paragraph" wire:click="toggleInfoRes">Info</p>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <img src="<?php echo e(asset('/images/pending.png')); ?>" alt="Pending Image" class="imgContainer">
                        <p class="restrictedHoliday">You have no
                            Restricted Holiday balance, as per our record.</p>
                    </div>
                </div>
            </div>

            <div id="leaveCancel" class="row  mt-2 align-items-center" style="<?php echo e($showLeaveCancel ? '' : 'display:none;'); ?>">
                <div class="containerWidth"> <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('leave-cancel');

$__html = app('livewire')->mount($__name, $__params, 'lw-2915565573-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?> </div>
            </div>

            <div id="compOff" class="row  mt-2 align-items-center" style="<?php echo e($showCompOff ? '' : 'display:none;'); ?>">
                <div class="containerWidth">
                    <div>
                        <div class="leave-pending rounded">
                            <!--[if BLOCK]><![endif]--><?php if($compOffShowinfoMessage): ?>
                            <div class="hide-info p-2 mb-2 mt-2 rounded d-flex justify-content-between align-items-center">
                                <p class="mb-0" style="font-size:11px;">Compensatory Off is additional leave granted as a compensation for working overtime or on
                                    an off day.</p>
                                <p class="mb-0 hideInfo" wire:click="toggleInfoCompOff">Hide</p>
                            </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <div class="d-flex justify-content-between">
                                <p class="applyingFor">Applying for Comp.
                                    Off Grant</p>
                                <!--[if BLOCK]><![endif]--><?php if($compOffShowinfoButton): ?>
                                <p class="info-paragraph" wire:click="toggleInfoCompOff">Info</p>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <img src="<?php echo e(asset('/images/pending.png')); ?>" alt="Pending Image" class="imgContainer">
                            <p class="restrictedHoliday">You are not
                                eligible to request for compensatory off grant. Please contact your HR for further
                                information.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- endcontent -->
            <!--[if BLOCK]><![endif]--><?php if($showLeaveApply): ?>
            <div class="containerWidth">
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('leave-apply');

$__html = app('livewire')->mount($__name, $__params, 'lw-2915565573-2', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        
        <div id="pendingButton" class="row rounded mt-4" style="<?php echo e($activeSection === 'pendingButton' ? '' : 'display:none;'); ?>; max-height: 370px;overflow-y: auto;">
            <!--[if BLOCK]><![endif]--><?php if(empty($combinedRequests) || $combinedRequests->isEmpty()): ?>
            <div class="mt-2">
                <div class="leave-pending rounded" style="width:80%;margin:0 auto;">

                    <img src="<?php echo e(asset('/images/pending.png')); ?>" alt="Pending Image" class="imgContainer">

                    <p class="restrictedHoliday">There are no pending records of any leave
                        transaction</p>

                </div>
            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <!--[if BLOCK]><![endif]--><?php if(!empty($combinedRequests)): ?>

            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $combinedRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leaveRequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="mt-4 containerWidth">

                <div class="accordion rounded">

                    <div class="accordion-heading rounded" onclick="toggleAccordion(this)">

                        <div class="accordion-title px-4 py-3 rounded">

                            <!-- Display leave details here based on $leaveRequest -->

                            <div class="col accordion-content">

                                <span class="accordionContentSpan">Category</span>

                                <span class="accordionContentSpanValue"><?php echo e($leaveRequest->category_type); ?></span>

                            </div>

                            <div class="col accordion-content">

                                <span class="accordionContentSpan">Leave Type</span>

                                <span class="accordionContentSpanValue"><?php echo e($leaveRequest->leave_type); ?></span>

                            </div>
                            <div class="col accordion-content">

                                <span class="accordionContentSpan">Pending with</span>
                                <?php
                                $applyingToArray = json_decode($leaveRequest->applying_to, true);
                                ?>
                                <span class="accordionContentSpanValue">
                                    <?php echo e(ucwords(strtolower($applyingToArray[0]['report_to'])) ?? 'No report_to available'); ?>

                                </span>

                            </div>

                            <div class="col accordion-content">

                                <span class="accordionContentSpan">No. of Days</span>

                                <span class="accordionContentSpanValue">

                                    <?php echo e($this->calculateNumberOfDays($leaveRequest->from_date, $leaveRequest->from_session, $leaveRequest->to_date, $leaveRequest->to_session)); ?>


                                </span>

                            </div>


                            <!-- Add other details based on your leave request structure -->
                            <!--[if BLOCK]><![endif]--><?php if(($leaveRequest->category_type === 'Leave') ): ?>
                            <div class="col accordion-content">
                                <span class="accordionContentSpanValue" style="color:#cf9b17 !important;"><?php echo e(strtoupper($leaveRequest->status)); ?></span>
                            </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <div class="arrow-btn">
                                <i class="fa fa-chevron-down"></i>
                            </div>

                        </div>

                    </div>

                    <div class="accordion-body m-0 p-0">

                        <div style="width:100%; height:1px; border-bottom:1px solid #ccc;"></div>

                        <div class="content pt-1 px-4">

                            <span style="color: #778899; font-size: 12px; font-weight: 500;">Duration:</span>

                            <span style="font-size: 11px;">

                                <span style="font-size: 11px; font-weight: 500;">
                                    <?php echo e(\Carbon\Carbon::parse($leaveRequest->from_date)->format('d-m-Y')); ?> </span>

                                ( <?php echo e($leaveRequest->from_session); ?> ) to

                                <span style="font-size: 11px; font-weight: 500;">
                                    <?php echo e(\Carbon\Carbon::parse($leaveRequest->to_date)->format('d-m-Y')); ?></span>

                                ( <?php echo e($leaveRequest->to_session); ?> )

                            </span>

                        </div>

                        <div class="content pb-1 px-4">

                            <span style="color: #778899; font-size: 12px; font-weight: 500;">Reason:</span>

                            <span style="font-size: 11px;"><?php echo e(ucfirst( $leaveRequest->reason)); ?></span>

                        </div>

                        <div style="width:100%; height:1px; border-bottom:1px solid #ccc;"></div>

                        <div class="d-flex justify-content-between align-items-center py-2 px-3">

                            <div class="content px-2">

                                <span style="color: #778899; font-size: 12px; font-weight: 500;">Applied on:</span>

                                <span style="color: #333; font-size:12px; font-weight: 500;"><?php echo e($leaveRequest->created_at->format('d M, Y')); ?></span>

                            </div>

                            <div class="content d-flex gap-2 align-items-center ">

                                <a href="<?php echo e(route('leave-history', ['leaveRequestId' => $leaveRequest->id])); ?>">

                                    <span style="color: rgb(2,17,53); font-size: 12px; font-weight: 500;">View
                                        Details</span>

                                </a>
                                <button class="withdraw" wire:click="cancelLeave(<?php echo e($leaveRequest->id); ?>)">Withdraw</button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        </div>



        

        <div id="historyButton" class="row historyContent rounded mt-4" style="<?php echo e($activeSection === 'historyButton' ? '' : 'display:none;'); ?>; max-height:370px;overflow-y:auto;">
            <!--[if BLOCK]><![endif]--><?php if($this->leaveRequests->isNotEmpty()): ?>

            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->leaveRequests->whereIn('status', ['approved', 'rejected','Withdrawn']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leaveRequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="container mt-4" style="width:85%; margin:0 auto;">

                <div class="accordion rounded ">

                    <div class="accordion-heading rounded" onclick="toggleAccordion(this)">

                        <div class="accordion-title px-4 py-3">

                            <!-- Display leave details here based on $leaveRequest -->

                            <div class="col accordion-content">

                                <span style="color: #778899; font-size:12px; font-weight: 500;">Category</span>

                                <span style="color: #36454F; font-size: 12px; font-weight: 500;"><?php echo e($leaveRequest->category_type); ?></span>

                            </div>

                            <div class="col accordion-content">

                                <span style="color: #778899; font-size:12px; font-weight: 500;">Leave Type</span>

                                <span style="color: #36454F; font-size: 12px; font-weight: 500;"><?php echo e($leaveRequest->leave_type); ?></span>

                            </div>

                            <div class="col accordion-content">

                                <span style="color: #778899; font-size:12px; font-weight: 500;">No. of Days</span>

                                <span style="color: #36454F; font-size: 12px; font-weight: 500;">

                                    <?php echo e($this->calculateNumberOfDays($leaveRequest->from_date, $leaveRequest->from_session, $leaveRequest->to_date, $leaveRequest->to_session)); ?>


                                </span>

                            </div>



                            <!-- Add other details based on your leave request structure -->



                            <div class="col accordion-content">

                                <!--[if BLOCK]><![endif]--><?php if(strtoupper($leaveRequest->status) == 'APPROVED'): ?>

                                <span class="accordionContentSpanValue" style="color:#32CD32 !important;"><?php echo e(strtoupper($leaveRequest->status)); ?></span>

                                <?php elseif(strtoupper($leaveRequest->status) == 'REJECTED'): ?>

                                <span class="accordionContentSpanValue" style="color:#FF0000 !important;"><?php echo e(strtoupper($leaveRequest->status)); ?></span>

                                <?php else: ?>

                                <span class="accordionContentSpanValue" style="color:#778899 !important;"><?php echo e(strtoupper($leaveRequest->status)); ?></span>

                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            </div>

                            <div class="arrow-btn">
                                <i class="fa fa-chevron-down"></i>
                            </div>

                        </div>

                    </div>

                    <div class="accordion-body m-0 p-0">

                        <div class="verticalLine"></div>

                        <div class="content pt-1 px-4">

                            <span class="headerText">Duration:</span>

                            <span style="font-size: 11px;">

                                <span style="font-size: 11px; font-weight: 500;"> <?php echo e(\Carbon\Carbon::parse($leaveRequest->from_date)->format('d-m-Y')); ?></span>

                                (<?php echo e($leaveRequest->from_session); ?> ) to

                                <span style="font-size: 11px; font-weight: 500;"> <?php echo e(\Carbon\Carbon::parse($leaveRequest->to_date)->format('d-m-Y')); ?></span>

                                ( <?php echo e($leaveRequest->to_session); ?> )

                            </span>

                        </div>

                        <div class="content  pb-1 px-4">

                            <span class="headerText">Reason:</span>

                            <span style="font-size: 11px;"><?php echo e(ucfirst($leaveRequest->reason)); ?></span>

                        </div>

                        <div class="verticalLine"></div>

                        <div class="d-flex flex-row justify-content-between px-3 py-2">

                            <div class="content px-2 ">

                                <span class="headerText">Applied on:</span>

                                <span class="paragraphContent"><?php echo e($leaveRequest->created_at->format('d M, Y')); ?></span>

                            </div>

                            <div class="content px-2 ">
                                <a href="<?php echo e(route('leave-pending', ['leaveRequestId' => $leaveRequest->id])); ?>">
                                    <span class="viewDetails">View
                                        Details</span>
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

            <?php else: ?>

            <div class="containerWidth">
                <div class="leave-pending rounded">

                    <img src="<?php echo e(asset('/images/pending.png')); ?>" alt="Pending Image" class="imgContainer">

                    <p class="restrictedHoliday">There are no history records of any leave
                        transaction</p>

                </div>
            </div>

            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        </div>

    </div>
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
</script><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/leave-page.blade.php ENDPATH**/ ?>