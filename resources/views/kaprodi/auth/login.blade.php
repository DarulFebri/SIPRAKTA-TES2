<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaprodi Login</title>
    <style>
        /* General Body Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e0f2f7; /* Light blue background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Full viewport height */
            color: #333;
        }

        /* Container for the form */
        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; /* Max width for the form */
            text-align: center;
            animation: fadeIn 0.5s ease-out; /* Simple fade-in animation */
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Heading Styles */
        h2 {
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 2.2em;
            position: relative;
            padding-bottom: 10px;
        }

        h2::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background-color: #3498db; /* Blue accent */
            border-radius: 2px;
        }

        /* Error Messages */
        .error-messages {
            background-color: #ffebee; /* Light red */
            color: #d32f2f; /* Darker red */
            border: 1px solid #ef9a9a;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: left;
            font-size: 0.9em;
        }

        .error-messages ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .error-messages li {
            margin-bottom: 5px;
        }

        /* Form Group Styling */
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 0.95em;
        }

        input[type="email"],
        input[type="password"] {
            width: calc(100% - 22px); /* Full width minus padding and border */
            padding: 12px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box; /* Include padding and border in the element's total width and height */
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #3498db; /* Blue on focus */
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2); /* Light blue shadow on focus */
            outline: none;
        }

        /* Button Styling */
        button[type="submit"] {
            background-color: #3498db; /* Blue button */
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 100%;
            margin-top: 20px;
        }

        button[type="submit"]:hover {
            background-color: #2980b9; /* Darker blue on hover */
            transform: translateY(-2px); /* Slight lift effect */
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login Kaprodi</h2>

        @if ($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('kaprodi.login') }}">
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