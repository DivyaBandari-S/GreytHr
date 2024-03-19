<div>
   
    <div class="bg-white m-0  rounded-md row">
        <div class="col-md-1">
        @foreach($employeeDetails as $employee)
      
        <img style="border-radius: 50%; margin-left: 10px" height="50" width="50" src="{{ asset($employee->image) }}">

@endforeach
        </div>
 
        <div class="col-md-11 mt-2 m-auto">
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
                                    <button wire:click="starredFilter" style=" height: 36px; border-radius: 0 5px 5px 0; background-color: rgb(2, 17, 79);; color: #fff; border: none;" class="search-btn" type="button">
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
        <span class="arrow-icon" id="arrowIcon2">
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
        <span class="arrow-icon" id="arrowIcon3">
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
     
                
        <div class="col-md-9" >
        <div id="eventsSection">
        <img src="https://cdni.iconscout.com/illustration/premium/thumb/business-failure-7626119-6210566.png" alt="Empty Image" style="width: 350px; height: auto; margin-left:100px; display: block;">
    <p style=" margin-left:200px;font-size:20px;font-weight:600">It feels empty here!</p>
    <p style=" margin-left:130px;">Your feed is still in making as there's no post to show.</p>
</div>

 
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