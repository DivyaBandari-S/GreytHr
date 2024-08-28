<!-- resources/views/livewire/people-lists.blade.php -->

<div>
    <style>
        .people-left-side-container {
            margin-right: 20px;
            padding: 20px;
            border-radius: 5px;
            height: 450px;
            margin-left: 0px;
        }

        .people-input-group-container {
            margin-bottom: 20px;
        }

        .people-search-input {
            font-size: 0.75rem !important;
            border-radius: 5px 0 0 5px;
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
            color: var(--label-color);
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
            color: var(--main-heading-color);
            margin-right: 5px;
        }

        .people-default-container-name.inactive {
            color: var(--requiredAlert);
        }

        .people-default-container-empid {
            font-size: 12px;
            color: var(--main-heading-color);
            white-space: nowrap;
        }

        .people-default-container-empid.inactive {
            color: var(--requiredAlert);
        }

        .people-text-blue {
            color: #f3c20f;
        }

        .people-default-star-icon {
            cursor: pointer;
            font-size: 12px;
            padding-left: 6px;
            color: #f3c20f;
        }

        .people-selectedperson-container {
            border-radius: 5px;
            padding: 20px;
            height: 450px;
            margin-top: 0px;
        }

        @media (max-width: 767px) {
            .people-selectedperson-container {
                margin-top: 10px;
                height: 490px;
            }
        }

        .people-selectedperson-detail-container {
            background: #e0e0e0;
            padding: 10px;
        }

        .people-selectedperson-name {
            font-size: 16px;
            margin-right: 5px;
            color: var(--main-heading-color);
            font-weight: 500;
        }

        .people-selectedperson-anchortag {
            text-decoration: none;
        }

        .people-selectedperson-star-icon {
            cursor: pointer;
            color: #f3c20f;
            margin-bottom: 10px;
        }

        .people-selectedperson-empid {
            color: var(--label-color);
            font-size: 14px;
        }

        .people-headings {
            margin-right: 10px;
            font-weight: 500;
            color: var(--label-color);
            font-size: 12px;
        }

        .people-horizontal-line {
            flex-grow: 1;
            width: 50px;
            color: var(--main-heading-color);
            border: 1px solid var(--label-color);
            margin: 0;
        }

        .people-label {
            color: var(--label-color);
            font-size: 13px;
        }

        .people-value {
            font-weight: 500;
            color: var(--main-heading-color);
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
        @media (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait) {
            .people-employee-detail-container {
            margin-left: 35px;
        }
        .people-left-side-container {
        flex: 0 0 41.66667%; 
        max-width: 41.66667%; 
    }

    .people-selectedperson-container {
        flex: 0 0 50%; 
        max-width: 50%; 
    }
        }

        
    </style>
    <div class="container mt-3">
        @if (session()->has('emp_error'))
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
            <div class="row justify-content-center" style="width: 316px; position: relative; padding-left: 2px;">
                <div class="col-4 text-center" style="border-radius: 5px; cursor: pointer;">
                    <a id="starred-tab-link"
                        style="text-decoration: none; font-size: 13px; color: {{ $activeTab === 'starred' ? 'rgb(2, 17, 79);' : 'var(--main-heading-color)' }}"
                        wire:click="$set('activeTab', 'starred')" class="links">
                        Starred
                    </a>
                </div>
                <div class="col-4 text-center" style="border-radius: 5px; cursor: pointer;">
                    <a id="myteam-tab-link"
                        style="text-decoration: none; font-size: 13px; color: {{ $activeTab === 'myteam' ? 'rgb(2, 17, 79);' : 'var(--main-heading-color)' }}"
                        wire:click="$set('activeTab', 'myteam')" class="links">
                        My Team
                    </a>
                </div>
                <div class="col-4 text-center" style="border-radius: 5px; cursor: pointer;">
                    <a id="everyone-tab-link"
                        style="text-decoration: none; font-size: 13px; color: {{ $activeTab === 'everyone' ? 'rgb(2, 17, 79);' : 'var(--main-heading-color)' }}"
                        wire:click="$set('activeTab', 'everyone')" class="links">
                        Everyone
                    </a>
                </div>
                <div
                    style="transition: left 0.3s ease-in-out; position: absolute; bottom: -11px; left: {{ $activeTab === 'starred' ? '4px' : ($activeTab === 'myteam' ? '111px' : '219px') }}; width: 92px; height: 4px; background-color: rgb(2, 17, 79); border-radius: 5px;">
                </div>
            </div>
        @else
            <div class="row justify-content-start" style="width: 316px; position: relative; padding-left: 7px;">
                <div class="col-3 text-start" style="border-radius: 5px; cursor: pointer;">
                    <a id="starred-tab-link"
                        style="text-decoration: none; font-size: 13px; color: {{ $activeTab === 'starred' ? 'rgb(2, 17, 79);' : 'var(--main-heading-color)' }}"
                        wire:click="$set('activeTab', 'starred')" class="links">
                        Starred
                    </a>
                </div>
                <div class="col-3 text-start" style="border-radius: 5px; cursor: pointer;">
                    <a id="everyone-tab-link"
                        style="text-decoration: none; font-size: 13px; color: {{ $activeTab === 'everyone' ? 'rgb(2, 17, 79);' : 'var(--main-heading-color)' }}"
                        wire:click="$set('activeTab', 'everyone')" class="links">
                        Everyone
                    </a>
                </div>
                <div
                    style="transition: left 0.3s ease-in-out; position: absolute; bottom: -11px; left: {{ $activeTab === 'starred' ? '2px' : '83px' }}; width: 86px; height: 4px; background-color: rgb(2, 17, 79); border-radius: 5px;">
                </div>
            </div>
        @endif


        @if ($activeTab === 'starred')
            <!-- Starred tab content -->
            <div class="row mt-3">

                <div class="col-12 col-md-4 bg-white people-left-side-container">
                    <div class="input-group people-input-group-container">
                        <input wire:model="search" type="text" class="form-control people-search-input"
                            placeholder="Search for Employee Name or ID" aria-label="Search"
                            aria-describedby="basic-addon1">
                        <div class="input-group-append">
                            <button wire:click="starredFilter" class="people-search-btn" type="button">
                                <i class="fa fa-search people-search-icon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mt-3 people-starred-list-container">

                        @if ($starredPeoples->isEmpty())
                            <div class="container people-empty-text">Looks like you don't have any records</div>
                        @else
                            @foreach ($starredPeoples->where('starred_status', 'starred') as $people)
                                <div wire:click="starredPersonById('{{ $people->id }}')"
                                    class="container people-detail-container {{ $selectStarredPeoples && $selectStarredPeoples->id == $people->id ? 'selected' : '' }}">
                                    <div class="row align-items-center">
                                        <div class="col-3">
                                            @if (!empty($people->profile) && $people->profile !== 'null')
                                                <img class="people-profile-image"
                                                    src="{{ 'data:image/jpeg;base64,' . base64_encode($people->profile) }}">
                                            @else
                                                @if ($people && $people->emp->gender == 'Male')
                                                    <img class="people-profile-image"
                                                        src="{{ asset('images/male-default.png') }}"
                                                        alt="Default Male Image">
                                                @elseif($people && $people->emp->gender == 'Female')
                                                    <img class="people-profile-image"
                                                        src="{{ asset('images/female-default.jpg') }}"
                                                        alt="Default Female Image">
                                                @else
                                                    <img class="people-profile-image"
                                                        src="{{ asset('images/user.jpg') }}" alt="Default Image">
                                                @endif
                                            @endif


                                        </div>
                                        <div class="col-9">
                                            <div class="d-flex align-items-center">
                                                <h6 class="username truncate-text people-default-container-name   @isset($people->emp)
                                        @if ($people->emp->employee_status != 'active')
                                            inactive
                                        @endif
                                            @endisset"
                                                    title="{{ ucwords(strtolower($people->name)) }} (#{{ $people->emp_id }})">
                                                    {{ ucwords(strtolower($people->name)) }}</h6>
                                                <p
                                                    class="mb-0 people-default-container-empid
                                            @isset($people->emp)
                                        @if ($people->emp->employee_status != 'active')
                                            inactive
                                        @endif
                                            @endisset">
                                                    (#{{ $people->people_id }})
                                                </p>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <!-- Details of the selected person -->
                <div class="col-12 col-md-7 bg-white people-selectedperson-container">

                    @if ($selectStarredPeoples)
                        <!-- Code to display details when $selectStarredPeoples is set -->
                        <div class="row">
                            <div class="col-3">
                                @if (!empty($selectStarredPeoples->profile) && $selectStarredPeoples->profile !== 'null')
                                    <img class="people-image"
                                        src="{{ 'data:image/jpeg;base64,' . base64_encode($selectStarredPeoples->profile) }}">
                                @else
                                    @if ($selectStarredPeoples && $selectStarredPeoples->emp->gender == 'Male')
                                        <img class="people-image" src="{{ asset('images/male-default.png') }}"
                                            alt="Default Male Image">
                                    @elseif($selectStarredPeoples && $selectStarredPeoples->emp->gender == 'Female')
                                        <img class="people-image" src="{{ asset('images/female-default.jpg') }}"
                                            alt="Default Female Image">
                                    @else
                                        <img class="people-image" src="{{ asset('images/user.jpg') }}"
                                            alt="Default Image">
                                    @endif
                                @endif


                            </div>
                            <div class="col-md-7 col-12 people-employee-detail-container">
                                <div class="people-selectedperson-detail-container">
                                    <div class="d-flex align-items-center">
                                        <h1 class="people-selectedperson-name">
                                            {{ ucwords(strtolower(optional($selectStarredPeoples)->name)) }}</h1>
                                        <a class="people-selectedperson-anchortag"
                                            wire:click="removeToggleStar('{{ optional($selectStarredPeoples)->people_id }}')">

                                            <i class="fa fa-star people-selectedperson-star-icon"></i>

                                        </a>

                                    </div>
                                    @php
                                        $jobTitle = optional($selectStarredPeoples->emp)->job_role;
                                        $convertedTitle = preg_replace('/\bII\b/', 'I', $jobTitle);
                                        $convertedTitle = preg_replace('/\bII\b/', 'II', $jobTitle);
                                        $convertedTitle = preg_replace('/\bIII\b/', 'III', $convertedTitle);
                                    @endphp
                                    <p class="mb-0 people-selectedperson-empid">{{ $convertedTitle }}
                                        (#{{ optional($selectStarredPeoples)->people_id }})</p>
                                </div>
                                <br>
                                <div class="d-flex align-items-center">
                                    <span class="people-headings">CONTACT DETAILS</span>
                                    <hr class="people-horizontal-line">
                                </div>
                                <br>
                                <div class="row">
                                    <label class="col-7 people-label">Mobile Number</label>
                                    <label
                                        class="col-5 people-value">{{ optional($selectStarredPeoples)->contact_details &&
                                        strtolower(optional($selectStarredPeoples)->contact_details) !== 'n/a'
                                            ? optional($selectStarredPeoples)->contact_details
                                            : '-' }}</label>
                                </div>
                                <br>
                                <div class="d-flex align-items-center">
                                    <span class="people-headings">CATEGORY</span>
                                    <hr class="people-horizontal-line">
                                </div>
                                <br>
                                <div class="row">
                                    <label class="col-7 people-label">Location</label>
                                    <label
                                        class="col-5 people-value">{{ optional($selectStarredPeoples)->location &&
                                        strtolower(optional($selectStarredPeoples)->location) !== 'unknown'
                                            ? optional($selectStarredPeoples)->location
                                            : '-' }}</label>
                                </div>
                                <br>
                                <div class="d-flex align-items-center">
                                    <span class="people-headings">OTHER INFORMATION</span>
                                    <hr class="people-horizontal-line">
                                </div>
                                <br>
                                <div class="row">
                                    <label class="col-7 people-label">Joining Date</label>
                                    <label
                                        class="col-5 people-value">{{ optional($selectStarredPeoples)->joining_date &&
                                        strtolower(optional($selectStarredPeoples)->joining_date) !== 'unknown'
                                            ? date('d M, Y', strtotime(optional($selectStarredPeoples)->joining_date))
                                            : '-' }}</label>
                                </div>
                                <div class="row">
                                    <label class="col-7 people-label">Date Of Birth</label>
                                    <label
                                        class="col-5 people-value">{{ optional($selectStarredPeoples)->date_of_birth &&
                                        strtolower(optional($selectStarredPeoples)->date_of_birth) !== 'unknown'
                                            ? date('d M, Y', strtotime(optional($selectStarredPeoples)->date_of_birth))
                                            : '-' }}</label>
                                </div>

                            </div>
                        </div>
                </div>
            @elseif (!$starredPeoples->isEmpty())
                <!-- Code to display details of the first person in $starredPeoples when $selectStarredPeoples is not set -->
                @php
                    $firstStarredPerson = $starredPeoples->first();
                @endphp


                <div class="row people-first-person-container">

                    <div class="col-3">
                        @if (!empty($firstStarredPerson->profile) && $firstStarredPerson->profile !== 'null')
                            <img class="people-image"
                                src="{{ 'data:image/jpeg;base64,' . base64_encode($firstStarredPerson->profile) }}">
                        @else
                            @if ($firstStarredPerson && $firstStarredPerson->emp->gender == 'Male')
                                <img class="people-image" src="{{ asset('images/male-default.png') }}"
                                    alt="Default Male Image">
                            @elseif($firstStarredPerson && $firstStarredPerson->emp->gender == 'Female')
                                <img class="people-image" src="{{ asset('images/female-default.jpg') }}"
                                    alt="Default Female Image">
                            @else
                                <img class="people-image" src="{{ asset('images/user.jpg') }}" alt="Default Image">
                            @endif
                        @endif

                    </div>
                    <div class="col-md-7 col-12 people-employee-detail-container">
                        <div class="people-selectedperson-detail-container">
                            <div class="d-flex align-items-center">
                                <h1 class="people-selectedperson-name">
                                    {{ ucwords(strtolower(optional($firstStarredPerson)->name)) }}</h1>
                                <a class="people-selectedperson-anchortag"
                                    wire:click="removeToggleStar('{{ optional($firstStarredPerson)->people_id }}')">

                                    <i class="fa fa-star people-selectedperson-star-icon"></i>

                                </a>

                            </div>
                            @php
                                $jobTitle = optional($firstStarredPerson->emp)->job_role;
                                $convertedTitle = preg_replace('/\bII\b/', 'I', $jobTitle);
                                $convertedTitle = preg_replace('/\bII\b/', 'II', $jobTitle);
                                $convertedTitle = preg_replace('/\bIII\b/', 'III', $convertedTitle);
                            @endphp
                            <p class="mb-0 people-selectedperson-empid">{{ $convertedTitle }}
                                (#{{ optional($firstStarredPerson)->people_id }})</p>
                        </div>
                        <br>
                        <div class="d-flex align-items-center">
                            <span class="people-headings">CONTACT DETAILS</span>
                            <hr class="people-horizontal-line">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-7 people-label">Mobile Number</label>
                            <label
                                class="col-5 people-value">{{ optional($firstStarredPerson)->contact_details &&
                                strtolower(optional($firstStarredPerson)->contact_details) !== 'n/a'
                                    ? optional($firstStarredPerson)->contact_details
                                    : '-' }}</label>
                        </div>
                        <br>
                        <div class="d-flex align-items-center">
                            <span class="people-headings">CATEGORY</span>
                            <hr class="people-horizontal-line">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-7 people-label">Location</label>
                            <label class="col-5 people-value">
                                {{ optional($firstStarredPerson)->location && strtolower(optional($firstStarredPerson)->location) !== 'unknown'
                                    ? optional($firstStarredPerson)->location
                                    : '-' }}</label>
                        </div>
                        <br>
                        <div class="d-flex align-items-center">
                            <span class="people-headings">OTHER INFORMATION</span>
                            <hr class="people-horizontal-line">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-7 people-label">Joining Date</label>
                            <label class="col-5 people-value">
                                {{ optional($firstStarredPerson)->joining_date &&
                                strtolower(optional($firstStarredPerson)->joining_date) !== 'unknown'
                                    ? date('d M, Y', strtotime(optional($firstStarredPerson)->joining_date))
                                    : '-' }}</label>
                        </div>
                        <div class="row">
                            <label class="col-7 people-label">Date Of Birth</label>
                            <label
                                class="col-5 people-value">{{ optional($firstStarredPerson)->date_of_birth &&
                                strtolower(optional($firstStarredPerson)->date_of_birth) !== 'unknown'
                                    ? date('d M, Y', strtotime(optional($firstStarredPerson)->date_of_birth))
                                    : '-' }}</label>
                        </div>

                    </div>

                </div>
            @else
                <div class="col-12">
                    <div
                        class="d-flex flex-column justify-content-center align-items-center h-100 people-starred-nodata-container">
                        <div class="d-flex flex-column align-items-center">
                            <img src="{{ asset('images/star.png') }}" class="people-starred-nodata-img"
                                alt="">
                            <p class="people-empty-text">Hey, you haven't starred any peers!</p>
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

        <div class="col-12 col-md-4 bg-white people-left-side-container">
            <div class="input-group people-input-group-container">
                <input wire:model="searchTerm" type="text" class="form-control people-search-input"
                    placeholder="Search for Employee Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                <div class="input-group-append">
                    <button wire:click="filter" class="people-search-btn" type="button">
                        <i class="fa fa-search people-search-icon"></i>
                    </button>
                </div>
            </div>
            <div class="mt-3">
                @if ($peopleData->isEmpty())
                    <div class="container people-empty-text">No People Found</div>
                @else
                    <div class="people-starred-list-container">
                        @foreach ($peopleData as $people)
                            <div wire:click="selectPerson('{{ $people->emp_id }}')"
                                class="container people-detail-container {{ $selectedPerson && $selectedPerson->emp_id == $people->emp_id ? 'selected' : '' }}">
                                <div class="row align-items-center">
                                    <div class="col-3">
                                        @if (!empty($people->image) && $people->image !== 'null')
                                            <img class="people-profile-image"
                                                src="{{ 'data:image/jpeg;base64,' . base64_encode($people->image) }}">
                                        @else
                                            @if ($people && $people->gender == 'Male')
                                                <img class="people-profile-image"
                                                    src="{{ asset('images/male-default.png') }}"
                                                    alt="Default Male Image">
                                            @elseif($people && $people->gender == 'Female')
                                                <img class="people-profile-image"
                                                    src="{{ asset('images/female-default.jpg') }}"
                                                    alt="Default Female Image">
                                            @else
                                                <img class="people-profile-image"
                                                    src="{{ asset('images/user.jpg') }}" alt="Default Image">
                                            @endif
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
                                        <div class="d-flex align-items-center">
                                            <h6 class="username truncate-text people-default-container-name @if ($people->employee_status != 'active') inactive @endif"
                                                title="{{ ucwords(strtolower($people->first_name)) }} {{ ucwords(strtolower($people->last_name)) }} (#{{ $people->emp_id }})">
                                                {{ ucwords(strtolower($people->first_name)) }}
                                                {{ ucwords(strtolower($people->last_name)) }}</h6>
                                            <p
                                                class="mb-0 people-default-container-empid @if ($people->employee_status != 'active') inactive @endif">
                                                (#{{ $people->emp_id }})
                                            </p>
                                            @if ($starredPerson && $starredPerson->starred_status == 'starred')
                                                <i class="fa fa-star  people-default-star-icon"></i>
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
        <div class="col-12 col-md-7 bg-white people-selectedperson-container">
            @if ($selectedPerson)
                <!-- Code to display details when $selectStarredPeoples is set -->
                <div class="row">
                    <div class="col-3">
                        @if (!empty($selectedPerson->image) && $selectedPerson->image !== 'null')
                            <img class="people-image"
                                src="{{ 'data:image/jpeg;base64,' . base64_encode($selectedPerson->image) }}">
                        @else
                            @if ($selectedPerson && $selectedPerson->gender == 'Male')
                                <img class="people-image" src="{{ asset('images/male-default.png') }}"
                                    alt="Default Male Image">
                            @elseif($selectedPerson && $selectedPerson->gender == 'Female')
                                <img class="people-image" src="{{ asset('images/female-default.jpg') }}"
                                    alt="Default Female Image">
                            @else
                                <img class="people-image" src="{{ asset('images/user.jpg') }}" alt="Default Image">
                            @endif
                        @endif

                    </div>
                    <div class="col-md-7 col-12 people-employee-detail-container">
                        @php
                            $starredPerson = DB::table('starred_peoples')
                                ->where('people_id', $selectedPerson->emp_id)
                                ->where('starred_status', 'starred')
                                ->where('emp_id', auth()->guard('emp')->user()->emp_id)
                                ->first();
                        @endphp
                        <div class="people-selectedperson-detail-container">

                            <div class="d-flex align-items-center">
                                <h1 class="people-selectedperson-name">
                                    {{ ucwords(strtolower(optional($selectedPerson)->first_name)) }}
                                    {{ ucwords(strtolower(optional($selectedPerson)->last_name)) }}</h1>
                                <a class="people-selectedperson-anchortag"
                                    wire:click="toggleStar('{{ optional($selectedPerson)->emp_id }}')">

                                    <i
                                        class="fa fa-star {{ $starredPerson && $starredPerson->starred_status == 'starred' ? 'people-text-blue' : 'text-white people-text-white' }} people-selected-person-star"></i>


                                </a>

                            </div>
                            @php
                                $jobTitle = optional($selectedPerson)->job_role;
                                $convertedTitle = preg_replace('/\bII\b/', 'I', $jobTitle);
                                $convertedTitle = preg_replace('/\bII\b/', 'II', $jobTitle);
                                $convertedTitle = preg_replace('/\bIII\b/', 'III', $convertedTitle);
                            @endphp
                            <p class="mb-0 people-selectedperson-empid">{{ $convertedTitle }}
                                (#{{ optional($selectedPerson)->emp_id }})</p>
                        </div>
                        <br>
                        <div class="d-flex align-items-center">
                            <span class="people-headings">CONTACT DETAILS</span>
                            <hr class="people-horizontal-line">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-7 people-label">Mobile Number</label>
                            <label
                                class="col-5 people-value">{{ optional($selectedPerson)->emergency_contact ?? '-' }}</label>
                        </div>
                        <br>
                        <div class="d-flex align-items-center">
                            <span class="people-headings">CATEGORY</span>
                            <hr class="people-horizontal-line">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-7 people-label">Location</label>
                            <label
                                class="col-5 people-value">{{ optional($selectedPerson)->job_location ?? '-' }}</label>
                        </div>
                        <br>
                        <div class="d-flex align-items-center">
                            <span class="people-headings">OTHER INFORMATION</span>
                            <hr class="people-horizontal-line">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-7 people-label">Joining Date</label>
                            <label
                                class="col-5 people-value">{{ optional($selectedPerson)->hire_date ? date('d M, Y', strtotime(optional($selectedPerson)->hire_date)) : '-' }}</label>
                        </div>
                        <div class="row">
                            <label class="col-7 people-label">Date Of Birth</label>
                            <label
                                class="col-5 people-value">{{ optional($selectedPerson)->date_of_birth ? date('d M, Y', strtotime(optional($selectedPerson)->date_of_birth)) : '-' }}</label>
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
                <div class="row people-first-person-container">

                    <div class="col-3">
                        @if (!empty($firstPerson->image) && $firstPerson->image !== 'null')
                            <img class="people-image"
                                src="{{ 'data:image/jpeg;base64,' . base64_encode($firstPerson->image) }}">
                        @else
                            @if ($firstPerson && $firstPerson->gender == 'Male')
                                <img class="people-image" src="{{ asset('images/male-default.png') }}"
                                    alt="Default Male Image">
                            @elseif($firstPerson && $firstPerson->gender == 'Female')
                                <img class="people-image" src="{{ asset('images/female-default.jpg') }}"
                                    alt="Default Female Image">
                            @else
                                <img class="people-image" src="{{ asset('images/user.jpg') }}" alt="Default Image">
                            @endif
                        @endif

                    </div>
                    <div class="col-md-7 col-12 people-employee-detail-container">
                        <div class="people-selectedperson-detail-container">
                            <div class="d-flex align-items-center">
                                <h1 class="people-selectedperson-name">
                                    {{ ucwords(strtolower(optional($firstPerson)->first_name)) }}
                                    {{ ucwords(strtolower(optional($firstPerson)->last_name)) }}</h1>
                                <a class="people-selectedperson-anchortag"
                                    wire:click="toggleStar('{{ optional($firstPerson)->emp_id }}')">

                                    <i
                                        class="fa fa-star {{ $starredPerson && $starredPerson->starred_status == 'starred' ? 'people-text-blue' : 'text-white people-text-white' }} people-selected-person-star"></i>


                                </a>

                            </div>
                            @php
                                $jobTitle = optional($firstPerson)->job_role;
                                $convertedTitle = preg_replace('/\bII\b/', 'I', $jobTitle);
                                $convertedTitle = preg_replace('/\bII\b/', 'II', $jobTitle);
                                $convertedTitle = preg_replace('/\bIII\b/', 'III', $convertedTitle);
                            @endphp
                            <p class="mb-0 people-selectedperson-empid">{{ $convertedTitle }}
                                (#{{ optional($firstPerson)->emp_id }})</p>
                        </div>
                        <br>
                        <div class="d-flex align-items-center">
                            <span class="people-headings">CONTACT DETAILS</span>
                            <hr class="people-horizontal-line">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-7 people-label">Mobile Number</label>
                            <label
                                class="col-5 people-value">{{ optional($firstPerson)->emergency_contact ?? '-' }}</label>
                        </div>
                        <br>
                        <div class="d-flex align-items-center">
                            <span class="people-headings">CATEGORY</span>
                            <hr class="people-horizontal-line">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-7 people-label">Location</label>
                            <label
                                class="col-5 people-value">{{ optional($firstPerson)->job_location ?? '-' }}</label>
                        </div>
                        <br>
                        <div class="d-flex align-items-center">
                            <span class="people-headings">OTHER INFORMATION</span>
                            <hr class="people-horizontal-line">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-7 people-label">Joining Date</label>
                            <label
                                class="col-5 people-value">{{ optional($firstPerson)->hire_date ? date('d M, Y', strtotime(optional($firstPerson)->hire_date)) : '-' }}</label>
                        </div>
                        <div class="row">
                            <label class="col-7 people-label">Date Of Birth</label>
                            <label
                                class="col-5 people-value">{{ optional($firstPerson)->date_of_birth ? date('d M, Y', strtotime(optional($firstPerson)->date_of_birth)) : '-' }}</label>
                        </div>

                    </div>

                </div>
            @else
                <div class="col-12">
                    <div
                        class="d-flex flex-column justify-content-center align-items-center h-100 people-nodata-container">
                        <div class="d-flex flex-column align-items-center">
                            <img class="people-nodata-img" src="{{ asset('images/nodata.png') }}" alt="">
                            <p class="people-empty-text">No People Found!</p>
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
    <div class="row mt-3">
        <!-- Search input and filter button -->
        <div class="col-12 col-md-4 bg-white people-left-side-container">

            <div class="input-group people-input-group-container">
                <input wire:model="searchValue" type="text" class="form-control people-search-input"
                    placeholder="Search for Employee Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                <div class="input-group-append">
                    <button wire:click="filterMyTeam" class="people-search-btn" type="button">
                        <i class="fa fa-search people-search-icon"></i>
                    </button>
                </div>
            </div>

            <div class="mt-3">
                @if ($myTeamData->isEmpty())
                    <div class="container people-empty-text">No People Found</div>
                @else
                    <div class="people-starred-list-container">
                        @foreach ($myTeamData as $people)
                            <div wire:click="selectMyTeamPerson('{{ $people->emp_id }}')"
                                class="container people-detail-container {{ $selectedMyTeamPerson && $selectedMyTeamPerson->emp_id == $people->emp_id ? 'selected' : '' }}">
                                <div class="row align-items-center">
                                    <div class="col-3">
                                        @if (!empty($people->image) && $people->image !== 'null')
                                            <img class="people-profile-image"
                                                src="{{ 'data:image/jpeg;base64,' . base64_encode($people->image) }}">
                                        @else
                                            @if ($people && $people->gender == 'Male')
                                                <img class="people-profile-image"
                                                    src="{{ asset('images/male-default.png') }}"
                                                    alt="Default Male Image">
                                            @elseif($people && $people->gender == 'Female')
                                                <img class="people-profile-image"
                                                    src="{{ asset('images/female-default.jpg') }}"
                                                    alt="Default Female Image">
                                            @else
                                                <img class="people-profile-image"
                                                    src="{{ asset('images/user.jpg') }}" alt="Default Image">
                                            @endif
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
                                        <div class="d-flex align-items-center">
                                            <h6 class="username truncate-text people-default-container-name @if ($people->employee_status != 'active') inactive @endif"
                                                title="{{ ucwords(strtolower($people->first_name)) }} {{ ucwords(strtolower($people->last_name)) }} (#{{ $people->emp_id }})">
                                                {{ ucwords(strtolower($people->first_name)) }}
                                                {{ ucwords(strtolower($people->last_name)) }}</h6>
                                            <p
                                                class="mb-0 people-default-container-empid @if ($people->employee_status != 'active') inactive @endif">
                                                (#{{ $people->emp_id }})
                                            </p>
                                            @if ($starredPerson && $starredPerson->starred_status == 'starred')
                                                <i class="fa fa-star people-default-star-icon"></i>
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
        <div class="col-12 col-md-7 bg-white people-selectedperson-container">
            @if ($selectedMyTeamPerson)
                <!-- Code to display details when $selectStarredPeoples is set -->
                <div class="row">
                    <div class="col-3">
                        @if (!empty($selectedMyTeamPerson->image) && $selectedMyTeamPerson->image !== 'null')
                            <img class="people-image"
                                src="{{ 'data:image/jpeg;base64,' . base64_encode($selectedMyTeamPerson->image) }}">
                        @else
                            @if ($selectedMyTeamPerson && $selectedMyTeamPerson->gender == 'Male')
                                <img class="people-image" src="{{ asset('images/male-default.png') }}"
                                    alt="Default Male Image">
                            @elseif($selectedMyTeamPerson && $selectedMyTeamPerson->gender == 'Female')
                                <img class="people-image" src="{{ asset('images/female-default.jpg') }}"
                                    alt="Default Female Image">
                            @else
                                <img class="people-image" src="{{ asset('images/user.jpg') }}" alt="Default Image">
                            @endif
                        @endif
                    </div>
                    <div class="col-md-7 col-12 people-employee-detail-container">
                        @php
                            $starredPerson = DB::table('starred_peoples')
                                ->where('people_id', $selectedMyTeamPerson->emp_id)
                                ->where('starred_status', 'starred')
                                ->where('emp_id', auth()->guard('emp')->user()->emp_id)
                                ->first();
                        @endphp
                        <div class="people-selectedperson-detail-container">
                            <div class="d-flex align-items-center">
                                <h1 class="people-selectedperson-name">
                                    {{ ucwords(strtolower(optional($selectedMyTeamPerson)->first_name)) }}
                                    {{ ucwords(strtolower(optional($selectedMyTeamPerson)->last_name)) }}</h1>
                                <a class="people-selectedperson-anchortag"
                                    wire:click="toggleStar('{{ optional($selectedMyTeamPerson)->emp_id }}')">

                                    <i
                                        class="fa fa-star {{ $starredPerson && $starredPerson->starred_status == 'starred' ? 'people-text-blue' : 'text-white people-text-white' }} people-selected-person-star"></i>


                                </a>

                            </div>
                            @php
                                $jobTitle = optional($selectedMyTeamPerson)->job_role;
                                $convertedTitle = preg_replace('/\bII\b/', 'I', $jobTitle);
                                $convertedTitle = preg_replace('/\bII\b/', 'II', $jobTitle);
                                $convertedTitle = preg_replace('/\bIII\b/', 'III', $convertedTitle);
                            @endphp
                            <p class="mb-0 people-selectedperson-empid">{{ $convertedTitle }}
                                (#{{ optional($selectedMyTeamPerson)->emp_id }})</p>
                        </div>
                        <br>
                        <div class="d-flex align-items-center">
                            <span class="people-headings">CONTACT DETAILS</span>
                            <hr class="people-horizontal-line">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-7 people-label">Mobile Number</label>
                            <label
                                class="col-5 people-value">{{ optional($selectedMyTeamPerson)->emergency_contact ?? '-' }}</label>
                        </div>
                        <br>
                        <div class="d-flex align-items-center">
                            <span class="people-headings">CATEGORY</span>
                            <hr class="people-horizontal-line">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-7 people-label">Location</label>
                            <label
                                class="col-5 people-value">{{ optional($selectedMyTeamPerson)->job_location ?? '-' }}</label>
                        </div>
                        <br>
                        <div class="d-flex align-items-center">
                            <span class="people-headings">OTHER INFORMATION</span>
                            <hr class="people-horizontal-line">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-7 people-label">Joining Date</label>
                            <label
                                class="col-5 people-value">{{ optional($selectedMyTeamPerson)->hire_date ? date('d M, Y', strtotime(optional($selectedMyTeamPerson)->hire_date)) : '-' }}</label>
                        </div>
                        <div class="row">
                            <label class="col-7 people-label">Date Of Birth</label>
                            <label
                                class="col-5 people-value">{{ optional($selectedMyTeamPerson)->date_of_birth ? date('d M, Y', strtotime(optional($selectedMyTeamPerson)->date_of_birth)) : '-' }}</label>
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
                <div class="row people-first-person-container">

                    <div class="col-3">
                        @if (!empty($firstPerson->image) && $firstPerson->image !== 'null')
                            <img class="people-image"
                                src="{{ 'data:image/jpeg;base64,' . base64_encode($firstPerson->image) }}">
                        @else
                            @if ($firstPerson && $firstPerson->gender == 'Male')
                                <img class="people-image" src="{{ asset('images/male-default.png') }}"
                                    alt="Default Male Image">
                            @elseif($firstPerson && $firstPerson->gender == 'Female')
                                <img class="people-image" src="{{ asset('images/female-default.jpg') }}"
                                    alt="Default Female Image">
                            @else
                                <img class="people-image" src="{{ asset('images/user.jpg') }}" alt="Default Image">
                            @endif
                        @endif

                    </div>
                    <div class="col-md-7 col-12 people-employee-detail-container">
                        <div class="people-selectedperson-detail-container">
                            <div class="d-flex align-items-center">
                                <h1 class="people-selectedperson-name">
                                    {{ ucwords(strtolower(optional($firstPerson)->first_name)) }}
                                    {{ ucwords(strtolower(optional($firstPerson)->last_name)) }}</h1>
                                <a class="people-selectedperson-anchortag"
                                    wire:click="toggleStar('{{ optional($firstPerson)->emp_id }}')">

                                    <i
                                        class="fa fa-star {{ $starredPerson && $starredPerson->starred_status == 'starred' ? 'people-text-blue' : 'text-white people-text-white' }} people-selected-person-star"></i>

                                </a>

                            </div>
                            @php
                                $jobTitle = optional($firstPerson)->job_role;
                                $convertedTitle = preg_replace('/\bII\b/', 'I', $jobTitle);
                                $convertedTitle = preg_replace('/\bII\b/', 'II', $jobTitle);
                                $convertedTitle = preg_replace('/\bIII\b/', 'III', $convertedTitle);
                            @endphp
                            <p class="mb-0 people-selectedperson-empid">{{ $convertedTitle }}
                                (#{{ optional($firstPerson)->emp_id }})</p>
                        </div>
                        <br>
                        <div class="d-flex align-items-center">
                            <span class="people-headings">CONTACT DETAILS</span>
                            <hr class="people-horizontal-line">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-7 people-label">Mobile Number</label>
                            <label
                                class="col-5 people-value">{{ optional($firstPerson)->emergency_contact ?? '-' }}</label>
                        </div>
                        <br>
                        <div class="d-flex align-items-center">
                            <span class="people-headings">CATEGORY</span>
                            <hr class="people-horizontal-line">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-7 people-label">Location</label>
                            <label
                                class="col-5 people-value">{{ optional($firstPerson)->job_location ?? '-' }}</label>
                        </div>
                        <br>
                        <div class="d-flex align-items-center">
                            <span class="people-headings">OTHER INFORMATION</span>
                            <hr class="people-horizontal-line">
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-7 people-label">Joining Date</label>
                            <label
                                class="col-5 people-value">{{ optional($firstPerson)->hire_date ? date('d M, Y', strtotime(optional($firstPerson)->hire_date)) : '-' }}</label>
                        </div>
                        <div class="row">
                            <label class="col-7 people-label">Date Of Birth</label>
                            <label
                                class="col-5 people-value">{{ optional($firstPerson)->date_of_birth ? date('d M, Y', strtotime(optional($firstPerson)->date_of_birth)) : '-' }}</label>
                        </div>

                    </div>

                </div>
            @else
                <div class="col-12">
                    <div
                        class="d-flex flex-column justify-content-center align-items-center h-100 people-nodata-container">
                        <div class="d-flex flex-column align-items-center">
                            <img class="people-nodata-img" src="{{ asset('images/nodata.png') }}" alt="">
                            <p class="people-empty-text">No People Found!</p>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
    <!-- End of Everyone tab content -->
@endif
