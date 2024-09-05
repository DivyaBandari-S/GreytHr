<div>
    @if (session()->has('emp_error'))
    <div class="alert alert-danger">
        {{ session('emp_error') }}
    </div>
    @endif
    <div class="row  p-0">


        <div class="nav-buttons d-flex justify-content-center" style="margin-top: 15px;">
            <ul class="nav custom-nav-tabs border">
                <li class="custom-item m-0 p-0 flex-grow-1">
                    <div style="border-top-left-radius:5px;border-bottom-left-radius:5px;" class="custom-nav-link active" onclick="toggleDetails('personalDetails', this)">Personal</div>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1" style="border-left:1px solid #ccc;border-right:1px solid #ccc;">
                    <a href="#" style="border-radius:none;" class="custom-nav-link " onclick="toggleDetails('accountDetails', this)">Accounts & Statements</a>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1" style="border-left:1px solid #ccc;border-right:1px solid #ccc;">
                    <a href="#" style="border-radius:none;" class="custom-nav-link " onclick="toggleDetails('familyDetails', this)">Family</a>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1" style="border-left:1px solid #ccc;border-right:1px solid #ccc;">
                    <a href="#" style="border-radius:none;" class="custom-nav-link " onclick="toggleDetails('employeeJobDetails', this)">Employment & Job</a>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1">
                    <a href="#" style="border-top-right-radius:5px;border-bottom-right-radius:5px;" class="custom-nav-link " onclick="toggleDetails('assetsDetails', this)">Assets</a>
                </li>
            </ul>
        </div>
        <div>
            @if ($employeeDetails)

            {{-- Personal Tab --}}
            <div class="row p-0 gx-0" id="personalDetails" style=" margin:20px 0px;">
                <div class="col">
                    <div class="row p-3 gx-0" style="border-radius: 5px; width: 100%; background-color: white; margin-bottom: 20px;">
                        <div style="margin-top: 2%;margin-left:15px;color:#778899;font-weight:500;font-size:13px;margin-bottom: 20px;">
                            PROFILE</div>
                        <div class="col-12 col-md-4">
                            @if($image)
                            <div class="employee-profile-image-container" style="margin-left: 15px;">
                                <img height="80" src="{{ $image->temporaryUrl() }}" class="employee-profile-image">
                            </div>
                            @elseif(!empty($employeeDetails->image) && $employeeDetails->image !== 'null')
                            <div class="employee-profile-image-container" style="margin-left: 15px;">
                                <img height="80" src="{{ $employeeDetails->image_url }}" class="employee-profile-image">
                            </div>
                            @else
                            @if($employeeDetails->gender=='Male')
                            <div class="employee-profile-image-container mb-2" style="margin-left: 15px;">

                                <img src="{{ asset('images/male-default.png') }}" class="employee-profile-image-placeholder" height="80" width="80" alt="Default Image">
                            </div>
                            @elseif($employeeDetails->gender=='Female')
                            <div class="employee-profile-image-container mb-2" style="margin-left: 15px;">
                                <img src="{{ asset('images/female-default.jpg') }}" class="employee-profile-image-placeholder" height="80" width="80" alt="Default Image">
                            </div>
                            @else
                            <div class="employee-profile-image-container mb-2" style="margin-left: 15px;">
                                <img src="{{ asset('images/user.jpg') }}" class="employee-profile-image-placeholder" height="80" width="80" alt="Default Image">
                            </div>
                            @endif
                            @endif
                            @if ($errors->has('image'))
                            <span class="text-danger">{{ $errors->first('image') }}</span><br>
                            @endif
                            <div class="d-flex align-items-center gap-2 " style="margin-left: 15px;">
                                <button class="submit-btn px-2 py-1" wire:click="updateProfile">
                                    <span style="font-size: 10px;">Update</span>
                                </button>
                                <input type="file" id="imageInput" wire:model="image" class="form-control-small" style="font-size: 0.75rem;">
                            </div>
                            @if ($showSuccessMessage)
                            <span class="alert" style="font-size: 10px;color:green;cursor:pointer;" wire:poll.5s="closeMessage">
                                Profile updated successfully!
                            </span>
                            @endif

                            <div style="font-size: 12px; margin-top: 10px; color: #778899; margin-left: 15px">
                                Location
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;color:#000;">
                                @if ($employeeDetails->job_location)
                                {{$employeeDetails->job_location }}
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
                                Mobile Number
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

                    <div class="row p-3 gx-0" style="border-radius: 5px;  width: 100%; background-color: white;margin-bottom: 20px;">
                        <div style="margin-top: 2%;margin-left:15px;margin-bottom:20px;color:#778899;font-weight:500;font-size:13px;">
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

                    <div class="row p-3 gx-0" style="border-radius: 5px; width: 100%; background-color: white; margin-bottom: 20px;">
                        <div style="margin-top: 2%;margin-left:15px;color:#778899;font-weight:500;font-size:13px; margin-bottom: 10px;">
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



                            <div style="margin-top: 20px; font-size: 11px;color:#000; color: #778899; margin-left: 15px">
                                Name
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;color:#000;">
                                {{ ucwords(strtolower($employeeDetails->first_name)) }}
                                {{ ucwords(strtolower($employeeDetails->last_name)) }}
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
                                Mobile Number
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
                                @if ($employeeDetails->email)
                                {{ $employeeDetails->email }}
                                @else
                                <span style="padding-left: 15px;">-</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row p-3 gx-0" style="border-radius: 5px; width: 100%; background-color: white; margin-bottom: 20px;">
                        <div style="margin-top: 2%;margin-left:15px;color:#778899;font-weight:500;font-size:13px; margin-bottom: 10px;">
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

            <div class="row p-0 gx-0" style="margin:20px auto;border-radius: 5px;display: none;" id="accountDetails">
                <div class="col">
                    <div class="row p-3 gx-0" style="border-radius: 5px;  width: 100%; background-color: white; margin-bottom: 20px;">
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

                    <div class="row p-3 gx-0" style="border-radius: 5px;  width: 100%; background-color: white;margin-bottom: 20px;">
                        <div style="margin-top: 2%;margin-left:15px;font-size:12px;font-weight:500;color:#778899; margin-bottom: 10px;">
                            PF AMOUNT</div>
                        <div class="col-6">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                PF Number
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->empPersonalInfo )
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
                                @if ($employeeDetails->empPersonalInfo )
                                {{ $employeeDetails->empPersonalInfo->uan_no }}
                                @else
                                <span style="padding-left: 10px;">-</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row p-3 gx-0" style="border-radius: 5px;  width: 100%; background-color: white; margin-bottom: 20px;">
                        <div style="margin-top: 2%;margin-left:15px;font-size:12px;font-weight:500;color:#778899; margin-bottom: 10px;">
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



            <div style="margin:20px auto;border-radius: 5px;display: none;" id="familyDetails">
                <div class="row p-0 gx-0" style="border-radius: 5px;  width: 100%; background-color: white; margin-bottom: 20px;">
                    <!-- Header -->
                    <div style="margin-top: 2%; margin-left: 17px; font-size: 12px; font-weight: 500;color:#778899;">FATHER
                        DETAILS</div>
                    <div class="row p-3 gx-0">
                        <div class="col-12 col-md-3">
                          
                            @if (($employeeDetails->empParentDetails) && !empty(optional($employeeDetails->empParentDetails)->father_image) && optional($employeeDetails->empParentDetails)->father_image !== 'null')
                            <img style="border-radius: 5px; margin-left: 43px; margin-top: 10px;" height="100" width="100"
                                src="{{ 'data:image/jpeg;base64,' . base64_encode(optional($employeeDetails->empParentDetails)->father_image) }}">
                              
                            @else

                            <img style="border-radius: 5px; margin-left: 43px; margin-top: 10px;" height="100" width="100" src="{{ asset('images/male-default.png') }}"
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
                <div class="row p-0 gx-0" style="border-radius: 5px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <!-- Header -->
                    <div style="margin-top: 2%; margin-left: 17px; font-size: 12px; font-weight: 500;color:#778899;">MOTHER
                        DETAILS</div>
                    <div class="row p-3 gx-0">
                        <div class="col-12 col-md-3">
                            @if (($employeeDetails->empParentDetails) && !empty(optional($employeeDetails->empParentDetails)->mother_image) && optional($employeeDetails->empParentDetails)->mother_image !== 'null')
                            <img style="border-radius: 5px; margin-left: 43px; margin-top: 10px;" height="100" width="100"
                                src="{{ 'data:image/jpeg;base64,' . base64_encode(optional($employeeDetails->empParentDetails)->mother_image) }}">
                            @else

                            <img style="border-radius: 5px; margin-left: 43px; margin-top: 10px;" height="100" width="100" src="{{ asset('images/female-default.jpg') }}"
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
                                $paddingLeft = $displayValue === '-' ? '39px' : '0px';
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
            <div class="row p-0 gx-0" style="margin:20px auto;border-radius: 5px;display: none;" id="employeeJobDetails">
                <div class="col">
                    <div class="row p-3 gx-0" style="border-radius: 5px;width: 100%; background-color: white; margin-bottom: 20px;">
                        <div class="row mt-2 p-0 gx-0">
                            <div class="col-6 col-md-6">
                                <div style="margin-top: 2%;margin-left:15px;font-size:12px;font-weight:500;color:#778899; margin-bottom: 10px;">
                                    CURRENT POSITION </div>
                            </div>
                            <div class="col-6 col-md-6">
                                <div style="margin-top: 2%; font-size: 11px; color: blue; margin-left: 25px">
                                    Resign
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

                        <div class="col-6 col-md-3">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                                Reporting To
                            </div>
                            <div style="margin-left: 15px; font-size: 12px; margin-bottom: 10px;">
                                @if ($manager)
                                {{ ucwords(strtolower($manager->first_name)) }}
                                {{ ucwords(strtolower($manager->last_name)) }}
                                @else
                                No Manager Assigned
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
                            <div style="margin-left: 15px; font-size: 12px;">
                                @if ($department)
                                {{ $department->department }}
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
                                @if ($convertedTitle )
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

            {{-- Assets --}}

            <div class="row p-0 gx-0" style="margin:20px auto;border-radius: 5px;display: none;" id="assetsDetails">
                <div class="col">
                    <div class="row p-3 gx-0" style="border-radius: 5px;width: 100%; background-color: white; margin-bottom: 20px;">
                        <div style="margin-top: 2%;margin-left:15px;font-size:13px;font-weight:500;color:#778899;margin-bottom: 10px;">
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

                    <div class="row p-3 gx-0" style="border-radius: 5px; height: 100px; width: 100%; background-color: white; margin-bottom: 20px;">
                        <div style="margin-top: 2%;margin-left:15px;color:#778899;font-size:13px;font-weight:500;margin-bottom: 10px;">
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
                <div class="mt-4 d-flex flex-column justify-content-center align-items-center m-auto bg-white people-nodata-container">
                    <div class="d-flex flex-column align-items-center">
                        <img class="people-nodata-img" src="{{ asset('images/nodata.png') }}" alt="" height="300" width="200">
                    </div>
                </div>
            </div>


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
