<div>
    @if (Session::has('success'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade show" style="
            height: 30px;
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
            align-items: center;
            display: flex;
            justify-content: center;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: lightgreen;
            color: white;
            margin-bottom: 5px;
            font-size: 12px;">
        {{ Session::get('success') }}
    </div>
    @endif
    <div>
        <div class="container" style="padding:0px;margin: 0;">
            <div id="alert-container" class="alert-container">
                <span id="close-btn" class="close-btn">&times;</span>
                @if (session()->has('emp_success'))
                {{ session('emp_success') }}
                @endif
            </div>
            <script>
                // Wait for the document to be ready (if using jQuery)
                $(document).ready(function() {
                    // Show the alert container
                    $('#alert-container').fadeIn();

                    // Set a timeout to hide the alert after a certain duration (e.g., 5000 milliseconds)
                    setTimeout(function() {
                        $('#alert-container').fadeOut();
                    }, 5000); // Adjust the duration as needed

                    // Close the alert on close button click
                    $('#close-btn').on('click', function() {
                        $('#alert-container').fadeOut();
                    });
                });
            </script>

            <div class="container " style="background:#f2f2f2;margin:0;padding:0;">
                <div class="d-flex justify-content-between p-3">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Employee</li>
                        </ol>
                    </nav>
                    <div>
                        <button style="width:200px; border-radius: 5px; background-color: rgb(2, 17, 79); color: white;"><a href="/update-employee-details" style="text-decoration: none;color:white">Employee
                                List</a></button>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="emp-container" style="padding:0; margin:0;">
                        <div class="card-header" style="background-color: rgb(2, 17, 79);color:white;margin:0;padding:5px 0;">
                            <h5 class="mb-0" style="text-align: center;color:white; font-size:16px;">Employee
                                Registration Form</h5>
                        </div>
                        <div class="emp-card-body mt-3 p-0">
                            <form wire:submit.prevent="register" enctype="multipart/form-data">
                                <div class="d-flex justify-content-between">
                                    <!-- Employee details -->
                                    <div class="col-md-6 d-flex flex-column justify-content-start bg-light">
                                        <div class="mb-2" style="display:flex;justify-content:start;color:rgb(2, 17, 79);">
                                            <h6 class="mt-2">Employee Details</h6>
                                        </div>
                                        <div class="form-group">
                                            <label for="first_name">First Name :</label>
                                            <input type="text" class="form-control placeholder-small" placeholder="Enter first name" wire:model="first_name" style="margin-bottom:10px;width:100%;">
                                            @error('first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="last_name">Last Name :</label>
                                            <input type="text" class="form-control placeholder-small" placeholder="Enter last name" wire:model="last_name" style="margin-bottom:10px;;">
                                            @error('last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="mobile_number">Phone Number :</label>
                                            <input type="text" class="form-control placeholder-small" placeholder="Enter phone number" wire:model="mobile_number" style="margin-bottom:10px;;">
                                            @error('mobile_number')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="alternate_mobile_number">Alternate Phone Number :</label>
                                            <input type="text" class="form-control placeholder-small" placeholder="Enter alternate phone number" wire:model="alternate_mobile_number" style="margin-bottom:10px;;">
                                            @error('alternate_mobile_number')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="education">Education :</label>
                                            <input type="text" class="form-control placeholder-small" placeholder="Enter education" wire:model="education" style="margin-bottom:10px;;">
                                            @error('education')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="experience">Experience :</label>
                                            <input type="text" class="form-control placeholder-small" placeholder="Enter experience" wire:model="experience" style="margin-bottom:10px;;">
                                            @error('experience')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email :</label>
                                            <input type="email" class="form-control placeholder-small" placeholder="Enter email" wire:model="email" style="margin-bottom:10px;;">
                                            @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Company Email :</label>
                                            <input type="email" class="form-control placeholder-small" placeholder="Enter company email" wire:model="company_email" style="margin-bottom:10px;;">
                                            @error('company_email')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="aadhar_no">Aadhar Number :</label>
                                            <input type="text" class="form-control placeholder-small" placeholder="Enter adhar number" wire:model="aadhar_no" style="margin-bottom:10px;;">
                                            @error('aadhar_no')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Password -->
                                        {{-- <div class="form-group">
                                                <label for="password">Password :</label>
                                                <input type="password" class="form-control placeholder-small" placeholder="Enter passowrd" wire:model="password"
                                                    style="margin-bottom:10px;;">
                                                @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div> --}}
                                    <div class="form-group">
                                        <div class="inpu-group">
                                            <label>Gender :</label><br>
                                            <div class="form-check form-check-inline" style="margin-top:10px;">
                                                <input class="form-check-input mb-2" type="radio" wire:model="gender" value="Male" id="maleRadio" name="gender">
                                                <label class="form-check-label " for="maleRadio">Male</label>
                                            </div>
                                            <div class="form-check form-check-inline" style="margin-top:10px;">
                                                <input class="form-check-input mb-2" type="radio" wire:model="gender" value="Female" id="femaleRadio" name="gender">
                                                <label class="form-check-label" for="femaleRadio">Female</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        @error('gender')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Upload Employee Image --}}
                                    <div class="form-group">
                                        <label for="image">Employee Image:</label>
                                        <input type="file" class="form-control-file" wire:model="image" style="margin-bottom:10px;">
                                        @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    @if($image)
                                    <img src="{{ is_string($image) ? asset('storage/' . $image) : $image->temporaryUrl() }}" alt="Preview" width="80" height="80" class="img-thumbnail" />
                                    @elseif($employee && $employee->image)
                                    <img src="{{ asset('storage/' . $employee->image) }}" alt="Preview" width="80" height="80" class="img-thumbnail" />
                                    @endif

                                </div>
                                <!-- job details -->
                                <div class="col-md-6 d-flex flex-column justify-content-start bg-light">
                                    <div class="mb-2" style="display:flex;justify-content:start;color:rgb(2, 17, 79);">
                                        <h6 class="mt-2">Job Details</h6>
                                    </div>
                                    <div class="form-group">
                                        <label for="hire_date">Hire Date :</label>
                                        <input type="date" class="form-control placeholder-small" wire:model="hire_date" max="{{ date('Y-m-d') }}" style="margin-bottom:10px;">
                                        @error('hire_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="employee_type">Employee Type:</label>
                                        <div class="input-group">
                                            <div class="form-check form-check-inline custom-radio">
                                                <input class="form-check-input mb-2" type="radio" id="full-time" value="full-time" wire:model="employee_type" checked>
                                                <label class="form-check-label " for="full-time">Full-Time</label>
                                            </div>
                                            <div class="form-check form-check-inline custom-radio">
                                                <input class="form-check-input mb-2" type="radio" id="part-time" value="part-time" wire:model="employee_type">
                                                <label class="form-check-label " for="part-time">Part-Time</label>
                                            </div>
                                            <div class="form-check form-check-inline custom-radio">
                                                <input class="form-check-input mb-2" type="radio" id="contract" value="contract" wire:model="employee_type">
                                                <label class="form-check-label " for="contract">Contract</label>
                                            </div>
                                        </div>
                                        @error('employee_type')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="employee_status">Employee Status:</label>
                                        <div class="input-group">
                                            <div class="form-check form-check-inline custom-radio">
                                                <input class="form-check-input mb-2" type="radio" id="active" value="active" wire:model="employee_status" checked>
                                                <label class="form-check-label " for="active">Active</label>
                                            </div>
                                            <div class="form-check form-check-inline custom-radio">
                                                <input class="form-check-input mb-2" type="radio" id="on-leave" value="on-leave" wire:model="employee_status">
                                                <label class="form-check-label " for="on-leave">On Leave</label>
                                            </div>
                                            <div class="form-check form-check-inline custom-radio">
                                                <input class="form-check-input mb-2" type="radio" id="terminated" value="terminated" wire:model="employee_status">
                                                <label class="form-check-label " for="terminated">Terminated</label>
                                            </div>
                                        </div>
                                        @error('employee_status')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="department">Department :</label>
                                        <input type="text" class="form-control placeholder-small" placeholder="Enter department" wire:model="department" style="margin-bottom:10px;;">
                                        @error('department')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="job_title">Job Title :</label>
                                        <input type="text" class="form-control placeholder-small" placeholder="Enter job title" wire:model="job_title" style="margin-bottom:10px;;">
                                        @error('job_title')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="job_location">Job Location :</label>
                                        <input type="text" class="form-control placeholder-small" placeholder="Enter job location " wire:model="job_location" style="margin-bottom:10px;;">
                                        @error('job_location')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="company_id">Company Id :</label>
                                        <select wire:click="selectedCompany" class="form-control placeholder-small" wire:model="company_id" style="margin-bottom: 10px;">
                                            <option value="">Select Company</option>
                                            <!-- Add a default option -->
                                            @foreach ($companieIds as $id)
                                            <option value="{{ $id->company_id }}">{{ $id->company_id }}</option>
                                            @endforeach
                                        </select>
                                        @error('company_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="company_name">Company Name :</label>
                                        @if ($companyName === null)
                                        <input type="text" class="form-control placeholder-small" placeholder="Enter manager name" wire:model="company_name" style="margin-bottom:10px;">
                                        @else
                                        <p class="mb-0" style="color:black;font-weight:500;font-size:0.825rem;">
                                            {{ $companyName }}
                                        </p>
                                        @endif
                                        @if ($companyName === null)
                                        @error('report_to')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @endif
                                    </div>


                                    <div class="form-group">
                                        <label for="manager_id">Manager Id :</label>
                                        <select wire:change="fetchReportTo" class="form-control placeholder-small" placeholder="Enter manager Id" wire:model="manager_id" style="margin-bottom: 10px;">
                                            <option value="">Select Manager</option>
                                            <!-- Add a default option -->
                                            @if ($managerIds != null)
                                            @foreach ($managerIds as $id)
                                            <option value="{{ $id }}">{{ $id }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @error('manager_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="report_to">Report To :</label>
                                        @if ($managerName === null)
                                        <input type="text" class="form-control placeholder-small" placeholder="Enter manager name" wire:model="report_to" style="margin-bottom:10px;">
                                        @else
                                        <p class="mb-0" style="color:black;font-weight:500;font-size:0.825rem;">
                                            {{ $managerName }}
                                        </p>
                                        @endif
                                        @if ($managerName === null)
                                        @error('report_to')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @endif
                                    </div>



                                    <div class="form-group">
                                        <div class="input-group">
                                            <label>International Employee :</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input mb-2" type="radio" wire:model="inter_emp" value="yes" id="yesRadio" name="inter_emp">
                                                <label class="form-check-label " for="yesRadio">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input mb-2" type="radio" wire:model="inter_emp" value="no" id="noRadio" name="inter_emp" checked>
                                                <label class="form-check-label " for="noRadio">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        @error('inter_emp')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                        </div>
                        <hr>
                    </div>

                    <div class="d-flex justify-content-between">
                        <!-- personal details -->
                        <div class="col-md-6 d-flex flex-column justify-content-start bg-light">
                            <div class="mb-2" style="display:flex;justify-content:start;color:rgb(2, 17, 79);">
                                <h6 class="mt-2">Employee Personal Details</h6>
                            </div>

                            <div class="form-group">
                                <label for="date_of_birth">Date of Birth :</label>
                                <input type="date" class="form-control placeholder-small" wire:model="date_of_birth" max="{{ date('Y-m-d') }}" style="margin-bottom:10px;">
                                @error('date_of_birth')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="blood_group">Blood Group :</label>
                                <input type="text" class="form-control placeholder-small" placeholder="Enter blood group" wire:model="blood_group" style="margin-bottom:10px;">
                                @error('blood_group')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="religion">Religion :</label>
                                <input type="text" class="form-control placeholder-small" placeholder="Enter religion" wire:model="religion" style="margin-bottom:10px;">
                                @error('religion')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nationality">Nationality :</label>
                                <input type="text" class="form-control placeholder-small" placeholder="Enter nationality" wire:model="nationality" style="margin-bottom:10px;">
                                @error('nationality')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label>Martial Status:</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input mb-2" type="radio" wire:model="marital_status" value="unmarried" id="unmarriedRadio" name="marital_status_group">
                                        <label class="form-check-label " for="unmarriedRadio">Single</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input mb-2" type="radio" wire:model="marital_status" value="married" id="marriedRadio" name="marital_status_group">
                                        <label class="form-check-label " for="marriedRadio">Married</label>
                                    </div>
                                </div>
                            </div>
                            <div>
                                @error('marital_status')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="spouse">Spouse:</label>
                                <input type="text" class="form-control placeholder-small" placeholder="Enter spouse name" wire:model="spouse" style="margin-bottom:10px;">
                                @error('spouse')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <label>Physically Challenge:</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input mb-2" type="radio" wire:model="physically_challenge" value="Yes" id="yesRadio" name="physically_challenge_group">
                                        <label class="form-check-label" for="yesRadio">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input mb-2" type="radio" wire:model="physically_challenge" value="No" id="noRadio" name="physically_challenge_group" checked>
                                        <label class="form-check-label" for="noRadio">No</label>
                                    </div>
                                </div>
                            </div>
                            <div>
                                @error('physically_challenge')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- other details -->
                        <div class="col-md-6 d-flex flex-column justify-content-start bg-light">
                            <div class="mb-2" style="display:flex;justify-content:start;color:rgb(2, 17, 79);">
                                <h6 class="mt-2">Other Details</h6>
                            </div>
                            <div class="form-group">
                                <label for="address">Address :</label>
                                <input type="text" class="form-control placeholder-small" placeholder="Enter address" wire:model="address" style="margin-bottom:10px;">
                                @error('address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="city">City :</label>
                                <input type="text" class="form-control placeholder-small" placeholder="Enter city" wire:model="city" style="margin-bottom:10px;">
                                @error('city')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="state">State :</label>
                                <input type="text" class="form-control placeholder-small" placeholder="Enter state" wire:model="state" style="margin-bottom:10px;">
                                @error('state')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="postal_code">Pin Code :</label>
                                <input type="text" class="form-control placeholder-small" placeholder="Enter pin code" wire:model="postal_code" style="margin-bottom:10px;">
                                @error('postal_code')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="country">Country :</label>
                                <input type="text" class="form-control placeholder-small" placeholder="Enter country" wire:model="country" style="margin-bottom:10px;">
                                @error('country')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="bg-light mt-0 mb-2" style="text-align: center;">
                        <!-- Check if employeeId is set, if set, it means we're editing an employee -->
                        @if($employeeId)
                        <button wire:click="updateEmployee" class="btn btn-primary" wire:loading.attr="disabled">Update</button>
                        @else
                        <!-- If employeeId is not set, it means we're adding a new employee -->
                        <button wire:click="register" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
                        @endif
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>