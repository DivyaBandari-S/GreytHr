<div>

    <button class="back-button mb-2"><a class="a-back" href="/document">Back</a></button>
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
                    <div class="row mt-2 mb-2 confirmation-letterr">
                        <div onclick="toggleDetails('manualDetails')" class="col-md-6">
                            <div class="test m-0" style="font-size:0.8rem">Employee Induction Manual</div>
                            <div style="color: gray;font-size:10px;font-size:0.7rem">Employee Induction Manual</div>
                        </div>
                        <div class="col-md-6" style="color: gray;text-align:end;font-size:10px">
                            Last updated on 17 Nov, 2023
                        </div>
                        <div id="manualDetails" style="display:none;color: gray; font-size: 10px; font-size: 0.7rem;padding:5px">
                            <button onclick="downloadPdf()" class="emp-manual" style="background-color: white; color: black; border: none; border-radius: 5px; margin-left: 10px; padding: 5px; border: 1px solid lightgrey;">
                                Employee Induction Manual 1 (2) (1) .pdf
                                <i class="fas fa-download" style="margin-left: 5px;"></i>
                            </button>
                        </div>
                    </div>
                    <script>
                        function downloadPdf() {
                            const pdfPath = '/storage/Employee Induction Manual  1 (2) (1) (1).pdf';
                            const link = document.createElement('a');
                            link.download = 'Employee_Induction_Manual.pdf';
                            link.href = pdfPath;
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        }

                        function toggleDetails(elementId) {
                            $('#' + elementId).toggle();
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>