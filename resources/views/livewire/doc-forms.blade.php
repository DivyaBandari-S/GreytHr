<div>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="/document">Document Center</a></li>
        <li class="breadcrumb-item active" aria-current="page">Documents</li>

    </ul>
    <!-- <button class="back-button mb-2"><a class="a-back" href="/document">Back</a></button> -->
    <div class="row m-1 d-flex flex-row">
        <div style="color: rgb(2,17,79);">Forms</div>
        <hr style="width: 40px; text-align: start; border: 2px solid rgb(2, 12, 53); color: blue; margin-top: 5px; border-radius: 5px;">
    </div>

    <div class="row" style="background-color: white; border-radius: 5px; height: 250px;width:800px">
        <div class="row m-1" style="font-family: 'Montserrat', sans-serif;">
            <div class="col-md-3">
                <div style="margin-top: 5px;margin-left:5px;color:grey;font-size: 0.7rem">JUMP TO</div>
                <button class="jump-to"><strong>General Forms</strong></button>
            </div>
            <div class="col-md-9">
                <div class="row mt-3" style="background-color: white; border-radius: 5px; height: auto; width: 100%; border: 1px solid lightgrey; overflow: hidden;">
                    <h6 style="font-size: 0.9rem; ;margin-top:5px">
                        <div><strong style="color: grey;">General Forms</strong></div>
                    </h6>
                    <hr style="background-color: black; border-color: black; width: 100%; border-radius: 5px; margin: 0;">
                    <div class="row mt-2 mb-2 confirmation-letterr d-flex"  onclick="toggleDetails('manualDetails')" style="cursor: pointer;" >
                        <div _ngcontent-etd-c530="" class="card-left " style="width: fit-content;">
                            <i _ngcontent-etd-c530="" class="fa fa-caret-right"  style="cursor: pointer; font-size: 20px; padding-right:5px"></i>
                        </div>
                        <div style="width: fit-content;padding-left:0px">
                            <div class="test m-0" style="font-size:0.8rem">Employee Induction Manual</div>
                            <div style="color: gray;font-size:10px;font-size:0.7rem">Employee Induction Manual</div>
                        </div>
                        <div  style="color: gray;font-size:10px;width:fit-content;margin-left:auto;padding-right: 0px;">
                            Last updated on 17 Nov, 2023
                        </div>

                    </div>
                    <div id="manualDetails" style="display:none;color: gray; font-size: 10px; font-size: 0.7rem;padding:5px">
                            <button  class="emp-manual" style="background-color: white; color: black; border: none; border-radius: 5px; margin-left: 10px; padding: 5px; border: 1px solid lightgrey;">
                                Employee Induction Manual 1 (2) (1) .pdf
                                <i class="fas fa-eye" wire:click="downloadPdf()" style=" font-size: 16px; margin-left: 10px;cursor: pointer;"></i>
                                <i class="fas fa-download" wire:click="downloadPdf() " style="margin-left: 5px;cursor: pointer;font-size: 16px;"></i>
                            </button>
                        </div>
                    <script>
                        // function downloadPdf() {
                        //     const pdfPath = '/storage/Employee Induction Manual  1 (2) (1) (1).pdf';
                        //     const link = document.createElement('a');
                        //     link.download = 'Employee_Induction_Manual.pdf';
                        //     link.href = pdfPath;
                        //     document.body.appendChild(link);
                        //     link.click();
                        //     document.body.removeChild(link);
                        // }

                        function toggleDetails(elementId) {
                            $('#' + elementId).toggle();

                            // const icon = iconElement.querySelector('.fa');
                            var icon = event.currentTarget.querySelector('.fa');
                            // var icon = document.querySelector(`[onclick="toggleDetails('${containerId}')"]`);
                            if (icon.classList.contains('fa-caret-right')) {
                                icon.classList.remove('fa-caret-right');
                                icon.classList.add('fa-caret-down');
                            } else {
                                icon.classList.remove('fa-caret-down');
                                icon.classList.add('fa-caret-right');
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
    @if( $showPopup == true)
    <div class="modal" id="logoutModal" tabindex="4" style="display: block;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body text-center" style="font-size: 16px;">
                   Currently working on  functionality.
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
</div>
