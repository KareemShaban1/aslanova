<!DOCTYPE html>
<html>
<head>
    <title>Verification Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        h3 {
            color: #333;
            font-size: 24px;
            text-align: center;
        }
        .verification-code {
            background-color: #ff4d4d;
            color: white;
            font-size: 30px;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
            margin-top: 20px;
            display: inline-block;
            width: 100%;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            text-align: center;
        }
        .company-info {
            margin-top: 30px;
            font-size: 14px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Your Verification Code is:</h3>
        <div class="verification-code">{{ $verificationCode }}</div>
        <p>Please enter this code on our website to complete your registration process.</p>

        <p class="company-info">
            Welcome to Aslanova, your trusted partner for exquisite furniture! We specialize in luxurious beds, kitchens, and a wide variety of home furnishings.
        </p>
    </div>
</body>
</html>
