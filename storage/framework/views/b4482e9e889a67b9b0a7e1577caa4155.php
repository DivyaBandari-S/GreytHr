<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1;
        }

        .table-frame {
            border: 5px solid #05054A;
            background-color: #f9f9f9;
            border-radius: 5px;
            margin-top: 20px;
            margin-bottom: 20px;
            overflow-x: auto;
        }

        .table-container table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.68rem;
        }

        .table-container th,
        .table-container td {
            padding: 8px 10px;
            border: 1px solid #ccc;
            text-transform: capitalize;
        }

        .table-container td.email-field input[type="email"] {
            text-transform: none;
        }

        .table-container th {
            font-size: 0.75rem;
            background-color: #05054A;
            color: #fff !important;
        }

        .table-container th,
        .table-container td {
            white-space: nowrap;
        }

        .table-container td:not(:first-child),
        .table-container th:not(:first-child) {
            width: 120px !important;
        }

        .table-container td:first-child,
        .table-container th:first-child {
            width: auto !important;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f1f1f1 !important;
        }

        .table-striped tbody tr:nth-child(even) {
            background-color: #ffffff;
        }

        .action-buttons {
            display: flex;
            gap: 4px;
        }

        .header,
        .footer {
            width: 100%;
            text-align: center;
            padding: 10px 0;
            background-color: #f6f6f6;
        }

        .footer {
            background-color: #05054A;
            color: #fff;
        }

        .footer a {
            color: #fff;
            margin: 0 10px;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .header img {
            width: 180px;
            height: auto;
        }

        .footer-social-icons {
            margin-top: 10px;
        }

        .footer-social-icons i {
            margin: 0 5px;
            font-size: 1.2rem;
        }

        .nav-link {
            color: #05054A;
            font-size: 14px;
            font-weight: 500;
        }

        .btn-update {
            padding: 5px;
            border: 1px solid #05054A;
            background-color: #fff;
            border-radius: 3px;
            font-size: 0.65rem;
        }

        .btn-delete {
            padding: 5px;
            background-color: #05054A;
            border: 1px solid #05054A;
            color: #fff;
            font-size: 0.65rem;
            border-radius: 3px;
        }
        .btn-save {
            padding:5px 15px;
            background-color: #05054A;
            border: 1px solid #05054A;
            color: #fff;
            font-size: 0.65rem;
            border-radius: 3px;
        }

        .footer-career {
            font-size: 12px;
        }

        .title {
            font-size: 14px;
            color: #05054A;
            font-weight: 500;
        }
        .text-red{
            color: red;
            font-size: 0.65rem;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header d-flex align-items-center justify-content-between">
        <div class="px-2">
            <img src="<?php echo e(asset('images/attune-logo.jpg')); ?>" alt="" > <!-- Replace with your logo path -->
        </div>
        <div class="title">Attune Global</div>
        <nav>
            <ul class="nav justify-content-center">
                <li class="nav-item"><a class="nav-link" href="/attune-reports">Go Back</a></li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div><?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('data-entry-for-email');

$__html = app('livewire')->mount($__name, $__params, 'lw-3112689930-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?></div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col justify-content-between align-items-center d-flex">
                    <div class="footer-social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-google-plus"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                    <p class="mb-0 footer-career">
                        <a href="#">Careers</a> |
                        <a href="#">Terms of Use / Disclaimer</a> |
                        <a href="#">Privacy Policy</a>
                    </p>
                    <p class="mb-0 footer-career">© Attune Global. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/data-entry_view.blade.php ENDPATH**/ ?>