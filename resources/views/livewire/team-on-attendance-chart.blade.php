<div>

<body>
    <style>
        .arrow-button::after {
                       content: "\25B6"; /* Unicode character for right-pointing triangle (arrow) */
                       font-size: 18px;
    
        }
        .approve-button {
            background-color:rgb(2, 17, 79);
            color: white; /* White text */
            padding: 10px 20px; /* Padding around the text */
            border: none; /* No border */
            cursor: pointer; /* Cursor style on hover */
            border-radius: 5px; /* Rounded corners */
       }
       .reject-button {
            background-color:rgb(2, 17, 79);
            color: white; /* White text */
            padding: 10px 20px; /* Padding around the text */
            border: none; /* No border */
            cursor: pointer; /* Cursor style on hover */
            border-radius: 5px; /* Rounded corners */
        }
        .horizontal-line {
            position: absolute;
            width: 942px;
            margin-left:-10px;  /* Make the line stretch across the container */
            height:1px;/* Adjust the line thickness as needed */
            background-color: #7f8fa4; /* Line color */
            margin-top:-14px; /* Position the line vertically at the middle */
            transform: translateY(-50%); /* Adjust for vertical alignment */
        }

  </style>
    @if($showTeamOnAttendance1)
    @foreach($withdraw as $w2)
    <div style="background-color:#fff; margin-bottom:20px; border:1px solid #7f8fa4;">
        <div style="display:flex;flex-direction:row;">        
            <p class="title" style="font-weight: bold;color: #7f8fa4;">Name:</p>
            <p class="title" style="font-weight: bold; margin-left:270px;color: #7f8fa4;">No. of days:</p>
            
        </div>  
        <div style="display:flex;flex-direction:row;margin-top:-15px;"> 
          @foreach($subordinate as $firstName => $lastName)
            <p class="highlight" style="color: rgb(2, 17, 79);; margin-right:60px;">{{$lastName}} {{$firstName}}</p>
          @endforeach  
            <p class="days" style="font-size:20px; color: rgb(2, 17, 79);; margin-top:-2px; margin-left:120px;">1</p>
        </div>
    </div>
    <div class="arrow-button toggle-button" style="float:right; margin-top:-70px; margin-right:20px;" data-target-container="myContainerBody1"></div> 
    <div class="container-body1" style="width: 942px; border: 1px solid #7f8fa4; height: 180px; background-color: #fff; margin-bottom:20px; text-align: center; padding: 10px; display:none; margin-right:4px;margin-top:-20px;" id="myContainerBody1">
        <p class="title" style="font-weight: bold;color: #7f8fa4;margin-left:40px;">Dates Applied:</p>
        <p class="highlight" style="color:rgb(2, 17, 79);">{{ \Carbon\Carbon::parse($w2->regularisation_date)->format('j M Y') }}</p>
        <div class="horizontal-line"></div>
       
        <div style="margin-top:30px; margin-left:610px;display:flex;flex-direction:row;"> 
             <button wire:click="approve({{$w2->id}})" class="approve-button" >Approve</button>
             <button wire:click="reject({{$w2->id}})" class="reject-button" style="margin-left:20px">Reject</button>
            <a href="/regularisation-pending" class="button view-details-button" style="margin-left:20px;margin-top:5px">View Details</a>
        </div>  
    </div>
    @endforeach 
    @endif
    <script>
    document.querySelectorAll('.toggle-button').forEach(function(button) {
        button.addEventListener('click', function() {
            var targetContainerId = button.getAttribute('data-target-container');
            var container = document.getElementById(targetContainerId);
            container.style.display = (container.style.display === 'none' || container.style.display === '') ? 'block' : 'none';
        });
    });
    $(document).ready(function () {
    $('.toggle-button').on('click', function () {
        var targetContainerId = $(this).data('target-container');
        $('#' + targetContainerId).slideToggle(); // Use slideToggle for a smoother transition
    });

});


</script>
<script>
  const toggleButton1 = document.getElementById("toggleButton1");
  const containerBody1 = document.getElementById("myContainerBody1");

  toggleButton1.addEventListener("click", function () {
    toggleButton1.classList.toggle("rotate-arrow");
  });
</script>
</body>
</div>