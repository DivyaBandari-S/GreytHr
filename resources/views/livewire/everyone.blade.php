<div>

    <div class="bg-white m-0 rounded-2 row">
        <div class="col-md-1 mt-2">
            @foreach($employeeDetails as $employee)

            <img style="border-radius: 50%; margin-left: 10px" height="50" width="50"
                src="{{ asset($employee->image) }}">

            @endforeach
        </div>

        <div class="col-md-11 mt-2">
            <!-- Placeholder for avatar -->
            <p class="m-0">
                @if(Auth::check())
                <span class="text-base font-semibold">Hey {{ Auth::user()->first_name }}
                    {{ Auth::user()->last_name }}</span>
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
                    <div class="row m-0">
                        <div class="col p-0" style="margin: 0px;">
                            <div class="input-group">
                                <input wire:model="search"
                                    style="width:80%; height: auto; font-size: 10px; border-radius: 5px 0 0 5px; cursor: pointer; "
                                    type="text" class="form-control" placeholder="Search...." aria-label="Search"
                                    aria-describedby="basic-addon1">
                                <button wire:click="starredFilter"
                                    style=" height: 36px; border-radius: 0 5px 5px 0; background-color: rgb(2, 17, 79);; color: #fff; border: none;"
                                    class="search-btn" type="button">
                                    <i style="text-align: center;" class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="w-full visible mt-1" style="margin-top:20px">
                        <div class="cus-button"
                            style="display: flex; justify-content: space-between; width: 100%; padding: 0.5rem;"
                            onclick="toggleDropdown('dropdownContent1', 'arrowSvg1')">
                            <span class="text-xs leading-4 color-black" style="font-weight:bold">Groups</span>
                            <span class="arrow-icon" id="arrowIcon1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="feather feather-chevron-down h-1.2x w-1.2x text-secondary-400" id="arrowSvg1"
                                    style="color:black">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </div>
                        <div id="dropdownContent1" style="display: none;">
                            <ul class="d-flex flex-column"
                                style="font-size: 12px; line-height: 1; text-decoration: none; color:black;text-align: left; padding-left: 0;">
                                <a class="menu-item" href="/Feeds"
                                    style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">All
                                    Feeds</a>
                                <a class="menu-item" href="/everyone"
                                    style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Every
                                    One</a>
                                <a class="menu-item" href="/events"
                                    style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Events</a>
                                <a class="menu-item" href="/events"
                                    style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Company
                                    News</a>
                                <a class="menu-item" href="/events"
                                    style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Appreciation</a>
                                <a class="menu-item" href="/events"
                                    style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Buy/Sell/Rent</a>
                            </ul>
                        </div>
                    </div>


                    <div class="w-full visible mt-1" style="margin-top:20px">
                        <div class="cus-button"
                            style="display: flex; justify-content: space-between; width: 100%; padding: 0.5rem;"
                            onclick="toggleDropdown('dropdownContent2', 'arrowSvg2')">
                            <span class="text-xs leading-4 color-black" style="font-weight:bold">Location</span>
                            <span class="arrow-icon" id="arrowIcon2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="feather feather-chevron-down h-1.2x w-1.2x text-secondary-400" id="arrowSvg2"
                                    style="color:black">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </div>
                        <div id="dropdownContent2"
                            style="font-size: 12px; line-height: 1; text-decoration: none; color:black;text-align: left; padding-left: 0;">
                            <ul style="font-size: 12px; margin: 0; padding: 0;">

                                <a class="menu-item" href="/events"
                                    style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Guntur</a>
                                <a class="menu-item" href="/events"
                                    style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Hyderabad</a>
                                <a class="menu-item" href="/events"
                                    style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Doddaballapur</a>
                                <a class="menu-item" href="/events"
                                    style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">USA</a>
                                <a class="menu-item" href="/events"
                                    style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Tirupati</a>
                                <a class="menu-item" href="/events"
                                    style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Vijayawada</a>
                                <a class="menu-item" href="/events"
                                    style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Adilabad</a>
                                <a class="menu-item" href="/events"
                                    style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Trivandrum</a>

                            </ul>
                        </div>
                    </div>

                    <div class="w-full visible mt-1" style="margin-top:20px">
                        <div class="cus-button"
                            style="display: flex; justify-content: space-between; width: 100%; padding: 0.5rem;"
                            onclick="toggleDropdown('dropdownContent3', 'arrowSvg3')">
                            <span class="text-xs leading-4 color-black" style="font-weight:bold">Department</span>
                            <span class="arrow-icon" id="arrowIcon3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="feather feather-chevron-down h-1.2x w-1.2x text-secondary-400" id="arrowSvg3"
                                    style="color:black">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </div>
                        <div id="dropdownContent3"
                            style="font-size: 12px; line-height: 1; text-decoration: none; color:black;text-align: left; padding-left: 0;">
                            <ul style="font-size: 12px; margin: 0; padding: 0;">



                                <a class="menu-item" href="/events"
                                    style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">HR</a>
                                <a class="menu-item" href="/events"
                                    style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Operations</a>
                                <a class="menu-item" href="/events"
                                    style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Operations
                                    Team</a>
                                <a class="menu-item" href="/events"
                                    style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">QA</a>
                                <a class="menu-item" href="/events"
                                    style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Production
                                    Team</a>
                                <a class="menu-item" href="/events"
                                    style="margin-top: 5px; display: block; padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Technology</a>
                                <a class="menu-item" href="/events"
                                    style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Sales
                                    Team</a>
                                <a class="menu-item" href="/events"
                                    style="margin-top: 5px; display: block;  padding: 5px 10px; transition: background-color 0.3s ease; color:black;">Testing
                                    Team</a>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>




        <div class="menu col-md-9" style="text-align: -webkit-center;">
            <div id="eventsSection" style="margin-top: 20px">
                <!-- <img src="https://cdni.iconscout.com/illustration/premium/thumb/business-failure-7626119-6210566.png"
                    alt="Empty Image" style="width: 300px; height: auto; display: block;"> -->
                <p style="font-size:20px;font-weight:600">It feels empty here!</p>
                <p style="font-size:12px;color:#778899;">Your feed is still in making as there's no
                    post to show.</p>
                <button
                    style="background:#6663ea;width:110px;height:30px;border:1px solid grey;border-radius:5px;color:white;"
                    wire:click="addFeeds">Create Post</button>
            </div>

            @foreach($posts as $post)
            <div class="col-md-8">
                <!-- Upcoming Birthdays List -->
                <div class="F"
                    style="background-color: white; border-radius: 5px; border: 1px solid #CFCACA; color: #3b4452; margin-top: 20px;">
                    <div class="m-0 mb-3 mt-3 row">
                        <div class="col-6" style="text-align: left;">
                                @livewire('company-logo')
                        </div>
                        <div class="col-6 m-auto"
                            style="font-size: 13px; font-weight: normal; font-family: Open Sans, sans-serif; font-weight: 100px; color: #9E9696;text-align:end;">
                            {{ $post->category }}
                        </div>
                    </div>
                    <div class="row m-0 mb-3">
                        @php
                        $employee = \App\Models\EmployeeDetails::where('emp_id', $post->emp_id)->first();
                        @endphp
                        @if($employee)
                        <div class="col-2">
                            <img style="border-radius: 50%;" height="50" width="50"
                                src="{{ asset($employee->image) }}">
                        </div>
                        <div class="col-10 m-auto" style="text-align: left">
                            <p class="text-base m-0"
                                style="margin-left:20px;font-size:14px;">{{ $employee->first_name }}
                                {{ $employee->last_name }}</p>
                        </div>
                        @else
                        <p>No employee details available.</p>
                        @endif
                    </div>


                    <div class="row m-0 mb-3">
                        <div class="col-md-6">
                            <img src="{{ Storage::url($post->attachment) }}" alt="Post Image"
                                style="width:200px;">
                        </div>
                        <div class="col-md-6 m-auto">
                            <p style="font-size: 14px; font-family: 'Open Sans', sans-serif; margin-top: 10px; font-weight: 100; color: #677A8E;">
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

            <!-- Begin the form outside the .form-group div -->
            @if($showFeedsDialog)
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Creating a Post</h5>

                            <button wire:click="closeFeeds" type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form wire:submit.prevent="submit">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="category">You are posting in:</label>
                                    <select wire:model="category" class="form-select" id="category">
                                        <option value="appreciations">category</option>
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
                                    <textarea wire:model="description" class="form-control" id="content"
                                        rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="attachment">Upload Attachment:</label>
                                    <input wire:model="attachment" type="file" id="attachment"
                                        class="form-control-file">
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
</div>
</body>
</div>