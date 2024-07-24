<!-- resources/views/livewire/people-lists.blade.php -->

<div>
    <div class="container mt-3">
        @if(session()->has('emp_error'))
        <div class="alert alert-danger">
            {{ session('emp_error') }}
        </div>
        @endif


        @php
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $mangerid = DB::table('employee_details')
        ->join('companies', 'employee_details.company_id', '=', 'companies.company_id')
        ->where('employee_details.manager_id', $employeeId)
        ->select('companies.company_logo', 'companies.company_name')
        ->first();
        @endphp
        @if ($mangerid)
        <div class="row justify-content-center" style="width: 35%; position: relative; padding-left: 30px;">
            <div class="col-4 text-center" style="border-radius: 5px; cursor: pointer;">
                <a id="starred-tab-link" style="text-decoration: none; font-size: 13px; color: {{ $activeTab === 'starred' ? 'rgb(2, 17, 79);' : '#333' }}" wire:click="$set('activeTab', 'starred')" class="links">
                    Starred
                </a>
            </div>
            <div class="col-4 text-center" style="border-radius: 5px; cursor: pointer;">
                <a id="myteam-tab-link" style="text-decoration: none; font-size: 13px; color: {{ $activeTab === 'myteam' ? 'rgb(2, 17, 79);' : '#333' }}" wire:click="$set('activeTab', 'myteam')" class="links">
                    My Team
                </a>
            </div>
            <div class="col-4 text-center" style="border-radius: 5px; cursor: pointer;">
                <a id="everyone-tab-link" style="text-decoration: none; font-size: 13px; color: {{ $activeTab === 'everyone' ? 'rgb(2, 17, 79);' : '#333' }}" wire:click="$set('activeTab', 'everyone')" class="links">
                    Everyone
                </a>
            </div>

            <div style="transition: left 0.3s ease-in-out; position: absolute; bottom: -11px; left: {{ $activeTab === 'starred' ? '30px' : ($activeTab === 'myteam' ? '39%' : '70%') }}; width: 30%; height: 4px; background-color: rgb(2, 17, 79); border-radius: 5px;"></div>
        </div>
        @else
        <div class="row justify-content-start" style="width: 40%; position: relative; padding-left: 40px;">
            <div class="col-3 text-start" style="border-radius: 5px; cursor: pointer;">
                <a id="starred-tab-link" style="text-decoration: none; font-size: 13px; color: {{ $activeTab === 'starred' ? 'rgb(2, 17, 79);' : '#333' }}" wire:click="$set('activeTab', 'starred')" class="links">
                    Starred
                </a>
            </div>
            <div class="col-3 text-start" style="border-radius: 5px; cursor: pointer;">
                <a id="everyone-tab-link" style="text-decoration: none; font-size: 13px; color: {{ $activeTab === 'everyone' ? 'rgb(2, 17, 79);' : '#333' }}" wire:click="$set('activeTab', 'everyone')" class="links">
                    Everyone
                </a>
            </div>
            <div style="transition: left 0.3s ease-in-out; position: absolute; bottom: -11px; left: {{ $activeTab === 'starred' ? '30px' : '118px' }}; width: 26%; height: 4px; background-color: rgb(2, 17, 79); border-radius: 5px;"></div>
        </div>
        @endif


        @if ($activeTab === 'starred')
        <!-- Starred tab content -->
        <div class="row mt-3" style="padding-left: 30px;">

            <div class="col-12 col-md-4 bg-white w-100" style="margin-right: 20px; padding: 20px; border-radius: 5px; height: 450px;">
                <div class="input-group" style="margin-bottom: 30px;">
                    <input wire:model="search" style="font-size: 10px; border-radius: 5px 0 0 5px; cursor: pointer" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                    <div class="input-group-append">
                        <button wire:click="starredFilter" style="height: 29px; width: 40px; position: relative; border-radius: 0 5px 5px 0; background-color: rgb(2, 17, 79);; color: #fff; border: none;" class="btn" type="button">
                            <i style="position: absolute; top: 7px; left: 11px;" class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="mt-3" style="max-height: 350px; overflow-y: auto; overflow-x: hidden;">
                    @if ($starredPeoples->isEmpty())
                    <div class="container" style="text-align: center; color: #778899; font-size: 12px;">Looks like you don't have any records</div>
                    @else
                    @foreach ($starredPeoples->where('starred_status', 'starred') as $people)
                    <div wire:click="starredPersonById('{{ $people->id }}')" class="container people-detail-container" style="height:auto;cursor: pointer; background-color: {{ $selectStarredPeoples && $selectStarredPeoples->id == $people->id ? '#f3faff' : 'white' }}; padding: 5px; margin-bottom: 8px;  border-radius: 5px; border: 1px solid #ccc;">
                        <div class="row align-items-center">
                            <div class="col-3">
                                @if($people->profile == "")
                                @if($people->emp->gender == "Male")
                                <img class="people-profile-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="">
                                @elseif($people->emp->gender == "Female")
                                <img class="people-profile-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="">
                                @endif
                                @else
                                <img class="people-profile-image" src="{{ Storage::url($people->profile) }}" alt="">
                                @endif

                            </div>
                            <div class="col-9">
                                <div style="display: flex; align-items: center;">
                                    <h6 style="font-size: 12px; color: black; margin-right: 5px;" class="username truncate-text" title="{{ ucwords(strtolower($people->name)) }} (#{{ $people->emp_id }})">{{ ucwords(strtolower($people->name)) }}</h6>
                                    <p class="mb-0" style="font-size: 12px; color: #333;white-space: nowrap;">(#{{ $people->people_id }})</p>
                                </div>
                                <!-- <h6 class="username truncate-text" title="{{ ucwords(strtolower($people->name)) }}" style="font-size: 12px; color: white;">{{ ucwords(strtolower($people->name)) }}</h6>
                            </div>
                            <div class="col-2">
                                <p class="mb-0" style="font-size: 12px; color: white;font-size:8px;white-space: nowrap;">(#{{ $people->people_id }})</p> -->
                            </div>

                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            <!-- Details of the selected person -->
            <div class="col-12 col-md-7 bg-white w-100" style="border-radius: 5px; padding: 20px; height: 450px;">
                @if ($selectStarredPeoples)
                <!-- Code to display details when $selectStarredPeoples is set -->
                <div class="row">
                    <div class="col-3">
                        @if(empty($selectStarredPeoples->profile) || $selectStarredPeoples->profile == "")
                        @if($selectStarredPeoples->emp->gender == "Male")
                        <img class="people-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="">
                        @elseif($selectStarredPeoples->emp->gender == "Female")
                        <img class="people-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="Profile Image">
                        @endif
                        @else
                        <img class="people-image" src="{{ Storage::url($selectStarredPeoples->profile) }}" alt="">
                        @endif

                    </div>
                    <div class="col-7">
                        <div style="background: #f9f9f9; padding: 10px;">
                            <div style="display: flex; align-items: center;">
                                <h1 style="font-size: 16px; margin-right: 5px;">{{ ucwords(strtolower(optional($selectStarredPeoples)->name)) }}</h1>
                                <a style="text-decoration: none;" wire:click="removeToggleStar('{{ optional($selectStarredPeoples)->people_id }}')">

                                    <i class="fa fa-star" style="cursor: pointer; color: yellow; margin-bottom: 10px;"></i>

                                </a>

                            </div>
                            <p class="mb-0" style="color: #778899; font-size: 14px;">(#{{ optional($selectStarredPeoples)->people_id }})</p>
                        </div>
                        <br>
                        <div style="display: flex; align-items: center;">
                            <span style="margin-right: 10px; font-weight:500; color: #778899; font-size: 12px;">CONTACT DETAILS</span>
                            <hr style="flex-grow: 1; width: 50px; color: black; border: 1px solid #778899; margin: 0;">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-6" style="color: #778899; font-size: 13px;">Mobile Number</label>
                            <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($selectStarredPeoples)->contact_details }}</label>
                        </div>
                        <br>
                        <div style="display: flex; align-items: center;">
                            <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">CATEGORY</span>
                            <hr style="flex-grow: 1; width: 50px; color: black; border: 1px solid #778899; margin: 0;">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-6" style="color: #778899; font-size: 13px;">Location</label>
                            <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($selectStarredPeoples)->location }}</label>
                        </div>
                        <br>
                        <div style="display: flex; align-items: center;">
                            <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">OTHER INFORMATION</span>
                            <hr style="flex-grow: 1; width: 50px; color: #333; border: 1px solid #778899; margin: 0;">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-6" style="color: #778899; font-size: 13px;">Joining Date</label>
                            <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($selectStarredPeoples)->joining_date ? date('d M, Y', strtotime(optional($selectedPerson)->joining_date)) : '' }}</label>
                        </div>
                        <div class="row">
                            <label class="col-6" style="color: #778899; font-size: 13px;">Date Of Birth</label>
                            <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($selectStarredPeoples)->date_of_birth ? date('d M, Y', strtotime(optional($selectStarredPeoples)->date_of_birth)) : '' }}</label>
                        </div>

                    </div>
                </div>
            </div>
            @elseif (!$starredPeoples->isEmpty())

            <!-- Code to display details of the first person in $starredPeoples when $selectStarredPeoples is not set -->
            @php
            $firstStarredPerson = $starredPeoples->first();
            @endphp
            <div class="row" style="font-size: 13px; padding: 10px; height: 450px;">

                <div class="col-3">
                    @if(empty($firstStarredPerson->profile) || $firstStarredPerson->profile == "")
                    @if($firstStarredPerson->emp->gender == "Male")
                    <img class="people-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="">
                    @elseif($firstStarredPerson->emp->gender == "Female")
                    <img class="people-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="">
                    @endif
                    @else
                    <img class="people-image" src="{{ Storage::url($firstStarredPerson->profile) }}" alt="">
                    @endif
                </div>
                <div class="col-7">
                    <div style="background: #f9f9f9; padding: 10px;">
                        <div style="display: flex; align-items: center;">
                            <h1 style="font-size: 16px; margin-right: 5px;">{{ ucwords(strtolower(optional($firstStarredPerson)->name)) }}</h1>
                            <a style="text-decoration: none;" wire:click="removeToggleStar('{{ optional($firstStarredPerson)->people_id }}')">

                                <i class="fa fa-star" style="cursor: pointer; color: yellow; margin-bottom: 10px;"></i>

                            </a>

                        </div>
                        <p class="mb-0" style="color: #778899; font-size: 14px;">(#{{ optional($firstStarredPerson)->people_id }})</p>
                    </div>
                    <br>
                    <div style="display: flex; align-items: center;">
                        <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">CONTACT DETAILS</span>
                        <hr style="flex-grow: 1; width: 50px; color: black; border: 1px solid #778899; margin: 0;">
                    </div>
                    <br>
                    <div class="row">
                        <label class="col-6" style="color: #778899; font-size: 13px;">Mobile Number</label>
                        <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($firstStarredPerson)->contact_details }}</label>
                    </div>
                    <br>
                    <div style="display: flex; align-items: center;">
                        <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">CATEGORY</span>
                        <hr style="flex-grow: 1; width: 50px; color: black; border: 1px solid #778899; margin: 0;">
                    </div>
                    <br>
                    <div class="row">
                        <label class="col-6" style="color: #778899; font-size: 13px;">Location</label>
                        <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($firstStarredPerson)->location }}</label>
                    </div>
                    <br>
                    <div style="display: flex; align-items: center;">
                        <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">OTHER INFORMATION</span>
                        <hr style="flex-grow: 1; width: 50px; color: #333; border: 1px solid #778899; margin: 0;">
                    </div>
                    <br>
                    <div class="row">
                        <label class="col-6" style="color: #778899; font-size: 13px;">Joining Date</label>
                        <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($firstStarredPerson)->joining_date ? date('d M, Y', strtotime(optional($firstStarredPerson)->joining_date)) : '' }}</label>
                    </div>
                    <div class="row">
                        <label class="col-6" style="color: #778899; font-size: 13px;">Date Of Birth</label>
                        <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($firstStarredPerson)->date_of_birth ? date('d M, Y', strtotime(optional($firstStarredPerson)->date_of_birth)) : '' }}</label>
                    </div>

                </div>

            </div>

            @else
            <div class="col-12">
                <div class="d-flex flex-column justify-content-center align-items-center h-100" style="margin-top: 140px">
                    <div class="d-flex flex-column align-items-center">
                        <img src="{{ asset('images/star.png') }}" style="height: 150px; width: 150px;" alt="">
                        <p style="text-align: center; color: #778899; font-size: 12px;">Hey, you haven't starred any peers!</p>
                    </div>
                </div>
            </div>


            @endif

        </div>
    </div>
    <!-- End of Starred tab content -->


</div>


</div>
@endif
@if ($activeTab === 'everyone')
<!-- Everyone tab content -->
<div class="row mt-3" style="padding-left: 30px;">

    <div class="col-12 col-md-4 bg-white w-100" style="margin-right: 20px; padding: 20px; border-radius: 5px; height: 450px;">
        <div class="input-group" style="margin-bottom: 30px;">
            <input wire:model="searchTerm" style="font-size: 10px; border-radius: 5px 0 0 5px; cursor: pointer" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
            <div class="input-group-append">
                <button wire:click="filter" style="height: 29px; width: 40px; position: relative; border-radius: 0 5px 5px 0; background-color: rgb(2, 17, 79);; color: #fff; border: none;" class="btn" type="button">
                    <i style="position: absolute; top: 7px; left: 11px;" class="fa fa-search"></i>
                </button>
            </div>
        </div>
        <div class="mt-3">
            @if ($peopleData->isEmpty())
            <div class="container" style="text-align: center; color: #778899; font-size: 12px;">No People Found</div>
            @else
            <div style="max-height:350px;overflow-y:auto; overflow-x:hidden;">
                @foreach($peopleData as $people)
                <div wire:click="selectPerson('{{ $people->emp_id }}')" class="container people-detail-container" style="height:auto;cursor: pointer; background-color: {{ $selectedPerson && $selectedPerson->emp_id == $people->emp_id ? '#f3faff' : 'white' }}; padding: 5px; margin-bottom: 8px; border-radius: 5px; border: 1px solid #ccc;">
                    <div class="row align-items-center">
                        <div class="col-3">
                            @if($people->image=="")
                            @if($people->gender=="Male")
                            <img class="people-profile-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt=" ">
                            @elseif($people->gender=="Female")
                            <img class="people-profile-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="">
                            @endif
                            @else
                            <img class="people-profile-image" src="{{ Storage::url($people->image) }}" alt="">
                            @endif
                        </div>
                        <div class="col-9">
                            @php
                            $starredPerson = DB::table('starred_peoples')
                            ->where('people_id', $people->emp_id)
                            ->where('starred_status', 'starred')
                            ->where('emp_id', auth()->guard('emp')->user()->emp_id)
                            ->first();
                            @endphp
                            <div style="display: flex; align-items: center;">
                                <h6 style="font-size: 12px; color: black; margin-right: 5px;" class="username truncate-text" title="{{ ucwords(strtolower($people->first_name)) }} {{ ucwords(strtolower($people->last_name)) }} (#{{ $people->emp_id }})">{{ ucwords(strtolower($people->first_name)) }} {{ ucwords(strtolower($people->last_name)) }}</h6>
                                <p class="mb-0" style="font-size: 12px; color: #333;white-space: nowrap;">(#{{ $people->emp_id }})</p>
                                @if($starredPerson && $starredPerson->starred_status == 'starred')
                                <i class="fa fa-star text-yellow" style="cursor: pointer; font-size: 12px;padding-left: 6px;"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    <div class="col-12 col-md-7 bg-white w-100" style="border-radius: 5px; padding: 20px; height: 450px;">
        @if ($selectedPerson)
        <!-- Code to display details when $selectStarredPeoples is set -->
        <div class="row">
            <div class="col-3">
                @if(empty($selectedPerson->image) || $selectedPerson->image == "")
                @if($selectedPerson->gender == "Male")
                <img class="people-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="">
                @elseif($selectedPerson->gender == "Female")
                <img class="people-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="">
                @endif
                @else
                <img class="people-image" src="{{ Storage::url($selectedPerson->image) }}" alt="">
                @endif

            </div>
            <div class="col-7">
                @php
                $starredPerson = DB::table('starred_peoples')
                ->where('people_id', $selectedPerson->emp_id)
                ->where('starred_status', 'starred')
                ->where('emp_id', auth()->guard('emp')->user()->emp_id)
                ->first();
                @endphp
                <div style="background: #f9f9f9; padding: 10px;">

                    <div style="display: flex; align-items: center;">
                        <h1 style="font-size: 16px; margin-right: 5px;">{{ ucwords(strtolower(optional($selectedPerson)->first_name )) }} {{ ucwords(strtolower(optional($selectedPerson)->last_name )) }}</h1>
                        <a style="text-decoration: none;" wire:click="toggleStar('{{ optional($selectedPerson)->emp_id }}')">

                            <i class="fa fa-star{{ $starredPerson && $starredPerson->starred_status == 'starred' ? ' text-yellow' : ' text-gray' }}" style="cursor: pointer; margin-bottom: 10px;"></i>


                        </a>

                    </div>
                    <p class="mb-0" style="color: #778899; font-size: 14px;">(#{{ optional($selectedPerson)->emp_id }})</p>
                </div>
                <br>
                <div style="display: flex; align-items: center;">
                    <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">CONTACT DETAILS</span>
                    <hr style="flex-grow: 1; width: 50px; color: black; border: 1px solid #778899; margin: 0;">
                </div>
                <br>
                <div class="row">
                    <label class="col-6" style="color: #778899; font-size: 13px;">Mobile Number</label>
                    <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($selectedPerson)->mobile_number }}</label>
                </div>
                <br>
                <div style="display: flex; align-items: center;">
                    <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">CATEGORY</span>
                    <hr style="flex-grow: 1; width: 50px; color: black; border: 1px solid #778899; margin: 0;">
                </div>
                <br>
                <div class="row">
                    <label class="col-6" style="color: #778899; font-size: 13px;">Location</label>
                    <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($selectedPerson)->job_location }}</label>
                </div>
                <br>
                <div style="display: flex; align-items: center;">
                    <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">OTHER INFORMATION</span>
                    <hr style="flex-grow: 1; width: 50px; color: #333; border: 1px solid #778899; margin: 0;">
                </div>
                <br>
                <div class="row">
                    <label class="col-6" style="color: #778899; font-size: 13px;">Joining Date</label>
                    <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($selectedPerson)->hire_date ? date('d M, Y', strtotime(optional($selectedPerson)->hire_date)) : '' }}</label>
                </div>
                <div class="row">
                    <label class="col-6" style="color: #778899; font-size: 13px;">Date Of Birth</label>
                    <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($selectedPerson)->date_of_birth ? date('d M, Y', strtotime(optional($selectedPerson)->date_of_birth)) : '' }}</label>
                </div>

            </div>

        </div>

        @elseif (!$peopleData->isEmpty())
        <!-- Code to display details of the first person in $starredPeoples when $selectStarredPeoples is not set -->
        @php
        $firstPerson = $peopleData->first();
        $starredPerson = DB::table('starred_peoples')
        ->where('people_id', $firstPerson->emp_id)
        ->where('starred_status', 'starred')
        ->where('emp_id', auth()->guard('emp')->user()->emp_id)
        ->first();
        @endphp
        <div class="row" style="font-size: 13px; padding: 10px; height: 450px;">

            <div class="col-3">
                <img class="people-image" src="{{ Storage::url(optional($firstPerson)->image) }}" alt="">

            </div>
            <div class="col-7">
                <div style="background: #f9f9f9; padding: 10px;">
                    <div style="display: flex; align-items: center;">
                        <h1 style="font-size: 16px; margin-right: 5px;">{{ ucwords(strtolower(optional($firstPerson)->first_name)) }} {{ ucwords(strtolower(optional($firstPerson)->last_name)) }}</h1>
                        <a style="text-decoration: none;" wire:click="toggleStar('{{ optional($firstPerson)->emp_id }}')">

                            <i class="fa fa-star{{ $starredPerson && $starredPerson->starred_status == 'starred' ? ' text-yellow' : ' text-gray' }}" style="cursor: pointer; margin-bottom: 10px;"></i>


                        </a>

                    </div>
                    <p class="mb-0" style="color: #778899; font-size: 14px;">(#{{ optional($firstPerson)->emp_id }})</p>
                </div>
                <br>
                <div style="display: flex; align-items: center;">
                    <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">CONTACT DETAILS</span>
                    <hr style="flex-grow: 1; width: 50px; color: black; border: 1px solid black; margin: 0;">
                </div>
                <br>
                <div class="row">
                    <label class="col-6" style="color: #778899; font-size: 13px;">Mobile Number</label>
                    <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($firstPerson)->mobile_number }}</label>
                </div>
                <br>
                <div style="display: flex; align-items: center;">
                    <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">CATEGORY</span>
                    <hr style="flex-grow: 1; width: 50px; color: black; border: 1px solid black; margin: 0;">
                </div>
                <br>
                <div class="row">
                    <label class="col-6" style="color: #778899; font-size: 13px;">Location</label>
                    <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($firstPerson)->job_location }}</label>
                </div>
                <br>
                <div style="display: flex; align-items: center;">
                    <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">OTHER INFORMATION</span>
                    <hr style="flex-grow: 1; width: 50px; color: #333; border: 1px solid black; margin: 0;">
                </div>
                <br>
                <div class="row">
                    <label class="col-6" style="color: #778899; font-size: 13px;">Joining Date</label>
                    <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($firstPerson)->hire_date ? date('d M, Y', strtotime(optional($firstPerson)->hire_date)) : '' }}</label>
                </div>
                <div class="row">
                    <label class="col-6" style="color: #778899; font-size: 13px;">Date Of Birth</label>
                    <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($firstPerson)->date_of_birth ? date('d M, Y', strtotime(optional($firstPerson)->date_of_birth)) : '' }}</label>
                </div>

            </div>

        </div>

        @else
        <div class="col-12">
            <div class="d-flex flex-column justify-content-center align-items-center h-100" style="margin-top: 100px">
                <div class="d-flex flex-column align-items-center">
                    <img src="{{ asset('images/nodata.png') }}" style="height: 200px; width: 200px;" alt="">
                    <p style="text-align: center; color: #778899;font-size: 12px;">No People Found!</p>
                </div>
            </div>
        </div>
        @endif
    </div>

</div>
</div>
<!-- End of Starred tab content -->


</div>


</div>

</div>
@endif

@if ($activeTab === 'myteam')
<!-- MyTeam tab content -->
<div class="row mt-3" style="padding-left: 30px;">
    <!-- Search input and filter button -->
    <div class="col-12 col-md-4 bg-white w-100" style="margin-right: 20px; padding: 20px; border-radius: 5px; height: 450px;">

        <div class="input-group" style="margin-bottom: 30px;">
            <input wire:model="searchTerm" style="font-size: 10px; border-radius: 5px 0 0 5px; cursor: pointer" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
            <div class="input-group-append">
                <button wire:click="filterMyTeam" style="height: 29px; width: 40px;position: relative; border-radius: 0 5px 5px 0; background-color: rgb(2, 17, 79);; color: #fff; border: none;" class="btn" type="button">
                    <i style="position: absolute; top: 7px; left: 11px;" class="fa fa-search"></i>
                </button>
            </div>
        </div>

        <div class="mt-3">
            @if ($myTeamData->isEmpty())
            <div class="container" style="text-align: center; color: #778899; font-size: 12px;">No People Found</div>
            @else
            <div style="max-height:350px;overflow-y:auto; overflow-x:hidden;">
                @foreach($myTeamData as $people)
                <div wire:click="selectMyTeamPerson('{{ $people->emp_id }}')" class="container people-detail-container" style="height:auto;cursor: pointer; background-color: {{ $selectedMyTeamPerson && $selectedMyTeamPerson->emp_id == $people->emp_id ? '#f3faff' : 'white' }}; padding: 5px; margin-bottom: 8px; border-radius: 5px; border: 1px solid #ccc;">
                    <div class="row align-items-center">
                        <div class="col-3">
                            @if($people->image=="")
                            @if($people->gender=="Male")
                            <img class="people-profile-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt=" ">
                            @elseif($people->gender=="Female")
                            <img class="people-profile-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="">
                            @endif
                            @else
                            <img class="people-profile-image" src="{{ Storage::url($people->image) }}" alt="">
                            @endif
                        </div>
                        <div class="col-9">
                            @php
                            $starredPerson = DB::table('starred_peoples')
                            ->where('people_id', $people->emp_id)
                            ->where('starred_status', 'starred')
                            ->where('emp_id', auth()->guard('emp')->user()->emp_id)
                            ->first();
                            @endphp
                            <div style="display: flex; align-items: center;">
                                <h6 style="font-size: 12px; color: black; margin-right: 5px;" class="username truncate-text" title="{{ ucwords(strtolower($people->first_name)) }} {{ ucwords(strtolower($people->last_name)) }} (#{{ $people->emp_id }})">{{ ucwords(strtolower($people->first_name)) }} {{ ucwords(strtolower($people->last_name)) }}</h6>
                                <p class="mb-0" style="font-size: 12px; color: #333;white-space: nowrap;">(#{{ $people->emp_id }})</p>
                                @if($starredPerson && $starredPerson->starred_status == 'starred')
                                <i class="fa fa-star text-yellow" style="cursor: pointer; font-size: 12px;padding-left: 6px;"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <!-- Details of the selected person -->
    <div class="col-12 col-md-7 bg-white w-100" style="border-radius: 5px; padding: 20px; height: 450px;">
        @if ($selectedMyTeamPerson)
        <!-- Code to display details when $selectStarredPeoples is set -->
        <div class="row">
            <div class="col-3">
                @if(empty($selectedMyTeamPerson->image) || $selectedMyTeamPerson->image == "")
                @if($selectedMyTeamPerson->gender == "Male")
                <img class="people-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="">
                @elseif($selectedMyTeamPerson->gender == "Female")
                <img class="people-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="">
                @endif
                @else
                <img class="people-image" src="{{ Storage::url($selectedMyTeamPerson->image) }}" alt="">
                @endif

            </div>
            <div class="col-7">
                @php
                $starredPerson = DB::table('starred_peoples')
                ->where('people_id', $selectedMyTeamPerson->emp_id)
                ->where('starred_status', 'starred')
                ->where('emp_id', auth()->guard('emp')->user()->emp_id)
                ->first();
                @endphp
                <div style="background: #f9f9f9; padding: 10px;">
                    <div style="display: flex; align-items: center;">
                        <h1 style="font-size: 16px; margin-right: 5px;">{{ ucwords(strtolower(optional($selectedMyTeamPerson)->first_name )) }} {{ ucwords(strtolower(optional($selectedMyTeamPerson)->last_name )) }}</h1>
                        <a style="text-decoration: none;" wire:click="toggleStar('{{ optional($selectedMyTeamPerson)->emp_id }}')">

                            <i class="fa fa-star{{ $starredPerson && $starredPerson->starred_status == 'starred' ? ' text-yellow' : ' text-gray' }}" style="cursor: pointer; margin-bottom: 10px;"></i>


                        </a>

                    </div>
                    <p class="mb-0" style="color: #778899; font-size: 14px;">(#{{ optional($selectedMyTeamPerson)->emp_id }})</p>
                </div>
                <br>
                <div style="display: flex; align-items: center;">
                    <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">CONTACT DETAILS</span>
                    <hr style="flex-grow: 1; width: 50px; color: black; border: 1px solid #778899; margin: 0;">
                </div>
                <br>
                <div class="row">
                    <label class="col-6" style="color: #778899; font-size: 13px;">Mobile Number</label>
                    <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($selectedMyTeamPerson)->mobile_number }}</label>
                </div>
                <br>
                <div style="display: flex; align-items: center;">
                    <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">CATEGORY</span>
                    <hr style="flex-grow: 1; width: 50px; color: black; border: 1px solid #778899; margin: 0;">
                </div>
                <br>
                <div class="row">
                    <label class="col-6" style="color: #778899; font-size: 13px;">Location</label>
                    <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($selectedMyTeamPerson)->job_location }}</label>
                </div>
                <br>
                <div style="display: flex; align-items: center;">
                    <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">OTHER INFORMATION</span>
                    <hr style="flex-grow: 1; width: 50px; color: #333; border: 1px solid #778899; margin: 0;">
                </div>
                <br>
                <div class="row">
                    <label class="col-6" style="color: #778899; font-size: 13px;">Joining Date</label>
                    <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($selectedMyTeamPerson)->hire_date ? date('d M, Y', strtotime(optional($selectedMyTeamPerson)->hire_date)) : '' }}</label>
                </div>
                <div class="row">
                    <label class="col-6" style="color: #778899; font-size: 13px;">Date Of Birth</label>
                    <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($selectedMyTeamPerson)->date_of_birth ? date('d M, Y', strtotime(optional($selectedMyTeamPerson)->date_of_birth)) : '' }}</label>
                </div>

            </div>

        </div>
        @elseif (!$myTeamData->isEmpty())
        <!-- Code to display details of the first person in $starredPeoples when $selectStarredPeoples is not set -->
        @php
        $firstPerson = $myTeamData->first();
        $starredPerson = DB::table('starred_peoples')
        ->where('people_id', $firstPerson->emp_id)
        ->where('starred_status', 'starred')
        ->where('emp_id', auth()->guard('emp')->user()->emp_id)
        ->first();
        @endphp
        <div class="row" style="font-size: 13px; padding: 10px; height: 450px;">

            <div class="col-3">
                <img class="people-image" src="{{ Storage::url(optional($firstPerson)->image) }}" alt="">

            </div>
            <div class="col-7">
                <div style="background: #f9f9f9; padding: 10px;">
                    <div style="display: flex; align-items: center;">
                        <h1 style="font-size: 16px; margin-right: 5px;">{{ ucwords(strtolower(optional($firstPerson)->first_name)) }} {{ ucwords(strtolower(optional($firstPerson)->last_name)) }}</h1>
                        <a style="text-decoration: none;" wire:click="toggleStar('{{ optional($firstPerson)->emp_id }}')">

                            <i class="fa fa-star{{ $starredPerson && $starredPerson->starred_status == 'starred' ? ' text-yellow' : ' text-gray' }}" style="cursor: pointer; margin-bottom: 10px;"></i>

                        </a>

                    </div>
                    <p class="mb-0" style="color: #778899; font-size: 14px;">(#{{ optional($firstPerson)->emp_id }})</p>
                </div>
                <br>
                <div style="display: flex; align-items: center;">
                    <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">CONTACT DETAILS</span>
                    <hr style="flex-grow: 1; width: 50px; color: black; border: 1px solid black; margin: 0;">
                </div>
                <br>
                <div class="row">
                    <label class="col-6" style="color: #778899; font-size: 13px;">Mobile Number</label>
                    <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($firstPerson)->mobile_number }}</label>
                </div>
                <br>
                <div style="display: flex; align-items: center;">
                    <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">CATEGORY</span>
                    <hr style="flex-grow: 1; width: 50px; color: black; border: 1px solid black; margin: 0;">
                </div>
                <br>
                <div class="row">
                    <label class="col-6" style="color: #778899; font-size: 13px;">Location</label>
                    <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($firstPerson)->job_location }}</label>
                </div>
                <br>
                <div style="display: flex; align-items: center;">
                    <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">OTHER INFORMATION</span>
                    <hr style="flex-grow: 1; width: 50px; color: #333; border: 1px solid black; margin: 0;">
                </div>
                <br>
                <div class="row">
                    <label class="col-6" style="color: #778899; font-size: 13px;">Joining Date</label>
                    <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($firstPerson)->hire_date ? date('d M, Y', strtotime(optional($firstPerson)->hire_date)) : '' }}</label>
                </div>
                <div class="row">
                    <label class="col-6" style="color: #778899; font-size: 13px;">Date Of Birth</label>
                    <label class="col-6" style="font-weight: 500; color: #333; font-size: 13px;">{{ optional($firstPerson)->date_of_birth ? date('d M, Y', strtotime(optional($firstPerson)->date_of_birth)) : '' }}</label>
                </div>

            </div>

        </div>
        @else
        <div class="col-12">
            <div class="d-flex flex-column justify-content-center align-items-center h-100" style="margin-top: 100px">
                <div class="d-flex flex-column align-items-center">
                    <img src="{{ asset('images/nodata.png') }}" style="height: 200px; width: 200px;" alt="">
                    <p style="text-align: center; color: #778899;font-size: 12px;">No People Found!</p>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
<!-- End of Everyone tab content -->
@endif
