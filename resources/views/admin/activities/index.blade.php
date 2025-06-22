<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Aktivitas</title>
</head>
<body>

    <h2>Log Aktivitas</h2>

    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>User</th>
                <th>Aktivitas</th>
                <th>Modul</th>
                <th>IP Address</th>
                <th>User Agent</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $activity)
                <tr>
                    <td>{{ $activity->created_at }}</td>
                    <td>{{ $activity->user ? $activity->user->name : 'Sistem' }}</td>
                    <td>{{ $activity->activity }}</td>
                    <td>{{ $activity->module }}</td>
                    <td>{{ $activity->ip_address }}</td>
                    <td>{{ $activity->user_agent }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $activities->links() }}  </body>
</html>