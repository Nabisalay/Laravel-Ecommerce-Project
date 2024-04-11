<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to [Your Company Name]!</title>
    <style>
        /* Basic styling for a clean and readable email */
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
        }

        .header {
            text-align: center;
        }

        .content {
            line-height: 1.5;
        }

        .link {
            color: #337ab7;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <header class="header">
        <h1>Welcome to {{ config('app.name') }}!</h1>
    </header>
    <div class="content">
        <p>Hi {{ $messages['User'] }},</p>

        <p>Thank you for registering on our platform. We're excited to have you join our community!</p>

        <p>Your account has been successfully created. You can now log in to your account and start using our features:</p>

        <a class="link" href="{{ url('http://127.0.0.1:8000/login') }}">Login Now</a>

        <p>Thanks,</p>
        <p>The  {{ config('app.name') }} Team</p>
    </div>
</div>
</body>
</html>