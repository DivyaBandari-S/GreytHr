<div>
    <?php if (isset($component)) { $__componentOriginald7103a47772803b4ca11acafa934cefb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald7103a47772803b4ca11acafa934cefb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.loading-indicator','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('loading-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald7103a47772803b4ca11acafa934cefb)): ?>
<?php $attributes = $__attributesOriginald7103a47772803b4ca11acafa934cefb; ?>
<?php unset($__attributesOriginald7103a47772803b4ca11acafa934cefb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald7103a47772803b4ca11acafa934cefb)): ?>
<?php $component = $__componentOriginald7103a47772803b4ca11acafa934cefb; ?>
<?php unset($__componentOriginald7103a47772803b4ca11acafa934cefb); ?>
<?php endif; ?>
<div class="px-4" style="position: relative;">
<!--[if BLOCK]><![endif]--><?php if($message): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?php echo e($message); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div class="container  mt-3" style="height:60px;margin-top:10px">
    
        <div class="row bg-white rounded border" style="height:80px">
     
            <div class="col-md-1 mt-3" style="height:60px">
            <!--[if BLOCK]><![endif]--><?php if($employeeDetails && $employeeDetails->count() > 0): ?>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $employeeDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!--[if BLOCK]><![endif]--><?php if($employee->image): ?>
                <img style="border-radius: 50%; margin-left: 10px" height="50" width="50" src="<?php echo e(asset('storage/' . $employee->image)); ?>">
                <?php else: ?>
                    <img style="border-radius: 50%; margin-left: 10px" height="50" width="50" src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" alt="Default Image">
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                <?php else: ?>
                <p>No employee details found.</p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="col-md-10 mt-2 bg-white d-flex align-items-center justify-content-between">
                <div>
                <!--[if BLOCK]><![endif]--><?php if(auth()->guard('emp')->check()): ?>
    <span class="text-base">Hey <?php echo e(ucwords(strtolower(auth()->guard('emp')->user()->first_name))); ?> <?php echo e(ucwords(strtolower(auth()->guard('emp')->user()->last_name))); ?></span>
<?php elseif(auth()->guard('hr')->check()): ?>
    <span class="text-base">Hey <?php echo e(ucwords(strtolower(auth()->guard('hr')->user()->employee_name))); ?></span>
<?php else: ?>
    <p>No employee details available.</p>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <div class="text-xs">Ready to dive in?</div>
                </div>
                <div>
                    <button wire:click="addFeeds" class="flex flex-col justify-between items-start group w-20 h-20 p-1 rounded-md border border-purple-200" style="background-color: #F1ECFC;border:1px solid purple;border-radius:5px;">
                        <div class="w-6 h-6 rounded bg-purple-200">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file stroke-current group-hover:text-purple-600 stroke-1 text-purple-400">
                                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                <polyline points="13 2 13 9 20 9"></polyline>
                            </svg>
                        </div>
                        <div class="row ml-2">
                            <div class="text-left text-xs" wire:click="addFeeds">Create</div>
                            <div class="text-left text-xs">Posts</div>
                        </div>
                    </button>

                    <!--[if BLOCK]><![endif]--><?php if($showFeedsDialog): ?>
                    <div class="modal" tabindex="-1" role="dialog" style="display: block;">
        
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                          <h5 class="modal-title">Creating a Post</h5>

                                    <button wire:click="closeFeeds" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <!--[if BLOCK]><![endif]--><?php if(Session::has('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert" style="font-size: 12px; width: 90%; margin: 10px auto 0;">
        <?php echo e(Session::get('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->



                                <form wire:submit.prevent="submit">
                                    <div class="modal-body">
                                        <div class="form-group">
                                        <select wire:model="category" class="form-select" id="category">
                                        <option value="Appreciations">Appreciations</option>
                                        <option value="Buy/Sell/Rent">Buy/Sell/Rent</option>
                                        <option value="Companynews">Companynews</option>
                                        <option value="Events">Events</option>
                                        <option value="Everyone">Everyone</option>
                                        <option value="Hyderabad">Hyderabad</option>
                                        <option value="US">US</option>
                                    </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="content" style="display: block; font-weight: 600;text-align:start">Write something here:</label>
                                            <textarea wire:model="description" class="form-control" id="content" rows="2"></textarea>
                                        </div>
                                        <div class="form-group" >
                                            <label for="attachment" style="display: block; font-weight: 600;text-align:start">Upload Attachment:</label>
                                           
                                            <div  style="text-align:start">
    <input wire:model="image" type="file" accept="image/*" style="font-size: 12px;">

    <!--[if BLOCK]><![endif]--><?php if($image): ?>
    <div class="mt-3">
        
        <div>
            <img src="<?php echo e($image->temporaryUrl()); ?>" height="50" width="50" alt="Image Preview" style="max-width: 300px;">
        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>

                                        </div>
                                    </div>
                                  
                                    <div class="modal-footer">
                                    <div class="m-0 p-0 mt-3 d-flex gap-3 justify-content-center">
                                    <button wire:click="submit" class="submit-btn" type="button">Submit</button>
                            <button wire:click="closeFeeds" class="cancel-btn" type="button" style="border: 1px solid rgb(2, 17, 79);">Cancel</button>
                       
                                    </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-backdrop fade show"></div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>
        <!-- Additional row -->
        <div class="row mt-3 d-flex" style="overflow-x: hidden;">

            <div class="col-md-3 bg-white p-3" style="border-radius:5px;border:1px solid silver;height:400;overflow-x: hidden;">

                <p style="font-weight: 500;font-size:13px;color:#47515b;">Filters</p>
                <hr style="width: 100%;border-bottom: 1px solid grey;">


                <p style="font-weight: 500;font-size:13px;color:#47515b;cursor:pointer">Activities</p>
                <div class="activities">
    <label class="custom-radio-label" style="display: flex; align-items: center;">
        <input type="radio" name="radio" value="activities" checked data-url="/Feeds">
        <div class="icon-container" style="margin-left: 10px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file stroke-current text-purple-400 stroke-1" style="width: 1rem; height: 1rem;">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
          
                <rect x="7" y="7" width="3" height="9"></rect>
    <rect x="14" y="7" width="3" height="5"></rect>
            </svg>
        </div>
        <span class="custom-radio-button bg-blue" style="margin-left: 10px; font-size: 8px;"></span>
        <span style="color: #778899; font-size: 12px; font-weight: 500;">All Activities</span>
    </label>
</div>

                <div class="posts" style="display:flex">
                    <label class="custom-radio-label" style="display:flex; align-items:center;">
                       
                        <!--[if BLOCK]><![endif]--><?php if(auth()->guard('emp')->check()): ?>
                        <input type="radio" name="radio" value=""   data-url="/everyone"><span>
<?php elseif(auth()->guard('hr')->check()): ?>
<input type="radio" name="radio" value=""   data-url="/hreveryone"><span>
<?php else: ?>
    <p>No employee details available.</p>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <div class="icon-container" style="margin-left: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file stroke-current text-purple-400 stroke-1" style="width: 1rem; height: 1rem;">
      
        <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
        <polyline points="13 2 13 9 20 9"></polyline>
    </svg>
</div>

                        </span><span class="custom-radio-button bg-blue" style="margin-left:10px;font-size:10px"></span> <span style="color:#778899;font-size:12px;font-weight:500;">Posts</span></label>
                </div>
                
                <hr style="width: 100%;border-bottom: 1px solid grey;">
                <div style="overflow-y:auto;max-height:300px;overflow-x: hidden;">
                    <div class="row">
                        <div class="col " style="margin: 0px;">
                            <div class="input-group">
                                <input wire:model="search" id="filterSearch" onkeyup="filterDropdowns()" style="width:80%;font-size: 10px; border-radius: 5px 0 0 5px; cursor: pointer; " type="text" class="form-control" placeholder="Search...." aria-label="Search" aria-describedby="basic-addon1">
                                <button style=" border-radius: 0 5px 5px 0; background-color: rgb(2, 17, 79);; color: #fff; border: none;" class="search-btn" type="button">
                                    <i style="text-align: center;" class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="w-full visible mt-1" style="margin-top:20px">
                        <div class="cus-button" style="display: flex; justify-content: space-between; width: 100%; padding: 0.5rem;" onclick="toggleDropdown('dropdownContent1', 'arrowSvg1')">
                            <span class="text-xs leading-4" style="font-weight:bold; color: grey;">Groups</span>

                            <span class="arrow-icon" id="arrowIcon1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down h-1.2x w-1.2x text-secondary-400" id="arrowSvg1" style="color:black">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </div>
                        <div id="dropdownContent1" style="display: none;">
                            <ul class="d-flex flex-column" style="font-size: 12px; line-height: 1; text-decoration: none; color:black;text-align: left; padding-left: 0;">
                                <a class="menu-item" href="/Feeds" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">All Feeds</a>
                                <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>
                          
        <a class="menu-item" href="/hreveryone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Every One </a>
    <?php elseif(Auth::guard('emp')->check()): ?>
        <a class="menu-item" href="/everyone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Every One </a>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->



    <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Events</a>
<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Events</a>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hreveryone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Company News</a>
<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/everyone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Company News</a>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hreveryone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Appreciation</a>
<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/everyone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Appreciation</a>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hreveryone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Buy/Sell/Rent</a>
<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/everyone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Buy/Sell/Rent</a>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </ul>
                        </div>
                    </div>

                    <div class="w-full visible mt-1" style="margin-top: 20px;">
                        <div class="cus-button" style="display: flex; justify-content: space-between; width: 100%; padding: 0.5rem;">
                            <span class="text-xs leading-4 " style="font-weight: bold;color:grey">Location</span>
                            <span class="arrow-icon" id="arrowIcon2" onclick="toggleDropdown('dropdownContent2', 'arrowSvg2')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down h-1.2x w-1.2x text-secondary-400" id="arrowSvg2" style="color: black;">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </div>
                        <div id="dropdownContent2" style="font-size: 12px; line-height: 1; text-decoration: none; color: black; text-align: left; padding-left: 0; display: none;">
                            <ul style="font-size: 12px; margin: 0; padding: 0;">
                                <b class="menu-item" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">India</b>
                                <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Guntur</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Guntur</a>

<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Hyderabad</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Hyderabad</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->      
 <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Doddaballapur</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Doddaballapur</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]--> 
 <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Tirupati</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Tirupati</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->      
 <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Adilabad</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Adilabad</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->      
 <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Trivandrum</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Trivandrum</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->      
 <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">USA</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">USA</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->      
 <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">California</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">California</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">New York</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">New York</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->      
 <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Alaska</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Alaska</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->      
 <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Hawaii</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Hawaii</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->                 

                            </ul>
                        </div>
                    </div>

                    <div class="w-full visible mt-1" style="margin-top: 20px;">
                        <div class="cus-button" style="display: flex; justify-content: space-between; width: 100%; padding: 0.5rem;">
                            <span class="text-xs leading-4 " style="font-weight: bold;color:grey">Department</span>
                            <span class="arrow-icon" id="arrowIcon3" onclick="toggleDropdown('dropdownContent3', 'arrowSvg3')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down h-1.2x w-1.2x text-secondary-400" id="arrowSvg3" style="color: black;">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </div>
                        <div id="dropdownContent3" style="font-size: 12px; line-height: 1; text-decoration: none; color: black; text-align: left; padding-left: 0; display: none;">
                            <ul style="font-size: 12px; margin: 0; padding: 0;">
                            <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">HR</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">HR</a>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Operations Team</a>


<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Operations</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Operations</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">QA</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">QA</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Production Team</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Production Team</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Sales Team</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Sales Team</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Testing Team</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Testing Team</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
           
                         
                              
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
         
            <div class="col" style="max-height: 80vh; overflow-y: auto;scroll-behavior: smooth;">
      
   
            <div class="col-md-8 mt-1">
            <div class="column text-right" style="display:flex; justify-content: flex-end;">
    
        
    <p style="margin-top: 1px;font-size:12px">Sort:</p>
    
       
            <p style="font-size:14px;font-weight:500;">Newest first</p>
           
                   <svg class="dropdown-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="2 0 24 24" stroke="currentColor"style="height:12px;width:14px;margin-left:2px;margin-top:4px">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>

    
</div>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $combinedData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <!--[if BLOCK]><![endif]--><?php if($data['type'] === 'date_of_birth' ): ?>
                    <div class="birthday-card  mt-2">
                        <!-- Upcoming Birthdays List -->
                        <div class="F mb-4" style="padding: 15px; background-color: white; border-radius: 5px; border: 1px solid #CFCACA; color: #3b4452; margin-top: 5px">
                            <div class="row m-0">
                                <div class="col-md-4 mb-2" style="text-align: center;">
                                <img src="<?php echo e($empCompanyLogoUrl); ?>" alt="Company Logo">
                                </div>
                                <div class="col-md-4 m-auto" style="color: #677A8E; font-size: 14px;font-weight: 100px; text-align: center;">
                                    Group Events
                                </div>
                                <div class="c col-md-4 m-auto" style="font-size: 13px; font-weight: 100px; color: #9E9696; text-align: center;">
                                    <?php echo e(date('d M ', strtotime($data['employee']->date_of_birth))); ?>

                                </div>
                            </div>
                            <div class="row m-0 mt-2">
                                <div class="col-md-4">
                                    <img src="<?php echo e(asset('images/Blowing_out_Birthday_candles_Gif.gif')); ?>" alt="Image Description" style="width: 200px;">
                                </div>
                                <div class="col-md-8 m-auto">
                                    <p style="color: #778899;font-size: 12px;font-weight:normal;">
                                        Happy Birthday <?php echo e(ucwords(strtoupper($data['employee']->first_name))); ?>

                                        <?php echo e(ucwords(strtoupper($data['employee']->last_name))); ?>,
                                        Have a great year ahead!
                                    </p>
                                    <div style="display: flex; align-items: center;">
                                        <img src="https://logodix.com/logo/1984436.jpg" alt="Image Description" style="height: 25px; width: 20px;">
                                        <p style="margin-left: 10px; font-size: 12px; color: #47515b;margin-bottom:0;font-weight:600;">
                                            Happy Birthday <?php echo e(ucwords(strtoupper($data['employee']->first_name))); ?>

                                            <?php echo e(ucwords(strtoupper($data['employee']->last_name))); ?>! 🎂
                                        </p>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-2 p-0" style="margin-left:5px;">
                                <?php
                                $currentCardEmojis = $emojis->where('emp_id', $data['employee']->emp_id);
                                $emojisCount = $currentCardEmojis->count();
                                $lastTwoEmojis = $currentCardEmojis->slice(max($emojisCount - 2, 0))->reverse();
                                $uniqueNames = [];
                                ?>

                                <!--[if BLOCK]><![endif]--><?php if($currentCardEmojis && $emojisCount > 0): ?>
                                <div style="white-space: nowrap;">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $lastTwoEmojis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $emoji_reaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span style="font-size: 16px;"><?php echo e($emoji_reaction->emoji_reaction); ?></span>
                                    <!--[if BLOCK]><![endif]--><?php if(!$loop->last): ?>
                                    <span>,</span>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $lastTwoEmojis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $emoji): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $fullName = ucwords(strtolower($emoji->first_name)) . ' ' . ucwords(strtolower($emoji->last_name));
                                    ?>
                                    <!--[if BLOCK]><![endif]--><?php if(!in_array($fullName, $uniqueNames)): ?>
                                    <!--[if BLOCK]><![endif]--><?php if(!$loop->first): ?>
                                    <span>,</span>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <span style="font-size: 8px;"> <?php echo e($fullName); ?></span>
                                    <?php $uniqueNames[] = $fullName; ?>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <!--[if BLOCK]><![endif]--><?php if(count($uniqueNames) > 0): ?>
                                    <span style="font-size:8px">reacted</span>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                                </div>




                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="w-90" style="border-top: 1px solid #E8E5E4; margin: 10px;"></div>
                            <div class="row" style="display: flex;">
                                <div class="col-md-3" style="display: flex;">
                                    <form wire:submit.prevent="createemoji('<?php echo e($data['employee']->emp_id); ?>')">

                                        <?php echo csrf_field(); ?>
                                        <div class="emoji-container">
                                            <span id="smiley-<?php echo e($index); ?>" class="emoji-trigger" onclick="showEmojiList(<?php echo e($index); ?>)" style="font-size: 16px;cursor:pointer">
                                                😊





                                                <!-- List of emojis -->
                                                <div id="emoji-list-<?php echo e($index); ?>" class="emoji-list" style="display: none;background:white; border-radius:5px; border:1px solid silver; max-height:170px;width:220px; overflow-y: auto;">
                                                    <div class="emoji-row">
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128512','<?php echo e($data['employee']->emp_id); ?>')">😀</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128513','<?php echo e($data['employee']->emp_id); ?>')">😁</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128514','<?php echo e($data['employee']->emp_id); ?>')">😂</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128515','<?php echo e($data['employee']->emp_id); ?>')">😃</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128516','<?php echo e($data['employee']->emp_id); ?>')">😄</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128517','<?php echo e($data['employee']->emp_id); ?>')">😅</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128518','<?php echo e($data['employee']->emp_id); ?>')">😆</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128519','<?php echo e($data['employee']->emp_id); ?>')">😇</span>

                                                    </div>
                                                    <div class="emoji-row">
                                                        <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128520','<?php echo e($data['employee']->emp_id); ?>')">😈</span>
                                                        <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128521','<?php echo e($data['employee']->emp_id); ?>')">😉</span>
                                                        <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128522','<?php echo e($data['employee']->emp_id); ?>')">😊</span>
                                                        <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128523','<?php echo e($data['employee']->emp_id); ?>')">😋</span>
                                                        <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128525','<?php echo e($data['employee']->emp_id); ?>')">😍</span>
                                                        <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128524','<?php echo e($data['employee']->emp_id); ?>')">😌</span>
                                                        <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128526','<?php echo e($data['employee']->emp_id); ?>'))">😎</span>
                                                        <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128527','<?php echo e($data['employee']->emp_id); ?>'))">😏</span>

                                                    </div>
                                                    <div class="emoji-row">
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128528','<?php echo e($data['employee']->emp_id); ?>')">😐</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128529','<?php echo e($data['employee']->emp_id); ?>')">😑 </span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128530','<?php echo e($data['employee']->emp_id); ?>')">😒</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128531','<?php echo e($data['employee']->emp_id); ?>')">😓</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128532','<?php echo e($data['employee']->emp_id); ?>')">😔</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128533','<?php echo e($data['employee']->emp_id); ?>')">😕</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128534','<?php echo e($data['employee']->emp_id); ?>')">😖</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128535','<?php echo e($data['employee']->emp_id); ?>')">😗</span>

                                                    </div>
                                                    <div class="emoji-row">
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128536','<?php echo e($data['employee']->emp_id); ?>')">😘</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128537')">😙</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128538','<?php echo e($data['employee']->emp_id); ?>')">😚</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128539','<?php echo e($data['employee']->emp_id); ?>')">😛</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128540','<?php echo e($data['employee']->emp_id); ?>')">😜</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128541','<?php echo e($data['employee']->emp_id); ?>')">😝</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128542','<?php echo e($data['employee']->emp_id); ?>')">😞</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128543','<?php echo e($data['employee']->emp_id); ?>')">😟</span>

                                                    </div>
                                                    <div class="emoji-row">
                                                        <!-- Add more emojis here -->
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128544','<?php echo e($data['employee']->emp_id); ?>')">😠</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128545','<?php echo e($data['employee']->emp_id); ?>')">😡 </span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128546','<?php echo e($data['employee']->emp_id); ?>')">😢</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128547','<?php echo e($data['employee']->emp_id); ?>')">😣</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128548','<?php echo e($data['employee']->emp_id); ?>')">😤</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128549','<?php echo e($data['employee']->emp_id); ?>')">😥</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128550','<?php echo e($data['employee']->emp_id); ?>')">😦</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128551','<?php echo e($data['employee']->emp_id); ?>')">😧</span>

                                                    </div>
                                                    <div class="emoji-row">
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128552','<?php echo e($data['employee']->emp_id); ?>')">😨</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128553','<?php echo e($data['employee']->emp_id); ?>')">😩</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128554','<?php echo e($data['employee']->emp_id); ?>')">😪</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128555','<?php echo e($data['employee']->emp_id); ?>')">😫</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128556','<?php echo e($data['employee']->emp_id); ?>')">😬</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128557','<?php echo e($data['employee']->emp_id); ?>')">😭</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128558','<?php echo e($data['employee']->emp_id); ?>')">😮</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128559','<?php echo e($data['employee']->emp_id); ?>')">😯</span>

                                                    </div>
                                                    <div class="emoji-row">
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128560','<?php echo e($data['employee']->emp_id); ?>')">😰</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128561','<?php echo e($data['employee']->emp_id); ?>')">😱</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128562','<?php echo e($data['employee']->emp_id); ?>')">😲</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128563','<?php echo e($data['employee']->emp_id); ?>')">😳</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128564','<?php echo e($data['employee']->emp_id); ?>')">😴</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128565','<?php echo e($data['employee']->emp_id); ?>')">😵</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128566','<?php echo e($data['employee']->emp_id); ?>')">😶</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128567','<?php echo e($data['employee']->emp_id); ?>')">😷</span>

                                                    </div>
                                                    <div class="emoji-row">
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128075','<?php echo e($data['employee']->emp_id); ?>')">👋</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#9995','<?php echo e($data['employee']->emp_id); ?>')">✋</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128400','<?php echo e($data['employee']->emp_id); ?>')">🖐</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128406','<?php echo e($data['employee']->emp_id); ?>'))">🖖</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#129306','<?php echo e($data['employee']->emp_id); ?>'))">🤚</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#9757','<?php echo e($data['employee']->emp_id); ?>'))">☝</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128070','<?php echo e($data['employee']->emp_id); ?>')">👆</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128071','<?php echo e($data['employee']->emp_id); ?>')">👇</span>


                                                    </div>
                                                    <div class="emoji-row">
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128072','<?php echo e($data['employee']->emp_id); ?>')">👈</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128073','<?php echo e($data['employee']->emp_id); ?>')">👉</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128405','<?php echo e($data['employee']->emp_id); ?>')">🖕</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#9994','<?php echo e($data['employee']->emp_id); ?>')">✊</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128074','<?php echo e($data['employee']->emp_id); ?>'))">👊</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128077','<?php echo e($data['employee']->emp_id); ?>'))">👍 </span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128078','<?php echo e($data['employee']->emp_id); ?>')">👎</span>

                                                    </div>
                                                    <div class="emoji-row">
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#129307','<?php echo e($data['employee']->emp_id); ?>')">🤛</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#9996','<?php echo e($data['employee']->emp_id); ?>')">✌</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128076','<?php echo e($data['employee']->emp_id); ?>')">👌</span>
                                                        <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#129295','<?php echo e($data['employee']->emp_id); ?>')">🤏</span>


                                                    </div>

                                    </form>
                                </div>
                            </div>
                        </div>





                        <div class="col-md-8 p-0">
                            <form wire:submit.prevent="add_comment('<?php echo e($data['employee']->emp_id); ?>')">
                                <?php echo csrf_field(); ?>
                                <div class="row m-0">
                                    <div class="col-md-3 mb-2">
                                        <div style="display: flex; align-items: center;">
                                            <span>
                                                <i class="comment-icon">💬</i>
                                            </span>
                                            <span style="margin-left: 5px;">
                                                <a href="#" onclick="comment(<?php echo e($index); ?>)" style="font-size: 10px;">Comment</a>
                                            </span>
                                        </div>

                                    </div>

                                    <div class="col-md-8 p-0 mb-2" style="margin-left:10px">
                                        <div class="replyDiv row m-0" id="replyDiv_<?php echo e($index); ?>" style="display: none;" style="margin-left:-20px">
                                            <div class="col-md-8">
                                                <textarea wire:model="newComment" placeholder="Post comment something here" style="font-size:10px" name="comment" class="form-control"></textarea>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" class="btn btn-primary" style="text-align: center; line-height: 10px; font-size:12px;margin-left:-10px;background-color:rgb(2, 17, 79);" value="comment" wire:target="add_comment">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                  
     
     
                    <div class="row m-0">
    <?php
    $currentCardComments = $comments->where('card_id', $data['employee']->emp_id)->sortByDesc('created_at');
    ?>
    <!--[if BLOCK]><![endif]--><?php if($currentCardComments && $currentCardComments->count() > 0): ?>
        <div class="m-0 mt-2 px-2" style="overflow-y:auto; max-height:150px;">
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $currentCardComments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mb-3" style="display: flex;gap:10px;align-items:center;">
                    <!--[if BLOCK]><![endif]--><?php if($comment->employee): ?>
                        <!--[if BLOCK]><![endif]--><?php if($comment->employee->image): ?>
                            <img style="border-radius: 50%;" height="25" width="25" src="<?php echo e(asset('storage/' . $comment->employee->image)); ?>">
                        <?php else: ?>
                            <!--[if BLOCK]><![endif]--><?php if($comment->employee->gender == "Male"): ?>
                                <img src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="" height="25" width="25">
                            <?php elseif($comment->employee->gender == "Female"): ?>
                                <img src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBW" alt="" height="25" width="25">
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <div class="comment" style="font-size: 10px;">
                            <b style="color:#778899; font-weight:500; font-size: 10px;"><?php echo e(ucwords(strtolower($comment->employee->first_name))); ?> <?php echo e(ucwords(strtolower($comment->employee->last_name))); ?></b>
                            <p class="mb-0" style="font-size: 11px;">
                                <?php echo e(ucfirst($comment->comment)); ?>

                            </p>
                        </div>
                    <?php elseif($comment->hr): ?>
                    <!--[if BLOCK]><![endif]--><?php if($comment->hr->image): ?>
                            <img style="border-radius: 50%;" height="25" width="25" src="<?php echo e(asset('storage/' . $comment->hr->image)); ?>">
                        <?php else: ?>
                            <!--[if BLOCK]><![endif]--><?php if($comment->hr->gender == "Male"): ?>
                                <img src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="" height="25" width="25">
                            <?php elseif($comment->hr->gender == "Female"): ?>
                                <img src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBW" alt="" height="25" width="25">
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <div class="comment" style="font-size: 10px;">
                            <b style="color:#778899; font-weight:500; font-size: 10px;"><?php echo e(ucwords(strtolower($comment->hr->first_name))); ?> <?php echo e(ucwords(strtolower($comment->hr->last_name))); ?></b>
                            <p class="mb-0" style="font-size: 11px;">
                                <?php echo e(ucfirst($comment->comment)); ?>

                            </p>
                        </div>
                    <?php else: ?>
                        <div class="comment" style="font-size: 10px;">
                            <b style="color:#778899; font-weight:500; font-size: 10px;">Unknown Employee</b>
                            <p class="mb-0" style="font-size: 11px;">
                                <?php echo e(ucfirst($comment->comment)); ?>

                            </p>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>


                    </div>
                    <?php elseif($data['type'] === 'hire_date' ): ?>
               
                    <div class="hire-card  mt-2">
                        <!-- Upcoming Birthdays List -->
                        <div class="F mb-4" style="padding: 15px; background-color: white; border-radius: 5px; border: 1px solid #CFCACA; color: #3b4452; margin-top: 5px">
                            <div class="row m-0">
                                <div class="col-md-4 mb-2" style="text-align: center;">
                                <img src="<?php echo e($empCompanyLogoUrl); ?>" alt="Company Logo">
                                </div>
                                <div class="col-md-4 m-auto" style="color: #677A8E; font-size: 14px;font-weight: 100px; text-align: center;">
                                    Group Events
                                </div>
                                <div class="c col-md-4 m-auto" style="font-size: 12px; font-weight: 100px; color: #9E9696; text-align: center;">
                            <?php echo e(date('d M Y', strtotime($data['employee']->hire_date))); ?>

                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-md-4">
                            <img src="<?php echo e(asset('images/New_team_members_gif.gif')); ?>" alt="Image Description" style="width: 200px;">
                        </div>
                        <div class="col-md-8 m-auto">
                            <p style="font-size:12px;color:#778899;font-weight:normal;margin-top:10px;">
                                <?php
                                $hireDate = $data['employee']->hire_date;
                                $yearsSinceHire = date('Y') - date('Y', strtotime($hireDate));
                                $yearText = $yearsSinceHire == 1 ? 'year' : 'years';
                                ?>

                                Our congratulations to <?php echo e(ucwords(strtoupper($data['employee']->first_name))); ?>

                                <?php echo e(ucwords(strtoupper($data['employee']->last_name))); ?>,on completing <?php echo e($yearsSinceHire); ?> successful <?php echo e($yearText); ?>.


                            </p>
                            <div style="display: flex; align-items: center;">
                                <!--[if BLOCK]><![endif]--><?php if($data['employee']->image): ?>
                                <img style="border-radius: 50%; margin-left: 10px;" height="35" width="35" src="<?php echo e(asset('storage/' . $data['employee']->image)); ?>">
                                <?php else: ?>
                                <div class="employee-profile-image-container">
                                    <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" class="employee-profile-image-placeholder" style="border-radius:50%;" height="35px" width="35px" alt="Default Image">
                                </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <p style="margin-left: 10px; font-size: 12px; color: #47515b;margin-bottom:0;font-weight:600;">
                                    Congratulations, <?php echo e(ucwords(strtoupper($data['employee']->first_name))); ?>

                                    <?php echo e(ucwords(strtoupper($data['employee']->last_name))); ?>

                                </p>
                            </div>
                        </div>

                   
                    </div>

                    <div class="col-md-2 p-0" style="margin-left: 9px;">
                        <?php
                        $currentCardEmojis = $storedemojis->where('emp_id', $data['employee']->emp_id);
                        $emojisCount = $currentCardEmojis->count();
                        $lastTwoEmojis = $currentCardEmojis->slice(max($emojisCount - 2, 0))->reverse();
                        $uniqueNames = [];
                        ?>

                        <!--[if BLOCK]><![endif]--><?php if($currentCardEmojis && $emojisCount > 0): ?>
                        <div style="white-space: nowrap;">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $lastTwoEmojis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $emoji): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span style="font-size: 16px;margin-left:-10px;"><?php echo e($emoji->emoji); ?></span>
                            <!--[if BLOCK]><![endif]--><?php if(!$loop->last): ?>

                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $lastTwoEmojis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $emoji): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $fullName = ucwords(strtolower($emoji->first_name)) . ' ' . ucwords(strtolower($emoji->last_name));
                            ?>
                            <!--[if BLOCK]><![endif]--><?php if(!in_array($fullName, $uniqueNames)): ?>
                            <!--[if BLOCK]><![endif]--><?php if(!$loop->first): ?>
                            <span>,</span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <span style="font-size: 8px;"> <?php echo e($fullName); ?></span>
                            <?php $uniqueNames[] = $fullName; ?>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                            <!--[if BLOCK]><![endif]--><?php if(count($uniqueNames) > 0): ?>
                            <span style="font-size:8px"> reacted</span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        </div>


                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    </div>
                    <div class="w-90" style="border-top: 1px solid #E8E5E4; margin: 10px;"></div>
                    <div class="row" style="display: flex;">
                        <div class="col-md-3" style="display: flex;">
                            <form wire:submit.prevent="add_emoji('<?php echo e($data['employee']->emp_id); ?>')">
                                <?php echo csrf_field(); ?>
                                <div class="emoji-container">
                                    <span id="smiley-<?php echo e($index); ?>" class="emoji-trigger" onclick="showEmojiList(<?php echo e($index); ?>)" style="font-size: 16px;cursor:pointer">
                                        😊




                                        <!-- List of emojis -->
                                        <div id="emoji-list-<?php echo e($index); ?>" class="emoji-list" style="display: none;background:white; border-radius:5px; border:1px solid silver; max-height:170px;width:220px; overflow-y: auto;">
                                            <div class="emoji-row">
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128512','<?php echo e($data['employee']->emp_id); ?>')">😀</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128513','<?php echo e($data['employee']->emp_id); ?>')">😁</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128514','<?php echo e($data['employee']->emp_id); ?>')">😂</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128515','<?php echo e($data['employee']->emp_id); ?>')">😃</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128516','<?php echo e($data['employee']->emp_id); ?>')">😄</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128517','<?php echo e($data['employee']->emp_id); ?>')">😅</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128518','<?php echo e($data['employee']->emp_id); ?>')">😆</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128519','<?php echo e($data['employee']->emp_id); ?>')">😇</span>

                                            </div>
                                            <div class="emoji-row">
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128520','<?php echo e($data['employee']->emp_id); ?>')">😈</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128521','<?php echo e($data['employee']->emp_id); ?>')">😉</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128522','<?php echo e($data['employee']->emp_id); ?>')">😊</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128523','<?php echo e($data['employee']->emp_id); ?>')">😋</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128525','<?php echo e($data['employee']->emp_id); ?>')">😍</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128524','<?php echo e($data['employee']->emp_id); ?>')">😌</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128526','<?php echo e($data['employee']->emp_id); ?>'))">😎</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128527','<?php echo e($data['employee']->emp_id); ?>'))">😏</span>

                                            </div>
                                            <div class="emoji-row">
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128528','<?php echo e($data['employee']->emp_id); ?>')">😐</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128529','<?php echo e($data['employee']->emp_id); ?>')">😑 </span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128530','<?php echo e($data['employee']->emp_id); ?>')">😒</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128531','<?php echo e($data['employee']->emp_id); ?>')">😓</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128532','<?php echo e($data['employee']->emp_id); ?>')">😔</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128533','<?php echo e($data['employee']->emp_id); ?>')">😕</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128534','<?php echo e($data['employee']->emp_id); ?>')">😖</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128535','<?php echo e($data['employee']->emp_id); ?>')">😗</span>

                                            </div>
                                            <div class="emoji-row">
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128536','<?php echo e($data['employee']->emp_id); ?>')">😘</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128537')">😙</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128538','<?php echo e($data['employee']->emp_id); ?>')">😚</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128539','<?php echo e($data['employee']->emp_id); ?>')">😛</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128540','<?php echo e($data['employee']->emp_id); ?>')">😜</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128541','<?php echo e($data['employee']->emp_id); ?>')">😝</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128542','<?php echo e($data['employee']->emp_id); ?>')">😞</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128543','<?php echo e($data['employee']->emp_id); ?>')">😟</span>

                                            </div>
                                            <div class="emoji-row">
                                                <!-- Add more emojis here -->
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128544','<?php echo e($data['employee']->emp_id); ?>')">😠</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128545','<?php echo e($data['employee']->emp_id); ?>')">😡 </span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128546','<?php echo e($data['employee']->emp_id); ?>')">😢</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128547','<?php echo e($data['employee']->emp_id); ?>')">😣</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128548','<?php echo e($data['employee']->emp_id); ?>')">😤</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128549','<?php echo e($data['employee']->emp_id); ?>')">😥</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128550','<?php echo e($data['employee']->emp_id); ?>')">😦</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128551','<?php echo e($data['employee']->emp_id); ?>')">😧</span>

                                            </div>
                                            <div class="emoji-row">
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128552','<?php echo e($data['employee']->emp_id); ?>')">😨</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128553','<?php echo e($data['employee']->emp_id); ?>')">😩</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128554','<?php echo e($data['employee']->emp_id); ?>')">😪</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128555','<?php echo e($data['employee']->emp_id); ?>')">😫</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128556','<?php echo e($data['employee']->emp_id); ?>')">😬</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128557','<?php echo e($data['employee']->emp_id); ?>')">😭</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128558','<?php echo e($data['employee']->emp_id); ?>')">😮</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128559','<?php echo e($data['employee']->emp_id); ?>')">😯</span>

                                            </div>
                                            <div class="emoji-row">
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128560','<?php echo e($data['employee']->emp_id); ?>')">😰</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128561','<?php echo e($data['employee']->emp_id); ?>')">😱</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128562','<?php echo e($data['employee']->emp_id); ?>')">😲</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128563','<?php echo e($data['employee']->emp_id); ?>')">😳</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128564','<?php echo e($data['employee']->emp_id); ?>')">😴</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128565','<?php echo e($data['employee']->emp_id); ?>')">😵</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128566','<?php echo e($data['employee']->emp_id); ?>')">😶</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128567','<?php echo e($data['employee']->emp_id); ?>')">😷</span>

                                            </div>
                                            <div class="emoji-row">
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128075','<?php echo e($data['employee']->emp_id); ?>')">👋</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#9995','<?php echo e($data['employee']->emp_id); ?>')">✋</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128400','<?php echo e($data['employee']->emp_id); ?>')">🖐</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128406','<?php echo e($data['employee']->emp_id); ?>'))">🖖</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#129306','<?php echo e($data['employee']->emp_id); ?>'))">🤚</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#9757','<?php echo e($data['employee']->emp_id); ?>'))">☝</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128070','<?php echo e($data['employee']->emp_id); ?>')">👆</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="selectEmoji('&#128071','<?php echo e($data['employee']->emp_id); ?>')">👇</span>


                                            </div>
                                            <div class="emoji-row">
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128072','<?php echo e($data['employee']->emp_id); ?>')">👈</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128073','<?php echo e($data['employee']->emp_id); ?>')">👉</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128405','<?php echo e($data['employee']->emp_id); ?>')">🖕</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#9994','<?php echo e($data['employee']->emp_id); ?>')">✊</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128074','<?php echo e($data['employee']->emp_id); ?>'))">👊</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128077','<?php echo e($data['employee']->emp_id); ?>'))">👍 </span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128078','<?php echo e($data['employee']->emp_id); ?>')">👎</span>

                                            </div>
                                            <div class="emoji-row">
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#129307','<?php echo e($data['employee']->emp_id); ?>')">🤛</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#9996','<?php echo e($data['employee']->emp_id); ?>')">✌</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#128076','<?php echo e($data['employee']->emp_id); ?>')">👌</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="selectEmoji('&#129295','<?php echo e($data['employee']->emp_id); ?>')">🤏</span>


                                            </div>

                            </form>
                        </div>
                    </div>
                </div>




                <div class="col-md-8 p-0">
                    <form wire:submit.prevent="createcomment('<?php echo e($data['employee']->emp_id); ?>')">
                        <?php echo csrf_field(); ?>
                        <div class="row m-0">
                            <div class="col-md-3 mb-2" style="margin-left:10px">

                                <div style="display: flex;">
                                    <span>
                                        <i class="comment-icon">💬</i>
                                    </span>
                                    <span style="margin-left: 5px;">
                                        <a href="#" onclick="comment(<?php echo e($index); ?>)" style="font-size: 10px;background:">Comment</a>
                                    </span>
                                </div>

                            </div>
                            <div class="col-md-8 p-0 mb-2" style="margin-left:10px;">
                                <div class="replyDiv row m-0" id="replyDiv_<?php echo e($index); ?>" style="display: none;">
                                    <div class="col-md-9">
                                        <textarea wire:model="newComment" placeholder="Post comment something here" style="font-size: 10px;" name="comment" class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="submit" class="btn btn-primary" style="text-align: center; line-height: 10px; font-size: 10px; margin-left: -20px;background-color:rgb(2, 17, 79);" value="Comment" wire:target="addcomment">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>



                                </div>
                            </div>
                               <div class="row m-0">
                               <?php
                    $currentCardComments = $addcomments->where('card_id', $data['employee']->emp_id)->sortByDesc('created_at');
                    ?>
                         <!--[if BLOCK]><![endif]--><?php if($currentCardComments && $currentCardComments->count() > 0): ?>
                        <div class="m-0 mt-2 px-2" style="overflow-y:auto; max-height:150px;">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $currentCardComments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       
                    <div class="mb-3" style="display: flex;gap:10px;align-items:center;">
                        <img style="border-radius: 50%; " height="25" width="25" src="<?php echo e(asset('storage/' . $comment->employee->image)); ?>">
                        <div class="comment" style="font-size: 10px;">
                            <b style="color:#778899;font-weight:500;font-size:10px;"><?php echo e(ucwords(strtolower($comment->employee->first_name))); ?> <?php echo e(ucwords(strtolower($comment->employee->last_name))); ?></b>
                            <p class="mb-0" style="font-size: 11px;">
                                <?php echo e(ucfirst($comment->addcomment)); ?>

                            </p>

                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <?php else: ?>
                        <p style="font-size: 10px;">No comments available.</p>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                        </div>
                  </div>
                  
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->



</div>
</div>
</div>



<style>
    /* Define the blue background color for the checked state */
    .input[type="radio"]:checked+.custom-radio-button {
        background-color: blue;
    }

    .feather {
        display: inline-block;
        vertical-align: middle;
    }

    .text-salmon-400 {
        fill: salmon;
        /* Change the color as needed */
    }

    .stroke-1 {
        stroke-width: 1px;
        /* Adjust the stroke width as needed */
    }

    .icon-container {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 2px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: #D8D8D8;
        /* You can change this to any desired background color */
    }
    .sort {
            border: none;
            background: none;
            font-size: 1rem;
            margin-left: 2px;
            padding: 2px ;
            align-items: end;
        }
        .sort:focus {
            outline: none;
        }
    .feather {
        width: 1rem;
        height: 1rem;
        color: #6B46C1;
        /* You can change this to any desired icon color */
    }

    .activities:hover {
        background-color: #e1e7f0;
        height: 30px;
        width: 100%;

        cursor:pointer,
    }

    .posts:hover {
        background-color: #e1e7f0;
        height: 30px;
        width: 100%;
        cursor:pointer,
    }
</style>
<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script> -->
<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
<script>
    document.addEventListener('livewire:load', function() {
        // Listen for clicks on emoji triggers and toggle the emoji list
        document.querySelectorAll('.emoji-trigger').forEach(trigger => {
            trigger.addEventListener('click', function() {
                var index = this.dataset.index;
                var emojiList = document.getElementById('emoji-list-' + index);
                emojiList.style.display = (emojiList.style.display === "none" || emojiList.style.display === "") ? "block" : "none";
            });
        });
    })

    // Hide emoji list when an emoji is selected
    document.querySelectorAll('.emoji-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.emoji-list').forEach(list => {
                list.style.display = "none";
            });
        });
    });

    function showEmojiList(index) {
        var emojiList = document.getElementById('emoji-list-' + index);
        if (emojiList.style.display === "none" || emojiList.style.display === "") {
            emojiList.style.display = "block";
        } else {
            emojiList.style.display = "none";
        }
    }

    function comment(index) {
        var div = document.getElementById('replyDiv_' + index);
        if (div.style.display === 'none') {
            div.style.display = 'flex';
        } else {
            div.style.display = 'none';
        }
    }






    function subReply(index) {
        var div = document.getElementById('subReplyDiv_' + index);
        if (div.style.display === 'none') {
            div.style.display = 'flex';
        } else {
            div.style.display = 'none';
        }
    }


    document.querySelector('emoji-picker').addEventListener('emoji-click', event => console.log(event.detail));
    // JavaScript function to toggle arrow icon visibility
    // JavaScript function to toggle arrow icon and dropdown content visibility
    // JavaScript function to toggle dropdown content visibility and arrow rotation
    function toggleDropdown(contentId, arrowId) {
        var dropdownContent = document.getElementById(contentId);
        var arrowSvg = document.getElementById(arrowId);

        if (dropdownContent.style.display === 'none') {
            dropdownContent.style.display = 'block';
            arrowSvg.style.transform = 'rotate(180deg)';
        } else {
            dropdownContent.style.display = 'none';
            arrowSvg.style.transform = 'rotate(0deg)';
        }
    }


    function reply(caller) {
        var replyDiv = $(caller).siblings('.replyDiv');
        $('.replyDiv').not(replyDiv).hide(); // Hide other replyDivs
        replyDiv.toggle(); // Toggle display of clicked replyDiv
    }


    function react(reaction) {
        // Handle reaction logic here, you can send it to the server or perform any other action
        console.log('Reacted with: ' + reaction);
    }
</script>

<script>
    function addEmoji(emoji) {
        let inputEle = document.getElementById('input');

        input.value += emoji;
    }

    function toggleEmojiDrawer() {
        let drawer = document.getElementById('drawer');

        if (drawer.classList.contains('hidden')) {
            drawer.classList.remove('hidden');
        } else {
            drawer.classList.add('hidden');
        }
    }

    function toggleDropdown(contentId, arrowId) {
        var content = document.getElementById(contentId);
        var arrow = document.getElementById(arrowId);

        if (content.style.display === 'block') {
            content.style.display = 'none';
            arrow.classList.remove('rotate');
        } else {
            content.style.display = 'block';
            arrow.classList.add('rotate');
        }

        // Close the dropdown when clicking on a link
        content.addEventListener('click', function(event) {
            if (event.target.tagName === 'A') {
                content.style.display = 'none';
                arrow.classList.remove('rotate');
            }
        });
    }
</script>
<script>
        $(document).ready(function() {
            $('input[name="radio"]').on('change', function() {
                var url = $(this).data('url');
                window.location.href = url;
            });

            // Ensures the corresponding radio button is selected based on current URL
            var currentUrl = window.location.pathname;
            $('input[name="radio"]').each(function() {
                if ($(this).data('url') === currentUrl) {
                    $(this).prop('checked', true);
                }
            });

            // Click handler for the custom radio label to trigger the radio input change
            $('.custom-radio-label').on('click', function() {
                $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
            });
        });
    </script>
<?php $__env->startPush('scripts'); ?>
<script>
    Livewire.on('commentAdded', () => {
        // Reload comments after adding a new comment
        Livewire.emit('refreshComments');
    });
</script>
<?php $__env->stopPush(); ?>
<script>
    // Add event listener to menu items
    const menuItems = document.querySelectorAll('.menu-item');
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remove background color from all menu items
            menuItems.forEach(item => {
                item.classList.remove('selected');
            });
            // Add background color to the clicked menu item
            this.classList.add('selected');
        });
    });
</script>
<script>
    function selectEmoji(emoji, empId) {
        // Your existing logic to select an emoji

        // Toggle the emoji list visibility using the showEmojiList function
        showEmojiList();
    }
    // Function to show the emoji list when clicking on the smiley emoji
    function showEmojiList(index) {
        var emojiList = document.getElementById('emoji-list-' + index);
        if (emojiList.style.display === "none") {
            emojiList.style.display = "block";
        } else {
            emojiList.style.display = "none";
        }
    }
</script>
<script>
    function addEmoji(emoji_reaction, empId) {
        // Your existing logic to select an emoji

        // Toggle the emoji list visibility using the showEmojiList function
        showEmojiList();
    }
    // Function to show the emoji list when clicking on the smiley emoji
    function showEmojiList(index) {
        var emojiList = document.getElementById('emoji-list-' + index);
        if (emojiList.style.display === "none") {
            emojiList.style.display = "block";
        } else {
            emojiList.style.display = "none";
        }
    }
</script>


<style>
    /* Define CSS for the menu items */
    .menu-item {
        transition: background-color 0.3s ease;
    }

    /* Define CSS for the menu items on hover */
    .menu-item:hover {
        background-color: #e1e7f0;
        height: 30px;
        width: 130%;
    }

    /* CSS for radio-wrapper */
    .radio-wrapper {
        display: inline-block;
        margin-right: 10px;
        /* Adjust margin as needed */
        cursor: pointer;
    }
    .medium-header {
    border-left-width: 0.125rem;
    font-weight: 600;
    font-size: 0.875rem;
    line-height: 1.25rem;
    color: var(--e-color-emoji-text);
  
  margin-left: 20px;
  margin-top:5px
}

    /* CSS for labels */
    .radio-label {
        display: inline-block;
        padding: 8px 12px;
        /* Adjust padding as needed */
        border-radius: 4px;
        /* Rounded corners */
        transition: background-color 0.3s ease;
        /* Smooth transition */
    }

    /* CSS for label hover effect */
    .radio-label:hover {
        background-color: #e1e7f0;
        /* Change background color on hover */
    }

    /* CSS for when radio button is checked */
    .input[type="radio"]:checked+.radio-label {
        background-color: #e1e7f0;
        /* Change background color when checked */
    }

    /* Ensure radio button and text remain on the same line */
    input[type="radio"] {
        vertical-align: middle;
    }

    /* Add this CSS to your main CSS file or in your Livewire component's style tag */
    :root {
        --e-color-border: #e1e1e1;
        --e-color-emoji-text: #666;
        --e-color-border-emoji-hover: #e1e1e1;
        --e-color-bg: #fff;
        --e-bg-emoji-hover: #f8f8f8;
        --e-size-emoji-text: 16px;
        --e-width-emoji-img: 20px;
        --e-height-emoji-img: 20px;
        --e-max-width: 288px;
    }
</style>



<script>
    document.addEventListener('livewire:load', function() {
        // Listen for clicks on emoji triggers and toggle the emoji list
        document.querySelectorAll('.emoji-trigger').forEach(trigger => {
            trigger.addEventListener('click', function() {
                var index = this.dataset.index;
                var emojiList = document.getElementById('emoji-list-' + index);
                emojiList.style.display = (emojiList.style.display === "none" || emojiList.style.display === "") ? "block" : "none";
            });
        });

        // Hide emoji list when an emoji is selected
        document.querySelectorAll('.emoji-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.emoji-list').forEach(list => {
                    list.style.display = "none";
                });
            });
        });
    });
</script>


<script>
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('.cus-button');
        dropdowns.forEach(function(dropdown) {
            if (!dropdown.contains(event.target)) {
                const dropdownContent = dropdown.nextElementSibling;
                dropdownContent.style.display = 'none';
            }
        });
    });

    function toggleDropdown(dropdownId, arrowId) {
        const dropdownContent = document.getElementById(dropdownId);
        const arrowSvg = document.getElementById(arrowId);

        if (dropdownContent.style.display === 'block') {
            dropdownContent.style.display = 'none';
            arrowSvg.classList.remove('arrow-rotate');
        } else {
            dropdownContent.style.display = 'block';
            arrowSvg.classList.add('arrow-rotate');
        }
    }
</script>
<script>
    window.addEventListener('post-creation-failed', event => {
        alert('Employees do not have permission to create a post.');
    });
</script>

<script>
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('.cus-button');
        dropdowns.forEach(function(dropdown) {
            if (!dropdown.contains(event.target)) {
                const dropdownContent = dropdown.nextElementSibling;
                dropdownContent.style.display = 'none';
            }
        });
    });

    function toggleDropdown(dropdownId, arrowId) {
        const dropdownContent = document.getElementById(dropdownId);
        const arrowSvg = document.getElementById(arrowId);

        if (dropdownContent.style.display === 'block') {
            dropdownContent.style.display = 'none';
            arrowSvg.classList.remove('arrow-rotate');
        } else {
            dropdownContent.style.display = 'block';
            arrowSvg.classList.add('arrow-rotate');
        }
    }
    document.querySelectorAll('.custom-radio-label a').forEach(link => {
    link.addEventListener('click', function(e) {
        // Ensure no preventDefault() call is here unless necessary for custom handling
    });
});

</script>
<?php $__env->startPush('scripts'); ?>
<script src="dist/emoji-popover.umd.js"></script>
<link rel="stylesheet" href="dist/style.css" />

<script>
    document.addEventListener('livewire:load', function() {
        const el = new EmojiPopover({
            button: '.picker',
            targetElement: '.emoji-picker',
            emojiList: [{
                    value: '🤣',
                    label: 'laugh and cry'
                },
                // Add more emoji objects here
            ]
        });

        el.onSelect(l => {
            document.querySelector(".emoji-picker").value += l;
        });

        // Toggle the emoji picker popover manually
        document.querySelector('.picker').addEventListener('click', function() {
            el.toggle();
        });
    });
</script>
<?php $__env->stopPush(); ?>


<script>
    function filterDropdowns() {
        var input, filter, ul, li, a, i;
        input = document.getElementById('filterSearch');
        filter = input.value.toUpperCase();
        uls = document.querySelectorAll('.w-full.visible ul');
        for (i = 0; i < uls.length; i++) {
            ul = uls[i];
            lis = ul.getElementsByTagName('a');
            for (j = 0; j < lis.length; j++) {
                a = lis[j];
                if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    lis[j].style.display = "";
                } else {
                    lis[j].style.display = "none";
                }
            }
        }
    }
</script>

</div>
</div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/feeds.blade.php ENDPATH**/ ?>