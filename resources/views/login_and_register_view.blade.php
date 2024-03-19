<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@5.x.x/dist/alpine.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <title>Login & Register</title>

</head>

<body>
    @livewire('login-and-register-for-jobs')
    @livewireScripts
</body>
<style>
        .form-control {
                width: 100%;
            }

            .text-danger {
                font-size: 12px;
            }

            .google-login-btn {
                /* Google's red color */

                border: none;
                padding: 10px 20px;
                font-size: 16px;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                margin-left: 60px;
                justify-content: center;
                background: white;
                border: 1px solid silver;
                border-radius: 5px;
            }

            /* Adjust icon size and spacing */
            .fa-google {

                font-size: 24px;
                margin-right: 8px;
            }
</style>
</html>