<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Registration </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@5.x.x/dist/alpine.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    @livewire('emp-register')
    @livewireScripts
</body>
<style>
            .form-control {
            width: 200px;
            height: 25px;
            font-size: 10px
        }


        body {
            font-family: 'Roboto', sans-serif;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            font-size: 12px;
        }

        .input-group {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .form-group label {
            font-weight: 500;
            color: #5f6c79;
            margin-bottom: 10px;
        }

        a:hover {
            color: green;
        }

        .emp {
            display: flex;
            flex-direction: column;
            padding: 5px;
            justify-content: space-between;
            margin: 0 auto;
            gap: 7px;
        }

        .employee-details {
            border: 1px solid #ccc;
            padding: 5px 10px;
            font-size: 0.925rem;
            border-radius: 10px;
            background: #fff;
        }

        .employee-details h5 {
            font-weight: 400;
            font-size: 18px;
            color: rgb(2, 17, 79);
        }

        .alert-container {
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 300px;
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border-radius: 5px;
            text-align: center;
            display: none;
            /* Initially hide the container */
        }

        .close-btn {
            cursor: pointer;
            float: right;
            font-weight: bold;
            font-size: 18px;
        }

        .close-btn:hover {
            color: #fff;
            /* Change color on hover */
        }

        .view-button {
            background-color: rgb(2, 17, 79);
            color: white;
            border-radius: 7px;
            border: none;
            cursor: pointer;
            margin-left: 10px;
            padding: 4px 10px;
            font-size: 0.825rem;
            transition: background-color 0.3s ease-in-out;
        }

        .view-button:hover {
            background-color: #0056b3;
            color: #fff;
        }

        .placeholder-small::placeholder {
            font-size: 0.625rem;
            /* Adjust the font size as needed */
            color: #6c757d;
            /* Muted color */
        }

        /* Add this CSS to your stylesheet or create a new CSS file */
        .job-posting-form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f5f5f5;
            margin-bottom: 15px;
            font-size: 12px;

        }

        .job-posting-form .form-group {
            margin-bottom: 20px;
        }

        .job-posting-form label {
            font-weight: bold;
        }

        .job-posting-form input[type="text"],
        .job-posting-form input[type="number"],
        .job-posting-form select,
        .job-posting-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 12px;
        }

        .img-preview {
            max-width: 100%;
            height: 50px;
            margin-top: 10px;
        }

        .job-posting-form select {
            height: 40px;
        }

        .job-posting-form .btn-primary {
            background-color: rgb(2, 17, 79);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .text-danger {
            font-size: 12px;
        }

        .job-posting-form .btn-primary:hover {
            background-color: #002D91;
        }

        #success-message {
            position: relative;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            margin: 10px 0;
            text-align: center;
        }

        #success-message .close-message {
            position: absolute;
            top: 5px;
            right: 10px;
            cursor: pointer;
            color: green;
        }

        .custom-radio {
            margin-right: 10px;
            /* Adjust the margin to control the gap between radio buttons */
        }

        .custom-radio input {
            width: 10px;
            /* Adjust the width to decrease the size of the radio buttons */
            height: 10px;
            /* Adjust the height to decrease the size of the radio buttons */
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
