<div style="overflow-x:hidden">

    <body>
        <div class="row ">
            <div class="d-flex align-item-center justify-content-center">
                <div class="card " style="width:400px; ">
                    <div class="card-header px-4 py-0 m-0 ">
                        <div class="row">
                            <button wire:click="$set('activeTab', 'active')" class="col btn @if($activeTab === 'active') active @else btn-light @endif" style="font-size:13px;font-weight:500;border-radius: 5px; margin-right: 5px;background-color: @if($activeTab === 'active') rgb(2, 17, 79) @else none @endif; color: @if($activeTab === 'active') #fff @else #778899 @endif;">
                                Active
                            </button>
                            <button wire:click="$set('activeTab', 'pending')" class="col btn @if($activeTab === 'pending') active @else btn-light @endif" style="font-size:13px;font-weight:500;border-radius: 5px;margin-right: 5px;background-color: @if($activeTab === 'pending') rgb(2, 17, 79) @else none @endif; color: @if($activeTab === 'pending') #fff @else #778899 @endif;">
                                Pending
                            </button>
                            <button wire:click="$set('activeTab', 'closed')" class="col btn @if($activeTab === 'closed') active @else btn-light @endif" style="font-size:13px;font-weight:500;border-radius: 5px;background-color: @if($activeTab === 'closed') rgb(2, 17, 79) @else none @endif; color: @if($activeTab === 'closed') #fff @else #778899 @endif;">
                                Closed
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="d-flex flex-row justify-content-end gap-10 mt-2">
            <div class="mx-2 ">
                <button wire:click="open" style="font-size:12px;background-color:rgb(2, 17, 79);color:white;border-radius:5px;padding:4px 10px;"> New Request </button>
            </div>
            <div>
                <button style="background-color: rgb(2, 17, 79); color: white; border-radius: 5px;margin:0;padding:1px 0;"><a href="/catalog" class="px-2 py-0" style="color:white;font-size:12px;margin:0;"> Catalog </a></button>
            </div>
        </div>

        @if($showDialog)
        <div class="modal" tabindex="-1" role="dialog" style="display: block;overflow-y:auto;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                        <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b>New Request</b></h5>
                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="close" style="background-color: white; height:10px;width:10px;">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category" style="color:#778899;font-weight:500;font-size:12px;">Category</label>
                            <div class="input-group">
                                <select wire:model="category" id="category" class="custom-select placeholder" style="font-size: 12px;">
                                    <option style="color: #778899; " value="">Select Category</option>
                                    <optgroup label="IT">
                                        <option value="Database Access Request">Database Access Request</option>
                                        <option value="IT Training Request">IT Training Request</option>
                                        <option value="New Laptop">New Laptop</option>
                                        <option value="New Mailbox Request">New Mailbox Request</option>
                                        <option value="Request For IT Accessories">Request For IT Accessories</option>
                                        <option value="Software Installation">Software Installation</option>
                                        <option value="System Upgrade Request">System Upgrade Request</option>
                                        <option value="VPN Access Request">VPN Access Request</option>
                                        <!-- Add more IT-related options as needed -->
                                    </optgroup>
                                    <optgroup label="Finance">
                                        <option value="Income Tax">Income Tax</option>
                                        <option value="Loans">Loans</option>
                                        <option value="Payslip">Payslip</option>
                                        <!-- Add more Finance-related options as needed -->
                                    </optgroup>
                                    <optgroup label="HR">
                                        <option value="Employee Information">Employee Information</option>
                                        <option value="Hardware Maintenance">Hardware Maintenance</option>
                                        <option value="Incident Report">Incident Report</option>
                                        <option value="Privilege Access Request">Privilege Access Request</option>
                                        <option value="Security Access Request">Security Access Request</option>
                                        <option value="Technical Support">Technical Support</option>
                                        <!-- Add more HR-related options as needed -->
                                    </optgroup>
                                    <optgroup label="Other">
                                        <option value="Other Request">Other Request</option>
                                    </optgroup>
                                </select>
                                <div>
                                    @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="subject" style="color:#778899;font-weight:500;font-size:12px;">Subject</label>
                            <input type="text" wire:model="subject" id="subject" class="form-control placeholder-small" placeholder="Enter subject">
                            @error('subject') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="description" style="color:#778899;font-weight:500;font-size:12px;">Description</label>
                            <textarea wire:model="description" id="description" class="form-control " placeholder="Enter description" rows="4"></textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="fileInput" style="color:#778899;font-weight:500;font-size:12px;cursor:pointer;">
                                    <i class="fa fa-paperclip"></i> Attach Image
                                </label>
                            </div>
                            @error('file_path') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <input wire:model="image" type="file" accept="image/*" style="font-size: 12px;">
                            @if ($image)
                            <div>
                                <img height="100" width="100" src="{{ $image->temporaryUrl() }}" alt="Image Preview" style="max-width: 300px;">
                            </div>
                            @endif
                        </div>

                        <div id="filePreview"></div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="category" style="color:#778899;font-weight:500;font-size:12px;margin-top:10px;">Priority</label>
                                    <div class="input-group">
                                        <select name="category" id="category" wire:model="priority" class="custom-select" style="font-size: 12px;">
                                            <option style="color: gray;" value="">Select Priority</option>
                                            <option value="High">
                                                <span></span> High
                                            </option>
                                            <option value="Low">
                                                <span></span> Low
                                            </option>
                                            <option value="Medium">
                                                <span></span> Medium
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                @error('priority') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="row " style="margin-top: 10px;">
                            <div class="col">
                                <div class="row m-0 p-0">
                                    <div class="row m-0 p-0">
                                        <div style="margin: 0px;padding:0;">
                                            <div>
                                                <div style="font-size: 12px;color:#778899;margin-bottom:10px;font-weight:500;">Selected CC recipients : {{ implode(', ', array_unique($selectedPeopleNames)) }}</div>
                                            </div>
                                            <button type="button" style="border-radius: 50%;margin-right:10px;color:#778899;border:1px solid #778899;" class="add-button" wire:click="toggleRotation">
                                                <i class="fa fa-plus" style="color:#778899;"></i>
                                            </button><span style="color:#778899;font-size:12px;">Add</span>

                                        </div>
                                        @error('cc_to') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                @if($isRotated)
                                <div style="border-radius:5px;background-color:grey;padding:8px;width:320px;margin-top:10px;height:200px;overflow-y:auto;">
                                    <div class="input-group" style="margin-bottom: 10px;">
                                        <input wire:model="searchTerm" style="font-size: 10px;cursor: pointer; border-radius: 5px 0 0 5px;" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                                        <div class="input-group-append">
                                            <button wire:click="filter" style="height: 30px; border-radius: 0 5px 5px 0; background-color: #007BFF; color: #fff; border: none;" class="btn" type="button">
                                                <i style="text-align: center;" class="fa fa-search"></i>
                                            </button>
                                            <button wire:click="closePeoples" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" style="color: white; font-size: 24px;">×</span>
                                            </button>
                                        </div>
                                    </div>
                                    @if ($peopleData->isEmpty())
                                    <div class="container" style="text-align: center; color: white;font-size:12px"> No People Found
                                    </div>
                                    @else
                                    @foreach($peopleData as $people)
                                    <div wire:model="cc_to" wire:click="selectPerson('{{ $people->emp_id }}')" class="container" style="cursor: pointer; background-color: darkgrey; padding: 5px; margin-bottom: 8px; width: 300px; border-radius: 5px;">
                                        <div class="row align-items-center ">
                                            <div class="col-auto">
                                                <input type="checkbox" wire:model="selectedPeople" value="{{ $people->emp_id }}" wire:click="selectPerson({{ $people->emp_id }})">
                                            </div>
                                            <div class="col-auto">
                                                @if($people->image=="")
                                                @if($people->gender=="Male")
                                                <img class="profile-image" src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png" alt="">
                                                @elseif($people->gender=="Female")
                                                <img class="profile-image" src="https://th.bing.com/th/id/R.f931db21888ef3645a8356047504aa7b?rik=63HALWH%2b%2fKtaNQ&riu=http%3a%2f%2fereadcost.eu%2fwp-content%2fuploads%2f2016%2f03%2fblank_profile_female-7.jpg&ehk=atYRSw0KxmUnhESig51u5yzYBWfaD9KBO5KvdxXRCTY%3d&risl=&pid=ImgRaw&r=0" alt="">
                                                @endif
                                                @else
                                                <img class="profile-image" src="{{ Storage::url($people->image) }}" alt="">
                                                @endif
                                            </div>
                                            <div class="col">
                                                <h6 class="username" style="font-size: 12px; color: white;">{{ ucwords(strtolower($people->first_name)) }} {{ ucwords(strtolower($people->last_name)) }}</h6>
                                                <p class="mb-0" style="font-size: 12px; color: white;">(#{{ $people->emp_id }})</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="m-0 p-0 mt-3 d-flex gap-3 justify-content-center">
                            <button wire:click="submit" class="submit-btn" type="button">Submit</button>
                            <button wire:click="close" class="cancel-btn" type="button" style="border: 1px solid rgb(2, 17, 79);">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
        @endif

        @if ($activeTab == "active")
        <div class="card-body " style="margin:0 auto;background-color:white;width:95%;height:400px;margin-top:30px;border-radius:5px;max-height:400px;overflow-y:auto">

            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: rgb(2, 17, 79); color: white;">
                        <th style="padding: 10px;font-size:12px;text-align:center;width:20%">Request Raised By</th>
                        <th style="padding: 10px;font-size:12px;text-align:center;width:10%">Category</th>
                        <th style="padding: 10px;font-size:12px;text-align:center;width:20%">Subject</th>
                        <th style="padding: 10px;font-size:12px;text-align:center;width:10%">Description</th>
                        <th style="padding: 10px;font-size:12px;text-align:center;width:10%">Attach Files</th>
                        <th style="padding: 10px;font-size:12px;text-align:center;width:20%">CC To</th>
                        <th style="padding: 10px;font-size:12px;text-align:center;width:10%">Priority</th>
                    </tr>
                </thead>
                <tbody>
                    @if($records->where('status', 'Open')->count() > 0)
                    @foreach ($records->where('status', 'Open') as $record)
                    <tr>
                        <td style="padding: 10px;font-size:12px;text-align:center;width:20%;text-transform: capitalize;">{{ ucwords(strtolower($record->emp->first_name)) }} {{ ucwords(strtolower($record->emp->last_name)) }} <br> <strong style="font-size: 10px;">({{$record->emp_id}})</strong></td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;width:10%;">{{ $record->category }}</td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;width:20%;">{{ $record->subject }}</td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;width:10%;">{{ $record->description }}</td>
                        <td style="padding: 10px;font-size:12px;text-align:center">
                            @if ($record->file_path)
                            <a href="{{ asset('storage/' . $record->file_path) }}" target="_blank" style="text-decoration: none; color: #007BFF;text-transform: capitalize;width:10%;">View File</a>
                            @else
                            N/A
                            @endif
                        </td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;width:20%;">{{ $record->cc_to }}</td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;width:10%;">{{ $record->priority }}</td>

                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" style="text-align: center;font-size:12px">Active records not found</td>
                    </tr>
                    @endif


                </tbody>
            </table>

        </div>
        @endif

        @if ($activeTab == "closed")
        <div class="card-body" style="margin:0 auto;background-color:white;width:95%;margin-top:30px;border-radius:5px;max-height:400px;height:400px;overflow-y:auto">

            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: rgb(2, 17, 79); color: white;">
                        <th style="padding: 10px;font-size:12px;text-align:center;width:120px">Request Raised By</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Category</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Subject</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Description</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Attach Files</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">CC To</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Priority</th>
                    </tr>
                </thead>
                <tbody>
                    @if($records->where('status', 'Completed')->count() > 0)
                    @foreach ($records->where('status', 'Completed') as $record)
                    <tr>
                        <td style="padding: 10px;font-size:12px;text-align:center;width:120px;text-transform: capitalize;">{{ $record->emp->first_name }} {{ $record->emp->last_name }} <br> <strong style="font-size: 10px;">({{$record->emp_id}})</strong></td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">{{ $record->category }}</td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">{{ $record->subject }}</td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">{{ $record->description }}</td>
                        <td style="padding: 10px;font-size:12px;text-align:center">
                            @if ($record->file_path)
                            <a href="{{ asset('storage/' . $record->file_path) }}" target="_blank" style="text-decoration: none; color: #007BFF;text-transform: capitalize;">View File</a>
                            @else
                            N/A
                            @endif
                        </td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">{{ $record->cc_to }}</td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">{{ $record->priority }}</td>

                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" style="text-align: center;font-size:12px">Closed records not found</td>
                    </tr>
                    @endif

                </tbody>
            </table>

        </div>
        @endif



        @if ($activeTab == "pending")
        <div class="card-body" style="margin:0 auto;background-color:white;width:95%;margin-top:30px;border-radius:5px;max-height:400px;height:400px;overflow-y:auto">

            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: rgb(2, 17, 79); color: white;">
                        <th style="padding: 10px;font-size:12px;text-align:center;width:120px">Request Raised By</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Category</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Subject</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Description</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Attach Files</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">CC To</th>
                        <th style="padding: 10px;font-size:12px;text-align:center">Priority</th>
                    </tr>
                </thead>
                <tbody>
                    @if($records->where('status', 'Pending')->count() > 0)
                    @foreach ($records->where('status', 'Pending') as $record)
                    <tr>
                        <td style="padding: 10px;font-size:12px;text-align:center;width:120px;text-transform: capitalize;">{{ $record->emp->first_name }} {{ $record->emp->last_name }} <br> <strong style="font-size: 10px;">({{$record->emp_id}})</strong></td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">{{ $record->category }}</td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">{{ $record->subject }}</td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">{{ $record->description }}</td>
                        <td style="padding: 10px;font-size:12px;text-align:center">
                            @if ($record->file_path)
                            <a href="{{ asset('storage/' . $record->file_path) }}" target="_blank" style="text-decoration: none; color: #007BFF;text-transform: capitalize;">View File</a>
                            @else
                            N/A
                            @endif
                        </td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">{{ $record->cc_to }}</td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">{{ $record->priority }}</td>

                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" style="text-align: center;font-size:12px">Pending records not found</td>
                    </tr>
                    @endif

                </tbody>
            </table>

        </div>
        @endif
</div>