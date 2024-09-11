<div class="container-fluid py-1 loginBGGradiant overflow-hidden">
    <div class="pt-2 m-0 row" style="overflow:hidden;">
        <div class="col-md-12 text-end">
            <button class="btn btn-primary" wire:click="jobs" style="background-color: rgb(2, 17, 79); color:white; border-radius:5px; border:none;">
                Recruitment
            </button>
        </div>
    </div>

    <div class="row m-0 d-flex align-items-center">
        <!-- Left Side (Login Form) -->
        <div class="col-md-6">
            @if ($showAlert)
                <div class="d-flex justify-content-center w-100" wire:poll.5s='hideAlert'>
                    <div class="alert alert-success" style="font-size: 12px;">
                        <p class="mb-0 mr-2">{{ $alertMessage }}</p>
                        <span style="margin-left: 20px; cursor:pointer;" wire:click='hideAlert'>x</span>
                    </div>
                </div>
            @endif

            @if (session('sessionExpired'))
                <div class="alert alert-danger">
                    {{ session('sessionExpired') }}
                </div>
            @endif

            <form wire:submit.prevent="empLogin" class="login-form-with-shadow" style="margin-top: 0px; background-color: #f2f2f6; backdrop-filter: blur(36px);">
                <div class="text-center mb-1" style="padding-top: 20px;">
                    <img src="{{ asset('images/hr_new_blue.png') }}" alt="Company Logo" style="width: 14em !important; height: auto !important; margin-bottom: 10px;">
                </div>

                <hr class="bg-white" />
                <header class="mb-12 text-center">
                    <div class="text-12gpx font-bold font-title-poppins-bold opacity-90 text-text-default justify-items-center">
                        Hello there! <span class="font-emoji text-12gpx">👋</span>
                    </div>
                </header><br>

                @if ($error)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong style="font-size: 12px;">{{ $error }}</strong>
                    </div>
                @endif

                <div class="form-group">
                    <label for="emp_id" style="font-size: 14px;">ID / Mail</label>
                    <input type="text" class="form-control" id="emp_id" placeholder="Enter ID / Mail" wire:model.lazy="form.emp_id" wire:input="login" wire:keydown.debounce.500ms="validateField('form.emp_id')" oninput="this.value = this.value.toUpperCase()" />
                    @error('form.emp_id')
                        <p class="pt-2 px-1 text-danger">{{ str_replace('form.emp id', 'Employee ID', $message) }}</p>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="password" style="font-size: 14px;">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter Password" wire:model.lazy="form.password" wire:input="login" wire:keydown.debounce.500ms="validateField('form.password')" />
                    @error('form.password')
                        <p class="pt-2 px-1 text-danger">{{ str_replace('form.password', 'Password', $message) }}</p>
                    @enderror
                </div>

                <div class="text-end" wire:click="show">
                    <span><a href="#" wire:click="show" style="color: rgb(2, 17, 79); font-size:12px;">Forgot Password?</a></span>
                </div>

                <div class="form-group text-center mt-2">
                    <input data-bs-toggle="modal" data-bs-target="#loginLoader" style="background-color:rgb(2,17,79); font-size:small; width:fit-content; margin: 0 auto;" type="submit" class="btn btn-primary btn-block" value="Login" />
                </div>
            </form>
        </div>

        <!-- Right Side (Carousel) -->
        <div class="col-md-6 p-0">
            <!-- Carousel -->
            <div id="demo" class="carousel slide" data-bs-ride="carousel" style="background-color: f0f0f0; aspect-ratio: 16/6; border-radius:10px;">
                <!-- Indicators -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                </div>

                <!-- Slideshow -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/communication.svg') }}" style="width: 85%;" alt="Communication" class="d-block">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/task.svg') }}" style="width: 85%;" alt="Task" class="d-block">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/working.svg') }}" style="width: 85%;" alt="Working" class="d-block">
                    </div>
                </div>

                <!-- Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center pb-2">
            <small>
                © Xsilica Software Solutions Pvt.Ltd |
                <a href="/Privacy&Policy" target="_blank" style="color: rgb(2, 17, 79);">Privacy Policy</a> |
                <a href="/Terms&Services" target="_blank" style="color: rgb(2, 17, 79);">Terms of Service</a>
            </small>
        </div>

        <!-- Modal Dialog -->
        @if ($showDialog)
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: rgb(2, 17, 79);">
                            <h5 class="modal-title" style="padding: 5px; color: white; font-size: 15px;">
                                <b>{{ $verified ? 'Reset Password' : 'Forgot Password' }}</b>
                            </h5>
                            <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="remove" style="background-color: white; height:10px; width:10px;"></button>
                        </div>
                        <div class="modal-body" style="background-color: #f0f0f0; padding: 20px;">
                            @if ($verified)
                                <!-- Reset Password Form -->
                                <form wire:submit.prevent="createNewPassword">
                                    @if ($pass_change_error)
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong style="font-size: 10px;">{{ $pass_change_error }}</strong>
                                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="newPassword">New Password</label>
                                        <input type="password" id="newPassword" class="form-control" placeholder="Enter your new password" wire:model.lazy="newPassword" wire:keydown.debounce.500ms="validateField('newPassword')">
                                        @error('newPassword')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="newPassword_confirmation">Confirm New Password</label>
                                        <input type="password" id="newPassword_confirmation" class="form-control" placeholder="Confirm your new password" wire:model.lazy="newPassword_confirmation" wire:keydown.debounce.500ms="validateField('newPassword_confirmation')">
                                        @error('newPassword_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-success">Reset Password</button>
                                    </div>
                                    @if (session()->has('passwordMessage'))
                                        <div class="alert alert-success mt-3">
                                            {{ session('passwordMessage') }}
                                        </div>
                                    @endif
                                </form>
                            @else
                                <!-- Forgot Password Form -->
                                <form wire:submit.prevent="verifyEmail">
                                    <div class="form-group">
                                        <label for="email" style="font-size: 14px;">Email</label>
                                        <input type="text" class="form-control" id="email" placeholder="Enter Email" wire:model.lazy="form.email" wire:keydown.debounce.500ms="validateField('form.email')" />
                                        @error('form.email')
                                            <p class="pt-2 px-1 text-danger">{{ str_replace('form.email', 'Email', $message) }}</p>
                                        @enderror
                                    </div>
                                    <div class="text-end">
                                        <span><a href="#" wire:click="show" style="color: rgb(2, 17, 79); font-size:12px;">Forgot Password?</a></span>
                                    </div>
                                    <div class="form-group text-center mt-2">
                                        <input data-bs-toggle="modal" data-bs-target="#loginLoader" style="background-color:rgb(2,17,79); font-size:small; width:fit-content; margin: 0 auto;" type="submit" class="btn btn-primary btn-block" value="Login" />
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
