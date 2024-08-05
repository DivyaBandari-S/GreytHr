<div style="text-align:center">


    <!--[if BLOCK]><![endif]--><?php if(auth()->guard('admins')->check()): ?>
    <div class="col" style="margin-left:20%">

        <div style="display:flex">

        </div>
    </div>
    <div class="card-body" style="background-color:white;width:97%;height:400px;margin-top:30px;border-radius:5px;max-height:400px;overflow-y:auto;overflow-x:auto;max-width:1100px;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: rgb(2, 17, 79); color: white;">
                    <th style="padding: 10px;font-size:12px;text-align:center;width:120px">Request Raised By</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Category</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Subject</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Description</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Distributor</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Mobile</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">MailBox</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Attach Files</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">CC To</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Priority</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Select Equipment</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Status</th>
                </tr>
            </thead>
            <tbody>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $forAdmin; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                <tr>
                    <td style="padding: 10px;font-size:12px;text-align:center;width:120px;text-transform: capitalize;">
                        <?php echo e($record->emp->first_name); ?> <?php echo e($record->emp->last_name); ?> <br>
                        <strong style="font-size: 10px;">(<?php echo e($record->emp_id); ?>)</strong>
                    </td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">
                        <?php echo e($record->category ?? 'N/A'); ?>

                    </td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">
                        <?php echo e($record->subject ?? 'N/A'); ?>

                    </td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">
                        <?php echo e($record->description ?? 'N/A'); ?>

                    </td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">
                        <?php echo e($record->distributor_name ?? 'N/A'); ?>

                    </td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">
                        <?php echo e($record->mobile ?? 'N/A'); ?>

                    </td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">
                        <?php echo e($record->mail ?? 'N/A'); ?>

                    </td>
                    <td style="padding: 10px;font-size:12px;text-align:center">
                        <!--[if BLOCK]><![endif]--><?php if($record->file_path): ?>
                        <a href="<?php echo e(asset('storage/' . $record->file_path)); ?>" target="_blank" style="text-decoration: none; color: #007BFF;text-transform: capitalize;">View File</a>
                        <?php else: ?>
                        N/A
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">
                        <?php echo e($record->cc_to ?? 'N/A'); ?>

                    </td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">
                        <?php echo e($record->priority ?? 'N/A'); ?>

                    </td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">
                        <?php echo e($record->selected_equipment ?? 'N/A'); ?>

                    </td>
                    <td style="padding: 5px; font-size: 12px; text-align: center;">
                        <div class="row" style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <button wire:click="confirmByAdmin('<?php echo e($record->id); ?>')" style="background-color: rgb(2, 17, 79); color: white; border-radius: 3px; font-size:12px;border :1px solid silver;width:110px;height:30px">Confirm</button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </tbody>
        </table>
    </div>

    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


    <!--[if BLOCK]><![endif]--><?php if(auth()->guard('hr')->check()): ?>
    <div class="col" style="margin-left:20%">
        <div class="card" style="width:400px;">
            <div class="card-header">
                <div class="row">
                    <button wire:click="$set('activeTab', 'active')" class="col btn <?php if($activeTab === 'active'): ?>  active <?php else: ?> btn-light <?php endif; ?>" style="border-radius: 5px; margin-right: 5px; background-color: <?php if($activeTab === 'active'): ?> rgb(2, 17, 79) <?php else: ?> none <?php endif; ?>; color: <?php if($activeTab === 'active'): ?> #fff <?php else: ?> #000 <?php endif; ?>;">
                        Active
                    </button>
                    <button wire:click="$set('activeTab', 'pending')" class="col btn <?php if($activeTab === 'pending'): ?>  active <?php else: ?> btn-light <?php endif; ?>" style="border-radius: 5px; background-color: <?php if($activeTab === 'pending'): ?> rgb(2, 17, 79) <?php else: ?> none <?php endif; ?>; color: <?php if($activeTab === 'pending'): ?> #fff <?php else: ?> #000 <?php endif; ?>;">
                        Pending
                    </button>
                    <button wire:click="$set('activeTab', 'closed')" class="col btn <?php if($activeTab === 'closed'): ?>  active <?php else: ?> btn-light <?php endif; ?>" style="border-radius: 5px; background-color: <?php if($activeTab === 'closed'): ?> rgb(2, 17, 79) <?php else: ?> none <?php endif; ?>; color: <?php if($activeTab === 'closed'): ?> #fff <?php else: ?> #000 <?php endif; ?>;">
                        Closed
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!--[if BLOCK]><![endif]--><?php if($activeTab == "active"): ?>
    <div class="card-body" style="background-color:white;width:95%;height:400px;margin-top:30px;border-radius:5px;max-height:400px;overflow-y:auto;overflow-x:auto;max-width:1100px;">

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: rgb(2, 17, 79); color: white;">
                    <th style="padding: 10px;font-size:12px;text-align:center;width:120px">Request Raised By</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Category</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Subject</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Description</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Distributor</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Mobile</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">MailBox</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Attach Files</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">CC To</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Priority</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Status</th>
                </tr>
            </thead>
            <tbody>
                <!--[if BLOCK]><![endif]--><?php if($forHR->where('status', 'Open')->count() > 0): ?>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $forHR->where('status', 'Open'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="padding: 10px;font-size:12px;text-align:center;width:120px;text-transform: capitalize;"><?php echo e($record->emp->first_name); ?> <?php echo e($record->emp->last_name); ?> <br> <strong style="font-size: 10px;">(<?php echo e($record->emp_id); ?>)</strong></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"> <?php echo e($record->category ?? 'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->subject); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->description); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->distributor_name ?? 'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->mobile); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->mail); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center">
                        <!--[if BLOCK]><![endif]--><?php if($record->file_path): ?>
                        <a href="<?php echo e(asset('storage/' . $record->file_path)); ?>" target="_blank" style="text-decoration: none; color: #007BFF;text-transform: capitalize;">View File</a>
                        <?php else: ?>
                        N/A
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->cc_to); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->priority); ?></td>
                    <td style="padding: 5px; font-size: 12px; text-align: center;">
                        <div class="row" style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <button wire:click="openForDesks('<?php echo e($record->id); ?>')" style="background-color: rgb(2, 17, 79); color: white; border-radius: 3px; padding: 5px;margin-bottom:8px">Close</button>
                            <button wire:click="pendingForDesks('<?php echo e($record->id); ?>')" style="background-color: rgb(2, 17, 79); color: white; border-radius: 3px; padding: 5px;">Pending</button>
                        </div>

                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;font-size:12px">Active records not found</td>
                </tr>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            </tbody>
        </table>

    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if($activeTab == "pending"): ?>
    <div class="card-body" style="background-color:white;width:95%;margin-top:30px;border-radius:5px;max-height:400px;height:400px;overflow-y:auto">

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: rgb(2, 17, 79); color: white;">
                    <th style="padding: 10px;font-size:12px;text-align:center;width:120px">Request Raised By</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Category</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Subject</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Description</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Distributor</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Mobile</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">MailBox</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Attach Files</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">CC To</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Priority</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Status</th>
                </tr>
            </thead>
            <tbody>
                <!--[if BLOCK]><![endif]--><?php if($forHR->where('status', 'Pending')->count() > 0): ?>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $forHR->where('status', 'Pending'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="padding: 10px;font-size:12px;text-align:center;width:120px;text-transform: capitalize;"><?php echo e($record->emp->first_name); ?> <?php echo e($record->emp->last_name); ?> <br> <strong style="font-size: 10px;">(<?php echo e($record->emp_id); ?>)</strong></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"> <?php echo e($record->category ?? 'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->subject ?? 'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->description ?? 'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->distributor_name?? 'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->mobile); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->mail ?? 'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center">
                        <!--[if BLOCK]><![endif]--><?php if($record->file_path): ?>
                        <a href="<?php echo e(asset('storage/' . $record->file_path)); ?>" target="_blank" style="text-decoration: none; color: #007BFF;text-transform: capitalize;">View File</a>
                        <?php else: ?>
                        N/A
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->cc_to ?? 'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->priority ?? 'N/A'); ?></td>
                    <td style="padding: 5px; font-size: 12px; text-align: center;">
                        <div class="row" style="display: flex; justify-content: space-between;">
                            <button wire:click="openForDesks('<?php echo e($record->id); ?>')" style="background-color: rgb(2, 17, 79); color: white; border-radius: 3px; padding: 5px;">Close</button>
                        </div>

                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;font-size:12px">Pending records not found</td>
                </tr>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            </tbody>
        </table>

    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if($activeTab == "closed"): ?>
    <div class="card-body" style="background-color:white;width:95%;margin-top:30px;border-radius:5px;max-height:400px;height:400px;overflow-y:auto">

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: rgb(2, 17, 79); color: white;">
                    <th style="padding: 10px;font-size:12px;text-align:center;width:120px">Request Raised By</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Category</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Subject</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Description</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Distributor</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Mobile</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">MailBox</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Attach Files</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">CC To</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Priority</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Select Equipment</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Status</th>
                </tr>
            </thead>
            <tbody>
                <!--[if BLOCK]><![endif]--><?php if($forHR->where('status', 'Completed')->count() > 0): ?>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $forHR->where('status', 'Completed'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="padding: 10px;font-size:12px;text-align:center;width:120px;text-transform: capitalize;"><?php echo e($record->emp->first_name); ?> <?php echo e($record->emp->last_name); ?> <br> <strong style="font-size: 10px;">(<?php echo e($record->emp_id); ?>)</strong></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->category); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->subject); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->description); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->distributor_name); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->mobile); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->mail); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center">
                        <!--[if BLOCK]><![endif]--><?php if($record->file_path): ?>
                        <a href="<?php echo e(asset('storage/' . $record->file_path)); ?>" target="_blank" style="text-decoration: none; color: #007BFF;text-transform: capitalize;">View File</a>
                        <?php else: ?>
                        N/A
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->cc_to); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->priority); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->selected_equipment ??'N/A'); ?></td>

                    <td style="padding: 5px; font-size: 12px; text-align: center">

                        <div class="row" style="display: flex; justify-content: space-between;">
                            <button wire:click="closeForDesks('<?php echo e($record->id); ?>')" style="background-color: rgb(2, 17, 79); color: white; border-radius: 5px; padding: 5px;">Open</button>
                        </div>

                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;font-size:12px">Closed records not found</td>
                </tr>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            </tbody>
        </table>

    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->




    <!--[if BLOCK]><![endif]--><?php if(auth()->guard('it')->check()): ?>

    <div class="col" style="margin-left:20%">
        <div style="display:flex">
            <div class="card" style="width:400px;">
                <div class="card-header">
                    <div class="row">
                        <button wire:click="$set('activeTab', 'active')" class="col btn <?php if($activeTab === 'active'): ?>  active <?php else: ?> btn-light <?php endif; ?>" style="border-radius: 5px; margin-right: 5px; background-color: <?php if($activeTab === 'active'): ?> rgb(2, 17, 79) <?php else: ?> none <?php endif; ?>; color: <?php if($activeTab === 'active'): ?> #fff <?php else: ?> #000 <?php endif; ?>;">
                            Active
                        </button>
                        <button wire:click="$set('activeTab', 'pending')" class="col btn <?php if($activeTab === 'pending'): ?>  active <?php else: ?> btn-light <?php endif; ?>" style="border-radius: 5px; background-color: <?php if($activeTab === 'pending'): ?> rgb(2, 17, 79) <?php else: ?> none <?php endif; ?>; color: <?php if($activeTab === 'pending'): ?> #fff <?php else: ?> #000 <?php endif; ?>;">
                            Pending
                        </button>
                        <button wire:click="$set('activeTab', 'closed')" class="col btn <?php if($activeTab === 'closed'): ?>  active <?php else: ?> btn-light <?php endif; ?>" style="border-radius: 5px; background-color: <?php if($activeTab === 'closed'): ?> rgb(2, 17, 79) <?php else: ?> none <?php endif; ?>; color: <?php if($activeTab === 'closed'): ?> #fff <?php else: ?> #000 <?php endif; ?>;">
                            Closed
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!--[if BLOCK]><![endif]--><?php if($activeTab == "active"): ?>
    <div class="card-body" style="background-color:white;width:95%;height:400px;margin-top:30px;border-radius:5px;max-height:400px;overflow-y:auto;overflow-x:auto;max-width:1100px;">
        <div class="card-body" style="background-color:white;width:95%;height:400px;margin-top:30px;border-radius:5px;max-height:400px;overflow-y:auto">

            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: rgb(2, 17, 79); color: white;">
                        <th style="padding: 10px;font-size:12px;text-align:center;width:120px">Request Raised By</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Category</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Subject</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Description</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Distributor_name</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Mobile</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">MailBox</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Attach Files</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">CC To</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Priority</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Select Equipment</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!--[if BLOCK]><![endif]--><?php if($forIT->where('status', 'Open')->count() > 0): ?>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $forIT->where('status', 'Open'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td style="padding: 10px;font-size:12px;text-align:center;width:120px;text-transform: capitalize;"><?php echo e($record->emp->first_name); ?> <?php echo e($record->emp->last_name); ?> <br> <strong style="font-size: 10px;">(<?php echo e($record->emp_id); ?>)</strong></td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"> <?php echo e($record->category ?? 'N/A'); ?></td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->subject??'N/A'); ?></td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->description ??'N/A'); ?></td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->distributor_name ??'N/A'); ?></td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->mobile ??'N/A'); ?></td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->mail ??'N/A'); ?></td>
                        <td style="padding: 10px;font-size:12px;text-align:center">
                            <!--[if BLOCK]><![endif]--><?php if($record->file_path): ?>
                            <a href="<?php echo e(asset('storage/' . $record->file_path)); ?>" target="_blank" style="text-decoration: none; color: #007BFF;text-transform: capitalize;">View File</a>
                            <?php else: ?>
                            N/A
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>
                     
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->cc_to ??'N/A'); ?></td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->priority ??'N/A'); ?></td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->selected_equipment ??'N/A'); ?></td>
                        <td style="padding: 5px; font-size: 12px; text-align: center;">
                            <div class="row" style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <button wire:click="openForDesks('<?php echo e($record->id); ?>')" style="background-color: rgb(2, 17, 79); color: white; border-radius: 3px; padding: 5px;margin-bottom:8px">Close</button>
                                <button wire:click="pendingForDesks('<?php echo e($record->id); ?>')" style="background-color: rgb(2, 17, 79); color: white; border-radius: 3px; padding: 5px;">Pending</button>
                            </div>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center;font-size:12px">Active records not found</td>
                    </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                </tbody>
            </table>

        </div>

    </div>
    <?php elseif($activeTab == "pending"): ?>
    <div class="card-body" style="background-color:white;width:95%;margin-top:30px;border-radius:5px;max-height:400px;height:400px;overflow-y:auto">

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: rgb(2, 17, 79); color: white;">
                    <th style="padding: 10px;font-size:12px;text-align:center;width:120px">Request Raised By</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Category</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Subject</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Description</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Distributor</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Mobile</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">MailBox</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Attach Files</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">CC To</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Priority</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Select Equipment</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Status</th>
                </tr>
            </thead>
            <tbody>
                <!--[if BLOCK]><![endif]--><?php if($forIT->where('status', 'Pending')->count() > 0): ?>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $forIT->where('status', 'Pending'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="padding: 10px;font-size:12px;text-align:center;width:120px;text-transform: capitalize;"><?php echo e($record->emp->first_name); ?> <?php echo e($record->emp->last_name); ?> <br> <strong style="font-size: 10px;">(<?php echo e($record->emp_id); ?>)</strong></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->category ?? 'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->subject ?? 'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->description?? 'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->distributor_name?? 'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->mobile?? 'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->mail ??'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center">
                        <!--[if BLOCK]><![endif]--><?php if($record->file_path): ?>
                        <a href="<?php echo e(asset('storage/' . $record->file_path)); ?>" target="_blank" style="text-decoration: none; color: #007BFF;text-transform: capitalize;">View File</a>
                        <?php else: ?>
                        N/A
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->cc_to?? 'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->priority?? 'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->selected_equipment?? 'N/A'); ?></td>
                    <td style="padding: 5px; font-size: 12px; text-align: center;">
                        <div class="row" style="display: flex; justify-content: space-between;">
                            <button wire:click="openForDesks('<?php echo e($record->id); ?>')" style="background-color: rgb(2, 17, 79); color: white; border-radius: 3px; padding: 5px;">Close</button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;font-size:12px">Pending records not found</td>
                </tr>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            </tbody>
        </table>

    </div>

    <?php elseif($activeTab == "closed"): ?>
    <div class="card-body" style="background-color:white;width:95%;margin-top:30px;border-radius:5px;max-height:400px;height:400px;overflow-y:auto">

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: rgb(2, 17, 79); color: white;">
                    <th style="padding: 10px;font-size:12px;text-align:center;width:120px">Request Raised By</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Category</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Subject</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Description</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Distributor</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Mobile</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">MailBox</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Attach Files</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">CC To</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Priority</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Select Equipment</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Status</th>
                </tr>
            </thead>
            <tbody>
                <!--[if BLOCK]><![endif]--><?php if($forIT->where('status', 'Completed')->count() > 0): ?>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $forIT->where('status', 'Completed'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="padding: 10px;font-size:12px;text-align:center;width:120px;text-transform: capitalize;"><?php echo e($record->emp->first_name); ?> <?php echo e($record->emp->last_name); ?> <br> <strong style="font-size: 10px;">(<?php echo e($record->emp_id); ?>)</strong></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->category??'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->subject ??'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->description ??'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->distributor_name ??'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->mobile ??'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->mail ??'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center">
                        <!--[if BLOCK]><![endif]--><?php if($record->file_path): ?>
                        <a href="<?php echo e(asset('storage/' . $record->file_path)); ?>" target="_blank" style="text-decoration: none; color: #007BFF;text-transform: capitalize;">View File</a>
                        <?php else: ?>
                        N/A
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->cc_to ??'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->priority ??'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->selected_equipment??'N/A'); ?></td>
                    <td style="padding: 5px; font-size: 12px; text-align: center">
                        <div class="row" style="display: flex; justify-content: space-between;">
                            <button wire:click="closeForDesks('<?php echo e($record->id); ?>')" style="background-color: rgb(2, 17, 79); color: white; border-radius: 5px; padding: 5px;">Open</button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;font-size:12px">Closed records not found</td>
                </tr>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            </tbody>
        </table>

    </div>


    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->








    <!--[if BLOCK]><![endif]--><?php if(auth()->guard('finance')->check()): ?>
    <div class="col" style="margin-left:20%">
        <div class="card" style="width:400px;">
            <div class="card-header">
                <div class="row">
                    <button wire:click="$set('activeTab', 'active')" class="col btn <?php if($activeTab === 'active'): ?>  active <?php else: ?> btn-light <?php endif; ?>" style="border-radius: 5px; margin-right: 5px; background-color: <?php if($activeTab === 'active'): ?> rgb(2, 17, 79) <?php else: ?> none <?php endif; ?>; color: <?php if($activeTab === 'active'): ?> #fff <?php else: ?> #000 <?php endif; ?>;">
                        Active
                    </button>
                    <button wire:click="$set('activeTab', 'pending')" class="col btn <?php if($activeTab === 'pending'): ?>  active <?php else: ?> btn-light <?php endif; ?>" style="border-radius: 5px; background-color: <?php if($activeTab === 'pending'): ?> rgb(2, 17, 79) <?php else: ?> none <?php endif; ?>; color: <?php if($activeTab === 'pending'): ?> #fff <?php else: ?> #000 <?php endif; ?>;">
                        Pending
                    </button>
                    <button wire:click="$set('activeTab', 'closed')" class="col btn <?php if($activeTab === 'closed'): ?>  active <?php else: ?> btn-light <?php endif; ?>" style="border-radius: 5px; background-color: <?php if($activeTab === 'closed'): ?> rgb(2, 17, 79) <?php else: ?> none <?php endif; ?>; color: <?php if($activeTab === 'closed'): ?> #fff <?php else: ?> #000 <?php endif; ?>;">
                        Closed
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!--[if BLOCK]><![endif]--><?php if($activeTab == "active"): ?>
    <div class="card-body" style="background-color:white;width:95%;height:400px;margin-top:30px;border-radius:5px;max-height:400px;overflow-y:auto;overflow-x:auto;max-width:1100px;">

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: rgb(2, 17, 79); color: white;">
                    <th style="padding: 10px;font-size:12px;text-align:center;width:120px">Request Raised By</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Category</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Subject</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Description</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Distributor</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Mobile</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">MailBox</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Attach Files</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">CC To</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Priority</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Select Equipment</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Status</th>
                </tr>
            </thead>
            <tbody>
                <!--[if BLOCK]><![endif]--><?php if($forFinance->where('status', 'Open')->count() > 0): ?>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $forFinance->where('status', 'Open'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="padding: 10px;font-size:12px;text-align:center;width:120px;text-transform: capitalize;"><?php echo e($record->emp->first_name); ?> <?php echo e($record->emp->last_name); ?> <br> <strong style="font-size: 10px;">(<?php echo e($record->emp_id); ?>)</strong></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->category); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->subject); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->description); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->distributor_name); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->mobile); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->mail); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center">
                        <!--[if BLOCK]><![endif]--><?php if($record->file_path): ?>
                        <a href="<?php echo e(asset('storage/' . $record->file_path)); ?>" target="_blank" style="text-decoration: none; color: #007BFF;text-transform: capitalize;">View File</a>
                        <?php else: ?>
                        N/A
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->cc_to); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->selected_equipment?? 'N/A'); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->priority); ?></td>
                    <td style="padding: 5px; font-size: 12px; text-align: center;">
                        <div class="row" style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <button wire:click="openForDesks('<?php echo e($record->id); ?>')" style="background-color: rgb(2, 17, 79); color: white; border-radius: 3px; padding: 5px;margin-bottom:8px">Close</button>
                            <button wire:click="pendingForDesks('<?php echo e($record->id); ?>')" style="background-color: rgb(2, 17, 79); color: white; border-radius: 3px; padding: 5px;">Pending</button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;font-size:12px">Active records not found</td>
                </tr>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            </tbody>
        </table>

    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if($activeTab == "pending"): ?>
    <div class="card-body" style="background-color:white;width:95%;margin-top:30px;border-radius:5px;max-height:400px;height:400px;overflow-y:auto">

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: rgb(2, 17, 79); color: white;">
                    <th style="padding: 10px;font-size:12px;text-align:center;width:120px">Request Raised By</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Category</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Subject</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Description</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Distributor_name</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Mobile</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">MailBox</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Attach Files</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">CC To</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Priority</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Status</th>
                </tr>
            </thead>
            <tbody>
                <!--[if BLOCK]><![endif]--><?php if($forFinance->where('status', 'Pending')->count() > 0): ?>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $forFinance->where('status', 'Pending'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="padding: 10px;font-size:12px;text-align:center;width:120px;text-transform: capitalize;"><?php echo e($record->emp->first_name); ?> <?php echo e($record->emp->last_name); ?> <br> <strong style="font-size: 10px;">(<?php echo e($record->emp_id); ?>)</strong></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->category); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->subject); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->description); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->distributor_name); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->mobile); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->mail); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center">
                        <!--[if BLOCK]><![endif]--><?php if($record->file_path): ?>
                        <a href="<?php echo e(asset('storage/' . $record->file_path)); ?>" target="_blank" style="text-decoration: none; color: #007BFF;text-transform: capitalize;">View File</a>
                        <?php else: ?>
                        N/A
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->cc_to); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->priority); ?></td>
                    <td style="padding: 5px; font-size: 12px; text-align: center;">
                        <div class="row" style="display: flex; justify-content: space-between;">
                            <button wire:click="openForDesks('<?php echo e($record->id); ?>')" style="background-color: rgb(2, 17, 79); color: white; border-radius: 3px; padding: 5px;">Close</button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;font-size:12px">Pending records not found</td>
                </tr>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            </tbody>
        </table>

    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if($activeTab == "closed"): ?>
    <div class="card-body" style="background-color:white;width:95%;margin-top:30px;border-radius:5px;max-height:400px;height:400px;overflow-y:auto">

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: rgb(2, 17, 79); color: white;">
                    <th style="padding: 10px;font-size:12px;text-align:center;width:120px">Request Raised By</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Category</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Subject</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Description</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Distributor</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Mobile</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Mail</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Attach Files</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">CC To</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Priority</th>
                    <th style="padding: 10px;font-size:12px;text-align:center">Status</th>
                </tr>
            </thead>
            <tbody>
                <!--[if BLOCK]><![endif]--><?php if($forFinance->where('status', 'Completed')->count() > 0): ?>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $forFinance->where('status', 'Completed'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="padding: 10px;font-size:12px;text-align:center;width:120px;text-transform: capitalize;"><?php echo e($record->emp->first_name); ?> <?php echo e($record->emp->last_name); ?> <br> <strong style="font-size: 10px;">(<?php echo e($record->emp_id); ?>)</strong></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->category); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->subject); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->description); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->distributor_name); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->mobile); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->mail); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center">
                        <!--[if BLOCK]><![endif]--><?php if($record->file_path): ?>
                        <a href="<?php echo e(asset('storage/' . $record->file_path)); ?>" target="_blank" style="text-decoration: none; color: #007BFF;text-transform: capitalize;">View File</a>
                        <?php else: ?>
                        N/A
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->cc_to); ?></td>
                    <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;"><?php echo e($record->priority); ?></td>
                    <td style="padding: 5px; font-size: 12px; text-align: center">
                        <div class="row" style="display: flex; justify-content: space-between;">
                            <button wire:click="closeForDesks('<?php echo e($record->id); ?>')" style="background-color: rgb(2, 17, 79); color: white; border-radius: 5px; padding: 5px;">Open</button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;font-size:12px">Closed records not found</td>
                </tr>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            </tbody>
        </table>

    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/auth-checking.blade.php ENDPATH**/ ?>