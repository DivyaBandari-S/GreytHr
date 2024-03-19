<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create CV</title>
</head>

<body>
    @livewire('c-v-builder')
    @livewireScripts
</body>
<style>
    body {
        font-family: 'Montserrat';
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
    }

    .left-column,
    .right-column {
        flex: 1;
        padding: 20px;
        font-family: Montserrat;

    }

    .left-column {
        background-color: #fff;
        max-width: 350px;
        padding: 40px;
        font-family: Montserrat;

    }

    .right-column {
        background-color: #f0f0f0;
        font-family: Montserrat;

    }

    .col {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        font-family: Montserrat;

    }

    h1 {
        font-size: 24px;
        text-align: center;
        margin: 20px 0;
        font-family: Montserrat;

    }

    h2 {
        font-size: 20px;
        margin-top: 20px;
        font-family: Montserrat;

    }

    label {
        font-weight: bold;
        font-family: Montserrat;

    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    textarea,
    input[type="file"],
    input[type="date"] {
        width: 96%;
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        font-family: Montserrat;

    }

    input[type="submit"] {
        background-color: #007BFF;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 18px;
        font-family: Montserrat;

    }

    input[type="submit"]:hover {
        background-color: #0056b3;
        font-family: Montserrat;

    }

    /* Added styles for education and work experience entries */
    .education-entry,
    .work-experience-entry {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 10px;
        margin: 10px 0;
        font-family: Montserrat;

    }

    .remove-education,
    .remove-work-experience {
        background-color: #ff5555;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin: 5px;
        padding: 5px 10px;
        font-family: Montserrat;

    }

    .remove-education:hover,
    .remove-work-experience:hover {
        background-color: #cc0000;
        font-family: Montserrat;

    }

    .error {
        font-size: 12px;
        color: red;
        font-family: Montserrat;

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

    .cv-container {
        /* display: flex;
                            width: 100%; */
        margin: 0 auto;
        background-color: #f0f0f0;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        font-family: Montserrat;
    }

    /* .row {
                            display: flex;
                            align-items: center;
                            font-family: Montserrat;
                        } */

    .col {
        flex: 1;
        font-family: Montserrat;
        width: 50%
    }

    img {
        width: 230px;
        height: 180px;
        font-family: Montserrat;
    }

    .name {
        font-size: 24px;
        font-weight: bold;
        margin-left: 20px;
        font-family: Montserrat;
    }

    .job-title {
        font-size: 18px;
        margin-left: 20px;
        font-family: Montserrat;

    }

    .profile-image {
        /* width: 250px; */
        height: 160px;
        font-family: Montserrat;
    }

    .contact-info {
        display: flex;
        align-items: center;
        font-size: 12px;
        font-family: Montserrat;
    }

    .contact-icon {
        margin-right: 10px;
        font-size: 24px;
        font-size: 12px;
        font-family: Montserrat;
    }

    .col-5 {
        margin-right: 0px;
        font-family: Montserrat;
    }
</style>

</html>