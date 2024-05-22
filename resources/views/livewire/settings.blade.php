<div>

    <div class="row m-0">
        <div class="d-flex align-items-center justify-content-end gap-3" >
            <div class=" p-0">
                <div wire:click="open" class="col text-primary" style="font-size:12px;font-weight:500;cursor:pointer;text-align:end;">
                View Login History
                </div>
                @if ($showAlertDialog)
                <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: rgb(2, 17, 79);">
                                <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b>Login
                                        History</b></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close">
                                    <span aria-hidden="true" style="color: white;">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col" style="font-size: 10px;"><b>Last Login</b></div>
                                    <div class="col" style="font-size: 10px;"><b>Last Login Failure</b></div>
                                    <div class="col" style="font-size: 10px;"><b>Last Password Changed</b></div>
                                </div>
                                <div class="row">
                                    <div class="col" style="font-size: 10px;">04 Oct 2023 14:32:00</div>
                                    <div class="col" style="font-size: 10px;">05 Apr 2023 19:12:48</div>
                                    <div class="col" style="font-size: 10px;">28 Jan 2023 19:00:01</div>
                                </div>
                                <table class="table-s" border="1" style="margin-top: 10px;width:100%">
                                    <tr  class="tr-s">
                                        <th class="th-s" style="font-size: 12px; color: grey;border: 1px solid black;padding: 8px;text-align: center;background-color:#f2f2f2">Date</th>
                                        <th class="th-s" style="font-size: 12px; color: grey;border: 1px solid black;padding: 8px;text-align: center;background-color:#f2f2f2">IP Address</th>
                                    </tr>
                                    <tr class="tr-s">
                                        <td class="th-d" style="font-size: 10px; color: black;border: 1px solid black;padding: 8px;text-align: center;">04 Oct, 2023 13:48:06</td>
                                        <td class="th-d" style="font-size: 10px; color: black;border: 1px solid black;padding: 8px;text-align: center;">183.82.97.220</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-backdrop fade show blurred-backdrop"></div>
                @endif
            </div>

            <div class="ps-0" style="background-color: pink;">
                    <button wire:click="show" class="btn btn-primary" style="background-color:rgb(2, 17, 79);color:white;font-size:12px;"><i style="color: white;height:10px;width:10px;font-size:12px;" class="fas fa-cog "></i>   &nbsp;Change Password</button>
                @if ($showDialog)
                <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: rgb(2, 17, 79);">
                                <h5 style="padding: 5px; color: white; font-size: 14px;" class="modal-title"><b>Change Password</b></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="remove">
                                    <span aria-hidden="true" style="color: white;">×</span>
                                </button>
                            </div>
                            <form wire:submit="changePassword">
                                <div class="modal-body" style="background-color: #f0f0f0;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card" style="padding: 20px; text-align: left;">
                                                <div class="form-group">
                                                    <label style="font-size: 12px;color:#778899;font-weight:500;" for="oldPassword">Old Password</label>
                                                    <br><input class="form-control" style="font-size: 12px;" type="password" id="oldPassword" name="oldPassword" placeholder="Enter your old password" wire:model="oldPassword">
                                                    @error("oldPassword")
                                                    <p class="pt-2 px-1 text-danger" style="font-size:10px">{{ str_replace('oldPassword', 'Password', $message) }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label style="font-size: 12px;color:#778899;font-weight:500;" for="newPassword">New Password</label>
                                                    <br><input class="form-control" style="font-size: 12px;" type="password" id="newPassword" name="newPassword" placeholder="Enter your new password" wire:model="newPassword">
                                                    @error("newPassword")
                                                    <p class="pt-2 px-1 text-danger" style="font-size:10px">{{ str_replace('newPassword', 'Password', $message) }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label style="font-size: 12px;color:#778899;font-weight:500;" for="confirmNewPassword">Confirm New Password</label>
                                                    <br><input class="form-control" style="font-size: 12px;" type="password" id="confirmNewPassword" name="confirmNewPassword" placeholder="Enter your new password again" wire:model="confirmNewPassword">
                                                    @error("confirmNewPassword")
                                                    <p class="pt-2 px-1 text-danger" style="font-size:10px">{{ str_replace('newPassword', 'Password', $message) }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-top: 20px; text-align: center;">
                                        <button class="submit-btn" >Save Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-backdrop fade show blurred-backdrop"></div>
                @endif
                <div>
                    @if ($passwordChanged)
                    <div style="text-align: center; position: fixed; top: 15%; left: 50%; transform: translate(-50%, -50%); z-index: 999;background-color: #4CAF50; color: #ffffff;" wire:poll.5s>
                        Your password has been changed successfully...
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


        @foreach($employees as $employee)
        <div class="row m-0">
            <div class="col-md-2"></div>
            <div class="card col-md-8" style="margin-top:20px;padding:10px">
                <div class="row m-0">
                    <div class="col-md-2">
                    @if(!empty($employee->image))
                        <img style="border-radius: 50%; padding: 8px;" height="80" width="80" src="{{asset('storage/' . $employee->image) }}" alt="">
                    @else
                        <!-- Default user image -->
                        <img style="border-radius: 50%; padding: 8px;" height="80" width="80" src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars.png" alt="">
                    @endif

                    </div>
                    <div class="col-md-5">
                        <div class="mb-2" style="font-size:13px;"><strong>{{ ucwords(strtolower($employee->first_name)) }} {{ ucwords(strtolower($employee->last_name)) }}</strong></div>
                        <div style="font-size: 12px; color: #000;">
                            <div style="display: inline-block;width:65px;color:#778899;">Emp ID</div> : <span style="font-weight:500; padding:0 5px;">{{$employee->emp_id}}</span>
                        </div>

                        <div style="font-size:12px;color: #000;">
                            <div style="display: inline-block;width:65px;color:#778899;">Location</div> : <span style="font-weight:500; padding:0 5px;">{{ ucwords(strtolower($employee->job_location)) }}</span>
                        </div>
                        <div style="font-size:12px;color: #000;">
                            <div style="display: inline-block;width:65px;color:#778899;">Role</div> : <span style="font-weight:500; padding:0 5px;">{{ ucwords(strtolower($employee->job_title)) }}</span>
                        </div>
                    </div>
                    <div class="col-md-5" style="margin-top: 15px;">
                        <div style="font-size:12px;color: #000;">
                            <div style="display: inline-block;width:100px;color:#778899;">Official Birthday</div> :  <span style="font-weight:500; padding:0 5px;">{{ \Carbon\Carbon::parse($employee->date_of_birth)->format('d-M-Y') }}</span>

                        </div>
                        <div style="font-size:12px;color: #000;">
                            <div style="display: inline-block;width:100px;color:#778899;">Department</div> : <span style="font-weight:500; padding:0 5px;">{{ ucwords(strtolower($employee->department)) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row m-0">
            <div class="col-md-2"></div>
            <div class="card col-md-8 p-0" style="margin-top: 20px;height:auto;margin-bottom:10px">
                <div class="card-header" style="background-color: rgb(2, 17, 79);color:white;font-size: 15px">
                    My Profile
                </div>
                <div class="container mt-3">
                <div class="col-md-6 mb-3" style="color:#778899;font-size:12px;"><strong>Profile</strong></div>
                    <div class="row m-0" style="margin-top: 20px;">
                        <div class="col-md-4 mb-3" style="color: #778899;font-size: 12px;">
                            Nick Name
                        </div>
                        <div class="col-md-4 mb-3" style="color: #778899;font-size: 12px">
                            Wish Me On
                        </div>
                        <div class="col-md-4 mb-3" style="text-align: end; font-size:  12px">
                            @if($editingNickName)
                            <!-- <i wire:click="editProfile" class="fas fa-edit"></i> -->
                            <i wire:click="cancelProfile" class="fas fa-times me-3"></i>
                            <i wire:click="saveProfile" class="fa fa-save"></i>
                            @else
                            <i wire:click="editProfile" class="fas fa-edit"></i>
                            @endif
                        </div>
                    </div>
                    @if ($editingNickName)
                    <div class="row m-0" style="margin-top: 10px;">
                        <div class="col-md-4 mb-3">
                            <input style="font-size:12px" type="text" class="form-control" wire:model="nickName" placeholder="Enter Nick Name">
                        </div>
                        <div class="col-md-4 mb-3">
                            <input style="font-size: 12px;" class="form-control" type="date" id="date_of_birth" placeholder="Select Wish Me On" name="date_of_birth" wire:model="wishMeOn" max="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    @else
                    <div class="row m-0" style="margin-top: 10px;">
                        <div class="col-md-4 mb-3" style="color: black; font-size: 12px;">{{$employee->nick_name}}</div>
                        <div class="col-md-4 mb-3" style="color: black; font-size: 12px;">{{ \Carbon\Carbon::parse($employee->date_of_birth)->format('d-M-Y') }}</div>
                    </div>
                    @endif
                </div>
                <hr>
                <div class="container">
                    <div class="row m-0" style="font-size: 12px;">
                        <div class="col-md-6 mb-3" style="color:#778899;"><strong>Time Zone</strong></div>
                        <div class="col-md-6 mb-3" style="text-align: end">
                            @if($editingTimeZone)
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
                            <select id="time_zone" name="time_zone" wire:model="selectedTimeZone" class="form-control" style="width: 150px; font-size: 12px;">
                                @foreach ($timeZones as $tz)
                                <option value="{{ $tz }}">{{ $tz }}</option>
                                @endforeach
                            </select>
                            @else
                            <div style="color: black; font-size: 12px;">{{ $employee->time_zone }}</div>
                            @endif
                        </div>
                    </div>

                </div>
                <hr>
                <div class="container">
                    <div class="row m-0" style="font-size: 12px;">
                        <div class="col-md-6 mb-3" style="color:#778899;"><strong>Biography</strong></div>
                        <div class="col-md-6 mb-3" style="text-align: end"> @if($editingBiography)
                            <!-- <i wire:click="editBiography" class="fas fa-edit"></i> -->
                            <i wire:click="cancelBiography" class="fas fa-times me-3"></i>
                            <i wire:click="saveBiography" class="fa fa-save"></i>
                            @else
                            <i wire:click="editBiography" class="fas fa-edit"></i>
                            @endif</i>
                        </div>
                    </div>
                    <!-- <div class="row" style="color: grey;margin-top: 20px;">
                    </div> -->
                    @if ($editingBiography)
                    <div class="row m-0" style="margin-top: 10px;">
                        <div class="col-md-12 mb-3" style="color: black; font-size: 12px;">
                            <textarea style="width:100%;font-size:12px" wire:model="biography" id="biography" class="form-control" placeholder="Enter Biography" rows="4"></textarea>
                        </div>
                    </div>
                    @else
                    <div class="row m-0" style="margin-top: 10px;">
                        <div class="col-md-12 mb-3" style="color: black; font-size: 12px;">{{$employee->biography}}</div>
                    </div>
                    @endif
                </div>
                <hr>
                <div class="container">
                    <div class="row m-0" style="font-size: 12px;">
                        <div class="col-md-6 mb-3" style="color:#778899;"><strong>Social Media</strong></div>
                        <div class="col-md-6 mb-3"  style="text-align: end"> @if($editingSocialMedia)
                            <!-- <i wire:click="editSocialMedia" class="fas fa-edit"></i> -->
                            <i wire:click="cancelSocialMedia" class="fas fa-times me-3"></i>
                            <i wire:click="saveSocialMedia" class="fa fa-save"></i>
                            @else
                            <i wire:click="editSocialMedia" class="fas fa-edit"></i>
                            @endif</i>
                        </div>
                    </div>
                    <div class="row m-0" style="color: #778899;margin-top: 10px;">
                        <div class="col-md-4 mb-3" style="font-size: 12px;">Facebook</div>
                        <div class="col-md-4 mb-3" style="font-size: 12px;">Twitter</div>
                        <div class="col-md-4 mb-3" style="font-size: 12px;">LinkedIn</div>
                    </div>
                    @if ($editingSocialMedia)
                    <div class="row m-0" style="margin-top: 10px;">
                        <div class="col-md-4 mb-3" style="color: black; font-size: 12px;"> <input style="font-size:12px" type="text" class="form-control" wire:model="faceBook" placeholder="FaceBook">
                        </div>
                        <div class="col-md-4 mb-3" style="color: black; font-size: 12px;"> <input style="font-size:12px" type="text" class="form-control" wire:model="twitter" placeholder="Twitter">
                        </div>
                        <div class="col-md-4 mb-3" style="color: black; font-size: 12px;"> <input style="font-size:12px" type="text" class="form-control" wire:model="linkedIn" placeholder="LinkedIn">
                        </div>
                    </div>
                    @else
                    <div class="row m-0" style="margin-top: 10px;">
                        <div class="col-md-4 mb-3" style="color: black; font-size: 12px;">{{$employee->facebook}}</div>
                        <div class="col-md-4 mb-3" style="color: black; font-size: 12px;">{{$employee->twitter}}</div>
                        <div class="col-md-4 mb-3" style="color: black; font-size: 12px;">{{$employee->linked_in}}</div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>


        @endforeach
    </div>
