<!-- resources/views/livewire/people-lists.blade.php -->

<div>
    <x-loading-indicator />
    <div class="container mt-3">
        @if(session()->has('emp_error'))
        <div class="alert alert-danger">
            {{ session('emp_error') }}
        </div>
        @endif
        <div class="row justify-content-center" style="width: 20%; position: relative;">
            <div class="col-6 text-center" style="border-radius: 5px; cursor: pointer;">
                <a id="starred-tab-link" style="text-decoration: none; font-size: 13px; color: {{ $activeTab === 'starred' ? 'rgb(2, 17, 79);' : '#333' }}" wire:click="$set('activeTab', 'starred')" class="links">
                    Starred
                </a>
            </div>
            <div class="col-6 text-center" style="border-radius: 5px; cursor: pointer;">
                <a id="everyone-tab-link" style="text-decoration: none; font-size: 13px; color: {{ $activeTab === 'everyone' ? 'rgb(2, 17, 79);' : '#333' }}" wire:click="$set('activeTab', 'everyone')" class="links">
                    Everyone
                </a>
            </div>
            <!-- Line below the active tab -->
            <div style="transition: left 0.3s ease-in-out; position: absolute; bottom: 0; left: {{ $activeTab === 'everyone' ? '50%' : '0' }}; width: 50%; height: 4px; background-color: rgb(2, 17, 79); border-radius: 5px;"></div>
        </div>

        @if ($activeTab === 'starred')
        <!-- Starred tab content -->
        <div class="row mt-3">

            <div class="col-12 col-md-4 bg-white w-100" style="margin-right: 20px; padding: 20px; border-radius: 5px; height: 500px;">
                <div class="input-group" style="margin-bottom: 30px;">
                    <input wire:model="search" style="font-size: 10px; border-radius: 5px 0 0 5px; cursor: pointer" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                    <div class="input-group-append">
                        <button wire:click="starredFilter" style="height: 28px; border-radius: 0 5px 5px 0; background-color: rgb(2, 17, 79);; color: #fff; border: none;" class="btn" type="button">
                            <i style="text-align: center;" class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="mt-3" style="max-height: 400px; overflow-y: auto; overflow-x: hidden;">
                    @if ($starredPeoples->isEmpty())
                    <div class="container" style="text-align: center; color: #778899; font-size: 12px;">Looks like you don't have any records</div>
                    @else
                    @foreach ($starredPeoples->where('starred_status', 'starred') as $people)
                    <div wire:click="starredPersonById('{{ $people->id }}')" class="container" style="height:auto;cursor: pointer; background-color: {{ $selectStarredPeoples && $selectStarredPeoples->id == $people->id ? '#ccc' : 'grey' }}; padding: 5px; margin-bottom: 8px;  border-radius: 5px;">
                        <div class="row align-items-center">
                            <div class="col-2">
                                @if($people->profile == "")
                                @if($people->emp->gender == "Male")
                                <img class="profile-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="">
                                @elseif($people->emp->gender == "Female")
                                <img class="profile-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="">
                                @endif
                                @else
                                <img class="profile-image" src="{{ Storage::url($people->profile) }}" alt="">
                                @endif

                            </div>
                            <div class="col-5">
                                <h6 class="username" style="font-size: 12px; color: white;">{{ ucwords(strtolower($people->name)) }}</h6>
                            </div>
                            <div class="col-3">
                                <p class="mb-0" style="font-size: 12px; color: white;font-size:8px">(#{{ $people->people_id }})</p>
                            </div>
                            <div class="col-2">
                                <i class="fa fa-star starred" style="color: yellow;"></i>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            <!-- Details of the selected person -->
            <div class="col-12 col-md-7 bg-white w-100" style="border-radius: 5px; padding: 20px; height: 500px;">
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
                    <div class="col-8">
                        <div style="display: flex; align-items: center;">
                            <div style="font-size: 16px; margin-right: 5px;">{{ ucwords(strtolower(optional($selectStarredPeoples)->name)) }}</div>
                            <a style="text-decoration: none;" wire:click="removeToggleStar('{{ optional($selectStarredPeoples)->people_id }}')">
                                <button style="background-color:white;border:1px solid white; padding: 0;">
                                    <i class="fa fa-star" style="cursor: pointer; color: yellow;"></i>
                                </button>
                            </a>

                        </div>
                        <div style="color: #778899; font-size: 14px;">(#{{ optional($selectStarredPeoples)->people_id }})</div>
                        <br>
                        <div style="display: flex; align-items: center;">
                            <span style="margin-right: 10px; font-weight:500; color: #778899; font-size: 12px;">CONTACT DETAILS</span>
                            <hr style="flex-grow: 1; width: 50px; color: black; border: 1px solid black; margin: 0;">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-6" style="color: #778899; font-size: 14px;">Mobile No</label>
                            <p class="col-6" style="font-weight: 500; color: #333; font-size: 14px;">{{ optional($selectStarredPeoples)->contact_details }}</p>
                        </div>
                        <br>
                        <div style="display: flex; align-items: center;">
                            <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">CATEGORY</span>
                            <hr style="flex-grow: 1; width: 50px; color: black; border: 1px solid black; margin: 0;">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-6" style="color: #778899; font-size: 14px;">Location</label>
                            <p class="col-6" style="font-weight: 500; color: #333; font-size: 14px;">{{ optional($selectStarredPeoples)->location }}</p>
                        </div>
                        <br>
                        <div style="display: flex; align-items: center;">
                            <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">OTHER INFORMATION</span>
                            <hr style="flex-grow: 1; width: 50px; color: #333; border: 1px solid black; margin: 0;">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-6" style="color: #778899; font-size: 14px;">Joining Date</label>
                            <p class="col-6" style="font-weight: 500; color: #333; font-size: 14px;">{{ optional($selectStarredPeoples)->joining_date ? date('d M y', strtotime(optional($selectedPerson)->joining_date)) : '' }}</p>
                        </div>
                        <div class="row">
                            <label class="col-6" style="color: #778899; font-size: 14px;">Date Of Birth</label>
                            <p class="col-6" style="font-weight: 500; color: #333; font-size: 14px;">{{ optional($selectStarredPeoples)->date_of_birth ? date('d M y', strtotime(optional($selectStarredPeoples)->date_of_birth)) : '' }}</p>
                        </div>

                    </div>
                </div>
            </div>
            @elseif (!$starredPeoples->isEmpty())

            <!-- Code to display details of the first person in $starredPeoples when $selectStarredPeoples is not set -->
            @php
            $firstStarredPerson = $starredPeoples->first();
            @endphp
            <div class="row" style="font-size: 13px; padding: 10px; height: 500px;">

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
                <div class="col-8">
                    <div style="display: flex; align-items: center;">
                        <div style="font-size: 16px; margin-right: 5px;">{{ ucwords(strtolower(optional($firstStarredPerson)->name)) }}</div>
                        <a style="text-decoration: none;" wire:click="removeToggleStar('{{ optional($firstStarredPerson)->people_id }}')">
                            <button style="background-color:white;border:1px solid white; padding: 0;">
                                <i class="fa fa-star" style="cursor: pointer; color: yellow;"></i>
                            </button>
                        </a>

                    </div>
                    <div style="color: #778899; font-size: 14px;">(#{{ optional($firstStarredPerson)->people_id }})</div>
                    <br>
                    <div style="display: flex; align-items: center;">
                        <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">CONTACT DETAILS</span>
                        <hr style="flex-grow: 1; width: 50px; color: black; border: 1px solid black; margin: 0;">
                    </div>
                    <br>
                    <div class="row">
                        <label class="col-6" style="color: #778899; font-size: 14px;">Mobile No</label>
                        <p class="col-6" style="font-weight: 500; color: #333; font-size: 14px;">{{ optional($firstStarredPerson)->contact_details }}</p>
                    </div>
                    <br>
                    <div style="display: flex; align-items: center;">
                        <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">CATEGORY</span>
                        <hr style="flex-grow: 1; width: 50px; color: black; border: 1px solid black; margin: 0;">
                    </div>
                    <br>
                    <div class="row">
                        <label class="col-6" style="color: #778899; font-size: 14px;">Location</label>
                        <p class="col-6" style="font-weight: 500; color: #333; font-size: 14px;">{{ optional($firstStarredPerson)->location }}</p>
                    </div>
                    <br>
                    <div style="display: flex; align-items: center;">
                        <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">OTHER INFORMATION</span>
                        <hr style="flex-grow: 1; width: 50px; color: #333; border: 1px solid black; margin: 0;">
                    </div>
                    <br>
                    <div class="row">
                        <label class="col-6" style="color: #778899; font-size: 14px;">Joining Date</label>
                        <p class="col-6" style="font-weight: 500; color: #333; font-size: 14px;">{{ optional($firstStarredPerson)->joining_date ? date('d M y', strtotime(optional($firstStarredPerson)->joining_date)) : '' }}</p>
                    </div>
                    <div class="row">
                        <label class="col-6" style="color: #778899; font-size: 14px;">Date Of Birth</label>
                        <p class="col-6" style="font-weight: 500; color: #333; font-size: 14px;">{{ optional($firstStarredPerson)->date_of_birth ? date('d M y', strtotime(optional($firstStarredPerson)->date_of_birth)) : '' }}</p>
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
<div class="row mt-3">

    <div class="col-12 col-md-4 bg-white w-100" style="margin-right: 20px; padding: 20px; border-radius: 5px; height: 500px;">
        <div class="input-group" style="margin-bottom: 30px;">
            <input wire:model="searchTerm" style="font-size: 10px; border-radius: 5px 0 0 5px; cursor: pointer" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
            <div class="input-group-append">
                <button wire:click="filter" style="height: 28px; border-radius: 0 5px 5px 0; background-color: rgb(2, 17, 79);; color: #fff; border: none;" class="btn" type="button">
                    <i style="text-align: center;" class="fa fa-search"></i>
                </button>
            </div>
        </div>
        <div class="mt-3">
            @if ($peopleData->isEmpty())
            <div class="container" style="text-align: center; color: #778899; font-size: 12px;">No People Found</div>
            @else
            <div style="max-height:400px;overflow-y:auto; overflow-x:hidden;">
                @foreach($peopleData as $people)
                <div wire:click="selectPerson('{{ $people->emp_id }}')" class="container" style="height:auto;cursor: pointer; background-color: {{ $selectedPerson && $selectedPerson->emp_id == $people->emp_id ? '#ccc' : 'grey' }}; padding: 5px; margin-bottom: 8px; border-radius: 5px;">
                    <div class="row align-items-center">
                        <div class="col-2">
                            @if($people->image=="")
                            @if($people->gender=="Male")
                            <img class="profile-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt=" ">
                            @elseif($people->gender=="Female")
                            <img class="profile-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="">
                            @endif
                            @else
                            <img class="profile-image" src="{{ Storage::url($people->image) }}" alt="">
                            @endif
                        </div>
                        <div class="col-6">
                            <h6 class="username" style="font-size: 12px; color: white;">{{ ucwords(strtolower($people->first_name)) }} {{ ucwords(strtolower($people->last_name)) }}</h6>
                        </div>
                        <div class="col-4">
                            <p class="mb-0" style="font-size: 12px; color: white;font-size:8px">(#{{ $people->emp_id }})</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    <div class="col-12 col-md-7 bg-white w-100" style="border-radius: 5px; padding: 20px; height: 500px;">
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
            <div class="col-8">
                @php
                $starredPerson = DB::table('starred_peoples')
                ->where('people_id', $selectedPerson->emp_id)
                ->where('starred_status', 'starred')
                ->where('emp_id', auth()->guard('emp')->user()->emp_id)
                ->first();
                @endphp

                <div style="display: flex; align-items: center;">
                    <div style="font-size: 16px; margin-right: 5px;">{{ ucwords(strtolower(optional($selectedPerson)->first_name )) }} {{ ucwords(strtolower(optional($selectedPerson)->last_name )) }}</div>
                    <a style="text-decoration: none;" wire:click="toggleStar('{{ optional($selectedPerson)->emp_id }}')">
                        <button style="background-color:white;border:1px solid white; padding: 0;">
                            <i class="fa fa-star{{ $starredPerson && $starredPerson->starred_status == 'starred' ? ' text-yellow' : ' text-gray' }}" style="cursor: pointer;"></i>

                        </button>
                    </a>

                </div>
                <div style="color: #778899; font-size: 14px;">(#{{ optional($selectedPerson)->emp_id }})</div>
                <br>
                <div style="display: flex; align-items: center;">
                    <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">CONTACT DETAILS</span>
                    <hr style="flex-grow: 1; width: 50px; color: black; border: 1px solid black; margin: 0;">
                </div>
                <br>
                <div class="row">
                    <label class="col-6" style="color: #778899; font-size: 14px;">Mobile No</label>
                    <p class="col-6" style="font-weight: 500; color: #333; font-size: 14px;">{{ optional($selectedPerson)->mobile_number }}</p>
                </div>
                <br>
                <div style="display: flex; align-items: center;">
                    <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">CATEGORY</span>
                    <hr style="flex-grow: 1; width: 50px; color: black; border: 1px solid black; margin: 0;">
                </div>
                <br>
                <div class="row">
                    <label class="col-6" style="color: #778899; font-size: 14px;">Location</label>
                    <p class="col-6" style="font-weight: 500; color: #333; font-size: 14px;">{{ optional($selectedPerson)->job_location }}</p>
                </div>
                <br>
                <div style="display: flex; align-items: center;">
                    <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">OTHER INFORMATION</span>
                    <hr style="flex-grow: 1; width: 50px; color: #333; border: 1px solid black; margin: 0;">
                </div>
                <br>
                <div class="row">
                    <label class="col-6" style="color: #778899; font-size: 14px;">Joining Date</label>
                    <p class="col-6" style="font-weight: 500; color: #333; font-size: 14px;">{{ optional($selectedPerson)->hire_date ? date('d M y', strtotime(optional($selectedPerson)->hire_date)) : '' }}</p>
                </div>
                <div class="row">
                    <label class="col-6" style="color: #778899; font-size: 14px;">Date Of Birth</label>
                    <p class="col-6" style="font-weight: 500; color: #333; font-size: 14px;">{{ optional($selectedPerson)->date_of_birth ? date('d M y', strtotime(optional($selectedPerson)->date_of_birth)) : '' }}</p>
                </div>

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
    <div class="row" style="font-size: 13px; padding: 10px; height: 500px;">

        <div class="col-3">
            <img class="people-image" src="{{ Storage::url(optional($firstPerson)->image) }}" alt="">

        </div>
        <div class="col-8">
            <div style="display: flex; align-items: center;">
                <div style="font-size: 16px; margin-right: 5px;">{{ ucwords(strtolower(optional($firstPerson)->first_name)) }} {{ ucwords(strtolower(optional($firstPerson)->last_name)) }}</div>
                <a style="text-decoration: none;" wire:click="toggleStar('{{ optional($firstPerson)->emp_id }}')">
                    <button style="background-color:white;border:1px solid white; padding: 0;">
                        <i class="fa fa-star{{ $starredPerson && $starredPerson->starred_status == 'starred' ? ' text-yellow' : ' text-gray' }}" style="cursor: pointer;"></i>

                    </button>
                </a>

            </div>
            <div style="color: #778899; font-size: 14px;">(#{{ optional($firstPerson)->emp_id }})</div>
            <br>
            <div style="display: flex; align-items: center;">
                <span style="margin-right: 10px; font-weight:500;color: #778899;">CONTACT DETAILS</span>
                <hr style="flex-grow: 1; width: 50px; color: black; border: 1px solid black; margin: 0;">
            </div>
            <br>
            <div class="row">
                <label class="col-6" style="color: #778899; font-size: 14px;">Mobile No</label>
                <p class="col-6" style="font-weight: 500; color: #333; font-size: 14px;">{{ optional($firstPerson)->mobile_number }}</p>
            </div>
            <br>
            <div style="display: flex; align-items: center;">
                <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">CATEGORY</span>
                <hr style="flex-grow: 1; width: 50px; color: black; border: 1px solid black; margin: 0;">
            </div>
            <br>
            <div class="row">
                <label class="col-6" style="color: #778899; font-size: 14px;">Location</label>
                <p class="col-6" style="font-weight: 500; color: #333; font-size: 14px;">{{ optional($firstPerson)->job_location }}</p>
            </div>
            <br>
            <div style="display: flex; align-items: center;">
                <span style="margin-right: 10px; font-weight:500;color: #778899; font-size: 12px;">OTHER INFORMATION</span>
                <hr style="flex-grow: 1; width: 50px; color: #333; border: 1px solid black; margin: 0;">
            </div>
            <br>
            <div class="row">
                <label class="col-6" style="color: #778899; font-size: 14px;">Joining Date</label>
                <p class="col-6" style="font-weight: 500; color: #333; font-size: 14px;">{{ optional($firstPerson)->hire_date ? date('d M y', strtotime(optional($firstPerson)->hire_date)) : '' }}</p>
            </div>
            <div class="row">
                <label class="col-6" style="color: #778899; font-size: 14px;">Date Of Birth</label>
                <p class="col-6" style="font-weight: 500; color: #333; font-size: 14px;">{{ optional($firstPerson)->date_of_birth ? date('d M y', strtotime(optional($firstPerson)->date_of_birth)) : '' }}</p>
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
<!-- End of Starred tab content -->


</div>


</div>

</div>
@endif