<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Job Details</title>
</head>

<body>
    @livewire('full-job-view', ['jobId' => $jobId])
    @livewireScripts
</body>
<style>
    body {
        font-family: 'Montserrat';
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 800px;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        border-radius: 5px;
        font-family: 'Montserrat';
    }

    h1 {
        color: #02134F;
        font-size: 28px;
    }

    p {
        color: #555;
        font-size: 16px;
        margin: 10px 0;
    }

    .company-logo {
        max-width: 150px;
        display: block;
        margin: 0 auto 20px;
    }

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

    .section-divider {
        border-top: 1px solid #ccc;
        margin: 20px 0;
    }

    .job-title {
        font-size: 24px;
        font-weight: bold;
        margin: 10px 0;
    }

    .job-company {
        color: #777;
    }

    .job-description {
        margin: 20px 0;
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