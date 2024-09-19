<!DOCTYPE html>
<html>

<head>
    <title>Password Changed Notification</title>
    <style>
        /* Include Montserrat font */
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap');

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .email-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .email-footer {
            text-align: center;
            margin-top: 30px;
            color: #888;
        }

        .logo {
            max-width: 100px;
            /* Adjust as needed */
            height: auto;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            {{-- Company Logo --}}
            {{-- <p>Image URL: {{ $logoUrl }}</p> --}}
            <img src="{{ $logoUrl }}" alt="Company Logo" class="logo">
            <h1>Your password has been changed.</h1>
        </div>
        <p>Hello {{ $user->first_name }} {{ $user->last_name }},</p>
        <p>This is a notification to inform you that your password has been successfully changed. If you did not
            initiate this change, please contact our support team immediately.</p>
        <p>Thank you for using our service!</p>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} {{ $companyName }} Pvt Ltd. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
