<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Notifications</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
    @livewire('all-notifications')
    @livewireScripts
</body>
<style>
      body {
                font-family: 'Montserrat', sans-serif;
                background-color: #f0f0f0;
                margin: 0;
                padding: 0;
            }

            .logo {
                width: 200px;
                height: 50px;
                margin-right: 10px;
            }

            .header {
                display: flex;
                align-items: center;
                justify-content: start;
            }

            .title {
                font-size: 21px;
                margin-left: 20px;
            }

            .icon {
                margin-right: 5px;
            }

            .card {
                text-align: center;
                margin: 10px auto;
                padding: 15px;
                border: 1px solid #ccc;
                border-radius: 10px;
                background-color: white;
                width: 80%;
            }

            .notification-options {
                text-align: center;
            }

            .radio-option {
                font-family: 'Montserrat', sans-serif;
            }

            .notification-list {
                margin-top: 10px;
                text-align: start;
                margin-bottom: 10px;
            }

            .notification-item {
                font-size: 12px;
                color: black;
                text-decoration: none;
                display: block;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                margin-bottom: 10px;
            }

            .notification-item:hover {
                background-color: #02134F;
                /* Use the color code or name of your choice */
                color: white;
                /* You can change the text color for better contrast */
            }

            .logout {
                background-color: rgb(2, 17, 79);
                /* Coral color */
                color: #fff;
                border: none;
                padding: 10px 15px;
                cursor: pointer;
                transition: background-color 0.3s ease;
                border: 1px solid white;
                border-radius: 5px;
            }

            .logout:hover {
                background-color: #fff ;
                color:black
                /* Darker coral color on hover */
            }
</style>
</html>