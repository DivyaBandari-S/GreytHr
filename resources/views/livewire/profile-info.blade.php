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




        @foreach($employeeDetails as $employee)
        {{-- Personal Tab --}}
        <div class="row p-0 " id="personalDetails" style="display: none; margin:20px auto;">
            <div class="col">
                <div class="row" style="border-radius: 5px; height: 250px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px">Profile</div>
                    <div class="col">
                        @if($employee->image)
                        <img class="profile-pic" style="border-radius: 50%; margin-left: 15px" height="80" width="80" src="{{ asset($employee->image) }}" alt="Profile Image">
                        @else
                            <img class="profile-pic" style="border-radius: 50%; margin-left: 15px" height="80" width="80" src="https://img.freepik.com/premium-vector/anonymous-user-circle-icon-vector-illustration-flat-style-with-long-shadow_520826-1931.jpg" alt="Profile Image">
                        @endif
                        <div style="font-size: 12px; margin-top: 30px; color: grey; margin-left: 15px">
                            Location
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->job_location}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 12px; color: grey; margin-left: 15px">
                            Name
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->first_name}} {{$employee->last_name}}
                        </div>
                        <div style="font-size: 12px; margin-top: 30px; color: grey; margin-left: 15px">
                            Employee ID
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->emp_id}}
                        </div>
                        <div style="font-size: 12px; margin-top: 30px; color: grey; margin-left: 15px">
                            Primary Contact No
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->mobile_number}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 12px; margin-top: 30px; color: grey; margin-left: 15px">
                            Company E-mail
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->company_email}}
                        </div>
                    </div>
                </div>

                <div class="row" style="border-radius: 5px; height: 270px; width: 100%; background-color: white;margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px;margin-bottom:10px;">Personal</div>
                    <div class="col">
                        <div style="font-size: 12px; color: grey; margin-left: 15px">
                            Blood Group
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->blood_group}}
                        </div>
                        <div style="margin-top: 20px; font-size: 12px; color: grey; margin-left: 15px">
                            Marital Status
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->marital_status}}
                        </div>
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Place Of Birth
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->city}}
                        </div>
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Religion
                        </div>
                        <div style="margin-left: 15px; font-size: 12px;margin-bottom:10px;">
                            {{$employee->religion}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 12px; color: grey; margin-left: 15px">
                            Date Of Birth
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{ \Carbon\Carbon::parse($employee->date_of_birth)->format('d-M-Y') }}
                        </div>
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Residential Status
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->job_location}}
                        </div>
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Physically Challenged
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->physically_challenge}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 12px; color: grey; margin-left: 15px">
                            Nationality
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->nationality}}
                        </div>
                        <div style="margin-top: 20px; font-size: 12px; color: grey; margin-left: 15px">
                            Spouse
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->spouse}}
                        </div>
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Father Name
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->father_name}}
                        </div>
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            International Employee
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->inter_emp}}
                        </div>
                    </div>
                </div>

                <div class="row" style="border-radius: 5px; height: 200px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px">Address</div>
                    <div class="col">
                        <div style="font-size: 12px; color: grey; margin-left: 15px">
                            Address
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->address}}
                        </div>
                        <div style="margin-top: 20px; font-size: 12px; color: grey; margin-left: 15px">
                            Name
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->first_name}} {{$employee->last_name}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Mobile
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->mobile_number}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Email
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->email}}
                        </div>
                    </div>
                </div>

                <div class="row" style="border-radius: 5px; height: 100px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px">Education</div>
                    <div class="col" style="margin-left: 15px; font-size: 12px">
                        <div style="font-size: 12px; color: grey; margin-left: 15px">
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
                    <div style="margin-top: 2%;margin-left:15px">Bank Account</div>
                    <div class="col" style="margin-top: 5px;">
                        <div style="font-size: 12px; color: grey; margin-left: 15px">
                            Bank Name
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$bankDetails->bank_name}}
                        </div>
                        <div style="margin-top:5px;font-size: 12px; color: grey; margin-left: 15px">
                            IFSC Code
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$bankDetails->ifsc_code}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 12px; color: grey; margin-left: 15px">
                            Bank Account Number
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$bankDetails->account_number}}
                        </div>
                        <div style="margin-top:5px;font-size: 12px; color: grey; margin-left: 15px">
                            Bank Address
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$bankDetails->bank_address}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 12px; color: grey; margin-left: 15px">
                            Bank Branch
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$bankDetails->bank_branch}}
                        </div>
                    </div>
                </div>

                <div class="row" style="border-radius: 5px; height: 100px; width: 100%; background-color: white;margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px">PF Amount</div>
                    <div class="col">
                        <div style="font-size: 12px; color: grey; margin-left: 15px">
                            PF Number
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->pf_no}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 12px; color: grey; margin-left: 15px">
                            UAN
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->pan_no}}
                        </div>
                    </div>
                </div>

                <div class="row" style="border-radius: 5px; height: 100px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px">Others IDS</div>
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
        @foreach($parentDetails as $details)
        <div class="row" style="margin:20px auto;border-radius: 5px;display: none;" id="familyDetails">
            <div class="col">
                <div class="row" style="border-radius: 5px; height: 200px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:17px">Father Details</div>
                    <div class="col" style="margin-left: 15px;">
                        <img style="border-radius: 5px;" height="150" width="150" src="{{$details->father_image}}" alt="">
                    </div>
                    <div class="col">
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Father Name
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$details->father_first_name}} {{$details->father_last_name}}
                        </div>
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Address
                        </div>
                        <div style="margin-left: 15px; font-size: 12px;width:250px">
                            {{$details->father_address}},{{$details->father_city}},{{$details->father_state}},{{$details->father_country}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Date of Birth
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{ \Carbon\Carbon::parse($details->father_dob)->format('d-M-Y') }}
                        </div>
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Nationality
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$details->father_nationality}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Blood Group
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$details->father_blood_group}}
                        </div>
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Occupation
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$details->father_occupation}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Religion
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{ $details->father_religion }}
                        </div>
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Father Email
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{ $details->father_email }}
                        </div>
                    </div>
                </div>



                <div class="row" style="border-radius: 5px; height: 200px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:17px">Mother Details</div>
                    <div class="col" style="margin-left: 15px;">
                        <img style="border-radius: 5px;" height="150" width="150" src="{{$details->mother_image}}" alt="">
                    </div>
                    <div class="col">
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Mother Name
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$details->mother_first_name}} {{$details->mother_last_name}}
                        </div>
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Address
                        </div>
                        <div style="margin-left: 15px; font-size: 12px;width:250px">
                            {{$details->mother_address}},{{$details->mother_city}},{{$details->mother_state}},{{$details->mother_country}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Date of Birth
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{ \Carbon\Carbon::parse($details->mother_dob)->format('d-M-Y') }}
                        </div>
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Nationality
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$details->mother_nationality}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Blood Group
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$details->mother_blood_group}}
                        </div>
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Occupation
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$details->mother_occupation}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
                            Religion
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{ $details->mother_religion }}
                        </div>
                        <div style="font-size: 12px; margin-top: 20px; color: grey; margin-left: 15px">
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
        @foreach($employeeDetails as $employee)
        {{-- Employment & Job --}}
        <div class="row" style="margin:20px auto;border-radius: 5px;display: none;" id="employeeJobDetails">
            <div class="col">
                <div class="row" style="border-radius: 5px; height: 250px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div class="row">
                        <div class="col">
                            <div style="margin-top: 2%;margin-left:15px">Current Position</div>
                        </div>
                        <div class="col">
                            <div style="margin-top: 2%; font-size: 12px; color: blue; margin-left: 25px">
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
                        <div style="margin-top: 20px; font-size: 12px; color: grey; margin-left: 15px">
                            Reporting To
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->report_to}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 12px; color: grey; margin-left: 15px">
                            Department
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->department}}
                        </div>
                        <div style="margin-top: 20px; font-size: 12px; color: grey; margin-left: 15px">
                            Subdepartment
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->Subdepartment}}
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 12px; color: grey; margin-left: 15px">
                            Designation
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->job_title}}
                        </div>
                        <div style="margin-top: 20px; font-size: 12px; color: grey; margin-left: 15px">
                            Location
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->job_location}}
                        </div>
                        <div style="margin-top: 20px; font-size: 12px; color: grey; margin-left: 15px">
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
                    <div style="margin-top: 2%;margin-left:15px">Access Card Details</div>
                    <div class="col">
                        <div style="font-size: 12px; color: grey; margin-left: 15px">
                            Card No
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            {{$employee->adhar_no}}
                        </div>
                        <div style="margin-top: 20px; font-size: 12px; color: grey; margin-left: 15px">
                            PREVIOUS
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            No Data Found
                        </div>
                    </div>
                    <div class="col">
                        <div style="font-size: 12px; color: grey; margin-left: 15px">
                            Validity
                        </div>
                        <div style="margin-left: 15px; font-size: 12px">
                            ____
                        </div>
                    </div>
                </div>

                <div class="row" style="border-radius: 5px; height: 100px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <div style="margin-top: 2%;margin-left:15px;">Assets</div>
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
    function toggleDetails(sectionId, clickedLink) {
        const tabs = ['personalDetails', 'accountDetails', 'familyDetails', 'employeeJobDetails', 'assetsDetails'];

        const links = document.querySelectorAll('.custom-nav-link-pi');
        links.forEach(link => link.classList.remove('active'));

        clickedLink.classList.add('active');

        tabs.forEach(tab => {
            const tabElement = document.getElementById(tab);
            if (tab === sectionId) {
                tabElement.style.display = 'block';
            } else {
                tabElement.style.display = 'none';
            }
        });
    }

    document.getElementById('personalDetails').style.display = 'block';
</script>