<div>
   
    <div class="bg-white m-0  rounded-2 row">
        <div class="col-md-1 mt-2">
        @foreach($employeeDetails as $employee)

        <img style="border-radius: 50%; margin-left: 10px" height="50" width="50" src="{{ asset($employee->image) }}">

@endforeach
        </div>

        <div class="col-md-11 mt-2">
            <!-- Placeholder for avatar -->
            <p class="m-0">
            @if(Auth::check())
    <span class="text-base font-semibold">Hey {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
@else
    <p>No employee details available.</p>
@endif

                <div class="text-xs">Ready to dive in?</div>
            </p>
 
        </div>
    </div>
    <div class="m-0 row">
        <div class="col-md-3 p-0">
            <div style="background:white;border:1px solid silver;border-radius:5px;margin-top:20px;" class="p-3">
                <b>Filters</b>
 
                <hr style="background: grey; margin-top:5px">
                <div>
    <div class="radio-wrapper">
        <input type="radio" name="my-input" id="yes" value="yes" checked />
        <label class="radio-label" for="yes">All Activities</label>
    </div>
    <div class="radio-wrapper">
        <input type="radio" name="my-input" id="no" value="no" />
        <label class="radio-label" for="no">Posts</label>
    </div>
</div>


         
            <div style="overflow-y:auto;max-height:300px;">
            <div class="row">
                        <div class="col " style="margin: 0px;">
                            <div class="input-group" >
                                <input wire:model="search" style="width:80%;font-size: 10px; border-radius: 5px 0 0 5px; cursor: pointer; " type="text" class="form-control" placeholder="Search...." aria-label="Search" aria-describedby="basic-addon1">
                                    <button wire:click="starredFilter" style=" border-radius: 0 5px 5px 0; background-color: rgb(2, 17, 79);; color: #fff; border: none;" class="search-btn" type="button">
                                        <i style="text-align: center;" class="fa fa-search"></i>
                                    </button>
                            </div>
                        </div>
                    </div>
 
                    <div class="w-full visible mt-1" style="margin-top:20px">
    <div class="cus-button" style="display: flex; justify-content: space-between; width: 100%; padding: 0.5rem;" onclick="toggleDropdown('dropdownContent1', 'arrowSvg1')">
        <span class="text-xs leading-4 color-black" style="font-weight:bold">Groups</span>
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

 
<div class="w-full visible mt-1" style="margin-top:20px">
    <div class="cus-button" style="display: flex; justify-content: space-between; width: 100%; padding: 0.5rem;" onclick="toggleDropdown('dropdownContent2', 'arrowSvg2')">
        <span class="text-xs leading-4 color-black" style="font-weight:bold">Location</span>
        <span class="arrow-icon" id="arrowIcon1">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down h-1.2x w-1.2x text-secondary-400" id="arrowSvg2" style="color:black"> 
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </span>
    </div>
    <div id="dropdownContent2" style="font-size: 12px; line-height: 1; text-decoration: none; color:black;text-align: left; padding-left: 0;">
        <ul style="font-size: 12px; margin: 0; padding: 0;">
            
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Guntur</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Hyderabad</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Doddaballapur</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">USA</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Tirupati</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Vijayawada</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Adilabad</a>
            <a class="menu-item" href="/events" style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Trivandrum</a>
           
        </ul>
    </div>
</div>

<div class="w-full visible mt-1" style="margin-top:20px">
    <div class="cus-button" style="display: flex; justify-content: space-between; width: 100%; padding: 0.5rem;" onclick="toggleDropdown('dropdownContent3', 'arrowSvg3')">
        <span class="text-xs leading-4 color-black" style="font-weight:bold">Department</span>
        <span class="arrow-icon" id="arrowIcon2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down h-1.2x w-1.2x text-secondary-400" id="arrowSvg3" style="color:black"> 
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </span>
    </div>
    <div id="dropdownContent3" style="font-size: 12px; line-height: 1; text-decoration: none; color:black;text-align: left; padding-left: 0;">
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

     </div>
     
                
        <div class="col-md-9" style="max-height: 80vh; overflow-y: auto;">
            @foreach ($combinedData as $index => $data)
            @if ($data['type'] === 'date_of_birth' )
 
            <div class="birthday-card bg-dark">
                <!-- Upcoming Birthdays List -->
                <div class="F"
                    style="padding: 15px; background-color: white; border-radius: 5px; border: 1px solid #CFCACA; color: #3b4452; margin-top: 20px">
                    <div class="row m-0">
                        <div class="col-md-4 mb-2" style="text-align: center;">
                            @livewire('company-logo')
                        </div>
                        <div class="col-md-4 m-auto"
                            style="color: #677A8E; font-size: 14px;font-weight: 100px; text-align: center;">
                            Group Events
                        </div>
                        <div class="c col-md-4 m-auto"
                            style="font-size: 13px; font-weight: 100px; color: #9E9696; text-align: center;">
                            {{ date('d M ', strtotime($data['employee']->date_of_birth)) }}
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-md-4">
                            <img src="{{ asset('images/Blowing_out_Birthday_candles_Gif.gif') }}"
                                alt="Image Description" style="width: 200px;">
                        </div>
                        <div class="col-md-8 m-auto">
                            <p style="color: #677A8E;">
                                Happy Birthday {{ $data['employee']->first_name }} {{ $data['employee']->last_name }},
                                Have a great year ahead!
                            </p>
                            <div style="display: flex; align-items: center;">
                                <img src="https://logodix.com/logo/1984436.jpg" alt="Image Description"
                                    style="height: 25px; width: 20px;">
                                <p style="margin-left: 10px; font-size: 14px; color: black;">
                                    Happy Birthday {{ $data['employee']->first_name }}
                                    {{ $data['employee']->last_name }}! 🎂
                                </p>
                            </div>
                        </div>
 
                    </div>
 
                    <!-- Display existing comments -->
                    <div class="row m-0">

    <div class="col-md-3 mb-2">
        <i class="far fa-smile"></i>
        <a style="margin-left: 10px;" onclick="toggleEmojiDiv({{ $index }})" wire:click="saveEmojiReaction({{ $employeeId }}, {{ $index }})">
            Reaction
        </a>
        <div class="myEmojiDiv" id="myEmojiDiv_{{ $index }}" style="display: none;">
            <emoji-picker style="width: 100%" @emoji-selected="selectEmoji($event.detail.native, {{ $index }})"></emoji-picker>
            <input type="hidden" name="emoji_ids[]" wire:model="selectedEmojiIds.{{ $employeeId }}.{{ $index }}">
        </div>
    </div>





                        <div class="col-md-9 p-0">
                        <form wire:submit.prevent="add_comment('{{ $data['employee']->emp_id }}')">
                    @csrf
                    <div class="row m-0">
                        <div class="col-md-4 mb-2">
                            <i class="comment-icon">💬</i>
                            <a href="#" onclick="comment({{ $index }})" style="margin-left: 10px;">Comment</a>
                        </div>

                        <div class="col-md-8 p-0 mb-2">
                            <div class="replyDiv row m-0" id="replyDiv_{{ $index }}" style="display: none;">
                                <div class="col-md-8">
                                    <textarea wire:model="newComment" placeholder="Post comment something here" style="font-size: 12px" name="comment" class="form-control"></textarea>
                                </div>
                                <div class="col-md-4">
                                    <input type="submit" class="btn btn-primary" style="text-align: center; line-height: 10px; font-size:12px;" value="Comment" wire:target="add_comment">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Display existing comments for the current birthday card -->
        <div class="row m-0">
    @php
        $currentCardComments = $comments->where('emp_id', $data['employee']->emp_id);
    @endphp
    @if($currentCardComments && $currentCardComments->count() > 0)
        @foreach ($currentCardComments as $comment)
            <div style="display: flex; margin-bottom: 20px;">
            <img style="border-radius: 50%; margin-left: 10px;" height="50" width="50" src="{{ asset($comment->image) }}">

                <div class="comment" style="font-size: 14px; font-family: 'Open Sans', sans-serif; margin-left: 20px;">
                    <b>{{ $comment->first_name }} {{ $comment->last_name }}</b>
                    <p style="font-size: 14px; font-family: 'Open Sans', sans-serif;">
                        {{ $comment->comment }}
                    </p>
                </div>
            </div>
        @endforeach
    @else
        <p>No comments available.</p>
    @endif
</div>
</div>
            </div>
            @elseif ($data['type'] === 'hire_date' )
            <div class="hire-card">
                <!-- Upcoming Hire Dates List -->
                <div class="F"
                    style="padding: 15px; background-color:white; border-radius: 5px; border: 1px solid #CFCACA; color: #3b4452; margin-top:20px">
                    <div class="row m-0">
                        <div class="col-md-4 mb-2" style="text-align: center;">
                            @livewire('company-logo')
                        </div>
                        <div class="col-md-4 m-auto"
                            style="color: #677A8E; font-size: 14px;font-weight: 100px; text-align: center;">
                            Group Events
                        </div>
                        <div class="c col-md-4 m-auto"
                            style="font-size: 13px; font-weight: 100px; color: #9E9696; text-align: center;">
                            {{ date('d M ', strtotime($data['employee']->hire_date)) }}
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-md-4">
                            <img src="{{ asset('images/New_team_members_gif.gif') }}" alt="Image Description"
                                style="width: 200px;">
                        </div>
                        <div class="col-md-8 m-auto">
                            <p style="color: #677A8E;">
                                {{ $data['employee']->first_name }} {{ $data['employee']->last_name }} has joined us
                                in the company on {{ date('d M Y', strtotime($data['employee']->hire_date)) }},
                                Please join us in welcoming our newest team member.
                            </p>
                            <div style="display: flex; align-items: center;">
                            <img style="border-radius: 50%; margin-left: 10px;" height="50" width="50" src="{{ $data['employee']->image }}">
                                <p style="margin-left: 10px; font-size: 14px; color: black;">
                                    {{ $data['employee']->first_name }} {{ $data['employee']->last_name }} Just
                                    Joined Us!
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
                                        <gt-button shade="secondary" name="Cancel" class="mr-2x hydrated">
                                        </gt-button>
                                        <gt-button shade="primary" name="Confirm" class="hydrated"></gt-button>
                                    </div>
                                </div>
                            </gt-popup-modal>
                        </confirmation-modal>
                    </div>
                    <div style="display: flex;">
                   
    <div class="emoji-comment-container">
        <!-- Emoji Picker Container -->
        <div class="emoji-picker-container">
            <button class="emoji-picker-button" id="emoji-picker-button" style="border:1px solid silver ;border-radius:5px">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-smile stroke-current text-secondary-400 w-4 h-4">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                    <line x1="9" y1="9" x2="9.01" y2="9"></line>
                    <line x1="15" y1="9" x2="15.01" y2="9"></line>
                </svg>
                <span class="emoji-text">Reaction</span>
            </button>
        </div>
   
            <!-- Emoji Picker Container -->
            <div id="emoji-picker" class="emoji-picker"></div>
            </div>
                        <div class="col-md-9 p-0">
                        <form wire:submit.prevent="createcomment('{{ $data['employee']->emp_id }}')">
                    @csrf
                    <div class="row m-0">
                        <div class="col-md-4 mb-2">
                            <i class="comment-icon">💬</i>
                            <a href="#" onclick="comment({{ $index }})" style="margin-left: 10px;">Comment</a>
                        </div>

                        <div class="col-md-8 p-0 mb-2">
                            <div class="replyDiv row m-0" id="replyDiv_{{ $index }}" style="display: none;">
                                <div class="col-md-8">
                                    <textarea wire:model="newComment" placeholder="Post comment something here" style="font-size: 12px" name="comment" class="form-control"></textarea>
                                </div>
                                <div class="col-md-4">
                                    <input type="submit" class="btn btn-primary" style="text-align: center; line-height: 10px; font-size:12px;" value="Addcomment" wire:target="addcomment">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Display existing comments for the current birthday card -->
        <div class="row m-0">
    @php
        $currentCardComments = $addcomments->where('emp_id', $data['employee']->emp_id);
    @endphp
    @if($currentCardComments && $currentCardComments->count() > 0)
        @foreach ($currentCardComments as $comment)
          <!-- Check if the comment has an associated employee -->
            <!-- Display the employee's image -->
            <div style="display: flex;">  
            <img style="border-radius: 50%; margin-left: 10px;" height="50" width="50" src="{{ asset($comment->image) }}">
  
     
                <div class="comment" style="font-size: 14px; font-family: 'Open Sans', sans-serif; margin-left: 20px;">
                    <b>{{ $comment->first_name }} {{ $comment->last_name }}</b>
                    <p style="font-size: 14px; font-family: 'Open Sans', sans-serif;">
                        {{ $comment->addcomment }}
                    </p>
                </div>
            </div>
        @endforeach
    @else
        <p>No comments available.</p>
    @endif
</div>
</div>
 
                    
            </div>
 
 
            @endif
            @endforeach
 
        </div>
    </div>
 

    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script> -->
    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
 
 
 
    <script>
    function toggleEmojiDiv(index) {
        var div = document.getElementById('myEmojiDiv_' + index);
        if (div.style.display === 'none') {
            div.style.display = 'block';
        } else {
            div.style.display = 'none';
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
 
    // function comment(caller) {
    //     var replyDiv = $(caller).siblings('.replyDiv');
    //     $('.replyDiv').not(replyDiv).hide(); // Hide other replyDivs
    //     replyDiv.toggle(); // Toggle display of clicked replyDiv
    // }
    </script>
 
 
    <script>
    function react(reaction) {
        // Handle reaction logic here, you can send it to the server or perform any other action
        console.log('Reacted with: ' + reaction);
    }
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        console.log("Document ready!");
 
        var emojiArea = $('#reaction-textarea').emojioneArea({
            pickerPosition: 'bottom'
        });
 
        $('#reaction-button').click(function() {
            console.log("Reaction button clicked!");
            $('#reaction-container').toggle();
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


</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const emojiPickerButton = document.getElementById('emoji-picker-button');
    const emojiPicker = document.getElementById('emoji-picker');
    
    // Define a list of emojis (you can use any emoji library or source)
    const emojis = ['😀', '😃', '😄', '😁', '😆', '😅', '😂', '🤣', '😊', '😇', '🙂', '🙃', '😉', '😌', '😍', '😘', '😗', '😙', '😚', '😋', '😛', '😝', '😜', '🤪', '🤨', '🧐', '🤓', '😎', '🤩', '😏', '😒', '😞', '😔', '😟', '😕', '🙁', '😣', '😖', '😫', '😩', '😤', '😠', '😡', '🤬', '😈', '👿', '💀', '☠️', '💩', '🤡', '👹', '👺', '👻', '👽', '👾', '🤖', '🎃', '😺', '😸', '😹', '😻', '😼', '😽', '🙀', '😿', '😾'];

    // Function to populate emoji picker
    function populateEmojiPicker() {
        emojis.forEach(emoji => {
            const emojiSpan = document.createElement('span');
            emojiSpan.textContent = emoji;
            emojiSpan.classList.add('emoji');
            emojiSpan.addEventListener('click', () => selectEmoji(emoji));
            emojiPicker.appendChild(emojiSpan);
        });
    }

    // Function to handle emoji selection
    function selectEmoji(emoji) {
        emojiPickerButton.querySelector('.emoji-text').textContent = emoji;
        emojiPicker.style.display = 'none';
    }

    // Toggle emoji picker visibility
    emojiPickerButton.addEventListener('click', () => {
        emojiPicker.style.display = emojiPicker.style.display === 'block' ? 'none' : 'block';
    });

    // Populate emoji picker on load
    populateEmojiPicker();
});

</script>