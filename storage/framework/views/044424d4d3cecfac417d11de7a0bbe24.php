<div class="container">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-end">
            <button onclick="window.location.href='/itdeclaration'" class="btn btn-primary border  ">Tax Planner</button>
            <span>
                <select id="yearSelect" class="form-control" style="width: 150px;">
                    <option class="dropdown" value="2023">2023</option>
                    <option class="dropdown" value="2024" selected>2024</option>
                </select>
            </span>
        </div>
    </div>

    <div class="row mt-4">
        <!-- First Column -->
        <div class="col-md-6 mb-4   text-center" >
            <div class="bg-white" style="height: 300px;border:1px solid silver;border-radius:5px">
                <img src="https://th.bing.com/th/id/OIP.vwV51NMNZ8YgCdZ__BSFkQAAAA?pid=ImgDet&rs=1" class="img-fluid" style="height: 200px;">
                <p>Sigh! Declaration is locked</p>
                <p style="font-size: 12px;">This declaration window is locked. Please wait for the admin notification</p>
            </div>
        </div>
        
        <!-- Second Column -->
        <div class="col-md-3 mx-md-5">
            <div class="row mb-4">
            <div class="col" style="border: 1px solid silver; border-radius: 5px; background-color: #ffffe8;<?php echo e($showDetails ? '' : 'height: 50px;'); ?>">
    <div class="mt-3 d-flex justify-content-between">
        <h6 style="color: #778899; font-weight: 500; font-size: 12px">Declaration Status: LOCKED</h6>
        <p style="font-size: 12px; cursor: pointer; color: deepskyblue; font-weight: 500;" wire:click="toggleDetails">
            <?php echo e($showDetails ? 'Hide' : 'Info'); ?>

        </p>
    </div>
    <!--[if BLOCK]><![endif]--><?php if($showDetails): ?>
        <p id="last-date-paragraph" style="font-size: 10px;">You have declared on <span id="declaration-date"></span>, and you cannot withdraw it</p>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>

            </div>
            <div class="row text-center">
                <div class="col" style="height:80px;background:white;border:1px solid silver;border-radius:5px;font-size:14px;"><p class="mt-2">Your IT declaration is considered as per the New Regime</p></div>
            </div>
            <a href="/downloadform" id="pdfLink2023_4" class="text-center" download><p class="mt-3">Download Form 12BB</p></a>
        </div>


    </div>
</div>
<script>
    // Get current date
    var currentDate = new Date();
 
    // Get the first day of the current month
    var firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 2);
 
    // Calculate the last day of the previous month
    var lastDayOfPreviousMonth = new Date(firstDayOfMonth - 2).getDate();
 
    // Get the month and year of the previous month
    var previousMonth = firstDayOfMonth.getMonth();
    var previousYear = firstDayOfMonth.getFullYear();
 
    // Format the previous month and year nicely
    var formattedPreviousMonth = new Intl.DateTimeFormat('en-US', { month: 'long' }).format(new Date(previousYear, previousMonth));
 
    // Update the paragraph text with the last date of the previous month
    var paragraph = document.getElementById("last-date-paragraph");
    paragraph.innerHTML = "You have declared on " + lastDayOfPreviousMonth + " " + formattedPreviousMonth + " " + previousYear + ", and you cannot withdraw it";
</script><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/declaration.blade.php ENDPATH**/ ?>