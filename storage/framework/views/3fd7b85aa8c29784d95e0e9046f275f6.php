<div>
<div style="overflow-x:hidden">

    <body>
        <div class="row ">
            <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('message')); ?>

                <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Close" style=" font-size: 0.75rem;padding: 0.25rem 0.5rem;margin-top:6px"></button>
            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php if(session()->has('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.75rem; padding: 0.25rem 0.5rem; margin-top: 5px;"></button>
            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <div class="d-flex border-0  align-items-center justify-content-center" style="height: 100px;">
                
            <div class="nav-buttons d-flex justify-content-center">
            <ul class="nav custom-nav-tabs border">
                <li class="custom-item m-0 p-0 flex-grow-1">
                    <a href="#" wire:click="$set('activeTab', 'active')" style="border-top-left-radius:5px;border-bottom-left-radius:5px;" class="custom-nav-link <?php if($activeTab === 'active'): ?> active <?php else: ?> btn-light <?php endif; ?>" >Active</a>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1" style="border-left:1px solid #ccc;border-right:1px solid #ccc;">
                    <a href="#" style="border-radius:none;"  wire:click="$set('activeTab', 'pending')" class="custom-nav-link <?php if($activeTab === 'pending'): ?> active <?php else: ?> btn-light <?php endif; ?>">Pending</a>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1">
                    <a href="#" wire:click="$set('activeTab', 'closed')" style="border-top-right-radius:5px;border-bottom-right-radius:5px;" class="custom-nav-link  <?php if($activeTab === 'closed'): ?> active <?php else: ?> btn-light <?php endif; ?>" >Closed</a>
                </li>
            </ul>
        </div>

</div>







        </div>
        <div class="d-flex flex-row justify-content-end mt-2">




            <div class="mx-2 ">
                <button onclick="location.href='/catalog'" style="font-size:12px;background-color:rgb(2, 17, 79);color:white;border-radius:5px;padding:4px 10px;"> IT Request  </button>
            </div>

            <div class="mx-2 ">
                <button wire:click="openFinance" style="font-size:12px;background-color:rgb(2, 17, 79);color:white;border-radius:5px;padding:4px 10px;"> Finance Request </button>
            </div>
            <div class="mx-2 ">
                <button wire:click="open" style="font-size:12px;background-color:rgb(2, 17, 79);color:white;border-radius:5px;padding:4px 10px;"> HR Request </button>
            </div>

            <div>

            </div>
        </div>

        <!--[if BLOCK]><![endif]--><?php if($showDialog): ?>
        <div class="modal" tabindex="-1" role="dialog" style="display: block;overflow-y:auto;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header align-items-center" style="background-color: rgb(2, 17, 79); height: 50px">
                        <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b>HR Request</b></h5>

                        </button>
                    </div>
                    <div class="modal-body">
                    <label for="category" style="color:#778899;font-weight:500;font-size:12px;">Category <span style="color:red">*</span></label>
<div class="input" type="" class="form-control placeholder-small">
    <div style="position: relative;">
        <select wire:model.lazy="category" id="category" style="font-size: 12px;" class="form-control placeholder-small">
            <option style="color: #778899; " value="">Select Category</option>
            <optgroup label="HR">
            <option value="Employee Information">Employee Information</option>
            <option value="Hardware Maintenance">Hardware Maintenance</option>
            <option value="Incident Report">Incident Report</option>
            <option value="Privilege Access Request">Privilege Access Request</option>
            <option value="Security Access Request">Security Access Request</option>
            <option value="Technical Support">Technical Support</option>
            <!-- Add more HR-related options as needed -->
        </optgroup>
        </select>
        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        <div class="dropdown-toggle-icon" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%);">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                <path d="M14.146 5.146a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 1 1 .708-.708L8 10.293l5.146-5.147a.5.5 0 0 1 .708 0z"/>
            </svg>
        </div>




                                </div>
                            </div>

                            <div class="form-group mt-2">
    <label for="subject" style="color: #778899; font-weight: 500; font-size: 12px;">Subject <span style="color: red;">*</span></label>
    <input type="text" wire:model.lazy="subject" id="subject" class="form-control placeholder-small" placeholder="Enter subject" style="font-family: Montserrat, sans-serif;">
    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
</div>

<div class="form-group mt-2">
    <label for="description" style="color: #778899; font-weight: 500; font-size: 12px;">Description <span style="color: red;">*</span></label>
    <textarea wire:model.lazy="description" id="description" class="form-control" placeholder="Enter description" rows="4" style="font-family: Montserrat, sans-serif;"></textarea>

    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
</div>

<div class="row mt-2">
                            <div class="col">
                                <label for="fileInput" style="color:#778899;font-weight:500;font-size:12px;cursor:pointer;">
                                    <i class="fa fa-paperclip"></i> Attach Image
                                </label>
                            </div>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['file_path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <div>
                            <input wire:model="image" type="file" accept="image/*" style="font-size: 12px;">

                        </div>
                        <div class="form-group mt-2">
    <label for="priority" style="color:#778899;font-weight:500;font-size:12px;margin-top:10px;">Priority<span style="color:red">*</span></label>
    <div class="input" class="form-control placeholder-small">
        <div style="position: relative;">
            <select name="priority" id="priority" wire:model.lazy="priority" style="font-size: 12px; " class="form-control placeholder-small">
                <option style="color: gray;" value="">Select Priority</option>
                <option value="High">High</option>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
            </select>
            <div class="dropdown-toggle-icon" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                    <path d="M14.146 5.146a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 1 1 .708-.708L8 10.293l5.146-5.147a.5.5 0 0 1 .708 0z"/>
                </svg>
            </div>
        </div>
    </div>
    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
</div>

<div class="row" style="margin-top: 10px;">
    <div class="col">
        <div class="row m-0 p-0">
            <div class="row m-0 p-0">
                <div style="margin: 0px; padding: 0;">
                    <div>
                        
                        <div style="font-size: 12px; color: #778899; margin-bottom: 10px; font-weight: 500;"   >
                            Selected CC recipients: <?php echo e(implode(', ', array_unique($selectedPeopleNames))); ?>

                        </div>
                    </div>
                    <button type="button" style="border-radius: 50%; color: #778899; border: 1px solid #778899;" class="add-button" wire:click="toggleRotation">
                        <div class="icon-container">
                            <i class="fas fa-plus" style="color: #778899;"></i>
                        </div>
                    </button>
                    <span style="color: #778899; font-size: 12px;">Add</span>
                </div>
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['cc_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
        
        <!--[if BLOCK]><![endif]--><?php if($isRotated): ?>
        <div style="border-radius: 5px; background-color: grey; padding: 8px; width: 330px; margin-top: 10px; height: 200px; overflow-y: auto;">
        <div class="input-group3" style="display: flex; align-items: center; width: 100%;">
    <input 
        wire:model="searchTerm" 
        style="font-size: 10px; cursor: pointer; border-radius: 5px 0 0 5px; width: 200px; height: 30px; padding: 5px;" 
        type="text" 
        class="form-control" 
        placeholder="Search for Emp.Name or ID" 
        aria-label="Search" 
        aria-describedby="basic-addon1"
    >
    <div class="input-group-append" style="display: flex; align-items: center;">
        <button 
            wire:click="filter" 
            style="height: 30px; border-radius: 0 5px 5px 0; background-color: rgb(2, 17, 79); color: #fff; border: none; padding: 0 10px;" 
            class="btn" 
            type="button"
        >
            <i style="text-align: center;" class="fa fa-search"></i>
        </button>

        <button 
            wire:click="closePeoples"  
            type="button" 
            class="close rounded px-1 py-0" 
            aria-label="Close" 
            style="background-color: rgb(2,17,79); height: 30px; width: 30px; margin-left: 5px; display: flex; align-items: center; justify-content: center;"
        >
            <span aria-hidden="true" style="color: white; font-size: 24px; line-height: 0;">×</span>
        </button>
    </div>
</div>



            <!--[if BLOCK]><![endif]--><?php if($peopleData && $peopleData->isEmpty()): ?>
                <div class="container" style="text-align: center; color: white; font-size: 12px;margin-top:5px"> No People Found
                </div>
            <?php else: ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $peopleData->sortBy(function($person) {
    return $person->first_name . ' ' . $person->last_name;
}); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $people): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label wire:click="selectPerson('<?php echo e($people->emp_id); ?>')" class="container" style="cursor: pointer; background-color: darkgrey; padding: 5px; margin-bottom: 8px; width: 300px; border-radius: 5px;margin-top:5px">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <input type="checkbox" wire:model="selectedPeople" value="<?php echo e($people->emp_id); ?>" <?php echo e(in_array($people->emp_id, $selectedPeople) ? 'checked' : ''); ?>>
                            </div>
                            <div class="col-auto">
                                <!--[if BLOCK]><![endif]--><?php if($people->image == ""): ?>
                                    <!--[if BLOCK]><![endif]--><?php if($people->gender == "Male"): ?>
                                        <img class="profile-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="">
                                    <?php elseif($people->gender == "Female"): ?>
                                        <img class="profile-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="">
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?>
                                    <img class="profile-image" src="<?php echo e(Storage::url($people->image)); ?>" alt="">
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="col">
                                <h6 class="username" style="font-size: 12px; color: white;"><?php echo e(ucwords(strtolower($people->first_name))); ?> <?php echo e(ucwords(strtolower($people->last_name))); ?></h6>
                                <p class="mb-0" style="font-size: 12px; color: white;">(#<?php echo e($people->emp_id); ?>)</p>
                            </div>
                        </div>
                    </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</div>


                        <div class="ml-0 p-0 mt-3 d-flex gap-3 justify-content-center">
                            <button wire:click="submitHR" class="submit-btn" type="button">Submit</button>
                            <button wire:click="close" class="cancel-btn" type="button" style="border: 1px solid rgb(2, 17, 79);">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <!--[if BLOCK]><![endif]--><?php if($showDialogFinance): ?>
        <div class="modal" tabindex="-1" role="dialog" style="display: block;overflow-y:auto;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header align-items-center" style="background-color: rgb(2, 17, 79); height: 50px">
                        <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b>Finance Request</b></h5>

                        </button>
                    </div>
                    <div class="modal-body" >
                    <label for="category" style="color:#778899;font-weight:500;font-size:12px;font-family: Arial, sans-serif;" >Category <span style="color:red">*</span></label>
                    <div class="input" type="" class="form-control placeholder-small">
    <div style="position: relative;">
        <select wire:model.lazy="category" id="category" style="font-size: 12px;" class="form-control placeholder-small">
            <option style="color: #778899; " value="">Select Category</option>
            <optgroup label="Finance">
                <option value="Income Tax">Income Tax</option>
                <option value="Loans">Loans</option>
                <option value="Payslip">Payslip</option>
            </optgroup>
        </select>
        <div class="dropdown-toggle-icon" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%);">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                <path d="M14.146 5.146a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 1 1 .708-.708L8 10.293l5.146-5.147a.5.5 0 0 1 .708 0z"/>
            </svg>
        </div>



                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>


                        <div class="form-group mt-2">
                            <label for="subject" style="color:#778899;font-weight:500;font-size:12px;">Subject<span  style="color:red">*</span></label>
                            <input type="text" wire:model.lazy="subject" id="subject" class="form-control placeholder-small" placeholder="Enter subject" style="font-family: Montserrat, sans-serif;">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="form-group mt-2">
                            <label for="description" style="color:#778899;font-weight:500;font-size:12px;">Description<span  style="color:red">*</span></label>
                            <textarea wire:model.lazy="description" id="description" class="form-control " placeholder="Enter description" rows="4" ></textarea>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <label for="fileInput" style="color:#778899;font-weight:500;font-size:12px;cursor:pointer;">
                                    <i class="fa fa-paperclip"></i> Attach Image
                                </label>
                            </div>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['file_path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <div>
                            <input wire:model="image" type="file" accept="image/*" style="font-size: 12px;">

                        </div>
                        <div class="row">
                            <div class="col">
                            <div class="form-group mt-2">
    <label for="priority" style="color:#778899;font-weight:500;font-size:12px;margin-top:10px;">Priority<span style="color:red">*</span></label>
    <div class="input" class="form-control placeholder-small">
        <div style="position: relative;">
            <select name="priority" id="priority" wire:model.lazy="priority" style="font-size: 12px; " class="form-control placeholder-small">
                <option style="color: gray;" value="">Select Priority</option>
                <option value="High">High</option>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
            </select>
            <div class="dropdown-toggle-icon" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                    <path d="M14.146 5.146a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 1 1 .708-.708L8 10.293l5.146-5.147a.5.5 0 0 1 .708 0z"/>
                </svg>
            </div>
        </div>
    </div>
    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
</div>

                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
    <div class="col">
        <div class="row m-0 p-0">
            <div class="row m-0 p-0">
                <div style="margin: 0px; padding: 0;">
                    <div>
                        
                        <div style="font-size: 12px; color: #778899; margin-bottom: 10px; font-weight: 500;"   >
                            Selected CC recipients: <?php echo e(implode(', ', array_unique($selectedPeopleNames))); ?>

                        </div>
                    </div>
                    <button type="button" style="border-radius: 50%; color: #778899; border: 1px solid #778899;" class="add-button" wire:click="toggleRotation">
                        <div class="icon-container">
                            <i class="bx bx-plus" style="color: #778899;"></i>
                        </div>
                    </button>
                    <span style="color: #778899; font-size: 12px;">Add</span>
                </div>
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['cc_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
        
        <!--[if BLOCK]><![endif]--><?php if($isRotated): ?>
        <div style="border-radius: 5px; background-color: grey; padding: 8px; width: 330px; margin-top: 10px; height: 200px; overflow-y: auto;">
        <div class="input-group" style="margin-bottom: 10px;">
            <input wire:model="searchTerm" style="font-size: 10px; cursor: pointer; border-radius: 5px 0 0 5px;" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
            <div class="input-group-append">
                <button wire:click="filter" style="height: 30px; border-radius: 0 5px 5px 0; background-color: rgb(2, 17, 79); color: #fff; border: none;" class="btn" type="button">
                    <i style="text-align: center;" class="fa fa-search"></i>
                </button>

                                <div class="col-md-2 ml-4 p-0">
                                <button wire:click="closePeoples"  type="button" class="close rounded px-1 py-0" aria-label="Close" style="background-color: rgb(2,17,79);height:32px;width:33px;">
                                    <span aria-hidden="true" style="color: white; font-size: 24px;">×</span>
                                </button>
                                </div>
            </div>
        </div>
        
        
 

            <!--[if BLOCK]><![endif]--><?php if($peopleData && $peopleData->isEmpty()): ?>
                <div class="container" style="text-align: center; color: white; font-size: 12px"> No People Found
                </div>
            <?php else: ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $peopleData->sortBy(function($person) {
    return $person->first_name . ' ' . $person->last_name;
}); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $people): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label wire:click="selectPerson('<?php echo e($people->emp_id); ?>')" class="container" style="cursor: pointer; background-color: darkgrey; padding: 5px; margin-bottom: 8px; width: 300px; border-radius: 5px;">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <input type="checkbox" wire:model="selectedPeople" value="<?php echo e($people->emp_id); ?>" <?php echo e(in_array($people->emp_id, $selectedPeople) ? 'checked' : ''); ?>>
                            </div>
                            <div class="col-auto">
                                <!--[if BLOCK]><![endif]--><?php if($people->image == ""): ?>
                                    <!--[if BLOCK]><![endif]--><?php if($people->gender == "Male"): ?>
                                        <img class="profile-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="">
                                    <?php elseif($people->gender == "Female"): ?>
                                        <img class="profile-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="">
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?>
                                    <img class="profile-image" src="<?php echo e(Storage::url($people->image)); ?>" alt="">
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="col">
                                <h6 class="username" style="font-size: 12px; color: white;"><?php echo e(ucwords(strtolower($people->first_name))); ?> <?php echo e(ucwords(strtolower($people->last_name))); ?></h6>
                                <p class="mb-0" style="font-size: 12px; color: white;">(#<?php echo e($people->emp_id); ?>)</p>
                            </div>
                        </div>
                    </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</div>
                        <div class="ml-0 p-0 mt-3 d-flex gap-3 justify-content-center">
                            <button wire:click="submit" class="submit-btn" type="button">Submit</button>
                            <button wire:click="closeFinance" class="cancel-btn" type="button" style="border: 1px solid rgb(2, 17, 79);">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!--[if BLOCK]><![endif]--><?php if($activeTab == "active"): ?>
        <div class="row">
    <div class="col-md-3">
        <div class="input-group people-input-group-container">
            <input wire:model="search" type="text" class="form-control people-search-input" placeholder="Search Employee.." aria-label="Search" aria-describedby="basic-addon1" style="height:32px">
            <div class="input-group-append">
                <button wire:click="searchActiveHelpDesk" class="submit-btn" type="button" >
                    <i class="fa fa-search people-search-icon"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <select wire:model="selectedCategory" wire:change="searchActiveHelpDesk" class="form-control">
            <option value="">Select Request</option>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $requestCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request => $categories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($request); ?>"><?php echo e($request); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
    </div>
</div>






<table style="width: 100%; border-collapse: collapse; background-color: white;margin-top:10px">
    <thead>
        <tr style="background-color: rgb(2, 17, 79); color: white;">
            <th style="padding: 10px; font-size: 12px; text-align: center; width: 20%;">Request Raised By</th>
            <th style="padding: 10px; font-size: 12px; text-align: center; width: 10%;">Category</th>
            <th style="padding: 10px; font-size: 12px; text-align: center; width: 20%;">Subject</th>
            <th style="padding: 10px; font-size: 12px; text-align: center; width: 10%;">Description</th>
            <th style="padding: 10px; font-size: 12px; text-align: center; width: 10%;">Attach Files</th>
            <th style="padding: 10px; font-size: 12px; text-align: center; width: 20%;">CC To</th>
            <th style="padding: 10px; font-size: 12px; text-align: center; width: 10%;">Priority</th>
        </tr>
    </thead>
    <tbody>
    <!--[if BLOCK]><![endif]--><?php if($searchData->where('status', 'Recent')->isEmpty()): ?>
            <tr>
                <td colspan="7" style="text-align: center;">
                    <img style="width: 10em; margin: 20px;" src="https://media.istockphoto.com/id/1357284048/vector/no-item-found-vector-flat-icon-design-illustration-web-and-mobile-application-symbol-on.jpg?s=612x612&w=0&k=20&c=j0V0ww6uBl1LwQLH0U9L7Zn81xMTZCpXPjH5qJo5QyQ=" alt="No items found">
                </td>
            </tr>
        <?php else: ?>
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $searchData->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <!--[if BLOCK]><![endif]--><?php if($record->status=="Recent"): ?>
                    <tr style="background-color: white;">
                        <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize;">
                            <?php echo e($record->emp->first_name); ?> <?php echo e($record->emp->last_name); ?> <br>
                            <strong style="font-size: 10px;">(<?php echo e($record->emp_id); ?>)</strong>
                        </td>
                        <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize;">
                            <?php echo e($record->category); ?>

                        </td>
                        <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize;">
                            <?php echo e($record->subject); ?>

                        </td>
                        <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize;">
                            <?php echo e($record->description); ?>

                        </td>
                        <td style="padding: 10px; font-size: 12px; text-align: center;">
                            <!--[if BLOCK]><![endif]--><?php if(!is_null($record->file_path) && $record->file_path !== 'N/A'): ?>
                                <a href="<?php echo e(asset('storage/' . $record->file_path)); ?>" target="_blank" style="text-decoration: none; color: #007BFF; text-transform: capitalize;">View File</a>
                            <?php else: ?>
                                -
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>
                        <td  style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize; border-top: none;">
                            <?php
                                $ccToArray = explode(',', $record->cc_to??'-');
                            ?>
                            <?php echo e(count($ccToArray) <= 2 ? implode(', ', $ccToArray) : '-'); ?>

                        </td>
                        <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize;">
                            <?php echo e($record->priority); ?>

                        </td>
                    </tr>
                    <!--[if BLOCK]><![endif]--><?php if(count($ccToArray) > 2): ?>
                        <tr class="no-border-top" >
                            <td  class="no-border-top" colspan="7" style="padding: 10px; font-size: 12px; text-transform: capitalize;">
                                <div  class="no-border-top" style="margin-left: 10px; font-size: 12px; text-transform: capitalize; ">
                                    CC TO: <?php echo e(implode(', ', $ccToArray)); ?>

                                </div>
                            </td>
                        </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </tbody>
</table>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->










        <!--[if BLOCK]><![endif]--><?php if($activeTab == "closed"): ?>
        <div class="row">
    <div class="col-md-3">
        <div class="input-group people-input-group-container">
            <input wire:model="search" type="text" class="form-control people-search-input" placeholder="Search Employee.." aria-label="Search" aria-describedby="basic-addon1" style="height:32px">
            <div class="input-group-append">
                <button wire:click="searchClosedHelpDesk" class="submit-btn" type="button" >
                    <i class="fa fa-search people-search-icon"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <select wire:model="selectedCategory" wire:change="searchClosedHelpDesk" class="form-control">
            <option value="">Select Request</option>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $requestCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request => $categories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($request); ?>"><?php echo e($request); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
    </div>
</div>
        <div class="card-body" style="margin:0 auto;background-color:white;width:95%;margin-top:30px;border-radius:5px;max-height:400px;height:400px;overflow-y:auto">

            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: rgb(2, 17, 79); color: white;">
                        <th style="padding: 10px;font-size:12px;text-align:center;width:120px">Request Raised By</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Category</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Subject</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Description</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Attach Files</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">CC To</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Priority</th>
                    </tr>
                </thead>
                <tbody>
                <!--[if BLOCK]><![endif]--><?php if($searchData->where('status', 'Completed')->isEmpty()): ?>
            <tr>
                <td colspan="7" style="text-align: center;">
                    <img style="width: 10em; margin: 20px;" src="https://media.istockphoto.com/id/1357284048/vector/no-item-found-vector-flat-icon-design-illustration-web-and-mobile-application-symbol-on.jpg?s=612x612&w=0&k=20&c=j0V0ww6uBl1LwQLH0U9L7Zn81xMTZCpXPjH5qJo5QyQ=" alt="No items found">
                </td>
            </tr>
        <?php else: ?>
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $searchData->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <!--[if BLOCK]><![endif]--><?php if($record->status=="Completed"): ?>
                    <tr style="background-color: white;">
                        <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize;">
                            <?php echo e($record->emp->first_name); ?> <?php echo e($record->emp->last_name); ?> <br>
                            <strong style="font-size: 10px;">(<?php echo e($record->emp_id); ?>)</strong>
                        </td>
                        <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize;">
                            <?php echo e($record->category); ?>

                        </td>
                        <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize;">
                            <?php echo e($record->subject); ?>

                        </td>
                        <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize;">
                            <?php echo e($record->description); ?>

                        </td>
                        <td style="padding: 10px; font-size: 12px; text-align: center;">
                            <!--[if BLOCK]><![endif]--><?php if(!is_null($record->file_path) && $record->file_path !== 'N/A'): ?>
                                <a href="<?php echo e(asset('storage/' . $record->file_path)); ?>" target="_blank" style="text-decoration: none; color: #007BFF; text-transform: capitalize;">View File</a>
                            <?php else: ?>
                                -
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>
                        <td  style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize; border-top: none;">
                            <?php
                                $ccToArray = explode(',', $record->cc_to??'-');
                            ?>
                            <?php echo e(count($ccToArray) <= 2 ? implode(', ', $ccToArray) : '-'); ?>

                        </td>
                        <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize;">
                            <?php echo e($record->priority); ?>

                        </td>
                    </tr>
                    <!--[if BLOCK]><![endif]--><?php if(count($ccToArray) > 2): ?>
                        <tr class="no-border-top" >
                            <td  class="no-border-top" colspan="7" style="padding: 10px; font-size: 12px; text-transform: capitalize;">
                                <div  class="no-border-top" style="margin-left: 10px; font-size: 12px; text-transform: capitalize; ">
                                    CC TO: <?php echo e(implode(', ', $ccToArray)); ?>

                                </div>
                            </td>
                        </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                  
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
      
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                </tbody>
            </table>

        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->



        <!--[if BLOCK]><![endif]--><?php if($activeTab == "pending"): ?>
        <div class="row">
    <div class="col-md-3">
        <div class="input-group people-input-group-container">
            <input wire:model="search" type="text" class="form-control people-search-input" placeholder="Search Employee.." aria-label="Search" aria-describedby="basic-addon1" style="height:32px">
            <div class="input-group-append">
                <button wire:click="searchPendingHelpDesk" class="submit-btn" type="button" >
                    <i class="fa fa-search people-search-icon"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <select wire:model="selectedCategory" wire:change="searchPendingHelpDesk" class="form-control">
            <option value="">Select Request</option>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $requestCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request => $categories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($request); ?>"><?php echo e($request); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
    </div>
</div>
        <div class="card-body" style="margin:0 auto;background-color:white;width:95%;margin-top:30px;border-radius:5px;max-height:400px;height:400px;overflow-y:auto">
  
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: rgb(2, 17, 79); color: white;">
                        <th style="padding: 10px;font-size:12px;text-align:center;width:120px">Request Raised By</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Category</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Subject</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Description</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Attach Files</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">CC To</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Priority</th>
                    </tr>
                </thead>
                <tbody>
                <!--[if BLOCK]><![endif]--><?php if($searchData->where('status', 'Pending')->isEmpty()): ?>
                <tr>
                <td colspan="7" style="text-align: center;">
                    <img style="width: 10em; margin: 20px;" src="https://media.istockphoto.com/id/1357284048/vector/no-item-found-vector-flat-icon-design-illustration-web-and-mobile-application-symbol-on.jpg?s=612x612&w=0&k=20&c=j0V0ww6uBl1LwQLH0U9L7Zn81xMTZCpXPjH5qJo5QyQ=" alt="No items found">
                </td>
            </tr>
        <?php else: ?>
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $searchData->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <!--[if BLOCK]><![endif]--><?php if($record->status=="Pending"): ?>
                    <tr style="background-color: white;">
                        <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize;">
                            <?php echo e($record->emp->first_name); ?> <?php echo e($record->emp->last_name); ?> <br>
                            <strong style="font-size: 10px;">(<?php echo e($record->emp_id); ?>)</strong>
                        </td>
                        <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize;">
                            <?php echo e($record->category); ?>

                        </td>
                        <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize;">
                            <?php echo e($record->subject); ?>

                        </td>
                        <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize;">
                            <?php echo e($record->description); ?>

                        </td>
                        <td style="padding: 10px; font-size: 12px; text-align: center;">
                            <!--[if BLOCK]><![endif]--><?php if(!is_null($record->file_path) && $record->file_path !== 'N/A'): ?>
                                <a href="<?php echo e(asset('storage/' . $record->file_path)); ?>" target="_blank" style="text-decoration: none; color: #007BFF; text-transform: capitalize;">View File</a>
                            <?php else: ?>
                                -
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>
                        <td  style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize; border-top: none;">
                            <?php
                                $ccToArray = explode(',', $record->cc_to??'-');
                            ?>
                            <?php echo e(count($ccToArray) <= 2 ? implode(', ', $ccToArray) : '-'); ?>

                        </td>
                        <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize;">
                            <?php echo e($record->priority); ?>

                        </td>
                    </tr>
                    <!--[if BLOCK]><![endif]--><?php if(count($ccToArray) > 2): ?>
                        <tr class="no-border-top" >
                            <td  class="no-border-top" colspan="7" style="padding: 10px; font-size: 12px; text-transform: capitalize;">
                                <div  class="no-border-top" style="margin-left: 10px; font-size: 12px; text-transform: capitalize; ">
                                    CC TO: <?php echo e(implode(', ', $ccToArray)); ?>

                                </div>
                            </td>
                        </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                  
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
      
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                </tbody>
            </table>

        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
</div>
<?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/help-desk.blade.php ENDPATH**/ ?>