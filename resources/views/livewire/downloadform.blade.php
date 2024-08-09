<div style="font-size:0.8rem">
<div  style="height:auto;width:800px;border:1px solid silver; margin: 0 auto; font-family: 'Montserrat', Arial, sans-serif;">
    <h3 class="heading" style="text-align: center;font-family: 'Montserrat', Arial, sans-serif;">Form No. 12BB</h3>
    @foreach($employees as $employee)
    <div class="cus-row" style="margin-left:20px">
    <b>Employee Information</b>
    <div class="row" style="font-size: 12px; width: 100%;">
    <div class="col-6" style="display: flex; align-items: center;">
        <p style="margin: 0;">Name and address of the employee</p>
    </div>
    <div class="col-6" style="display: flex; align-items: center;">
        <p style="margin: 0;">: {{$employee->first_name}} {{$employee->last_name}}</p>
    </div>
</div>


    <div class="row" style="font-size: 12px;">
        <div class="col-md-3" style="display: flex; align-items: center; padding-right: 0;">
            <p style="margin: 0;">[Permanent Account Number or Aadhaar Number] of the employee</p>
        </div>
        <div class="col-md-9" style="display: flex; align-items: center; padding-left: 0;">
            <span style="margin: 0;">:</span>
        </div>
    </div>
    <div class="row" style="font-size: 12px;">
        <div class="col-md-3" style="display: flex; align-items: center; padding-right: 0;">
            <p style="margin: 0;">Financial year</p>
        </div>
        <div class="col-md-9" style="display: flex; align-items: center; padding-left: 0;">
            <span style="margin: 0;">: 2023-24</span>
        </div>
    </div>
    <div class="row" style="font-size: 12px;">
        <div class="col-md-3" style="display: flex; align-items: center; padding-right: 0;">
            <p style="margin: 0;">Tax Regime</p>
        </div>
        <div class="col-md-9" style="display: flex; align-items: center; padding-left: 0;">
            <span style="margin: 0;">: New Tax Regime</span>
        </div>
    </div>
</div>

        <table class="custom-table" style="margin-left:5px;border-collapse: collapse; margin-top: 20px;
            font-family: 'Montserrat', Arial, sans-serif;
           font-size:10px">
            <tr class="declaration" style="">
                <th class="custom-th" style="border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; ">Sl. No.</th>
                <th class="custom-th" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif;">Nature of Claim</th>
                <th class="custom-th" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; ">Amount (Rs.)</th>
                <th class="custom-th" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; ">Evidence / Particulars</th>
            </tr>
            <tr>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; ">1</td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif">House Rent Allowance</td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; "></td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; ">
                    (i) Rent paid to the landlord<br>
                    (ii) Name of the landlord<br>
                    (iii) Address of the landlord<br>
                    (iv) PAN of the landlord (if rent exceeds 1 lakh)
                </td>
            </tr>
            <tr>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; ">2</td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; ">Leave Travel Concessions or Assistance</td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; "></td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; "></td>
            </tr>
            <tr>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; ">3</td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; ">Deduction of Interest on Borrowing</td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; "></td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif;">
                    Interest on Housing Loan (Self occupied)<br>
                    (i) Interest payable/paid to the lender<br>
                    (ii) Name of the lender<br>
                    (iii) Address of the lender<br>
                    (iv) PAN of the lender<br>
                    - Financial Institutions (if available)<br>
                    - Employer (if available)<br>
                    - Others
                </td>
            </tr>
            <tr>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; ">4</td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif;">Deduction under Chapter VI-A</td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; "></td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif;">
                    (A) Section 80C, 80CCC, and 80CCD<br>
                    - Section 80C<br>
                    - Section 80CCC<br>
                    - Section 80CCD<br>
                    (B) Other sections (e.g., 80E, 80G, 80TTA, etc.) under Chapter VI-A
                </td>
            </tr>
        </table>

        <div class="claim-details" style="margin-left:20px">
            <p>Verification</p>
            <p>I,{{$employee->first_name}} {{$employee->last_name}}  son/daughter of  {{$employee->father_name}} do hereby certify that the information given above is complete and correct.</p>
        </div>

        <div class="custom-signature">
            <p class=" custom-text-center" style="  text-align: center;font-family: 'Montserrat', Arial, sans-serif;
    font-size: 12px;">Place: ____________________________</p>
            <p class=" custom-text-center" style="  text-align: center;font-family: 'Montserrat', Arial, sans-serif;
    font-size: 12px;">Date: ____________________________</p>
            <p class="custom-text-center" style="  text-align: center;font-family: 'Montserrat', Arial, sans-serif;
    font-size: 12px;">(Signature of the employee)</p>
            <p class="custom-text-center" style="  text-align: center;font-family: 'Montserrat', Arial, sans-serif;
    font-size: 12px;">Designation:  {{$employee->job_title}}</p>
            <p class="custom-text-center" style="  text-align: center;font-family: 'Montserrat', Arial, sans-serif;
    font-size: 12px;">Full Name:  {{$employee->first_name}} {{$employee->last_name}}</p>
        </div>
        @endforeach
    </div>
