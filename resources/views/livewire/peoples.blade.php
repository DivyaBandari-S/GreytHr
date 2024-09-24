<!-- resources/views/livewire/people-lists.blade.php -->

<div>

    <div class="container">
        @if (session()->has('emp_error'))
            <div class="alert alert-danger">
                {{ session('emp_error') }}
            </div>
        @endif

        @php
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $companyId = Auth::user()->company_id;
            if (is_string($companyId)) {
                $companyIdsArray = json_decode($companyId, true);
            } else {
                $companyIdsArray = $companyId;
            }

            if (!is_array($companyIdsArray)) {
                $companyIdsArray = [];
            }

            $mangerid = DB::table('employee_details')
                        ->join('companies', function ($join) use ($companyIdsArray) {
                            // Use JSON_CONTAINS to check against the company_id JSON field
                        $join->whereRaw('JSON_CONTAINS(employee_details.company_id, ?)', [json_encode($companyIdsArray)]);
                        })
                        ->where('employee_details.manager_id', $employeeId)
                        ->select('companies.company_logo', 'companies.company_name')
                        ->first();
        @endphp
        @if ($mangerid)
            <div class="row justify-content-center people-tab-container">
                <div class="col-4 text-center people-starred-tab-container">
                    <a id="starred-tab-link"
                        class="people-manager-tab-link {{ $activeTab === 'starred' ? 'active' : '' }}"
                        wire:click="$set('activeTab', 'starred')" class="links">
                        Starred
                    </a>
                </div>
                <div class="col-4 text-center people-starred-tab-container">
                    <a id="myteam-tab-link" class="people-manager-tab-link {{ $activeTab === 'myteam' ? 'active' : '' }}"
                        wire:click="$set('activeTab', 'myteam')" class="links">
                        My Team
                    </a>
                </div>
                <div class="col-4 text-center people-starred-tab-container">
                    <a id="everyone-tab-link"
                        class="people-manager-tab-link {{ $activeTab === 'everyone' ? 'active' : '' }}"
                        wire:click="$set('activeTab', 'everyone')" class="links">
                        Everyone
                    </a>
                </div>
                <div
                    class="people-manager-tab-line {{ $activeTab === 'starred' ? 'tab-position-starred' : ($activeTab === 'myteam' ? 'tab-position-myteam' : 'tab-position-everyone') }}">
                </div>
            </div>
        @else
            <div class="row justify-content-start people-emp-tab-container">
                <div class="col-3 text-start people-starred-tab-container">
                    <a id="starred-tab-link"
                        class="people-manager-tab-link {{ $activeTab === 'starred' ? 'active' : '' }}"
                        wire:click="$set('activeTab', 'starred')" class="links">
                        Starred
                    </a>
                </div>
                <div class="col-3 text-start people-starred-tab-container">
                    <a id="everyone-tab-link"
                        class="people-manager-tab-link {{ $activeTab === 'everyone' ? 'active' : '' }}"
                        wire:click="$set('activeTab', 'everyone')" class="links">
                        Everyone
                    </a>
                </div>
                <div
                    class="people-emp-tab-line {{ $activeTab === 'starred' ? 'tab-position-emp-starred' : 'tab-position-emp-everyone' }}">
                </div>
            </div>
        @endif


        @if ($activeTab === 'starred')
            <!-- Starred tab content -->
            <div class="row mt-3">

                <div class="col-12 col-md-4 bg-white people-left-side-container">
                    <div class="input-group people-input-group-container">
                        <input wire:input="starredFilter" wire:model="search" type="text" class="form-control people-search-input"
                            placeholder="Search for Employee Name or ID" aria-label="Search"
                            aria-describedby="basic-addon1">
                        <div class="input-group-append">
                            <button wire:click="starredFilter" class="people-search-button" type="button">
                                <i class="fa fa-search people-search-icon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mt-3 people-starred-list-container">

                        @if ($starredPeoples->isEmpty())
                            <div class="container people-empty-text">Looks like you don't have any records</div>
                        @else
                            @php
                                // Check if $selectStarredPeoples is null and set it to the first record if needed
                                $defaultSelection = $starredPeoples->where('starred_status', 'starred')->first();
                            @endphp
                            @foreach ($starredPeoples->where('starred_status', 'starred') as $people)
                                <div wire:click="starredPersonById('{{ $people->id }}')"
                                    class="container people-details-container {{ ($selectStarredPeoples && $selectStarredPeoples->id == $people->id) || (!$selectStarredPeoples && $defaultSelection->id == $people->id) ? 'selected' : '' }}">
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


                <div class="row">

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
                <input wire:input="filter" wire:model="searchTerm" type="text" class="form-control people-search-input"
                    placeholder="Search for Employee Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                <div class="input-group-append">
                    <button wire:click="filter" class="people-search-button" type="button">
                        <i class="fa fa-search people-search-icon"></i>
                    </button>
                </div>
            </div>
            <div class="mt-3">
                @if ($peopleData->isEmpty())
                    <div class="container people-empty-text">No People Found</div>
                @else
                    <div class="people-starred-list-container">
                        @php
                            // Get the first record to use for default selection if no other record is selected
                            $defaultSelection = $peopleData->first();
                        @endphp

                        @foreach ($peopleData as $people)
                            <div wire:click="selectPerson('{{ $people->emp_id }}')"
                                class="container people-details-container {{ ($selectedPerson && $selectedPerson->emp_id == $people->emp_id) || (!$selectedPerson && $defaultSelection && $defaultSelection->emp_id == $people->emp_id) ? 'selected' : '' }}">
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
                <div class="row">

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
                <input wire:input="filterMyTeam" wire:model="searchValue" type="text" class="form-control people-search-input"
                    placeholder="Search for Employee Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                <div class="input-group-append">
                    <button wire:click="filterMyTeam" class="people-search-button" type="button">
                        <i class="fa fa-search people-search-icon"></i>
                    </button>
                </div>
            </div>

            <div class="mt-3">
                @if ($myTeamData->isEmpty())
                    <div class="container people-empty-text">No People Found</div>
                @else
                    <div class="people-starred-list-container">
                        @php
                            // Get the first record to use for default selection if no other record is selected
                            $defaultSelection = $myTeamData->first();
                        @endphp
                        @foreach ($myTeamData as $people)
                            <div wire:click="selectMyTeamPerson('{{ $people->emp_id }}')"
                                class="container people-details-container {{ ($selectedMyTeamPerson && $selectedMyTeamPerson->emp_id == $people->emp_id) || (!$selectedMyTeamPerson && $defaultSelection && $defaultSelection->emp_id == $people->emp_id) ? 'selected' : '' }}">
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
                <div class="row">

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
