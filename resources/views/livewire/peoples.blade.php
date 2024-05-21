<!-- resources/views/livewire/people-lists.blade.php -->

<div>
    <x-loading-indicator />
    <div class="container">
        <div class="row" style="margin-left: 1%; width: 20%; position: relative;width:500px">
            <div class="col" style="text-align: center; border-radius: 5px; margin-right: 10px; cursor: pointer;">
                <a id="starred-tab-link" style="text-decoration: none; font-size: 13px; color: {{ $activeTab === 'starred' ? 'rgb(2, 17, 79);' : '#333' }}" wire:click="$set('activeTab', 'starred')" class="links">Starred</a>
            </div>
            <div class="col" style="text-align: center; border-radius: 5px; cursor: pointer;">
                <a id="everyone-tab-link" style="text-decoration: none; font-size: 13px; color: {{ $activeTab === 'everyone' ? 'rgb(2, 17, 79);' : '#333' }}" wire:click="$set('activeTab', 'everyone')" class="links">Everyone</a>
            </div>
            <!-- Line below the active tab -->
            <div style="transition: left 0.3s ease-in-out;position: absolute; bottom: 0; left: {{ $activeTab === 'everyone' ? '50%' : '0' }}; width: 50%; height: 4px; background-color:rgb(2, 17, 79);; border-radius: 5px;"></div>
        </div>


        @if ($activeTab === 'starred')
        <!-- Starred tab content -->
        <div class="row" style="margin-top: 15px">
            <!-- Search input and filter button -->
            <div class="col" style="width: 150px; background-color: white; border-radius: 5px; margin-right: 20px; padding: 5px;">
                <div class="container" style="margin-top: 10px">
                    <div class="row">
                        <div class="col" style="margin: 0px; padding: 0px">
                            <div class="input-group">
                                <input wire:model="search" style="font-size: 10px; border-radius: 5px 0 0 5px; cursor: pointer" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <button wire:click="starredFilter" style="height: 30px; border-radius: 0 5px 5px 0; background-color: rgb(2, 17, 79);; color: #fff; border: none;" class="btn" type="button">
                                        <i style="text-align: center;" class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 15px; font-size: 13px;">
                        @if ($starredPeoples->isEmpty())
                        <div class="container" style="text-align: center; color: gray;">Looks like you don't have any records</div>
                        @else
                        @foreach ($starredPeoples->where('starred_status', 'starred') as $people)
                        <div wire:click="starredPersonById('{{ $people->id }}')" class="container" style="height:auto;cursor: pointer; background-color: {{ $selectStarredPeoples && $selectStarredPeoples->id == $people->id ? '#ccc' : 'grey' }}; padding: 5px; margin-bottom: 8px; width: 400px; border-radius: 5px;">
                            <div class="row align-items-center">
                                <div class="col-md-2">
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
                                <div class="col-md-5">
                                    <h6 class="username" style="font-size: 12px; color: white;">{{ ucwords(strtolower($people->name)) }}</h6>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-0" style="font-size: 12px; color: white;font-size:8px">(#{{ $people->people_id }})</p>
                                </div>
                                <div class="col-md-2">
                                    <i class="fa fa-star starred" style="color: yellow;"></i>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        @endif
                    </div>
                </div>
            </div>

            <!-- Details of the selected person -->
            <div class="col-6" style="width: 500px; background-color: white; border-radius: 5px; height: 420px; padding: 5px;">
                @if ($selectStarredPeoples)
                <!-- Code to display details when $selectStarredPeoples is set -->
                <div class="row" style="font-size: 13px;">
                    <div class="row">
                      
                        <div class="col" style="margin-top: 50px;">
                            @if(empty($selectStarredPeoples->profile) || $selectStarredPeoples->profile == "")
                            @if($selectStarredPeoples->emp->gender == "Male")
                            <img class="people-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="">
                            @elseif($selectStarredPeoples->emp->gender == "Female")
                            <img class="people-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="Profile Image">
                            @endif
                            @else
                            <img style="width: 100px;height: 100px;border-radius: 50%;background:#f9f9f9;" class="people-image" src="{{ Storage::url($selectStarredPeoples->profile) }}" alt="">
                            @endif

                        </div>
                        <div class="col" style="margin-top: 50px; margin-right: 80px;">
                            <a style="text-decoration: none;" wire:click="removeToggleStar('{{ optional($selectStarredPeoples)->people_id }}')">
                                <button style="background-color: white;border:1px solid white">
                                    <i class="fa fa-star" style="cursor: pointer; color: yellow;"></i>
                                </button>
                            </a>
                            <div>{{ ucwords(strtolower(optional($selectStarredPeoples)->name)) }}</div>
                            <strong>
                                <div>(#{{ optional($selectStarredPeoples)->people_id }})</div>
                            </strong>

                            <div>Contact Details <br> <strong>{{ optional($selectStarredPeoples)->contact_details }}</strong></div>
                            <div>CATEGORY <br><strong>{{ optional($selectStarredPeoples)->category }}</strong></div>
                            <div>Location <br><strong>{{ optional($selectStarredPeoples)->location }}</strong></div>
                            <div>Joining Date <br><strong>{{ optional($selectStarredPeoples)->joining_date ? date('d M y', strtotime(optional($selectedPerson)->joining_date)) : '' }}</strong></div>
                            <div>Date Of Birth <br><strong>{{ optional($selectStarredPeoples)->date_of_birth ? date('d M y', strtotime(optional($selectStarredPeoples)->date_of_birth)) : '' }}</strong></div>
                        </div>
                    </div>
                </div>
                @elseif (!$starredPeoples->isEmpty())
                <!-- Code to display details of the first person in $starredPeoples when $selectStarredPeoples is not set -->
                @php
                $firstStarredPerson = $starredPeoples->first();
                @endphp
                <div class="row" style="font-size: 13px;">
                    <div class="row">
                        <div class="col" style="margin-top: 50px;">
                            @if(empty($firstStarredPerson->profile) || $firstStarredPerson->profile == "")
                            @if($firstStarredPerson->emp->gender == "Male")
                            <img class="people-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="">
                            @elseif($firstStarredPerson->emp->gender == "Female")
                            <img class="people-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="">
                            @endif
                            @else
                            <img style="width: 100px;height: 100px;border-radius: 50%;background:#f9f9f9;" class="people-image" src="{{ Storage::url($firstStarredPerson->profile) }}" alt="">
                            @endif
                        </div>
                        <div class="col" style="margin-top: 50px; margin-right: 80px;">
                            <a style="text-decoration: none;" wire:click="removeToggleStar('{{ optional($firstStarredPerson)->people_id }}')"> <button style="background-color:white;border:1px solid white">
                                    <i class="fa fa-star" style="cursor: pointer; color: yellow;"></i>
                                </button></a>

                                <div>{{ ucwords(strtolower(optional($firstStarredPerson)->name)) }}</div>
                            <strong>
                                <div>(#{{ optional($firstStarredPerson)->people_id }})</div>
                            </strong>
                            <div>Contact Details <br> <strong>{{ optional($firstStarredPerson)->contact_details }}</strong></div>
                            <div>CATEGORY <br><strong>{{ optional($firstStarredPerson)->category }}</strong></div>
                            <div>Location <br><strong>{{ optional($firstStarredPerson)->location }}</strong></div>
                            <div>Joining Date <br> <strong>{{ optional($firstStarredPerson)->joining_date ? date('d M y', strtotime(optional($firstStarredPerson)->joining_date)) : '' }}</strong></div>
                            <div>Date Of Birth <br><strong>{{ optional($firstStarredPerson)->date_of_birth ? date('d M y', strtotime(optional($firstStarredPerson)->date_of_birth)) : '' }}</strong></div>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
        <!-- End of Starred tab content -->
        @endif

        @if ($activeTab === 'everyone')
        <!-- Everyone tab content -->
        <div class="row" style="margin-top: 15px; width: 100%;">
            <!-- Search input and filter button -->
            <div class="col" style="width: 150px; background-color: white; border-radius: 5px; height: auto; margin-right: 20px; padding: 5px;">
                <div class="container" style="margin-top: 10px;">
                    <div class="row">
                        <div class="col" style="margin: 0px; padding: 0px">
                            <div class="input-group">
                                <input wire:model="searchTerm" style="font-size: 10px; cursor: pointer; border-radius: 5px 0 0 5px;" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <button wire:click="filter" style="height: 30px; border-radius: 0 5px 5px 0; background-color: rgb(2, 17, 79); color: #fff; border: none;" class="btn" type="button">
                                        <i style="text-align: center;" class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 15px; font-size: 13px;">
                    @if ($peopleData->isEmpty())
                    <div class="container" style="text-align: center; color: gray;">No People Found</div>
                    @else
                        <div class="px-2 " style="max-height:350px;overflow-y:auto;width: 85%;margin: 10px auto;">
                        @foreach($peopleData as $people)
                            <div wire:click="selectPerson('{{ $people->emp_id }}')" class="container" style="height:auto;cursor: pointer; background-color: {{ $selectedPerson && $selectedPerson->emp_id == $people->emp_id ? '#ccc' : 'grey' }}; padding: 5px; margin-bottom: 8px; width: 400px; border-radius: 5px;">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        @if($people->image=="")
                                        @if($people->gender=="Male")
                                        <img class="profile-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt=" ">
                                        @elseif($people->gender=="Female")
                                        <img class="profile-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="">
                                        @endif
                                        @else
                                        <img class="profile-image"  src="{{ Storage::url($people->image) }}" alt="">
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="username" style="font-size: 12px; color: white;">{{ ucwords(strtolower($people->first_name)) }} {{ ucwords(strtolower($people->last_name)) }}</h6>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-0" style="font-size: 12px; color: white;font-size:8px">(#{{ $people->emp_id }})</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Details of the selected person -->
            <div class="col-6" style="width: 500px; background-color: white; border-radius: 5px; height: 420px; padding: 5px">
                @if ($selectedPerson)
                <div class="row" style="font-size: 13px;">
                    <div class="row">

                        <div class="col" style="margin-top: 50px;">
                            @if(empty($selectedPerson->image) || $selectedPerson->image == "")
                            @if($selectedPerson->gender == "Male")
                            <img class="people-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="">
                            @elseif($selectedPerson->gender == "Female")
                            <img class="people-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="">
                            @endif
                            @else
                            <img style="width: 100px;height: 100px;border-radius: 50%;background:#f9f9f9;" class="people-image" src="{{ Storage::url($selectedPerson->image) }}" alt="">
                            @endif

                        </div>
                        <div class="col" style="margin-top: 50px; margin-right: 80px;">
                            @php
                            $starredPerson = DB::table('starred_peoples')
                            ->where('people_id', $selectedPerson->emp_id)
                            ->where('starred_status', 'starred')
                            ->where('emp_id', auth()->guard('emp')->user()->emp_id)
                            ->first();
                            @endphp
                            <a style="text-decoration: none;" wire:click="toggleStar('{{ optional($selectedPerson)->emp_id }}')">
                                <button style="background-color: #fff;border:1px solid white">
                                    <i class="fa fa-star{{ $starredPerson && $starredPerson->starred_status == 'starred' ? ' text-yellow' : ' text-gray' }}" style="cursor: pointer;"></i>
                                </button>
                            </a>

                            <div>{{ ucwords(strtolower(optional($selectedPerson)->first_name )) }} {{ ucwords(strtolower(optional($selectedPerson)->last_name )) }}</div>
                            <strong>
                                <div>(#{{ optional($selectedPerson)->emp_id }})</div>
                            </strong>
                            <div>Contact Details <br> <strong>{{ optional($selectedPerson)->mobile_number }}</strong></div>
                            <div>CATEGORY <br><strong>{{ optional($selectedPerson)->job_title }}</strong></div>
                            <div>Location <br><strong>{{ optional($selectedPerson)->job_location }}</strong></div>
                            <div>Joining Date <br><strong>{{ optional($selectedPerson)->hire_date ? date('d M y', strtotime(optional($selectedPerson)->hire_date)) : '' }}</strong></div>
                            <div>Date Of Birth <br><strong>{{ optional($selectedPerson)->date_of_birth ? date('d M y', strtotime(optional($selectedPerson)->date_of_birth)) : '' }}</strong></div>
                        </div>
                    </div>
                </div>
                @elseif (!$peopleData->isEmpty())
                <!-- Display details of the first person in the list -->
                @php
                $firstPerson = $peopleData->first();
                $starredPerson = DB::table('starred_peoples')
                ->where('people_id', $firstPerson->emp_id)
                ->where('starred_status', 'starred')
                ->where('emp_id', auth()->guard('emp')->user()->emp_id)
                ->first();
                @endphp

                <div class="row" style="font-size: 13px;">
                    <div class="row">

                        <div class="col" style="margin-top: 50px;">
                            <img style="width: 100px;height: 100px;border-radius: 50%;width: 100px;height: 100px;border-radius: 50%;background:#f9f9f9;" class="people-image" src="{{ Storage::url(optional($firstPerson)->image) }}" alt="">
                        </div>
                        <div class="col" style="margin-top: 50px; margin-right: 80px;">
                            <a style="text-decoration: none;" wire:click="toggleStar('{{ optional($firstPerson)->emp_id }}')">
                                <button style="background-color: white;border:1px solid white">
                                    <i class="fa fa-star{{ $starredPerson && $starredPerson->starred_status == 'starred' ? ' text-yellow' : ' text-gray' }}" style="cursor: pointer;"></i>
                                </button>
                            </a>
                            <div>{{ ucwords(strtolower(optional($firstPerson)->first_name)) }} {{ ucwords(strtolower(optional($firstPerson)->last_name)) }}</div>
                            <strong>
                                <div>(#{{ optional($firstPerson)->emp_id }})</div>
                            </strong>
                            <div>Contact Details <br> <strong>{{ optional($firstPerson)->mobile_number }}</strong></div>
                            <div>CATEGORY <br> <strong>{{ optional($firstPerson)->job_title }}</strong></div>
                            <div>Location <br> <strong>{{ optional($firstPerson)->job_location }}</strong></div>
                            <div>Joining Date <br><strong>{{ optional($firstPerson)->hire_date ? date('d M y', strtotime(optional($firstPerson)->hire_date)) : '' }}</strong></div>
                            <div>Date Of Birth <br><strong>{{ optional($firstPerson)->date_of_birth ? date('d M y', strtotime(optional($firstPerson)->date_of_birth)) : '' }}</strong></div>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
        <!-- End of Everyone tab content -->
        @endif
    </div>
</div>