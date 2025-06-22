<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #e0f2f7, #bbdefb); /* Light blue gradient */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: #333;
        }
        .container {
            background-color: #ffffff; /* White background */
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 450px;
            width: 90%;
        }
        h2 {
            color: #007bff; /* Primary blue */
            margin-bottom: 20px;
            font-weight: 700;
        }
        p {
            margin-bottom: 25px;
            font-size: 15px;
            line-height: 1.6;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
            text-align: center;
            letter-spacing: 5px; /* Untuk tampilan OTP */
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
        }
        .btn-primary {
            background-color: #007bff; /* Primary blue */
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Darker blue on hover */
            transform: translateY(-2px);
        }
        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 15px;
            text-align: left;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .error-message {
            color: #dc3545; /* Red for errors */
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }
        .resend-otp {
            margin-top: 20px;
            font-size: 14px;
        }
        .resend-otp button {
            background: none;
            border: none;
            color: #007bff;
            cursor: pointer;
            text-decoration: underline;
            font-size: 15px;
            font-weight: 600;
            padding: 0;
            transition: color 0.3s ease;
        }
        .resend-otp button:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Verifikasi Kode OTP</h2>
        <p>Kami telah mengirimkan kode OTP ke email Anda (<strong>{{ $email ?? 'Tidak diketahui' }}</strong>). Silakan masukkan kode tersebut di bawah ini.</p>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('mahasiswa.otp.verify') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="form-group">
                <label for="otp">Kode OTP</label>
                <input type="text" id="otp" name="otp" required maxlength="6" value="{{ old('otp') }}">
                @error('otp')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn-primary">Verifikasi OTP</button>
        </form>

        <div class="resend-otp">
            <p>Tidak menerima kode?
                <form method="POST" action="{{ route('mahasiswa.otp.resend') }}" style="display:inline;">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <button type="submit">Kirim Ulang OTP</button>
                </form>
            </p>
        </div>
    </div>
</body>
</html>