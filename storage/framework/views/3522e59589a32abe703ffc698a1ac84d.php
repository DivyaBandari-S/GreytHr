<div class="router-container pb-15 container-fluid">
  <router-outlet></router-outlet>
  <itd-plan-details _nghost-whw-c468="" class="ng-star-inserted">
    <div _ngcontent-whw-c468="" class="itd-plan-details ng-star-inserted">
      <div _ngcontent-whw-c468="" class="itd-plan-details-alert ng-star-inserted">
        <alert _ngcontent-whw-c468="" type="info" dismissible="true">
          <div role="alert" class="alert alert-info alert-dismissible ng-star-inserted">
            <button type="button" aria-label="Close" class="close ng-star-inserted">
              <span aria-hidden="true">×</span>
              <span class="sr-only">Close</span>
            </button>
            <!---->
            <i _ngcontent-whw-c468="" class="alert-icon fa fa-fw fa-warning"></i>
            <span _ngcontent-whw-c468="" class="alert-text" style="font-size:12px"> Please note, you're only calculating your taxes. This is not a submission. </span>
          </div>
          <!---->
        </alert>
      </div>
      <div _ngcontent-whw-c468="" class="itd-plan-details-search ng-star-inserted">
        <itd-sections-typeahead _ngcontent-whw-c468="" _nghost-whw-c466="">
          <gt-typeahead _ngcontent-whw-c466="" class="itd-sections-typeahead ng-star-inserted">
            <div dropdown="" class="btn-group gt-typeahead">
              <form novalidate="" class="ng-untouched ng-pristine ng-valid">
                <div class="input-with-icon">
                  <input type="text" name="search" placeholder="Search" autocomplete="off" class="form-control ng-untouched ng-pristine ng-valid">
                  <!---->
                  <i class="icon-gt-search ng-star-inserted"></i>
                  <!---->
                </div>
              </form>
              <!---->
            </div>
            <!---->
          </gt-typeahead>
          <!---->
          <!---->
        </itd-sections-typeahead>
      </div>
      <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div _ngcontent-whw-c468="" class="itd-plan-details-content ng-star-inserted">
        <div _ngcontent-whw-c468="" class="row">
          <!-- Card 1 -->
         <div class="row" style="height:200px;margin-top:20px;width:300px;background:white;margin-left:10px;border:1px solid silver;border-radius:5px;font-size:12px">
         <img src="https://calisthenicsacademy.co/wp-content/uploads/2015/11/number-8-no-lines.png" style="height:40px;width:80px;margin-top:40px;margin-left:70px">
         <p _ngcontent-whw-c467="" class="text-black" title="Sec 80C" style="margin-left:70px">Sec 80C</p>
         
    <p style="margin-top:-20px;margin-left:40px">Total Value: <?php echo e($total); ?>/1,50,000</p>
 
         <a class="declaration-link" style="margin-top: -30px; margin-left: 50px;" wire:click="addSec80">Add to declaration</a>
         <!--[if BLOCK]><![endif]--><?php if($showSec80CDialog): ?>
 
<div class="modal" tabindex="-1" role="dialog" style="display: block;font-size:12px">
 
    <div class="modal-dialog modal-dialog-centered" role="document">
 
        <div class="modal-content" style="width: 800px;font-size:12px">
        <div class="modal-header" style="background-color:  #D4D2D2; height: 60px; width: 800px">
        <h5 style="padding: 5px; color: #747576; font-size: 15px;" class="modal-title"><b>Sec 80C</b></h5>
        <button wire:click="closeSec80C" type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #747576">
            <span aria-hidden="true" style="color: black;">×</span>
        </button>
    </div>
    <div class="modal-body" style="max-height: auto;">
        <div class="container" style="height: 60px; border: 1px solid silver; border-radius: 7px;width:700px">
         
            <p>Total Value: <?php echo e($total); ?>/1,50,000</p>
            <div style="margin-top: -10px; display: flex">
                <p style="margin-left: 35px">Max Limit in (₹)</p>
                <p style="margin-left: 26px">1,50,000</p>
            </div>
        </div>
        <!-- Begin the form outside the .form-group div -->
        <form wire:submit.prevent="submitsec80">
            <div class="form-group">
                <div class="column" style="display:flex">
                    <div class="row">
                        <label for="5_years_fixed_deposit" style="font-size:14px;">80C 5 Years of Fixed Deposit in Scheduled Bank</label>
                     
                        <input type="text" wire:model="fields.5_years_fixed_deposit" name="fields.5_years_fixed_deposit" id="5_years_fixed_deposit" class="form-control" placeholder="₹ Enter amount" style="width:200px; font-size:14px; margin-left:20px; ">
 
 
<!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fields.5_years_fixed_deposit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="text-danger" style="font-size:10px"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                      </div>
                    <div class="row">
                        <label for="5_years_deposit" style="font-size:14px">80C Children Tuition Fees
</label>
           
                 <input type="text" wire:model="fields.5_years_deposit" name="fields.5_years_deposit" id="5_years_deposit" class="form-control" placeholder="₹ Enter amount" style="width:200px; font-size:14px; margin-left:20px; ">
 
 
<!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fields.5_years_deposit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="text-danger" style="font-size:10px"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->  
                </div>
                </div>
            </div>
            <div class="form-group">
                <div class="column" style="display:flex">
                    <div class="row">
                        <label for="contribution_to_pension_fund">80CCC Contribution to Pension Fund</label>
                       <input type="text" wire:model="fields.contribution_to_pension_fund" name="fields.contribution_to_pension_fund" id="contribution_to_pension_fund" class="form-control" placeholder="₹ Enter amount" style="width:200px; font-size:14px; margin-left:20px; ">
 
 
<!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fields.contribution_to_pension_fund'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="text-danger" style="font-size:10px"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->  
                      </div>
                    <div class="row">
                        <label for="deposit_in_nsc" style="margin-left: 20px;font-size:14px">80C Deposit in NSC</label>
                       
   
                     <input type="text" wire:model="fields.deposit_in_nsc" name="fields.deposit_in_nsc" id="deposit_in_nsc" class="form-control" placeholder="₹ Enter amount" style="width:200px; font-size:14px; margin-left:20px; ">
 
 
<!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fields.deposit_in_nsc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="text-danger" style="font-size:10px"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->  
                    </div>
                </div>
            </div>
            <div class="for
            m-group">
                <div class="column" style="display:flex">
                    <div class="row">
                        <label for="deposit_in_nss">80C Deposit in NSS</label>
                    <input type="text" wire:model="fields.deposit_in_nss" name="fields.deposit_in_nss" id="deposit_in_nss" class="form-control" placeholder="₹ Enter amount" style="width:200px; font-size:14px; margin-left:20px; ">
 
 
<!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fields.deposit_in_nss'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="text-danger" style="font-size:10px"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->  
                </div>
                    <div class="row">
                        <label for="interest_on_nsc_reinvested" style="margin-left: 210px;font-size:14px">80C Interest on NSC Reinvested</label>
                        <input type="text" wire:model="fields.interest_on_nsc_reinvested" name="fields.interest_on_nsc_reinvested" id="interest_on_nsc_reinvested" class="form-control" placeholder="₹ Enter amount" style="width:200px; font-size:14px; margin-left:240px; ">
 
 
<!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fields.deposit_in_nsc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="text-danger" style="font-size:10px"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->  
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="column" style="display:flex">
                    <div class="row">
                        <label for="equity" style="font-size:14px;margin-left:20px">80C Equity Linked Savings Scheme ( ELSS )</label>
 
                        <input type="text" wire:model="fields.equity" name="fields.equity" id="equity" class="form-control" placeholder="₹ Enter amount" style="width:200px; font-size:14px; margin-left:20px; ">
 
<!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fields.life_insurance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="text-danger" style="font-size:10px"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->      
                    </div>
                    <div class="row">
                        <label for="life_insurance" style="margin-left: 70px;font-size:14px">Life Insurance Premium</label>
                       
 
                     <input type="text" wire:model="fields.life_insurance" name="fields.life_insurance" id="life_insurance" class="form-control" placeholder="₹ Enter amount" style="width:200px; font-size:14px; margin-left:90px; ">
 
<!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fields.life_insurance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="text-danger" style="font-size:10px"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->      
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 20px;">
                <div class="col-1">
                    <button type="button"  wire:click="submitsec80" class="custom-button submit-button" style="background:green;border:1px solid silver;border-radius:5px;color:white;margin-left:10px;width:80px;height:30px;">Submit</button>
                </div>
                <div class="col-2" style="margin-left: 10%;">
                    <button wire:click="closeSec80C" class="custom-button cancel-button"  style="background:red;border:1px solid silver;border-radius:5px;color:white;margin-left:10px;width:80px;height:30px;">Cancel</button>
                </div>
                </div>
               
    </form>
   
    <!--[if BLOCK]><![endif]--><?php if($total): ?>
        <p>Total Value: <?php echo e($total); ?></p>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
           
       
    </div>
</div>
</div>
</div>
 
<div class="modal-backdrop fade show blurred-backdrop"></div>
 
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 
</div>
<div class="row" style="height:200px;margin-top:20px;width:300px;background:white;margin-left:30px;border:1px solid silver;border-radius:5px;font-size:12px">
<img src="https://completed.com/images/accurate.png" style="height:50px;width:80px;margin-top:40px;margin-left:90px">
         <p _ngcontent-whw-c467="" class="text-black" title="Sec 80C" style="margin-left:40px;font-size:12px">Other Chapter VI-A Deductions</p>
         <p style="margin-top:-20px;margin-left:40px">Total Value: <?php echo e($totaldeductions); ?>/1,50,000</p>
         <a class="declaration-link" style="margin-top: -30px; margin-left: 50px;" wire:click="addshowVIDeductions">Add to declaration</a>
         <!--[if BLOCK]><![endif]--><?php if($showVIDeductions): ?>
 
<div class="modal" tabindex="-1" role="dialog" style="display: block;">
 
    <div class="modal-dialog modal-dialog-centered" role="document">
 
        <div class="modal-content" style="width: 800px">
        <div class="modal-header" style="background-color: #D4D2D2; height: 60px; width: 800px">
        <h5 style="padding: 5px; color: #747576; font-size: 15px;" class="modal-title"><b>Other Chapter VI-A Deductions</b></h5>
        <button wire:click="closeshowVIDeductions" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color: black;">×</span>
        </button>
    </div>
    <div class="modal-body" style="max-height: auto;">
        <div class="container" style="height: 30px; border: 1px solid silver; border-radius: 7px;width:700px">
            <p>Total declared in (₹)</p>
           
        </div>
        <!-- Begin the form outside the .form-group div -->
        <form wire:submit.prevent="submitotherdeductions">
            <div class="form-group">
                <div class="column" style="display:flex">
                    <div class="row">
                        <label for="intrest_on_housing" style="font-size:12px;margin-left:10px">80EE  Interest on housing loan borrowed as on 24th oct 2023
</label>
<input type="text" wire:model="fieldsdeductions.intrest_on_housing" name="fieldsdeductions.intrest_on_housing" id="intrest_on_housing" class="form-control" placeholder="₹ Enter amount" style="width:200px; font-size:14px; margin-left:20px; ">
<span class="limit text-6 ng-star-inserted" style="font-size:10px;margin-left:20px">
        <span class="text-secondary text-5 text-regular">Max limit in <i class="icon-gt-rupee text-6 text-regular"></i>:</span>
        <span class="text-black" >₹ 50,000.00</span>
    </span>
 
<!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fieldsdeductions.intrest_on_housing'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="text-danger" style="font-size:10px"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div class="row">
                        <label for="intrest_on_loan" style="font-size:12px;margin-left:30px">80EEA  Interest on Housing loan borrowed as on 1st Apr 2023</label>
                        <input type="text" wire:model="fieldsdeductions.intrest_on_loan" name="fieldsdeductions.intrest_on_loan" id="intrest_on_housing" class="form-control" placeholder="₹ Enter amount" style="width:200px; font-size:14px; margin-left:40px; ">
                       
                        <span class="limit text-6 ng-star-inserted" style="font-size:10px;margin-left:30px">
        <span class="text-secondary text-5 text-regular">Max limit in <i class="icon-gt-rupee text-6 text-regular"></i>:</span>
        <span class="text-black" >₹ 50,000.00</span>
    </span>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fieldsdeductions.intrest_on_loan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="text-danger" style="font-size:10px;margin-left:20px"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
               
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="column" style="display:flex">
                    <div class="row">
                        <label for="contribution_to_pension_fund" style="font-size:12px;margin-left:10px">80CCD(1) Employee Contribution to NPS</label>
               
                        <input type="text" wire:model="fieldsdeductions.contribution_to_pension_fund" name="fieldsdeductions.contribution_to_pension_fund" id="contribution_to_pension_fund" class="form-control" placeholder="₹ Enter amount" style="width:200px; font-size:14px; margin-left:20px; ">
                       
                        <span class="limit text-6 ng-star-inserted" style="font-size:10px;margin-left:20px">
        <span class="text-secondary text-5 text-regular">Max limit in <i class="icon-gt-rupee text-6 text-regular"></i>:</span>
        <span class="text-black" >₹ 50,000.00</span>
    </span>                      
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fieldsdeductions.contribution_to_pension_fund'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="text-danger" style="font-size:10px"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div class="row">
                        <label for="deposit_in_nsc" style="margin-left: 80px;font-size:12px">80EEB Interest on Electric Vehicle borrowed as on 1st Apr 2023
</label>
 
<input type="text" wire:model="fieldsdeductions.deposit_in_nsc" name="fieldsdeductions.deposit_in_nsc" id="deposit_in_nsc" class="form-control" placeholder="₹ Enter amount" style="width:200px; font-size:14px; margin-left:110px; ">
                       
                        <span class="limit text-6 ng-star-inserted" style="font-size:10px;margin-left:120px">
        <span class="text-secondary text-5 text-regular">Max limit in <i class="icon-gt-rupee text-6 text-regular"></i>:</span>
        <span class="text-black" >₹ 50,000.00</span>
    </span>
<!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fieldsdeductions.deposit_in_nsc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="text-danger"  style="font-size:10px;margin-left:100px"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->  
                    </div>
                </div>
            </div>
            <div class="for
            m-group">
                <div class="column" style="display:flex">
                    <div class="row">
                        <label for="deposit_in_nss" style="font-size:12px">80CCD1(B) Contribution to NPS 2023</label>
                       
       
                   <input type="text" wire:model="fieldsdeductions.deposit_in_nss" name="fieldsdeductions.deposit_in_nss" id="deposit_in_nss" class="form-control" placeholder="₹ Enter amount" style="width:200px; font-size:14px; margin-left:20px; ">
                       
                        <span class="limit text-6 ng-star-inserted" style="font-size:10px;margin-left:40px">
        <span class="text-secondary text-5 text-regular">Max limit in <i class="icon-gt-rupee text-6 text-regular"></i>:</span>
        <span class="text-black" >₹ 50,000.00</span>
    </span>    
                   
                   <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fieldsdeductions.deposit_in_nss'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="text-danger"  style="font-size:10px"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div class="row">
                        <label for="interest_on_nsc_reinvested" style="margin-left: 100px;font-size:12px">80TTB Interest on Deposits in Savings Account, FDs for Senior Citizen</label>
             
                        <input type="text" wire:model="fieldsdeductions.interest_on_nsc_reinvested" name="fieldsdeductions.interest_on_nsc_reinvested" id="interest_on_nsc_reinvested" class="form-control" placeholder="₹ Enter amount" style="width:200px; font-size:14px; margin-left:140px; ">
                       
                        <span class="limit text-6 ng-star-inserted" style="font-size:10px;margin-left:130px">
        <span class="text-secondary text-5 text-regular">Max limit in <i class="icon-gt-rupee text-6 text-regular"></i>:</span>
        <span class="text-black" >₹ 50,000.00</span>
    </span>                    
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fieldsdeductions.interest_on_nsc_reinvested'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="text-danger"  style="font-size:10px;margin-left:110px"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                     
                     
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="column" style="display:flex">
                    <div class="row">
                        <label for="superannuation" style="font-size:12px">10(13) Superannuation Exemption</label>
             
                        <input type="text" wire:model="fieldsdeductions.superannuation" name="fieldsdeductions.superannuation" id="superannuation" class="form-control" placeholder="₹ Enter amount" style="width:200px; font-size:14px; margin-left:20px; ">
                       
                        <span class="limit text-6 ng-star-inserted" style="font-size:10px;margin-left:20px">
        <span class="text-secondary text-5 text-regular">Max limit in <i class="icon-gt-rupee text-6 text-regular"></i>:</span>
        <span class="text-black" >₹ 50,000.00</span>
    </span>  
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fieldsdeductions.superannuation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="text-danger"  style="font-size:10px"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div class="row">
                        <label for="donation" style="margin-left: 90px;font-size:12px">80G Donation - 100% Exemption</label>
                       
                        <input type="text" wire:model="fieldsdeductions.donation" name="fieldsdeductions.donation" id="donation" class="form-control" placeholder="₹ Enter amount" style="width:200px; font-size:14px; margin-left:110px; ">
                       
                        <span class="limit text-6 ng-star-inserted" style="font-size:10px;margin-left:110px">
        <span class="text-secondary text-5 text-regular">Max limit in <i class="icon-gt-rupee text-6 text-regular"></i>:</span>
        <span class="text-black" >₹ 50,000.00</span>
    </span>  
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fieldsdeductions.donation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="text-danger"  style="font-size:10px;margin-left:90px"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 20px;">
                <div class="col-1" style="margin-left: 30%;">
                    <button wire:click="submitotherdeductions" class="custom-button submit-button" style="background:green;border:1px solid silver;border-radius:5px;color:white;margin-left:-200px;width:80px;height:30px;">Submit</button>
                </div>
                <div class="col-2" style="margin-left: 10%;">
                    <button wire:click="closeshowVIDeductions" class="custom-button cancel-button" style="background:red;border:1px solid silver;border-radius:5px;color:white;margin-left:-190px;width:80px;height:30px">Cancel</button>
                </div>
                <!--[if BLOCK]><![endif]--><?php if($totaldeductions): ?>
        <p>Total Value: <?php echo e($totaldeductions); ?></p>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </form>
    </div>
</div>
</div>
</div>
 
<div class="modal-backdrop fade show blurred-backdrop"></div>
 
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<div class="row" style="height:200px;margin-top:20px;width:300px;background:white;margin-left:30px;border:1px solid silver;border-radius:5px;font-size:12px">
<img src="https://www.creditloan.com/media/final-definitive-guide-how-to-maximize-the-value-of-your-credit-cards-personal-loans-68.png" style="height:50px;width:80px;margin-top:40px;margin-left:70px">
         <p _ngcontent-whw-c467="" class="text-black" title="Sec 80C" style="margin-left:50px">Medical (Sec 80D)
 
</p>
<a class="declaration-link" style="margin-top: -40px; margin-left: 50px;" wire:click="addMedical">Add to declaration</a>
         <!--[if BLOCK]><![endif]--><?php if($showMedicalDialog): ?>
 
         <div class="modal" tabindex="-1" role="dialog" style="display: block;">
 
<div class="modal-dialog modal-dialog-centered" role="document">
 
    <div class="modal-content" style="width: 800px">
    <div class="modal-header" style="background-color:#D4D2D2; height: 60px; width: 800px">
    <h5 style="padding: 5px; color: #747576; font-size: 15px;" class="modal-title"><b>Medical (Sec 80D)</b></h5>
    <button wire:click="closeMedical" type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true" style="color: white;">×</span>
    </button>
</div>
<div class="modal-body" style="max-height: auto;overflow-y: auto;">
    <div class="container" style="height: 30px; border: 1px solid silver; border-radius: 7px;width:700px">
        <p>Total declared in (₹)</p>
     
    </div>
    <!-- Begin the form outside the .form-group div -->
    <form wire:submit.prevent="submit">
        <div class="form-group">
            <div class="column" style="display:flex">
         
                <div class="row" style="margin-top:20px">
                <div class="container" style="height:30px;background:#D9D9D9;width:780px;border:1px solid silver">
                80D Medical Bills - Senior Citizen (>60)
 
                  </div>
                    <label for="Medical" style="font-size:14px">declared amount</label>
     
                    <input type="text" wire:model="fieldsmedical.medical" name="fieldsmedical.medical" id="medical" class="form-control" placeholder="₹ Enter amount" style="width:200px; font-size:14px; margin-left:10px;">
 
<!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fields.health_checkup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="text-danger" style="font-size:10px"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->  
                   
                    <b style="font-size:10px;color:#C3C1C1">Max limit in  :₹50,000.00</b>
                </div>
               
            </div>
        </div>
        <div class="form-group">
        <div class="row" style="margin-top:20px">
                <div class="container" style="height:30px;background:#D9D9D9;width:780px;border:1px solid silver">
                Preventive Health Check-up
 
                  </div>
                    <label for="Health Checkup" style="font-size:14px">declared amount</label>
 
                    <input type="text" wire:model="fields.health_checkup" name="fields.health_checkup" id="health_checkup" class="form-control" placeholder="₹ Enter amount" style="width:200px; font-size:14px; margin-left:10px; ">
 
<!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fields.health_checkup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="text-danger" style="font-size:10px"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->  
                    <b style="font-size:10px;color:#C3C1C1">Max limit in  :₹50,000.00</b>
                </div>
               
            </div>
        </div>
        <div class="form-group">
            <div class="column" style="display:flex">
            <div class="row" style="margin-top:-10px">
                <div class="container" style="height:30px;background:#D9D9D9;width:780px;border:1px solid silver">
                80D Preventive Health Checkup - Dependant Parents
 
                  </div>
                    <label for="Dependant Parents" style="font-size:14px;margin-left:10px">declared amount</label>
 
                    <input type="text" wire:model="fieldsmedical.Dependant Parents" name="fieldsmedical.Dependant Parents" id="Dependant Parents" class="form-control" placeholder="₹ Enter amount" style="width:200px; font-size:14px; margin-left:20px; ">
 
<!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fields.Dependant Parents'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="text-danger" style="font-size:10px"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->  
                    <b style="font-size:10px;color:#C3C1C1;margin-left:10px">Max limit in  :₹50,000.00</b>
                </div>
               
            </div>
        </div>
       
        <div class="row" style="margin-top: -10px;">
            <div class="col-1" style="margin-left: 30%;">
                <button type="button" wire:click="submitmedical" class="custom-button submit-button" style="background:green;border:1px solid silver;border-radius:5px;color:white;margin-left:-100px;width:80px;">Submit</button>
            </div>
            <div class="col-2" style="margin-left: 10%;">
                <button wire:click="closeMedical" class="custom-button cancel-button" style="background:red;border:1px solid silver;border-radius:5px;color:white;margin-left:-70px;width:80px;">Cancel</button>
            </div>
        </div>
    </form>
</div>
</div>
</div>
</div>
 
<div class="modal-backdrop fade show blurred-backdrop"></div>
 
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 
         
</div>
       
 
        </div>
        <div _ngcontent-whw-c468="" class="itd-plan-details-content ng-star-inserted">
        <div _ngcontent-whw-c468="" class="row">
          <!-- Card 1 -->
         <div class="row" style="height:200px;margin-top:20px;width:300px;background:white;margin-left:10px;border:1px solid silver;border-radius:5px;font-size:12px">
         <img src="https://d2zcpk7yfyf2dq.cloudfront.net/milaap/image/upload/v1493815112/production/entity_details/milaap_page/1892/Fund_1493815111.png" style="height:40px;width:80px;margin-top:40px;margin-left:90px">
         <p _ngcontent-whw-c467="" class="text-black" title="Sec 80C" style="margin-left:20px">Income/loss from House Property</p>
         <a class="declaration-link" style="margin-top: -40px; margin-left: 50px;" wire:click="addIncome">Add to declaration</a>
 
<!--[if BLOCK]><![endif]--><?php if($showIncomeDialog): ?>
 
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
 
            <div class="modal-dialog modal-dialog-centered" role="document" >
 
                <div class="modal-content" style="width: 800px">
                <div class="modal-header" style="background-color:#D4D2D2 ;height: 60px; width: 800px">
                <h5 style="padding:5px; color:black; font-size: 15px;" class="modal-title"><b>Income/loss from House Property</b></h5>
                <button wire:click="closeIncome" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: black;">×</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: auto;overflow-y:auto">
                <div class="container" style="height: 60px; border: 1px solid silver; border-radius: 7px;width:700px;display:flex">
                <div class="row"style="display: flex;width:200px;margin-top:10px">
                    <p style="width:300px;font-size:14px;">Total declared in (₹)</p>
                    </div>
                    <div class="row" style="display: flex;margin-left:40px;font-size:10px; ">
                        <p style="margin-left: 26px;">a. Interest on Housing Loan (Self- Occupied) </p>
                        <p style="margin-left: 26px;margin-top:-20px;">b. Total Income/Loss from Let-out Property  </p>
                        <p style="margin-left: 26px;margin-top:-20px;">If (a + b) is less than -200000 then -200000 will be exempted, else (c) will be exempted </p>
                    </div>
                   
                </div>
                <!-- Begin the form outside the .form-group div -->
                <form wire:submit.prevent="submit">
                <div class="form-group">
                        <div class="column" style="display:flex">
                     
                            <div class="row" style="margin-top:20px">
                            <div class="container" style="height:30px;background:#D9D9D9;width:780px;border:1px solid silver">
                            a. Income from Self-Occupied Property
 
                              </div>
                                <label for="income" style="font-size:14px">Interest on Housing Loan (Self Occupied) in ₹</label>
                                <input type="text" wire:model="fields.income" id="income" class="form-control" placeholder="Enter amount" style="width:300px;font-size:14px;margin-left:10px">
                                <b style="font-size:10px;color:#C3C1C1">Eligible Amount in :₹2,00,000.00</b>
                                <div class="column" style="display:flex">
                                <div>
                                <label for="Lender’s" style="font-size:14px;margin-left:10px">Lender’s Name</label>
                                <input type="text" wire:model="fields.Lender’s" id="Lender’s" class="form-control" placeholder="Enter amount" style="width:300px;font-size:14px;margin-left:10px">
                               </div>
                               <div>
                                <label for="Lender’s plan" style="font-size:14px">Lender’s PAN</label>
                                <input type="text" wire:model="fields.Lender’s plan" id="Lender’s plan" class="form-control" placeholder="e.g.AXPRA123" style="width:300px;font-size:14px;margin-left:10px">
</div>
                              </div>
                            </div>
                           
                        </div>
                    </div>
                    <div class="form-group">
                    <div class="row" style="margin-top:10px">
                            <div class="container" style="height:30px;background:#D9D9D9;width:780px;border:1px solid silver">
                            b. Income from Let-out Property
 
                              </div>
                                <label for="annual" style="font-size:14px">1. Annual Letable Value/Rent Received or Receivable</label>
                                <input type="text" wire:model="annual" id="annual" class="form-control" placeholder="Enter amount" style="width:300px;font-size:14px;margin-left:10px">
                                <b style="font-size:10px;color:#C3C1C1">Max limit in  :₹50,000.00</b>
                            </div>
                            </div>
                                <!-- <label for="5_years_fixed_deposit" style="font-size:14px">1. Annual Letable Value/Rent Received or Receivable</label>
                                <input type="text" wire:model="fields.5_years_fixed_deposit" id="5_years_fixed_deposit" class="form-control" placeholder="Enter amount" style="width:300px;font-size:14px;margin-left:10px">
                                <b style="font-size:10px;color:#C3C1C1">Max limit in  :₹50,000.00</b> -->
                            </div>
                           
                        </div>
                    </div>
           
                   
                    <div class="row" style="margin-top: -90px;">
                        <div class="col-1" style="margin-left: 30%;" >
                            <button type="submit" class="custom-button submit-button" style="background:green;border:1px solid silver;border-radius:5px;color:white;width:80px;margin-top:10px">Submit</button>
                        </div>
                        <div class="col-2" >
                            <button wire:click="closeIncome" class="custom-button cancel-button" style="background:red;border:1px solid silver;border-radius:5px;color:white;width:80px;margin-top:10px">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
     
   
</div>
 
<div class="modal-backdrop fade show blurred-backdrop"></div>
 
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 
 
         
 
</div>
<div class="row" style="height:200px;margin-top:20px;width:300px;background:white;margin-left:30px;border:1px solid silver;border-radius:5px;font-size:12px">
<img src="https://completed.com/images/accurate.png" style="height:50px;width:80px;margin-top:40px;margin-left:90px">
         <p _ngcontent-whw-c467="" class="text-black" title="Sec 80C" style="margin-left:40px">Other Income
 
</p>
<a class="declaration-link" style="margin-top: -40px; margin-left: 50px;" wire:click="addshowOtherIncome">Add to declaration</a>
 
<!--[if BLOCK]><![endif]--><?php if($showOtherIncome): ?>
 
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
 
            <div class="modal-dialog modal-dialog-centered" role="document" >
 
                <div class="modal-content" style="width: 800px">
                <div class="modal-header" style="background-color: #D4D2D2; height: 60px; width: 800px">
                <h5 style="padding: 5px;  font-size: 15px;" class="modal-title"><b>Other Income</b></h5>
                <button wire:click="closeshowOtherIncome" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: black;">×</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: auto;">
                <div class="container" style="height: 60px; border: 1px solid silver; border-radius: 7px;width:700px;display:flex">
                <div class="row"style="display: flex;width:200px;margin-top:10px">
                    <p style="width:300px;font-size:14px;">Total declared in (₹)</p>
                    </div>
                   
                   
                </div>
                <!-- Begin the form outside the .form-group div -->
                <form wire:submit.prevent="submit">
                <div class="form-group">
                        <div class="column" style="display:flex">
                     
                            <div class="row" style="margin-top:20px">
                            <div class="container" style="height:30px;background:#D9D9D9;width:780px;border:1px solid silver">
                            Other Income 1
                              </div>
                              <div class="column" style="display:flex">
                              <div class="row">
                              <label for="income" style="font-size:14px">Particulars</label>
                                <input type="text" wire:model="fields.income" id="income" class="form-control" placeholder="Enter income type" style="width:300px;font-size:14px;margin-left:10px">
                               
                              </div>
                             
                               <div class="row">
                               <label for="Lender’s" style="font-size:14px;margin-left:10px">Declared Amount</label>
                                <input type="text" wire:model="fields.Lender’s" id="Lender’s" class="form-control" placeholder="Enter amount " style="width:300px;font-size:14px;margin-left:10px">
                               </div>
                               </div>
                                  </div>
                              </div>
                              <div class="container" style="height:30px;background:#D9D9D9;width:780px;border:1px solid silver;margin-top:5px;margin-left:-10px">
                            Other Income 2
                              </div>
                              <div class="column" style="display:flex">
                              <div class="row">
                              <label for="income" style="font-size:14px">Particulars</label>
                                <input type="text" wire:model="fields.income" id="income" class="form-control" placeholder="Enter Income Type" style="width:300px;font-size:14px;margin-left:10px">
                               
                              </div>
                             
                               <div class="row">
                               <label for="Lender’s" style="font-size:14px;margin-left:10px">Declared Amount</label>
                                <input type="text" wire:model="fields.Lender’s" id="Lender’s" class="form-control" placeholder="Enter amount" style="width:300px;font-size:14px;margin-left:10px">
                               </div>
                               </div>
                               
                               
               
                              </div>
                            </div>
                            <div class="row" style="margin-top: -10px;">
                        <div class="col-1" >
                            <button type="submit" class="custom-button submit-button" style="background:green;border:1px solid silver;border-radius:5px;color:white;margin-left:10px;width:80px;">Submit</button>
                        </div>
                        <div class="col-2" style="margin-left: 10%;">
                            <button wire:click="closeshowOtherIncome" class="custom-button cancel-button" style="background:red;border:1px solid silver;border-radius:5px;color:white;margin-left:10px">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
     
   
</div>
</div>
                   
             
                   
                   
 
<div class="modal-backdrop fade show blurred-backdrop"></div>
 
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<div class="row" style="height:200px;margin-top:20px;width:300px;background:white;margin-left:30px;border:1px solid silver;border-radius:5px;font-size:12px">
<img src="https://www.creditloan.com/media/final-definitive-guide-how-to-maximize-the-value-of-your-credit-cards-personal-loans-68.png" style="height:50px;width:80px;margin-top:40px;margin-left:70px">
         <p _ngcontent-whw-c467="" class="text-black" title="Sec 80C" style="margin-left:50px">Salary Allowance
 
</p>
<a class="declaration-link" style="margin-top: -40px; margin-left: 50px;" wire:click="addSalayAllowance">Add to declaration</a>
 
<!--[if BLOCK]><![endif]--><?php if($showSalayAllowance): ?>
 
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
 
            <div class="modal-dialog modal-dialog-centered" role="document" >
 
                <div class="modal-content" style="width: 800px">
                <div class="modal-header" style="background-color: #D4D2D2; height: 60px; width: 800px">
                <h5 style="padding: 5px;  font-size: 15px;" class="modal-title"><b>Salary Allowance</b></h5>
                <button wire:click="closeSalayAllowance" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" >×</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: auto;">
                <div class="container" style="height: 60px; border: 1px solid silver; border-radius: 7px;width:700px;display:flex">
                <div class="row"style="display: flex;width:200px;margin-top:10px">
                    <p style="width:300px;font-size:14px;">Total declared in (₹)</p>
                    </div>
                   
                   
                </div>
                <!-- Begin the form outside the .form-group div -->
                <form wire:submit.prevent="submit">
                <div class="form-group">
                        <div class="column" style="display:flex">
                     
                            <div class="row" style="margin-top:20px">
                            <div class="container" style="height:30px;background:#D9D9D9;width:780px;border:1px solid silver">
                            Other Income 1
                              </div>
                              <div class="column" style="display:flex">
                              <div class="row">
                              <label for="income" style="font-size:14px">Particulars</label>
                                <input type="text" wire:model="fields.income" id="income" class="form-control" placeholder="Enter income type" style="width:300px;font-size:14px;margin-left:10px">
                               
                              </div>
                             
                               <div class="row">
                               <label for="Lender’s" style="font-size:14px;margin-left:10px">Declared Amount</label>
                                <input type="text" wire:model="fields.Lender’s" id="Lender’s" class="form-control" placeholder="Enter amount " style="width:300px;font-size:14px;margin-left:10px">
                               </div>
                               </div>
                                  </div>
                              </div>
                           
                              <div class="column" style="display:flex">
                              <div class="row">
                              <label for="income" style="font-size:14px">LTA</label>
                                <input type="text" wire:model="fields.income" id="income" class="form-control" placeholder="Enter Income Type" style="width:300px;font-size:14px;margin-left:10px">
                               <p>Max limit in  ₹:99,99,99,999.00</p>
                              </div>
                             
                             
                               </div>
                               
                               
               
                              </div>
                            </div>
                            <div class="row" style="margin-top: -10px;">
                        <div class="col-1">
                            <button type="submit" class="custom-button submit-button" style="background:green;border:1px solid silver;border-radius:5px;color:white;margin-left:10px;width:80px">Submit</button>
                        </div>
                        <div class="col-2" style= "margin-left:10%">
                            <button wire:click="closeSalayAllowance" class="custom-button cancel-button" style="background:red;border:1px solid silver;border-radius:5px;color:white;margin-left:120x;width:80px">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
     
   
</div>
</div>
                   
             
                   
                   
 
<div class="modal-backdrop fade show blurred-backdrop"></div>
 
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
          <!-- Card 2 -->
       
 
          <!-- Add more cards here as needed -->
 
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
     
      <!---->
      <!---->
      <!---->
    </div>
  </itd-plan-details>
  <!---->
</div>
<div class="container" style="height:60px;width:105%;background:white;margin-top:30px;margin-left:-120px">

    <button style="border-radius:5px;border:1px solid #80daeb;height:30px;width:160px;margin-left:800px;margin-top:15px;font-size:12px"><a href="/itstatement">View IT Calculation</a> </button>

</div>
<script>
        // Get the modal and buttons
        var modal = document.getElementById("myModal");
        var addToDeclarationLink = document.getElementById("addToDeclarationLink");
        var closeModalButton = document.getElementById("closeModal");
 
        // Open the modal when the link is clicked
        addToDeclarationLink.addEventListener("click", function () {
            modal.style.display = "block";
        });
 
        // Close the modal when the "Close" button is clicked
        closeModalButton.addEventListener("click", function () {
            modal.style.display = "none";
        });
 
        // Close the modal when clicking outside of it
        window.addEventListener("click", function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });
        </script>
 <?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/plan-a.blade.php ENDPATH**/ ?>