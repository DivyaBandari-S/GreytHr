<div>
<div wire:loading
        wire:target="addFeeds,submit,file_path,openEmojiDialog,openDialog,closeEmojiDialog,handleRadioChange,closePost,closeFeeds">
        <div class="loader-overlay">
            <div class="loader">
                <div></div>
            </div>
            
        </div>
    </div>
<div class="px-4 " style="position: relative;">


<div class="col-md-12  mt-1" style="height:60px;">

<div class="row bg-white rounded border py-1 d-flex align-items-center">
                <div class="d-flex mt-2 flex-row align-items-center row m-0">
                    <div class="align-items-center col-md-10 d-flex gap-2 mb-2">
                        <div class="d-flex align-items-center">
                            @if(auth('emp')->check() || auth('hr')->check())
                            @php
                            // Determine the employee ID based on the authentication guard
                            $empEmployeeId = auth('emp')->check() ? auth('emp')->user()->emp_id : auth('hr')->user()->hr_emp_id;

                            // Fetch the employee details from EmployeeDetails model
                            $employeeDetails = \App\Models\EmployeeDetails::where('emp_id', $empEmployeeId)->first();
                            @endphp

                            @if(($employeeDetails->image) && $employeeDetails->image !== 'null')
                            <img class="navProfileImgFeeds rounded-circle" src="data:image/jpeg;base64,{{ ($employeeDetails->image) }}">
                            @else
                            @if($employeeDetails && $employeeDetails->gender == "Male")
                            <img class="navProfileImgFeeds rounded-circle" src="{{asset("images/male-default.png")}}" alt="Default Male Image">
                            @elseif($employeeDetails && $employeeDetails->gender == "Female")
                            <img class="navProfileImgFeeds rounded-circle" src="{{asset("images/female-default.jpg")}}" alt="Default Female Image">
                            @else
                            <img class="navProfileImgFeeds rounded-circle" src="{{asset("images/user.jpg")}}" alt="Default Image">
                            @endif
                            @endif
                            @else
                            <p>User is not authenticated.</p>
                            @endif
                        </div>
                        <div class="drive-in  justify-content-center align-items-start">
                            <span class="text-feed ">Hey {{ ucwords(strtolower(auth()->guard('emp')->user()->first_name)) }} {{ ucwords(strtolower(auth()->guard('emp')->user()->last_name)) }}</span>
                            <p class="text-xs mb-0">Ready to dive in?</p>
                        </div>
                    </div>
                    <div class="align-items-center col-md-2 createpost d-flex ms-auto">
                        <!-- <button wire:click="addFeeds" class="ms-auto btn-post flex flex-col justify-center items-center group w-20 p-1 rounded-md border border-purple-200">
                            <div class="w-6 h-6 rounded bg-purple-200 flex justify-center items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file stroke-current group-hover:text-purple-600 stroke-1 text-purple-400">
                                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                    <polyline points="13 2 13 9 20 9"></polyline>
                                </svg>
                            </div>
                            <div class="row mt-1">
                                <div class="text-left text-xs ms-1 text-center" wire:click="addFeeds">Create Posts</div>
                            </div>
                        </button> -->
                    </div>
                </div>
                <div class=" mt-2 bg-white d-flex align-items-center ">
                    <div class="d-flex ms-auto">
                    @if($showFeedsDialog)
<div class="modal" tabindex="-1" role="dialog" style="display: block;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <p class="mb-0">Create a Post</p>
                <span class="img d-flex align-items-end">
                    <img src="{{ asset('images/Posts.jpg') }}" class="img rounded custom-height-30">
                </span>
            </div>

            <div>
            <form wire:submit.prevent="submit" enctype="multipart/form-data">
    <div class="modal-body" style="padding: 20px; width: 80%;"> 

        <!-- Category Selection -->
        <div class="form-group mb-15">
            <label for="category">You are posting in:</label>
            <select wire:model.lazy="category" class="form-select" id="category">
                <option value="" hidden>Select Category</option>
                <option value="Appreciations">Appreciations</option>
                <option value="Companynews">Company News</option>
                <option value="Events">Events</option>
                <option value="Everyone">Everyone</option>
                <option value="Hyderabad">Hyderabad</option>
                <option value="US">US</option>
            </select>
            @error('category') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Quill Editor -->
        <div class="row mt-3">
            <label for="description">Write something here:</label>
        </div>
        <div id="quill-toolbar-container" style="margin-top:10px;background:#F7F7F7">
            <div id="quill-toolbar" class="ql-toolbar ql-snow">
                <span class="ql-formats">
                    <button type="button" onclick="execCmd('bold')"><b>B</b></button>
                    <button type="button" onclick="execCmd('italic')"><i>I</i></button>
                    <button type="button" onclick="execCmd('underline')"><u>U</u></button>
                    <button type="button" onclick="execCmd('strikeThrough')"><s>S</s></button>
                    <button type="button" onclick="execCmd('insertUnorderedList')" style="display: inline-flex; align-items: center; gap: 5px;">
                        <i class="fas fa-list-ul"></i>
                    </button>
                    <button type="button" onclick="execCmd('insertOrderedList')">  <i class="fas fa-list-ol"></i></button>
                    <button type="button" onclick="insertVideo()">🎥</button>

                </span>
            </div>
        </div>
        <!-- Content Editable div with wire:ignore -->
        <div 
                                id="richTextEditor" 
                                contenteditable="true"
                                wire:ignore
                                class="form-control" 
                                style="border: 1px solid #ccc; border-radius: 6px; padding: 10px; min-height: 150px; background-color: #fff;"
                                oninput="updateDescription(this.innerHTML)">
                                {!! $description !!}
                            </div>



        @error('description') 
            <span class="text-danger">{{ $message }}</span> 
        @enderror
        <div class="form-group mt-3">
            <label for="file_path">Upload Attachment:</label>
            <div style="text-align: start;">
                <input type="file" wire:model="file_path" class="form-control" id="file_path" style="margin-top: 5px">
                @error('file_path') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

    </div>
    


   
    <!-- Submit & Cancel Buttons -->
    <div class="modal-footer border-top">
        <div class="d-flex justify-content-center w-100">
            <button type="submit" class="submit-btn">Submit</button>
            <button type="button" wire:click="closeFeeds" class="cancel-btn1 ms-2">Cancel</button>
        </div>
    </div>
</form>




    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="alert alert-success mt-3">{{ session('message') }}</div>
    @endif
</div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif
                    </div>
                </div>
            </div>

    <!-- Additional row -->
    <div class="row mt-2 d-flex">

        <div class="col-md-3 feeds-custom-menu bg-white p-3">

            <p class="feeds-left-menu">Filters</p>
            <hr style="width: 100%;border-bottom: 1px solid grey;">


            <p class="feeds-left-menu">Activities</p>
            <div class="activities">
                <label class="custom-radio-label">
                    <input type="radio" name="radio" value="activities" checked data-url="/Feeds" wire:click="handleRadioChange('activities')">
                    <div class="feed-icon-container" style="margin-left: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file stroke-current text-purple-400 stroke-1">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <rect x="7" y="7" width="3" height="9"></rect>
                            <rect x="14" y="7" width="3" height="5"></rect>
                        </svg>
                    </div>
                    <span class="custom-radio-button bg-blue"></span>
                    <span class="custom-radio-content ">All Activities</span>
                </label>
            </div>


            <div class="posts">
                <label class="custom-radio-label">

                    <input type="radio" id="radio-hr" name="radio" value="posts" data-url="/everyone" wire:click="handleRadioChange('posts')">

                    <div class="feed-icon-container" style="margin-left: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file stroke-current text-purple-400 stroke-1">
                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                            <polyline points="13 2 13 9 20 9"></polyline>
                        </svg>
                    </div>
                    <span class="custom-radio-button bg-blue"></span>
                    <span class="custom-radio-content ">Posts</span>
                </label>
            </div>
            @if($isManager)
            <div class="post-requests">
                <label class="custom-radio-label">

                    <input type="radio" id="radio-emp" name="radio" value="post-requests" data-url="/emp-post-requests" wire:click="handleRadioChange('post-requests')">

                    <div class="feed-icon-container" style="margin-left: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file stroke-current text-purple-400 stroke-1" style="width: 1rem; height: 1rem;">
                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                            <polyline points="13 2 13 9 20 9"></polyline>
                        </svg>
                    </div>
                    <span class="custom-radio-button bg-blue"></span>
                    <span class="custom-radio-content ">Post Requests</span>
                </label>
            </div>
            @endif


            <hr style="width: 100%;border-bottom: 1px solid grey;">
            <div>
                <div class="row" style="max-height:auto">
                    <div class="col " style="margin: 0px;">
                        <div class="input-group">
                            <input wire:model="search" id="filterSearch" onkeyup="filterDropdowns()" id="searchInput"
                                type="text"
                                class="form-control task-search-input placeholder-small"
                                placeholder="Search...."
                                aria-label="Search"
                                aria-describedby="basic-addon1">
                            <button class="helpdesk-search-btn" type="button">
                                <i style="text-align: center;color:white;margin-left:10px" class="fa fa-search"></i>
                            </button>

                        </div>
                    </div>
                </div>
                <div class="w-full visible mt-1 custom-dropdown ">
                    <div class="cus-button" onclick="toggleDropdown('dropdownContent1', 'arrowSvg1')">
                        <span class="text-base leading-4">Groups</span>
                        <span class="arrow-icon" id="arrowIcon1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down h-1.2x w-1.2x text-secondary-400" id="arrowSvg1" style="color:#3b4452;margin-top:-5px">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </span>
                    </div>
                    <div id="dropdownContent1" class="Feeds-Dropdown">
                        <ul class="d-flex flex-column m-0 p-0">
                            <a class="menu-item" href="/Feeds">All Feeds</a>

                            <a class="menu-item" href="/everyone">Every One</a>

                            <a class="menu-item" href="/Feeds">Events</a>

                            <a class="menu-item" href="/everyone">Company News</a>

                            <a class="menu-item" href="/everyone">Appreciation</a>


                            <a class="menu-item" href="/everyone">Buy/Sell/Rent</a>

                        </ul>
                    </div>
                </div>


                <div class="w-full visible custom-dropdown mt-1">
                    <div class="cus-button">
                        <span class="text-base leading-4 ">Location</span>
                        <span class="arrow-icon" id="arrowIcon2" onclick="toggleDropdown('dropdownContent2', 'arrowSvg2')" style="margin-top:-5px;color:#3b4452;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down h-1.2x w-1.2x text-secondary-400" id="arrowSvg2" style="color:#3b4452;margin-top:-5px">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </span>
                    </div>
                    <div id="dropdownContent2" class="Feeds-Dropdown">
                        <ul class="d-flex flex-column p-0 m-0">
                            <a class="menu-item" style="font-weight: 700;">India</a>


                            <a class="menu-item" href="/everyone">Adilabad</a>


     


                            <a class="menu-item" href="/everyone">Doddaballapur</a>


                            <a class="menu-item" href="/everyone">Guntur</a>

                            <a class="menu-item" href="/everyone">Hoskote</a>

                            <a class="menu-item" href="/everyone">Hyderabad</a>

                            <a class="menu-item" href="/everyone">Mandya
                            </a>

                            <a class="menu-item" href="/everyone">Mangalore
                            </a>

                            <a class="menu-item" href="/everyone">Mumbai
                            </a>


                            <a class="menu-item" href="/everyone">Mysore
                            </a>

                            <a class="menu-item" href="/everyone">Pune
                            </a>

                            <a class="menu-item" href="/everyone">Sirsi
                            </a>

                            <a class="menu-item" href="/everyone">Thumkur
                            </a>

                            <a class="menu-item" href="/everyone">Tirupati</a>

                            <a class="menu-item" href="/everyone">Trivandrum</a>

                            <a class="menu-item" href="/everyone">Udaipur</a>

                            <a class="menu-item" href="/everyone">Vijayawada</a>

                            <a class="menu-item" style="font-weight: 700;">USA</a>

                            <a class="menu-item" href="/everyone">California</a>

                            <a class="menu-item" href="/everyone">New York</a>

                            <a class="menu-item" href="/everyone">Hawaii</a>


                        </ul>
                    </div>
                </div>
                <div class="w-full visible mt-1 custom-dropdown ">
                    <div class="cus-button">
                        <span class="text-base leading-4">Department</span>
                        <span class="arrow-icon" id="arrowIcon3" onclick="toggleDropdown('dropdownContent3', 'arrowSvg3')" style="margin-top:-5px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down h-1.2x w-1.2x text-secondary-400" id="arrowSvg3" style="color:#3b4452;">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </span>
                    </div>
                    <div id="dropdownContent3" class="Feeds-Dropdown">
                        <ul class="d-flex flex-column" style="font-size: 12px; margin: 0; padding: 0;">

                            <a class="menu-item" href="/everyone">HR</a>




                            <a class="menu-item" href="/everyone">Operations</a>


                            <a class="menu-item" href="/everyone">Production Team</a>


                            <a class="menu-item" href="/everyone">QA</a>


                            <a class="menu-item" href="/everyone">Sales Team</a>


                            <a class="menu-item" href="/everyone">Testing Team</a>

                        </ul>
                    </div>
                </div>

            </div>
        </div>
      
        <div class="col-md-9">
    <div class="row align-items-center">
        <div class="col-md-5" style="justify-content: flex-start; display: flex">
            <div style="width: 2px; height: 40px; background-color: #97E8DF; margin-right: 10px;"></div>
            <gt-heading _ngcontent-eff-c648="" size="md" class="ng-tns-c648-2 hydrated"></gt-heading>
            <div class="medium-header border-cyan-200" style="margin-left: -1px; color: #3b4452">Post Requests</div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="eventsSection">
            @if($isManager)
                @if($posts->where('status', 'Pending')->isEmpty())
                    <img src="https://freesvg.org/img/request.png" alt="Empty Image" style="width: 250px; height: auto; display: block;">
                    <p class="text-feed">It feels empty here!</p>
                    <p class="text-xs">Your feed is still in making as there's no post requests to show.</p>
                @else
                    <div class="col-md-12 feeds-main-content">
                        @foreach($posts->where('status', 'Pending') as $post)
                            <div class="col-md-9 bg-white" style="border-radius: 5px; border: 1px solid #ccc; height: auto; margin-top: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                <div class="row mt-2 align-items-center">
                                    <!-- Company Logo -->
                                    <div class="col-12 col-md-4 text-center mb-2 mb-md-0">
                                        <img src="data:image/jpeg;base64,{{ $empCompanyLogoUrl }}" 
                                             alt="Company Logo" 
                                             class="img-fluid" 
                                             style="max-width: 120px;">
                                    </div>
                                    <!-- Timestamp -->
                                    <div class="col-12 col-md-7 text-md-end text-center mt-1" style="font-size: 12px;">
                                        {{ $post->updated_at->diffForHumans() }}
                                    </div>
                                </div>

                                <div class="row m-2">
                                    <div class="col-12 col-md-6" style="font-size: 12px;">
                                        @if($post->employeeDetails)
                                            Employee Name: {{ $post->employeeDetails->first_name }} {{ $post->employeeDetails->last_name }}
                                        @else
                                            No employee details found for this post.
                                        @endif
                                    </div>
                                    <div class="col-12 col-md-6" style="font-size: 12px;">
                                        Employee ID: {{ $post->emp_id }}
                                    </div>
                                </div>

                                <div class="row m-2">
                                    <div class="col-12 col-md-6" style="font-size: 12px;">
                                        Category: {{ $post->category }}
                                    </div>
                                 
                                </div>
                                <div class="row m-2">
                                <div class="col-11 " style="font-size: 12px;">
                                        Description:  <br> {!! $post->description !!}
                                    </div>
                                </div>

                                <div class="row m-2 align-items-center">
                                    <div class="col-12 col-md-5" style="font-size: 12px;">
                                        @if ($post->getImageUrlAttribute())
                                            <a href="#" wire:click.prevent="showImage('{{ $post->getImageUrlAttribute() }}')" style="text-decoration: none; color: #007BFF;">
                                                View Image
                                            </a>
                                        @endif
                                    </div>
                                    <div class="col-6 col-md-7 d-flex align-items-center" style="font-size: 12px;">
                                        <div>
                                            @if($post->status !== 'Rejected')
                                                <button class="cancel-btn" wire:click="rejectPost('{{ $post->id }}')">Reject</button>
                                            @endif
                                        </div>
                                        <div>
                                            @if($post->status !== 'Closed')
                                                <button class="post-button" wire:click="closePost('{{ $post->id }}')">Approve</button>
                                            @else
                                                <button disabled>Closed</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal for viewing image -->
                                @if ($showImageDialog)
                                    <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title viewfile">View File</h5>
                                                </div>
                                                <div class="modal-body text-center">
                                                    @if ($imageUrl)
                                                        <img src="{{ $imageUrl }}" alt="File" class="img-fluid" style="max-width: 100%;" />
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="submit-btn" wire:click.prevent="downloadImage">Download</button>
                                                    <button type="button" class="cancel-btn1" wire:click="closeImageDialog">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-backdrop fade show blurred-backdrop"></div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
    </div>

</div>

                 


    

</div>
            
            </div>
        
            <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script> -->
<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>

@push('scripts')
<script>
    Livewire.on('updateSortType', sortType => {
        Livewire.emit('refreshComments', sortType);
    });
</script>
@endpush
<script>
    function handleRadioChange(element) {
        const url = element.getAttribute('data-url');
        window.location.href = url;
    }
</script>


<script>
     function handleImageChange() {
        // Display a flash message
        showFlashMessage('File uploaded successfully!');
    }

    function showFlashMessage(message) {
        const container = document.getElementById('flash-message-container');
        container.textContent = message;
        container.style.fontSize = '0.75rem';
        container.style.display = 'block';

        // Hide the message after 3 seconds
        setTimeout(() => {
            container.style.display = 'none';
        }, 3000);
    }

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
    document.addEventListener('livewire:update', function() {
        document.querySelectorAll('.emoji-trigger').forEach(trigger => {
            trigger.addEventListener('click', function() {
                var index = this.dataset.index;
                var emojiList = document.getElementById('emoji-list-' + index);
                emojiList.style.display = (emojiList.style.display === "none" || emojiList.style.display === "") ? "block" : "none";
            });
        });
});
    function showEmojiList(index, cardId) {
        var emojiList = document.getElementById('emoji-list-' + index);
        if (emojiList.style.display === "none" || emojiList.style.display === "") {
            emojiList.style.display = "block";
        } else {
            emojiList.style.display = "none";
        }
    }

    function comment(index, cardId) {
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
  document.addEventListener('DOMContentLoaded', function() {
    // Get all radio buttons with name="radio"
    var radios = document.querySelectorAll('input[name="radio"]');

    // Add change event listener to each radio button
    radios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            var url = this.dataset.url; // Get the data-url attribute
            if (url) {
                window.location.href = url; // Redirect to the URL
            }
        });
    });
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


        // Ensures the corresponding radio button is selected based on current URL
     
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
    function createcomment(comment, empId, index) {
        // Your existing logic to select an emoji

        // Toggle the emoji list visibility using the showEmojiList function
        comment();
    }
    // Function to show the emoji list when clicking on the smiley emoji
    function comment(index, cardId) {
        var div = document.getElementById('replyDiv_' + index);
        if (div.style.display === 'none') {
            div.style.display = 'flex';
        } else {
            div.style.display = 'none';
        }
    }
</script>
<script>
    function add_comment(comment, empId, index) {
        // Your existing logic to select an emoji

        // Toggle the emoji list visibility using the showEmojiList function
        comment();
    }
    // Function to show the emoji list when clicking on the smiley emoji
    function comment(index, cardId) {
        var div = document.getElementById('replyDiv_' + index);
        if (div.style.display === 'none') {
            div.style.display = 'flex';
        } else {
            div.style.display = 'none';
        }
    }
</script>
<script>
    function selectEmoji(emoji, empId, index) {
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
    function addEmoji(emoji_reaction, empId, cardId) {
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
    window.addEventListener('post-creation-failed', event => {
        alert('Employees do not have permission to create a post.');
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
    document.querySelectorAll('.custom-radio-label a').forEach(link => {
        link.addEventListener('click', function(e) {
            // Ensure no preventDefault() call is here unless necessary for custom handling
        });
    });
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

<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

<!-- Quill.js JS -->
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>







<script>
    function execCmd(command) {
        document.execCommand(command, false, null);
    }

    function updateDescription(content) {
        @this.set('description', content); // Update Livewire description property
    }
    function insertVideo() {
    const url = prompt('Enter YouTube Video URL:');
    if (url) {
        // Match standard YouTube or shortened URLs
        const match = url.match(/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/);
        if (match && match[1]) {
            const embedUrl = `https://www.youtube.com/embed/${match[1]}`;
            const iframe = `<iframe src="${embedUrl}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="width:50%; height:200px;"></iframe>`;
            document.execCommand('insertHTML', false, iframe);
        } else {
            alert('Invalid YouTube URL. Please use a valid link.');
        }
    }
}



</script>
<script>
    function filterDropdowns() {
        var input, filter, dropdownContents, dropdownContent, menuItems, a, i, j, hasMatch;
        input = document.getElementById('filterSearch');
        filter = input.value.toUpperCase();

        // Select all dropdown content elements
        dropdownContents = [
            document.getElementById('dropdownContent1'),
            document.getElementById('dropdownContent2'),
            document.getElementById('dropdownContent3')
        ];

        // Loop through each dropdown content
        dropdownContents.forEach(function(dropdownContent) {
            menuItems = dropdownContent.getElementsByTagName('a');
            hasMatch = false; // Reset match flag

            // Loop through all menu items and hide/show based on the filter
            for (j = 0; j < menuItems.length; j++) {
                a = menuItems[j];
                if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    a.style.display = ""; // Show matching item
                    hasMatch = true; // Found a match
                } else {
                    a.style.display = "none"; // Hide non-matching item
                }
            }

            // Show dropdown if there's at least one matching item
            dropdownContent.style.display = hasMatch ? "block" : "none"; // Show or hide based on match
        });
    }
</script>
</div>
        </div>