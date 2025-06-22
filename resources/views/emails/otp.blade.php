<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Anda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: none;
            width: 100%;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #333333;
            font-size: 24px;
        }
        .content {
            font-size: 16px;
            line-height: 1.6;
            color: #555555;
            text-align: center;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: #007bff;
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #e9f5ff;
            border-radius: 5px;
            display: inline-block;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #888888;
            text-align: center;
        }
        .warning {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Reset Password</h1>
        </div>
        <div class="content">
            <p>Halo,</p>
            <p>Anda telah meminta kode OTP untuk mereset password akun Anda. Berikut adalah kode OTP Anda:</p>
            <p class="otp-code">{{ $otp }}</p>
            <p>Kode ini akan kedaluwarsa dalam **5 menit**. Mohon jangan bagikan kode ini kepada siapapun.</p>
            <p class="warning">Jika Anda tidak merasa meminta reset password, mohon abaikan email ini.</p>
        </div>
        <div class="footer">
            <p>Terima kasih,</p>
            <p>Tim {{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>