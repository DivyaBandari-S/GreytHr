<div>
<body>
<div class="f" style="width:450px;background:white;border:1px solid silver;border-radius:5px">

    <p style="margin-left: 40px; font-family: Open Sans, sans-serif; margin-top: 10px;font-weight:medium;font-size:16px;text-decoration:underline">Payslips</p>

<div _ngcontent-etd-c531="" class="document-body-card ng-star-inserted">
    <documents-card _ngcontent-etd-c531="" _nghost-etd-c530="" id="cat_2023" class="ng-star-inserted">
        <div class="container-2023" style="margin-left:40px">
            <div _ngcontent-etd-c530="" class="doc-card-title text-secondary text-4"></div>
            <div class="title-line"></div>

            <!-- Loop through the last 4 months in descending order -->
            <!--[if BLOCK]><![endif]--><?php for($i = 1; $i <= 4; $i++): ?>
                <?php
                    // Calculate the year and month dynamically
                    $currentYear = date('Y');
                    $lastMonth = date('m') - $i;
                    if ($lastMonth <= 0) {
                        $lastMonth += 12;
                        $currentYear -= 1;
                    }
                ?>

                <div _ngcontent-etd-c530="" class="doc-card has-selected">
                    <div _ngcontent-etd-c530="" class="doc-card-hover ng-star-inserted">
                        <div _ngcontent-etd-c530="" class="doc-card-body">
                            <div _ngcontent-etd-c530="" class="card-left">
                                <i _ngcontent-etd-c530="" class="fa fa-caret-right" onclick="togglePdf(<?php echo e($currentYear); ?>, <?php echo e($lastMonth); ?>)"></i>
                            </div>
                            <div _ngcontent-etd-c530="" class="card-right">
                                <div _ngcontent-etd-c530="" class="doc-card-body-content">
                                    <!-- Display the dynamically calculated month and year -->
                                    <span _ngcontent-etd-c530="" class="text-black text-5 text-regular"><?php echo e(date('M Y', strtotime($currentYear . '-' . $lastMonth . '-01'))); ?></span>
                                    <span _ngcontent-etd-c530="" class="text-secondary text-regular text-6" style="margin-left: 170px; font-size: 12px;"> Last updated on <?php echo e(date('d M, Y', strtotime($currentYear . '-' . $lastMonth . '-01'))); ?></span>
                                </div>
                                <p _ngcontent-etd-c530="" class="text-secondary text-regular text-6 card-desc">
                                    <!-- You can customize the card description as needed -->
                                    Payroll for the month of <?php echo e(date('M Y', strtotime($currentYear . '-' . $lastMonth . '-01'))); ?>

                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- PDF download link -->
                    <a href="/your-download-route" id="pdfLink<?php echo e($currentYear); ?>_<?php echo e($lastMonth); ?>" class="pdf-download" download style="display: none;">Download PDF</a>
                </div>
            <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </documents-card>
</div>


              
        </div>
    </div>
</div></div>


<script>
    function togglePdf(year, containerId) {
        var pdfLink = document.getElementById('pdfLink' + year + '_' + containerId);
        if (pdfLink.style.display === 'none') {
            pdfLink.style.display = 'inline-block';
        } else {
            pdfLink.style.display = 'none';
        }
    }
</script>


</div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/payroll.blade.php ENDPATH**/ ?>