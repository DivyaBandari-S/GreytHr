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

    <div class="row bg-white rounded border d-flex" style="height:70px;">
        <div class="d-flex flex-row">


        <div class=" mt-1 h-60">
                        @if(auth('emp')->check() || auth('hr')->check())
                        @php
                        // Determine the employee ID based on the authentication guard
                        $empEmployeeId = auth('emp')->check() ? auth('emp')->user()->emp_id : auth('hr')->user()->hr_emp_id;

                        // Fetch the employee details from EmployeeDetails model
                        $employeeDetails = \App\Models\EmployeeDetails::where('emp_id', $empEmployeeId)->first();
                        @endphp

                        @if(($employeeDetails->image) && $employeeDetails->image !== 'null')
                        <img style="border-radius: 50%; " height="50" width="50" src="data:image/jpeg;base64,{{ ($employeeDetails->image) }}">
                        @else
                        @if($employeeDetails && $employeeDetails->gender == "Male")
                        <img style="border-radius: 50%; " height="50" width="50" src="{{asset("images/male-default.png")}}" alt="Default Male Image">
                        @elseif($employeeDetails && $employeeDetails->gender == "Female")
                        <img style="border-radius: 50%; " height="50" width="50" src="{{asset("images/female-default.jpg")}}" alt="Default Female Image">
                        @else
                        <img style="border-radius: 50%; " height="50" width="50" src="{{asset("images/user.jpg")}}" alt="Default Image">
                        @endif
                        @endif
                        @else
                        <p>User is not authenticated.</p>
                        @endif
                    </div>
            <div class="drive-in  justify-content-center mt-2">

                <span class="text-feed mt-1">Hey {{ ucwords(strtolower(auth()->guard('emp')->user()->first_name)) }} {{ ucwords(strtolower(auth()->guard('emp')->user()->last_name)) }}</span>



                <p class="text-xs">Ready to dive in?</p>
            </div>
            <div class="d-flex align-items-center ms-auto createpost">
                <button wire:click="addFeeds" class="btn-post flex flex-col justify-between items-start group w-20  p-1 rounded-md border border-purple-200">
                    <div class="w-6 h-6 rounded bg-purple-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file stroke-current group-hover:text-purple-600 stroke-1 text-purple-400">
                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                            <polyline points="13 2 13 9 20 9"></polyline>
                        </svg>
                    </div>
                    <div class="row mt-1">
                        <div class="text-left text-xs ms-1" wire:click="addFeeds">Create Posts</div>
                    </div>

                </button>
            </div>
        </div>
        <div class=" mt-2 bg-white d-flex align-items-center ">

            <div class="d-flex ms-auto">


                @if($showFeedsDialog)
                <div class="modal" tabindex="-1" role="dialog" style="display: block; ">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-between align-items-center">
                                <p class="mb-0">Create a post</p>
                                <span class="img d-flex align-items-end">
                                    <img src="{{ asset('images/Posts.jpg') }}" class="img rounded custom-height-30">
                                </span>
                            </div>



                            @if(Session::has('error'))
                            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert"
                                style="font-size: 0.875rem; width: 90%; margin: 10px auto; padding: 10px; border-radius:4px; background-color: #f8d7da; color: #721c24;">
                                {{ Session::get('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="margin-left: 10px;margin-top:-5px"></button>
                            </div>
                            @endif
                            <form wire:submit.prevent="submit" enctype="multipart/form-data">
                                <div class="modal-body" style="padding: 20px;">
                                    <!-- Category Selection -->
                                    <div class="form-group mb-15">
                                        <label for="category">You are posting in:</label>
                                        <select wire:model.lazy="category" class="form-select" id="category">
                                            <option value="">Select Category</option>
                                            <option value="Appreciations">Appreciations</option>
                                         
                                            <option value="Companynews">Company News</option>
                                            <option value="Events">Events</option>
                                            <option value="Everyone">Everyone</option>
                                            <option value="Hyderabad">Hyderabad</option>
                                            <option value="US">US</option>
                                        </select>
                                        @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Description Input -->
                                    <div class="form-group mt-1">
                                        <label for="content">Write something here:</label>
                                        <textarea wire:model.lazy="description" class="form-control" id="content" rows="2" style="border: 1px solid #ccc; border-radius: 4px; padding: 10px; font-size: 0.875rem; resize: vertical; width: 100%; margin-left: -250px; margin-top: 5px" placeholder="Enter your description here..."></textarea>
                                        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <!-- File Input -->
                                    <div id="flash-message-container" style="display: none;margin-top:10px" class="alert alert-success"
                                        role="alert"></div>
                                    <!-- File Upload -->
                                    <div class="form-group mt-1">
                                        <label for="file_path">Upload Attachment:</label>
                                        <div style="text-align: start;">


                                            <input type="file" wire:model="file_path" class="form-control" id="file_path" style="margin-top:5px" onchange="handleImageChange()">
                                            @error('file_path') <span class="text-danger">{{ $message }}</span> @enderror

                                            <!-- Success Message -->


                                        </div>
                                    </div>
                                </div>

                                <!-- Submit & Cancel Buttons -->
                                <div class="modal-footer border-top">
                                    <div class="d-flex justify-content-center w-100">
                                        <button type="submit" wire:target="file_path" wire:loading.attr="disabled" class="submit-btn">Submit</button>
                                        <button wire:click="closeFeeds" type="button" class="cancel-btn1 ms-2">Cancel</button>
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
                                class="form-control placeholder-small"
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

                            <a class="menu-item" href="/events">Every One</a>

                            <a class="menu-item" href="/Feeds">Events</a>

                            <a class="menu-item" href="/events">Company News</a>

                            <a class="menu-item" href="/events">Appreciation</a>


                            <a class="menu-item" href="/events">Buy/Sell/Rent</a>

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


                            <a class="menu-item" href="/events">Adilabad</a>


     


                            <a class="menu-item" href="/events">Doddaballapur</a>


                            <a class="menu-item" href="/events">Guntur</a>

                            <a class="menu-item" href="/events">Hoskote</a>

                            <a class="menu-item" href="/events">Hyderabad</a>

                            <a class="menu-item" href="/events">Mandya
                            </a>

                            <a class="menu-item" href="/events">Mangalore
                            </a>

                            <a class="menu-item" href="/events">Mumbai
                            </a>


                            <a class="menu-item" href="/events">Mysore
                            </a>

                            <a class="menu-item" href="/events">Pune
                            </a>

                            <a class="menu-item" href="/events">Sirsi
                            </a>

                            <a class="menu-item" href="/events">Thumkur
                            </a>

                            <a class="menu-item" href="/events">Tirupati</a>

                            <a class="menu-item" href="/events">Trivandrum</a>

                            <a class="menu-item" href="/events">Udaipur</a>

                            <a class="menu-item" href="/events">Vijayawada</a>

                            <a class="menu-item" style="font-weight: 700;">USA</a>

                            <a class="menu-item" href="/events">California</a>

                            <a class="menu-item" href="/events">New York</a>

                            <a class="menu-item" href="/events">Hawaii</a>


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

                            <a class="menu-item" href="/events">HR</a>




                            <a class="menu-item" href="/events">Operations</a>


                            <a class="menu-item" href="/events">Production Team</a>


                            <a class="menu-item" href="/events">QA</a>


                            <a class="menu-item" href="/events">Sales Team</a>


                            <a class="menu-item" href="/events">Testing Team</a>

                        </ul>
                    </div>
                </div>

            </div>
        </div>
   
    <div class="col-md-9 m-0" style="max-height: 100vh; overflow-y: auto;scroll-behavior: smooth;">
                    <div class="row align-items-center ">
                        <div class="col-md-5" style=" justify-content: flex-start;display:flex">
                            <div style="width: 2px; height: 40px; background-color: #97E8DF; margin-right: 10px;"></div>
                            <gt-heading _ngcontent-eff-c648="" size="md" class="ng-tns-c648-2 hydrated"></gt-heading>
                            <div class="medium-header border-cyan-200" style="margin-left:-1px">Post Requests</div>
                        </div>

                 


                    </div>
                    <div class="col-md-12">

                    <div id="eventsSection" class="eventsSection">
                    @if($isManager)    
                    @if($posts->where('status', 'Pending')->isEmpty())
                        <img src="https://freesvg.org/img/request.png" alt="Empty Image" style="width: 250px; height: auto; display: block;">
                        <p class="text-feed">It feels empty here!</p>
                        <p class="text-xs">Your feed is still in making as there's no post requests to show.</p>
                  

                    </div>

                    @else
                   
                    @foreach($posts->where('status', 'Pending') as $post)

                    <div class="col-md-12 bg-white" style="border-radius:5px;border:1px solid #ccc;height:auto;margin-top:10px">
                         <div class="row m-2">
                            <p class="text-feed">Post Requests :</p>
                            <div class="col-md-4" style="font-size:12px;">
                               EmpID : {{ $post->emp_id }}
                               
                            </div>
                            <div class="col-md-7" style="font-size:12px">
                            @if($post->employeeDetails)
  Employee Name: {{ $post->employeeDetails->first_name }} {{ $post->employeeDetails->last_name }}
@else
 No employee details found for this post.
@endif
                               
                            </div>
                     
                            </div>
                            <div class="row m-2">
                            <div class="col-md-12 " style="font-size:12px">
                               Category : {{ $post->category }}
                               
                            </div>
                            </div>
                            <div class="row m-2">
                            <div class="col " style="font-size:12px">
                               Description : {{ $post->description }}
                               
                            </div>
                            </div>
                            <div class="row" style="display:flex">
                            <div class="col-md-5 m-2" style="font-size:12px">
                               @if ($post->getImageUrlAttribute())
                                <a href="#" wire:click.prevent="showImage('{{ $post->getImageUrlAttribute() }}')"
                                    style="text-decoration: none; color: #007BFF;margin-left:10px">
                                    View Image
                                </a>
                                @endif
                            </div>
                          
                                @if ($showImageDialog)
                            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title viewfile">View File</h5>
                    </div>
                    <div class="modal-body text-center">
                    @if ($imageUrl)
                    <img src="{{ $imageUrl }}"  alt="File" class="img-fluid" style="max-width: 100%;" />
                    @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="submit-btn"
                            wire:click.prevent="downloadImage">Download</button>
                        <button type="button" class="cancel-btn1" wire:click="closeImageDialog">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
    
@endif
                               
<div class="col-md-5 ml-2" style="font-size:12px">
<div class="row" style="display: flex; justify-content: space-between; margin-bottom: 8px;">
    @if($post->status !== 'Closed')
        <button class="post-button"
            wire:click="closePost('{{ $post->id }}')" >
            Approve
        </button>
    @else
        <button 
            disabled >
            Closed
        </button>
    @endif
</div>

            </div>  
                         </div>
                    </div>
                    </div>
                    
@endforeach

@endif
            


                    @endif




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
        </div>
        </div>
        </div>