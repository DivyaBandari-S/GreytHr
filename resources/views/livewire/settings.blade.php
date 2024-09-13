<div>
    @if (session()->has('emp_error'))
        <div class="alert alert-danger">
            {{ session('emp_error') }}
        </div>
    @endif
    <div class="row m-0">
        <div class="d-flex align-items-center justify-content-end gap-3">
            <div class=" p-0">
                <div wire:click="loginfo" class="col text-primary setting-login-history-text">
                    View Login History
                </div>

            </div>

            <div class="ps-0 setting-password-container">
                <button wire:click="show" class="submit-btn setting-password-btn"><i class="fas fa-cog setting-password-icon"></i>
                    &nbsp;Change Password</button>

                {{-- <div>
                    @if ($passwordChanged)
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 15%; left: 50%; transform: translate(-50%, -50%); z-index: 999; background-color: #4CAF50; color: #ffffff; text-align: center;">
                            Your password has been changed successfully...
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                </div> --}}

                <div class="setting-flash-message-container">
                    @if (session()->has('password'))
                        <div class="alert alert-success alert-dismissible fade show setting-flash-msg-text" role="alert">
                            <strong>{{ session('password') }}</strong>
                            <button type="button" class="btn-close btn-xs" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if ($showAlertDialog)

        <div class="modal d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between setting-history-modal-header">
                        <h6 class="modal-title" id="exampleModalLongTitle">Login
                            History</h6>
                        <button type="button" class="close setting-history-modal-close" data-dismiss="modal" aria-label="Close" wire:click="close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col setting-history-modal-text"><b>Last Login</b></div>
                            <div class="col setting-history-modal-text"><b>Last Login Failure</b></div>
                            <div class="col setting-history-modal-text"><b>Last Password Changed</b></div>
                        </div>
                        <div class="row">
                            <div class="col setting-history-modal-text">{{ $lastLogin }}</div>
                            <div class="col setting-history-modal-text">{{ $lastLoginFailure }}</div>
                            <div class="col setting-history-modal-text">{{ $lastPasswordChanged }}</div>
                        </div>
                        <table class="table-s setting-history-modal-table" border="1">
                            <tr class="tr-s">
                                <th class="th-s setting-history-modal-table-label">
                                    Login Location</th>
                                <th class="th-s setting-history-modal-table-label">
                                    Device</th>
                                <th class="th-s setting-history-modal-table-label">
                                    IP Address</th>


                            </tr>

                            @foreach ($loginHistory as $history)
                                <tr class="tr-s">
                                    <td class="th-d setting-history-modal-table-value">
                                        {{ $history->location }}</td>
                                    <td class="th-d setting-history-modal-table-value">
                                        {{ $history->device_type }}<br>{{ $history->user_agent }}</td>
                                    <td class="th-d setting-history-modal-table-value">
                                        {{ $history->ip_address }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
    @endif
    @if ($showDialog)
        <div class="modal d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between setting-password-modal-header">
                        <h6 class="modal-title" id="exampleModalLongTitle">Change Password</h6>
                        <button type="button" class="close setting-password-modal-close" data-dismiss="modal" aria-label="Close"
                            wire:click="remove">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <form wire:submit.prevent="changePassword">
                        @if ($error)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong class="setting-password-flash-msg">{{ $error }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="modal-body setting-password-modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card setting-password-card">
                                        <div class="form-group">
                                            <label class="setting-password-modal-label"
                                                for="oldPassword">Current Password</label>
                                            <br><input class="form-control setting-password-modal-input" type="password"
                                                id="oldPassword" name="oldPassword"
                                                placeholder="Enter your current password" wire:model.lazy="oldPassword">
                                            @error('oldPassword')
                                                <p class="pt-2 px-1 text-danger setting-password-error-msg">
                                                    {{ str_replace('oldPassword', 'Password', $message) }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="setting-password-modal-label"
                                                for="newPassword">New Password</label>
                                            <br><input class="form-control setting-password-modal-input" type="password"
                                                id="newPassword" name="newPassword"
                                                placeholder="Enter your new password" wire:model.lazy="newPassword">
                                            @error('newPassword')
                                                <p class="pt-2 px-1 text-danger setting-password-error-msg">
                                                    {{ str_replace('newPassword', 'Password', $message) }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="setting-password-modal-label"
                                                for="confirmNewPassword">Confirm New Password</label>
                                            <br><input class="form-control setting-password-modal-input" type="password"
                                                id="confirmNewPassword" name="confirmNewPassword"
                                                placeholder="Enter your confirm new password"
                                                wire:model.lazy="confirmNewPassword">
                                            @error('confirmNewPassword')
                                                <p class="pt-2 px-1 text-danger setting-password-error-msg">
                                                    {{ str_replace('newPassword', 'Password', $message) }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="setting-password-submit-container">
                                <button class="submit-btn">Save Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
    @endif

    @foreach ($employees as $employee)
        <div class="row m-0">
            <div class="col-md-1"></div>
            <div class="card col-md-9 p-2 mt-3">
                <div class="row m-0 p-0 d-flex">
                    <div class="col-lg-2 col-12 text-center">
                        @if (!empty($employee->image) && $employee->image !== 'null')
                            <img class="settings-profile-image"
                                src="{{ 'data:image/jpeg;base64,' . base64_encode($employee->image) }}">
                        @else
                            @if ($employee && $employee->gender == 'Male')
                                <img class="settings-profile-image" src="{{ asset('images/male-default.png') }}"
                                    alt="Default Male Image">
                            @elseif($employee && $employee->gender == 'Female')
                                <img class="settings-profile-image" src="{{ asset('images/female-default.jpg') }}"
                                    alt="Default Female Image">
                            @else
                                <img class="settings-profile-image" src="{{ asset('images/user.jpg') }}"
                                    alt="Default Image">
                            @endif
                        @endif

                    </div>
                    <div class="col-lg-3 col-6 text-start mt-2 p-0">
                        <!-- Name -->
                        <div class="setting-empname-text">
                            {{ ucwords(strtolower($employee->first_name)) }}
                            {{ ucwords(strtolower($employee->last_name)) }}
                        </div>

                        <!-- Emp ID -->
                        <div class="setting-empid-container">
                            <div class="d-flex align-items-start">
                                <!-- Fixed width for the label -->
                                <div class="setting-empid-label">
                                    Emp ID
                                </div>
                                <!-- Increased width for the value, allowing wrapping if needed -->
                                <div class="setting-empid-value">
                                    @if ($employee->emp_id)
                                        : {{ $employee->emp_id }}
                                    @else
                                        : -
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 text-start mt-2 p-0">
                        <!-- Official Birthday -->
                        <div class="setting-bday-container">
                            <div class="d-flex align-items-start">
                                <div class="setting-bday-label">
                                    Official Birthday
                                </div>
                                <div class="settings-birthday-value"
                                    title="{{ $employee->empPersonalInfo && $employee->empPersonalInfo->date_of_birth
                                        ? date('d M, Y', strtotime($employee->empPersonalInfo->date_of_birth))
                                        : '-' }}">
                                    :
                                    {{ $employee->empPersonalInfo && $employee->empPersonalInfo->date_of_birth
                                        ? date('d M, Y', strtotime($employee->empPersonalInfo->date_of_birth))
                                        : '-' }}
                                </div>
                            </div>
                        </div>

                        <!-- Department -->
                        <div class="setting-bday-container">
                            <div class="d-flex align-items-start">
                                <div class="setting-bday-label">
                                    Department
                                </div>
                                <div class="setting-department-value"
                                    title="{{ ucwords(strtolower($employee->empDepartment->department)) ?? '-' }}">
                                    : {{ ucwords(strtolower($employee->empDepartment->department)) ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-6 text-start mt-2 p-0">
                        <!-- Location -->
                        <div class="setting-bday-container">
                            <div class="d-flex align-items-start">
                                <!-- Decreased width for the label -->
                                <div class="setting-location-label">
                                    Location
                                </div>
                                <!-- Increased width for the value -->
                                <div class="setting-location-value"
                                    title="{{ !empty($employee->job_location) ? ucwords(strtolower($employee->job_location)) : '-' }}">
                                    :
                                    {{ !empty($employee->job_location) ? ucwords(strtolower($employee->job_location)) : '-' }}
                                </div>
                            </div>
                        </div>

                        <!-- Designation -->
                        <div class="setting-bday-container">
                            <div class="d-flex align-items-start">
                                <!-- Decreased width for the label -->
                                <div class="setting-designation-label">
                                    Designation
                                </div>
                                <!-- Increased width for the value -->
                                <div class="setting-designation-value"
                                    title="@if (!empty($employee->job_role)) {{ ucwords(strtolower($employee->job_role)) }} @else - @endif">
                                    @if (!empty($employee->job_role))
                                        : {{ ucwords(strtolower($employee->job_role)) }}
                                    @else
                                        : -
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="row m-0">
            <div class="col-md-1"></div>
            <div class="card col-md-9 p-0 setting-myprofile-container">
                <div class="card-header setting-myprofile-text">
                    My Profile
                </div>
                <div class="container mt-3">
                    <div class="row m-0 setting-timezone-container">
                        <div class="col-6 mb-3 setting-profile-text">
                            <strong>Profile</strong>
                        </div>
                        <div class="col-6 mb-3 setting-edit-delete-icon">
                            @if ($editingNickName)
                                <i wire:click="cancelProfile" class="fas fa-times me-3"></i>
                                <i wire:click="saveProfile" class="fa fa-save"></i>
                            @else
                                <i wire:click="editProfile" class="fas fa-edit"></i>
                            @endif
                        </div>
                    </div>
                    <div class="row m-0 setting-nickname-container">
                        <div class="col-md-4 mb-3 d-flex flex-column">
                            <span class="label-text setting-nickname-label">Nick Name</span>
                            @if ($editingNickName)
                                <input type="text"
                                    class="form-control settings-custom-placeholder setting-nickname-input" wire:model="nickName"
                                    placeholder="Enter Nick Name">
                            @else
                                <span class="value-text setting-nickname-value">
                                    {{ $employee->empPersonalInfo ? ucwords(strtolower($employee->empPersonalInfo->nick_name ?? '-')) : '-' }}
                                </span>
                            @endif
                        </div>
                        <div class="col-md-4 mb-3 d-flex flex-column">
                            <span class="label-text setting-nickname-label">Wish Me On</span>
                            @if ($editingNickName)
                                <input class="form-control setting-nickname-input" type="date"
                                    id="date_of_birth" placeholder="Select Wish Me On" name="date_of_birth"
                                    wire:model="wishMeOn" max="{{ date('Y-m-d') }}">
                            @else
                                <span class="value-text setting-nickname-value">
                                    {{ $employee->empPersonalInfo && $employee->empPersonalInfo->date_of_birth
                                        ? date('d M, Y', strtotime($employee->empPersonalInfo->date_of_birth))
                                        : '-' }}
                                </span>
                            @endif
                        </div>

                    </div>
                </div>

                <hr>
                <div class="container">
                    <div class="row m-0 setting-timezone-container">
                        <div class="col-6 mb-3 setting-timezone-text"><strong>Time Zone</strong></div>
                        <div class="col-6 mb-3 setting-edit-delete-icon">
                            @if ($editingTimeZone)
                                <!-- <i wire:click="editTimeZone" class="fas fa-edit"></i> -->
                                <i wire:click="cancelTimeZone" class="fas fa-times me-3"></i>
                                <i wire:click="saveTimeZone" class="fa fa-save"></i>
                            @else
                                <i wire:click="editTimeZone" class="fas fa-edit"></i>
                            @endif
                        </div>
                    </div>
                    <!-- <div class="row" style="margin-top: 20px;">
                    </div> -->
                    <div class="row m-0 setting-timezone-icons-container">
                        <div class="col-md-12 mb-3">
                            @if ($editingTimeZone)
                                <select id="time_zone" name="time_zone" wire:model="selectedTimeZone"
                                    class="form-control setting-timezone-select">
                                    @foreach ($timeZones as $tz)
                                        <option value="{{ $tz }}">{{ $tz }}</option>
                                    @endforeach
                                </select>
                            @else
                                <div class="setting-timezone-value">{{ $employee->time_zone ?? '-' }}</div>
                            @endif
                        </div>
                    </div>

                </div>
                <hr>
                <div class="container">
                    <div class="row m-0 setting-timezone-container">
                        <div class="col-6 mb-3 setting-timezone-text"><strong>Biography</strong></div>
                        <div class="col-6 mb-3 setting-edit-delete-icon">
                            @if ($editingBiography)
                                <!-- <i wire:click="editBiography" class="fas fa-edit"></i> -->
                                <i wire:click="cancelBiography" class="fas fa-times me-3"></i>
                                <i wire:click="saveBiography" class="fa fa-save"></i>
                            @else
                                <i wire:click="editBiography" class="fas fa-edit"></i>
                            @endif
                            </i>
                        </div>
                    </div>
                    <!-- <div class="row" style="color: grey;margin-top: 20px;">
                    </div> -->
                    @if ($editingBiography)
                        <div class="row m-0 setting-timezone-icons-container">
                            <div class="col-md-12 mb-3 setting-timezone-value">
                                <textarea wire:model="biography" id="biography" class="form-control setting-biography-textarea"
                                    placeholder="Enter Biography" rows="4"></textarea>
                            </div>
                        </div>
                    @else
                        <div class="row m-0 setting-timezone-icons-container">
                            <div class="col-md-12 mb-3 setting-timezone-value">
                                {{ $employee->empPersonalInfo && !empty($employee->empPersonalInfo->biography)
                                    ? ucwords(strtolower($employee->empPersonalInfo->biography))
                                    : '-' }}

                            </div>
                        </div>
                    @endif
                </div>
                <hr>
                <div class="container">
                    <div class="row m-0 setting-timezone-container">
                        <div class="col-6 setting-timezone-text"><strong>Social Media</strong></div>
                        <div class="col-6 setting-edit-delete-icon">
                            @if ($editingSocialMedia)
                                <!-- <i wire:click="editSocialMedia" class="fas fa-edit"></i> -->
                                <i wire:click="cancelSocialMedia" class="fas fa-times me-3"></i>
                                <i wire:click="saveSocialMedia" class="fa fa-save"></i>
                            @else
                                <i wire:click="editSocialMedia" class="fas fa-edit"></i>
                            @endif
                            </i>
                        </div>
                    </div>
                    <div class="container mt-3 mb-2">
                        <div class="row m-0 setting-socialmedia-container">
                            <div class="col-md-4 mb-3 d-flex flex-column">
                                <span class="label-text setting-facebook-text">Facebook</span>
                                @if ($editingSocialMedia)
                                    <input  type="text"
                                        class="form-control settings-custom-placeholder setting-nickname-input" wire:model.lazy="facebook"
                                        placeholder="Enter Facebook URL">
                                    @error('facebook')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                @else
                                    <span class="value-text setting-timezone-value">
                                        {{ !empty($employee->empPersonalInfo->facebook) ? $employee->empPersonalInfo->facebook : '-' }}
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3 d-flex flex-column">
                                <span class="label-text setting-facebook-text">Twitter</span>
                                @if ($editingSocialMedia)
                                    <input  type="text"
                                        class="form-control settings-custom-placeholder setting-nickname-input" wire:model.lazy="twitter"
                                        placeholder="Enter Twitter URL">
                                    @error('twitter')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                @else
                                    <span class="value-text setting-timezone-value">
                                        {{ !empty($employee->empPersonalInfo->twitter) ? $employee->empPersonalInfo->twitter : '-' }}
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3 d-flex flex-column">
                                <span class="label-text setting-facebook-text">LinkedIn</span>
                                @if ($editingSocialMedia)
                                    <input  type="text"
                                        class="form-control settings-custom-placeholder setting-nickname-input" wire:model.lazy="linkedIn"
                                        placeholder="Enter LinkedIn URL">
                                    @error('linkedIn')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                @else
                                    <span class="value-text setting-timezone-value">
                                        {{ !empty($employee->empPersonalInfo->linked_in) ? $employee->empPersonalInfo->linked_in : '-' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    @endforeach
</div>
