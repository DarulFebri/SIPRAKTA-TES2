<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosen Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* General Body Styles */
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f2f5; /* Light gray background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Full viewport height */
            color: #334155; /* Darker text */
        }

        /* Login Container (Card) */
        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); /* Soft shadow */
            width: 100%;
            max-width: 400px; /* Max width for the login form */
            text-align: center;
        }

        /* Heading */
        h2 {
            color: #1e3a8a; /* Deep blue for heading */
            margin-bottom: 30px;
            font-size: 2em;
            font-weight: 700;
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
            background-color: #3b82f6; /* Accent blue */
            border-radius: 2px;
        }

        /* Error Messages */
        .alert-error {
            background-color: #fee2e2; /* Light red */
            color: #b91c1c; /* Darker red */
            border: 1px solid #fca5a5;
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            text-align: left;
            font-size: 0.9em;
        }

        .alert-error ul {
            margin: 0;
            padding-left: 20px;
            list-style-type: disc;
        }

        .alert-error li {
            margin-bottom: 5px;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 20px;
            text-align: left; /* Align labels and inputs to the left */
        }

        .form-group label {
            display: block; /* Each label on its own line */
            margin-bottom: 8px;
            font-weight: 600;
            color: #475569; /* Muted gray for labels */
            font-size: 0.95em;
        }

        .form-control {
            width: 100%; /* Full width of its container */
            padding: 12px;
            border: 1px solid #cbd5e1; /* Light border */
            border-radius: 6px;
            font-size: 1em;
            box-sizing: border-box; /* Include padding in width */
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            background-color: #f8fafc; /* Very light background for input */
            color: #334155;
        }

        .form-control:focus {
            border-color: #3b82f6; /* Accent blue on focus */
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2); /* Subtle glow */
            outline: none; /* Remove default outline */
            background-color: #fff;
        }

        /* Button */
        .btn-submit {
            width: 100%;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            background-color: #3b82f6; /* Brighter blue */
            color: white;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
            margin-top: 20px;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.2);
        }

        .btn-submit:hover {
            background-color: #2563eb; /* Darker blue on hover */
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(59, 130, 246, 0.3);
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Dosen Login</h2>

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('dosen.login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <button type="submit" class="btn-submit">Login</button>
        </form>
    </div>

</body>
</html>