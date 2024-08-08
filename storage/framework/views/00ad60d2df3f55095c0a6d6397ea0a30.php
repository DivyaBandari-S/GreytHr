<div>
    <div class="detail-container ">
        <div class="approved-leave d-flex gap-3">
            <div class="heading mb-3">
                <div class="heading-2" >
                    <div class="d-flex flex-row justify-content-between rounded">
                    <div class="field">
                            <span style="color: #778899; font-size: 12px; font-weight: 500;">
                                 Pending With
                            </span>
                                <!--[if BLOCK]><![endif]--><?php if($ManagerName): ?>
                                    <span style="color: #333; font-weight: 500;font-size:12px;">
                                       <?php echo e(ucwords(strtolower($ManagerName->first_name))); ?>&nbsp;<?php echo e(ucwords(strtolower($ManagerName->last_name))); ?>

                                    </span>
                                <?php else: ?>
                                    <span style="color: #333; font-weight: 500;font-size:12px; ">
                                         Manager Details Not Available
                                    </span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
 
                     <div>
                        <span style="color: #32CD32; font-size: 12px; font-weight: 500; text-transform:uppercase;">
                      
 
                                    <span style="margin-top:0.625rem; font-size: 12px; font-weight: 500; color:#32CD32;text-transform:uppercase;">pending</span>
 
                        </span>
                   </div>
                </div>
            <div class="middle-container">
                <div class="view-container m-0 p-0">
                     <div class="first-col" style="display:flex; gap:40px;">
                            <div class="field p-2">
                                <span style="color: #778899; font-size:11px; font-weight: 500;">Remarks</span>
                                <span style="font-size: 12px; font-weight: 600;text-align:center;">-<br></span>
                            </div>
                           
                            <div class="vertical-line"></div>
                         </div>
                         <div class="box" style="display:flex;  margin-left:30px;  text-align:center; padding:5px;">
                            <div class="field p-2">
                                <span style="color: #778899; font-size:10px; font-weight: 500;">No. of days</span>
                                <span style=" font-size: 12px; font-weight: 600;"><?php echo e($totalEntries); ?></span>
                            </div>
                        </div>
                     </div>
                 </div>
              </div>
 
        
        </div>
        <div class="side-container mx-2 ">
            <h6 style="color: #778899; font-size: 12px; font-weight: 500; text-align:start;"> Application Timeline </h6>
           <div  style="display:flex; ">
           <div style="margin-top:20px;">
             <div class="cirlce"></div>
             <div class="v-line"></div>
              <div class=cirlce></div>
            </div>
              <div style="display:flex; flex-direction:column; gap:60px;">
              <div class="group">
              <div>
                <h5 style="color: #333; font-size: 12px; font-weight: 400; text-align:start;">
                    
                        Pending <br><span style="color: #778899; font-size: 12px; font-weight: 400; text-align:start;">with</span>
                        <!--[if BLOCK]><![endif]--><?php if($ManagerName): ?>
                            <span style="color: #778899; font-weight: 500; ">
                            <?php echo e(ucwords(strtolower($ManagerName->first_name))); ?>&nbsp;<?php echo e(ucwords(strtolower($ManagerName->last_name))); ?>

                            </span>
                        <?php else: ?>
                           <span style="color: #778899; font-weight: 500;">
                             Manager Details Not Available
                            </span>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <br>
                    
                </h5>
            </div>
 
           </div>
           <div class="group">
               <div >
                  <h5 style="color: #333; font-size: 12px; font-weight: 400; text-align:start;">Submitted<br>
                <span style="color: #778899; font-size: 11px; font-weight: 400;text-align:start;">
                                      <!--[if BLOCK]><![endif]--><?php if(\Carbon\Carbon::parse($regularisationrequest->created_at)->isToday()): ?>
                                                Today 
                                      <?php elseif(\Carbon\Carbon::parse($regularisationrequest->created_at)->isYesterday()): ?>
                                                Yesterday
                                      <?php else: ?>
                                         <?php echo e(\Carbon\Carbon::parse($regularisationrequest->created_at)->format('Y-m-d')); ?>

                                      <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                      &nbsp;&nbsp;&nbsp;<?php echo e(\Carbon\Carbon::parse($regularisationrequest->created_at)->format('h:i A')); ?>

                </span>
                    </h5>
               </div>
           </div>
              </div>
           
           </div>
             
        </div>
        </div>
    </div>
  <div class="rounded bg-white border mt-4">
  <table class="custom-table">
        <thead>
            <tr>
                <th class="header-style">Date</th>
                <th class="header-style">Approve/Reject</th>
                <th class="header-style">Approver&nbsp;Remarks</th>
                <th class="header-style">Shift</th>
                <th class="header-style">First In Time</th>
                <th class="header-style">Last Out Time</th>
                <th class="header-style">Reason</th>
            </tr>
        </thead>
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $regularisationEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tbody >
                <td><?php echo e(\Carbon\Carbon::parse($entry['date'])->format('d M, Y')); ?></td>
                <td style="text-transform: uppercase;">pending</td>
                <td>-</td>
                <td class="overflow-cell">10:00 am to 07:00 pm</td>
                <td>
                       <!--[if BLOCK]><![endif]--><?php if(empty($entry['from'])): ?>
                            10:00
                       <?php else: ?>
                            <?php echo e($entry['from']); ?>

                       <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </td>
                <td>
                       <!--[if BLOCK]><![endif]--><?php if(empty($entry['to'])): ?>
                            19:00
                       <?php else: ?>
                            <?php echo e($entry['to']); ?>

                       <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </td>
                <td style="padding-right:5px;">
                       <!--[if BLOCK]><![endif]--><?php if(empty($entry['reason'])): ?>
                            -....
                       <?php else: ?>
                            <?php echo e($entry['reason']); ?>

                       <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </td>
        </tbody>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </table>
  </div>

</div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/regularisation-pending.blade.php ENDPATH**/ ?>