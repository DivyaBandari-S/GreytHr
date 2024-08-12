<div>
<!--[if BLOCK]><![endif]--><?php if( $employeeDetails->isEmpty()): ?> 
<p>No employee details found.</p>

<?php else: ?>
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
            <!--[if BLOCK]><![endif]--><?php if(auth('emp')->check() || auth('hr')->check()): ?>
    <?php
        // Determine the employee ID based on the authentication guard
        $empEmployeeId = auth('emp')->check() ? auth('emp')->user()->emp_id : auth('hr')->user()->hr_emp_id;

        // Fetch the employee details from EmployeeDetails model
        $employeeDetails = \App\Models\EmployeeDetails::where('emp_id', $empEmployeeId)->first();
    ?>

    <!--[if BLOCK]><![endif]--><?php if($employeeDetails && $employeeDetails->image): ?>
        <img style="border-radius: 50%; margin-left: 10px" height="50" width="50" src="<?php echo e($employeeDetails->image_url); ?>" alt="Employee Image">
    <?php else: ?>
        <!--[if BLOCK]><![endif]--><?php if($employeeDetails && $employeeDetails->gender == "Male"): ?>
            <img style="border-radius: 50%; margin-left: 10px" height="50" width="50" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="Default Male Image">
        <?php elseif($employeeDetails && $employeeDetails->gender == "Female"): ?>
            <img style="border-radius: 50%; margin-left: 10px" height="50" width="50" src="https://th.bing.com/th/id/OIP.16PsNaosyhVxpn3hmvC46AHaHa?w=199&h=199&c=7&r=0&o=5&dpr=1.5&pid=1.7" alt="Default Female Image">
        <?php else: ?>
        <img style="border-radius: 50%; margin-left: 10px" height="50" width="50" src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" alt="Default Image">
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php else: ?>
    <p>User is not authenticated.</p>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->





      
            </div>
            <div class="col-md-10 mt-2 bg-white d-flex align-items-center justify-content-between">
                <div style="color:#3b4452;">
                <!--[if BLOCK]><![endif]--><?php if(auth()->guard('emp')->check()): ?>
    <span class="text-base">Hey <?php echo e(ucwords(strtolower(auth()->guard('emp')->user()->first_name))); ?> <?php echo e(ucwords(strtolower(auth()->guard('emp')->user()->last_name))); ?></span>
<?php elseif(auth()->guard('hr')->check()): ?>
    <span class="text-base">Hey <?php echo e(ucwords(strtolower(auth()->guard('hr')->user()->employee_name))); ?></span>
<?php else: ?>
    <p>No employee details available.</p>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <div class="text-xs" style="color:#3b4452;">Ready to dive in?</div>
                </div>
                <div>
                    <button wire:click="addFeeds" class="flex flex-col justify-between items-start group w-20 h-20 p-1 rounded-md border border-purple-200" style="background-color: #F1ECFC;border:1px solid purple;border-radius:5px;width:130px">
                        <div class="w-6 h-6 rounded bg-purple-200">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file stroke-current group-hover:text-purple-600 stroke-1 text-purple-400">
                                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                <polyline points="13 2 13 9 20 9"></polyline>
                            </svg>
                        </div>
                        <div class="row  mt-1">
                            <div class="text-left text-xs" style="margin-left:5px" wire:click="addFeeds">Create Posts</div>
                      
                        </div>
                    </button>

                    <!--[if BLOCK]><![endif]--><?php if($showFeedsDialog): ?>
                    <div class="modal" tabindex="-1" role="dialog" style="display: block; color: #3b4452; font-family: Montserrat, sans-serif;">
    <div class="modal-dialog modal-dialog-centered" role="document" style="color: #3b4452;">
        <div class="modal-content" style="border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <div class="modal-header" style="border-bottom: 1px solid #ccc; padding: 15px;">
                <!-- <h5 class="modal-title" style="font-weight: 500; font-size: 1.25rem;color:#3b4452">Creating a Post</h5> -->
               <span style="justify-content-end">
                <image src="https://www3.nhk.or.jp/nhkworld/en/tv/bento/season5/images/top_info_20190412_5_pc.png" >
               </span>
            </div>

            <!--[if BLOCK]><![endif]--><?php if(Session::has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert" 
                    style="font-size: 0.875rem; width: 90%; margin: 10px auto; padding: 10px; border-radius:4px; background-color: #f8d7da; color: #721c24;">
                    <?php echo e(Session::get('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="margin-left: 10px;"></button>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <form wire:submit.prevent="submit">
                <div class="modal-body" style="padding: 20px;">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="category" style="font-weight: 600; color: #3b4452;">Select Category:</label>
                        <select wire:model="category" class="form-select" id="category" style="border: 1px solid #ccc; border-radius: 4px; padding: 10px; font-size: 0.875rem;color:#3b4452;margin-top:5px">
                            <option value="Appreciations">Appreciations</option>
                            <option value="Buy/Sell/Rent">Buy/Sell/Rent</option>
                            <option value="Companynews">Company News</option>
                            <option value="Events">Events</option>
                            <option value="Everyone">Everyone</option>
                            <option value="Hyderabad">Hyderabad</option>
                            <option value="US">US</option>
                        </select>
                    </div>

                    <div class="form-group" >
                        <label for="content" style="font-weight: 600; color: #3b4452;">Write something here:</label>
                        <textarea wire:model="description" class="form-control" id="content" rows="2" 
                            style="border: 1px solid #ccc; border-radius: 4px; padding: 10px; font-size: 0.875rem; resize: vertical; width: 100%;margin-left:-240px;;margin-top:5px"
                            placeholder="Enter your description here..."></textarea>
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="attachment" style="font-weight: 600; color: #3b4452;">Upload Attachment:</label>
                        <div style="text-align: start;">
                            <input wire:model="image" type="file" accept="image/*" style="font-size: 12px ;margin-top:5px">
                            <!--[if BLOCK]><![endif]--><?php if($image): ?>
                                <div class="mt-2">
                                    <img src="<?php echo e($image->temporaryUrl()); ?>" height="50" width="50" alt="Image Preview" style="max-width: 100px; border-radius: 4px; border: 1px solid #ccc;">
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="border-top: 1px solid #ccc; ">
                    <div class="d-flex justify-content-center" style="width: 100%;">
                    <button type="button" wire:click="submit" class="submit-btn">Submit</button>
                    <button wire:click="closeFeeds" type="button" class="cancel-btn" style="border:1px solid rgb(2,17,79);margin-left:10px">Cancel</button>

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

            <div class="col-md-4 bg-white p-3" style="border-radius:5px;border:1px solid silver;height:auto;overflow-x: hidden;">

                <p style="font-weight: 500;font-size:13px;color:#47515b;">Filters</p>
                <hr style="width: 100%;border-bottom: 1px solid grey;">


                <p style="font-weight: 500;font-size:13px;color:#47515b;cursor:pointer">Activities</p>
                <div class="activities" style="width: 100%; height: 30px;">
    <label class="custom-radio-label" style="display: flex; align-items: center; padding: 5px; height: 100%;">
        <input type="radio" name="radio" value="activities" checked data-url="/Feeds" onclick="handleRadioChange(this)">
        <div class="feed-icon-container" style="margin-left: 10px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file stroke-current text-purple-400 stroke-1" style="width: 1rem; height: 1rem;">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <rect x="7" y="7" width="3" height="9"></rect>
                <rect x="14" y="7" width="3" height="5"></rect>
            </svg>
        </div>
        <span class="custom-radio-button bg-blue" style="margin-left: 10px; font-size: 8px;"></span>
        <span style="color: #778899; font-size: 12px; font-weight: 500; margin-left: 5px;">All Activities</span>
    </label>
</div>


<div class="posts" style="width: 100%; height: 30px;">
    <label class="custom-radio-label" style="display: flex; align-items: center; padding: 5px; height: 100%;">
        <!--[if BLOCK]><![endif]--><?php if(auth()->guard('emp')->check()): ?>
            <input type="radio" id="radio-emp" name="radio"  value="posts" data-url="/everyone" onclick="handleRadioChange(this)">
        <?php elseif(auth()->guard('hr')->check()): ?>
            <input type="radio" id="radio-hr" name="radio"  value="posts" data-url="/hreveryone" onclick="handleRadioChange(this)">
        <?php else: ?>
            <p>No employee details available.</p>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <div class="feed-icon-container" style="margin-left: 10px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file stroke-current text-purple-400 stroke-1" style="width: 1rem; height: 1rem;">
                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                <polyline points="13 2 13 9 20 9"></polyline>
            </svg>
        </div>
        <span class="custom-radio-button bg-blue" style="margin-left: 10px; font-size: 10px;"></span>
        <span style="color: #778899; font-size: 12px; font-weight: 500; margin-left: 5px;">Posts</span>
    </label>
</div>


                <hr style="width: 100%;border-bottom: 1px solid grey;">
                <div style="overflow-y:auto;max-height:300px;overflow-x: hidden;">
                    <div class="row">
                        <div class="col " style="margin: 0px;">
                        <div class="input-group">
    <input wire:model="search" id="filterSearch" onkeyup="filterDropdowns()" style="width:80%;font-size: 10px; border-radius: 5px 0 0 5px;" type="text" class="form-control" placeholder="Search...." aria-label="Search" aria-describedby="basic-addon1">
    <button style="border-radius: 0 5px 5px 0; background-color: rgb(2, 17, 79); color: #fff; border: none;" class="search-btn" type="button" >
        <i style="text-align: center;color:white;margin-left:10px" class="fa fa-search"></i>
    </button>
</div>
                        </div>
                    </div>
                    <div class="w-full visible mt-1" style="margin-top:20px;display:block">
    <div class="cus-button" style="display: flex; justify-content: space-between; width: 100%; padding: 0.5rem;" onclick="toggleDropdown('dropdownContent1', 'arrowSvg1')">
        <span class="text-xs leading-4" style="font-weight:bold; color: grey;">Groups</span>
        <span class="arrow-icon" id="arrowIcon1" style="margin-top:-5px">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down h-1.2x w-1.2x text-secondary-400" id="arrowSvg1" style="color:#3b4452;margin-top:-5px">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </span>
    </div>
    <div id="dropdownContent1" style="display: none;">
        <ul class="d-flex flex-column" style="font-size: 12px; line-height: 1; text-decoration: none; color:black;text-align: left; padding-left: 0;">
            <a class="menu-item" href="/Feeds" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">All Feeds</a>
            <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>
                <a class="menu-item" href="/hreveryone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Every One</a>
            <?php elseif(Auth::guard('emp')->check()): ?>
                <a class="menu-item" href="/everyone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Every One</a>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>
                <a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Events</a>
            <?php elseif(Auth::guard('emp')->check()): ?>
                <a class="menu-item" href="/events" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Events</a>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>
                <a class="menu-item" href="/hreveryone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Company News</a>
            <?php elseif(Auth::guard('emp')->check()): ?>
                <a class="menu-item" href="/everyone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Company News</a>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>
                <a class="menu-item" href="/hreveryone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Appreciation</a>
            <?php elseif(Auth::guard('emp')->check()): ?>
                <a class="menu-item" href="/everyone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Appreciation</a>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>
                <a class="menu-item" href="/hreveryone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Buy/Sell/Rent</a>
            <?php elseif(Auth::guard('emp')->check()): ?>
                <a class="menu-item" href="/everyone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Buy/Sell/Rent</a>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </ul>
    </div>
</div>


                    <div class="w-full visible mt-1" style="margin-top: 20px;display:block">
                        <div class="cus-button" style="display: flex; justify-content: space-between; width: 100%; padding: 0.5rem;">
                            <span class="text-xs leading-4 " style="font-weight: bold;color:grey">Location</span>
                            <span class="arrow-icon" id="arrowIcon2" onclick="toggleDropdown('dropdownContent2', 'arrowSvg2')" style="margin-top:-5px;color:#3b4452;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down h-1.2x w-1.2x text-secondary-400" id="arrowSvg2" style="color:#3b4452;margin-top:-5px">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </div>
                        <div id="dropdownContent2" style="font-size: 12px; line-height: 1; text-decoration: none; color:#3b4452; text-align: left; padding-left: 0; display: none;">
                            <ul  class="d-flex flex-column" style="font-size: 12px; margin: 0; padding: 0;">
                                <b class="menu-item" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">India</b>
                               
                                <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Adilabad</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Adilabad</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]--> 
                             
 <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">Doddaballapur</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Doddaballapur</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]--> 
                                <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Guntur</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Guntur</a>

<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Hyderabad</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">Hyderabad</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->      

 <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">Tirupati</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">Tirupati</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->      
     
 <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">Trivandrum</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">Trivandrum</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->      
 <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;font-weight:700">USA</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;font-weight:700">USA</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->      
 <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">California</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">California</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">New York</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">New York</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->      
     
 <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Hawaii</a>

<?php elseif(Auth::guard('emp')->check()): ?>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Hawaii</a>
 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->                 

                            </ul>
                        </div>
                    </div>
                    <div class="w-full visible mt-1" style="margin-top: 20px;display:block">
    <div class="cus-button" style="display: flex; justify-content: space-between; width: 100%; padding: 0.5rem;">
        <span class="text-xs leading-4" style="font-weight: bold; color: grey;">Department</span>
        <span class="arrow-icon" id="arrowIcon3" onclick="toggleDropdown('dropdownContent3', 'arrowSvg3')" style="margin-top:-5px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down h-1.2x w-1.2x text-secondary-400" id="arrowSvg3" style="color:#3b4452;">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </span>
    </div>
    <div id="dropdownContent3" style="font-size: 12px; line-height: 1; text-decoration: none; color: black; text-align: left; padding-left: 0; display: none;">
        <ul  class="d-flex flex-column" style="font-size: 12px; margin: 0; padding: 0;">
            <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>
                <a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color: #3b4452;">HR</a>
            <?php elseif(Auth::guard('emp')->check()): ?>
                <a class="menu-item" href="/events" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color: #3b4452;">HR</a>
                <a class="menu-item" href="/events" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color: #3b4452;">Operations Team</a>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>
                <a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color: #3b4452;">Operations</a>
            <?php elseif(Auth::guard('emp')->check()): ?>
                <a class="menu-item" href="/events" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color: #3b4452;">Operations</a>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>
                <a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color: #3b4452;">Production Team</a>
            <?php elseif(Auth::guard('emp')->check()): ?>
                <a class="menu-item" href="/events" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color: #3b4452;">Production Team</a>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>
                <a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color: #3b4452;">QA</a>
            <?php elseif(Auth::guard('emp')->check()): ?>
                <a class="menu-item" href="/events" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color: #3b4452;">QA</a>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>
                <a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color: #3b4452;">Sales Team</a>
            <?php elseif(Auth::guard('emp')->check()): ?>
                <a class="menu-item" href="/events" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color: #3b4452;">Sales Team</a>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <!--[if BLOCK]><![endif]--><?php if(Auth::guard('hr')->check()): ?>
                <a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color: #3b4452;">Testing Team</a>
            <?php elseif(Auth::guard('emp')->check()): ?>
                <a class="menu-item" href="/events" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color: #3b4452;">Testing Team</a>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </ul>
    </div>
</div>

                </div>
            </div>
         
            <div class="col m-0" style="max-height: 100vh; overflow-y: auto;scroll-behavior: smooth;">
            <div class="row align-items-center ">
                <div class="col-md-5"  style=" justify-content: flex-start;display:flex">
                <div style="width: 2px; height: 40px; background-color: #97E8DF; margin-right: 10px;"></div>
               <gt-heading _ngcontent-eff-c648="" size="md" class="ng-tns-c648-2 hydrated"></gt-heading>
                <div class="medium-header border-cyan-200" style="margin-left:-1px">All Activities - All Groups</div>
            </div>
            
            <div class="col-md-5 text-right" style="display: flex; justify-content: flex-end; align-items: center; margin-left: 20px;">
    <p style="font-size: 14px; margin-right: 5px;margin-top:10px;font-weight:500;">Sort:</p>
    <div class="dropdown" style="position: relative; display: inline-block;margin-top:-5px">
        <button id="dropdown-toggle" class="dropdown-toggle" style="background: none; border: none; font-size: 14px; font-weight: 500; cursor: pointer; display: flex; align-items: center;color:#3b4452;">
            <?php echo e($sortType === 'newest' ? 'Newest First' : 'Most Recent Interacted'); ?>

        </button>
        <div class="dropdown-menu" style="display: <?php echo e($dropdownVisible ? 'block' : 'none'); ?>; position: absolute; background-color: white; box-shadow: 0px 8px 16px rgba(0,0,0,0.2); z-index: 1; min-width: 190px; right: 0; border-radius: 4px; border: 1px solid #ddd;">
            <a href="#" data-sort="newest" wire:click.prevent="updateSortType('newest')" class="dropdown-item" style="padding: 8px 16px; display: block; font-size: 14px; text-decoration: none; color:#3b4452;">Newest First</a>
            <a href="#" data-sort="interacted" wire:click.prevent="updateSortType('interacted')" class="dropdown-item" style="padding: 8px 16px; display: block; font-size: 14px; text-decoration: none; color:#3b4452;">Most Recent Interacted</a>
        </div>
    </div>
</div>


</div>
<div class="col-md-10" >

<!--[if BLOCK]><![endif]--><?php $__currentLoopData = $combinedData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php


    // Group comments by card_id and count the number of comments per card
    $cardCommentsCount = $comments->groupBy('card_id')->map(function ($comments) {
        return $comments->count();
    });

 
?>
         
    <!--[if BLOCK]><![endif]--><?php if(isset($data['type']) && $data['type'] === 'date_of_birth'): ?>

    <!--[if BLOCK]><![endif]--><?php if($sortType==='newest'): ?>
    <div class="birthday-card mt-2 comment-item"
        data-created="<?php echo e($data['created_at'] ?? ''); ?>" data-interacted="<?php echo e($data['updated_at'] ?? ''); ?>">

        <div class="F mb-4" style="padding: 15px; background-color: white; border-radius: 5px; border: 1px solid #CFCACA; color: #3b4452; margin-top: 5px">

        <div class="row m-0">
                                <div class="col-md-4 mb-2" style="text-align: center;">
                                <img src="<?php echo e($empCompanyLogoUrl); ?>" alt="Company Logo" style="width:120px">
                                </div>
                                <div class="col-md-4 m-auto" style="color: #677A8E; font-size: 14px;font-weight: 100px; text-align: center;">
                                    Group Events
                                </div>
                                <div class="c col-md-4 m-auto" style="font-size: 13px; font-weight: 100px; color: #9E9696; text-align: center;">
                                <?php echo e(date('d M', strtotime($data['employee']->personalInfo->date_of_birth??'-'))); ?>

                                </div>
                            </div>
                            <div class="row m-0 mt-2">
                                <div class="col-md-4">
                                    <img src="<?php echo e(asset('images/Blowing_out_Birthday_candles_Gif.gif')); ?>" alt="Image Description" style="width: 120px;">
                                </div>
                                <div class="col-md-8 m-auto">
                                    <p style="color: #778899;font-size: 12px;font-weight:normal;">
                                        Happy Birthday <?php echo e(ucwords(strtoupper($data['employee']->first_name))); ?>

                                        <?php echo e(ucwords(strtoupper($data['employee']->last_name))); ?>,
                                        Have a great year ahead!
                                    </p>
                                    <div style="display: flex; align-items: center;">
                                    <!--[if BLOCK]><![endif]--><?php if($data['employee'] && $data['employee']->image_url): ?>
    <img style="border-radius: 50%; margin-left: 10px;" height="35" width="35" src="<?php echo e($data['employee']->image_url); ?>" alt="Employee Image">
<?php else: ?>
    <img style="border-radius: 50%; margin-left: 10px;" height="35" width="35" src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" alt="Default Image">


                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <p style="margin-left: 10px; font-size: 12px; color:#3b4452;margin-bottom:0;font-weight:600;">
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
                                    <span style="font-size: 16px;margin-left:-7px;"><?php echo e($emoji_reaction->emoji_reaction); ?></span>
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
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128520','<?php echo e($data['employee']->emp_id); ?>')">😈</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128521','<?php echo e($data['employee']->emp_id); ?>')">😉</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128522','<?php echo e($data['employee']->emp_id); ?>')">😊</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128523','<?php echo e($data['employee']->emp_id); ?>')">😋</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128525','<?php echo e($data['employee']->emp_id); ?>')">😍</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128524','<?php echo e($data['employee']->emp_id); ?>')">😌</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128526','<?php echo e($data['employee']->emp_id); ?>'))">😎</span>
                                                <span class="emoji-option" style="font-size: 14px;cursor:pointer" wire:click="addEmoji('&#128527','<?php echo e($data['employee']->emp_id); ?>'))">😏</span>

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
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128536','<?php echo e($data['employee']->emp_id); ?>')">😘</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128537')">😙</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128538','<?php echo e($data['employee']->emp_id); ?>')">😚</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128539','<?php echo e($data['employee']->emp_id); ?>')">😛</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128540','<?php echo e($data['employee']->emp_id); ?>')">😜</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128541','<?php echo e($data['employee']->emp_id); ?>')">😝</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128542','<?php echo e($data['employee']->emp_id); ?>')">😞</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128543','<?php echo e($data['employee']->emp_id); ?>')">😟</span>

                                            </div>
                                            <div class="emoji-row">
                                                <!-- Add more emojis here -->
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128544','<?php echo e($data['employee']->emp_id); ?>')">😠</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128545','<?php echo e($data['employee']->emp_id); ?>')">😡 </span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128546','<?php echo e($data['employee']->emp_id); ?>')">😢</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128547','<?php echo e($data['employee']->emp_id); ?>')">😣</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128548','<?php echo e($data['employee']->emp_id); ?>')">😤</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128549','<?php echo e($data['employee']->emp_id); ?>')">😥</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128550','<?php echo e($data['employee']->emp_id); ?>')">😦</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128551','<?php echo e($data['employee']->emp_id); ?>')">😧</span>

                                            </div>
                                            <div class="emoji-row">
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128552','<?php echo e($data['employee']->emp_id); ?>')">😨</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128553','<?php echo e($data['employee']->emp_id); ?>')">😩</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128554','<?php echo e($data['employee']->emp_id); ?>')">😪</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128555','<?php echo e($data['employee']->emp_id); ?>')">😫</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128556','<?php echo e($data['employee']->emp_id); ?>')">😬</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128557','<?php echo e($data['employee']->emp_id); ?>')">😭</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128558','<?php echo e($data['employee']->emp_id); ?>')">😮</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128559','<?php echo e($data['employee']->emp_id); ?>')">😯</span>

                                            </div>
                                            <div class="emoji-row">
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128560','<?php echo e($data['employee']->emp_id); ?>')">😰</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128561','<?php echo e($data['employee']->emp_id); ?>')">😱</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128562','<?php echo e($data['employee']->emp_id); ?>')">😲</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128563','<?php echo e($data['employee']->emp_id); ?>')">😳</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128564','<?php echo e($data['employee']->emp_id); ?>')">😴</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128565','<?php echo e($data['employee']->emp_id); ?>')">😵</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128566','<?php echo e($data['employee']->emp_id); ?>')">😶</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128567','<?php echo e($data['employee']->emp_id); ?>')">😷</span>

                                            </div>
                                            <div class="emoji-row">
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128075','<?php echo e($data['employee']->emp_id); ?>')">👋</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#9995','<?php echo e($data['employee']->emp_id); ?>')">✋</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128400','<?php echo e($data['employee']->emp_id); ?>')">🖐</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128406','<?php echo e($data['employee']->emp_id); ?>'))">🖖</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#129306','<?php echo e($data['employee']->emp_id); ?>'))">🤚</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#9757','<?php echo e($data['employee']->emp_id); ?>'))">☝</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128070','<?php echo e($data['employee']->emp_id); ?>')">👆</span>
                                                <span class="emoji-option" style="font-size: 14px;" wire:click="addEmoji('&#128071','<?php echo e($data['employee']->emp_id); ?>')">👇</span>


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
                        <div class="row m-0">
    <?php
        $currentCardComments = $comments->where('card_id', $data['employee']->emp_id)->sortByDesc('created_at');
    ?>
    <div class="m-0 mt-2 px-2" id="comments-container" style="overflow-y:auto; max-height:150px;">
  
    <!--[if BLOCK]><![endif]--><?php if($currentCardComments && $currentCardComments->count() > 0): ?>
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $currentCardComments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="mb-3 comment-item" data-created="<?php echo e($comment->created_at); ?>" data-interacted="<?php echo e($comment->updated_at); ?>" style="display: flex; gap: 10px; align-items: center;">
                <!--[if BLOCK]><![endif]--><?php if($comment->employee): ?>
                    <?php
                        $employee = $comment->employee;
                        $imageUrl = $employee->image_url; // Retrieves image URL using the accessor
                      
                    ?>

<!--[if BLOCK]><![endif]--><?php if($employee->image_url): ?>
    <!-- Display the employee's actual image -->
    <img style="border-radius: 50%;" height="25" width="25" src="<?php echo e($employee->image_url); ?>" alt="Employee Image">
<?php else: ?>
    <!-- Display a default image based on gender or a generic fallback -->
    <!--[if BLOCK]><![endif]--><?php if($employee->gender == "Male"): ?>
        <img class="feeds-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="Default Male Profile" style="border-radius: 50%;" height="25" width="25">
    <?php elseif($employee->gender == "Female"): ?>
        <img class="feeds-image" src="https://th.bing.com/th/id/OIP.16PsNaosyhVxpn3hmvC46AHaHa?w=199&h=199&c=7&r=0&o=5&dpr=1.5&pid=1.7" alt="Default Female Profile" style="border-radius: 50%;" height="25" width="25">
    <?php else: ?>
        <img style="border-radius: 50%;" height="25" width="25" src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" alt="Default Profile Image">
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                    <div class="comment" style="font-size: 10px;">
                        <b style="color:#778899; font-weight:500; font-size: 10px;">
                            <?php echo e(ucwords(strtolower($employee->first_name))); ?> <?php echo e(ucwords(strtolower($employee->last_name))); ?>

                        </b>
                        <p class="mb-0" style="font-size: 11px;">
                            <?php echo e(ucfirst($comment->comment)); ?>

                        </p>
                    </div>

                <?php elseif($comment->hr): ?>
                    <?php
                        $hr = $comment->hr;
                        $imageUrl = $hr->image_url; // Retrieves image URL using the accessor for HR
                    ?>

                    <!--[if BLOCK]><![endif]--><?php if($imageUrl): ?>
                        <img style="border-radius: 50%;" height="25" width="25" src="<?php echo e($imageUrl); ?>" alt="HR Image">
                    <?php else: ?>
                        <!--[if BLOCK]><![endif]--><?php if($hr->gender == "Male"): ?>
                            <img class="feeds-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="Default Male Profile" style=" border-radius: 50%;" height="25" width="25">
                        <?php elseif($hr->gender == "Female"): ?>
                            <img class="feeds-image" src="https://th.bing.com/th/id/OIP.16PsNaosyhVxpn3hmvC46AHaHa?w=199&h=199&c=7&r=0&o=5&dpr=1.5&pid=1.7" alt="Default Female Profile" height="25" width="25" style="border-radius:50%">
                        <?php else: ?>
                            <img style="border-radius: 50%;" height="25" width="25" src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" alt="Default Image">
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <div class="comment" style="font-size: 10px;">
                        <b style="color:#778899; font-weight:500; font-size: 10px;">
                            <?php echo e(ucwords(strtolower($hr->first_name))); ?> <?php echo e(ucwords(strtolower($hr->last_name))); ?>

                        </b>
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
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
</div>

                  

                            </div>

</div>
</div>

    <?php else: ?>
    <?php
    // Group comments by card_id and count the number of comments per card
    $cardCommentsCount = $comments->groupBy('card_id')->map(function ($comments) {
            return $comments->count();
        });

        // Get card IDs with more than 2 comments
        $validCardIds = $cardCommentsCount->filter(function ($count) {
            return $count > 2;
        })->keys();
            $filteredComments = $comments->whereIn('card_id', $validCardIds);

    // Check if the card is a birthday card based on your conditions, 
    // for example, checking if the card_id matches the employee's emp_id.
    $birthdayCardId = $data['employee']->emp_id; // assuming this is your birthday card's ID
?>
<div class="birthday-card mt-2 comment-item"
        data-created="<?php echo e($data['created_at'] ?? ''); ?>" data-interacted="<?php echo e($data['updated_at'] ?? ''); ?>">
        <!--[if BLOCK]><![endif]--><?php if($filteredComments->where('card_id', $birthdayCardId)->count() > 0): ?>
        <div class="F mb-4" style="padding: 15px; background-color: white; border-radius: 5px; border: 1px solid #CFCACA; color: #3b4452; margin-top: 5px">
                            <div class="row m-0">
                                <div class="col-md-3 mb-2" style="text-align: center;">
                                <img src="<?php echo e($empCompanyLogoUrl); ?>" alt="Company Logo" style="width:120px">
                                </div>
                                <div class="col-md-4 m-auto" style="color: #677A8E; font-size: 14px;font-weight: 100px; text-align: center;">
                                    Group Events
                                </div>
                                <div class="c col-md-4 m-auto" style="font-size: 13px; font-weight: 100px; color: #9E9696; text-align: center;">
                                    <?php echo e(date('d M ', strtotime($data['employee']->date_of_birth))); ?>

                                </div>
                            </div>
                            <div class="row m-0 mt-2">
                                <div class="col-md-3">
                                    <img src="<?php echo e(asset('images/Blowing_out_Birthday_candles_Gif.gif')); ?>" alt="Image Description" style="width: 120px;">
                                </div>
                                <div class="col-md-8 m-auto">
                                    <p style="color: #778899;font-size: 12px;font-weight:normal;">
                                        Happy Birthday <?php echo e(ucwords(strtoupper($data['employee']->first_name))); ?>

                                        <?php echo e(ucwords(strtoupper($data['employee']->last_name))); ?>,
                                        Have a great year ahead!
                                    </p>
                                    <div style="display: flex; align-items: center;">
                                    <!--[if BLOCK]><![endif]--><?php if($data['employee'] && $data['employee']->image_url): ?>
    <img style="border-radius: 50%; margin-left: 10px;" height="35" width="35" src="<?php echo e($data['employee']->image_url); ?>" alt="Employee Image">
<?php else: ?>
    <img style="border-radius: 50%; margin-left: 10px;" height="35" width="35" src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" alt="Default Image">


                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
    // Group comments by card_id and count the number of comments per card
    $cardCommentsCount = $comments->groupBy('card_id')->map(function ($comments) {
        return $comments->count();
    });

    // Get card IDs with more than 2 comments
    $validCardIds = $cardCommentsCount->filter(function ($count) {
        return $count >= 2; // Use >= 2 to include cards with exactly 2 comments
    })->keys();

    // Filter comments to include only those for cards with at least 2 comments
    $filteredComments = $comments->whereIn('card_id', $validCardIds);

    // Sort the filtered comments based on the sortType
    if ($sortType === 'interacted') {
        $filteredComments = $filteredComments->sortByDesc('updated_at');
    }
?>
 <div class="m-0 mt-2 px-2" id="comments-container" style="overflow-y:auto; max-height:150px;">
 <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $filteredComments->where('card_id', $data['employee']->emp_id)->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <div class="mb-3 comment-item" data-created="<?php echo e($comment->created_at); ?>" data-interacted="<?php echo e($comment->updated_at); ?>" style="display: flex; gap: 10px; align-items: center;">
 <!--[if BLOCK]><![endif]--><?php if($comment->employee): ?>
    <?php
        $employee = $comment->employee;
        $employeeDetails = $employee->employeeDetails;
        $imageUrl = $employeeDetails->image_url ?? null;
        $gender = $employeeDetails->gender ?? null;
    ?>

    <!--[if BLOCK]><![endif]--><?php if($imageUrl): ?>
        <img style="border-radius: 50%;" height="25" width="25" src="<?php echo e($imageUrl); ?>" alt="Employee Image">
    <?php else: ?>
        <!--[if BLOCK]><![endif]--><?php if($gender == "Male"): ?>
            <img src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="Default Male Profile" height="25" width="25">
        <?php elseif($gender == "Female"): ?>
            <img src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBW" alt="Default Female Profile" height="25" width="25">
        <?php else: ?>
            <img src="https://via.placeholder.com/25" alt="Default Profile" height="25" width="25">
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div class="comment" style="font-size: 10px;">
        <b style="color:#778899; font-weight:500; font-size: 10px;">
            <?php echo e(ucwords(strtolower($employee->first_name))); ?> <?php echo e(ucwords(strtolower($employee->last_name))); ?>

        </b>
        <p class="mb-0" style="font-size: 11px;">
            <?php echo e(ucfirst($comment->comment)); ?>

        </p>
    </div>

<?php elseif($comment->hr): ?>
    <?php
        $imageUrl = $comment->hr->image;
        $gender = $comment->hr->gender;
    ?>

    <!--[if BLOCK]><![endif]--><?php if($imageUrl): ?>
        <img style="border-radius: 50%;" height="25" width="25" src="<?php echo e(asset('storage/' . $imageUrl)); ?>">
    <?php else: ?>
        <!--[if BLOCK]><![endif]--><?php if($gender == "Male"): ?>
            <img src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="Default Male Profile" height="25" width="25">
        <?php elseif($gender == "Female"): ?>
            <img src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBW" alt="Default Female Profile" height="25" width="25">
        <?php else: ?>
            <img src="https://via.placeholder.com/25" alt="Default Profile" height="25" width="25">
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
                            </div>




        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        
        </div>

        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    
<?php else: ?>

<!--[if BLOCK]><![endif]--><?php if($sortType==='newest'): ?>
    <div class="hire-card mt-2 comment-item"
        data-created="<?php echo e($data['created_at'] ?? ''); ?>" data-interacted="<?php echo e($data['updated_at'] ?? ''); ?>">

        <div class="F mb-4" style="padding: 15px; background-color: white; border-radius: 5px; border: 1px solid #CFCACA; color: #3b4452; margin-top: 5px">

        <div class="row m-0">
                                <div class="col-md-3 mb-2" style="text-align: center;">
                                <img src="<?php echo e($empCompanyLogoUrl); ?>" alt="Company Logo" style="width:120px">
                                </div>
                                <div class="col-md-4 m-auto" style="color: #677A8E; font-size: 14px;font-weight: 100px; text-align: center;">
                                    Group Events
                                </div>
                                <div class="c col-md-4 m-auto" style="font-size: 12px; font-weight: 100px; color: #9E9696; text-align: center;">
                            <?php echo e(date('d M Y', strtotime($data['employee']->hire_date))); ?>

                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-md-3">
                            <img src="<?php echo e(asset('images/New_team_members_gif.gif')); ?>" alt="Image Description" style="width: 120px;">
                        </div>
                        <div class="col-md-8 m-auto">
                            <p style="font-size:12px;color:#778899;font-weight:normal;margin-top:10px;padding-left:10px">
                                <?php
                                $hireDate = $data['employee']->hire_date;
                                $yearsSinceHire = date('Y') - date('Y', strtotime($hireDate));
                                $yearText = $yearsSinceHire == 1 ? 'year' : 'years';
                                ?>

                                Our congratulations to <?php echo e(ucwords(strtoupper($data['employee']->first_name))); ?>

                                <?php echo e(ucwords(strtoupper($data['employee']->last_name))); ?>,on completing <?php echo e($yearsSinceHire); ?> successful <?php echo e($yearText); ?>.


                            </p>
                            <div style="display: flex; align-items: center;">
                            <!--[if BLOCK]><![endif]--><?php if($data['employee'] && $data['employee']->image_url): ?>
    <img style="border-radius: 50%; margin-left: 10px;" height="35" width="35" src="<?php echo e($data['employee']->image_url); ?>" alt="Employee Image">
<?php else: ?>
    <img style="border-radius: 50%; margin-left: 10px;" height="35" width="35" src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" alt="Default Image">


                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <p style="margin-left: 10px; font-size: 12px;color:#3b4452;margin-bottom:0;font-weight:600;">
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




                <div class="col-md-7 p-0">
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
                            

                        <div class="row m-0">

                        <?php
                    $currentCardComments = $addcomments->where('card_id', $data['employee']->emp_id)->sortByDesc('created_at');
                    ?>
     <div class="m-0 mt-2 px-2" id="comments-container" style="overflow-y:auto; max-height:150px;">
  
  <!--[if BLOCK]><![endif]--><?php if($currentCardComments && $currentCardComments->count() > 0): ?>
  <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $currentCardComments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="mb-3 comment-item" data-created="<?php echo e($comment->created_at); ?>" data-interacted="<?php echo e($comment->updated_at); ?>" style="display: flex; gap: 10px; align-items: center;">
        
        <?php
          
          

            // Determine if it's an employee or HR
            if ($comment->employee) {
                $employee = $comment->employee;
                $imageUrl = $employee->image_url; // Assuming 'image_url' is directly in Employee model
            } elseif ($comment->hr) {
                $imageUrl = $comment->hr->image ? asset('storage/' . $comment->hr->image) : null;
            }

            // Determine default images based on gender if no image URL is available
            if (!$imageUrl) {
                $gender = $comment->employee->gender ?? $comment->hr->gender ;

                if ($gender == "Male") {
                    $imageUrl = "https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png";
                } elseif ($gender == "Female") {
                    $imageUrl = "https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBW";
                } else {
                    $imageUrl = "https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain";
                }
            }
        ?>

        <img style="border-radius: 50%;" height="25" width="25" src="<?php echo e($imageUrl); ?>" alt="Profile Image">

        <div class="comment" style="font-size: 10px;">
            <!--[if BLOCK]><![endif]--><?php if($comment->employee): ?>
                <b style="color:#778899; font-weight:500; font-size: 10px;">
                    <?php echo e(ucwords(strtolower($comment->employee->first_name))); ?> <?php echo e(ucwords(strtolower($comment->employee->last_name))); ?>

                </b>
            <?php elseif($comment->hr): ?>
                <b style="color:#778899; font-weight:500; font-size: 10px;">
                    <?php echo e(ucwords(strtolower($comment->hr->first_name))); ?> <?php echo e(ucwords(strtolower($comment->hr->last_name))); ?>

                </b>
            <?php else: ?>
                <b style="color:#778899; font-weight:500; font-size: 10px;">Unknown Employee</b>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <p class="mb-0" style="font-size: 11px;">
                <?php echo e(ucfirst($comment->addcomment)); ?>

            </p>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->


  <?php endif; ?><!--[if ENDBLOCK]><![endif]-->




</div>


</div>
                  

                            </div>

</div>
</div>

    <?php else: ?>
    <?php
    // Group comments by card_id and count the number of comments per card
    $cardCommentsCount = $addcomments->groupBy('card_id')->map(function ($comments) {
            return $comments->count();
        });

        // Get card IDs with more than 2 comments
        $validCardIds = $cardCommentsCount->filter(function ($count) {
            return $count > 2;
        })->keys();
            $filteredComments = $addcomments->whereIn('card_id', $validCardIds);

    // Check if the card is a birthday card based on your conditions, 
    // for example, checking if the card_id matches the employee's emp_id.
    $hireCardId = $data['employee']->emp_id; // assuming this is your birthday card's ID
?>
<div class="hire-card mt-2 comment-item"
        data-created="<?php echo e($data['created_at'] ?? ''); ?>" data-interacted="<?php echo e($data['updated_at'] ?? ''); ?>">
       
                        <!-- Upcoming Birthdays List -->
                     
        <!--[if BLOCK]><![endif]--><?php if($filteredComments->where('card_id', $hireCardId)->count() > 0): ?>
        <div class="F mb-4" style="padding: 15px; background-color: white; border-radius: 5px; border: 1px solid #CFCACA; color: #3b4452; margin-top: 5px">
        <div class="row m-0">
                                <div class="col-md-4 mb-2" style="text-align: center;">
                                <img src="<?php echo e($empCompanyLogoUrl); ?>" alt="Company Logo" style="width:120px">
                                </div>
                                <div class="col-md-4 m-auto" style="color: #677A8E; font-size: 14px;font-weight: 100px; text-align: center;">
                                    Group Events
                                </div>
                                <div class="c col-md-4 m-auto" style="font-size: 12px; font-weight: 100px; color: #9E9696; text-align: center;">
                            <?php echo e(date('d M Y', strtotime($data['employee']->hire_date))); ?>

                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-md-3">
                            <img src="<?php echo e(asset('images/New_team_members_gif.gif')); ?>" alt="Image Description" style="width: 120px;">
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
                            <!--[if BLOCK]><![endif]--><?php if($data['employee'] && $data['employee']->image_url): ?>
    <img style="border-radius: 50%; margin-left: 10px;" height="35" width="35" src="<?php echo e($data['employee']->image_url); ?>" alt="Employee Image">
<?php else: ?>
    <img style="border-radius: 50%; margin-left: 10px;" height="35" width="35" src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" alt="Default Image">


                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <p style="margin-left: 10px; font-size: 12px; color: #47515b;margin-bottom:0;font-weight:600;">
                                    Congratulations, <?php echo e(ucwords(strtoupper($data['employee']->first_name))); ?>

                                    <?php echo e(ucwords(strtoupper($data['employee']->last_name))); ?>

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




                <div class="col-md-7 p-0">
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
    // Group comments by card_id and count the number of comments per card
    $cardCommentsCount = $addcomments->groupBy('card_id')->map(function ($comments) {
        return $comments->count();
    });

    // Get card IDs with more than 2 comments
    $validCardIds = $cardCommentsCount->filter(function ($count) {
        return $count >= 2; // Use >= 2 to include cards with exactly 2 comments
    })->keys();

    // Filter comments to include only those for cards with at least 2 comments
    $filteredComments = $addcomments->whereIn('card_id', $validCardIds);

    // Sort the filtered comments based on the sortType
    if ($sortType === 'interacted') {
        $filteredComments = $filteredComments->sortByDesc('updated_at');
    }
?>
 <div class="m-0 mt-2 px-2" id="comments-container" style="overflow-y:auto; max-height:150px;">
 <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $filteredComments->where('card_id', $data['employee']->emp_id)->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <div class="mb-3 comment-item" data-created="<?php echo e($comment->created_at); ?>" data-interacted="<?php echo e($comment->updated_at); ?>" style="display: flex; gap: 10px; align-items: center;">
 <!--[if BLOCK]><![endif]--><?php if($comment->employee): ?>
            <!--[if BLOCK]><![endif]--><?php if($comment->employee->image): ?>
                <img style="border-radius: 50%;" height="25" width="25" src="<?php echo e($comment->employee->image_url); ?>" alt="Employee Image">
            <?php else: ?>
                <!--[if BLOCK]><![endif]--><?php if($comment->employee->gender == "Male"): ?>
                    <img src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="Default Male Profile" height="25" width="25">
                <?php elseif($comment->employee->gender == "Female"): ?>
                    <img src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBW" alt="Default Female Profile" height="25" width="25">
                <?php else: ?>
                    <img src="https://via.placeholder.com/25" alt="Default Profile" height="25" width="25">
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <div class="comment" style="font-size: 10px;">
                <b style="color:#778899; font-weight:500; font-size: 10px;"><?php echo e(ucwords(strtolower($comment->employee->first_name))); ?> <?php echo e(ucwords(strtolower($comment->employee->last_name))); ?></b>
                <p class="mb-0" style="font-size: 11px;">
                    <?php echo e(ucfirst($comment->addcomment)); ?>

                </p>
            </div>
        <?php elseif($comment->hr): ?>
            <!--[if BLOCK]><![endif]--><?php if($comment->hr->image): ?>
                <img style="border-radius: 50%;" height="25" width="25" src="<?php echo e($comment->hr->image_url); ?>" alt="HR Image">
            <?php else: ?>
                <!--[if BLOCK]><![endif]--><?php if($comment->hr->gender == "Male"): ?>
                    <img src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="Default Male Profile" height="25" width="25">
                <?php elseif($comment->hr->gender == "Female"): ?>
                    <img src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBW" alt="Default Female Profile" height="25" width="25">
                <?php else: ?>
                    <img src="https://via.placeholder.com/25" alt="Default Profile" height="25" width="25">
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <div class="comment" style="font-size: 10px;">
                <b style="color:#778899; font-weight:500; font-size: 10px;"><?php echo e(ucwords(strtolower($comment->hr->first_name))); ?> <?php echo e(ucwords(strtolower($comment->hr->last_name))); ?></b>
                <p class="mb-0" style="font-size: 11px;">
                    <?php echo e(ucfirst($comment->addcomment)); ?>

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
                            </div>




        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


   <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </div>



</div>

</div>
</div>




<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script> -->
<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
<?php $__env->startPush('scripts'); ?>
<script>


    Livewire.on('updateSortType', sortType => {
        Livewire.emit('refreshComments', sortType);
    });
</script>
<?php $__env->stopPush(); ?>
<script>
    function handleRadioChange(element) {
        const url = element.getAttribute('data-url');
        window.location.href = url;
    }
</script>


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

    function showEmojiList(index,cardId) {
        var emojiList = document.getElementById('emoji-list-' + index);
        if (emojiList.style.display === "none" || emojiList.style.display === "") {
            emojiList.style.display = "block";
        } else {
            emojiList.style.display = "none";
        }
    }

    function comment(index,cardId) {
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
document.addEventListener('DOMContentLoaded', function() {
    var dropdownToggle = document.getElementById('dropdown-toggle');

    // Set the initial dropdown value based on the sort type
    var initialSortType = dropdownToggle.childNodes[0].textContent.trim();
    dropdownToggle.childNodes[0].textContent = initialSortType === 'Newest First' ? 'Newest First' : 'Most Recent Interacted';

    dropdownToggle.addEventListener('click', function(event) {
        event.stopPropagation();
        var dropdownMenu = this.nextElementSibling;
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });

    window.addEventListener('click', function() {
        var dropdownMenus = document.querySelectorAll('.dropdown-menu');
        dropdownMenus.forEach(function(menu) {
            menu.style.display = 'none';
        });
    });

    document.querySelectorAll('.dropdown-item').forEach(function(item) {
        item.addEventListener('click', function(event) {
            event.preventDefault();
            var dropdownToggle = document.getElementById('dropdown-toggle');
            dropdownToggle.childNodes[0].textContent = this.textContent.trim();
            dropdownToggle.nextElementSibling.style.display = 'none';

            var sortType = this.getAttribute('data-sort');
            Livewire.emit('updateSortType', sortType); // Ensure this event exists and is handled
        });

        item.addEventListener('mouseover', function() {
            this.style.backgroundColor = '#E3EBF9';
        });

        item.addEventListener('mouseout', function() {
            this.style.backgroundColor = 'white';
        });
    });

    Livewire.on('refreshComments', function(sortType) {
        sortComments(sortType);
    });

    function sortComments(type) {
        var commentsContainer = document.getElementById('comments-container');
        var comments = Array.from(commentsContainer.getElementsByClassName('comment-item'));

        if (sortType === 'newest') {
            comments.sort(function(a, b) {
                return new Date(b.dataset.created) - new Date(a.dataset.created);
            });
        } else if (sortType === 'interacted') {
            comments = comments.filter(function(comment) {
                return parseInt(comment.dataset.comments) > 2; // Only keep comments with more than 2 comments
            });

            comments.sort(function(a, b) {
                return new Date(b.dataset.interacted) - new Date(a.dataset.interacted);
            });
        }

        commentsContainer.innerHTML = '';
        comments.forEach(function(comment) {
            commentsContainer.appendChild(comment);
        });
    }
});
</script>


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
    function selectEmoji(emoji, empId,index) {
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

    function addEmoji(emoji_reaction, empId, cardId) {
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
        var input, filter, dropdownContents, dropdownContent, menuItems, a, i, j, hasMatch;
        input = document.getElementById('filterSearch');
        filter = input.value.toUpperCase();
        
        // Select all dropdown content elements
        dropdownContents = [
            document.getElementById('dropdownContent1'),
            document.getElementById('dropdownContent2'),
            document.getElementById('dropdownContent3')
        ];

        // Loop through each dropdown content
        dropdownContents.forEach(function(dropdownContent) {
            menuItems = dropdownContent.getElementsByTagName('a');
            hasMatch = false; // Reset match flag

            // Loop through all menu items and hide/show based on the filter
            for (j = 0; j < menuItems.length; j++) {
                a = menuItems[j];
                if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    a.style.display = ""; // Show matching item
                    hasMatch = true; // Found a match
                } else {
                    a.style.display = "none"; // Hide non-matching item
                }
            }

            // Show dropdown if there's at least one matching item
            dropdownContent.style.display = hasMatch ? "block" : "none"; // Show or hide based on match
        });
    }
</script>


</div>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>      <?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/feeds.blade.php ENDPATH**/ ?>