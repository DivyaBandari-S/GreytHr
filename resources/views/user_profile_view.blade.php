<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Document</title>
</head>
<body>
    @livewire('user-profile')
    @livewireScripts
</body>
<style>
      .education-entry {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
            margin: 10px 0;
            font-family: Montserrat;

        }

        .remove-education {
            background-color: #ff5555;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px;
            padding: 5px 10px;
            font-family: Montserrat;

        }

        .remove-education:hover {
            background-color: #cc0000;
            font-family: Montserrat;

        }

        .resume-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            height: auto;
        }

        .profile-percent {
            font-size: 28px;
            /* Increase font size */
            font-weight: bold;
            color: rgb(2, 17, 79);
        }

        .name {
            font-size: 24px;
            /* Increase font size */
            color: rgb(2, 17, 79);
            margin-top: 10px;
        }

        .info {
            font-size: 14px;
            margin-top: 15px;
        }

        .section-title {
            font-weight: bold;
            color: rgb(2, 17, 79);
            font-size: 18px;
            /* Increase font size */
            /* margin-top: 20px; */
        }

        .section-content {
            font-size: 16px;
            /* Increase font size */
            margin: 10px 0;
        }

        .resume-section {
            background-color: #fff;
            margin: 10px 0;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .resume-header {
            background-color: rgb(2, 17, 79);
            color: #fff;
            padding: 15px;
            border-radius: 5px;
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
                background-color: #fff ;
                color:black
                /* Darker coral color on hover */
            }
</style>
</html>