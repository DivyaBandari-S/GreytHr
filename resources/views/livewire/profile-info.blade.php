<div>

    <div class="row m-0 p-0">


        <div class="card" style="width: auto; margin-left: 18%;padding:5px">
            <ul class="nav custom-nav-tabss"> <!-- Apply the custom class to the nav -->
                <li class="nav-item-pi flex-grow-1">
                    <a class="custom-nav-link-pi active" data-section="personalDetails" onclick="toggleDetails('personalDetails', this)">Personal</a>
                </li>
                <li class="nav-item-pi flex-grow-1">
                    <a class="custom-nav-link-pi" data-section="accountDetails" onclick="toggleDetails('accountDetails', this)">Accounts & Statements</a>
                </li>
                <li class="nav-item-pi flex-grow-1">
                    <a class="custom-nav-link-pi" data-section="familyDetails" onclick="toggleDetails('familyDetails', this)">Family</a>
                </li>
                <li class="nav-item-pi flex-grow-1">
                    <a class="custom-nav-link-pi" data-section="employeeJobDetails" onclick="toggleDetails('employeeJobDetails', this)">Employment & Job</a>
                </li>
                <li class="nav-item-pi flex-grow-1">
                    <a class="custom-nav-link-pi" data-section="assetsDetails" onclick="toggleDetails('assetsDetails', this)">Assets</a>
                </li>
            </ul>
        </div>
<div>

</div>
        @foreach($employeeDetails as $employee)
        {{-- Personal Tab --}}
        <div class="row p-0 " id="personalDetails" style=" margin:20px auto;">
            <div class="col">
                <div class="row" style="border-radius: 5px; height: 270px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px;color:#778899;font-weight:500;font-size:13px;">PROFILE</div>
                       <div class="col" >
                            @if($employee->image)
                                <div class="employee-profile-image-container" style="margin-left: 15px;">
                                    <img height="80" src="{{ asset('storage/' . $employee->image) }}" class="employee-profile-image">
                                </div>
                            @else
                                <div class="employee-profile-image-container" style="margin-left: 15px;">
                                    <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" class="employee-profile-image-placeholder" height="80" alt="Default Image">
                                </div>
                            @endif
                            @if($errors->has('image'))
                            <span class="text-danger">{{ $errors->first('image') }}</span><br>
                            @endif
                            <div class="d-flex align-items-start " style="margin-left: 15px;">
                                <button class="btn btn-primary btn-sm p-0" style="font-size: 10px; height: 20px;width:55px; background-color: rgb(2,17,79)" wire:click="updateProfile" wire:loading.attr="disabled" wire:target="updateProfile">
                                    <span style="font-size: 10px;" wire:loading wire:target="image">Uploading...</span>
                                    <span style="font-size: 10px;" wire:loading.remove>Update</span>
                                </button> <br>
                                <input type="file" id="imageInput" wire:model="image" class="form-control-small" style="font-size:10px;margin-left:5px;">
                            </div>
                            @if ($showSuccessMessage)
                                <span class="alert" style="font-size: 10px;color:green;cursor:pointer;" wire:click="closeMessage">
                                    Profile updated successfully!
                                </span>
                            @endif

                        <div style="font-size: 12px; margin-top: 10px; color: #778899; margin-left: 15px">
                            Location
                        </div>
                        <div style="margin-left: 15px; font-size: 12px;color:#000;">
                            {{$employee->job_location}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                            Name
                        </div>
                        <div style="margin-left: 15px; font-size: 12px;color:#000;">
                            {{ucwords(strtolower($employee->first_name))}} {{ucwords(strtolower($employee->last_name))}}
                        </div>
                        <div style="font-size: 11px; margin-top: 30px; color: #778899; margin-left: 15px;">
                            Employee ID
                        </div>
                        <div style="margin-left: 15px; font-size: 12px;color:#000;">
                            {{$employee->emp_id}}
                        </div>
                        <div style="font-size: 11px; margin-top: 30px; color: #778899; margin-left: 15px;">
                            Primary Contact No
                        </div>
                        <div style="margin-left: 15px; font-size: 12px;color:#000;">
                            {{$employee->mobile_number}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px;  color: #778899; margin-left: 15px">
                            Company E-mail
                        </div>
                        <div style="margin-left: 15px; font-size: 12px;color:#000;">
                            {{$employee->company_email}}
                        </div>
                    </div>
                </div>

                <div class="row" style="border-radius: 5px; height: 270px; width: 100%; background-color: white;margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px;margin-bottom:10px;color:#778899;font-weight:500;font-size:13px;">PERSONAL</div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                            Blood Group
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->blood_group}}
                        </div>
                        <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px;">
                            Marital Status
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->marital_status}}
                        </div>
                        <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                            Place Of Birth
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->city}}
                        </div>
                        <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                            Religion
                        </div>
                        @if($employee->religion)
                        <div style="margin-left: 15px; font-size: 12px;margin-bottom:10px;">
                            {{$employee->religion}}
                        </div>
                        @else
                        <div style="margin-left: 15px; font-size: 12px;margin-bottom:10px;">
                           -
                        </div>
                        @endif
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            Date Of Birth
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{ \Carbon\Carbon::parse($employee->date_of_birth)->format('d-M-Y') }}
                        </div>
                        <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                            Residential Status
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->job_location}}
                        </div>
                        <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                            Physically Challenged
                        </div>
                        <div style="margin-left: 15px; font-size: 12px;">
                            {{$employee->physically_challenge}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            Nationality
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->nationality}}
                        </div>
                        <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px">
                            Spouse
                        </div>
                        @if($employee->spouse)
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->spouse}}
                        </div>
                        @else
                        <div style="margin-left: 15px; font-size: 12px;margin-bottom:10px;">
                            -
                        </div>
                        @endif

                        <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                            Father Name
                        </div>
                        @if($employee->father_name)
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->father_name}}
                        </div>
                        @else
                        <div style="margin-left: 15px; font-size: 12px;margin-bottom:10px;">
                            -
                        </div>
                        @endif
                        <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                            International Employee
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->inter_emp}}
                        </div>
                    </div>
                </div>

                <div class="row" style="border-radius: 5px; height: 200px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px;color:#778899;font-weight:500;font-size:13px;">ADDRESS</div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            Address
                        </div>
                        @if(!$employee->address)
                        <div style="margin-left: 15px; font-size: 11px;color:#000;">
                            {{$employee->address}}
                        </div>
                        @else
                        <div style="margin-left: 15px; font-size: 12px;color:#000;">
                            -
                        </div>
                        @endif
                        <div style="margin-top: 20px; font-size: 11px;color:#000; color: #778899; margin-left: 15px">
                            Name
                        </div>
                        <div style="margin-left: 15px; font-size: 12px;color:#000;">
                            {{ucwords(strtolower($employee->first_name))}} {{ucwords(strtolower($employee->last_name))}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                            Mobile
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->mobile_number}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; margin-top: 20px; color: #778899; margin-left: 15px">
                            Email
                        </div>
                        @if($employee->email)
                        <div style="margin-left: 15px; font-size: 12px;color:#000;">
                            {{$employee->email}}
                        </div>
                        @else
                        <div style="margin-left: 15px; font-size: 12px;color:#000;">
                          -
                        </div>
                        @endif
                    </div>
                </div>

                <div class="row" style="border-radius: 5px; height: 100px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px;color:#778899;font-weight:500;font-size:13px;">EDUCATION</div>
                    <div class="col" style="margin-left: 15px; font-size: 12px">
                        <div style="font-size: 12px; color: #778899; margin-left: 15px">
                            No Data Found
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        {{-- Accounts & Statements --}}
        @foreach($empBankDetails as $bankDetails)
        <div class="row" style="margin:20px auto;border-radius: 5px;display: none;" id="accountDetails">
            <div class="col">
                <div class="row" style="border-radius: 5px; height: 150px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px;color:#778899;font-size:12px;font-weight:500;">BANK ACCOUNT</div>
                    <div class="col" style="margin-top: 5px;">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            Bank Name
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$bankDetails->bank_name}}
                        </div>
                        <div style="margin-top:10px;font-size: 11px; color: #778899; margin-left: 15px">
                            IFSC Code
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$bankDetails->ifsc_code}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                            Bank Account Number
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$bankDetails->account_number}}
                        </div>
                        <div style="margin-top:10px;font-size: 11px; color: #778899; margin-left: 15px">
                            Bank Address
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$bankDetails->bank_address}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            Bank Branch
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$bankDetails->bank_branch}}
                        </div>
                    </div>
                </div>

                <div class="row" style="border-radius: 5px; height: 100px; width: 100%; background-color: white;margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px;font-size:12px;font-weight:500;color:#778899;">PF AMOUNT</div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            PF Number
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->pf_no}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            UAN
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->pan_no}}
                        </div>
                    </div>
                </div>

                <div class="row" style="border-radius: 5px; height: 100px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px;font-size:12px;font-weight:500;color:#778899;">OTHERS IDS</div>
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
        @endforeach
        {{-- Family --}}
        @if($parentDetails->isEmpty())
        <div class="row" style="margin:20px auto;border-radius: 5px;display: none;" id="familyDetails">
            <hr style="border-top: 1px solid #ccc;">
            <div style="text-align: center;">No parent details available.Hr will add the details.</div>
        </div>
        @else
            @foreach($parentDetails as $details)
            <div class="row" style="margin:20px auto;border-radius: 5px;display: none;" id="familyDetails">
                <div class="col">
                    <div class="row" style="border-radius: 5px; height: 200px; width: 100%; background-color: white; margin-bottom: 20px;">
                        <div style="margin-top: 2%;margin-left:17px;font-size:12px;font-weight:500;">FATHER DETAILS</div>
                        <div class="col" style="margin-left: 15px;">
                            <img style="border-radius: 5px;" height="150" width="150" src="{{$details->father_image}}" alt="">
                        </div>
                        <div class="col">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Father Name
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                {{ucwords(strtolower($details->father_first_name))}} {{ucwords(strtolower($details->father_last_name))}}
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Address
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;width:250px">
                                {{$details->father_address}},{{$details->father_city}},{{$details->father_state}},{{$details->father_country}}
                            </div>
                        </div>
                        <div class="col">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Date of Birth
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                {{ \Carbon\Carbon::parse($details->father_dob)->format('d-M-Y') }}
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Nationality
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                {{$details->father_nationality}}
                            </div>
                        </div>
                        <div class="col">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Blood Group
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                {{$details->father_blood_group}}
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Occupation
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                {{$details->father_occupation}}
                            </div>
                        </div>
                        <div class="col">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Religion
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                {{ $details->father_religion }}
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Father Email
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                {{ $details->father_email }}
                            </div>
                        </div>
                    </div>



                    <div class="row" style="border-radius: 5px; height: 200px; width: 100%; background-color: white; margin-bottom: 20px;">
                        <div style="margin-top: 2%;margin-left:17px;font-size:12px;font-weight:500;">MOTHER DETAILS</div>
                        <div class="col" style="margin-left: 15px;">
                            <img style="border-radius: 5px;" height="150" width="150" src="{{$details->mother_image}}" alt="">
                        </div>
                        <div class="col">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Mother Name
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                {{ucwords(strtolower($details->mother_first_name))}} {{ucwords(strtolower($details->mother_last_name))}}
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Address
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;width:250px">
                                {{$details->mother_address}},{{$details->mother_city}},{{$details->mother_state}},{{$details->mother_country}}
                            </div>
                        </div>
                        <div class="col">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Date of Birth
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                {{ \Carbon\Carbon::parse($details->mother_dob)->format('d-M-Y') }}
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Nationality
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                {{$details->mother_nationality}}
                            </div>
                        </div>
                        <div class="col">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Blood Group
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                {{$details->mother_blood_group}}
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Occupation
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                {{$details->mother_occupation}}
                            </div>
                        </div>
                        <div class="col">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Religion
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                {{ $details->mother_religion }}
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899; margin-left: 15px">
                                Mother Email
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                {{ $details->mother_email }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
        @foreach($employeeDetails as $employee)
        {{-- Employment & Job --}}
        <div class="row" style="margin:20px auto;border-radius: 5px;display: none;" id="employeeJobDetails">
            <div class="col">
                <div class="row" style="border-radius: 5px; height: 250px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div class="row mt-2">
                        <div class="col">
                            <div style="margin-top: 2%;margin-left:15px;font-size:12px;font-weight:500;color:#778899;">CURRENT POSITION </div>
                        </div>
                        <div class="col">
                            <div style="margin-top: 2%; font-size: 11px; color: blue; margin-left: 25px">
                                Resign
                            </div>
                        </div>
                        <div class="col">
                            <div style="margin-top: 2%; font-size: 12px; color: indigo; margin-right: 3px">
                                <button style="background-color: blue; color: white; border-radius: 5px">View TimeLine</button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div style=" font-size: 11px; color: #778899; margin-left: 15px">
                            Reporting To
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->report_to}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            Department
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->department}}
                        </div>
                        <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px">
                            Subdepartment
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->Subdepartment}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            Designation
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->job_title}}
                        </div>
                        <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px">
                            Location
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->job_location}}
                        </div>
                        <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px">
                            Date of Join
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{ \Carbon\Carbon::parse($employee->hire_date)->format('d-M-Y') }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @endforeach
        {{-- Assets --}}
        @foreach($employeeDetails as $employee)
        <div class="row" style="margin:20px auto;border-radius: 5px;display: none;" id="assetsDetails">
            <div class="col">
                <div class="row" style="border-radius: 5px; height: 200px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px;font-size:13px;font-weight:500;color:#778899;">ACESS CARD DETAILS</div>
                    <div class="col">
                        <div style="font-size: 11px; color: #778899; margin-left: 15px">
                            Card No
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->adhar_no}}
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

                <div class="row" style="border-radius: 5px; height: 100px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px;color:#778899;font-size:13px;font-weight:500;">ASSETS</div>
                    <div class="col">
                        <div style="font-size: 12px; color: black; margin-left: 15px">
                            No Data Found
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
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

        const links = document.querySelectorAll('.custom-nav-link-pi');
        links.forEach(link => link.classList.remove('active'));

        clickedLink.classList.add('active');

        tabs.forEach(tab => {
            const tabElement = document.getElementById(tab);
            if(tabElement){
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