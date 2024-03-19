<!DOCTYPE html>
<html lang="en">

<head>
    <script src="/path/to/pdf.js"></script>

    <!-- Include the correct Bootstrap 5 CSS link -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs</title>
</head>

<body>
    @livewire('jobs')
    @livewireScripts
</body>
<style>
    .card {
        background-color: white;
        display: none;
        position: fixed;
        top: 0;
        right: 0;
        margin-right: 11%;
        width: 450px;
        margin-top: 50px;
        padding: 5px;
        border: 1px solid grey;
        border-radius: 10px;
    }

    /* Style for the badge (notification count) */
    .badge {
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 5px 8px;
        font-size: 8px;
    }

    /* Global styles */
    body {
        font-family: 'Montserrat';
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
    }

    /* Header styles */
    .header {
        background-color: #02454f;
        color: #fff;
        text-align: center;
        padding: 20px 0;
        font-family: 'Montserrat';

    }

    .header h1 {
        font-size: 24px;
        font-weight: bold;
        margin: 0;
        font-family: 'Montserrat';

    }

    /* Navigation styles */
    .navigation {
        display: flex;
        justify-content: flex-end;
        margin: 20px 0;
    }

    .navigation button {
        font-size: 14px;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        margin-left: 10px;
        cursor: pointer;
        background-color: #0077b6;
        color: #fff;
        text-decoration: none;
    }


    /* Job card styles */
    .job-listings {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(500px, 1fr));
        gap: 20px;
        list-style: none;
        padding: 0;
        margin: 0;
        font-family: 'Montserrat';

    }

    .job-card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        font-family: 'Montserrat';

    }

    .job-card:hover {
        border: 2px solid black;
    }

    .job-title {
        font-size: 18px;
        color: #333;
        margin: 0;
        font-family: 'Montserrat';

    }

    .job-company {
        font-weight: bold;
        color: #0077b6;
        font-family: 'Montserrat';

    }

    .job-details {
        margin-top: 10px;
        display: flex;
        justify-content: space-between;
        font-family: 'Montserrat';

    }

    .job-location,
    .job-salary,
    .job-posted-at,
    .job-vacancies,
    .job-education-requirement,
    .job-experience-requirement,
    .job-skills-required {
        font-size: 14px;
        color: #555;
        font-family: 'Montserrat';

    }

    .apply-button {
        background-color: #0077b6;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        margin-top: 10px;
        cursor: pointer;
    }

    .apply-button:hover {
        background-color: #00546d;
    }

    /* Table styles */
    .job-list {
        width: 100%;
        margin-top: 10px;
        font-size: 14px;
        font-family: 'Montserrat';

    }

    .job-list th {
        background-color: #007BFF;
        color: white;
        font-size: 14px;
        font-family: 'Montserrat';

    }

    .job-list td {
        vertical-align: middle;
        padding: 10px;
        font-family: 'Montserrat';

    }

    .job-list tbody tr:nth-child(odd) {
        background-color: #f2f2f2;
        font-family: 'Montserrat';

    }

    /* Success and error message styles */
    #success-message,
    #error-message {
        position: relative;
        padding: 10px;
        margin: 10px 0;
        text-align: center;
    }

    #success-message {
        background-color: #4CAF50;
        color: white;
    }

    #error-message {
        background-color: #f44336;
        color: white;
    }

    .close-message {
        position: absolute;
        top: 5px;
        right: 10px;
        cursor: pointer;
        color: green;
    }

    .close {
        position: absolute;
        top: 5px;
        right: 10px;
        cursor: pointer;
        color: red;
    }

    .shortedList:hover {
        background-color: white;
        border-radius: 2px;
        border: 1px solid rgb(2, 17, 79);
    }

    a {
        text-decoration: none;
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