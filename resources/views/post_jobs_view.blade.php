<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Jobs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@5.x.x/dist/alpine.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    @livewire('post-jobs')
    @livewireScripts
</body>
<style>
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