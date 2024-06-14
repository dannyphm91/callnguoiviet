<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .email-container {
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 20px;
        }

        h1 {
            color: #1768e0; /* Green color */
        }

        p {
            color: black;
        }

        a {
            display: inline-block;
            padding: 5px 10px;
            background-color: #1768e0; /* Green color */
            color: white;
            text-decoration: none !important;
            border-radius: 5px;
        }

        a:hover {
            background-color: #1768e0;
            color: white; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>{{ config('app.name') }}</h1>
        <p>You can reset your password by clicking the link below:</p>
        <a href="{{ route('password.reset', $token) }}" style="color: white;">Reset Password</a>
        <h2>Thank you for staying with us.</h2>
    </div>

</body>
</html>
