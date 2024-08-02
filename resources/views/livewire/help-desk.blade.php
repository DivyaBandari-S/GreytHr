<div>
<div style="overflow-x:hidden">

    <body>
        <div class="row ">
            @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Close" style=" font-size: 0.75rem;padding: 0.25rem 0.5rem;margin-top:6px"></button>
            </div>
            @endif
            @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.75rem; padding: 0.25rem 0.5rem; margin-top: 5px;"></button>
            </div>
            @endif
            <div class="d-flex border-0  align-items-center justify-content-center" style="height: 100px;">
            <div class="nav-buttons d-flex justify-content-center">
            <ul class="nav custom-nav-tabs border">
                <li class="custom-item m-0 p-0 flex-grow-1">
                    <a href="#" wire:click="$set('activeTab', 'active')" style="border-top-left-radius:5px;border-bottom-left-radius:5px;" class="custom-nav-link @if($activeTab === 'active') active @else btn-light @endif" >Active</a>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1" style="border-left:1px solid #ccc;border-right:1px solid #ccc;">
                    <a href="#" style="border-radius:none;"  wire:click="$set('activeTab', 'pending')" class="custom-nav-link @if($activeTab === 'pending') active @else btn-light @endif">Pending</a>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1">
                    <a href="#" wire:click="$set('activeTab', 'closed')" style="border-top-right-radius:5px;border-bottom-right-radius:5px;" class="custom-nav-link  @if($activeTab === 'closed') active @else btn-light @endif" >Closed</a>
                </li>
            </ul>
        </div>

</div>







        </div>
        <div class="d-flex flex-row justify-content-end gap-10 mt-2">

            <div class="mx-2 ">
                <button onclick="location.href='/catalog'" style="font-size:12px;background-color:rgb(2, 17, 79);color:white;border-radius:5px;padding:4px 10px;"> IT Request  </button>
            </div>

            <div class="mx-2 ">
                <button wire:click="openFinance" style="font-size:12px;background-color:rgb(2, 17, 79);color:white;border-radius:5px;padding:4px 10px;"> Finance Request </button>
            </div>
            <div class="mx-2 ">
                <button wire:click="open" style="font-size:12px;background-color:rgb(2, 17, 79);color:white;border-radius:5px;padding:4px 10px;"> HR Request </button>
            </div>

            <div>

            </div>
        </div>

        @if($showDialog)
        <div class="modal" tabindex="-1" role="dialog" style="display: block;overflow-y:auto;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header align-items-center" style="background-color: rgb(2, 17, 79); height: 50px">
                        <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b>HR Request</b></h5>

                        </button>
                    </div>
                    <div class="modal-body">
                    <label for="category" style="color:#778899;font-weight:500;font-size:12px;">Category <span style="color:red">*</span></label>
<div class="input" type="" class="form-control placeholder-small">
    <div style="position: relative;">
        <select wire:model.lazy="category" id="category" style="font-size: 12px;" class="form-control placeholder-small">
            <option style="color: #778899; " value="">Select Category</option>
            <optgroup label="HR">
            <option value="Employee Information">Employee Information</option>
            <option value="Hardware Maintenance">Hardware Maintenance</option>
            <option value="Incident Report">Incident Report</option>
            <option value="Privilege Access Request">Privilege Access Request</option>
            <option value="Security Access Request">Security Access Request</option>
            <option value="Technical Support">Technical Support</option>
            <!-- Add more HR-related options as needed -->
        </optgroup>
        </select>
        @error('category') <span class="text-danger">{{ $message }}</span> @enderror
        <div class="dropdown-toggle-icon" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%);">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                <path d="M14.146 5.146a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 1 1 .708-.708L8 10.293l5.146-5.147a.5.5 0 0 1 .708 0z"/>
            </svg>
        </div>




                                </div>
                            </div>

                            <div class="form-group mt-2">
    <label for="subject" style="color: #778899; font-weight: 500; font-size: 12px;">Subject <span style="color: red;">*</span></label>
    <input type="text" wire:model.lazy="subject" id="subject" class="form-control placeholder-small" placeholder="Enter subject" style="font-family: Montserrat, sans-serif;">
    @error('subject') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="description" style="color: #778899; font-weight: 500; font-size: 12px;">Description <span style="color: red;">*</span></label>
    <textarea wire:model.lazy="description" id="description" class="form-control" placeholder="Enter description" rows="4" style="font-family: Montserrat, sans-serif;"></textarea>

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

                        </div>
                        <div class="row">
                            <div class="col">
                            <div class="form-group mt-2">
    <label for="priority" style="color:#778899;font-weight:500;font-size:12px;margin-top:10px;">Priority<span style="color:red">*</span></label>
    <div class="input" class="form-control placeholder-small">
        <div style="position: relative;">
            <select name="priority" id="priority" wire:model.lazy="priority" style="font-size: 12px; " class="form-control placeholder-small">
                <option style="color: gray;" value="">Select Priority</option>
                <option value="High">High</option>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
            </select>
            <div class="dropdown-toggle-icon" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                    <path d="M14.146 5.146a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 1 1 .708-.708L8 10.293l5.146-5.147a.5.5 0 0 1 .708 0z"/>
                </svg>
            </div>
        </div>
    </div>
    @error('priority') <span class="text-danger">{{ $message }}</span> @enderror
</div>

                            </div>
                        </div>
                        <div class="row " style="margin-top: 10px;">
                            <div class="col">
                                <div class="row m-0 p-0">
                                    <div class="row m-0 p-0">
                                        <div style="margin: 0px;padding:0;">
                                            <div>
                                                <div style="font-size: 12px;color:#778899;margin-bottom:10px;font-weight:500;" wire:model="cc_to" id="cc_to">Selected CC recipients : {{ implode(', ', array_unique($selectedPeopleNames)) }}</div>
                                            </div>
                                            <button type="button" style="border-radius: 50%;margin-right:10px;color:#778899;border:1px solid #778899;" class="add-button" wire:click="toggleRotation">
                                                <i class="fa fa-plus" style="color:#778899;"></i>
                                            </button><span style="color:#778899;font-size:12px;">Add</span>

                                        </div>
                                        @error('cc_to') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                @if($isRotated)
                                <div style="border-radius:5px;background-color:grey;padding:8px;width:330px;margin-top:10px;height:200px;overflow-y:auto;">
                                    <div class="input-group" style="margin-bottom: 10px;">
                                        <input wire:model="searchTerm" style="font-size: 10px;cursor: pointer; border-radius: 5px 0 0 5px;" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                                        <div class="input-group-append">
                                            <button wire:click="filter" style="height: 30px; border-radius: 0 5px 5px 0;  background-color: rgb(2, 17, 79); color: #fff; border: none;" class="btn" type="button">
                                                <i style="text-align: center;" class="fa fa-search"></i>
                                            </button>
                                            <div class="col-md-2 ml-4 p-0">
                                <button wire:click="closePeoples"  type="button" class="close rounded px-1 py-0" aria-label="Close" style="background-color: rgb(2,17,79);height:32px;width:33px;">
                                    <span aria-hidden="true" style="color: white; font-size: 24px;">×</span>
                                </button>
                                        </div>
                                    </div>
                                    @if ($peopleData->isEmpty())
                                    <div class="container" style="text-align: center; color: white;font-size:12px"> No People Found
                                    </div>
                                    @else
                                    @foreach($peopleData as $people)
                                    <label wire:click="selectPerson('{{ $people->emp_id }}')" class="container" style="cursor: pointer; background-color: darkgrey; padding: 5px; margin-bottom: 8px; width: 300px; border-radius: 5px;">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <input type="checkbox" wire:model="selectedPeople" id="cc_to" value="{{ $people->emp_id }}">
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
                                    </label>
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
        @if($showDialogFinance)
        <div class="modal" tabindex="-1" role="dialog" style="display: block;overflow-y:auto;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header align-items-center" style="background-color: rgb(2, 17, 79); height: 50px">
                        <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b>Finance Request</b></h5>

                        </button>
                    </div>
                    <div class="modal-body" >
                    <label for="category" style="color:#778899;font-weight:500;font-size:12px;font-family: Arial, sans-serif;" >Category <span style="color:red">*</span></label>
                    <div class="input" type="" class="form-control placeholder-small">
    <div style="position: relative;">
        <select wire:model.lazy="category" id="category" style="font-size: 12px;" class="form-control placeholder-small">
            <option style="color: #778899; " value="">Select Category</option>
            <optgroup label="Finance">
                <option value="Income Tax">Income Tax</option>
                <option value="Loans">Loans</option>
                <option value="Payslip">Payslip</option>
            </optgroup>
        </select>
        <div class="dropdown-toggle-icon" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%);">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                <path d="M14.146 5.146a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 1 1 .708-.708L8 10.293l5.146-5.147a.5.5 0 0 1 .708 0z"/>
            </svg>
        </div>



                                    @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>


                        <div class="form-group mt-2">
                            <label for="subject" style="color:#778899;font-weight:500;font-size:12px;">Subject<span  style="color:red">*</span></label>
                            <input type="text" wire:model.lazy="subject" id="subject" class="form-control placeholder-small" placeholder="Enter subject" style="font-family: Montserrat, sans-serif;">
                            @error('subject') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="description" style="color:#778899;font-weight:500;font-size:12px;">Description<span  style="color:red">*</span></label>
                            <textarea wire:model.lazy="description" id="description" class="form-control " placeholder="Enter description" rows="4" ></textarea>
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

                        </div>
                        <div class="row">
                            <div class="col">
                            <div class="form-group mt-2">
    <label for="priority" style="color:#778899;font-weight:500;font-size:12px;margin-top:10px;">Priority<span style="color:red">*</span></label>
    <div class="input" class="form-control placeholder-small">
        <div style="position: relative;">
            <select name="priority" id="priority" wire:model.lazy="priority" style="font-size: 12px; " class="form-control placeholder-small">
                <option style="color: gray;" value="">Select Priority</option>
                <option value="High">High</option>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
            </select>
            <div class="dropdown-toggle-icon" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                    <path d="M14.146 5.146a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 1 1 .708-.708L8 10.293l5.146-5.147a.5.5 0 0 1 .708 0z"/>
                </svg>
            </div>
        </div>
    </div>
    @error('priority') <span class="text-danger">{{ $message }}</span> @enderror
</div>

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
                                <div style="border-radius:5px;background-color:grey;padding:8px;width:330px;margin-top:10px;height:200px;overflow-y:auto;">
                                    <div class="input-group" style="margin-bottom: 10px;">
                                        <input wire:model="searchTerm" style="font-size: 10px;cursor: pointer; border-radius: 5px 0 0 5px;" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                                        <div class="input-group-append">
                                            <button wire:click="filter" style="height: 30px; border-radius: 0 5px 5px 0;  background-color: rgb(2, 17, 79); color: #fff; border: none;" class="btn" type="button">
                                                <i style="text-align: center;" class="fa fa-search"></i>
                                            </button>
                                            <div class="col-md-2 ml-4 p-0">
                                <button wire:click="closePeoples"  type="button" class="close rounded px-1 py-0" aria-label="Close" style="background-color: rgb(2,17,79);height:32px;width:33px;">
                                    <span aria-hidden="true" style="color: white; font-size: 24px;">×</span>
                                </button>
                            </div>

                                        </div>
                                    </div>
                                    @if ($peopleData->isEmpty())
                                    <div class="container" style="text-align: center; color: white;font-size:12px"> No People Found
                                    </div>
                                    @else
                                    @foreach($peopleData as $people)
                                    <label wire:click="selectPerson('{{ $people->emp_id }}')" class="container" style="cursor: pointer; background-color: darkgrey; padding: 5px; margin-bottom: 8px; width: 300px; border-radius: 5px;">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <input type="checkbox" wire:model="selectedPeople" value="{{ $people->emp_id }}">
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
                                    </label>
                                    @endforeach
                                    @endif
                                </div>
                                @endif

                            </div>
                        </div>
                        <div class="ml-0 p-0 mt-3 d-flex gap-3 justify-content-center">
                            <button wire:click="submit" class="submit-btn" type="button">Submit</button>
                            <button wire:click="closeFinance" class="cancel-btn" type="button" style="border: 1px solid rgb(2, 17, 79);">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
        @endif

        @if ($activeTab == "active")
    <div class="card-body" style="margin: 0 auto; background-color: white; width: 95%; height: 400px; margin-top: 30px; border-radius: 5px; max-height: 400px; overflow-y: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: rgb(2, 17, 79); color: white;">
                    <th style="padding: 10px; font-size: 12px; text-align: center; width: 20%;">Request Raised By</th>
                    <th style="padding: 10px; font-size: 12px; text-align: center; width: 10%;">Category</th>
                    <th style="padding: 10px; font-size: 12px; text-align: center; width: 20%;">Subject</th>
                    <th style="padding: 10px; font-size: 12px; text-align: center; width: 10%;">Description</th>
                    <th style="padding: 10px; font-size: 12px; text-align: center; width: 10%;">Attach Files</th>
                    <th style="padding: 10px; font-size: 12px; text-align: center; width: 20%;">CC To</th>
                    <th style="padding: 10px; font-size: 12px; text-align: center; width: 10%;">Priority</th>
                </tr>
            </thead>
            <tbody>
                @if($records->where('status', 'Recent')->count() > 0)
                    @foreach ($records->where('status', 'Recent') as $record)
                        @php
                            $ccToArray = explode(',', $record->cc_to);
                        @endphp
                        <tr>
                            <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize; width: 20%;">
                                {{ ucwords(strtolower($record->emp->first_name)) }} {{ ucwords(strtolower($record->emp->last_name)) }} <br> <strong style="font-size: 10px;">({{ $record->emp_id }})</strong>
                            </td>
                            <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize; width: 10%;">{{ $record->category }}</td>
                            <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize; width: 20%;">{{ $record->subject }}</td>
                            <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize; width: 10%;">{{ $record->description }}</td>
                            <td style="padding: 10px; font-size: 12px; text-align: center;">
                                @if (!is_null($record->file_path) && $record->file_path !== 'N/A')
                                    <a href="{{ asset('storage/' . $record->file_path) }}" target="_blank" style="text-decoration: none; color: #007BFF; text-transform: capitalize;">View File</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize; width: 20%;">
                                {{ count($ccToArray) <= 2 ? $record->cc_to ?? '-' : '-' }}
                            </td>
                            <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize; width: 10%;">{{ $record->priority }}</td>
                        </tr>
                        @if(count($ccToArray) > 2)

                            <tr style="border-top:none">


                                <td colspan="7" style="padding: 10px; font-size: 12px; text-transform: capitalize; width: 100%;border-top:none">
                                <div style="margin-left: 10px; font-size: 12px; text-transform: capitalize; width: 100%;border-top:none">
                                        CC TO: {{ implode(', ', $ccToArray) }}
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" style="text-align: center; font-size: 12px;">Active records not found</td>
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

                        @if (!is_null($record->file_path) && $record->file_path !== 'N/A')
    <a href="{{ asset('storage/' . $record->file_path) }}" target="_blank" style="text-decoration: none; color: #007BFF; text-transform: capitalize;">View File</a>
@else
    -
@endif


                        </td>
                        <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize; width: 20%;">
                                {{ count($ccToArray) <= 2 ? $record->cc_to ?? '-' : '-' }}
                            </td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">{{ $record->priority }}</td>

                    </tr>
                    @if(count($ccToArray) > 2)

                            <tr style="border-top:none">

 
                                <td colspan="7" style="padding: 10px; font-size: 12px; text-transform: capitalize; width: 100%;border-top:none">
                                <div style="margin-left: 10px; font-size: 12px; text-transform: capitalize; width: 100%;border-top:none">
                                        CC TO: {{ implode(', ', $ccToArray) }}
                                    </div>
                                </td>
                            </tr>
                        @endif
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
                        @if (!is_null($record->file_path) && $record->file_path !== 'N/A')
    <a href="{{ asset('storage/' . $record->file_path) }}" target="_blank" style="text-decoration: none; color: #007BFF; text-transform: capitalize;">View File</a>
@else
    -
@endif

                        </td>
                        <td style="padding: 10px; font-size: 12px; text-align: center; text-transform: capitalize; width: 20%;">
                                {{ count($ccToArray) <= 2 ? $record->cc_to ?? '-' : '-' }}
                            </td>
                        <td style="padding: 10px;font-size:12px;text-align:center;text-transform: capitalize;">{{ $record->priority }}</td>

                    </tr>
                    @if(count($ccToArray) > 2)

                            <tr style="border-top:none">

      
                                <td colspan="7" style="padding: 10px; font-size: 12px; text-transform: capitalize; width: 100%;border-top:none">
                                <div style="margin-left: 10px; font-size: 12px; text-transform: capitalize; width: 100%;border-top:none">
                                        CC TO: {{ implode(', ', $ccToArray) }}
                                    </div>
                                </td>
                            </tr>
                        @endif
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
</div>
