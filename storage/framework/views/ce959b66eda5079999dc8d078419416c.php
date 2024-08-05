<!-- resources/views/livewire/people-lists.blade.php -->

<div>
    <style>
        .people-left-side-container {
            margin-right: 20px;
            padding: 20px;
            border-radius: 5px;
            height: 450px;
            margin-left: 25px;
        }

        .people-input-group-container {
            margin-bottom: 20px;
        }

        .people-search-input {
            font-size: 0.75rem !important;
            border-radius: 5px 0 0 5px;
            cursor: pointer;
            height: 32px;
        }


        .people-search-btn {
            height: 32px;
            width: 40px;
            position: relative;
            border-radius: 0 5px 5px 0;
            background-color: rgb(2, 17, 79);
            color: #fff;
            border: none;
        }

        .people-search-icon {
            position: absolute;
            top: 9px;
            left: 11px;
        }


        .people-starred-list-container {
            max-height: 350px;
            overflow-y: auto;
            overflow-x: hidden;
        }


        .people-empty-text {
            text-align: center;
            color: #778899;
            font-size: 12px;
        }

        .people-detail-container {
            height: auto;
            cursor: pointer;
            padding: 5px;
            margin-bottom: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: white;
        }

        .people-detail-container.selected {
            background-color: #f3faff;
        }

        .people-default-container-name {
            font-size: 12px;
            color: black;
            margin-right: 5px;
        }

        .people-default-container-name.inactive {
            color: red;
        }

        .people-default-container-empid {
            font-size: 12px;
            color: #333;
            white-space: nowrap;
        }

        .people-default-container-empid.inactive {
            color: red;
        }

        .people-text-blue {
            color: rgb(2, 17, 79);
        }

        .people-default-star-icon {
            cursor: pointer;
            font-size: 12px;
            padding-left: 6px;
            color: rgb(2, 17, 79)
        }

        .people-selectedperson-container {
            border-radius: 5px;
            padding: 20px;
            height: 450px;
        }

        .people-selectedperson-detail-container {
            background: #e0e0e0;
            padding: 10px;
        }

        .people-selectedperson-name {
            font-size: 16px;
            margin-right: 5px;
        }

        .people-selectedperson-anchortag {
            text-decoration: none;
        }

        .people-selectedperson-star-icon {
            cursor: pointer;
            color: rgb(2, 17, 79);
            margin-bottom: 10px;
        }

        .people-selectedperson-empid {
            color: #778899;
            font-size: 14px;
        }

        .people-headings {
            margin-right: 10px;
            font-weight: 500;
            color: #778899;
            font-size: 12px;
        }

        .people-horizontal-line {
            flex-grow: 1;
            width: 50px;
            color: black;
            border: 1px solid #778899;
            margin: 0;
        }

        .people-label {
            color: #778899;
            font-size: 13px;
        }

        .people-value {
            font-weight: 500;
            color: #333;
            font-size: 13px;
        }

        .people-first-person-container {
            font-size: 13px;
            padding: 10px;
            height: 450px;
        }

        .people-starred-nodata-container {
            margin-top: 140px
        }

        .people-starred-nodata-img {
            height: 150px;
            width: 150px;
        }

        .people-text-white {
            text-shadow: 0 0 2px rgb(2, 17, 79);
        }

        .people-selected-person-star {
            cursor: pointer;
            margin-bottom: 10px;
        }

        .people-nodata-container {
            margin-top: 100px
        }

        .people-nodata-img {
            height: 200px;
            width: 200px;
        }
    </style>
    <div class="container mt-3">
        <!--[if BLOCK]><![endif]--><?php if(session()->has('emp_error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('emp_error')); ?>

        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <?php
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $mangerid = DB::table('employee_details')
        ->join('companies', 'employee_details.company_id', '=', 'companies.company_id')
        ->where('employee_details.manager_id', $employeeId)
        ->select('companies.company_logo', 'companies.company_name')
        ->first();
        ?>
        <!--[if BLOCK]><![endif]--><?php if($mangerid): ?>
        <div class="row justify-content-center" style="width: 35%; position: relative; padding-left: 30px;">
            <div class="col-4 text-center" style="border-radius: 5px; cursor: pointer;">
                <a id="starred-tab-link" style="text-decoration: none; font-size: 13px; color: <?php echo e($activeTab === 'starred' ? 'rgb(2, 17, 79);' : '#333'); ?>" wire:click="$set('activeTab', 'starred')" class="links">
                    Starred
                </a>
            </div>
            <div class="col-4 text-center" style="border-radius: 5px; cursor: pointer;">
                <a id="myteam-tab-link" style="text-decoration: none; font-size: 13px; color: <?php echo e($activeTab === 'myteam' ? 'rgb(2, 17, 79);' : '#333'); ?>" wire:click="$set('activeTab', 'myteam')" class="links">
                    My Team
                </a>
            </div>
            <div class="col-4 text-center" style="border-radius: 5px; cursor: pointer;">
                <a id="everyone-tab-link" style="text-decoration: none; font-size: 13px; color: <?php echo e($activeTab === 'everyone' ? 'rgb(2, 17, 79);' : '#333'); ?>" wire:click="$set('activeTab', 'everyone')" class="links">
                    Everyone
                </a>
            </div>
            <div style="transition: left 0.3s ease-in-out; position: absolute; bottom: -11px; left: <?php echo e($activeTab === 'starred' ? '30px' : ($activeTab === 'myteam' ? '39%' : '70%')); ?>; width: 30%; height: 4px; background-color: rgb(2, 17, 79); border-radius: 5px;"></div>
        </div>
        <?php else: ?>
        <div class="row justify-content-start" style="width: 40%; position: relative; padding-left: 40px;">
            <div class="col-3 text-start" style="border-radius: 5px; cursor: pointer;">
                <a id="starred-tab-link" style="text-decoration: none; font-size: 13px; color: <?php echo e($activeTab === 'starred' ? 'rgb(2, 17, 79);' : '#333'); ?>" wire:click="$set('activeTab', 'starred')" class="links">
                    Starred
                </a>
            </div>
            <div class="col-3 text-start" style="border-radius: 5px; cursor: pointer;">
                <a id="everyone-tab-link" style="text-decoration: none; font-size: 13px; color: <?php echo e($activeTab === 'everyone' ? 'rgb(2, 17, 79);' : '#333'); ?>" wire:click="$set('activeTab', 'everyone')" class="links">
                    Everyone
                </a>
            </div>
            <div style="transition: left 0.3s ease-in-out; position: absolute; bottom: -11px; left: <?php echo e($activeTab === 'starred' ? '30px' : '118px'); ?>; width: 26%; height: 4px; background-color: rgb(2, 17, 79); border-radius: 5px;"></div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


        <!--[if BLOCK]><![endif]--><?php if($activeTab === 'starred'): ?>
        <!-- Starred tab content -->
        <div class="row mt-3 people-all-tabs-container">

            <div class="col-12 col-md-4 bg-white people-left-side-container">
                <div class="input-group people-input-group-container">
                    <input wire:model="search" type="text" class="form-control people-search-input" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                    <div class="input-group-append">
                        <button wire:click="starredFilter" class="people-search-btn" type="button">
                            <i class="fa fa-search people-search-icon"></i>
                        </button>
                    </div>
                </div>
                <div class="mt-3 people-starred-list-container">


                    <!--[if BLOCK]><![endif]--><?php if($starredPeoples->isEmpty()): ?>
                    <div class="container people-empty-text">Looks like you don't have any records</div>
                    <?php else: ?>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $starredPeoples->where('starred_status', 'starred'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $people): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div wire:click="starredPersonById('<?php echo e($people->id); ?>')" class="container people-detail-container <?php echo e($selectStarredPeoples && $selectStarredPeoples->id == $people->id ? 'selected' : ''); ?>">
                        <div class="row align-items-center">
                            <div class="col-3">
                                <!--[if BLOCK]><![endif]--><?php if($people->profile == ""): ?>
                                <!--[if BLOCK]><![endif]--><?php if($people->emp->gender == "Male"): ?>
                                <img class="people-profile-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="">
                                <?php elseif($people->emp->gender == "Female"): ?>
                                <img class="people-profile-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="">
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?>
                                <img class="people-profile-image" src="<?php echo e(Storage::url($people->profile)); ?>" alt="">
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            </div>
                            <div class="col-md-9 col-12">
                                <div class="d-flex align-items-center">
                                    <h6 class="username truncate-text people-default-container-name   <?php if(isset($people->emp)): ?>
                                        <?php if($people->emp->employee_status != 'active'): ?>
                                            inactive
                                        <?php endif; ?>
                                            <?php endif; ?>" title="<?php echo e(ucwords(strtolower($people->name))); ?> (#<?php echo e($people->emp_id); ?>)"><?php echo e(ucwords(strtolower($people->name))); ?></h6>
                                            <p class="mb-0 people-default-container-empid
                                            <?php if(isset($people->emp)): ?>
                                        <?php if($people->emp->employee_status != 'active'): ?>
                                            inactive
                                        <?php endif; ?>
                                            <?php endif; ?>">(#<?php echo e($people->people_id); ?>)</p>
                                </div>

                            </div>

                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
            <!-- Details of the selected person -->
            <div class="col-12 col-md-7 bg-white people-selectedperson-container">

                <!--[if BLOCK]><![endif]--><?php if($selectStarredPeoples): ?>
                <!-- Code to display details when $selectStarredPeoples is set -->
                <div class="row">
                    <div class="col-3">
                        <!--[if BLOCK]><![endif]--><?php if(empty($selectStarredPeoples->profile) || $selectStarredPeoples->profile == ""): ?>
                        <!--[if BLOCK]><![endif]--><?php if($selectStarredPeoples->emp->gender == "Male"): ?>
                        <img class="people-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="">
                        <?php elseif($selectStarredPeoples->emp->gender == "Female"): ?>
                        <img class="people-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="Profile Image">
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php else: ?>
                        <img class="people-image" src="<?php echo e(Storage::url($selectStarredPeoples->profile)); ?>" alt="">
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    </div>
                    <div class="col-md-7 col-12">
                        <div class="people-selectedperson-detail-container">
                            <div class="d-flex align-items-center">
                                <h1 class="people-selectedperson-name"><?php echo e(ucwords(strtolower(optional($selectStarredPeoples)->name))); ?></h1>
                                <a class="people-selectedperson-anchortag" wire:click="removeToggleStar('<?php echo e(optional($selectStarredPeoples)->people_id); ?>')">

                                    <i class="fa fa-star people-selectedperson-star-icon"></i>

                                </a>

                            </div>
                            <?php
                            $jobTitle = optional($selectStarredPeoples->emp)->job_role;
                            $convertedTitle = preg_replace('/\bII\b/', 'I', $jobTitle);
                            $convertedTitle = preg_replace('/\bII\b/', 'II', $jobTitle);
                            $convertedTitle = preg_replace('/\bIII\b/', 'III', $convertedTitle);
                            ?>
                            <p class="mb-0 people-selectedperson-empid"><?php echo e($convertedTitle); ?> (#<?php echo e(optional($selectStarredPeoples)->people_id); ?>)</p>
                        </div>
                        <br>
                        <div class="d-flex align-items-center">
                            <span class="people-headings">CONTACT DETAILS</span>
                            <hr class="people-horizontal-line">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-7 people-label">Mobile Number</label>
                            <label class="col-5 people-value"><?php echo e(optional($selectStarredPeoples)->contact_details && strtolower(optional($selectStarredPeoples)->contact_details) !== 'n/a'
                                ? optional($selectStarredPeoples)->contact_details
                                : '-'); ?></label>
                        </div>
                        <br>
                        <div class="d-flex align-items-center">
                            <span class="people-headings">CATEGORY</span>
                            <hr class="people-horizontal-line">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-7 people-label">Location</label>
                            <label class="col-5 people-value"><?php echo e(optional($selectStarredPeoples)->location && strtolower(optional($selectStarredPeoples)->location) !== 'unknown'
                                ? optional($selectStarredPeoples)->location
                                : '-'); ?></label>
                        </div>
                        <br>
                        <div class="d-flex align-items-center">
                            <span class="people-headings">OTHER INFORMATION</span>
                            <hr class="people-horizontal-line">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-7 people-label">Joining Date</label>
                            <label class="col-5 people-value"><?php echo e(optional($selectStarredPeoples)->joining_date && strtolower(optional($selectStarredPeoples)->joining_date) !== 'unknown' 
                                ? date('d M, Y', strtotime(optional($selectStarredPeoples)->joining_date)) 
                                : '-'); ?></label>
                        </div>
                        <div class="row">
                            <label class="col-7 people-label">Date Of Birth</label>
                            <label class="col-5 people-value"><?php echo e(optional($selectStarredPeoples)->date_of_birth && strtolower(optional($selectStarredPeoples)->date_of_birth) !== 'unknown' 
                                ? date('d M, Y', strtotime(optional($selectStarredPeoples)->date_of_birth)) 
                                : '-'); ?></label>
                        </div>

                    </div>
                </div>
            </div>
            <?php elseif(!$starredPeoples->isEmpty()): ?>

            <!-- Code to display details of the first person in $starredPeoples when $selectStarredPeoples is not set -->
            <?php
            $firstStarredPerson = $starredPeoples->first();
            ?>

            <div class="row people-first-person-container">

                <div class="col-3">
                    <!--[if BLOCK]><![endif]--><?php if(empty($firstStarredPerson->profile) || $firstStarredPerson->profile == ""): ?>
                    <!--[if BLOCK]><![endif]--><?php if($firstStarredPerson->emp->gender == "Male"): ?>
                    <img class="people-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="">
                    <?php elseif($firstStarredPerson->emp->gender == "Female"): ?>
                    <img class="people-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="">
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <?php else: ?>
                    <img class="people-image" src="<?php echo e(Storage::url($firstStarredPerson->profile)); ?>" alt="">
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div class="col-md-7 col-12">
                    <div class="people-selectedperson-detail-container">
                        <div class="d-flex align-items-center">
                            <h1 class="people-selectedperson-name"><?php echo e(ucwords(strtolower(optional($firstStarredPerson)->name))); ?></h1>
                            <a class="people-selectedperson-anchortag" wire:click="removeToggleStar('<?php echo e(optional($firstStarredPerson)->people_id); ?>')">

                                <i class="fa fa-star people-selectedperson-star-icon"></i>

                            </a>

                        </div>
                        <?php
                        $jobTitle = optional($firstStarredPerson->emp)->job_role;
                        $convertedTitle = preg_replace('/\bII\b/', 'I', $jobTitle);
                        $convertedTitle = preg_replace('/\bII\b/', 'II', $jobTitle);
                        $convertedTitle = preg_replace('/\bIII\b/', 'III', $convertedTitle);
                        ?>
                        <p class="mb-0 people-selectedperson-empid"><?php echo e($convertedTitle); ?> (#<?php echo e(optional($firstStarredPerson)->people_id); ?>)</p>
                    </div>
                    <br>
                    <div class="d-flex align-items-center">
                        <span class="people-headings">CONTACT DETAILS</span>
                        <hr class="people-horizontal-line">
                    </div>
                    <br>
                    <div class="row">
                        <label class="col-7 people-label">Mobile Number</label>
                        <label class="col-5 people-value"><?php echo e(optional($firstStarredPerson)->contact_details && strtolower(optional($firstStarredPerson)->contact_details) !== 'n/a'
                            ? optional($firstStarredPerson)->contact_details
                            : '-'); ?></label>
                    </div>
                    <br>
                    <div class="d-flex align-items-center">
                        <span class="people-headings">CATEGORY</span>
                        <hr class="people-horizontal-line">
                    </div>
                    <br>
                    <div class="row">
                        <label class="col-7 people-label">Location</label>
                        <label class="col-5 people-value"> <?php echo e(optional($firstStarredPerson)->location && strtolower(optional($firstStarredPerson)->location) !== 'unknown'
                            ? optional($firstStarredPerson)->location
                            : '-'); ?></label>
                    </div>
                    <br>
                    <div class="d-flex align-items-center">
                        <span class="people-headings">OTHER INFORMATION</span>
                        <hr class="people-horizontal-line">
                    </div>
                    <br>
                    <div class="row">
                        <label class="col-7 people-label">Joining Date</label>
                        <label class="col-5 people-value"> <?php echo e(optional($firstStarredPerson)->joining_date && strtolower(optional($firstStarredPerson)->joining_date) !== 'unknown' 
                            ? date('d M, Y', strtotime(optional($firstStarredPerson)->joining_date)) 
                            : '-'); ?></label>
                    </div>
                    <div class="row">
                        <label class="col-7 people-label">Date Of Birth</label>
                        <label class="col-5 people-value"><?php echo e(optional($firstStarredPerson)->date_of_birth && strtolower(optional($firstStarredPerson)->date_of_birth) !== 'unknown' 
                            ? date('d M, Y', strtotime(optional($firstStarredPerson)->date_of_birth)) 
                            : '-'); ?></label>
                    </div>

                </div>

            </div>

            <?php else: ?>
            <div class="col-12">
                <div class="d-flex flex-column justify-content-center align-items-center h-100 people-starred-nodata-container">
                    <div class="d-flex flex-column align-items-center">
                        <img src="<?php echo e(asset('images/star.png')); ?>" class="people-starred-nodata-img" alt="">
                        <p class="people-empty-text">Hey, you haven't starred any peers!</p>
                    </div>
                </div>
            </div>


            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        </div>
    </div>
    <!-- End of Starred tab content -->


</div>


</div>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<!--[if BLOCK]><![endif]--><?php if($activeTab === 'everyone'): ?>
<!-- Everyone tab content -->
<div class="row mt-3 people-all-tabs-container">

    <div class="col-12 col-md-4 bg-white people-left-side-container">
        <div class="input-group people-input-group-container">
            <input wire:model="searchTerm" type="text" class="form-control people-search-input" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
            <div class="input-group-append">
                <button wire:click="filter" class="people-search-btn" type="button">
                    <i class="fa fa-search people-search-icon"></i>
                </button>
            </div>
        </div>
        <div class="mt-3">
            <!--[if BLOCK]><![endif]--><?php if($peopleData->isEmpty()): ?>
            <div class="container people-empty-text">No People Found</div>
            <?php else: ?>
            <div class="people-starred-list-container">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $peopleData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $people): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div wire:click="selectPerson('<?php echo e($people->emp_id); ?>')" class="container people-detail-container <?php echo e($selectedPerson && $selectedPerson->emp_id == $people->emp_id ? 'selected' : ''); ?>">
                    <div class="row align-items-center">
                        <div class="col-3">
                            <!--[if BLOCK]><![endif]--><?php if($people->image==""): ?>
                            <!--[if BLOCK]><![endif]--><?php if($people->gender=="Male"): ?>
                            <img class="people-profile-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt=" ">
                            <?php elseif($people->gender=="Female"): ?>
                            <img class="people-profile-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="">
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php else: ?>
                            <img class="people-profile-image" src="<?php echo e(Storage::url($people->image)); ?>" alt="">
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="col-md-9 col-12">
                            <?php
                            $starredPerson = DB::table('starred_peoples')
                            ->where('people_id', $people->emp_id)
                            ->where('starred_status', 'starred')
                            ->where('emp_id', auth()->guard('emp')->user()->emp_id)
                            ->first();
                            ?>
                            <div class="d-flex align-items-center">
                                <h6 class="username truncate-text people-default-container-name <?php if($people->employee_status != 'active'): ?> inactive <?php endif; ?>" title="<?php echo e(ucwords(strtolower($people->first_name))); ?> <?php echo e(ucwords(strtolower($people->last_name))); ?> (#<?php echo e($people->emp_id); ?>)"><?php echo e(ucwords(strtolower($people->first_name))); ?> <?php echo e(ucwords(strtolower($people->last_name))); ?></h6>
                                <p class="mb-0 people-default-container-empid <?php if($people->employee_status != 'active'): ?> inactive <?php endif; ?>">(#<?php echo e($people->emp_id); ?>)</p>
                                <!--[if BLOCK]><![endif]--><?php if($starredPerson && $starredPerson->starred_status == 'starred'): ?>
                                <i class="fa fa-star  people-default-star-icon"></i>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
    <div class="col-12 col-md-7 bg-white people-selectedperson-container">
        <!--[if BLOCK]><![endif]--><?php if($selectedPerson): ?>
        <!-- Code to display details when $selectStarredPeoples is set -->
        <div class="row">
            <div class="col-3">
                <!--[if BLOCK]><![endif]--><?php if(empty($selectedPerson->image) || $selectedPerson->image == ""): ?>
                <!--[if BLOCK]><![endif]--><?php if($selectedPerson->gender == "Male"): ?>
                <img class="people-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="">
                <?php elseif($selectedPerson->gender == "Female"): ?>
                <img class="people-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="">
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php else: ?>
                <img class="people-image" src="<?php echo e(Storage::url($selectedPerson->image)); ?>" alt="">
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            </div>
            <div class="col-md-7 col-12">
                <?php
                $starredPerson = DB::table('starred_peoples')
                ->where('people_id', $selectedPerson->emp_id)
                ->where('starred_status', 'starred')
                ->where('emp_id', auth()->guard('emp')->user()->emp_id)
                ->first();
                ?>
                <div class="people-selectedperson-detail-container">

                    <div class="d-flex align-items-center">
                        <h1 class="people-selectedperson-name"><?php echo e(ucwords(strtolower(optional($selectedPerson)->first_name ))); ?> <?php echo e(ucwords(strtolower(optional($selectedPerson)->last_name ))); ?></h1>
                        <a class="people-selectedperson-anchortag" wire:click="toggleStar('<?php echo e(optional($selectedPerson)->emp_id); ?>')">

                            <i class="fa fa-star <?php echo e($starredPerson && $starredPerson->starred_status == 'starred' ? 'people-text-blue' : 'text-white people-text-white'); ?> people-selected-person-star"></i>


                        </a>

                    </div>
                    <?php
                    $jobTitle = optional($selectedPerson)->job_role;
                    $convertedTitle = preg_replace('/\bII\b/', 'I', $jobTitle);
                    $convertedTitle = preg_replace('/\bII\b/', 'II', $jobTitle);
                    $convertedTitle = preg_replace('/\bIII\b/', 'III', $convertedTitle);
                    ?>
                    <p class="mb-0 people-selectedperson-empid"><?php echo e($convertedTitle); ?> (#<?php echo e(optional($selectedPerson)->emp_id); ?>)</p>
                </div>
                <br>
                <div class="d-flex align-items-center">
                    <span class="people-headings">CONTACT DETAILS</span>
                    <hr class="people-horizontal-line">
                </div>
                <br>
                <div class="row">
                    <label class="col-7 people-label">Mobile Number</label>
                    <label class="col-5 people-value"><?php echo e(optional($selectedPerson)->emergency_contact ?? '-'); ?></label>
                </div>
                <br>
                <div class="d-flex align-items-center">
                    <span class="people-headings">CATEGORY</span>
                    <hr class="people-horizontal-line">
                </div>
                <br>
                <div class="row">
                    <label class="col-7 people-label">Location</label>
                    <label class="col-5 people-value"><?php echo e(optional($selectedPerson)->job_location ?? '-'); ?></label>
                </div>
                <br>
                <div class="d-flex align-items-center">
                    <span class="people-headings">OTHER INFORMATION</span>
                    <hr class="people-horizontal-line">
                </div>
                <br>
                <div class="row">
                    <label class="col-7 people-label">Joining Date</label>
                    <label class="col-5 people-value"><?php echo e(optional($selectedPerson)->hire_date ? date('d M, Y', strtotime(optional($selectedPerson)->hire_date)) : '-'); ?></label>
                </div>
                <div class="row">
                    <label class="col-7 people-label">Date Of Birth</label>
                    <label class="col-5 people-value"><?php echo e(optional($selectedPerson)->date_of_birth ? date('d M, Y', strtotime(optional($selectedPerson)->date_of_birth)) : '-'); ?></label>
                </div>

            </div>

        </div>

        <?php elseif(!$peopleData->isEmpty()): ?>
        <!-- Code to display details of the first person in $starredPeoples when $selectStarredPeoples is not set -->
        <?php
        $firstPerson = $peopleData->first();
        $starredPerson = DB::table('starred_peoples')
        ->where('people_id', $firstPerson->emp_id)
        ->where('starred_status', 'starred')
        ->where('emp_id', auth()->guard('emp')->user()->emp_id)
        ->first();
        ?>
        <div class="row people-first-person-container">

            <div class="col-3">
                <img class="people-image" src="<?php echo e(Storage::url(optional($firstPerson)->image)); ?>" alt="">

            </div>
            <div class="col-md-7 col-12">
                <div class="people-selectedperson-detail-container">
                    <div class="d-flex align-items-center">
                        <h1 class="people-selectedperson-name"><?php echo e(ucwords(strtolower(optional($firstPerson)->first_name))); ?> <?php echo e(ucwords(strtolower(optional($firstPerson)->last_name))); ?></h1>
                        <a class="people-selectedperson-anchortag" wire:click="toggleStar('<?php echo e(optional($firstPerson)->emp_id); ?>')">

                            <i class="fa fa-star <?php echo e($starredPerson && $starredPerson->starred_status == 'starred' ? 'people-text-blue' : 'text-white people-text-white'); ?> people-selected-person-star"></i>


                        </a>

                    </div>
                    <?php
                    $jobTitle = optional($firstPerson)->job_role;
                    $convertedTitle = preg_replace('/\bII\b/', 'I', $jobTitle);
                    $convertedTitle = preg_replace('/\bII\b/', 'II', $jobTitle);
                    $convertedTitle = preg_replace('/\bIII\b/', 'III', $convertedTitle);
                    ?>
                    <p class="mb-0 people-selectedperson-empid"><?php echo e($convertedTitle); ?> (#<?php echo e(optional($firstPerson)->emp_id); ?>)</p>
                </div>
                <br>
                <div class="d-flex align-items-center">
                    <span class="people-headings">CONTACT DETAILS</span>
                    <hr class="people-horizontal-line">
                </div>
                <br>
                <div class="row">
                    <label class="col-7 people-label">Mobile Number</label>
                    <label class="col-5 people-value"><?php echo e(optional($firstPerson)->emergency_contact ?? '-'); ?></label>
                </div>
                <br>
                <div class="d-flex align-items-center">
                    <span class="people-headings">CATEGORY</span>
                    <hr class="people-horizontal-line">
                </div>
                <br>
                <div class="row">
                    <label class="col-7 people-label">Location</label>
                    <label class="col-5 people-value"><?php echo e(optional($firstPerson)->job_location ?? '-'); ?></label>
                </div>
                <br>
                <div class="d-flex align-items-center">
                    <span class="people-headings">OTHER INFORMATION</span>
                    <hr class="people-horizontal-line">
                </div>
                <br>
                <div class="row">
                    <label class="col-7 people-label">Joining Date</label>
                    <label class="col-5 people-value"><?php echo e(optional($firstPerson)->hire_date ? date('d M, Y', strtotime(optional($firstPerson)->hire_date)) : '-'); ?></label>
                </div>
                <div class="row">
                    <label class="col-7 people-label">Date Of Birth</label>
                    <label class="col-5 people-value"><?php echo e(optional($firstPerson)->date_of_birth ? date('d M, Y', strtotime(optional($firstPerson)->date_of_birth)) : '-'); ?></label>
                </div>

            </div>

        </div>

        <?php else: ?>
        <div class="col-12">
            <div class="d-flex flex-column justify-content-center align-items-center h-100 people-nodata-container">
                <div class="d-flex flex-column align-items-center">
                    <img class="people-nodata-img" src="<?php echo e(asset('images/nodata.png')); ?>" alt="">
                    <p class="people-empty-text">No People Found!</p>
                </div>
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

</div>
</div>
<!-- End of Starred tab content -->


</div>


</div>

</div>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->

<!--[if BLOCK]><![endif]--><?php if($activeTab === 'myteam'): ?>
<!-- MyTeam tab content -->
<div class="row mt-3 people-all-tabs-container">
    <!-- Search input and filter button -->
    <div class="col-12 col-md-4 bg-white people-left-side-container">

        <div class="input-group people-input-group-container">
            <input wire:model="searchTerm" type="text" class="form-control people-search-input" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
            <div class="input-group-append">
                <button wire:click="filterMyTeam" class="people-search-btn" type="button">
                    <i class="fa fa-search people-search-icon"></i>
                </button>
            </div>
        </div>

        <div class="mt-3">
            <!--[if BLOCK]><![endif]--><?php if($myTeamData->isEmpty()): ?>
            <div class="container people-empty-text">No People Found</div>
            <?php else: ?>
            <div class="people-starred-list-container">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $myTeamData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $people): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div wire:click="selectMyTeamPerson('<?php echo e($people->emp_id); ?>')" class="container people-detail-container <?php echo e($selectedMyTeamPerson && $selectedMyTeamPerson->emp_id == $people->emp_id ? 'selected' : ''); ?>">
                    <div class="row align-items-center">
                        <div class="col-3">
                            <!--[if BLOCK]><![endif]--><?php if($people->image==""): ?>
                            <!--[if BLOCK]><![endif]--><?php if($people->gender=="Male"): ?>
                            <img class="people-profile-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt=" ">
                            <?php elseif($people->gender=="Female"): ?>
                            <img class="people-profile-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="">
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php else: ?>
                            <img class="people-profile-image" src="<?php echo e(Storage::url($people->image)); ?>" alt="">
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="col-md-9 col-12">
                            <?php
                            $starredPerson = DB::table('starred_peoples')
                            ->where('people_id', $people->emp_id)
                            ->where('starred_status', 'starred')
                            ->where('emp_id', auth()->guard('emp')->user()->emp_id)
                            ->first();
                            ?>
                            <div class="d-flex align-items-center">
                                <h6 class="username truncate-text people-default-container-name <?php if($people->employee_status != 'active'): ?> inactive <?php endif; ?>" title="<?php echo e(ucwords(strtolower($people->first_name))); ?> <?php echo e(ucwords(strtolower($people->last_name))); ?> (#<?php echo e($people->emp_id); ?>)"><?php echo e(ucwords(strtolower($people->first_name))); ?> <?php echo e(ucwords(strtolower($people->last_name))); ?></h6>
                                <p class="mb-0 people-default-container-empid <?php if($people->employee_status != 'active'): ?> inactive <?php endif; ?>">(#<?php echo e($people->emp_id); ?>)</p>
                                <!--[if BLOCK]><![endif]--><?php if($starredPerson && $starredPerson->starred_status == 'starred'): ?>
                                <i class="fa fa-star people-default-star-icon"></i>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>

    <!-- Details of the selected person -->
    <div class="col-12 col-md-7 bg-white people-selectedperson-container">
        <!--[if BLOCK]><![endif]--><?php if($selectedMyTeamPerson): ?>
        <!-- Code to display details when $selectStarredPeoples is set -->
        <div class="row">
            <div class="col-3">
                <!--[if BLOCK]><![endif]--><?php if(empty($selectedMyTeamPerson->image) || $selectedMyTeamPerson->image == ""): ?>
                <!--[if BLOCK]><![endif]--><?php if($selectedMyTeamPerson->gender == "Male"): ?>
                <img class="people-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="">
                <?php elseif($selectedMyTeamPerson->gender == "Female"): ?>
                <img class="people-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="">
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php else: ?>
                <img class="people-image" src="<?php echo e(Storage::url($selectedMyTeamPerson->image)); ?>" alt="">
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            </div>
            <div class="col-md-7 col-12">
                <?php
                $starredPerson = DB::table('starred_peoples')
                ->where('people_id', $selectedMyTeamPerson->emp_id)
                ->where('starred_status', 'starred')
                ->where('emp_id', auth()->guard('emp')->user()->emp_id)
                ->first();
                ?>
                <div class="people-selectedperson-detail-container">
                    <div class="d-flex align-items-center">
                        <h1 class="people-selectedperson-name"><?php echo e(ucwords(strtolower(optional($selectedMyTeamPerson)->first_name ))); ?> <?php echo e(ucwords(strtolower(optional($selectedMyTeamPerson)->last_name ))); ?></h1>
                        <a class="people-selectedperson-anchortag" wire:click="toggleStar('<?php echo e(optional($selectedMyTeamPerson)->emp_id); ?>')">

                            <i class="fa fa-star <?php echo e($starredPerson && $starredPerson->starred_status == 'starred' ? 'people-text-blue' : 'text-white people-text-white'); ?> people-selected-person-star"></i>


                        </a>

                    </div>
                    <?php
                    $jobTitle = optional($selectedMyTeamPerson)->job_role;
                    $convertedTitle = preg_replace('/\bII\b/', 'I', $jobTitle);
                    $convertedTitle = preg_replace('/\bII\b/', 'II', $jobTitle);
                    $convertedTitle = preg_replace('/\bIII\b/', 'III', $convertedTitle);
                    ?>
                    <p class="mb-0 people-selectedperson-empid"><?php echo e($convertedTitle); ?> (#<?php echo e(optional($selectedMyTeamPerson)->emp_id); ?>)</p>
                </div>
                <br>
                <div class="d-flex align-items-center">
                    <span class="people-headings">CONTACT DETAILS</span>
                    <hr class="people-horizontal-line">
                </div>
                <br>
                <div class="row">
                    <label class="col-7 people-label">Mobile Number</label>
                    <label class="col-5 people-value"><?php echo e(optional($selectedMyTeamPerson)->emergency_contact ?? '-'); ?></label>
                </div>
                <br>
                <div class="d-flex align-items-center">
                    <span class="people-headings">CATEGORY</span>
                    <hr class="people-horizontal-line">
                </div>
                <br>
                <div class="row">
                    <label class="col-7 people-label">Location</label>
                    <label class="col-5 people-value"><?php echo e(optional($selectedMyTeamPerson)->job_location ?? '-'); ?></label>
                </div>
                <br>
                <div class="d-flex align-items-center">
                    <span class="people-headings">OTHER INFORMATION</span>
                    <hr class="people-horizontal-line">
                </div>
                <br>
                <div class="row">
                    <label class="col-7 people-label">Joining Date</label>
                    <label class="col-5 people-value"><?php echo e(optional($selectedMyTeamPerson)->hire_date ? date('d M, Y', strtotime(optional($selectedMyTeamPerson)->hire_date)) : '-'); ?></label>
                </div>
                <div class="row">
                    <label class="col-7 people-label">Date Of Birth</label>
                    <label class="col-5 people-value"><?php echo e(optional($selectedMyTeamPerson)->date_of_birth ? date('d M, Y', strtotime(optional($selectedMyTeamPerson)->date_of_birth)) : '-'); ?></label>
                </div>

            </div>

        </div>
        <?php elseif(!$myTeamData->isEmpty()): ?>
        <!-- Code to display details of the first person in $starredPeoples when $selectStarredPeoples is not set -->
        <?php
        $firstPerson = $myTeamData->first();
        $starredPerson = DB::table('starred_peoples')
        ->where('people_id', $firstPerson->emp_id)
        ->where('starred_status', 'starred')
        ->where('emp_id', auth()->guard('emp')->user()->emp_id)
        ->first();
        ?>
        <div class="row people-first-person-container">

            <div class="col-3">
                <img class="people-image" src="<?php echo e(Storage::url(optional($firstPerson)->image)); ?>" alt="">

            </div>
            <div class="col-md-7 col-12">
                <div class="people-selectedperson-detail-container">
                    <div class="d-flex align-items-center">
                        <h1 class="people-selectedperson-name"><?php echo e(ucwords(strtolower(optional($firstPerson)->first_name))); ?> <?php echo e(ucwords(strtolower(optional($firstPerson)->last_name))); ?></h1>
                        <a class="people-selectedperson-anchortag" wire:click="toggleStar('<?php echo e(optional($firstPerson)->emp_id); ?>')">

                            <i class="fa fa-star <?php echo e($starredPerson && $starredPerson->starred_status == 'starred' ? 'people-text-blue' : 'text-white people-text-white'); ?> people-selected-person-star"></i>

                        </a>

                    </div>
                    <?php
                    $jobTitle = optional($firstPerson)->job_role;
                    $convertedTitle = preg_replace('/\bII\b/', 'I', $jobTitle);
                    $convertedTitle = preg_replace('/\bII\b/', 'II', $jobTitle);
                    $convertedTitle = preg_replace('/\bIII\b/', 'III', $convertedTitle);
                    ?>
                    <p class="mb-0 people-selectedperson-empid"><?php echo e($convertedTitle); ?> (#<?php echo e(optional($firstPerson)->emp_id); ?>)</p>
                </div>
                <br>
                <div class="d-flex align-items-center">
                    <span class="people-headings">CONTACT DETAILS</span>
                    <hr class="people-horizontal-line">
                </div>
                <br>
                <div class="row">
                    <label class="col-7 people-label">Mobile Number</label>
                    <label class="col-5 people-value"><?php echo e(optional($firstPerson)->emergency_contact ?? '-'); ?></label>
                </div>
                <br>
                <div class="d-flex align-items-center">
                    <span class="people-headings">CATEGORY</span>
                    <hr class="people-horizontal-line">
                </div>
                <br>
                <div class="row">
                    <label class="col-7 people-label">Location</label>
                    <label class="col-5 people-value"><?php echo e(optional($firstPerson)->job_location ?? '-'); ?></label>
                </div>
                <br>
                <div class="d-flex align-items-center">
                    <span class="people-headings">OTHER INFORMATION</span>
                    <hr class="people-horizontal-line">
                </div>
                <br>
                <div class="row">
                    <label class="col-7 people-label">Joining Date</label>
                    <label class="col-5 people-value"><?php echo e(optional($firstPerson)->hire_date ? date('d M, Y', strtotime(optional($firstPerson)->hire_date)) : '-'); ?></label>
                </div>
                <div class="row">
                    <label class="col-7 people-label">Date Of Birth</label>
                    <label class="col-5 people-value"><?php echo e(optional($firstPerson)->date_of_birth ? date('d M, Y', strtotime(optional($firstPerson)->date_of_birth)) : '-'); ?></label>
                </div>

            </div>

        </div>
        <?php else: ?>
        <div class="col-12">
            <div class="d-flex flex-column justify-content-center align-items-center h-100 people-nodata-container">
                <div class="d-flex flex-column align-items-center">
                    <img class="people-nodata-img" src="<?php echo e(asset('images/nodata.png')); ?>" alt="">
                    <p class="people-empty-text">No People Found!</p>
                </div>
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    </div>
</div>
<!-- End of Everyone tab content -->
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/peoples.blade.php ENDPATH**/ ?>