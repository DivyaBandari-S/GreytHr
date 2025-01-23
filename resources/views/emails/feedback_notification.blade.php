<!DOCTYPE html>
<html>
<head>
    <title>Feedback Notification</title>
</head>
<body>
    <h2>{{ $feedbackStatus }}</h2>
    <p><strong>From:</strong> {{ $feedbackFrom }}</p>
    <p><strong>To:</strong> {{ $feedbackTo }}</p>
    <p><strong>Message:</strong> {{ $feedbackMessage }}</p>
    <p><strong>Feedback Type:</strong> {{ $feedbackType }}</p> <!-- Added feedback_type here -->
    <p><strong>Time:</strong> {{ $feedbackTime }}</p>

    <p>Thank you!</p>
</body>
</html>
