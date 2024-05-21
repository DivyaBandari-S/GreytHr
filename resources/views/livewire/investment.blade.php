<div class="container-fluid">
    <div class="d-flex justify-content-end">
        <div class="investment dropdown3 justify-content-end" style="position: relative; display: inline-block; margin-right: 20px;">
            <button class="dropdown-button3" id="yearDropdown" style="background-color: #fff; color: #333; border: 1px solid #ccc; padding: 8px 16px; font-size: 14px; cursor: pointer;">
                2022 - 2023
                <span class="dropdown-icon3" style="border: solid #333; border-width: 0 2px 2px 0; display: inline-block; padding: 3px; transform: rotate(45deg); margin-left: 5px;"></span>
            </button>
            <div class="dropdown-content3" style="position: absolute; background-color: #f9f9f9; min-width: 160px; z-index: 1; box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2); border: 1px solid #ccc; border-top: none; right: 0; top: 100%; display: none;">
                <div class="dropdown-item" data-year="2023-2024" style="color: #333; padding: 12px 16px; text-decoration: none; display: block; cursor: pointer; transition: background-color 0.3s;">2023 - 2024</div>
                <div class="dropdown-item" data-year="2022-2023" style="color: #333; padding: 12px 16px; text-decoration: none; display: block; cursor: pointer; transition: background-color 0.3s;">2022 - 2023</div>
            </div>
        </div>
    </div>
    <div class="container-fluid" style="width:100%">
        <div class="col-md-12 mt-3 text-center bg-white"  style="border-bottom:1px solid silver;">
            <div class="mt-3 d-flex justify-content-between">
                <h6 class="mt-3" id="poi-status" style="color: #778899; font-weight: 500; font-size: 12px;">
                    POI Status: <span id="selectedYear">2022 - 2023</span> : NOT YET RELEASED
                </h6>
                <p class="mt-3" style="font-size: 12px; cursor: pointer; color: deepskyblue; font-weight: 500;" wire:click="toggleDetails">
                    {{ $showDetails ? 'Hide' : 'Info' }}
                </p>
            </div>
            @if ($showDetails)
                <p style="font-size:12px">Proof of investment is an yearly process, where you have to provide necessary document as a proof for your investments.</p>
            @endif
        </div>
        
        <div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 bg-white text-center mt-3" id="content-2022-2023" style="border-radius: 5px; border: 1px solid silver; display: none;">
            <img src="https://th.bing.com/th/id/OIP.vwV51NMNZ8YgCdZ__BSFkQAAAA?pid=ImgDet&rs=1" class="img-fluid" style="height: 200px; width: auto;">
            <p>Sigh! POI is not yet released</p>
            <p style="font-size: 12px;">You can now seamlessly submit your investment proof here.</p>
        </div>
    </div>


        <div id="content-2023-2024" style="display:none;">
        <a href="/downloadform" id="pdfLink2023_4" class="pdf-download text-align-end" download style=" display: inline-block;margin-top:20px;font-size:14px">Download Form 12BB</a>
<div class="row d-flex">
  <div class="col-md-4">
  <ul class="side-page-nav mt-3" style="text-align:start;">
    <div class="text-muted">POI COMPONENTS</div>
    <li class="side-page-nav-item ng-star-inserted">
        <span class="info ng-star-inserted" title="Section 80C">1. Section 80C</span>
    </li>
    <li class="side-page-nav-item ng-star-inserted">
        <span class="info ng-star-inserted" title="Other Chapter VI-A Deductions">2. Other Chapter VI-A Deductions</span>
    </li>
    <li class="side-page-nav-item ng-star-inserted">
        <span class="info ng-star-inserted" title="House Rent Allowance">3. House Rent Allowance</span>
    </li>
    <li class="side-page-nav-item ng-star-inserted">
        <span class="info ng-star-inserted" title="Medical (Sec 80D)">4. Medical (Sec 80D)</span>
    </li>
    <li class="side-page-nav-item ng-star-inserted">
        <span class="info ng-star-inserted" title="Income/loss from House Property">5. Income/loss from House Property</span>
    </li>
    <li class="side-page-nav-item ng-star-inserted">
        <span class="info ng-star-inserted" title="Previous Employment">6. Previous Employment</span>
    </li>
    <li class="side-page-nav-item ng-star-inserted">
        <span class="info ng-star-inserted" title="Other Income">7. Other Income</span>
    </li>
    <li class="side-page-nav-item ng-star-inserted">
        <span class="info section-type ng-star-inserted" title="Proof Attachment">Proof Attachment</span>
    </li>
</ul>
  </div> 
  <div class="col-md-7 ml-6 bg-white" style="border-radius:5px;border:1px solid silver;height:300px">
  <div class="row" style="display:flex">
<p class="pt-3" style="width:100%;">Section 80C</p>
<a class="pt-1" href="/" wire:click="addshowVIDeductions" style="font-size: 25px; margin-left: 550px; text-decoration: none;color:black;margin-top:-50px">&rarr; </a>
</div>
<div style="border-bottom: 1px solid silver; "></div>
<div class="row" style="display:flex">
<p style="width:100%;">Other Chapter VI-A Deductions</p>
<a href="declaration-link" wire:click="addshowVIDeductions" style="font-size: 25px; margin-left: 550px; text-decoration: none;color:black;margin-top:-50px">&rarr; </a>
</div>
<div style="border-bottom: 1px solid silver; "></div>
<div class="row" style="display:flex">
<p style="width:100%;">House Rent Allowance</p>
<a href="declaration-link" wire:click="addshowVIDeductions" style="font-size: 25px; margin-left: 550px; text-decoration: none;color:black;margin-top:-50px">&rarr; </a>
</div>
<div class="row" style="display:flex">
<div style="border-bottom: 1px solid silver; "></div>
<p style="width:100%;">Medical (Sec 80D)</p>
<a href="declaration-link" wire:click="addshowVIDeductions" style="font-size: 25px; margin-left: 550px; text-decoration: none;color:black;margin-top:-50px">&rarr; </a>
</div>
<div style="border-bottom: 1px solid silver; "></div>
<div class="row" style="display:flex">
<p style="width:100%;">Income/loss from House Property</p>
<a href="declaration-link" wire:click="addshowVIDeductions" style="font-size: 25px; margin-left: 550px; text-decoration: none;color:black;margin-top:-50px">&rarr; </a>
</div>

<div style="border-bottom: 1px solid silver;"></div>
<div class="row" style="display:flex">
<p style="width:100%;">Previous Employment</p>
<a href="declaration-link" wire:click="addshowVIDeductions" style="font-size: 25px; margin-left: 550px; text-decoration: none;color:black;margin-top:-50px">&rarr; </a>
</div>
<div style="border-bottom: 1px solid silver;"></div>
<div class="row" style="display:flex">
<p style="width:100%;">Other Income</p>
<a href="declaration-link" wire:click="addshowVIDeductions" style="font-size: 25px; margin-left: 550px; text-decoration: none;color:black;margin-top:-50px">&rarr; </a>
</div>
  </div>

</div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var button = document.getElementById("yearDropdown");
        var dropdownContent = document.querySelector(".dropdown-content3");
        var selectedYear = document.getElementById("selectedYear");

        button.addEventListener("click", function() {
            dropdownContent.style.display = dropdownContent.style.display === "none" ? "block" : "none";
        });

        dropdownContent.addEventListener("click", function(event) {
            if (!event.target.matches(".dropdown-item")) return;
            var year = event.target.dataset.year;
            button.innerText = year;
            selectedYear.textContent = year; // Update selectedYear content
            dropdownContent.style.display = "none";
            
            // Show content based on selected year
            if (year === "2022-2023") {
                document.getElementById("content-2022-2023").style.display = "block";
                document.getElementById("content-2023-2024").style.display = "none";
            } else if (year === "2023-2024") {
                document.getElementById("content-2022-2023").style.display = "none";
                document.getElementById("content-2023-2024").style.display = "block";
            }
        });
    });
</script>

