<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Companies</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    @livewire('companies')
    @livewireScripts
</body>
<style>
            .company-list {
            font-family: 'Montserrat', sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .company-item {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .company-logo img {
            width: 240px;
            height: 90px;
            object-fit: contain;
            border: 1px solid #ddd;
            border-radius: 5px;
            /* margin-right: 20px; */
        }

        .label {
            font-weight: bold;
            font-size: 16px;
            margin: 5px 0;
        }

        .back-button {
            text-align: right;
        }

        .back-button a {
            text-decoration: none;
            background-color: #02134F;
            color: white;
            padding: 5px;
            border-radius: 5px;
            font-weight: bold;
            margin-right: 10px;
        }

        .data {
            font-size: 14px;
            margin: 5px 0;
            word-break: break-all;
        }

        .data i {
            margin-right: 5px;
        }

        .right-arrow {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .right-arrow i {
            font-size: 20px;
        }
        /* @media only screen and (max-width: 768px) {
            .right-arrow {
                display: none
            }
        } */

        .timestamps {
            font-size: 12px;
            color: #777;
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