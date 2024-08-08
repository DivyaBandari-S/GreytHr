<div>
    <!--[if BLOCK]><![endif]--><?php if(session()->has('emp_error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('emp_error')); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <div class="row  p-0" style="margin:0 10px;">
        <div class="card" style="width: auto; margin-left: 18%;padding:5px;">
            <ul class="nav custom-nav-tabss"> <!-- Apply the custom class to the nav -->
                <li class="nav-item-pi flex-grow-1">
                    <a class="custom-nav-link-pi active" data-section="personalDetails" onclick="toggleDetails('personalDetails', this)">Personal</a>
                </li>
                <li class="nav-item-pi flex-grow-1">
                    <a class="custom-nav-link-pi" data-section="accountDetails" onclick="toggleDetails('accountDetails', this)">Accounts & Statements</a>
                </li>
                <li class="nav-item-pi flex-grow-1">
                    <a class="custom-nav-link-pi" data-section="familyDetails" onclick="toggleDetails('familyDetails', this)">Family</a>
                </li>
                <li class="nav-item-pi flex-grow-1">
                    <a class="custom-nav-link-pi" data-section="employeeJobDetails" onclick="toggleDetails('employeeJobDetails', this)">Employment & Job</a>
                </li>
                <li class="nav-item-pi flex-grow-1">
                    <a class="custom-nav-link-pi" data-section="assetsDetails" onclick="toggleDetails('assetsDetails', this)">Assets</a>
                </li>
            </ul>
        </div>
    <div>

   </div>
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $employeeDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
        <div class="row p-0 " id="personalDetails" style=" margin:20px auto;">
            <div class="col">
                <div class="row" style="border-radius: 5px; height: 270px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px;color:#778899;font-weight:500;font-size:13px;">PROFILE</div>
                       <div class="col" >
                            <!--[if BLOCK]><![endif]--><?php if($employee->image): ?>
                                <div class="employee-profile-image-container" style="margin-left: 15px;">
                                    <img height="80" src="<?php echo e(asset('storage/' . $employee->image)); ?>" class="employee-profile-image">
                                </div>
                            <?php else: ?>
                                <div class="employee-profile-image-container" style="margin-left: 15px;">
                                    <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" class="employee-profile-image-placeholder" height="80" alt="Default Image">
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <!--[if BLOCK]><![endif]--><?php if($errors->has('image')): ?>
                            <span class="text-danger"><?php echo e($errors->first('image')); ?></span><br>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <div class="d-flex align-items-start " style="margin-left: 15px;">
                                <button class="btn btn-primary btn-sm p-0" style="font-size: 10px; height: 20px;width:55px; background-color: rgb(2,17,79)" wire:click="updateProfile" wire:loading.attr="disabled" wire:target="updateProfile">
                                    <span style="font-size: 10px;" wire:loading wire:target="image">Uploading...</span>
                                    <span style="font-size: 10px;" wire:loading.remove>Update</span>
                                </button> <br>
                                <input type="file" id="imageInput" wire:model="image" class="form-control-small" style="font-size:10px;margin-left:5px;">
                            </div>
                            <!--[if BLOCK]><![endif]--><?php if($showSuccessMessage): ?>
                                <span class="alert" style="font-size: 10px;color:green;cursor:pointer;" wire:click="closeMessage">
                                    Profile updated successfully!
                                </span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <div style="font-size: 12px; margin-top: 10px; color: #778899; margin-left: 15px">
                            Location
                        </div>
                        <div style="margin-left: 15px; font-size: 12px;color:#000;">
                            <?php echo e($employee->job_location); ?>

                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                            Name
                        </div>
                        <div style="margin-left: 15px; font-size: 12px;color:#000;">
                            <?php echo e(ucwords(strtolower($employee->first_name))); ?> <?php echo e(ucwords(strtolower($employee->last_name))); ?>

                        </div>
                        <div style="font-size: 11px; margin-top: 30px; color: #778899; margin-left: 15px;">
                            Employee ID
                        </div>
                        <div style="margin-left: 15px; font-size: 12px;color:#000;">
                            <?php echo e($employee->emp_id); ?>

                        </div>
                        <div style="font-size: 11px; margin-top: 30px; color: #778899; margin-left: 15px;">
                            Primary Contact No
                        </div>
                        <div style="margin-left: 15px; font-size: 12px;color:#000;">
                            <?php echo e($employee->mobile_number); ?>

                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px;  color: #778899; margin-left: 15px">
                            Company E-mail
                        </div>
                        <div style="margin-left: 15px; font-size: 12px;color:#000;">
                            <?php echo e($employee->company_email); ?>

                        </div>
                    </div>
                </div>

                <div class="row" style="border-radius: 5px; height: 270px; width: 100%; background-color: white;margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px;margin-bottom:20px;color:#778899;font-weight:500;font-size:13px;">PERSONAL</div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                            Blood Group
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($employee->blood_group); ?>

                        </div>
                        <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px;">
                            Marital Status
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($employee->marital_status); ?>

                        </div>
                        <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                            Place Of Birth
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($employee->city); ?>

                        </div>
                        <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                            Religion
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if($employee->religion): ?>
                        <div style="margin-left: 15px; font-size: 12px;margin-bottom:10px;">
                            <?php echo e($employee->religion); ?>

                        </div>
                        <?php else: ?>
                        <div style="margin-left: 15px; font-size: 12px;margin-bottom:10px;">
                           -
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            Date Of Birth
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e(\Carbon\Carbon::parse($employee->date_of_birth)->format('d-M-Y')); ?>

                        </div>
                        <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                            Residential Status
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($employee->job_location); ?>

                        </div>
                        <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                            Physically Challenged
                        </div>
                        <div style="margin-left: 15px; font-size: 12px;">
                            <?php echo e($employee->physically_challenge); ?>

                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            Nationality
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($employee->nationality); ?>

                        </div>
                        <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px">
                            Spouse
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if($employee->spouse): ?>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($employee->spouse); ?>

                        </div>
                        <?php else: ?>
                        <div style="margin-left: 15px; font-size: 12px;margin-bottom:10px;">
                            -
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                            Father Name
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if($employee->father_name): ?>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($employee->father_name); ?>

                        </div>
                        <?php else: ?>
                        <div style="margin-left: 15px; font-size: 12px;margin-bottom:10px;">
                            -
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                            International Employee
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($employee->inter_emp); ?>

                        </div>
                    </div>
                </div>

                <div class="row" style="border-radius: 5px; height: 200px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px;color:#778899;font-weight:500;font-size:13px;">ADDRESS</div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            Address
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if(!$employee->address): ?>
                        <div style="margin-left: 15px; font-size: 11px;color:#000;">
                            <?php echo e($employee->address); ?>

                        </div>
                        <?php else: ?>
                        <div style="margin-left: 15px; font-size: 12px;color:#000;">
                            -
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <div style="margin-top: 20px; font-size: 11px;color:#000; color: #778899; margin-left: 15px">
                            Name
                        </div>
                        <div style="margin-left: 15px; font-size: 12px;color:#000;">
                            <?php echo e(ucwords(strtolower($employee->first_name))); ?> <?php echo e(ucwords(strtolower($employee->last_name))); ?>

                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                            Mobile
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($employee->mobile_number); ?>

                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                            Email
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if($employee->email): ?>
                        <div style="margin-left: 15px; font-size: 12px;color:#000;">
                            <?php echo e($employee->email); ?>

                        </div>
                        <?php else: ?>
                        <div style="margin-left: 15px; font-size: 12px;color:#000;">
                          -
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <div class="row" style="border-radius: 5px; height: 100px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px;color:#778899;font-weight:500;font-size:13px;">EDUCATION</div>
                    <div class="col" style="margin-left: 15px; font-size: 12px">
                        <div style="font-size: 12px; color: #778899; margin-left: 15px">
                            No Data Found
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

        
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $empBankDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bankDetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="row" style="margin:20px auto;border-radius: 5px;display: none;" id="accountDetails">
            <div class="col">
                <div class="row" style="border-radius: 5px; height: 150px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px;color:#778899;font-size:12px;font-weight:500;">BANK ACCOUNT</div>
                    <div class="col" style="margin-top: 5px;">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            Bank Name
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($bankDetails->bank_name); ?>

                        </div>
                        <div style="margin-top:10px;font-size: 11px; color: #778899; margin-left: 15px">
                            IFSC Code
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($bankDetails->ifsc_code); ?>

                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                            Bank Account Number
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($bankDetails->account_number); ?>

                        </div>
                        <div style="margin-top:10px;font-size: 11px; color: #778899; margin-left: 15px">
                            Bank Address
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($bankDetails->bank_address); ?>

                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            Bank Branch
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($bankDetails->bank_branch); ?>

                        </div>
                    </div>
                </div>

                <div class="row" style="border-radius: 5px; height: 100px; width: 100%; background-color: white;margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px;font-size:12px;font-weight:500;color:#778899;">PF AMOUNT</div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            PF Number
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($employee->pf_no); ?>

                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            UAN
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($employee->pan_no); ?>

                        </div>
                    </div>
                </div>

                <div class="row" style="border-radius: 5px; height: 100px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px;font-size:12px;font-weight:500;color:#778899;">OTHERS IDS</div>
                    <div class="col">
                        <div style="margin-left: 15px; font-size: 12px">
                            ___
                        </div>
                    </div>
                    <div class="col">
                        <div style="color: red; margin-left: 15px; font-size: 12px">
                            Unverified
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        
        <!--[if BLOCK]><![endif]--><?php if($parentDetails->isEmpty()): ?>
        <div class="row" style="margin:20px auto;border-radius: 5px;display: none;" id="familyDetails">
            <hr style="border-top: 1px solid #ccc;">
            <div style="text-align: center;">No parent details available.Hr will add the details.</div>
        </div>
        <?php else: ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $parentDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="row" style="margin:20px auto;border-radius: 5px;display: none;" id="familyDetails">
                <div class="col">
                    <div class="row" style="border-radius: 5px; height: 200px; width: 100%; background-color: white; margin-bottom: 20px;">
                        <div style="margin-top: 2%;margin-left:17px;font-size:12px;font-weight:500;">FATHER DETAILS</div>
                        <div class="col" style="margin-left: 15px;">
                            <img style="border-radius: 5px;" height="150" width="150" src="<?php echo e($details->father_image); ?>" alt="">
                        </div>
                        <div class="col">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Father Name
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                <?php echo e(ucwords(strtolower($details->father_first_name))); ?> <?php echo e(ucwords(strtolower($details->father_last_name))); ?>

                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Address
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;width:250px">
                                <?php echo e($details->father_address); ?>,<?php echo e($details->father_city); ?>,<?php echo e($details->father_state); ?>,<?php echo e($details->father_country); ?>

                            </div>
                        </div>
                        <div class="col">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Date of Birth
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                <?php echo e(\Carbon\Carbon::parse($details->father_dob)->format('d-M-Y')); ?>

                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Nationality
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                <?php echo e($details->father_nationality); ?>

                            </div>
                        </div>
                        <div class="col">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Blood Group
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                <?php echo e($details->father_blood_group); ?>

                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Occupation
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                <?php echo e($details->father_occupation); ?>

                            </div>
                        </div>
                        <div class="col">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Religion
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                <?php echo e($details->father_religion); ?>

                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Father Email
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                <?php echo e($details->father_email); ?>

                            </div>
                        </div>
                    </div>



                    <div class="row" style="border-radius: 5px; height: 200px; width: 100%; background-color: white; margin-bottom: 20px;">
                        <div style="margin-top: 2%;margin-left:17px;font-size:12px;font-weight:500;">MOTHER DETAILS</div>
                        <div class="col" style="margin-left: 15px;">
                            <img style="border-radius: 5px;" height="150" width="150" src="<?php echo e($details->mother_image); ?>" alt="">
                        </div>
                        <div class="col">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Mother Name
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                <?php echo e(ucwords(strtolower($details->mother_first_name))); ?> <?php echo e(ucwords(strtolower($details->mother_last_name))); ?>

                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Address
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;width:250px">
                                <?php echo e($details->mother_address); ?>,<?php echo e($details->mother_city); ?>,<?php echo e($details->mother_state); ?>,<?php echo e($details->mother_country); ?>

                            </div>
                        </div>
                        <div class="col">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Date of Birth
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                <?php echo e(\Carbon\Carbon::parse($details->mother_dob)->format('d-M-Y')); ?>

                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Nationality
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                <?php echo e($details->mother_nationality); ?>

                            </div>
                        </div>
                        <div class="col">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Blood Group
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                <?php echo e($details->mother_blood_group); ?>

                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Occupation
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                <?php echo e($details->mother_occupation); ?>

                            </div>
                        </div>
                        <div class="col">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Religion
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                <?php echo e($details->mother_religion); ?>

                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Mother Email
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                <?php echo e($details->mother_email); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $employeeDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
        <div class="row" style="margin:20px auto;border-radius: 5px;display: none;" id="employeeJobDetails">
            <div class="col">
                <div class="row" style="border-radius: 5px; height: 250px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div class="row mt-2">
                        <div class="col">
                            <div style="margin-top: 2%;margin-left:15px;font-size:12px;font-weight:500;color:#778899;">CURRENT POSITION </div>
                        </div>
                        <div class="col">
                            <div style="margin-top: 2%; font-size: 11px; color: blue; margin-left: 25px">
                                Resign
                            </div>
                        </div>
                        <div class="col">
                            <div style="margin-top: 2%; font-size: 12px; color: indigo; margin-right: 3px">
                                <button style="background-color: blue; color: white; border-radius: 5px">View TimeLine</button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div style=" font-size: 11px; color: #778899; margin-left: 15px">
                            Reporting To
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($employee->report_to); ?>

                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            Department
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($employee->department); ?>

                        </div>
                        <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px">
                            Subdepartment
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($employee->Subdepartment); ?>

                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            Designation
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($employee->job_title); ?>

                        </div>
                        <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px">
                            Location
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($employee->job_location); ?>

                        </div>
                        <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px">
                            Date of Join
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e(\Carbon\Carbon::parse($employee->hire_date)->format('d-M-Y')); ?>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $employeeDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="row" style="margin:20px auto;border-radius: 5px;display: none;" id="assetsDetails">
            <div class="col">
                <div class="row" style="border-radius: 5px; height: 200px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px;font-size:13px;font-weight:500;color:#778899;">ACESS CARD DETAILS</div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            Card No
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            <?php echo e($employee->adhar_no); ?>

                        </div>
                        <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px">
                            PREVIOUS
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            No Data Found
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            Validity
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            ____
                        </div>
                    </div>
                </div>

                <div class="row" style="border-radius: 5px; height: 100px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px;color:#778899;font-size:13px;font-weight:500;">ASSETS</div>
                    <div class="col">
                        <div style="font-size: 12px; color: black; margin-left: 15px">
                            No Data Found
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
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
    function toggleDetails(sectionId, clickedLink) {
        const tabs = ['personalDetails', 'accountDetails', 'familyDetails', 'employeeJobDetails', 'assetsDetails'];

        const links = document.querySelectorAll('.custom-nav-link-pi');
        links.forEach(link => link.classList.remove('active'));

        clickedLink.classList.add('active');

        tabs.forEach(tab => {
            const tabElement = document.getElementById(tab);
            if(tabElement){
                if (tab === sectionId) {
                    tabElement.style.display = 'block';
                } else {
                    tabElement.style.display = 'none';
                }
            }
        });
    }

    document.getElementById('personalDetails').style.display = 'block';
</script><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/profile-info.blade.php ENDPATH**/ ?>