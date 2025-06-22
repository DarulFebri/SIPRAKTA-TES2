<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPRAKTA - Login Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #007bff;
            --dark-blue: #0056b3;
            --light-blue-bg: #e6f2ff;
            --white: #ffffff;
            --light-grey: #f8f9fa;
            --medium-grey: #dee2e6;
            --dark-grey: #495057;
            --text-color: #343a40;
            --border-color: #ced4da;
            --error-color: #dc3545;
            --shadow-medium: 0 4px 15px rgba(0,0,0,0.1);
            --border-radius: 8px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-grey);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-container {
            background-color: var(--white);
            padding: 40px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-medium);
            width: 100%;
            max-width: 400px;
            text-align: center;
            border: 1px solid var(--border-color);
        }

        h2 {
            color: var(--primary-blue);
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 700;
        }

        .alert-error {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--error-color);
            border: 1px solid var(--error-color);
            border-radius: var(--border-radius);
            padding: 15px;
            margin-bottom: 20px;
            text-align: left;
            font-size: 14px;
            list-style: none; /* Remove default list styling */
            padding-left: 20px; /* Adjust padding for list items */
        }

        .alert-error ul {
            padding: 0;
            margin: 0;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--dark-grey);
            font-weight: 500;
            font-size: 15px;
        }

        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            font-size: 16px;
            color: var(--text-color);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
            outline: none;
        }

        button[type="submit"] {
            width: 100%;
            padding: 14px;
            background-color: var(--primary-blue);
            color: var(--white);
            border: none;
            border-radius: var(--border-radius);
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 10px;
            box-shadow: var(--shadow-light);
        }

        button[type="submit"]:hover {
            background-color: var(--dark-blue);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 123, 255, 0.2);
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }
            h2 {
                font-size: 24px;
                margin-bottom: 25px;
            }
            .form-group input {
                padding: 10px;
                font-size: 15px;
            }
            button[type="submit"] {
                padding: 12px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2><i class="fas fa-user-shield"></i> Login Admin</h2>

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-triangle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required autocomplete="email" autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required autocomplete="current-password">
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>