<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Kepala Jurusan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f2f5 0%, #e0e6ed 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: #333;
        }

        .login-container {
            background-color: #ffffff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-sizing: border-box; /* Include padding in element's total width and height */
        }

        h2 {
            font-size: 2em;
            margin-bottom: 25px;
            color: #2c3e50;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        h2 i {
            margin-right: 10px;
            color: #3498db;
        }

        .alert {
            background-color: #ffe6e6;
            color: #c0392b;
            border: 1px solid #e6b3b3;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 0.9em;
            text-align: left;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
            list-style-type: disc;
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
            font-size: 0.95em;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            box-sizing: border-box;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            outline: none;
        }

        button[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 100%;
            margin-top: 10px;
            box-shadow: 0 4px 10px rgba(52, 152, 219, 0.3);
        }

        button[type="submit"]:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2><i class="fas fa-user-tie"></i> Login Kepala Jurusan</h2>

        @if ($errors->any())
            <div class="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('kajur.login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required autocomplete="email" placeholder="Masukkan email Anda">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required autocomplete="current-password" placeholder="Masukkan password Anda">
            </div>

            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>