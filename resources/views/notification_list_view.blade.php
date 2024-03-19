<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@5.x.x/dist/alpine.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    @livewire('notification-list', ['jobId' => $jobId])
    @livewireScripts
</body>
<style>
    body {
                font-family: Arial, sans-serif;
            }

            .card {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #e0e0e0;
                margin-bottom: 15px;
            }

            h6 {
                color: #3498db;
            }

            p {
                font-size: 16px;
            }

            ul {
                list-style-type: disc;
                margin-left: 20px;
            }

            a {
                color: #3498db;
                text-decoration: none;
            }

            a:hover {
                text-decoration: underline;
            }
</style>
</html>