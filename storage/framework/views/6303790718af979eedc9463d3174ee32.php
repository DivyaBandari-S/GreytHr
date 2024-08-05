<div>
<div class="custom-container" style="height:auto;width:800px;border:1px solid silver;
            margin: 0 auto;
            font-family: 'Montserrat', Arial, sans-serif;">
        <h3 class="heading" style="text-align: center;font-family: 'Montserrat', Arial, sans-serif;">Form No. 12BB</h3>
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="custom-row" style="margin-left:20px">
            <b>Employee Information</b>
            <div class="custom-row" style="display:flex;font-size:12px">
                <p>Name and address of the employee</p>
                <p style="padding-left:275px">: <?php echo e($employee->first_name); ?> <?php echo e($employee->last_name); ?></p>
            </div>
            <div class="custom-row" style="display:flex;font-size:12px">
                <p>[Permanent Account Number or Aadhaar Number] of the employee</p>
                <p style="padding-left:110px">:</p>
            </div>
            <div class="custom-row" style="display:flex;font-size:12px">
                <p>Financial year </p>
                <p style="padding-left:390px">:2023-24</p>
            </div>
            <div class="custom-row" style="display:flex;font-size:12px;">
                <p>Tax Regime</p>
                <p style="padding-left:400px">:New Tax Regime</p>
            </div>
        </div>

        <table class="custom-table" style="width:700px;margin-left:30px;font-size:12px;border-collapse: collapse; margin-top: 20px;
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 12px;">
            <tr>
                <th class="custom-th" style="border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; font-size: 12px;">Sl. No.</th>
                <th class="custom-th" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; font-size: 12px;">Nature of Claim</th>
                <th class="custom-th" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; font-size: 12px;">Amount (Rs.)</th>
                <th class="custom-th" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; font-size: 12px;">Evidence / Particulars</th>
            </tr>
            <tr>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; font-size: 12px;">1</td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; font-size: 12px;">House Rent Allowance</td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; font-size: 12px;"></td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; font-size: 12px;">
                    (i) Rent paid to the landlord<br>
                    (ii) Name of the landlord<br>
                    (iii) Address of the landlord<br>
                    (iv) PAN of the landlord (if rent exceeds 1 lakh)
                </td>
            </tr>
            <tr>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; font-size: 12px;">2</td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; font-size: 12px;">Leave Travel Concessions or Assistance</td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; font-size: 12px;"></td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; font-size: 12px;"></td>
            </tr>
            <tr>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; font-size: 12px;">3</td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; font-size: 12px;">Deduction of Interest on Borrowing</td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; font-size: 12px;"></td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; font-size: 12px;">
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
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; font-size: 12px;">4</td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; font-size: 12px;">Deduction under Chapter VI-A</td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; font-size: 12px;"></td>
                <td class="custom-td" style=" border: 1px solid #000;  padding: 8px;text-align: left;font-family: 'Montserrat', Arial, sans-serif; font-size: 12px;">
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
            <p>I,<?php echo e($employee->first_name); ?> <?php echo e($employee->last_name); ?>  son/daughter of  <?php echo e($employee->father_name); ?> do hereby certify that the information given above is complete and correct.</p>
        </div>

        <div class="custom-signature">
            <p class=" custom-text-center" style="  text-align: center;font-family: 'Montserrat', Arial, sans-serif;
    font-size: 12px;">Place: ____________________________</p>
            <p class=" custom-text-center" style="  text-align: center;font-family: 'Montserrat', Arial, sans-serif;
    font-size: 12px;">Date: ____________________________</p>
            <p class="custom-text-center" style="  text-align: center;font-family: 'Montserrat', Arial, sans-serif;
    font-size: 12px;">(Signature of the employee)</p>
            <p class="custom-text-center" style="  text-align: center;font-family: 'Montserrat', Arial, sans-serif;
    font-size: 12px;">Designation:  <?php echo e($employee->job_title); ?></p>
            <p class="custom-text-center" style="  text-align: center;font-family: 'Montserrat', Arial, sans-serif;
    font-size: 12px;">Full Name:  <?php echo e($employee->first_name); ?> <?php echo e($employee->last_name); ?></p>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </div>
<?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/downloadform.blade.php ENDPATH**/ ?>