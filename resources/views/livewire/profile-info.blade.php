<div class="position-relative">
    <div class="position-absolute" wire:loading
        wire:target="setActiveTab,showPopupModal,closeModel,resetInputFields,applyForResignation">
        <div class="loader-overlay">
            <div class="loader">
                <div></div>
            </div>

        </div>
    </div>
    @if (session()->has('emp_error'))
    <div class="alert alert-danger">
        {{ session('emp_error') }}
    </div>
    @endif

    <div class="row  p-0">
        <div class="nav-buttons d-flex justify-content-center" style="margin-top: 15px;">
            <ul class="nav custom-nav-tabs border">
                <li class="custom-item m-0 p-0 flex-grow-1">
                    <div style="border-top-left-radius:5px;border-bottom-left-radius:5px;" class="custom-nav-link {{ $activeTab === 'personalDetails' ? 'active' : '' }}"
                 wire:click="setActiveTab('personalDetails')">Personal</div>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1"
                    style="border-left:1px solid #ccc;border-right:1px solid #ccc;">
                    <a href="#" style="border-radius:none;" class="custom-nav-link {{ $activeTab === 'accountDetails' ? 'active' : '' }}"
                 wire:click="setActiveTab('accountDetails')">Accounts & Statements</a>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1"
                    style="border-left:1px solid #ccc;border-right:1px solid #ccc;">
                    <a href="#" style="border-radius:none;" class="custom-nav-link {{ $activeTab === 'familyDetails' ? 'active' : '' }}"
                 wire:click="setActiveTab('familyDetails')">Family</a>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1"
                    style="border-left:1px solid #ccc;border-right:1px solid #ccc;">
                    <a href="#" style="border-radius:none;" class="custom-nav-link {{ $activeTab === 'employeeJobDetails' ? 'active' : '' }}"
                 wire:click="setActiveTab('employeeJobDetails')">Employment & Job</a>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1">
                    <a href="#" style="border-top-right-radius:5px;border-bottom-right-radius:5px;"
                        class="custom-nav-link {{ $activeTab === 'assetsDetails' ? 'active' : '' }}"
                 wire:click="setActiveTab('assetsDetails')">Assets</a>
                </li>
            </ul>
        </div>
        <div>
            @if ($employeeDetails)

                {{-- Personal Tab --}}
                <div class="row p-0 gx-0" id="personalDetails" style=" margin:20px 0px;{{ $activeTab === 'personalDetails' ? 'display: block;' : 'display: none;' }}">
                    <div class="col">
                        <div class="row p-3 gx-0"
                            style="border-radius: 5px; width: 100%; background-color: white; margin-bottom: 20px;">
                            <div
                                style="margin-top: 2%;margin-left:15px;color:#778899;font-weight:500;font-size:13px;margin-bottom: 20px;">
                                PROFILE</div>

                        <div class="col-12 col-md-4 position-relative">
                            @if (session()->has('error'))
                            <div class="alert alert-danger position-absolute" wire:poll.3s="hideAlert"
                                style="top:-25%;">
                                {{ session('error') }}
                            </div>
                            @endif

                            @if (
                            $employeeDetails->image !== null &&
                            $employeeDetails->image != 'null' &&
                            $employeeDetails->image != 'Null' &&
                            $employeeDetails->image != '')
                            <!-- Check if the image is in base64 format -->
                            @if (strpos($employeeDetails->image, 'data:image/') === 0)
                            <!-- It's base64 -->
                            <img src="{{ $employeeDetails->image }}" alt="binary"
                                style='height:80px;width:80px; margin:0px 0px 5px 15px'
                                class="img-thumbnail" />
                            @else
                            <!-- It's binary, convert to base64 -->
                            <img src="data:image/jpeg;base64,{{ $employeeDetails->image }}" alt="base"
                                style='height:80px;width:80px;margin:0px 0px 5px 15px'
                                class="img-thumbnail" />
                            @endif
                            @else
                            <!-- Default images based on gender -->
                            @if ($employeeDetails->gender == 'Male')
                            <div class="employee-profile-image-container mb-2">
                                <img src="{{ asset('images/male-default.png') }}"
                                    class="employee-profile-image-placeholder"
                                    style='height:80px;width:80px;margin:0px 0px 5px 15px'
                                    alt="Default Image">
                            </div>
                            @elseif($employeeDetails->gender == 'Female')
                            <div class="employee-profile-image-container mb-2">
                                <img src="{{ asset('images/female-default.jpg') }}"
                                    class="employee-profile-image-placeholder"
                                    style='height:80px;width:80px;margin:0px 0px 5px 15px'
                                    alt="Default Image">
                            </div>
                            @else
                            <div class="employee-profile-image-container mb-2">
                                <img src="{{ asset('images/user.jpg') }}"
                                    class="employee-profile-image-placeholder"
                                    style='height:80px;width:80px;margin:0px 0px 5px 15px'
                                    alt="Default Image">
                            </div>
                            @endif
                            @endif
                            <div style="font-size: 12px; margin-top: 10px; color: #778899; margin-left: 15px">
                                Location
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;color:#000;">
                                @if ($employeeDetails->job_location)
                                {{ $employeeDetails->job_location }}
                                @else
                                <span style="padding-left: 25px;">-</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                                Name
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;color:#000;">
                                @if ($employeeDetails->first_name && $employeeDetails->last_name)
                                {{ ucwords(strtolower($employeeDetails->first_name)) . ' ' . ucwords(strtolower($employeeDetails->last_name)) }}
                                @else
                                <span style="padding-left: 50px;">-</span>
                                @endif
                            </div>
                            <div style="font-size: 11px; margin-top: 30px; color: #778899; margin-left: 15px;">
                                Employee ID
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;color:#000;">
                                @if ($employeeDetails->emp_id)
                                {{ $employeeDetails->emp_id }}
                                @else
                                <span style="padding-left: 50px;">-</span>
                                @endif
                            </div>
                            <div style="font-size: 11px; margin-top: 30px; color: #778899; margin-left: 15px;">
                                Primary Contact No.
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;color:#000;">
                                @if ($employeeDetails->emergency_contact)
                                {{ $employeeDetails->emergency_contact }}
                                @else
                                <span style="padding-left: 37px;">-</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div style="font-size: 11px;  color: #778899; margin-left: 15px">
                                Company E-mail
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;color:#000;word-wrap: break-word;">
                                @if ($employeeDetails->email)
                                {{ $employeeDetails->email }}
                                @else
                                <span style="padding-left: 50px;">-</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row p-3 gx-0"
                        style="border-radius: 5px;  width: 100%; background-color: white;margin-bottom: 20px;">
                        <div
                            style="margin-top: 2%;margin-left:15px;margin-bottom:20px;color:#778899;font-weight:500;font-size:13px;">
                            PERSONAL</div>
                        <div class="col-6 col-md-4">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                                Blood Group
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->empPersonalInfo && $employeeDetails->empPersonalInfo->blood_group)
                                {{ $employeeDetails->empPersonalInfo->blood_group }}
                                @else
                                <span style="padding-left: 30px;">-</span>
                                @endif

                            </div>
                            <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px;">
                                Marital Status
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if (optional($employeeDetails->empPersonalInfo)->marital_status)
                                {{ ucwords(strtolower(optional($employeeDetails->empPersonalInfo)->marital_status)) }}
                                @else
                                <span style="padding-left: 37px;">-</span>
                                @endif

                            </div>
                            <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Place Of Birth
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if (optional($employeeDetails->empPersonalInfo)->city)
                                {{ optional($employeeDetails->empPersonalInfo)->city }}
                                @else
                                <span style="padding-left: 30px;">-</span>
                                @endif

                            </div>
                            <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Religion
                            </div>

                            <div style="margin-left: 15px; font-size: 12px;margin-bottom:10px;">
                                @if (optional($employeeDetails->empPersonalInfo)->religion)
                                {{ optional($employeeDetails->empPersonalInfo)->religion }}
                                @else
                                <span style="padding-left: 17px;">-</span>
                                @endif

                            </div>

                        </div>
                        <div class="col-6 col-md-4">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                Date Of Birth
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->empPersonalInfo && $employeeDetails->empPersonalInfo->date_of_birth)
                                {{ \Carbon\Carbon::parse($employeeDetails->empPersonalInfo->date_of_birth)->format('d-M-Y') }}
                                @else
                                <span style="padding-left: 35px;">-</span>
                                @endif
                            </div>
                            <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Residential Status
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->job_location)
                                {{ $employeeDetails->job_location }}
                                @else
                                <span style="padding-left: 50px;">-</span>
                                @endif
                            </div>
                            <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Physically Challenged
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;">
                                @if (optional($employeeDetails->empPersonalInfo)->physically_challenge)
                                {{ ucwords(strtolower(optional($employeeDetails->empPersonalInfo)->physically_challenge)) }}
                                @else
                                <span style="padding-left: 50px;">-</span>
                                @endif

                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                Nationality
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if (optional($employeeDetails->empPersonalInfo)->nationality)
                                {{ ucwords(strtolower(optional($employeeDetails->empPersonalInfo)->nationality)) }}
                                @else
                                <span style="padding-left: 27px;">-</span>
                                @endif

                            </div>
                            <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px">
                                Spouse
                            </div>

                            <div style="margin-left: 15px; font-size: 12px">
                                @if (optional($employeeDetails->empSpouseDetails)->name)
                                {{ ucwords(strtolower(optional($employeeDetails->empSpouseDetails)->name)) }}
                                @else
                                <span style="padding-left: 18px;">-</span>
                                @endif

                            </div>


                            <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Father Name
                            </div>

                            <div style="margin-left: 15px; font-size: 12px">
                                @php
                                $fatherFirstName = optional($employeeDetails->empParentDetails)
                                ->father_first_name;
                                $fatherLastName = optional($employeeDetails->empParentDetails)
                                ->father_last_name;

                                // Combine names, trimming any extra spaces
                                $combinedName = trim(
                                ucwords(strtolower($fatherFirstName)) .
                                ' ' .
                                ucwords(strtolower($fatherLastName)),
                                );

                                // Show '-' if the combined name is empty
                                $displayName = $combinedName ? $combinedName : '-';
                                $paddingLeft = $displayName === '-' ? '35px' : '0px';
                                @endphp

                                <div style="padding-left: {{ $paddingLeft }};">
                                    {{ $displayName }}
                                </div>

                            </div>

                            <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                                International Employee
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->inter_emp)
                                {{ ucwords(strtolower($employeeDetails->inter_emp)) }}
                                @else
                                <span style="padding-left: 50px;">-</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row p-3 gx-0"
                        style="border-radius: 5px; width: 100%; background-color: white; margin-bottom: 20px;">
                        <div
                            style="margin-top: 2%;margin-left:15px;color:#778899;font-weight:500;font-size:13px; margin-bottom: 10px;">
                            ADDRESS</div>
                        <div class="col-6 col-md-4">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                Permanent Address
                            </div>

                            <div style="margin-left: 15px; font-size: 11px;color:#000;">
                                @if ($employeeDetails->empPersonalInfo && $employeeDetails->empPersonalInfo->permenant_address)
                                {{ $employeeDetails->empPersonalInfo->permenant_address }}
                                @else
                                <span style="padding-left: 50px;">-</span>
                                @endif

                            </div>

                        </div>
                        <div class="col-6 col-md-4">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                Present Address
                            </div>

                            <div style="margin-left: 15px; font-size: 11px;color:#000;">
                                @if ($employeeDetails->empPersonalInfo && $employeeDetails->empPersonalInfo->present_address)
                                {{ $employeeDetails->empPersonalInfo->present_address }}
                                @else
                                <span style="padding-left: 41px;">-</span>
                                @endif
                            </div>

                            <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Mobile
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->empPersonalInfo && $employeeDetails->empPersonalInfo->mobile_number)
                                {{ $employeeDetails->empPersonalInfo->mobile_number }}
                                @else
                                <span style="padding-left: 35px;">-</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div style="font-size: 11px;  color: #778899; margin-left: 15px">
                                Email
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;color:#000;">
                                @if ($employeeDetails->empPersonalInfo)
                                @if ($employeeDetails->empPersonalInfo->email)
                                {{ $employeeDetails->empPersonalInfo->email }}
                                @else
                                <span style="padding-left: 15px;">-</span>
                                @endif
                                @else
                                <span style="padding-left: 15px;">-</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row p-3 gx-0"
                        style="border-radius: 5px; width: 100%; background-color: white; margin-bottom: 20px;">
                        <div
                            style="margin-top: 2%;margin-left:15px;color:#778899;font-weight:500;font-size:13px; margin-bottom: 10px;">
                            EDUCATION</div>
                        {{-- <div style="margin-left: 15px; font-size: 12px">
                            @if ($qualifications && count($qualifications) > 0)
                            @foreach ($qualifications as $index => $education)
                            @if (count($qualifications) > 1)
                            <div style="margin-bottom: 10px;">
                                <strong style="font-size: 13px; color: #778899;">Education Details
                                    {{ $index + 1 }}</strong>
                            </div>
                            @endif
                            <div class="row p-0" style="margin-bottom: 10px;">
                                <div class="col-4" style="font-size: 11px; color: #778899;">Degree</div>
                                <div class="col-4" style="font-size: 11px; color: #778899;">Year of
                                    Passing</div>
                                <div class="col-4" style="font-size: 11px; color: #778899;">Institution
                                </div>
                            </div>

                            <div class="row p-0" style="margin-bottom: 10px;">
                                <div class="col-4" style="font-size: 12px; color: #000;">
                                    {{ $education['level'] }}
                                </div>
                                <div class="col-4" style="font-size: 12px; color: #000;">
                                    {{ $education['year_of_passing'] }}
                                </div>
                                <div class="col-4" style="font-size: 12px; color: #000;">
                                    {{ $education['institution'] }}
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div style="font-size: 12px; color: #778899; margin-left: 15px">
                                No Data Found
                            </div>
                            @endif
                        </div> --}}
                        <div style="margin-left: 15px; font-size: 12px">
                            @if ($qualifications && count($qualifications) > 0)
                                @php $detailIndex = 1; @endphp  <!-- Initialize the counter for Education Details -->
                                
                                @foreach ($qualifications as $index => $education)
                                    @if (is_array($education) && count($education) > 0)
                                        <!-- Show "Education Details" without a number for the first qualification -->
                                        @if (count($qualifications) === 1)
                                            <div style="margin-bottom: 10px;">
                                                <strong style="font-size: 13px; color: #778899;">Education Details</strong>
                                            </div>
                                        @elseif (count($qualifications) > 1)
                                            <div style="margin-bottom: 10px;">
                                                <strong style="font-size: 13px; color: #778899;">Education Details {{ $detailIndex }}</strong>
                                            </div>
                                        @endif
                                        
                                        <div class="row p-0" style="margin-bottom: 10px;">
                                            <div class="col-4" style="font-size: 11px; color: #778899;">Degree</div>
                                            <div class="col-4" style="font-size: 11px; color: #778899;">Year of Passing</div>
                                            <div class="col-4" style="font-size: 11px; color: #778899;">Institution</div>
                                        </div>
                        
                                        <div class="row p-0" style="margin-bottom: 10px;">
                                            <div class="col-4" style="font-size: 12px; color: #000;">
                                                {{ $education['level'] ?? 'N/A' }}
                                            </div>
                                            <div class="col-4" style="font-size: 12px; color: #000;">
                                                {{ $education['year_of_passing'] ?? 'N/A' }}
                                            </div>
                                            <div class="col-4" style="font-size: 12px; color: #000;">
                                                {{ $education['institution'] ?? 'N/A' }}
                                            </div>
                                        </div>
                        
                                        @php $detailIndex++; @endphp  <!-- Increment the counter for the next qualification -->
                                    @endif
                                @endforeach
                            @else
                                <div style="font-size: 12px; color: #778899; margin-left: 15px">
                                    No Data Found
                                </div>
                            @endif
                        </div>
                        
                        
                        {{-- <div class="col" style="margin-left: 15px; font-size: 12px">
                            <div style="font-size: 12px; color: #778899; margin-left: 15px">
                                No Data Found
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>

            {{-- Accounts & Statements --}}

            <div class="row p-0 gx-0" style="margin:20px auto;border-radius: 5px; {{ $activeTab === 'accountDetails' ? 'display: block;' : 'display: none;' }}"
                id="accountDetails">
                <div class="col">
                    <div class="row p-3 gx-0"
                        style="border-radius: 5px;  width: 100%; background-color: white; margin-bottom: 20px;">
                        <div style="margin-top: 2%;margin-left:15px;color:#778899;font-size:12px;font-weight:500;">
                            BANK ACCOUNT</div>
                        <div class="col-6 col-md-4" style="margin-top: 5px;">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                Bank Name
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->empBankDetails)
                                {{ $employeeDetails->empBankDetails->bank_name }}
                                @else
                                <span style="padding-left: 30px;">-</span>
                                @endif


                            </div>
                            <div style="margin-top:10px;font-size: 11px; color: #778899; margin-left: 15px">
                                IFSC Code
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->empBankDetails && $employeeDetails->empBankDetails->ifsc_code)
                                {{ $employeeDetails->empBankDetails->ifsc_code }}
                                @else
                                <span style="padding-left: 25px;">-</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                                Bank Account Number
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->empBankDetails && $employeeDetails->empBankDetails->account_number)
                                {{ $employeeDetails->empBankDetails->account_number }}
                                @else
                                <span style="padding-left: 50px;">-</span>
                                @endif

                            </div>
                            <div style="margin-top:10px;font-size: 11px; color: #778899; margin-left: 15px">
                                Bank Address
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->empBankDetails && $employeeDetails->empBankDetails->bank_address)
                                {{ $employeeDetails->empBankDetails->bank_address }}
                                @else
                                <span style="padding-left: 30px;">-</span>
                                @endif

                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                Bank Branch
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->empBankDetails && $employeeDetails->empBankDetails->bank_branch)
                                {{ $employeeDetails->empBankDetails->bank_branch }}
                                @else
                                <span style="padding-left: 30px;">-</span>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="row p-3 gx-0"
                        style="border-radius: 5px;  width: 100%; background-color: white;margin-bottom: 20px;">
                        <div
                            style="margin-top: 2%;margin-left:15px;font-size:12px;font-weight:500;color:#778899; margin-bottom: 10px;">
                            PF AMOUNT</div>
                        <div class="col-6">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                PF Number
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->empPersonalInfo)
                                {{ $employeeDetails->empPersonalInfo->pf_no }}
                                @else
                                <span style="padding-left: 26px;">-</span>
                                @endif

                            </div>
                        </div>
                        <div class="col-6">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                UAN
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->empPersonalInfo)
                                {{ $employeeDetails->empPersonalInfo->uan_no }}
                                @else
                                <span style="padding-left: 10px;">-</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row p-3 gx-0"
                        style="border-radius: 5px;  width: 100%; background-color: white; margin-bottom: 20px;">
                        <div
                            style="margin-top: 2%;margin-left:15px;font-size:12px;font-weight:500;color:#778899; margin-bottom: 10px;">
                            OTHERS IDS</div>
                        <div class="col-6">
                            <div style="margin-left: 15px; font-size: 12px">
                                ___
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="color: red; margin-left: 15px; font-size: 12px">
                                Unverified
                            </div>
                        </div>
                    </div>
                </div>

            </div>



                <div style="margin:20px auto;border-radius: 5px; {{ $activeTab === 'familyDetails' ? 'display: block;' : 'display: none;' }}" id="familyDetails">
                    <div class="row p-0 gx-0"
                        style="border-radius: 5px;  width: 100%; background-color: white; margin-bottom: 20px;">
                        <!-- Header -->
                        <div
                            style="margin-top: 2%; margin-left: 17px; font-size: 12px; font-weight: 500;color:#778899;">
                            FATHER
                            DETAILS</div>
                        <div class="row p-3 gx-0">
                            <div class="col-12 col-md-3">

                                @if ($employeeDetails->empParentDetails &&
                                !empty(optional($employeeDetails->empParentDetails)->father_image) &&
                                optional($employeeDetails->empParentDetails)->father_image !== null && $employeeDetails->empParentDetails &&
                            !empty(optional($employeeDetails->empParentDetails)->father_image) &&
                            optional($employeeDetails->empParentDetails)->father_image != 'null' && $employeeDetails->empParentDetails &&
                            !empty(optional($employeeDetails->empParentDetails)->father_image) &&
                            optional($employeeDetails->empParentDetails)->father_image != 'Null' && $employeeDetails->empParentDetails &&
                            !empty(optional($employeeDetails->empParentDetails)->father_image) &&
                            optional($employeeDetails->empParentDetails)->father_image != '')
                                                <!-- It's binary, convert to base64 -->
                                                <img  style="border-radius: 5px; margin-left: 43px; margin-top: 10px;"
                                                height="100" width="100" src="data:image/jpeg;base64,{{ (optional($employeeDetails->empParentDetails)->father_image) }}" alt="base"
                                                     /> 
                            @else
                            <img style="border-radius: 5px; margin-left: 43px; margin-top: 10px;"
                                height="100" width="100" src="{{ asset('images/male-default.png') }}"
                                alt="Default Male Image">
                            @endif
                            {{-- <img style="border-radius: 5px;" height="150" width="150" src="{{ optional($employeeDetails->empParentDetails)->father_image ?: 'path/to/default/image.jpg' }}" alt=""> --}}
                        </div>
                        <div class="col-6 col-md-3">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Father Name</div>
                            <div style="font-size: 12px">
                                @php
                                $fatherFirstName = optional($employeeDetails->empParentDetails)
                                ->father_first_name;
                                $fatherLastName = optional($employeeDetails->empParentDetails)
                                ->father_last_name;
                                $combinedName = trim(
                                ucwords(strtolower($fatherFirstName)) .
                                ' ' .
                                ucwords(strtolower($fatherLastName)),
                                );
                                $displayName = $combinedName ?: '-';
                                @endphp
                                @if ($displayName === '-')
                                <div style="padding-left: 37px;">{{ $displayName }}</div>
                                @else
                                {{ $displayName }}
                                @endif
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Address</div>
                            <div style="font-size: 12px; width: 250px">
                                @php
                                $fatherAddress = optional($employeeDetails->empParentDetails)->father_address;
                                $fatherCity = optional($employeeDetails->empParentDetails)->father_city;
                                $fatherState = optional($employeeDetails->empParentDetails)->father_state;
                                $fatherCountry = optional($employeeDetails->empParentDetails)->father_country;
                                $combined = trim(
                                "{$fatherAddress}, {$fatherCity}, {$fatherState}, {$fatherCountry}",
                                ', ',
                                );
                                $displayValue = $combined ?: '-';
                                $hasPadding = $displayValue === '-' ? 'padding-left: 23px;' : '';
                                @endphp
                                <span style="{{ $hasPadding }}">{{ $displayValue }}</span>
                            </div>
                        </div>

                        <div class="col-6 col-md-2">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Date of Birth</div>
                            <div style="font-size: 12px">
                                @if (optional($employeeDetails->empParentDetails)->father_dob)
                                {{ \Carbon\Carbon::parse(optional($employeeDetails->empParentDetails)->father_dob)->format('d-M-Y') }}
                                @else
                                <span style="padding-left: 37px;">-</span>
                                @endif
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Nationality</div>
                            <div style="font-size: 12px">
                                @if (optional($employeeDetails->empParentDetails)->father_nationality)
                                {{ optional($employeeDetails->empParentDetails)->father_nationality }}
                                @else
                                <span style="padding-left: 29px;">-</span>
                                @endif

                            </div>
                        </div>

                        <div class="col-6 col-md-2">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Blood Group</div>
                            <div style="font-size: 12px">
                                @if (optional($employeeDetails->empParentDetails)->father_blood_group)
                                {{ optional($employeeDetails->empParentDetails)->father_blood_group }}
                                @else
                                <span style="padding-left: 50px;">-</span>
                                @endif

                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Occupation</div>
                            <div style="font-size: 12px">
                                @if (optional($employeeDetails->empParentDetails)->father_occupation)
                                {{ optional($employeeDetails->empParentDetails)->father_occupation }}
                                @else
                                <span style="padding-left: 30px;">-</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-6 col-md-2">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Religion</div>
                            <div style="font-size: 12px; word-wrap: break-word;">
                                @if (optional($employeeDetails->empParentDetails)->father_religion)
                                {{ optional($employeeDetails->empParentDetails)->father_religion }}
                                @else
                                <span style="padding-left: 21px;">-</span>
                                @endif
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Father Email</div>
                            <div style="font-size: 12px; word-wrap: break-word; white-space: normal;">
                                @if (optional($employeeDetails->empParentDetails)->father_email)
                                {{ optional($employeeDetails->empParentDetails)->father_email }}
                                @else
                                <span style="padding-left: 35px;">-</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row p-0 gx-0"
                    style="border-radius: 5px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <!-- Header -->
                    <div
                        style="margin-top: 2%; margin-left: 17px; font-size: 12px; font-weight: 500;color:#778899;">
                        MOTHER
                        DETAILS</div>
                    <div class="row p-3 gx-0">
                        <div class="col-12 col-md-3">
                            @if ( $employeeDetails->empParentDetails &&
                            !empty(optional($employeeDetails->empParentDetails)->mother_image) &&
                            optional($employeeDetails->empParentDetails)->mother_image !== null &&  $employeeDetails->empParentDetails &&
                            !empty(optional($employeeDetails->empParentDetails)->mother_image) &&
                            optional($employeeDetails->empParentDetails)->mother_image != 'null' &&  $employeeDetails->empParentDetails &&
                            !empty(optional($employeeDetails->empParentDetails)->mother_image) &&
                            optional($employeeDetails->empParentDetails)->mother_image != 'Null' &&  $employeeDetails->empParentDetails &&
                            !empty(optional($employeeDetails->empParentDetails)->mother_image) &&
                            optional($employeeDetails->empParentDetails)->mother_image != '')
                            <!-- It's binary, convert to base64 -->
                            <img style="border-radius: 5px; margin-left: 43px; margin-top: 10px;"
                            height="100" width="100" src="data:image/jpeg;base64,{{ (optional($employeeDetails->empParentDetails)->mother_image) }}" alt="base"
                               />
                           
                            @else
                            <img style="border-radius: 5px; margin-left: 43px; margin-top: 10px;"
                                height="100" width="100" src="{{ asset('images/female-default.jpg') }}"
                                alt="Default Female Image">
                            @endif
                            {{-- <img style="border-radius: 5px;" height="150" width="150" src="{{ optional($employeeDetails->empParentDetails)->mother_image ?: 'path/to/default/image.jpg' }}" alt=""> --}}
                        </div>
                        <div class="col-6 col-md-3">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Mother Name</div>
                            <div style="font-size: 12px">
                                @php
                                $motherFirstName = optional($employeeDetails->empParentDetails)
                                ->mother_first_name;
                                $motherLastName = optional($employeeDetails->empParentDetails)
                                ->mother_last_name;
                                $combinedName = trim(
                                ucwords(strtolower($motherFirstName)) .
                                ' ' .
                                ucwords(strtolower($motherLastName)),
                                );
                                $displayName = $combinedName ?: '-';
                                $paddingLeft = $displayName === '-' ? '39px' : '0px';
                                @endphp

                                <span style="padding-left: {{ $paddingLeft }};">
                                    {{ $displayName }}
                                </span>
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Address</div>
                            <div style="font-size: 12px; width: 250px">
                                @php
                                $motherAddress = optional($employeeDetails->empParentDetails)->mother_address;
                                $motherCity = optional($employeeDetails->empParentDetails)->mother_city;
                                $motherState = optional($employeeDetails->empParentDetails)->mother_state;
                                $motherCountry = optional($employeeDetails->empParentDetails)->mother_country;
                                $combined = trim(
                                "{$motherAddress}, {$motherCity}, {$motherState}, {$motherCountry}",
                                ', ',
                                );
                                $displayValue = $combined ?: '-';
                                $paddingLeft = $displayValue === '-' ? '24px' : '0px';
                                @endphp

                                <span style="padding-left: {{ $paddingLeft }};">
                                    {{ $displayValue }}
                                </span>
                            </div>
                        </div>

                        <div class="col-6 col-md-2">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Date of Birth</div>
                            <div style="font-size: 12px">
                                @if (optional($employeeDetails->empParentDetails)->mother_dob)
                                {{ \Carbon\Carbon::parse(optional($employeeDetails->empParentDetails)->mother_dob)->format('d-M-Y') }}
                                @else
                                <span style="padding-left: 37px;">-</span>
                                @endif
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Nationality</div>
                            <div style="font-size: 12px">
                                @if (optional($employeeDetails->empParentDetails)->mother_nationality)
                                {{ optional($employeeDetails->empParentDetails)->mother_nationality }}
                                @else
                                <span style="padding-left: 31px;">-</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-6 col-md-2">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Blood Group</div>
                            <div style="font-size: 12px">
                                @if (optional($employeeDetails->empParentDetails)->mother_blood_group)
                                {{ optional($employeeDetails->empParentDetails)->mother_blood_group }}
                                @else
                                <span style="padding-left: 37px;">-</span>
                                @endif
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Occupation</div>
                            <div style="font-size: 12px">
                                @if (optional($employeeDetails->empParentDetails)->mother_occupation)
                                {{ optional($employeeDetails->empParentDetails)->mother_occupation }}
                                @else
                                <span style="padding-left: 30px;">-</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-6 col-md-2">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Religion</div>
                            <div style="font-size: 12px; word-wrap: break-word;">
                                @if (optional($employeeDetails->empParentDetails)->mother_religion)
                                {{ optional($employeeDetails->empParentDetails)->mother_religion }}
                                @else
                                <span style="padding-left: 21px;">-</span>
                                @endif
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Mother Email</div>
                            <div style="font-size: 12px; word-wrap: break-word; white-space: normal;">
                                @if (optional($employeeDetails->empParentDetails)->mother_email)
                                {{ optional($employeeDetails->empParentDetails)->mother_email }}
                                @else
                                <span style="padding-left: 39px;">-</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>


                {{-- Employment & Job --}}
                <div class="row p-0 gx-0" style="margin:20px auto;border-radius: 5px; {{ $activeTab === 'employeeJobDetails' ? 'display: block;' : 'display: none;' }}"
                    id="employeeJobDetails">
                    <div class="col">
                        <div class="row p-3 gx-0"
                            style="border-radius: 5px;width: 100%; background-color: white; margin-bottom: 20px;">
                            <div class="row mt-2 p-0 gx-0">
                                <div class="col-6 col-md-6">
                                    <div
                                        style="margin-top: 2%;margin-left:15px;font-size:12px;font-weight:500;color:#778899; margin-bottom: 10px;">
                                        CURRENT POSITION </div>
                                </div>
                                <div class="col-6 col-md-6">
                                    @if ($isResigned == '')
                                        <div class="anchorTagDetails" style="margin-top: 2%; margin-left: 25px"
                                            wire:click="showPopupModal">
                                            Resign
                                        </div>
                                    @elseif($isResigned == 'Pending')
                                        <div class="anchorTagDetails" style="margin-top: 2%; margin-left: 25px"
                                            wire:click="showPopupModal">
                                            Edit Resignation
                                        </div>
                                    @else
                                        <div class="anchorTagDetails" style="margin-top: 2%; margin-left: 25px"
                                            wire:click="showPopupModal">
                                            View Resignation
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @php
                                // Fetch the manager details directly in Blade
                                $manager = \App\Models\EmployeeDetails::where(
                                    'emp_id',
                                    $employeeDetails->manager_id,
                                )->first();
                            @endphp

                        <div class="col-6 col-md-3">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                Cost Center
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;margin-bottom: 20px;">
                                @if ($employeeDetails->emp_domain)
                                @php
                                $domains = json_decode($employeeDetails->emp_domain);
                                @endphp

                                @if (is_array($domains) && count($domains) > 0)
                                {{ implode(', ', $domains) }}
                                @else
                                <span style="padding-left: 22px;">-</span>
                                @endif
                                @else
                                <span style="padding-left: 22px;">-</span>
                                @endif

                            </div>
                            <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                                Reporting To
                            </div>
                            <div style="margin-left: 15px; font-size: 12px; margin-bottom: 20px;">
                                @if ($manager)
                                {{ ucwords(strtolower($manager->first_name)) }}
                                {{ ucwords(strtolower($manager->last_name)) }}
                                @else
                                No Manager Assigned
                                @endif
                            </div>
                            <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                                Job Mode
                            </div>
                            <div style="margin-left: 15px; font-size: 12px; margin-bottom: 10px;">
                                @if ($employeeDetails->job_mode)
                                {{ ucwords(strtolower($manager->job_mode)) }}
                                @else
                                NA
                                @endif
                            </div>
                        </div>
                        <div class="col-6  col-md-3">
                            @php
                            // Fetch the department name directly in Blade
                            $department = \App\Models\EmpDepartment::where(
                            'dept_id',
                            $employeeDetails->dept_id,
                            )->first();
                            @endphp

                            <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                                Department
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;margin-bottom: 20px;">
                                @if ($department)
                                {{ $department->department }}
                                @else
                                No Department Assigned
                                @endif
                            </div>
                            @php
                            // Fetch the department name directly in Blade
                            $subDepartment = \App\Models\EmpSubDepartments::where(
                            'sub_dept_id',
                            $employeeDetails->sub_dept_id,
                            )->first();
                            @endphp

                            <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                                Division
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;">
                                @if ($subDepartment)
                                {{ ucwords(strtolower($subDepartment->sub_department)) }}
                                @else
                                No Department Assigned
                                @endif
                            </div>
                        </div>
                        <div class="col-6  col-md-3">
                            @php
                            // Fetch the department name directly in Blade
                            $subDepartment = \App\Models\EmpSubDepartments::where(
                            'sub_dept_id',
                            $employeeDetails->sub_dept_id,
                            )->first();
                            @endphp

                            <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                                Sub Department
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;">
                                @if ($subDepartment)
                                {{ ucwords(strtolower($subDepartment->sub_department)) }}
                                @else
                                No Department Assigned
                                @endif
                            </div>
                        </div>
                        <div class="col-6  col-md-3">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                Designation
                            </div>
                            @php
                            $jobTitle = $employeeDetails->job_role;
                            $convertedTitle = preg_replace('/\bII\b/', 'I', $jobTitle);
                            $convertedTitle = preg_replace('/\bII\b/', 'II', $jobTitle);
                            $convertedTitle = preg_replace('/\bIII\b/', 'III', $convertedTitle);
                            @endphp
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($convertedTitle)
                                {{ $convertedTitle }}
                                @else
                                <span style="padding-left: 31px;">-</span>
                                @endif

                            </div>
                            <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px">
                                Location
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->job_location)
                                {{ $employeeDetails->job_location }}
                                @else
                                <span style="padding-left: 22px;">-</span>
                                @endif

                            </div>

                            <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px">
                                Date of Join
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->hire_date)
                                {{ \Carbon\Carbon::parse($employeeDetails->hire_date)->format('d M, Y') }}
                                @else
                                <span style="padding-left: 50px;">-</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- modal -->
            @if ($showModal)
            <div wire:ignore.self class="modal fade show" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display:block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            @if($isResigned == 'Pending')
                            <h6 class="modal-title">Edit Resignation</h6>
                            @elseif($isResigned == '')
                            <h6 class="modal-title">Apply For Resignation</h6>
                            @else
                            <h6 class="modal-title">Resignation Details</h6>
                            @endif
                            <button type="button" wire:click='closeModel' class="btn-close"
                                data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                            </button>
                        </div>
                        @if($isResigned != 'Approved')
                        <form wire:submit.prevent="applyForResignation">
                            <div class="modal-body">
                                <div class="form-group ">
                                    <label for="resignation_date">Resignation Date<span
                                            class="text-danger onboard-Valid">*</span></label>
                                    <input type="date" class="form-control placeholder-small"
                                        wire:model="resignation_date"
                                        wire:change="validateFields('resignation_date')" id="resignation_date"
                                        name="resignation_date">
                                    <!-- name="resignation_date" min="<?php echo date('Y-m-d'); ?>"> -->
                                    @error('resignation_date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mt-2">
                                    <label for="reason">Reason<span
                                            class="text-danger onboard-Valid">*</span></label>
                                    <input type="text" placeholder="Enter reason" wire:keydown="validateFields('reason')"
                                        wire:model="reason" class="form-control placeholder-small"
                                        id="reason" name="reason">
                                    @error('reason')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mt-2">
                                    <label for="">Files</label> <br>
                                    <input type="file" class="form-control-file"
                                        wire:change="validateFields('signature')" wire:model="signature"
                                        id="signature" name="signature" style="font-size:12px;display:none;">
                                    <label for="signature">
                                        <img style="cursor: pointer;" width="20"
                                            src="{{ asset('images/attachments.png') }}" alt="">
                                    </label>
                                    @if($fileName!=null)
                                    <label for="">{{ $fileName }}</label>
                                    @endif
                                    <br>
                                    @error('signature')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                @if($isResigned=='')
                                <button type="submit" class="submit-btn">Submit</button>

                                <button type="button" class="cancel-btn" wire:click="resetInputFields"
                                    style="border:1px solid rgb(2,17,79);">Clear</button>
                                @else
                                <button type="submit" class="submit-btn">Update</button>
                                <button type="button" wire:click="withdrawResignation" class="submit-btn">Withdraw</button>
                                @endif
                            </div>
                        </form>
                        @else
                        <div>
                            <div class="row d-flex justify-content-center align-items-center mb-4">
                                <div class="col-md-5   form-group mt-2" style="display: flex;flex-direction:column;justify-content:center">
                                    <!-- <label for="">Resignation Date: </label> -->
                                    <div class="d-flex justify-content-center" style="font-size: 11px; color: #778899; ">
                                        Resignation Date:
                                    </div>
                                    <div class="d-flex justify-content-center" style=" font-size: 12px;color:#000;">
                                    {{ \Carbon\Carbon::parse($resignation_date)->format('d-M-Y') }}

                                    </div>
                                </div>
                                <div class="col-md-5  form-group mt-2" style="display: flex;flex-direction:column;justify-content:center">
                                    <div class="d-flex justify-content-center" style="font-size: 11px; color: #778899; ">
                                        Last Working Date:
                                    </div>
                                    <div class="d-flex justify-content-center" style=" font-size: 12px;color:#000;">
                                    {{ \Carbon\Carbon::parse($last_working_date)->format('d-M-Y') }}
                                    </div>
                                </div>
                                <div class="col-md-5  form-group mt-2" style="display: flex;flex-direction:column;justify-content:center">
                                    <div class="d-flex justify-content-center" style="font-size: 11px; color: #778899; ">
                                    Resignation Status:
                                    </div>
                                    <div class="d-flex justify-content-center" style=" font-size: 12px;color:#000;">
                                        {{$isResigned}}
                                    </div>
                                </div>
                                <div class="col-md-5  form-group mt-2" style="display: flex;flex-direction:column;justify-content:center">
                                    <div class="d-flex justify-content-center" style="font-size: 11px; color: #778899; ">
                                    Approved On:
                                    </div>
                                    <div class="d-flex justify-content-center" style=" font-size: 12px;color:#000;">
                                    {{ \Carbon\Carbon::parse($approvedOn)->format('d-M-Y') }}
                                    </div>
                                </div>
                                <div class="col-md-5  form-group mt-2" style="display: flex;flex-direction:column;justify-content:center">
                                    <div class="d-flex justify-content-center" style="font-size: 11px; color: #778899; ">
                                   Reason:
                                    </div>
                                    <div class="d-flex justify-content-center" style=" font-size: 12px;color:#000;">
                                        {{$reason}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show"></div>
            @endif
            {{-- Assets --}}

                <div class="row p-0 gx-0" style="margin:20px auto;border-radius: 5px; {{ $activeTab === 'assetsDetails' ? 'display: block;' : 'display: none;' }}"
                    id="assetsDetails">
                    <div class="col">
                        <div class="row p-3 gx-0"
                            style="border-radius: 5px;width: 100%; background-color: white; margin-bottom: 20px;">
                            <div
                                style="margin-top: 2%;margin-left:15px;font-size:13px;font-weight:500;color:#778899;margin-bottom: 10px;">
                                ACESS CARD DETAILS</div>
                            <div class="col-6">
                                <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                    Card No
                                </div>
                                <div style="margin-left: 15px; font-size: 12px">
                                    @if (optional($employeeDetails->empPersonalInfo)->adhar_no)
                                        {{ optional($employeeDetails->empPersonalInfo)->adhar_no }}
                                    @else
                                        <span style="padding-left: 20px;">-</span>
                                    @endif

                            </div>
                            <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px">
                                PREVIOUS
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                No Data Found
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                Validity
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                ____
                            </div>
                        </div>
                    </div>

                    <div class="row p-3 gx-0"
                        style="border-radius: 5px; height: 100px; width: 100%; background-color: white; margin-bottom: 20px;">
                        <div
                            style="margin-top: 2%;margin-left:15px;color:#778899;font-size:13px;font-weight:500;margin-bottom: 10px;">
                            ASSETS</div>
                        <div class="col">
                            <div style="font-size: 12px; color: black; margin-left: 15px">
                                No Data Found
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="col-12">
                <div
                    class="mt-4 d-flex flex-column justify-content-center align-items-center m-auto bg-white people-nodata-container">
                    <div class="d-flex flex-column align-items-center">
                        <img class="people-nodata-img" src="{{ asset('images/nodata.png') }}" alt=""
                            height="300" width="200">
                    </div>
                </div>
            </div>


            @endif

        </div>
        <script>
            // function toggleAccordion(element) {

            //     const accordionBody = element.nextElementSibling;

            //     if (accordionBody.style.display === 'block') {

            //         accordionBody.style.display = 'none';

            //         element.classList.remove('active'); // Remove active class

            //     } else {

            //         accordionBody.style.display = 'block';

            //         element.classList.add('active'); // Add active class

            //     }
            // }

            // function toggleDetails(sectionId, clickedLink) {
            //     const tabs = ['personalDetails', 'accountDetails', 'familyDetails', 'employeeJobDetails', 'assetsDetails'];

            //     // Remove active class from all links
            //     const links = document.querySelectorAll('.custom-nav-link');
            //     links.forEach(link => link.classList.remove('active'));

            //     // Add active class to the clicked link
            //     clickedLink.classList.add('active');

            //     // Toggle tab visibility
            //     tabs.forEach(tab => {
            //         const tabElement = document.getElementById(tab);
            //         if (tabElement) {
            //             tabElement.style.display = (tab === sectionId) ? 'block' : 'none';
            //         }
            //     });
            // }

            // document.getElementById('employeeJobDetails').style.display = 'none';
            // document.addEventListener('DOMContentLoaded', function() {
            //     var today = new Date().toISOString().split('T')[0];
            //     document.getElementById('resignation_date').setAttribute('min', today);
            // });
        </script>
