<div class="container">
<div class="row">
<div class="col d-flex justify-content-end align-items-center">
    <button onclick="window.location.href='/itdeclaration'" class="btn btn-primary border" style="margin-left:-20px;background-color:rgb(2, 17, 79)">Tax Planner</button>
    <span class="ml-3">
        <select id="yearSelect" class="form-control" style="width: 150px;align-items:center">
            <option class="dropdown" value="2023">2023</option>
            <option class="dropdown" value="2024" selected>2024</option>
        </select>
    </span>
</div>

    </div>
    <div class="row mt-5">
        <!-- First Column -->
        <div class="col-md-8   text-center"  >
            <div class="bg-white" style="height: 300px;border:1px solid #EFC3CA;border-radius:5px">
                <img src="https://th.bing.com/th/id/OIP.vwV51NMNZ8YgCdZ__BSFkQAAAA?pid=ImgDet&rs=1" class="img-fluid" style="height: 200px;">
                <p>Sigh! Declaration is locked</p>
                <p style="font-size:  0.8rem;align-items:center">This declaration window is locked. Please wait for the admin notification</p>
            </div>
            
        </div>
        <div class="col-md-4 ">
            <div class="row mb-4">
            <div class="col-md-10" style="border: 1px solid silver; border-radius: 5px; background-color: #ffffe8;<?php echo e($showDetails ? '' : 'height: 50px;'); ?>">
    <div class="mt-3 d-flex justify-content-between">
        <h6 style="color: #778899; font-weight: 500; font-size: 12px">Declaration Status: LOCKED</h6>
        <p style="font-size: 0.7rem; cursor: pointer; color: deepskyblue; font-weight: 500;" wire:click="toggleDetails">
            <?php echo e($showDetails ? 'Hide' : 'Info'); ?>

        </p>
    </div>
    <!--[if BLOCK]><![endif]--><?php if($showDetails): ?>
        <p id="last-date-paragraph" style="font-size: 10px;">You have declared on <span id="declaration-date"></span>, and you cannot withdraw it</p>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>

            </div>
            <div class="row text-center">
                <div class="col-md-10" style="height:80px;background:white;border:1px solid silver;border-radius:5px;font-size:0.7rem;"><p class="mt-2">Your IT declaration is considered as per the New Regime</p></div>
            </div>

            <a style="text-decoration:underline;cursor:pointer" wire:click="downloadPdf" id="pdfLink2023_4" class="text-center" download><p class="mt-3" style="font-size:0.7rem">Download Form 12BB</p></a>
        </div>


    </div>
</div>
</div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/declaration.blade.php ENDPATH**/ ?>