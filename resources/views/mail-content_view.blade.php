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
        .email-form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ced4da;
            border-radius: 8px;
            line-height: 1;
        }

        .form-label {
            color: #778899;
            font-weight: normal;
            font-size: 12px;
        }

        .email-form form {
            width: 100%;
        }

        .email-link {
            color: #80bdff;
            text-decoration: underline;
            cursor: pointer;
        }

        .title {
            font-weight: 500;
            color: #333;
        }

        .email-form .form-label {
            margin-bottom: 5px;
            font-weight: 500;
        }

        .email-form .form-control {
            width: 100%;
            padding: 8px 12px;
            font-size: 16px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .email-form .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .email-form .btn-primary {
            display: inline-block;
            font-weight: 400;
            color: #fff;
            background-color: #007bff;
            border: 1px solid transparent;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            transition: all 0.3s;
        }

        .email-form .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .email-form .text-danger {
            font-size: 14px;
            color: #dc3545;
            margin-top: 5px;
        }

        .small-padding-input {
            padding-top: 0.25rem !important;
            padding-bottom: 0.25rem !important;
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
            font-size: 0.6rem;
            /* Adjust font size if needed */
        }

        .cc-label {
            font-size: 0.765rem;
            color: #778899;
        }

        .cc-to {
            font-size: 0.75rem;
            color: #333;
        }

        .text-danger {
            font-size: 0.75rem;
        }

        .table {
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
            font-size: 0.75rem;
        }

        .table td {
            white-space: nowrap;
            /* Prevent text wrapping */
            overflow: hidden;
            text-overflow: ellipsis;
        }


        .table th {
            font-size: 0.75rem;
            font-weight: 500;
            color: #778899;
            background-color: #e7f0f9;
            font-weight: bold;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        .btn {
            padding: 0.3rem 0.6rem;
            border-radius: 0.375rem;
            outline: none;
            font-size: 0.75rem;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn:hover {
            background-color: #2563EB;
            /* Tailwind's hover:bg-blue-600 */
            color: #fff;
        }

        .btn-active {
            background-color: #3B82F6;
            /* Tailwind's bg-blue-500 */
            color: #fff;
        }

        .btn-inactive {
            background-color: #E5E7EB;
            /* Tailwind's bg-gray-200 */
            color: #374151;
            /* Tailwind's text-gray-700 */
        }

        .content-container {
            padding: 1rem;
            background-color: #fff;
            border-radius: 0.375rem;
            /* Equivalent to rounded-md in Tailwind CSS */
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1), 0 1px 1px rgba(0, 0, 0, 0.03);
            /* Tailwind's shadow-md */
        }
    </style>

</head>

<body>
    <div>@livewire('upload-time-sheet')</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>