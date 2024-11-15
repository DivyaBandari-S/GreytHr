<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Request Created</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
            text-align: center;
        }

        .container {
            width: 100%;
            max-width: 500px; /* Smaller width */
            margin: 40px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            position: relative; /* Allow positioning of images */
        }

        .header-img, .bottom-img {
            width: 100%;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            transition: transform 0.3s ease-in-out;
        }

        .header-img {
            top: -25px;
        }

        .bottom-img {
            bottom: -25px;
            transform: translateX(-50%) rotate(180deg); /* Flip and position */
        }

        .container:hover .header-img, .container:hover .bottom-img {
            transform: translateX(-50%) scale(1.05); /* Animation on hover */
        }

        .content {
            font-size: 12px; /* Smaller font size */
            line-height: 1.4;
            margin: 60px 0 40px; /* Top margin to accommodate header */
            padding: 15px;
            background-color: #ffffff;
            border: 1px solid silver;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: left;
            width:50%;
            align-items: center;
        }

        .details h4 {
            font-size: 16px;
            margin-bottom: 10px;
            text-align: center;
        }

        .details ul {
            list-style-type: none;
            padding-left: 0;
            margin: 10px 0;
        }

        .details li {
            padding: 5px 0;
        }

        .footer {
            font-size: 10px;
            color: #777;
            text-align: center;
            margin-top: 20px;
        }

        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }

        .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 12px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- Email Body Container -->
    <div class="container">
        <!-- Top Image with Overlap -->
<img src="https://via.placeholder.com/600x200/0000FF/ffffff?text=New+Request+Created" alt="Header Request Image" class="header-img">

        <!-- Content Area -->
        <div class="content">
            <div class="details">
                <h4>Request {{ $helpDesk->request_id }} Created</h4>
                <p>Hello, {{ $first_name }} {{ $last_name }}</p>
                <p>A new HelpDesk request has been submitted with the following details:</p>
                <ul>
                    <li><strong>Employee ID:</strong> {{ $helpDesk->emp_id }}</li>
                    <li><strong>Category:</strong> {{ $helpDesk->category }}</li>
                    <li><strong>Subject:</strong> {{ $helpDesk->subject }}</li>
                    <li><strong>Description:</strong> {{ $helpDesk->description }}</li>
                
                </ul>
            </div>

            <p>If you have any questions, feel free to reach out to the employee or view the HelpDesk portal.</p>
            <button lass="btn btn-primary">View Request</button>
        </div>

        <!-- Bottom Image with Overlap -->
        <img src="https://media.licdn.com/dms/image/v2/C4E16AQHPRunD1-WxJQ/profile-displaybackgroundimage-shrink_200_800/profile-displaybackgroundimage-shrink_200_800/0/1638280520996?e=2147483647&v=beta&t=vRo3GTbuJ8Wmo6aFswocjMvRWlHRmoqFNYk6KLTuGFQ" alt="HelpDesk Logo" class="bottom-img">

        <!-- Footer Section -->
        <div class="footer">
            <p>Thank you for managing the  requests.</p>

            <p><small>This is an automated message; please do not reply directly to this email.</small></p>
        </div>
    </div>

</body>
</html>
