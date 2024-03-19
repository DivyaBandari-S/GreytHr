<div>

    <div class="row">
        <div wire:click="open" class="col" style="margin-left: 58%;color:rgb(2, 17, 79)">
            View Login History
        </div>
        @if ($showAlertDialog)
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
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
        <div class="col" style="margin: 0px;">
            <button wire:click="show" style="background-color:rgb(2, 17, 79);color:white;border-radius:5px; width:200px"><i style="color: white;" class="fas fa-cog"></i>Change Password</button>
        </div>
        @if ($showDialog)
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="width: 500px;margin-left:30px">
                    <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px;">
                        <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b>Change Password</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="remove">
                            <span aria-hidden="true" style="color: white;">×</span>
                        </button>
                    </div>
                    <form wire:submit="changePassword" class="login-form-with-shadow" style="margin-top: 0;">
                        <div class="modal-body" style="background-color: #f0f0f0; padding: 20px;margin-top:40px">
                            <div class="row" style="width:800px;margin-left:30px">
                                <div class="col-md-6">
                                    <div class="card" style="padding: 20px;">
                                        <div class="form-group" style="margin-top:-13px">
                                            <label style="font-size: 14px;" for="oldPassword">Old Password</label>
                                            <br><input style="font-size: 12px;" type="password" id="oldPassword" name="oldPassword" style="margin-left:60px" placeholder="Enter your old password" wire:model="oldPassword" wire:change="changePassword">
                                            @error("oldPassword")
                                            <p class="pt-2 px-1 text-danger" style="font-size:10px">{{ str_replace('oldPassword', 'Password', $message) }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group" style="margin-top:-13px">
                                            <label style="font-size: 14px;" for="newPassword">New Password</label>
                                            <br><input style="font-size: 12px;" type="password" id="newPassword" style="margin-left:30px" name="newPassword" placeholder="Enter your new password" wire:model="newPassword" wire:change="changePassword">
                                            @error("newPassword")
                                            <p class="pt-2 px-1 text-danger" style="font-size:10px">{{ str_replace('newPassword', 'Password', $message) }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group" style="margin-top:-13px">
                                            <label style="font-size: 14px;" for="confirmNewPassword">Confirm New Password</label>
                                            <br><input style="font-size: 12px;" type="password" id="confirmNewPassword" name="confirmNewPassword" style="margin-left:20px" placeholder="Enter your new password again" wire:model="confirmNewPassword" wire:change="changePassword">
                                            @error("confirmNewPassword")
                                            <p class="pt-2 px-1 text-danger" style="font-size:10px">{{ str_replace('newPassword', 'Password', $message) }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-top: 20px; text-align: center;">
                                <button style="background-color: green; color: white; border-radius: 5px; font-size: 15px;">Save Password</button>
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
        @foreach($employees as $employee)
        <div class="card" style="width: 800px;margin-top:20px;padding:10px">
            <div class="row">
                <div class="col-md-2">
                    <img style="border-radius: 50%;padding:8px" height="80" width="80" src="{{ asset($employee->image) }}">
                </div>
                <div class="col-md-5">
                    <div style="font-size:12px;"><strong>{{$employee->first_name}} {{$employee->last_name}}</strong></div>
                    <div style="font-size: 12px; color: grey;">
                        <div style="display: inline-block;width:65px">Emp ID</div><strong> : {{$employee->emp_id}}</strong>
                    </div>

                    <div style="font-size:12px;color: grey;">
                        <div style="display: inline-block;width:65px">Location</div> <strong>: {{$employee->job_location}}</strong>
                    </div>
                    <div style="font-size:12px;color: grey;">
                        <div style="display: inline-block;width:65px">Role</div><strong> : {{$employee->job_title}}</strong>
                    </div>
                </div>
                <div class="col-md-5" style="margin-top: 15px;">
                    <div style="font-size:12px;color: grey;">
                        <div style="display: inline-block;width:100px">Official Birthday</div><Strong>: {{ \Carbon\Carbon::parse($employee->date_of_birth)->format('d-M-Y') }}
                        </Strong>
                    </div>
                    <div style="font-size:12px;color: grey;">
                        <div style="display: inline-block;width:100px">Department</div><strong>: {{$employee->department}}</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" style="margin-top: 20px;height:auto;width:800px;margin-bottom:10px">
            <div class="card-header" style="background-color: rgb(2, 17, 79);color:white;font-size: 15px;width:787px">
                My Profile
            </div>
            <div class="container">
                <div class="row" style="margin-top: 20px;">
                    <div class="col" style="color: grey;font-size: 12px;">
                        Nick Name
                    </div>
                    <div class="col" style="color: grey;font-size: 12px;margin-left:80px">
                        Wish Me On
                    </div>
                    <div class="col" style="margin-left: 44%;font-size:12px">
                        @if($editingNickName)
                        <i wire:click="editProfile" class="fas fa-edit"></i>
                        <i wire:click="cancelProfile" class="fas fa-times"></i>
                        <i wire:click="saveProfile" class="fa fa-save"></i>
                        @else
                        <i wire:click="editProfile" class="fas fa-edit"></i>
                        @endif
                    </div>
                </div>
                @if ($editingNickName)
                <div class="row" style="margin-top: 10px;">
                    <div class="col">
                        <input style="width:150px;font-size:12px" type="text" class="form-control" wire:model="nickName" placeholder="Enter Nick Name">
                    </div>
                    <div class="col" style="margin-right: 50%;">
                        <input style="width: 150px; font-size: 12px;" type="date" id="date_of_birth" placeholder="Select Wish Me On" name="date_of_birth" wire:model="wishMeOn" max="{{ date('Y-m-d') }}">
                    </div>
                </div>
                @else
                <div class="row" style="margin-top: 10px;">
                    <div class="col" style="color: black; font-size: 12px;">{{$employee->nick_name}}</div>
                    <div class="col" style="color: black; font-size: 12px;margin-right:50%">{{ \Carbon\Carbon::parse($employee->date_of_birth)->format('d-M-Y') }}</div>
                </div>
                @endif
            </div>
            <hr>
            <div class="container">
                <div class="row" style="font-size: 12px;">
                    <div class="col"><strong>Time Zone</strong></div>
                    <div class="col" style="margin-left: 70%;">
                        @if($editingTimeZone)
                        <i wire:click="editTimeZone" class="fas fa-edit"></i>
                        <i wire:click="cancelTimeZone" class="fas fa-times"></i>
                        <i wire:click="saveTimeZone" class="fa fa-save"></i>
                        @else
                        <i wire:click="editTimeZone" class="fas fa-edit"></i>
                        @endif
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                </div>
                <div class="row" style="margin-top: 10px;">
                    <div class="col">
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
                <div class="row" style="font-size: 12px;">
                    <div class="col"><strong>Biography</strong></div>
                    <div class="col" style="margin-left: 70%;"> @if($editingBiography)
                        <i wire:click="editBiography" class="fas fa-edit"></i>
                        <i wire:click="cancelBiography" class="fas fa-times"></i>
                        <i wire:click="saveBiography" class="fa fa-save"></i>
                        @else
                        <i wire:click="editBiography" class="fas fa-edit"></i>
                        @endif</i>
                    </div>
                </div>
                <div class="row" style="color: grey;margin-top: 20px;">
                </div>
                @if ($editingBiography)
                <div class="row" style="margin-top: 10px;">
                    <div class="col" style="color: black; font-size: 12px;">
                        <textarea style="width:100%;font-size:12px" wire:model="biography" id="biography" class="form-control" placeholder="Enter Biography" rows="4"></textarea>
                    </div>
                </div>
                @else
                <div class="row" style="margin-top: 10px;">
                    <div class="col" style="color: black; font-size: 12px;">{{$employee->biography}}</div>
                </div>
                @endif
            </div>
            <hr>
            <div class="container">
                <div class="row" style="font-size: 12px;">
                    <div class="col"><strong>Social Media</strong></div>
                    <div class="col" style="margin-left: 70%;"> @if($editingSocialMedia)
                        <i wire:click="editSocialMedia" class="fas fa-edit"></i>
                        <i wire:click="cancelSocialMedia" class="fas fa-times"></i>
                        <i wire:click="saveSocialMedia" class="fa fa-save"></i>
                        @else
                        <i wire:click="editSocialMedia" class="fas fa-edit"></i>
                        @endif</i>
                    </div>
                </div>
                <div class="row" style="color: grey;margin-top: 10px;">
                    <div class="col" style="font-size: 12px;">Facebook</div>
                    <div class="col" style="font-size: 12px;">Twitter</div>
                    <div class="col" style="font-size: 12px;">LinkedIn</div>
                </div>
                @if ($editingSocialMedia)
                <div class="row" style="margin-top: 10px;margin-bottom:20px">
                    <div class="col" style="color: black; font-size: 12px;"> <input style="width:150px;font-size:12px" type="text" class="form-control" wire:model="faceBook" placeholder="FaceBook">
                    </div>
                    <div class="col" style="color: black; font-size: 12px;"> <input style="width:150px;font-size:12px" type="text" class="form-control" wire:model="twitter" placeholder="Twitter">
                    </div>
                    <div class="col" style="color: black; font-size: 12px;"> <input style="width:150px;font-size:12px" type="text" class="form-control" wire:model="linkedIn" placeholder="LinkedIn">
                    </div>
                </div>
                @else
                <div class="row" style="margin-top: 10px;margin-bottom:20px">
                    <div class="col" style="color: black; font-size: 12px;">{{$employee->facebook}}</div>
                    <div class="col" style="color: black; font-size: 12px;">{{$employee->twitter}}</div>
                    <div class="col" style="color: black; font-size: 12px;">{{$employee->linked_in}}</div>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>