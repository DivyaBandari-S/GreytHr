<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendors Submitted CVs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@5.x.x/dist/alpine.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    @livewire('vendors-submitted-c-vs')
    @livewireScripts
</body>
<style>
      .container {
            font-family: 'Montserrat';
        }

        /* Example custom styles for the table */
        .table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
            font-size: 12px;
        }

        .table th,
        .table td {
            padding: 10px;
            font-size: 14px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 12px;
        }

        .table th {
            background-color: #f2f2f2;
            font-size: 12px;
            color: #333;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
            font-size: 12px;
        }

        .table tr:nth-child(odd) {
            background-color: #fff;
            font-size: 12px;
        }

        .job-seekers-applied-jobs {
            font-family: 'Montserrat';
        }

        .preview-button {
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 9px;
            width: 100px;
            margin-bottom: 5px;
        }

        .preview-button:hover {
            background-color: #0056b3;
        }

        .download-button {
            padding: 5px 10px;
            background-color: #02B802;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 9px;
            width: 100px;
            margin-bottom: 5px;
        }

        .download-button:hover {
            background-color: #027D02;
        }
        .logout {
            background-color: rgb(2, 17, 79);
            /* Coral color */
            color: #fff;
            border: none;
            padding: 10px 15px;
            margin-top: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            border: 1px solid white;
            border-radius: 5px;
            font-size: 12px;
        }

        .logout:hover {
            background-color: #fff;
            color: black
                /* Darker coral color on hover */
        }
</style>
</html>