<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seekers Applied Jobs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@5.x.x/dist/alpine.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<body>
    @livewire('job-seekers-applied-jobs')
    @livewireScripts
</body>
<style>
    .cc-label {
        text-align: start;
        font-size: 10px;
    }

    ::placeholder {
        font-size: 10px;
    }

    .button {
        background-color: rgb(1, 7, 79);
        color: white;
        border-radius: 5px;
        border: none;
        padding: 10px;
        cursor: pointer;
        width: 100%;
        font-size: 10px;

    }



    .cc-grid {
        width: 360px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 3px;
    }

    .cc-to {
        border: 1px solid #ddd;
        background-color: rgb(1, 7, 79);
        color: white;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 5px;
        text-align: start;
        font-size: 8px;
    }

    .cc-to i {
        cursor: pointer;
        color: white;
        transition: color 0.3s ease-in-out;
    }

    .cc-to i:hover {
        color: #dc3545;
    }


    .error-message {
        color: red;
        text-align: start;
        font-size: 10px;
    }

    .button {
        margin-top: 10px;
        margin-bottom: 10px;
        width: 20%;
        border: none;
    }



    .generate-password {
        height: auto;
        width: auto;
        background-color: rgb(1, 7, 79);
        color: white;
        border-radius: 0 5px 5px 0;
        font-size: 10px;
    }

    label {
        display: block;
        text-align: start;
        margin-bottom: 10px;
        margin-top: 5px;
        font-size: 12px;
        color: rgb(1, 7, 79);
    }

    input {
        font-size: 12px;
    }

    .form {
        padding: 5px;
    }

    .error-message {
        font-size: 10px;
    }

    #success-message,
    #error-message,
    #success-exam-message {
        position: relative;
        padding: 10px;
        margin: 10px 0;
        text-align: center;
    }

    #success-message {
        background-color: #4CAF50;
        color: white;
    }

    #success-exam-message {
        background-color: blue;
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

    .close-exam-message {
        position: absolute;
        top: 5px;
        right: 10px;
        cursor: pointer;
        color: blue;
    }

    .close {
        position: absolute;
        top: 5px;
        right: 10px;
        cursor: pointer;
        color: red;
    }

    .text-danger {
        font-size: 12px;
    }

    .input-fields {
        width: 100%;
    }

    /* Styles for the modal container */
    .modal {
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 1050;
        /* Ensure the modal appears above other elements */
        overflow-y: auto;
    }

    /* Center the modal dialog vertically and horizontally */
    .modal-dialog {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    /* Styles for the modal content */
    .modal-content {
        background-color: #fff;
        max-width: 80%;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        max-height: 500px;
        overflow-x: hidden;
        overflow-y: auto;
    }

    /* Styles for the modal header */
    .modal-header {
        background-color: rgb(2, 17, 79);
        color: white;
        height: 50px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 15px;
        border-radius: 5px 5px 0 0;
    }

    /* Styles for the close button */
    .modal-header .close {
        color: white;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
    }

    /* Styles for the modal body */
    .modal-body {
        padding: 20px;
        font-size: 12px;
    }

    /* Styles for the input fields and Save button */
    .modal-body input[type="text"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    /* Style the Save button */
    .modal-body button {
        background-color: rgb(2, 17, 79);
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    /* Add any additional styles as needed */


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

    .container-header {
        background-color: #02134F;
        color: white;
        padding: 10px;
        margin: 0;
    }

    .header-content {
        display: flex;
        align-items: center;
    }

    .header-logo {
        width: 200px;
        height: 50px;
        margin-right: 10px;
    }

    .header-title {
        font-size: 20px;
        margin-left: 24%;
        margin-top: 10px;
    }

    .back-button {
        width: 80px;
        border-radius: 5px;
        background-color: #02134F;
        color: white;
        margin-top: 5px;
        margin-bottom: 5px;
        margin-left: 93%;
    }

    .back-button a {
        text-decoration: none;
        color: white;
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
    }

    .download-button:hover {
        background-color: #027D02;
    }

    .status {
        border: none;
        border-radius: 5px;
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
<script>
    function initDatepicker(el, format) {
        flatpickr(el, {
            dateFormat: format,
        });
    }
</script>