<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Password Reset Request</title>
</head>

<body>
    <h2>Password Reset Request</h2>
    <p>Hello,</p>
    <p>You are receiving this email because we received a password reset request for your account.</p>

    <p>Click the button below to reset your password:</p>

    <a href="{{ $resetUrl }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Reset Password</a>

    <p>If you did not request a password reset, no further action is required.</p>

    <p>Thank you for using our application!</p>
</body>

</html>