<!DOCTYPE html>
<html>

<head>
    <title>Feedback Notification</title>
</head>

<body>
    <h2>{{ $feedbackStatus }}</h2>
    <p><strong>From:</strong> {{ $feedbackFrom }}</p>
    <p><strong>To:</strong> {{ $feedbackTo }}</p>
    <div class="ql-editor">
        <p><strong>Message:</strong> {!! $feedbackMessage !!}</p>
    </div>

    <p><strong>Feedback Type:</strong> {{ ucfirst($feedbackType) }}</p> <!-- Capitalized first letter -->
    <p><strong>Time:</strong> {{ $feedbackTime }}</p>

    <!-- Display reply message if it exists -->
    @if (!empty($replayFeedbackMessage))
        <div class="ql-editor">
            <p><strong>Reply:</strong> {!! $replayFeedbackMessage !!}</p>
        </div>
    @endif
    @if ($feedback->is_declined)
        <p style="color: red;">
            <strong>Note:</strong> Your feedback request has been declined by
            <strong>{{ $receiverName }}</strong> (#{{ $receiverId }}).
        </p>
    @endif

    <p>Thank you!</p>
</body>

</html>
