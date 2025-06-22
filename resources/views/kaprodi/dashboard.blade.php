<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kaprodi</title>
    <style>
        /* General Body Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 30px;
            background-color: #f0f2f5; /* Light grey background */
            color: #333;
            line-height: 1.6;
        }

        /* Dashboard Container */
        .dashboard-container {
            max-width: 900px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        /* Heading Styles */
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 35px;
            font-size: 2.5em;
            position: relative;
            padding-bottom: 10px;
        }

        h2::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: #3498db; /* Blue accent */
            border-radius: 2px;
        }

        h3 {
            color: #2c3e50;
            margin-top: 30px;
            margin-bottom: 15px;
            font-size: 1.8em;
            border-bottom: 2px solid #eee;
            padding-bottom: 8px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: #e8f5e9; /* Light green for stats */
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card.dosen {
            background-color: #e3f2fd; /* Light blue for dosen */
        }

        .stat-card.pengajuan {
            background-color: #fff3e0; /* Light orange for pengajuan */
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
        }

        .stat-card p {
            margin: 0;
            font-size: 1.1em;
            color: #555;
        }

        .stat-card .number {
            font-size: 3.5em;
            font-weight: bold;
            color: #3498db; /* Blue for numbers */
            margin-top: 10px;
            line-height: 1;
        }

        .stat-card.dosen .number {
            color: #2196f3;
        }
        .stat-card.pengajuan .number {
            color: #ff9800;
        }

        /* Latest Submissions List */
        .latest-submissions ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .latest-submissions ul li {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            padding: 15px 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.05em;
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }

        .latest-submissions ul li:hover {
            background-color: #f8f8f8;
            border-color: #c7c7c7;
        }

        .latest-submissions .no-submissions {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            border: 1px dashed #ccc;
            text-align: center;
            color: #777;
            font-style: italic;
        }

        /* Navigation Link */
        .dashboard-nav {
            margin-top: 40px;
            text-align: center;
        }

        .dashboard-nav a {
            display: inline-block;
            padding: 12px 25px;
            background-color: #28a745; /* Green button */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 3px 8px rgba(40, 167, 69, 0.2);
        }

        .dashboard-nav a:hover {
            background-color: #218838; /* Darker green on hover */
            transform: translateY(-2px);
        }

        /* Logout Button */
        .logout-form {
            text-align: center;
            margin-top: 30px;
        }

        .logout-form button {
            background-color: #dc3545; /* Red button */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .logout-form button:hover {
            background-color: #c82333; /* Darker red on hover */
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <h2>Dashboard Kaprodi</h2>

        <div class="stats-grid">
            <div class="stat-card dosen">
                <p>Jumlah Dosen</p>
                <div class="number">{{ $jumlahDosen }}</div>
            </div>
            <div class="stat-card pengajuan">
                <p>Jumlah Pengajuan Baru</p>
                <div class="number">{{ $jumlahPengajuan }}</div>
            </div>
        </div>

        <h3>Pengajuan Terbaru</h3>
        <div class="latest-submissions">
            @if ($pengajuanBaru->count() > 0)
                <ul>
                    @foreach ($pengajuanBaru as $pengajuan)
                        <li>
                            <span>{{ $pengajuan->mahasiswa->nama_lengkap }}</span>
                            <span style="font-weight: 600; color: #3498db;">
                                {{ strtoupper(str_replace('_', ' ', $pengajuan->jenis_pengajuan)) }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="no-submissions">Tidak ada pengajuan baru yang perlu diverifikasi saat ini.</p>
            @endif
        </div>

        <div class="dashboard-nav">
            <a href="{{ route('kaprodi.pengajuan.index') }}">Ke Menu Manajemen Pengajuan Sidang</a>
        </div>

        <div class="logout-form">
            <form action="{{ route('kaprodi.logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>