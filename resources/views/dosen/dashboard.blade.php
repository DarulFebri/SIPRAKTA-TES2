<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dosen</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* General Body Styles */
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 30px 20px;
            background-color: #f0f2f5; /* Light gray background */
            color: #334155; /* Darker, muted text */
            line-height: 1.6;
        }

        /* Container Styling */
        .container {
            max-width: 1000px; /* Slightly wider for dashboard content */
            margin: 20px auto;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); /* Soft shadow */
        }

        /* Heading Styles */
        h2 {
            text-align: center;
            color: #1e3a8a; /* Deep blue for heading */
            margin-bottom: 35px;
            font-size: 2.5em;
            font-weight: 700;
            position: relative;
            padding-bottom: 15px;
        }

        h2::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: #3b82f6; /* Accent blue */
            border-radius: 2px;
        }

        h3 {
            color: #1e3a8a;
            margin-top: 30px;
            margin-bottom: 20px;
            font-size: 1.8em;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0; /* Lighter border */
        }

        /* Alert Messages */
        .alert {
            padding: 15px 20px;
            margin-bottom: 25px;
            border-radius: 8px; /* Slightly more rounded */
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05); /* Subtle shadow */
        }

        .alert-success {
            background-color: #dcfce7; /* Light green */
            color: #166534; /* Darker green */
            border: 1px solid #86efac;
        }

        .alert-danger {
            background-color: #fee2e2; /* Light red */
            color: #b91c1c; /* Darker red */
            border: 1px solid #fca5a5;
        }

        .alert-info {
            background-color: #e0f2fe; /* Light blue */
            color: #1d4ed8; /* Darker blue */
            border: 1px solid #93c5fd;
        }

        /* Card Sections */
        .card-section {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px; /* More space between cards */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        }

        .card-section h3 {
            margin-top: 0; /* Override default h3 margin */
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eff2f5;
        }

        /* Notification Section */
        .notification-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start; /* Align content to top if actions are taller */
            padding: 15px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .notification-item:last-child {
            border-bottom: none; /* No border for the last item */
        }

        .notification-content {
            flex-grow: 1;
            margin-right: 20px;
        }

        .notification-content p {
            margin: 0 0 5px 0;
            color: #475569;
        }

        .notification-content strong {
            color: #1e293b;
        }

        .notification-content .timestamp {
            font-size: 0.85em;
            color: #94a3b8; /* Lighter gray for timestamp */
            margin-top: 5px;
            display: block;
        }

        .notification-actions {
            display: flex;
            flex-direction: column; /* Stack buttons vertically */
            gap: 8px; /* Space between action buttons */
            flex-shrink: 0; /* Prevent actions from shrinking */
        }

        .notification-actions .action-link,
        .notification-actions button {
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            font-size: 0.9em;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.2s ease, transform 0.1s ease;
            white-space: nowrap; /* Prevent text wrapping on buttons */
        }

        .notification-actions .action-link {
            background-color: #3b82f6; /* Accent blue */
            color: white;
            box-shadow: 0 2px 5px rgba(59, 130, 246, 0.15);
        }

        .notification-actions .action-link:hover {
            background-color: #2563eb;
            transform: translateY(-1px);
        }

        .notification-actions button {
            background-color: #cbd5e1; /* Light gray for "Mark as Read" */
            color: #475569;
            box-shadow: 0 2px 5px rgba(132, 147, 169, 0.1);
        }

        .notification-actions button:hover {
            background-color: #94a3b8;
            color: #fff;
            transform: translateY(-1px);
        }

        /* Sidang Invitations / Approved / Rejected Section */
        .sidang-item {
            background-color: #f8fafc; /* Lighter background for each item */
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            position: relative; /* For role badge positioning */
        }

        .sidang-item p {
            margin-bottom: 8px;
            font-size: 0.95em;
        }

        .sidang-item p strong {
            color: #1e293b;
        }

        .sidang-item .action-link {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #3b82f6;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.2s ease, transform 0.1s ease;
            box-shadow: 0 2px 5px rgba(59, 130, 246, 0.15);
        }

        .sidang-item .action-link.approved {
            background-color: #22c55e; /* Green for approved */
        }
        .sidang-item .action-link.approved:hover {
            background-color: #16a34a;
        }

        .sidang-item .action-link.rejected {
            background-color: #ef4444; /* Red for rejected */
        }
        .sidang-item .action-link.rejected:hover {
            background-color: #dc2626;
        }


        .sidang-item .action-link:hover {
            background-color: #2563eb;
            transform: translateY(-1px);
        }

        .no-items-message {
            padding: 15px;
            background-color: #e2e8f0;
            border-radius: 8px;
            color: #64748b;
            font-style: italic;
            text-align: center;
            font-size: 0.95em;
        }

        .dosen-role-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: #a78bfa; /* Purple for role */
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.8em;
            font-weight: 600;
            white-space: nowrap;
        }
        .dosen-role-badge.status-setuju {
            background-color: #22c55e; /* Green for 'Setuju' status */
        }
        .dosen-role-badge.status-tolak {
            background-color: #ef4444; /* Red for 'Tolak' status */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .notification-item {
                flex-direction: column;
                align-items: stretch;
            }
            .notification-content {
                margin-right: 0;
                margin-bottom: 10px;
            }
            .notification-actions {
                flex-direction: row; /* Buttons side-by-side on smaller screens */
                justify-content: flex-end;
                gap: 10px;
            }
            .notification-actions .action-link,
            .notification-actions button {
                flex-grow: 1; /* Allow buttons to expand */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Dashboard Dosen</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif

        <div class="card-section notification-section">
            <h3>Notifikasi Terbaru (Belum Dibaca)</h3>
            @forelse ($unreadNotifications as $notification)
                <div class="notification-item">
                    <div class="notification-content">
                        @if ($notification->type === 'App\Notifications\DosenSidangInvitation')
                            <p><strong>Undangan Sidang Baru:</strong> {{ $notification->data['message'] }}</p>
                            <p>Mahasiswa: {{ $notification->data['mahasiswa_nama'] }}</p>
                            <p>Jenis: {{ $notification->data['jenis_pengajuan'] }}</p>
                            <p>Tanggal: {{ $notification->data['tanggal_sidang'] }}</p>
                            <p>Ruangan: {{ $notification->data['ruangan_sidang'] }}</p>
                        @else
                            <p>Notifikasi Umum: {{ $notification->data['message'] ?? 'Tidak ada detail pesan.' }}</p>
                        @endif
                        <span class="timestamp">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="notification-actions">
                        @if ($notification->type === 'App\Notifications\DosenSidangInvitation' && isset($notification->data['sidang_id']))
                            <a href="{{ route('dosen.sidang.respon.form', $notification->data['sidang_id']) }}" class="action-link">Respon Undangan</a>
                        @endif
                        <form action="{{ route('dosen.notifications.markAsRead', $notification->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit">Tandai Sudah Dibaca</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="no-items-message">Tidak ada notifikasi baru.</p>
            @endforelse
        </div>

        <div class="card-section sidang-invitations-section">
            <h3>Undangan Sidang Menunggu Respon</h3>
            @forelse ($sidangInvitations as $sidang)
                <div class="sidang-item">
                    <span class="dosen-role-badge">
                        @php
                            $dosenLoginId = Auth::user()->dosen->id;
                            if ($sidang->ketua_sidang_dosen_id == $dosenLoginId) echo 'Ketua Sidang';
                            elseif ($sidang->sekretaris_sidang_dosen_id == $dosenLoginId) echo 'Sekretaris Sidang';
                            elseif ($sidang->anggota1_sidang_dosen_id == $dosenLoginId) echo 'Anggota Sidang 1 (Penguji)';
                            elseif ($sidang->anggota2_sidang_dosen_id == $dosenLoginId) echo 'Anggota Sidang 2 (Penguji)';
                            elseif ($sidang->dosen_pembimbing_id == $dosenLoginId) echo 'Dosen Pembimbing 1';
                            elseif ($sidang->dosen_penguji1_id == $dosenLoginId) echo 'Dosen Pembimbing 2';
                        @endphp
                    </span>
                    <p><strong>Mahasiswa:</strong> {{ $sidang->pengajuan->mahasiswa->nama_lengkap }} (NIM: {{ $sidang->pengajuan->mahasiswa->nim }})</p>
                    <p><strong>Jenis Sidang:</strong> {{ strtoupper(str_replace('_', ' ', $sidang->pengajuan->jenis_pengajuan)) }}</p>
                    <p><strong>Tanggal & Waktu:</strong> {{ \Carbon\Carbon::parse($sidang->tanggal_waktu_sidang)->translatedFormat('l, d F Y H:i') }} WIB</p>
                    <p><strong>Ruangan:</strong> {{ $sidang->ruangan_sidang }}</p>
                    <a href="{{ route('dosen.sidang.respon.form', $sidang->id) }}" class="action-link">Respon Undangan Ini</a>
                </div>
            @empty
                <p class="no-items-message">Tidak ada undangan sidang yang menunggu respon Anda.</p>
            @endforelse
        </div>

        <div class="card-section approved-sidangs-section">
            <h3>Sidang yang Disetujui</h3>
            @forelse ($approvedSidangs as $sidang)
                <div class="sidang-item">
                    <span class="dosen-role-badge status-setuju">
                        @php
                            $dosenLoginId = Auth::user()->dosen->id;
                            $roleDisplayed = '';
                            if ($sidang->ketua_sidang_dosen_id == $dosenLoginId) $roleDisplayed = 'Ketua Sidang';
                            elseif ($sidang->sekretaris_sidang_dosen_id == $dosenLoginId) $roleDisplayed = 'Sekretaris Sidang';
                            elseif ($sidang->anggota1_sidang_dosen_id == $dosenLoginId) $roleDisplayed = 'Anggota Sidang 1 (Penguji)';
                            elseif ($sidang->anggota2_sidang_dosen_id == $dosenLoginId) $roleDisplayed = 'Anggota Sidang 2 (Penguji)';
                            elseif ($sidang->dosen_pembimbing_id == $dosenLoginId) $roleDisplayed = 'Dosen Pembimbing 1';
                            elseif ($sidang->dosen_penguji1_id == $dosenLoginId) $roleDisplayed = 'Dosen Pembimbing 2';
                            echo "$roleDisplayed (Disetujui)";
                        @endphp
                    </span>
                    <p><strong>Mahasiswa:</strong> {{ $sidang->pengajuan->mahasiswa->nama_lengkap }} (NIM: {{ $sidang->pengajuan->mahasiswa->nim }})</p>
                    <p><strong>Jenis Sidang:</strong> {{ strtoupper(str_replace('_', ' ', $sidang->pengajuan->jenis_pengajuan)) }}</p>
                    <p><strong>Tanggal & Waktu:</strong> {{ \Carbon\Carbon::parse($sidang->tanggal_waktu_sidang)->translatedFormat('l, d F Y H:i') }} WIB</p>
                    <p><strong>Ruangan:</strong> {{ $sidang->ruangan_sidang }}</p>
                    {{-- UNCOMMENTED: Link to view detailed submission (Pengajuan) --}}
                    <a href="{{ route('dosen.pengajuan.show', $sidang->pengajuan->id) }}" class="action-link approved">Lihat Detail Pengajuan</a>
                </div>
            @empty
                <p class="no-items-message">Belum ada sidang yang Anda setujui.</p>
            @endforelse
        </div>

        <div class="card-section rejected-sidangs-section">
            <h3>Sidang yang Ditolak</h3>
            @forelse ($rejectedSidangs as $sidang)
                <div class="sidang-item">
                    <span class="dosen-role-badge status-tolak">
                        @php
                            $dosenLoginId = Auth::user()->dosen->id;
                            $roleDisplayed = '';
                            if ($sidang->ketua_sidang_dosen_id == $dosenLoginId) $roleDisplayed = 'Ketua Sidang';
                            elseif ($sidang->sekretaris_sidang_dosen_id == $dosenLoginId) $roleDisplayed = 'Sekretaris Sidang';
                            elseif ($sidang->anggota1_sidang_dosen_id == $dosenLoginId) $roleDisplayed = 'Anggota Sidang 1 (Penguji)';
                            elseif ($sidang->anggota2_sidang_dosen_id == $dosenLoginId) $roleDisplayed = 'Anggota Sidang 2 (Penguji)';
                            elseif ($sidang->dosen_pembimbing_id == $dosenLoginId) $roleDisplayed = 'Dosen Pembimbing 1';
                            elseif ($sidang->dosen_penguji1_id == $dosenLoginId) $roleDisplayed = 'Dosen Pembimbing 2';
                            echo "$roleDisplayed (Ditolak)";
                        @endphp
                    </span>
                    <p><strong>Mahasiswa:</strong> {{ $sidang->pengajuan->mahasiswa->nama_lengkap }} (NIM: {{ $sidang->pengajuan->mahasiswa->nim }})</p>
                    <p><strong>Jenis Sidang:</strong> {{ strtoupper(str_replace('_', ' ', $sidang->pengajuan->jenis_pengajuan)) }}</p>
                    <p><strong>Tanggal & Waktu:</strong> {{ \Carbon\Carbon::parse($sidang->tanggal_waktu_sidang)->translatedFormat('l, d F Y H:i') }} WIB</p>
                    <p><strong>Ruangan:</strong> {{ $sidang->ruangan_sidang }}</p>
                    {{-- UNCOMMENTED: Link to view detailed submission (Pengajuan) --}}
                    <a href="{{ route('dosen.pengajuan.show', $sidang->pengajuan->id) }}" class="action-link rejected">Lihat Detail Pengajuan</a>
                </div>
            @empty
                <p class="no-items-message">Belum ada sidang yang Anda tolak.</p>
            @endforelse
        </div>
    </div>
</body>
</html>