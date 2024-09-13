<div>

    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="/document">Document Center</a></li>
        <li class="breadcrumb-item active" aria-current="page">Payslips</li>

    </ul>
    <p style="margin-left: 40px; font-family: Open Sans, sans-serif; margin-top: 10px;font-weight:medium;font-size:16px;text-decoration:underline">Payslips</p>

    <div class="f" style="width:450px; background:white; border:1px solid silver; border-radius:5px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">

        <div _ngcontent-etd-c531="" class="document-body-card ng-star-inserted">
            <documents-card _ngcontent-etd-c531="" _nghost-etd-c530="" id="cat_2023" class="ng-star-inserted">
                <div class="container-a" style="margin-left:20px;margin-top:20px">
                    <div _ngcontent-etd-c530="" class="doc-card-title text-secondary text-4"></div>
                    <div class="title-line"></div>

                    <!-- Loop through the last 4 months in descending order -->
                    @for ($i = 1; $i <= 4; $i++)
                        @php
                        // Calculate the year and month dynamically
                        $currentYear=date('Y');
                        $lastMonth=date('m') - $i;
                        if ($lastMonth <=0) {
                        $lastMonth +=12;
                        $currentYear -=1;
                        }
                        @endphp

                        <div _ngcontent-etd-c530="" class="doc-card has-selected">
                        <div _ngcontent-etd-c530="" class="doc-card-hover ng-star-inserted">
                            <div _ngcontent-etd-c530="" class="doc-card-body d-flex w-100">
                                <div _ngcontent-etd-c530="" class="card-left ">
                                    <i _ngcontent-etd-c530="" class="fa fa-caret-right" onclick="togglePdf('pdfContainer{{ $currentYear }}_{{ $lastMonth }}')" style="cursor: pointer; font-size: 20px; padding-right:10px"></i>
                                </div>
                                <div _ngcontent-etd-c530="" class="card-right w-100">
                                    <div style="display: flex; align-items: center;">
                                        <!-- Display the dynamically calculated month and year -->
                                        <span class="text-black text-5 text-regular" style="font-size: 12px; display: inline-block;">
                                            {{ date('M Y', strtotime($currentYear . '-' . $lastMonth . '-01')) }}
                                        </span>
                                        <span style="margin-left: auto; font-size: 12px; white-space: nowrap; display: inline-block;padding-right:5px">
                                            Last updated on {{ date('d M, Y', strtotime($currentYear . '-' . $lastMonth . '-01')) }}
                                        </span>
                                    </div>

                                    <p class="text-secondary text-regular text-6 card-desc" style="font-size:10px">
                                        <!-- You can customize the card description as needed -->
                                        Payroll for the month of {{ date('M Y', strtotime($currentYear . '-' . $lastMonth . '-01')) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div id="pdfContainer{{ $currentYear }}_{{ $lastMonth }}" class="hey" style="width: 450px; background: white; border-radius: 5px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); width: 40%; display: none; flex: 1; align-items: center; padding: 10px; border: 1px solid transparent; transition: border-color 0.3s ease;margin-bottom: 10px;">
                            <span id="pdfLink{{ $currentYear }}_{{ $lastMonth }}" class="text-black text-5 text-regular" style="font-size: 12px; margin-right: 10px;">
                                {{ date('M Y', strtotime($currentYear . '-' . $lastMonth . '-01')) }}.pdf
                            </span>
                            <!-- <i class="bi bi-eye" style="color: blue; font-size: 16px; margin-right: 10px;"></i> Bootstrap Icons view icon -->
                            <i class="fas fa-eye" wire:click="downloadPdf" style=" font-size: 16px; margin-right: 10px;cursor: pointer;"></i>
                            <i class="fas fa-download" wire:click="downloadPdf" style="font-size: 16px; cursor: pointer;"></i>
                        </div>
                </div>
                <!-- PDF download link -->

                @endfor
        </div>
        </documents-card>
    </div>



</div>

@if( $showPopup == true)
<div class="modal" id="logoutModal" tabindex="4" style="display: block;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body text-center" style="font-size: 16px;">
                Currently working on functionality.
            </div>
            <div class="d-flex justify-content-center p-3" style="gap: 10px;">
                <!-- <button type="button" class="submit-btn mr-3" wire:click="confirmLogout">Logout</button> -->
                <button type="button" class="cancel-btn1" wire:click="cancel">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif


<script>
    function togglePdf(containerId) {
        var container = document.getElementById(containerId);
        // var icon = document.querySelector(`.fa-caret-right[onclick="togglePdf('${containerId}')"]`);
        var icon = document.querySelector(`[onclick="togglePdf('${containerId}')"]`);

        if (container.style.display === 'none' || container.style.display === '') {
            container.style.display = 'flex'; // Show container
            icon.classList.remove('fa-caret-right');
            icon.classList.add('fa-caret-down');
        } else {
            container.style.display = 'none'; // Hide container
            icon.classList.remove('fa-caret-down');
            icon.classList.add('fa-caret-right');
        }
    }
</script>



</div>
