<div class="px-4">
<div class="container mt-3" style="height:60px;">
    <div class="row bg-white border rounded" style="height:80px">
        <div class="col-md-1 mt-3" style="height:60px">
            @foreach($employeeDetails as $employee)
            @if($employee->image)
                <img style="border-radius: 50%; margin-left: 10px" height="50" width="50" src="{{ asset('storage/' . $employee->image) }}">
                @else
                    <img style="border-radius: 50%; margin-left: 10px" height="50" width="50" src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" alt="Default Image">
                @endif
            @endforeach
        </div>
        <div class="col-md-10 mt-2 bg-white d-flex align-items-center justify-content-between">
            <div>
                @if(Auth::check())
                <span class="text-base">Hey {{ ucwords(strtolower(Auth::user()->first_name)) }} {{ ucwords(strtolower(Auth::user()->last_name)) }}</span>
                @else
                <p>No employee details available.</p>
                @endif
                <div class="text-xs">Ready to dive in?</div>
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
            <!-- Modal -->
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                    <h5 class="modal-title">Creating a Post</h5>
                    <button wire:click="closeFeeds" type="button" class="btn-close" aria-label="Close"></button>

                </div>
                        <!-- Modal Body -->
                        <form wire:submit.prevent="submit">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="category">You are posting in:</label>
                                    <select wire:model="category" class="form-select" id="category">
                                        <option value="appreciations">Appreciations</option>
                                        <option value="buy_sell_rent">Buy/Sell/Rent</option>
                                        <option value="company_news">Company News</option>
                                        <option value="events">Events</option>
                                        <option value="everyone">Everyone</option>
                                        <option value="hyderabad">Hyderabad</option>
                                        <option value="US">US</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="content">Write something here:</label>
                                    <textarea wire:model="description" class="form-control" id="content" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="attachment">Upload Attachment:</label>
                                    <input wire:model="attachment" type="file" id="attachment" class="form-control-file">
                                    @if ($attachment)
                                    <p>File: {{ $attachment->getClientOriginalName() }}</p>
                                    @endif
                                    @if ($message)
                                    <p>{{ $message }}</p>
                                    @endif
                                </div>
                            </div>
                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Post</button>
                                <button wire:click="closeFeeds" class="btn btn-secondary">Cancel</button>
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
    <div class="row mt-3 d-flex"  style="overflow-x: hidden;">
        <div class="col-md-3 bg-white p-3" style="border-radius:5px;border:1px solid silver;height:500px">

        <p style="font-weight: 400;color:grey">Filters</p>
        <hr style="width: 100%;border-bottom: 1px solid grey;">


<p style="font-weight: 400;color:grey">Activities</p>

   <div class="activities">
<label class="custom-radio-label">
  <input type="radio" name="radio" value="activities" checked>
 

  <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trello stroke-current text-salmon-400 stroke-1" style="width: 1rem; height: 1rem;margin-left:10px">
  <circle cx="12" cy="12" r="12" fill="#F9D3BF" />
  <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
    <rect x="7" y="7" width="3" height="9"></rect>
    <rect x="14" y="7" width="3" height="5"></rect>
  </svg></span>
  <span class="custom-radio-button bg-blue" style="margin-left:10px"></span>
  All Activities
</label>
</div>
<div class="posts" style="display:flex" >
<label class="custom-radio-label" style="display:flex; align-items:center;">
<input type="radio" name="radio" value="" checked><span>
    <div class="icon-containers"style="margin-left:10px"><circle cx="12" cy="12" r="12" fill="#F9D3BF" />
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file" >
    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg></div>
</span><span class="custom-radio-button bg-blue"style="margin-left:10px"></span>Posts</label></div>


 
    <hr style="width: 100%;border-bottom: 1px solid grey;">
    <div style="overflow-y:auto;max-height:300px; overflow-x: hidden;">
            <div class="row">
                        <div class="col " style="margin: 0px;">
                            <div class="input-group" >
                                <input wire:model="search" id="filterSearch" onkeyup="filterDropdowns()" style="width:80%;font-size: 10px; border-radius: 5px 0 0 5px; cursor: pointer; " type="text" class="form-control" placeholder="Search...." aria-label="Search" aria-describedby="basic-addon1">
                                    <button  style=" border-radius: 0 5px 5px 0; background-color: rgb(2, 17, 79);; color: #fff; border: none;" class="search-btn" type="button">
                                        <i style="text-align: center;" class="fa fa-search"></i>
                                    </button>
                            </div>
                        </div>
                    </div>
 
                    <div class="w-full visible mt-1" style="margin-top:20px">
    <div class="cus-button" style="display: flex; justify-content: space-between; width: 100%; padding: 0.5rem;" onclick="toggleDropdown('dropdownContent1', 'arrowSvg1')">
    <span class="text-xs leading-4" style="font-weight:bold; color: grey;">Groups</span>

        <span class="arrow-icon" id="arrowIcon1">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down h-1.2x w-1.2x text-secondary-400" id="arrowSvg1" style="color:black">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </span>
    </div>
    <div id="dropdownContent1" style="display: none;">
        <ul class="d-flex flex-column" style="font-size: 12px; line-height: 1; text-decoration: none; color:black;text-align: left; padding-left: 0;">
            <a class="menu-item" href="/Feeds" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">All Feeds</a>
            <a class="menu-item" href="/everyone" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Every One</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Events</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Company News</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Appreciation</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Buy/Sell/Rent</a>
        </ul>
    </div>
</div>

 
<div class="w-full visible mt-1" style="margin-top: 20px;">
        <div class="cus-button" style="display: flex; justify-content: space-between; width: 100%; padding: 0.5rem;">
            <span class="text-xs leading-4 " style="font-weight: bold;color:grey">Location</span>
            <span class="arrow-icon" id="arrowIcon2" onclick="toggleDropdown('dropdownContent2', 'arrowSvg2')">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down h-1.2x w-1.2x text-secondary-400" id="arrowSvg2" style="color: black;">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </span>
        </div>
        <div id="dropdownContent2" style="font-size: 12px; line-height: 1; text-decoration: none; color: black; text-align: left; padding-left: 0; display: none;">
            <ul style="font-size: 12px; margin: 0; padding: 0;">
            <b class="menu-item"  style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">India</b>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Guntur</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Hyderabad</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Doddaballapur</a>

            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Tirupati</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Vijayawada</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Adilabad</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Trivandrum</a>
            <b class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">USA</b>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">California</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;"> New York</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;"> Alaska</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Hawaii</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;"> Texas</a>
        </ul>
    </div>
</div>

<div class="w-full visible mt-1" style="margin-top: 20px;">
        <div class="cus-button" style="display: flex; justify-content: space-between; width: 100%; padding: 0.5rem;">
            <span class="text-xs leading-4 " style="font-weight: bold;color:grey">Department</span>
            <span class="arrow-icon" id="arrowIcon3" onclick="toggleDropdown('dropdownContent3', 'arrowSvg3')">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down h-1.2x w-1.2x text-secondary-400" id="arrowSvg3" style="color: black;">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </span>
        </div>
        <div id="dropdownContent3" style="font-size: 12px; line-height: 1; text-decoration: none; color: black; text-align: left; padding-left: 0; display: none;">
            <ul style="font-size: 12px; margin: 0; padding: 0;">
                          
                
            
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">HR</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Operations</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Operations Team</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">QA</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Production Team</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Technology</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Sales Team</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Testing Team</a>
           
        </ul>
    </div>
                </div>
            </div>
      


    </div>
    <div class="menu col-md-9" style="text-align: -webkit-center;max-height:100vh;overflow-y:auto;">
            <div id="eventsSection" style="margin-top: 20px; ">
                <!-- <img src="https://cdni.iconscout.com/illustration/premium/thumb/business-failure-7626119-6210566.png"
                    alt="Empty Image" style="width: 300px; height: auto; display: block;"> -->
                <p style="font-size:20px;font-weight:600">It feels empty here!</p>
                <p style="font-size:12px;color:#778899;">Your feed is still in making as there's no
                    post to show.</p>
                <button
                    style="background:#6663ea;width:110px;height:30px;border:1px solid grey;border-radius:5px;color:white;"
                    wire:click="addFeeds">Create Post</button>

            <!-- Begin the form outside the .form-group div -->
    @if($showFeedsDialog)
    <div class="modal" tabindex="-1" role="dialog" style="display: block;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Creating a Post</h5>
                   
                    <button wire:click="closeFeeds" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form wire:submit.prevent="submit">
                    <div class="modal-body">
                        <div class="form-group" style="text-align:start;e">
                            <label for="category">You are posting in:</label>
                            <select wire:model="category" class="form-select" id="category">
                                <option value="appreciations">Appreciations</option>
                                <option value="buy_sell_rent">Buy/Sell/Rent</option>
                                <option value="company_news">Company News</option>
                                <option value="events">Events</option>
                                <option value="everyone">Everyone</option>
                                <option value="everyone">Hyderabad</option>
                                <option value="everyone">US</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="content">Write something here:</label>
                            <textarea wire:model="description" class="form-control" id="content" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="attachment">Upload Attachment:</label>
                            <input wire:model="attachment" type="file" id="attachment" class="form-control-file">
                            @if ($attachment)
                                <p>File: {{ $attachment->getClientOriginalName() }}</p>
                            @endif
                            @if ($message)
                                <p>{{ $message }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Post</button>
                        <button wire:click="closeFeeds" class="btn btn-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
@endif
    </div>
    @foreach($posts as $post)
            <div class="col-md-6 ">
                <!-- Upcoming Birthdays List -->
                <div class="F"
                    style="background-color: white; border-radius: 5px; border: 1px solid #CFCACA; color: #3b4452; margin-top: 20px;">
                    <div class="m-0 mb-3 mt-3 row">
                        <div class="col-6" style="text-align: left;">
                                @livewire('company-logo')
                        </div>
                        <div class="col-6 m-auto"
                            style="font-size: 13px; font-weight: normal;  font-weight: 100px; color: #9E9696;text-align:end;">
                            {{ $post->category }}
                        </div>
                    </div>
                    <div class="row m-0 mb-3">
                        @php
                        $employee = \App\Models\EmployeeDetails::where('emp_id', $post->emp_id)->first();
                        @endphp
                        @if($employee)
                        <div class="col-3">
                            @if($employee->image)

                            <img style="border-radius: 50%;" height="50" width="50"
                                src="{{ asset('storage/'. $employee->image) }}">
                            @else
                                <div class="employee-profile-image-container" >
                                    <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" class="employee-profile-image-placeholder" style="border-radius:50%;" height="35px" width="35px" alt="Default Image">
                                </div>
                            @endif
                        </div>
                        <div class="col-9 m-auto" style="text-align: left">
                        <p class="text-base m-0" style="margin-left: 20px; font-size: 12px;">
    {{ ucwords(strtolower($employee->first_name)) }} {{ ucwords(strtolower($employee->last_name)) }}
</p>

                        </div>
                        @else
                        <p>No employee details available.</p>
                        @endif
                    </div>


                    <div class="row m-0 mb-3">
                        <div class="col-md-6">
                        <img src="{{ asset('storage/' . $post->attachment) }}" alt="" style="width: 200px; height: 60px">
                        </div>
                        <div class="col-md-6 m-auto">
                            <p style="font-size: 12px; margin-top: 10px; font-weight: 100; color: #677A8E;">
                                {{ $post->description }}
                            </p>
                        </div>

                    </div>
                    <confirmation-modal class="confirmation-modal">
                        <gt-popup-modal label="modal" size="sm" class="hydrated">
                            <div class="body-content">
                                <div slot="modal-body">
                                    <!-- Content for modal body -->
                                </div>
                            </div>
                            <div slot="modal-footer">
                                <div class="flex justify-end">
                                    <gt-button shade="secondary" name="Cancel" class="mr-2x hydrated"></gt-button>
                                    <gt-button shade="primary" name="Confirm" class="hydrated"></gt-button>
                                </div>
                            </div>
                        </gt-popup-modal>
                    </confirmation-modal>
                    <!-- Like Button -->

                </div>
            </div>

            @endforeach
     


 

    </div>

  
 

    
    <style>
  /* Define the blue background color for the checked state */
  .input[type="radio"]:checked + .custom-radio-button {
    background-color: blue;
  }
  .feather {
  display: inline-block;
  vertical-align: middle;
}

.text-salmon-400 {
  fill: salmon; /* Change the color as needed */
}

.stroke-1 {
  stroke-width: 1px; /* Adjust the stroke width as needed */
}
.icon-container {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-left: 2px;
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background-color: #D8D8D8; /* You can change this to any desired background color */
}

.feather {
  width: 1rem;
  height: 1rem;
  color: #6B46C1; /* You can change this to any desired icon color */
}

.activities:hover{
    background-color: #e1e7f0;
      height: 30px;
      width: 100%;
}

.posts:hover{
    background-color: #e1e7f0;
      height: 30px;
      width: 100%;
}
</style>
   <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script> -->
<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
    <script>
 document.addEventListener('livewire:load', function () {
        // Listen for clicks on emoji triggers and toggle the emoji list
        document.querySelectorAll('.emoji-trigger').forEach(trigger => {
            trigger.addEventListener('click', function () {
                var index = this.dataset.index;
                var emojiList = document.getElementById('emoji-list-' + index);
                emojiList.style.display = (emojiList.style.display === "none" || emojiList.style.display === "") ? "block" : "none";
            });
        });
    })

        // Hide emoji list when an emoji is selected
        document.querySelectorAll('.emoji-option').forEach(option => {
            option.addEventListener('click', function () {
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
    content.addEventListener('click', function (event) {
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
        if (emojiList.style.display === "none" ) {
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
        if (emojiList.style.display === "none" ) {
            emojiList.style.display = "block";
        } else {
            emojiList.style.display = "none";
        }
    }
  


</script>


<style>
 /* Define CSS for the menu items */
.menu-item {
    transition: background-color 0.3s ease;
}

/* Define CSS for the menu items on hover */
.menu-item:hover {
    background-color: #e1e7f0;
    height: 30px;
    width: 130%;
}

/* CSS for radio-wrapper */
.radio-wrapper {
    display: inline-block;
    margin-right: 10px; /* Adjust margin as needed */
    cursor: pointer;
}

/* CSS for labels */
.radio-label {
    display: inline-block;
    padding: 8px 12px; /* Adjust padding as needed */
    border-radius: 4px; /* Rounded corners */
    transition: background-color 0.3s ease; /* Smooth transition */
}

/* CSS for label hover effect */
.radio-label:hover {
    background-color: #e1e7f0; /* Change background color on hover */
}

/* CSS for when radio button is checked */
.input[type="radio"]:checked + .radio-label {
    background-color: #e1e7f0; /* Change background color when checked */
}

/* Ensure radio button and text remain on the same line */
input[type="radio"] {
    vertical-align: middle;
}

/* Add this CSS to your main CSS file or in your Livewire component's style tag */
:root {
  --e-color-border: #e1e1e1;
  --e-color-emoji-text: #666;
  --e-color-border-emoji-hover: #e1e1e1;
  --e-color-bg: #fff;
  --e-bg-emoji-hover: #f8f8f8;
  --e-size-emoji-text: 16px;
  --e-width-emoji-img: 20px;
  --e-height-emoji-img: 20px;
  --e-max-width: 288px;
}

</style>



<script>
    document.addEventListener('livewire:load', function () {
        // Listen for clicks on emoji triggers and toggle the emoji list
        document.querySelectorAll('.emoji-trigger').forEach(trigger => {
            trigger.addEventListener('click', function () {
                var index = this.dataset.index;
                var emojiList = document.getElementById('emoji-list-' + index);
                emojiList.style.display = (emojiList.style.display === "none" || emojiList.style.display === "") ? "block" : "none";
            });
        });

        // Hide emoji list when an emoji is selected
        document.querySelectorAll('.emoji-option').forEach(option => {
            option.addEventListener('click', function () {
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
document.addEventListener('livewire:load', function () {
    const el = new EmojiPopover({
        button: '.picker',
        targetElement: '.emoji-picker',
        emojiList: [
            {
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
    document.querySelector('.picker').addEventListener('click', function () {
        el.toggle();
    });
});
</script>
@endpush

</div>
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

</div>