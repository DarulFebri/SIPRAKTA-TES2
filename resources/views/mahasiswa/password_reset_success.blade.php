<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sandi Berhasil Diubah</title>
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
            color: #28a745; /* Green for success */
            margin-bottom: 20px;
            font-weight: 700;
        }
        p {
            margin-bottom: 30px;
            font-size: 16px;
            line-height: 1.6;
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
            text-decoration: none; /* For anchor tag */
            display: inline-block; /* For anchor tag */
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Sandi Berhasil Diubah!</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @else
            <p>Password Anda telah berhasil diubah. Silakan masuk dengan password baru Anda.</p>
        @endif

        <a href="{{ route('mahasiswa.login') }}" class="btn-primary">Kembali ke Halaman Login</a>
    </div>
</body>
</html>