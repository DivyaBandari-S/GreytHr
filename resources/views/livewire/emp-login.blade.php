<div class="container-fluid p-0 loginBGGradiant">
    <div class="m-0 pb-2 pt-3 row">
        <div class="col-md-12" style="text-align: end;">
            <button class="btn btn-primary" wire:click="jobs"
                style="background-color: rgb(2, 17, 79);color:white;border-radius:5px;border:none">
                Recruitment</button>
        </div>
    </div>


    <div class="row m-0 d-felx align-items-center">
        <!-- Left Side (Login Form) -->
        <div class="col-md-6 ">

            @if ($showAlert)
                <div class="d-flex justify-content-center w-100" wire:poll.5s='hideAlert'>

                    <div class="alert alert-success " style="font-size: 12px; ">
                        <p class="mb-0 mr-2"> {{ $alertMessage }}</p>
                        <span style="margin-left: 20px;cursor:pointer" wire:click='hideAlert'>x</span>
                    </div>
                </div>
            @endif
            @if (session('sessionExpired'))
                <div class="alert alert-danger">
                    {{ session('sessionExpired') }}
                </div>
            @endif

            <form wire:submit.prevent="empLogin" class="login-form-with-shadow"
                style="margin-top: 0px; background-color: #f2f2f6; backdrop-filter: blur(36px);">
                <div class="text-center mb-1" style="padding-top: 20px;">
                    <img src="{{ asset('images/hr_new_blue.png') }}" alt="Company Logo"
                        style="width: 14em !important; height: auto !important; margin-bottom: 10px;">
                </div>

                <hr class="bg-white" />
                <header _ngcontent-hyf-c110="" class="mb-12 text-center">
                    <div _ngcontent-hyf-c110=""
                        class="text-12gpx font-bold font-title-poppins-bold opacity-90 text-text-default justify-items-center">

                        Hello there! <span _ngcontent-hyf-c110="" class="font-emoji text-12gpx">👋</span>

                    </div>
                </header><br>
                @if ($error)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong style="font-size: 12px;">{{ $error }}</strong>
                        <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                    </div>
                @endif
                <div class="form-group">
                    <label for="emp_id" style="font-size: 14px;">ID / Mail</label>
                    <input type="text" class="form-control" id="emp_id" placeholder="Enter ID / Mail"
                        wire:model.lazy="form.emp_id" wire:input="login"
                        wire:keydown.debounce.500ms="validateField('form.emp_id')"
                        oninput="this.value = this.value.toUpperCase()" />

                    @error('form.emp_id')
                        <p class="pt-2 px-1 text-danger">{{ str_replace('form.emp id', 'Employee ID', $message) }}</p>
                    @enderror
                </div>
                <div class="form-group" style="margin-top: 20px;">
                    <label for="password" style="font-size: 14px;">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter Password"
                        wire:model.lazy="form.password" wire:input="login"
                        wire:keydown.debounce.500ms="validateField('form.password')" />

                    @error('form.password')
                        <p class="pt-2 px-1 text-danger">{{ str_replace('form.password', 'Password', $message) }}</p>
                    @enderror
                </div>
                <div style="margin-left: 60%; text-align: center;" wire:click="show">
                    <span><a href="#" wire:click="show" style="color: rgb(2, 17, 79);font-size:12px;">Forgot
                            Password?</a></span>
                </div>
                <div class="form-group" style="text-align:center; margin-top:10px;">
                    <input data-bs-toggle="modal" data-bs-target="#loginLoader"
                        style="background-color:rgb(2,17,79); font-size:small; width:fit-content; margin: 0 auto;"
                        type="submit" class="btn btn-primary btn-block" value="Login" />
                </div>



            </form>

        </div>
        <!-- Right Side (Carousel) -->
        <div class="col-md-6 p-0">
            <!-- Carousel -->
            <div id="demo" class="carousel slide" data-bs-ride="carousel"
                style="background-color: f0f0f0; aspect-ratio: 16/6;border-radius:10px">
                <!-- Indicators/dots -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                </div>

                <!-- The slideshow/carousel -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/communication.svg') }}" style="width: 85%;" alt="Los Angeles"
                            class="d-block">
                        <div class="carousel-caption" style="bottom: 0px; padding-bottom: 0px; color: #007bff;">

                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/task.svg') }}" style="width: 85%;" alt="Chicago"
                            class="d-block">
                        <div class="carousel-caption" style="bottom: 0px; padding-bottom: 0px; color: #007bff;">

                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/working.svg') }}" style="width: 85%;" alt="New York"
                            class="d-block">
                        <div class="carousel-caption" style="bottom: 0px; padding-bottom: 0px; color: #007bff;">

                        </div>
                    </div>
                </div>

                <!-- Left and right controls/icons -->
                <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
        <div class="text-center pb-2">
            <small>
                © Xsilica Software Solutions Pvt.Ltd |
                <a href="/Privacy&Policy" target="_blank" style="color: rgb(2, 17, 79);">Privacy Policy</a> |
                <a href="/Terms&Services" target="_blank" style="color: rgb(2, 17, 79);">Terms of Service</a>
            </small>
        </div>
        @if ($showDialog)
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: rgb(2, 17, 79);">
                            <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title">
                                <b>{{ $verified ? 'Reset Password' : 'Forgot Password' }}</b>
                            </h5>
                            <button type="button" class="btn-close btn-primary" data-dismiss="modal"
                                aria-label="Close" wire:click="remove"
                                style="background-color: white; height:10px;width:10px;">
                            </button>
                        </div>
                        <div class="modal-body" style="background-color: #f0f0f0; padding: 20px;">
                            @if ($verified)
                                <!-- Form for creating a new password -->
                                <form wire:submit.prevent="createNewPassword">
                                    <!-- Add input fields for new password and confirmation -->
                                    @if ($pass_change_error)
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong style="font-size: 10px;">{{ $pass_change_error }}</strong>
                                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="newPassword">New Password</label>
                                        <input type="password" id="newPassword" name="newPassword"
                                            class="form-control" placeholder="Enter your new password"
                                            wire:model.lazy="newPassword"
                                            wire:keydown.debounce.500ms="validateField('newPassword')">
                                        @error('newPassword')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="newPassword_confirmation">Confirm New Password</label>
                                        <input type="password" id="newPassword_confirmation"
                                            name="newPassword_confirmation" class="form-control"
                                            placeholder="Enter your new password"
                                            wire:model.lazy="newPassword_confirmation"
                                            wire:keydown.debounce.500ms="validateField('newPassword_confirmation')">
                                        @error('newPassword_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-center mt-2">
                                        <button type="submit" class="btn btn-success">Reset Password</button>
                                    </div>

                                    <!-- Success or error message for password update -->
                                    @if (session()->has('passwordMessage'))
                                        <div class="alert alert-success mt-3">
                                            {{ session('passwordMessage') }}
                                        </div>
                                    @endif
                                </form>
                            @else
                                <!-- Form for verifying email and DOB -->
                                <form wire:submit.prevent="verifyEmailAndDOB">
                                    <!-- Add input fields for email and DOB verification -->
                                    @if ($verify_error)
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong style="font-size: 10px;">{{ $verify_error }}</strong>
                                            <!-- <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button> -->
                                        </div>
                                    @endif

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" name="email" class="form-control"
                                            placeholder="Enter your email" wire:model.lazy="email"
                                            wire:keydown.debounce.500ms="validateField('email')"
                                            wire:input="forgotPassword">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="dob">Date Of Birth</label>
                                        <div class="input-group">
                                            <input type="date" id="dob" name="dob" class="form-control"
                                                max="{{ date('Y-m-d') }}" wire:model.lazy="dob"
                                                wire:keydown.debounce.500ms="validateField('dob')"
                                                wire:input="forgotPassword">
                                        </div>
                                        @error('dob')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-center mt-2">
                                        <button type="submit" class="submit-btn">Verify</button>
                                    </div>

                                    <!-- Success or error message for email and DOB verification -->
                                    @if (session()->has('emailDobMessage'))
                                        <div class="alert alert-{{ session('emailDobMessageType') }} mt-3">
                                            {{ session('emailDobMessage') }}
                                        </div>
                                    @endif
                                </form>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show blurred-backdrop"></div>
        @endif

        @if ($showSuccessModal)
            <!-- Success Message and Password Change Modal -->
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: rgb(2, 17, 79);">
                            <h5 style="padding: 10px; color: white; font-size: 15px;" class="modal-title">
                                <b>Verification successful!</b>
                            </h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"
                                wire:click="closeSuccessModal">
                            </button>
                        </div>
                        <div class="modal-body" style="background-color: #f0f0f0;">
                            <p style="padding: 30px 0px; text-align: center;">Do you want to Reset your password?</p>
                            <div class="d-flex justify-content-center">
                                <button style="margin-bottom: 70px;" type="submit" class="btn btn-success"
                                    wire:click="showPasswordChangeModal">Reset Password</button>
                            </div>

                            <!-- <button type="button" class="btn btn-secondary" wire:click="closeSuccessModal">Cancel</button> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show blurred-backdrop"></div>
        @endif



        @if ($passwordChangedModal)
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" >
                            <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title">
                                <b>Success Message</b>
                            </h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"
                                wire:click="closePasswordChangedModal">
                            </button>
                        </div>
                        <div class="modal-bodyd-flex align-items-center justify-content-center" style="background-color: #f0f0f0; padding: 20px;">
                            <p>Password Changes Successfully...</p>
                            <button type="button" class="cancel-btn"
                                wire:click="closePasswordChangedModal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Button trigger modal -->
        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginLoader">
        Launch static backdrop modal
        </button> -->
        @if ($showLoader)
            <!-- Modal -->
            <div class="modal fade backdropModal" id="loginLoader" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="loginLoaderLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="background-color : transparent; border : none">
                        <!-- <div class="modal-header">
                <h1 class="modal-title fs-5" id="loginLoaderLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> -->
                        <div class="modal-body">
                            <div class="logo text-center mb-1" style="padding-top: 20px;">
                                <img src="https://xsilica.com/images/xsilica_broucher_final_modified_05082016-2.png"
                                    alt="Company Logo" width="200">
                            </div>
                            <div class="d-flex justify-content-center m-4">
                                <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;"
                                    role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div> -->
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
