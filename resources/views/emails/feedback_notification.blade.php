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
    <p><strong>Feedback Type:</strong> {{ ucfirst($feedbackType) }}</p> <!-- Capitalized first letter -->
    <p><strong>Time:</strong> {{ $feedbackTime }}</p>

    <!-- Display reply message if it exists -->
    @if(!empty($replayFeedbackMessage))
        <p><strong>Reply:</strong> {{ $replayFeedbackMessage }}</p>
    @endif

    <p>Thank you!</p>
</body>
</html>
