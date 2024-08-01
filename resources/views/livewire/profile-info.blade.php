<div>
    @if (session()->has('emp_error'))
        <div class="alert alert-danger">
            {{ session('emp_error') }}
        </div>
    @endif
    <div class="row  p-0" style="margin:0 10px;">


        <div class="nav-buttons d-flex justify-content-center" style="margin-top: 15px;">
            <ul class="nav custom-nav-tabs border">
                <li class="custom-item m-0 p-0 flex-grow-1">
                    <a href="#" style="border-top-left-radius:5px;border-bottom-left-radius:5px;"
                        class="custom-nav-link active" onclick="toggleDetails('personalDetails', this)">Personal</a>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1"
                    style="border-left:1px solid #ccc;border-right:1px solid #ccc;">
                    <a href="#" style="border-radius:none;" class="custom-nav-link "
                        onclick="toggleDetails('accountDetails', this)">Accounts & Statements</a>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1"
                    style="border-left:1px solid #ccc;border-right:1px solid #ccc;">
                    <a href="#" style="border-radius:none;" class="custom-nav-link "
                        onclick="toggleDetails('familyDetails', this)">Family</a>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1"
                    style="border-left:1px solid #ccc;border-right:1px solid #ccc;">
                    <a href="#" style="border-radius:none;" class="custom-nav-link "
                        onclick="toggleDetails('employeeJobDetails', this)">Employment & Job</a>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1">
                    <a href="#" style="border-top-right-radius:5px;border-bottom-right-radius:5px;"
                        class="custom-nav-link " onclick="toggleDetails('assetsDetails', this)">Assets</a>
                </li>
            </ul>
        </div>
        <div>
            @if ($employeeDetails)

                {{-- Personal Tab --}}
                <div class="row p-0 " id="personalDetails" style=" margin:20px auto;">
                    <div class="col">
                        <div class="row"
                            style="border-radius: 5px; height: 270px; width: 100%; background-color: white; margin-bottom: 20px;">
                            <div style="margin-top: 2%;margin-left:15px;color:#778899;font-weight:500;font-size:13px;">
                                PROFILE</div>
                            <div class="col">

                                @if ($employeeDetails)
                                
                                    <div class="employee-profile-image-container" style="margin-left: 15px;">
                                        <img height="80"
                                            src="{{ asset('storage/' . $employeeDetails->image) }}"
                                            class="employee-profile-image">
                                    </div>
                                @else
                                    <div class="employee-profile-image-container" style="margin-left: 15px;">
                                        <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain"
                                            class="employee-profile-image-placeholder" height="80"
                                            alt="Default Image">
                                    </div>
                                @endif
                                @if ($errors->has('image'))
                                    <span class="text-danger">{{ $errors->first('image') }}</span><br>
                                @endif
                                <div class="d-flex align-items-start " style="margin-left: 15px;">
                                    <button class="btn btn-primary btn-sm p-0"
                                        style="font-size: 10px; height: 20px;width:55px; background-color: rgb(2,17,79)"
                                        wire:click="updateProfile" wire:loading.attr="disabled"
                                        wire:target="updateProfile">
                                        <span style="font-size: 10px;" wire:loading
                                            wire:target="image">Uploading...</span>
                                        <span style="font-size: 10px;" wire:loading.remove>Update</span>
                                    </button> <br>
                                    <input type="file" id="imageInput" wire:model="image" class="form-control-small"
                                        style="font-size:10px;margin-left:5px;">
                                </div>
                                @if ($showSuccessMessage)
                                    <span class="alert" style="font-size: 10px;color:green;cursor:pointer;"
                                        wire:click="closeMessage">
                                        Profile updated successfully!
                                    </span>
                                @endif

                                <div style="font-size: 12px; margin-top: 10px; color: #778899; margin-left: 15px">
                                    Location
                                </div>
                                <div style="margin-left: 15px; font-size: 12px;color:#000;">
                                    {{ $employeeDetails->job_location ? $employeeDetails->job_location : '-' }}
                                </div>
                            </div>
                            <div class="col">
                                <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                                    Name
                                </div>
                                <div style="margin-left: 15px; font-size: 12px;color:#000;">
                                    {{ $employeeDetails->first_name && $employeeDetails->last_name
                                        ? ucwords(strtolower($employeeDetails->first_name)) . ' ' . ucwords(strtolower($employeeDetails->last_name))
                                        : '-' }}
                                </div>
                                <div style="font-size: 11px; margin-top: 30px; color: #778899; margin-left: 15px;">
                                    Employee ID
                                </div>
                                <div style="margin-left: 15px; font-size: 12px;color:#000;">
                                    {{ $employeeDetails->emp_id ? $employeeDetails->emp_id : '-' }}
                                </div>
                                <div style="font-size: 11px; margin-top: 30px; color: #778899; margin-left: 15px;">
                                    Primary Contact No
                                </div>
                                <div style="margin-left: 15px; font-size: 12px;color:#000;">
                                    {{ $employeeDetails->emergency_contact ? $employeeDetails->emergency_contact : '-' }}
                                </div>
                            </div>
                            <div class="col">
                                <div style="font-size: 11px;  color: #778899; margin-left: 15px">
                                    Company E-mail
                                </div>
                                <div style="margin-left: 15px; font-size: 12px;color:#000;">
                                    {{ $employeeDetails->email ? $employeeDetails->email : '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="row"
                            style="border-radius: 5px; height: 270px; width: 100%; background-color: white;margin-bottom: 20px;">
                            <div
                                style="margin-top: 2%;margin-left:15px;margin-bottom:20px;color:#778899;font-weight:500;font-size:13px;">
                                PERSONAL</div>
                            <div class="col">
                                <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                                    Blood Group
                                </div>
                                <div style="margin-left: 15px; font-size: 12px">
                                    {{ optional($employeeDetails->empPersonalInfo)->blood_group ?: '-' }}
                                </div>
                                <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px;">
                                    Marital Status
                                </div>
                                <div style="margin-left: 15px; font-size: 12px">
                                    {{ optional($employeeDetails->empPersonalInfo)->marital_status
                                        ? ucwords(strtolower(optional($employeeDetails->empPersonalInfo)->marital_status))
                                        : '-' }}

                                </div>
                                <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                                    Place Of Birth
                                </div>
                                <div style="margin-left: 15px; font-size: 12px">
                                    {{ optional($employeeDetails->empPersonalInfo)->city ?? '-' }}

                                </div>
                                <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                                    Religion
                                </div>

                                <div style="margin-left: 15px; font-size: 12px;margin-bottom:10px;">
                                    {{ optional($employeeDetails->empPersonalInfo)->religion ?? '-' }}

                                </div>

                            </div>
                            <div class="col">
                                <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                    Date Of Birth
                                </div>
                                <div style="margin-left: 15px; font-size: 12px">
                                    {{ $employeeDetails->empPersonalInfo && $employeeDetails->empPersonalInfo->date_of_birth
                                        ? \Carbon\Carbon::parse($employeeDetails->empPersonalInfo->date_of_birth)->format('d-M-Y')
                                        : '-' }}
                                </div>
                                <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                                    Residential Status
                                </div>
                                <div style="margin-left: 15px; font-size: 12px">
                                    {{ $employeeDetails->job_location ? $employeeDetails->job_location : '-' }}
                                </div>
                                <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                                    Physically Challenged
                                </div>
                                <div style="margin-left: 15px; font-size: 12px;">
                                    {{ optional($employeeDetails->empPersonalInfo)->physically_challenge ? ucwords(strtolower(optional($employeeDetails->empPersonalInfo)->physically_challenge)) : '-' }}

                                </div>
                            </div>
                            <div class="col">
                                <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                    Nationality
                                </div>
                                <div style="margin-left: 15px; font-size: 12px">
                                    {{ optional($employeeDetails->empPersonalInfo)->nationality ?? '-' }}

                                </div>
                                <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px">
                                    Spouse
                                </div>

                                <div style="margin-left: 15px; font-size: 12px">
                                    {{ optional($employeeDetails->empSpouseDetails)->name ?? '-' }}

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
                                    @endphp

                                    {{ $displayName }}

                                </div>

                                <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                                    International Employee
                                </div>
                                <div style="margin-left: 15px; font-size: 12px">
                                    {{ $employeeDetails->inter_emp ? ucwords(strtolower($employeeDetails->inter_emp)) : '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="row"
                            style="border-radius: 5px; height: 200px; width: 100%; background-color: white; margin-bottom: 20px;">
                            <div style="margin-top: 2%;margin-left:15px;color:#778899;font-weight:500;font-size:13px;">
                                ADDRESS</div>
                            <div class="col">
                                <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                    Permanent Address
                                </div>

                                <div style="margin-left: 15px; font-size: 11px;color:#000;">
                                    {{ optional($employeeDetails->empPersonalInfo)->permenant_address ?: '-' }}

                                </div>



                                <div
                                    style="margin-top: 20px; font-size: 11px;color:#000; color: #778899; margin-left: 15px">
                                    Name
                                </div>
                                <div style="margin-left: 15px; font-size: 12px;color:#000;">
                                    {{ ucwords(strtolower($employeeDetails->first_name)) }}
                                    {{ ucwords(strtolower($employeeDetails->last_name)) }}
                                </div>
                            </div>
                            <div class="col">
                                <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                    Present Address
                                </div>

                                <div style="margin-left: 15px; font-size: 11px;color:#000;">
                                    {{ optional($employeeDetails->empPersonalInfo)->present_address ?: '-' }}

                                </div>

                                <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                                    Mobile
                                </div>
                                <div style="margin-left: 15px; font-size: 12px">
                                    {{ optional($employeeDetails->empPersonalInfo)->mobile_number ?: '-' }}

                                </div>
                            </div>
                            <div class="col">
                                <div style="font-size: 11px;  color: #778899; margin-left: 15px">
                                    Email
                                </div>
                                <div style="margin-left: 15px; font-size: 12px;color:#000;">
                                    {{ $employeeDetails->email ? $employeeDetails->email : '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="row"
                            style="border-radius: 5px; height: 100px; width: 100%; background-color: white; margin-bottom: 20px;">
                            <div style="margin-top: 2%;margin-left:15px;color:#778899;font-weight:500;font-size:13px;">
                                EDUCATION</div>
                            <div class="col" style="margin-left: 15px; font-size: 12px">
                                <div style="font-size: 12px; color: #778899; margin-left: 15px">
                                    No Data Found
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Accounts & Statements --}}

                <div class="row" style="margin:20px auto;border-radius: 5px;display: none;" id="accountDetails">
                    <div class="col">
                        <div class="row"
                            style="border-radius: 5px; height: 150px; width: 100%; background-color: white; margin-bottom: 20px;">
                            <div style="margin-top: 2%;margin-left:15px;color:#778899;font-size:12px;font-weight:500;">
                                BANK ACCOUNT</div>
                            <div class="col" style="margin-top: 5px;">
                                <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                    Bank Name
                                </div>
                                <div style="margin-left: 15px; font-size: 12px">
                                    {{ $employeeDetails->empBankDetails ? $employeeDetails->empBankDetails->bank_name : '-' }}

                                </div>
                                <div style="margin-top:10px;font-size: 11px; color: #778899; margin-left: 15px">
                                    IFSC Code
                                </div>
                                <div style="margin-left: 15px; font-size: 12px">
                                    {{ $employeeDetails->empBankDetails ? $employeeDetails->empBankDetails->ifsc_code : '-' }}
                                </div>
                            </div>
                            <div class="col">
                                <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                                    Bank Account Number
                                </div>
                                <div style="margin-left: 15px; font-size: 12px">
                                    {{ $employeeDetails->empBankDetails ? $employeeDetails->empBankDetails->account_number : '-' }}
                                </div>
                                <div style="margin-top:10px;font-size: 11px; color: #778899; margin-left: 15px">
                                    Bank Address
                                </div>
                                <div style="margin-left: 15px; font-size: 12px">
                                    {{ $employeeDetails->empBankDetails ? $employeeDetails->empBankDetails->bank_address : '-' }}
                                </div>
                            </div>
                            <div class="col">
                                <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                    Bank Branch
                                </div>
                                <div style="margin-left: 15px; font-size: 12px">
                                    {{ $employeeDetails->empBankDetails ? $employeeDetails->empBankDetails->bank_branch : '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="row"
                            style="border-radius: 5px; height: 100px; width: 100%; background-color: white;margin-bottom: 20px;">
                            <div style="margin-top: 2%;margin-left:15px;font-size:12px;font-weight:500;color:#778899;">
                                PF AMOUNT</div>
                            <div class="col">
                                <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                    PF Number
                                </div>
                                <div style="margin-left: 15px; font-size: 12px">
                                    {{ $employeeDetails->empPersonalInfo ? $employeeDetails->empPersonalInfo->pf_no : '-' }}
                                </div>
                            </div>
                            <div class="col">
                                <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                    UAN
                                </div>
                                <div style="margin-left: 15px; font-size: 12px">
                                    {{ $employeeDetails->empPersonalInfo ? $employeeDetails->empPersonalInfo->pan_no : '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="row"
                            style="border-radius: 5px; height: 100px; width: 100%; background-color: white; margin-bottom: 20px;">
                            <div style="margin-top: 2%;margin-left:15px;font-size:12px;font-weight:500;color:#778899;">
                                OTHERS IDS</div>
                            <div class="col">
                                <div style="margin-left: 15px; font-size: 12px">
                                    ___
                                </div>
                            </div>
                            <div class="col">
                                <div style="color: red; margin-left: 15px; font-size: 12px">
                                    Unverified
                                </div>
                            </div>
                        </div>
                    </div>

                </div>



                <div style="margin:20px auto;border-radius: 5px;display: none;" id="familyDetails">
                    <div class="row"
                        style="border-radius: 5px; height: 200px; width: 100%; background-color: white; margin-bottom: 20px;">
                        <!-- Header -->
                        <div style="margin-top: 2%; margin-left: 17px; font-size: 12px; font-weight: 500;">FATHER
                            DETAILS</div>
                        <div class="row">
                            <div class="col-3">
                                <img style="border-radius: 5px;" height="150" width="150"
                                    src="{{ optional($employeeDetails->empParentDetails)->father_image ?: 'path/to/default/image.jpg' }}"
                                    alt="">
                            </div>
                            <div class="col-3">
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
                                    {{ $displayName }}
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
                                    @endphp
                                    {{ $displayValue }}
                                </div>
                            </div>

                            <div class="col-2">
                                <div style="font-size: 12px; margin-top: 20px; color: #778899;">Date of Birth</div>
                                <div style="font-size: 12px">
                                    {{ optional($employeeDetails->empParentDetails)->father_dob
                                        ? \Carbon\Carbon::parse($employeeDetails->empParentDetails->father_dob)->format('d-M-Y')
                                        : '-' }}
                                </div>
                                <div style="font-size: 12px; margin-top: 20px; color: #778899;">Nationality</div>
                                <div style="font-size: 12px">
                                    {{ optional($employeeDetails->empParentDetails)->father_nationality ?? '-' }}
                                </div>
                            </div>

                            <div class="col-2">
                                <div style="font-size: 12px; margin-top: 20px; color: #778899;">Blood Group</div>
                                <div style="font-size: 12px">
                                    {{ optional($employeeDetails->empParentDetails)->father_blood_group ?? '-' }}
                                </div>
                                <div style="font-size: 12px; margin-top: 20px; color: #778899;">Occupation</div>
                                <div style="font-size: 12px">
                                    {{ optional($employeeDetails->empParentDetails)->father_occupation ?? '-' }}
                                </div>
                            </div>
                            <div class="col-2">
                                <div style="font-size: 12px; margin-top: 20px; color: #778899;">Religion</div>
                                <div style="font-size: 12px; word-wrap: break-word;">
                                    {{ optional($employeeDetails->empParentDetails)->father_religion ?? '-' }}
                                </div>
                                <div style="font-size: 12px; margin-top: 20px; color: #778899;">Father Email</div>
                                <div style="font-size: 12px; word-wrap: break-word; white-space: normal;">
                                    {{ optional($employeeDetails->empParentDetails)->father_email ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row"
                        style="border-radius: 5px; height: 200px; width: 100%; background-color: white; margin-bottom: 20px;">
                        <!-- Header -->
                        <div style="margin-top: 2%; margin-left: 17px; font-size: 12px; font-weight: 500;">MOTHER
                            DETAILS</div>
                        <div class="row">
                            <div class="col-3">
                                <img style="border-radius: 5px;" height="150" width="150"
                                    src="{{ optional($employeeDetails->empParentDetails)->mother_image ?: 'path/to/default/image.jpg' }}"
                                    alt="">
                            </div>
                            <div class="col-3">
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
                                    @endphp
                                    {{ $displayName }}
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
                                    @endphp
                                    {{ $displayValue }}
                                </div>
                            </div>

                            <div class="col-2">
                                <div style="font-size: 12px; margin-top: 20px; color: #778899;">Date of Birth</div>
                                <div style="font-size: 12px">
                                    {{ optional($employeeDetails->empParentDetails)->mother_dob
                                        ? \Carbon\Carbon::parse($employeeDetails->empParentDetails->mother_dob)->format('d-M-Y')
                                        : '-' }}
                                </div>
                                <div style="font-size: 12px; margin-top: 20px; color: #778899;">Nationality</div>
                                <div style="font-size: 12px">
                                    {{ optional($employeeDetails->empParentDetails)->mother_nationality ?? '-' }}
                                </div>
                            </div>

                            <div class="col-2">
                                <div style="font-size: 12px; margin-top: 20px; color: #778899;">Blood Group</div>
                                <div style="font-size: 12px">
                                    {{ optional($employeeDetails->empParentDetails)->mother_blood_group ?? '-' }}
                                </div>
                                <div style="font-size: 12px; margin-top: 20px; color: #778899;">Occupation</div>
                                <div style="font-size: 12px">
                                    {{ optional($employeeDetails->empParentDetails)->mother_occupation ?? '-' }}
                                </div>
                            </div>
                            <div class="col-2">
                                <div style="font-size: 12px; margin-top: 20px; color: #778899;">Religion</div>
                                <div style="font-size: 12px; word-wrap: break-word;">
                                    {{ optional($employeeDetails->empParentDetails)->mother_religion ?? '-' }}
                                </div>
                                <div style="font-size: 12px; margin-top: 20px; color: #778899;">Mother Email</div>
                                <div style="font-size: 12px; word-wrap: break-word; white-space: normal;">
                                    {{ optional($employeeDetails->empParentDetails)->mother_email ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                    {{-- Employment & Job --}}
                    <div class="row" style="margin:20px auto;border-radius: 5px;display: none;"
                        id="employeeJobDetails">
                        <div class="col">
                            <div class="row"
                                style="border-radius: 5px; height: 250px; width: 100%; background-color: white; margin-bottom: 20px;">
                                <div class="row mt-2">
                                    <div class="col">
                                        <div
                                            style="margin-top: 2%;margin-left:15px;font-size:12px;font-weight:500;color:#778899;">
                                            CURRENT POSITION </div>
                                    </div>
                                    <div class="col">
                                        <div style="margin-top: 2%; font-size: 11px; color: blue; margin-left: 25px">
                                            Resign
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div style="margin-top: 2%; font-size: 12px; color: indigo; margin-right: 3px">
                                            <button
                                                style="background-color: blue; color: white; border-radius: 5px">View
                                                TimeLine</button>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    // Fetch the manager details directly in Blade
                                    $manager = \App\Models\EmployeeDetails::where(
                                        'emp_id',
                                        $employeeDetails->manager_id,
                                    )->first();
                                @endphp

                                <div class="col">
                                    <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                                        Reporting To
                                    </div>
                                    <div style="margin-left: 15px; font-size: 12px;">
                                        @if ($manager)
                                            {{ ucwords(strtolower($manager->first_name)) }}
                                            {{ ucwords(strtolower($manager->last_name)) }}
                                        @else
                                            No Manager Assigned
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
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
                                    <div style="margin-left: 15px; font-size: 12px;">
                                        @if ($department)
                                            {{ $department->department }}
                                        @else
                                            No Department Assigned
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
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
                                            {{ $subDepartment->sub_department }}
                                        @else
                                            No Department Assigned
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                        Designation
                                    </div>
                                    <div style="margin-left: 15px; font-size: 12px">
                                        {{ $employeeDetails->job_role ?: '-' }}
                                    </div>
                                    <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px">
                                        Location
                                    </div>
                                    <div style="margin-left: 15px; font-size: 12px">
                                        {{ $employeeDetails->job_location ?: '-' }}
                                    </div>

                                    <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px">
                                        Date of Join
                                    </div>
                                    <div style="margin-left: 15px; font-size: 12px">
                                        {{ \Carbon\Carbon::parse($employeeDetails->hire_date)->format('d-M-Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Assets --}}

                    <div class="row" style="margin:20px auto;border-radius: 5px;display: none;"
                        id="assetsDetails">
                        <div class="col">
                            <div class="row"
                                style="border-radius: 5px; height: 200px; width: 100%; background-color: white; margin-bottom: 20px;">
                                <div
                                    style="margin-top: 2%;margin-left:15px;font-size:13px;font-weight:500;color:#778899;">
                                    ACESS CARD DETAILS</div>
                                <div class="col">
                                    <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                        Card No
                                    </div>
                                    <div style="margin-left: 15px; font-size: 12px">
                                        {{ optional($employeeDetails->empPersonalInfo)->adhar_no ?? '-' }}

                                    </div>
                                    <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px">
                                        PREVIOUS
                                    </div>
                                    <div style="margin-left: 15px; font-size: 12px">
                                        No Data Found
                                    </div>
                                </div>
                                <div class="col">
                                    <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                        Validity
                                    </div>
                                    <div style="margin-left: 15px; font-size: 12px">
                                        ____
                                    </div>
                                </div>
                            </div>

                            <div class="row"
                                style="border-radius: 5px; height: 100px; width: 100%; background-color: white; margin-bottom: 20px;">
                                <div
                                    style="margin-top: 2%;margin-left:15px;color:#778899;font-size:13px;font-weight:500;">
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
                    <p>hi</p>

            @endif

        </div>
        <script>
            function toggleAccordion(element) {

                const accordionBody = element.nextElementSibling;

                if (accordionBody.style.display === 'block') {

                    accordionBody.style.display = 'none';

                    element.classList.remove('active'); // Remove active class

                } else {

                    accordionBody.style.display = 'block';

                    element.classList.add('active'); // Add active class

                }
            }

            function toggleDetails(sectionId, clickedLink) {
                const tabs = ['personalDetails', 'accountDetails', 'familyDetails', 'employeeJobDetails', 'assetsDetails'];

                const links = document.querySelectorAll('.custom-nav-link');
                links.forEach(link => link.classList.remove('active'));

                clickedLink.classList.add('active');

                tabs.forEach(tab => {
                    const tabElement = document.getElementById(tab);
                    if (tabElement) {
                        if (tab === sectionId) {
                            tabElement.style.display = 'block';
                        } else {
                            tabElement.style.display = 'none';
                        }
                    }
                });
            }

            document.getElementById('personalDetails').style.display = 'block';
        </script>
