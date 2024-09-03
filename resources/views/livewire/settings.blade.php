<div>
    <style>
        .custom-placeholder::placeholder {
            font-size: 12px;
            /* Adjust this value as needed */
        }
    </style>
    @if (session()->has('emp_error'))
        <div class="alert alert-danger">
            {{ session('emp_error') }}
        </div>
    @endif
    <div class="row m-0">
        <div class="d-flex align-items-center justify-content-end gap-3">
            <div class=" p-0">
                <div wire:click="loginfo" class="col text-primary"
                    style="font-size:12px;font-weight:500;cursor:pointer;text-align:end;">
                    View Login History
                </div>

            </div>

            <div class="ps-0" style="background-color: pink;">
                <button wire:click="show" class="btn btn-primary"
                    style="background-color:rgb(2, 17, 79);color:white;font-size:12px;"><i
                        style="color: white;height:10px;width:10px;font-size:12px;" class="fas fa-cog "></i>
                    &nbsp;Change Password</button>

                {{-- <div>
                    @if ($passwordChanged)
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 15%; left: 50%; transform: translate(-50%, -50%); z-index: 999; background-color: #4CAF50; color: #ffffff; text-align: center;">
                            Your password has been changed successfully...
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                </div> --}}

                <div style="position: fixed; top: 15%; left: 50%; transform: translate(-50%, -50%); z-index: 999;">
                    @if (session()->has('password'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                            style="font-size: 12px;">
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
        .
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between"
                        style="background-color: rgb(2, 17, 79);color: white; height: 40px; padding: 8px; position: relative;">
                        <h6 class="modal-title" id="exampleModalLongTitle">Login
                            History</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close"
                            style="background: none; border: none; color: white; font-size: 30px; cursor: pointer;">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col" style="font-size: 10px;"><b>Last Login</b></div>
                            <div class="col" style="font-size: 10px;"><b>Last Login Failure</b></div>
                            <div class="col" style="font-size: 10px;"><b>Last Password Changed</b></div>
                        </div>
                        <div class="row">
                            <div class="col" style="font-size: 10px;">{{ $lastLogin }}</div>
                            <div class="col" style="font-size: 10px;">{{ $lastLoginFailure }}</div>
                            <div class="col" style="font-size: 10px;">{{ $lastPasswordChanged }}</div>
                        </div>
                        <table class="table-s" border="1" style="margin-top: 10px;width:100%">
                            <tr class="tr-s">
                                <th class="th-s"
                                    style="font-size: 12px; color: grey;border: 1px solid black;padding: 8px;text-align: center;background-color:#f2f2f2">
                                    Login Location</th>
                                <th class="th-s"
                                    style="font-size: 12px; color: grey;border: 1px solid black;padding: 8px;text-align: center;background-color:#f2f2f2">
                                    Device</th>
                                <th class="th-s"
                                    style="font-size: 12px; color: grey;border: 1px solid black;padding: 8px;text-align: center;background-color:#f2f2f2">
                                    IP Address</th>


                            </tr>

                            @foreach ($loginHistory as $history)
                                <tr class="tr-s">
                                    <td class="th-d"
                                        style="font-size: 10px; color: black; border: 1px solid black; padding: 8px; text-align: center;">
                                        {{ $history->location }}</td>
                                    <td class="th-d"
                                        style="font-size: 10px; color: black; border: 1px solid black; padding: 8px; text-align: center;">
                                        {{ $history->device_type }}<br>{{ $history->user_agent }}</td>
                                    <td class="th-d"
                                        style="font-size: 10px; color: black; border: 1px solid black; padding: 8px; text-align: center;">
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
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between"
                        style="background-color: rgb(2, 17, 79);color: white; height: 40px; padding: 8px; position: relative;">
                        <h6 class="modal-title" id="exampleModalLongTitle">Change Password</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            wire:click="remove"
                            style="background: none; border: none; color: white; font-size: 30px; cursor: pointer;">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <form wire:submit.prevent="changePassword">
                        @if ($error)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong style="font-size: 12px;">{{ $error }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="modal-body" style="background-color: #f0f0f0;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card" style="padding: 20px; text-align: left;">
                                        <div class="form-group">
                                            <label style="font-size: 12px;color:#778899;font-weight:500;"
                                                for="oldPassword">Old Password</label>
                                            <br><input class="form-control" style="font-size: 12px;" type="password"
                                                id="oldPassword" name="oldPassword"
                                                placeholder="Enter your old password" wire:model.lazy="oldPassword">
                                            @error('oldPassword')
                                                <p class="pt-2 px-1 text-danger" style="font-size:10px">
                                                    {{ str_replace('oldPassword', 'Password', $message) }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size: 12px;color:#778899;font-weight:500;"
                                                for="newPassword">New Password</label>
                                            <br><input class="form-control" style="font-size: 12px;" type="password"
                                                id="newPassword" name="newPassword"
                                                placeholder="Enter your new password" wire:model.lazy="newPassword">
                                            @error('newPassword')
                                                <p class="pt-2 px-1 text-danger" style="font-size:10px">
                                                    {{ str_replace('newPassword', 'Password', $message) }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size: 12px;color:#778899;font-weight:500;"
                                                for="confirmNewPassword">Confirm New Password</label>
                                            <br><input class="form-control" style="font-size: 12px;" type="password"
                                                id="confirmNewPassword" name="confirmNewPassword"
                                                placeholder="Enter your new password again"
                                                wire:model.lazy="confirmNewPassword">
                                            @error('confirmNewPassword')
                                                <p class="pt-2 px-1 text-danger" style="font-size:10px">
                                                    {{ str_replace('newPassword', 'Password', $message) }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-top: 20px; text-align: center;">
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
                        <div
                            style="font-size: 13px; font-weight: 600; color: #000; white-space: nowrap; margin-bottom: 15px;">
                            {{ ucwords(strtolower($employee->first_name)) }}
                            {{ ucwords(strtolower($employee->last_name)) }}
                        </div>

                        <!-- Emp ID -->
                        <div style="font-size: 12px; color: #000; margin-bottom: 15px;">
                            <div style="display: flex; align-items: flex-start;">
                                <!-- Fixed width for the label -->
                                <div
                                    style="width: 60px; font-size: 11px; color: #778899; flex-shrink: 0;white-space: nowrap;">
                                    Emp ID
                                </div>
                                <!-- Increased width for the value, allowing wrapping if needed -->
                                <div
                                    style="flex: 1; margin-left: 5px; font-size: 12px; font-weight: 500; white-space: normal;">
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
                        <div style="font-size: 12px; color: #000; margin-bottom: 10px;">
                            <div style="display: flex; align-items: flex-start;">
                                <div style="width: 95px; color: #778899; flex-shrink: 0;white-space: nowrap;">
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
                        <div style="font-size: 12px; color: #000; margin-bottom: 15px;">
                            <div style="display: flex; align-items: flex-start;">
                                <div style="width: 95px; color: #778899; flex-shrink: 0;white-space: nowrap;">
                                    Department
                                </div>
                                <div style="flex: 1; margin-left: 5px; font-weight: 500; color: #000; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;"
                                    title="{{ ucwords(strtolower($employee->empDepartment->department)) ?? '-' }}">
                                    : {{ ucwords(strtolower($employee->empDepartment->department)) ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-6 text-start mt-2 p-0">
                        <!-- Location -->
                        <div style="font-size: 12px; color: #000; margin-bottom: 15px;">
                            <div style="display: flex; align-items: flex-start;">
                                <!-- Decreased width for the label -->
                                <div style="width: 80px; color: #778899; flex-shrink: 0;white-space: nowrap;">
                                    Location
                                </div>
                                <!-- Increased width for the value -->
                                <div style="flex: 1; margin-left: 10px; font-weight: 500; color: #000; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;"
                                    title="{{ !empty($employee->job_location) ? ucwords(strtolower($employee->job_location)) : '-' }}">
                                    :
                                    {{ !empty($employee->job_location) ? ucwords(strtolower($employee->job_location)) : '-' }}
                                </div>
                            </div>
                        </div>

                        <!-- Designation -->
                        <div style="font-size: 12px; color: #000; margin-bottom: 15px;">
                            <div style="display: flex; align-items: flex-start;">
                                <!-- Decreased width for the label -->
                                <div style="width: 80px; color: #778899; flex-shrink: 0;white-space: nowrap;">
                                    Designation
                                </div>
                                <!-- Increased width for the value -->
                                <div style="flex: 1; margin-left: 10px; font-weight: 500; color: #000; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;"
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
            <div class="card col-md-9 p-0" style="margin-top: 20px;height:auto;margin-bottom:10px">
                <div class="card-header" style="background-color: rgb(2, 17, 79);color:white;font-size: 15px">
                    My Profile
                </div>
                <div class="container mt-3">
                    <div class="row m-0" style="font-size: 12px;">
                        <div class="col-6 mb-3" style="color:#778899;font-size:12px;">
                            <strong>Profile</strong>
                        </div>
                        <div class="col-6 mb-3" style="text-align: end; cursor: pointer;">
                            @if ($editingNickName)
                                <i wire:click="cancelProfile" class="fas fa-times me-3"></i>
                                <i wire:click="saveProfile" class="fa fa-save"></i>
                            @else
                                <i wire:click="editProfile" class="fas fa-edit"></i>
                            @endif
                        </div>
                    </div>
                    <div class="row m-0" style="margin-top: 20px;">
                        <div class="col-md-4 mb-3 d-flex flex-column">
                            <span class="label-text" style="color: #778899;font-size: 12px;">Nick Name</span>
                            @if ($editingNickName)
                                <input style="font-size:12px; margin-top: 5px;" type="text"
                                    class="form-control custom-placeholder" wire:model="nickName"
                                    placeholder="Enter Nick Name">
                            @else
                                <span class="value-text" style="color: black; font-size: 12px;">
                                    {{ $employee->empPersonalInfo ? ucwords(strtolower($employee->empPersonalInfo->nick_name ?? '-')) : '-' }}
                                </span>
                            @endif
                        </div>
                        <div class="col-md-4 mb-3 d-flex flex-column">
                            <span class="label-text" style="color: #778899;font-size: 12px;">Wish Me On</span>
                            @if ($editingNickName)
                                <input style="font-size: 12px; margin-top: 5px;" class="form-control" type="date"
                                    id="date_of_birth" placeholder="Select Wish Me On" name="date_of_birth"
                                    wire:model="wishMeOn" max="{{ date('Y-m-d') }}">
                            @else
                                <span class="value-text" style="color: black; font-size: 12px;">
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
                    <div class="row m-0" style="font-size: 12px;">
                        <div class="col-6 mb-3" style="color:#778899;"><strong>Time Zone</strong></div>
                        <div class="col-6 mb-3" style="text-align: end; cursor: pointer;">
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
                    <div class="row m-0" style="margin-top: 10px;">
                        <div class="col-md-12 mb-3">
                            @if ($editingTimeZone)
                                <select id="time_zone" name="time_zone" wire:model="selectedTimeZone"
                                    class="form-control" style="width: 150px; font-size: 12px;">
                                    @foreach ($timeZones as $tz)
                                        <option value="{{ $tz }}">{{ $tz }}</option>
                                    @endforeach
                                </select>
                            @else
                                <div style="color: black; font-size: 12px;">{{ $employee->time_zone ?? '-' }}</div>
                            @endif
                        </div>
                    </div>

                </div>
                <hr>
                <div class="container">
                    <div class="row m-0" style="font-size: 12px;">
                        <div class="col-6 mb-3" style="color:#778899;"><strong>Biography</strong></div>
                        <div class="col-6 mb-3" style="text-align: end;  cursor: pointer;">
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
                        <div class="row m-0" style="margin-top: 10px;">
                            <div class="col-md-12 mb-3" style="color: black; font-size: 12px;">
                                <textarea style="width:100%;font-size:12px" wire:model="biography" id="biography" class="form-control"
                                    placeholder="Enter Biography" rows="4"></textarea>
                            </div>
                        </div>
                    @else
                        <div class="row m-0" style="margin-top: 10px;">
                            <div class="col-md-12 mb-3" style="color: black; font-size: 12px;">
                                {{ $employee->empPersonalInfo && !empty($employee->empPersonalInfo->biography)
                                    ? ucwords(strtolower($employee->empPersonalInfo->biography))
                                    : '-' }}

                            </div>
                        </div>
                    @endif
                </div>
                <hr>
                <div class="container">
                    <div class="row m-0" style="font-size: 12px;">
                        <div class="col-6 mb-3" style="color:#778899;"><strong>Social Media</strong></div>
                        <div class="col-6 mb-3" style="text-align: end; cursor: pointer;">
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
                    <div class="container mt-3">
                        <div class="row m-0" style="margin-top: 20px;">
                            <div class="col-md-4 mb-3 d-flex flex-column">
                                <span class="label-text" style="color: #778899; font-size: 12px;">Facebook</span>
                                @if ($editingSocialMedia)
                                    <input style="font-size: 12px; margin-top: 5px;" type="text"
                                        class="form-control custom-placeholder" wire:model.lazy="facebook"
                                        placeholder="Enter Facebook URL">
                                    @error('facebook')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                @else
                                    <span class="value-text" style="color: black; font-size: 12px;">
                                        {{ !empty($employee->empPersonalInfo->facebook) ? $employee->empPersonalInfo->facebook : '-' }}
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3 d-flex flex-column">
                                <span class="label-text" style="color: #778899; font-size: 12px;">Twitter</span>
                                @if ($editingSocialMedia)
                                    <input style="font-size: 12px; margin-top: 5px;" type="text"
                                        class="form-control custom-placeholder" wire:model.lazy="twitter"
                                        placeholder="Enter Twitter URL">
                                    @error('twitter')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                @else
                                    <span class="value-text" style="color: black; font-size: 12px;">
                                        {{ !empty($employee->empPersonalInfo->twitter) ? $employee->empPersonalInfo->twitter : '-' }}
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3 d-flex flex-column">
                                <span class="label-text" style="color: #778899; font-size: 12px;">LinkedIn</span>
                                @if ($editingSocialMedia)
                                    <input style="font-size: 12px; margin-top: 5px;" type="text"
                                        class="form-control custom-placeholder" wire:model.lazy="linkedIn"
                                        placeholder="Enter LinkedIn URL">
                                    @error('linkedIn')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                @else
                                    <span class="value-text" style="color: black; font-size: 12px;">
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
