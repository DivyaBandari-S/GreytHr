<div>



    <div class="container">

        <!-- Left Menu and Content (Conditional) -->
        <div class="left-menu">

            <!-- Add your menu items here -->
        </div>

        <!-- Content Area -->
        <div class="content" style="height:auto">
            <div style="width: 100%;display: flex;margin: 20px auto;">
                <div style="max-width: 800px;">
                    <div class="container" id="responsive-container" style="width: calc(100vw - 20px); display: flex; background: white; border-radius: 8px; padding: 20px; box-sizing: border-box;">
                        <div style="flex-grow: 1; max-width: calc(100% - 170px);">
                            <h1 style="margin-top: 0; margin-bottom: 20px; font-size: 20px; font-family: 'Montserrat', sans-serif; color: #000;">
                                We've got it sorted for you!
                            </h1>
                            <div class="author text-black uppercase" style="font-size: 16px; color: #555; line-height: 1.5;">
                                All Documents are now in one place..
                            </div>
                            <div class="author text-black uppercase" style="font-size: 16px; color: #555; margin-top: 10px;">
                                You can now request a new letter if you don't find the one you were looking for..
                            </div>
                        </div>
                        <img src="https://www.device42.com/wp-content/uploads/2019/06/user-defined-260x300.jpg" id="responsive-image" style="height: 160px; width: 150px; margin-left: 20px; margin-top: 0; border-radius: 8px;">
                    </div>
                </div>
            </div>
            <p style="font-size: 16px;margin-top:5px;font-weight:400">Documents</p>
            <div class="row" style="margin-top: 20px; display: flex; flex-wrap: wrap; gap: 10px;">
                <div class="col-md-3 docContent" >
                    <img src="{{ asset('/images/document.png') }}" alt="Image Description" style="height: 25px; width: 25px; ">
                    <p >Documents</p>
                    <a class="links" href="/documents" style="margin-left: auto; padding-right: 10px; font-size: 12px; color: black; text-decoration: none;">
                        <span onmouseover="this.style.color='#33B3BC'; this.style.textDecoration='underline';" onmouseout="this.style.color='black'; this.style.textDecoration='none';">
                            View all
                        </span>
                    </a>
                </div>
                <div class="col-md-3 docContent" >
                    <img src="{{ asset('/images/payslip.png') }}" alt="Image Description" style="height: 30px; width: 30px; ">
                    <p >
                        Payslips</p>
                    <a class="links" href="/payslip" style="margin-left: auto; padding-right: 10px; font-size: 12px; color: black; text-decoration: none;">
                        <span onmouseover="this.style.color='#33B3BC'; this.style.textDecoration='underline';" onmouseout="this.style.color='black'; this.style.textDecoration='none';">
                            View all
                        </span>
                    </a>
                </div>


                <div class="col-md-3 docContent" >
                    <img src="{{ asset('/images/form.png') }}" alt="Image Description" style="height: 25px; width: 25px; ">
                    <p >Form 16</p>
                    <a class="links" href="/documents" style="margin-left: auto; padding-right: 10px; font-size: 12px; color: black; text-decoration: none;">
                        <span onmouseover="this.style.color='#33B3BC'; this.style.textDecoration='underline';" onmouseout="this.style.color='black'; this.style.textDecoration='none';">
                            View all
                        </span>
                    </a>
                </div>
            </div>
            <div class="row" style="margin-top: 20px; display: flex; flex-wrap: wrap; gap: 10px;">

                <div class="col-md-3 docContent" >
                    <img src="{{ asset('/images/policy.png') }}" alt="Image Description" style="height: 25px; width: 25px; ">
                    <p >Policy</p>
                    <a class="links" href="/documents" style="margin-left: auto; padding-right: 10px; font-size: 12px; color: black; text-decoration: none;">
                        <span onmouseover="this.style.color='#33B3BC'; this.style.textDecoration='underline';" onmouseout="this.style.color='black'; this.style.textDecoration='none';">
                            View all
                        </span>
                    </a>
                </div>
                <div class="col-md-3 docContent" >
                    <img src="{{ asset('/images/form.png') }}" alt="Image Description" style="height: 25px; width: 25px; ">
                    <p >Forms</p>
                    <a class="links" href="/doc-forms" style="margin-left: auto; padding-right: 10px; font-size: 12px; color: black; text-decoration: none;">
                        <span onmouseover="this.style.color='#33B3BC'; this.style.textDecoration='underline';" onmouseout="this.style.color='black'; this.style.textDecoration='none';">
                            View all
                        </span>
                    </a>
                </div>
                <div class="col-md-4">

                </div>

            </div>
            <div class="col-md-4" style="height: 90px; background-color: white; border: 1px solid #D9D9D9; border-radius: 5px;margin-left:-5px;margin-top:20px;">
                <div class="c" style="height: 45px;">
                    <div style="display: flex; flex-direction: row;">
                        <img src="{{ asset('/images/receive-mail.png') }}" alt="Image Description" style="height: 25px; width: 25px; margin-left: 10px; margin-top: 20px;">
                        <p style="margin-top: 22px; margin-left: 20px;font-size:12px;">Letter</p>
                        <a class="links" href="/document-center-letters" style="margin-top: 23px; padding-left: 90px; font-size: 12px;  color: black; text-decoration: none;">
                            <span onmouseover="this.style.color='#33B3BC'; this.style.textDecoration='underline';" onmouseout="this.style.color='black'; this.style.textDecoration='none';">
                                View all
                            </span>
                        </a>
                    </div>
                </div>
                <div class="B" style="height: 45px;display: flex;">
                    <div style="display: flex; flex-direction: row; margin-left: 10px; margin-top: 10px;">
                        <p style="font-size: 14px; ">Pending:0</p>
                        <p style="margin-left: 100px; font-size: 12px; color: #677A8E;">Declined:0</p>
                    </div>

                </div>
            </div>
            <style>
                @media (max-width: 767px) {
                    .row {
                        flex-direction: column;
                        align-items: stretch;
                    }

                    .col-md-3 {
                        margin: 10px 0;
                        width: 100%;
                        height: auto;
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                    }

                    .col-md-3 img {
                        height: 25px;
                        /* Adjust if needed */
                        width: 25px;
                        /* Adjust if needed */
                    }
                }
            </style>
            <script>
                function adjustStyles() {
                    var container = document.getElementById('responsive-container');
                    var image = document.getElementById('responsive-image');
                    var width = window.innerWidth;

                    if (width <= 767) {
                        // Mobile styles
                        container.style.flexDirection = 'column';
                        container.style.width = 'calc(100% - 20px)';
                        container.style.padding = '15px';
                        image.style.width = '100%';
                        image.style.height = 'auto';
                        image.style.marginLeft = '0';
                        image.style.marginTop = '15px';
                        document.querySelector('h1').style.fontSize = '18px';
                        document.querySelectorAll('.author').forEach(el => el.style.fontSize = '14px');
                    } else {
                        // Default (desktop) styles
                        container.style.flexDirection = 'row';
                        container.style.width = 'calc(100vw - 20px)';
                        container.style.padding = '20px';
                        image.style.width = '150px';
                        image.style.height = '160px';
                        image.style.marginLeft = '20px';
                        image.style.marginTop = '0';
                        document.querySelector('h1').style.fontSize = '20px';
                        document.querySelectorAll('.author').forEach(el => el.style.fontSize = '16px');
                    }
                }

                window.addEventListener('resize', adjustStyles);
                window.addEventListener('load', adjustStyles);
            </script>
        </div>