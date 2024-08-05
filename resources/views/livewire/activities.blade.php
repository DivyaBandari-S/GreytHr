<div class="px-4">
<div class="px-4" style="position: relative;">
@if ($message)
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

    <div class="container  mt-3" style="height:60px;margin-top:10px">
    
        <div class="row bg-white rounded border" style="height:80px">
     
            <div class="col-md-1 mt-3" style="height:60px">
            @if(auth('emp')->check())
    @php
        $empEmployeeId = auth('emp')->user()->emp_id;
        $employeeDetails = \App\Models\EmployeeDetails::with('personalInfo') // Eager load personal info
            ->where('emp_id', $empEmployeeId)
            ->get();
    @endphp

    @if($employeeDetails && $employeeDetails->count() > 0)
        @foreach($employeeDetails as $employee)
            @if($employee->personalInfo && $employee->personalInfo->image)
                <img style="border-radius: 50%; margin-left: 10px" height="50" width="50" src="{{ asset('storage/' . $employee->personalInfo->image) }}">
            @else
                <img style="border-radius: 50%; margin-left: 10px" height="50" width="50" src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" alt="Default Image">
            @endif
        @endforeach
    @else
        <p>No employee details found.</p>
    @endif



@elseif(auth('hr')->check())
    @php
        $hrEmployeeId = auth('hr')->user()->hr_emp_id;
        $hrEmployeeDetails = \App\Models\Hr::where('hr_emp_id', $hrEmployeeId)->get();
    @endphp

    @if($hrEmployeeDetails && $hrEmployeeDetails->count() > 0)
        @foreach($hrEmployeeDetails as $hr)
            @if($hr->image)
                <img style="border-radius: 50%; margin-left: 10px" height="50" width="50" src="{{ asset('storage/' . $hr->image) }}">
            @else
                <img style="border-radius: 50%; margin-left: 10px" height="50" width="50" src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" alt="Default Image">
            @endif
        @endforeach
    @else
        <p>No HR employee details found.</p>
    @endif

@else
    <p>User is not authenticated.</p>
@endif


      
            </div>
            <div class="col-md-10 mt-2 bg-white d-flex align-items-center justify-content-between">
                <div style="color:#3b4452;">
                @if(auth()->guard('emp')->check())
    <span class="text-base">Hey {{ ucwords(strtolower(auth()->guard('emp')->user()->first_name)) }} {{ ucwords(strtolower(auth()->guard('emp')->user()->last_name)) }}</span>
@elseif(auth()->guard('hr')->check())
    <span class="text-base">Hey {{ ucwords(strtolower(auth()->guard('hr')->user()->employee_name)) }}</span>
@else
    <p>No employee details available.</p>
@endif

                    <div class="text-xs" style="color:#3b4452;">Ready to dive in?</div>
                </div>
                <div>
                    <button wire:click="addFeeds" class="flex flex-col justify-between items-start group w-20 h-20 p-1 rounded-md border border-purple-200" style="background-color: #F1ECFC;border:1px solid purple;border-radius:5px;">
                        <div class="w-6 h-6 rounded bg-purple-200">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file stroke-current group-hover:text-purple-600 stroke-1 text-purple-400">
                                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                <polyline points="13 2 13 9 20 9"></polyline>
                            </svg>
                        </div>
                        <div class="row ml-2">
                            <div class="text-left text-xs" wire:click="addFeeds">Create</div>
                            <div class="text-left text-xs">Posts</div>
                        </div>
                    </button>

                    @if($showFeedsDialog)
                    <div class="modal" tabindex="-1" role="dialog" style="display: block; color: #3b4452; font-family: Montserrat, sans-serif;">
    <div class="modal-dialog modal-dialog-centered" role="document" style="color: #3b4452;">
        <div class="modal-content" style="border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <div class="modal-header" style="border-bottom: 1px solid #ccc; padding: 15px;">
                <!-- <h5 class="modal-title" style="font-weight: 500; font-size: 1.25rem;color:#3b4452">Creating a Post</h5> -->
               <span style="justify-content-end">
                <image src="https://www3.nhk.or.jp/nhkworld/en/tv/bento/season5/images/top_info_20190412_5_pc.png" >
               </span>
            </div>

            @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert" 
                    style="font-size: 0.875rem; width: 90%; margin: 10px auto; padding: 10px; border-radius: 4px; background-color: #f8d7da; color: #721c24;">
                    {{ Session::get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="margin-left: 10px;"></button>
                </div>
            @endif

            <form wire:submit.prevent="submit">
                <div class="modal-body" style="padding: 20px;">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="category" style="font-weight: 600; color: #3b4452;">Select Category:</label>
                        <select wire:model="category" class="form-select" id="category" style="border: 1px solid #ccc; border-radius: 4px; padding: 10px; font-size: 0.875rem;color:#3b4452;margin-top:5px">
                            <option value="Appreciations">Appreciations</option>
                            <option value="Buy/Sell/Rent">Buy/Sell/Rent</option>
                            <option value="Companynews">Company News</option>
                            <option value="Events">Events</option>
                            <option value="Everyone">Everyone</option>
                            <option value="Hyderabad">Hyderabad</option>
                            <option value="US">US</option>
                        </select>
                    </div>

                    <div class="form-group" >
                        <label for="content" style="font-weight: 600; color: #3b4452;">Write something here:</label>
                        <textarea wire:model="description" class="form-control" id="content" rows="2" 
                            style="border: 1px solid #ccc; border-radius: 4px; padding: 10px; font-size: 0.875rem; resize: vertical; width: 100%;margin-left:-260px;;margin-top:5px"
                            placeholder="Enter your description here..."></textarea>
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="attachment" style="font-weight: 600; color: #3b4452;">Upload Attachment:</label>
                        <div style="text-align: start;">
                            <input wire:model="image" type="file" accept="image/*" style="font-size: 12px ;margin-top:5px">
                            @if ($image)
                                <div class="mt-2">
                                    <img src="{{ $image->temporaryUrl() }}" height="50" width="50" alt="Image Preview" style="max-width: 100px; border-radius: 4px; border: 1px solid #ccc;">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="border-top: 1px solid #ccc; ">
                    <div class="d-flex justify-content-center" style="width: 100%;">
                    <button type="button" wire:click="submit" class="submit-btn">Submit</button>
                    <button wire:click="closeFeeds" type="button" class="cancel-btn" style="border:1px solid rgb(2,17,79);margin-left:10px">Cancel</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>




                    <div class="modal-backdrop fade show"></div>
                    @endif
                </div>
            </div>
        </div>
        <!-- Additional row -->
        <div class="row mt-3 d-flex" style="overflow-x: hidden;">

            <div class="col-md-4 bg-white p-3" style="border-radius:5px;border:1px solid silver;height:auto;overflow-x: hidden;">

                <p style="font-weight: 500;font-size:13px;color:#47515b;">Filters</p>
                <hr style="width: 100%;border-bottom: 1px solid grey;">


                <p style="font-weight: 500;font-size:13px;color:#47515b;cursor:pointer">Activities</p>
                <div class="activities" style="width: 100%; height: 30px;">
    <label class="custom-radio-label" style="display: flex; align-items: center; padding: 5px; height: 100%;">
        <input type="radio" name="radio" value="activities" checked data-url="/Feeds" onclick="handleRadioChange(this)">
        <div class="feed-icon-container" style="margin-left: 10px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file stroke-current text-purple-400 stroke-1" style="width: 1rem; height: 1rem;">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <rect x="7" y="7" width="3" height="9"></rect>
                <rect x="14" y="7" width="3" height="5"></rect>
            </svg>
        </div>
        <span class="custom-radio-button bg-blue" style="margin-left: 10px; font-size: 8px;"></span>
        <span style="color: #778899; font-size: 12px; font-weight: 500; margin-left: 5px;">All Activities</span>
    </label>
</div>


<div class="posts" style="width: 100%; height: 30px;">
    <label class="custom-radio-label" style="display: flex; align-items: center; padding: 5px; height: 100%;">
        @if(auth()->guard('emp')->check())
            <input type="radio" id="radio-emp" name="radio" value="" data-url="/everyone" onclick="handleRadioChange(this)">
        @elseif(auth()->guard('hr')->check())
            <input type="radio" id="radio-hr" name="radio" value="" data-url="/hreveryone" onclick="handleRadioChange(this)">
        @else
            <p>No employee details available.</p>
        @endif
        <div class="feed-icon-container" style="margin-left: 10px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file stroke-current text-purple-400 stroke-1" style="width: 1rem; height: 1rem;">
                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                <polyline points="13 2 13 9 20 9"></polyline>
            </svg>
        </div>
        <span class="custom-radio-button bg-blue" style="margin-left: 10px; font-size: 10px;"></span>
        <span style="color: #778899; font-size: 12px; font-weight: 500; margin-left: 5px;">Posts</span>
    </label>
</div>


                <hr style="width: 100%;border-bottom: 1px solid grey;">
                <div style="overflow-y:auto;max-height:300px;overflow-x: hidden;">
                    <div class="row">
                        <div class="col " style="margin: 0px;">
                            <div class="input-group">
                                <input wire:model="search" id="filterSearch" onkeyup="filterDropdowns()" style="width:80%;font-size: 10px; border-radius: 5px 0 0 5px;  " type="text" class="form-control" placeholder="Search...." aria-label="Search" aria-describedby="basic-addon1">
                                <button style="border-radius: 0 5px 5px 0; background-color: rgb(2, 17, 79);; color: #fff; border: none;" class="search-btn" type="button">
                                    <i style="text-align: center;color:white" class="fa fa-search" ></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="w-full visible mt-1" style="margin-top:20px">
                        <div class="cus-button" style="display: flex; justify-content: space-between; width: 100%; padding: 0.5rem;" onclick="toggleDropdown('dropdownContent1', 'arrowSvg1')">
                            <span class="text-xs leading-4" style="font-weight:bold; color: grey;">Groups</span>

                            <span class="arrow-icon" id="arrowIcon1" style="margin-top:-5px">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down h-1.2x w-1.2x text-secondary-400" id="arrowSvg1" style="color:#3b4452;margin-top:-5px">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </div>
                        <div id="dropdownContent1" style="display: none;">
                            <ul class="d-flex flex-column" style="font-size: 12px; line-height: 1; text-decoration: none; color:black;text-align: left; padding-left: 0;">
                                <a class="menu-item" href="/Feeds" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">All Feeds</a>
                                @if (Auth::guard('hr')->check())
                          
        <a class="menu-item" href="/hreveryone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Every One </a>
    @elseif (Auth::guard('emp')->check())
        <a class="menu-item" href="/everyone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Every One </a>
    @endif



    @if (Auth::guard('hr')->check())

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Events</a>
@elseif (Auth::guard('emp')->check())
<a class="menu-item" href="/events" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Events</a>
@endif
@if (Auth::guard('hr')->check())

<a class="menu-item" href="/hreveryone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Company News</a>
@elseif (Auth::guard('emp')->check())
<a class="menu-item" href="/everyone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Company News</a>
@endif
@if (Auth::guard('hr')->check())

<a class="menu-item" href="/hreveryone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Appreciation</a>
@elseif (Auth::guard('emp')->check())
<a class="menu-item" href="/everyone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">Appreciation</a>
@endif
@if (Auth::guard('hr')->check())

<a class="menu-item" href="/hreveryone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Buy/Sell/Rent</a>
@elseif (Auth::guard('emp')->check())
<a class="menu-item" href="/everyone" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Buy/Sell/Rent</a>
@endif
                            </ul>
                        </div>
                    </div>

                    <div class="w-full visible mt-1" style="margin-top: 20px;">
                        <div class="cus-button" style="display: flex; justify-content: space-between; width: 100%; padding: 0.5rem;">
                            <span class="text-xs leading-4 " style="font-weight: bold;color:grey">Location</span>
                            <span class="arrow-icon" id="arrowIcon2" onclick="toggleDropdown('dropdownContent2', 'arrowSvg2')" style="margin-top:-5px;color:#3b4452;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down h-1.2x w-1.2x text-secondary-400" id="arrowSvg2" style="color:#3b4452;margin-top:-5px">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </div>
                        <div id="dropdownContent2" style="font-size: 12px; line-height: 1; text-decoration: none; color:#3b4452; text-align: left; padding-left: 0; display: none;">
                            <ul style="font-size: 12px; margin: 0; padding: 0;">
                                <b class="menu-item" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">India</b>
                               
                                @if (Auth::guard('hr')->check())

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Adilabad</a>

@elseif (Auth::guard('emp')->check())
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Adilabad</a>
 @endif 
                                @if (Auth::guard('hr')->check())

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">California</a>

@elseif (Auth::guard('emp')->check())
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">California</a>
 @endif
 @if (Auth::guard('hr')->check())

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">Doddaballapur</a>

@elseif (Auth::guard('emp')->check())
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Doddaballapur</a>
 @endif 
                                @if (Auth::guard('hr')->check())

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Guntur</a>

@elseif (Auth::guard('emp')->check())
<a class="menu-item" href="/events" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Guntur</a>

@endif
@if (Auth::guard('hr')->check())

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Hyderabad</a>

@elseif (Auth::guard('emp')->check())
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">Hyderabad</a>
 @endif      

 @if (Auth::guard('hr')->check())

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">Tirupati</a>

@elseif (Auth::guard('emp')->check())
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">Tirupati</a>
 @endif      
     
 @if (Auth::guard('hr')->check())

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">Trivandrum</a>

@elseif (Auth::guard('emp')->check())
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">Trivandrum</a>
 @endif      
 @if (Auth::guard('hr')->check())

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;font-weight:700">USA</a>

@elseif (Auth::guard('emp')->check())
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;font-weight:700">USA</a>
 @endif      

 @if (Auth::guard('hr')->check())

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">New York</a>

@elseif (Auth::guard('emp')->check())
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">New York</a>
 @endif      
     
 @if (Auth::guard('hr')->check())

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Hawaii</a>

@elseif (Auth::guard('emp')->check())
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Hawaii</a>
 @endif                 

                            </ul>
                        </div>
                    </div>

                    <div class="w-full visible mt-1" style="margin-top: 20px;">
                        <div class="cus-button" style="display: flex; justify-content: space-between; width: 100%; padding: 0.5rem;">
                            <span class="text-xs leading-4 " style="font-weight: bold;color:grey">Department</span>
                            <span class="arrow-icon" id="arrowIcon3" onclick="toggleDropdown('dropdownContent3', 'arrowSvg3')" style="margin-top:-5px">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down h-1.2x w-1.2x text-secondary-400" id="arrowSvg3" style="color:#3b4452;">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </div>
                        <div id="dropdownContent3" style="font-size: 12px; line-height: 1; text-decoration: none; color: black; text-align: left; padding-left: 0; display: none;">
                            <ul style="font-size: 12px; margin: 0; padding: 0;">
                            @if (Auth::guard('hr')->check())

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">HR</a>

@elseif (Auth::guard('emp')->check())
<a class="menu-item" href="/events" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">HR</a>
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Operations Team</a>


@endif
@if (Auth::guard('hr')->check())

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Operations</a>

@elseif (Auth::guard('emp')->check())
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Operations</a>
 @endif
 @if (Auth::guard('hr')->check())

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">Production Team</a>

@elseif (Auth::guard('emp')->check())
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Production Team</a>
 @endif
 @if (Auth::guard('hr')->check())

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:#3b4452;">QA</a>

@elseif (Auth::guard('emp')->check())
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">QA</a>
 @endif

 @if (Auth::guard('hr')->check())

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">Sales Team</a>

@elseif (Auth::guard('emp')->check())
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">Sales Team</a>
 @endif
 @if (Auth::guard('hr')->check())

<a class="menu-item" href="/hrevents" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">Testing Team</a>

@elseif (Auth::guard('emp')->check())
<a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease;color:#3b4452;">Testing Team</a>
 @endif
           
                         
                              
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
<div class="col" >
    
<div id="eventsSection" style=" display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh;margin-top:-130px">

        <img src="https://cdni.iconscout.com/illustration/premium/thumb/business-failure-7626119-6210566.png" alt="Empty Image" style="width: 300px; height: auto; display: block;">
        <p style="font-size:20px;font-weight:500; text-align: center;color:#3b4452">It feels empty here!</p>
        <p style="font-size:12px;color:#778899; text-align: center;">Your feed is still in making as there's no post to show.</p>


        <!-- Begin the form outside the .form-group div -->
        @if($showFeedsDialog)
            <!-- Form content here -->
        @endif

</div>

           
          




            </div>

</div>



     
            <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script> -->
            <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
            <script>
                document.addEventListener('livewire:load', function() {
                    // Listen for clicks on emoji triggers and toggle the emoji list
                    document.querySelectorAll('.emoji-trigger').forEach(trigger => {
                        trigger.addEventListener('click', function() {
                            var index = this.dataset.index;
                            var emojiList = document.getElementById('emoji-list-' + index);
                            emojiList.style.display = (emojiList.style.display === "none" || emojiList.style.display === "") ? "block" : "none";
                        });
                    });
                })

                // Hide emoji list when an emoji is selected
                document.querySelectorAll('.emoji-option').forEach(option => {
                    option.addEventListener('click', function() {
                        document.querySelectorAll('.emoji-list').forEach(list => {
                            list.style.display = "none";
                        });
                    });
                });

                function showEmojiList(index) {
                    var emojiList = document.getElementById('emoji-list-' + index);
                    if (emojiList.style.display === "none" || emojiList.style.display === "") {
                        emojiList.style.display = "block";
                    } else {
                        emojiList.style.display = "none";
                    }
                }

                function comment(index) {
                    var div = document.getElementById('replyDiv_' + index);
                    if (div.style.display === 'none') {
                        div.style.display = 'flex';
                    } else {
                        div.style.display = 'none';
                    }
                }






                function subReply(index) {
                    var div = document.getElementById('subReplyDiv_' + index);
                    if (div.style.display === 'none') {
                        div.style.display = 'flex';
                    } else {
                        div.style.display = 'none';
                    }
                }


                document.querySelector('emoji-picker').addEventListener('emoji-click', event => console.log(event.detail));
                // JavaScript function to toggle arrow icon visibility
                // JavaScript function to toggle arrow icon and dropdown content visibility
                // JavaScript function to toggle dropdown content visibility and arrow rotation
                function toggleDropdown(contentId, arrowId) {
                    var dropdownContent = document.getElementById(contentId);
                    var arrowSvg = document.getElementById(arrowId);

                    if (dropdownContent.style.display === 'none') {
                        dropdownContent.style.display = 'block';
                        arrowSvg.style.transform = 'rotate(180deg)';
                    } else {
                        dropdownContent.style.display = 'none';
                        arrowSvg.style.transform = 'rotate(0deg)';
                    }
                }


                function reply(caller) {
                    var replyDiv = $(caller).siblings('.replyDiv');
                    $('.replyDiv').not(replyDiv).hide(); // Hide other replyDivs
                    replyDiv.toggle(); // Toggle display of clicked replyDiv
                }


                function react(reaction) {
                    // Handle reaction logic here, you can send it to the server or perform any other action
                    console.log('Reacted with: ' + reaction);
                }
            </script>
            <script>
                $(document).ready(function() {
                    $('input[name="radio"]').on('change', function() {
                        var url = $(this).data('url');
                        window.location.href = url;
                    });

                    // Ensures the corresponding radio button is selected based on current URL
                    var currentUrl = window.location.pathname;
                    $('input[name="radio"]').each(function() {
                        if ($(this).data('url') === currentUrl) {
                            $(this).prop('checked', true);
                        }
                    });

                    // Click handler for the custom radio label to trigger the radio input change
                    $('.custom-radio-label').on('click', function() {
                        $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
                    });
                });
            </script>
            <script>
                function addEmoji(emoji) {
                    let inputEle = document.getElementById('input');

                    input.value += emoji;
                }

                function toggleEmojiDrawer() {
                    let drawer = document.getElementById('drawer');

                    if (drawer.classList.contains('hidden')) {
                        drawer.classList.remove('hidden');
                    } else {
                        drawer.classList.add('hidden');
                    }
                }

                function toggleDropdown(contentId, arrowId) {
                    var content = document.getElementById(contentId);
                    var arrow = document.getElementById(arrowId);

                    if (content.style.display === 'block') {
                        content.style.display = 'none';
                        arrow.classList.remove('rotate');
                    } else {
                        content.style.display = 'block';
                        arrow.classList.add('rotate');
                    }

                    // Close the dropdown when clicking on a link
                    content.addEventListener('click', function(event) {
                        if (event.target.tagName === 'A') {
                            content.style.display = 'none';
                            arrow.classList.remove('rotate');
                        }
                    });
                }
            </script>
            <script>
                tinymce.init({
                    height: 140,
                    selector: "textarea#mytextarea",
                    plugins: "emoticons",
                    toolbar: "emoticons",
                    toolbar_location: "bottom",
                    menubar: false,
                    setup: function(editor) {
                        editor.on('input', function() {
                            autoResizeTextarea();
                        });
                    }
                });

                function autoResizeTextarea() {
                    var textarea = document.getElementById('mytextarea');
                    textarea.style.height = '140';
                }
            </script>
            @push('scripts')
            <script>
                Livewire.on('commentAdded', () => {
                    // Reload comments after adding a new comment
                    Livewire.emit('refreshComments');
                });
            </script>
            @endpush
            <script>
                // Add event listener to menu items
                const menuItems = document.querySelectorAll('.menu-item');
                menuItems.forEach(item => {
                    item.addEventListener('click', function() {
                        // Remove background color from all menu items
                        menuItems.forEach(item => {
                            item.classList.remove('selected');
                        });
                        // Add background color to the clicked menu item
                        this.classList.add('selected');
                    });
                });
            </script>
            <script>
                function selectEmoji(emoji, empId) {
                    // Your existing logic to select an emoji

                    // Toggle the emoji list visibility using the showEmojiList function
                    showEmojiList();
                }
                // Function to show the emoji list when clicking on the smiley emoji
                function showEmojiList(index) {
                    var emojiList = document.getElementById('emoji-list-' + index);
                    if (emojiList.style.display === "none") {
                        emojiList.style.display = "block";
                    } else {
                        emojiList.style.display = "none";
                    }
                }
            </script>
            <script>
                function addEmoji(emoji_reaction, empId) {
                    // Your existing logic to select an emoji

                    // Toggle the emoji list visibility using the showEmojiList function
                    showEmojiList();
                }
                // Function to show the emoji list when clicking on the smiley emoji
                function showEmojiList(index) {
                    var emojiList = document.getElementById('emoji-list-' + index);
                    if (emojiList.style.display === "none") {
                        emojiList.style.display = "block";
                    } else {
                        emojiList.style.display = "none";
                    }
                }
            </script>




            <script>
                document.addEventListener('livewire:load', function() {
                    // Listen for clicks on emoji triggers and toggle the emoji list
                    document.querySelectorAll('.emoji-trigger').forEach(trigger => {
                        trigger.addEventListener('click', function() {
                            var index = this.dataset.index;
                            var emojiList = document.getElementById('emoji-list-' + index);
                            emojiList.style.display = (emojiList.style.display === "none" || emojiList.style.display === "") ? "block" : "none";
                        });
                    });

                    // Hide emoji list when an emoji is selected
                    document.querySelectorAll('.emoji-option').forEach(option => {
                        option.addEventListener('click', function() {
                            document.querySelectorAll('.emoji-list').forEach(list => {
                                list.style.display = "none";
                            });
                        });
                    });
                });
            </script>


            <script>
                document.addEventListener('click', function(event) {
                    const dropdowns = document.querySelectorAll('.cus-button');
                    dropdowns.forEach(function(dropdown) {
                        if (!dropdown.contains(event.target)) {
                            const dropdownContent = dropdown.nextElementSibling;
                            dropdownContent.style.display = 'none';
                        }
                    });
                });

                function toggleDropdown(dropdownId, arrowId) {
                    const dropdownContent = document.getElementById(dropdownId);
                    const arrowSvg = document.getElementById(arrowId);

                    if (dropdownContent.style.display === 'block') {
                        dropdownContent.style.display = 'none';
                        arrowSvg.classList.remove('arrow-rotate');
                    } else {
                        dropdownContent.style.display = 'block';
                        arrowSvg.classList.add('arrow-rotate');
                    }
                }
            </script>


            <script>
                document.addEventListener('click', function(event) {
                    const dropdowns = document.querySelectorAll('.cus-button');
                    dropdowns.forEach(function(dropdown) {
                        if (!dropdown.contains(event.target)) {
                            const dropdownContent = dropdown.nextElementSibling;
                            dropdownContent.style.display = 'none';
                        }
                    });
                });

                function toggleDropdown(dropdownId, arrowId) {
                    const dropdownContent = document.getElementById(dropdownId);
                    const arrowSvg = document.getElementById(arrowId);

                    if (dropdownContent.style.display === 'block') {
                        dropdownContent.style.display = 'none';
                        arrowSvg.classList.remove('arrow-rotate');
                    } else {
                        dropdownContent.style.display = 'block';
                        arrowSvg.classList.add('arrow-rotate');
                    }
                }
            </script>
            @push('scripts')
            <script src="dist/emoji-popover.umd.js"></script>
            <link rel="stylesheet" href="dist/style.css" />

            <script>
                document.addEventListener('livewire:load', function() {
                    const el = new EmojiPopover({
                        button: '.picker',
                        targetElement: '.emoji-picker',
                        emojiList: [{
                                value: '🤣',
                                label: 'laugh and cry'
                            },
                            // Add more emoji objects here
                        ]
                    });

                    el.onSelect(l => {
                        document.querySelector(".emoji-picker").value += l;
                    });

                    // Toggle the emoji picker popover manually
                    document.querySelector('.picker').addEventListener('click', function() {
                        el.toggle();
                    });
                });
            </script>
            @endpush

     
        <script>
            function filterDropdowns() {
                var input, filter, ul, li, a, i;
                input = document.getElementById('filterSearch');
                filter = input.value.toUpperCase();
                uls = document.querySelectorAll('.w-full.visible ul');
                for (i = 0; i < uls.length; i++) {
                    ul = uls[i];
                    lis = ul.getElementsByTagName('a');
                    for (j = 0; j < lis.length; j++) {
                        a = lis[j];
                        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                            lis[j].style.display = "";
                        } else {
                            lis[j].style.display = "none";
                        }
                    }
                }
            }
        </script>

<script>
    function handleRadioChange(element) {
        const url = element.getAttribute('data-url');
        window.location.href = url;
    }
</script>

    </div>
    </div>