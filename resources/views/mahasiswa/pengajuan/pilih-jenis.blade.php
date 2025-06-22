<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Jenis Pengajuan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #007bff;
            --dark-blue: #0056b3;
            --white: #ffffff;
            --light-grey: #f8f9fa;
            --medium-grey: #dee2e6;
            --text-color: #343a40;
            --border-color: #ced4da;
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
            margin: 0;
            padding: 30px;
            background-color: var(--light-grey);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            max-width: 600px;
            width: 100%;
            background-color: var(--white);
            padding: 35px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-medium);
            border: 1px solid var(--border-color);
            text-align: center;
        }

        h2 {
            color: var(--primary-blue);
            margin-bottom: 30px;
            font-weight: 700;
            position: relative;
            padding-bottom: 10px;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--primary-blue);
            border-radius: 2px;
        }

        .options {
            display: flex;
            flex-direction: column; /* Stack options vertically */
            gap: 20px; /* Space between options */
            margin-bottom: 30px;
        }

        .options a {
            display: block; /* Make links take full width */
            padding: 20px 30px;
            background-color: var(--primary-blue);
            color: var(--white);
            text-decoration: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .options a:hover {
            background-color: var(--dark-blue);
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: var(--primary-blue);
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            transition: color 0.3s ease, transform 0.2s ease;
            padding: 8px 15px; /* Add padding for better clickable area */
            border-radius: 5px;
            border: 1px solid transparent; /* To prevent layout shift on hover */
        }

        .back-link:hover {
            text-decoration: underline;
            color: var(--dark-blue);
            transform: translateY(-1px);
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }
            .container {
                padding: 25px;
            }
            h2 {
                font-size: 24px;
                margin-bottom: 25px;
            }
            .options a {
                font-size: 16px;
                padding: 18px 25px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pilih Jenis Pengajuan</h2>
        <div class="options">
            <a href="{{ route('mahasiswa.pengajuan.create', 'ta') }}">Pengajuan Tugas Akhir</a>
            <a href="{{ route('mahasiswa.pengajuan.create', 'pkl') }}">Pengajuan Praktek Kerja Lapangan</a>
        </div>
        <a href="{{ route('mahasiswa.dashboard') }}" class="back-link">Kembali ke Dashboard</a>
    </div>
</body>
</html>