<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Applied Jobs</title>
</head>

<body>
    @livewire('applied-jobs')
    @livewireScripts
</body>
<style>
    .back-button {
        margin-top: 15px;
        text-align: right;
    }

    .back-button a {
        text-decoration: none;
        background-color: #02134F;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: bold;
        margin-right: 10px;
    }

    /* Style for the "Applied Jobs" section */
    .container {
        margin: 20px auto;
        max-width: 800px;
        padding: 20px;
        background-color: #f9f9f9;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        font-family: 'Montserrat';
        font-size: 12px;
    }

    h2 {
        text-align: center;
        font-family: 'Montserrat', sans-serif;
    }

    /* Style for the table */
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 12px 16px;
        text-align: center;
    }

    .table thead {
        background-color: #007BFF;
        color: white;
    }

    .table tbody tr:nth-child(odd) {
        background-color: #f2f2f2;
    }

    /* Style for the "No applied jobs found" message */
    p {
        text-align: center;
        font-size: 16px;
        color: #555;
    }

    .logout {
        background-color: rgb(2, 17, 79);
        /* Coral color */
        color: #fff;
        border: none;
        padding: 10px 15px;
        margin-top: 15px;
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