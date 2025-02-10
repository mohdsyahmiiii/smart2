<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Attendance Report</h1>
    @foreach($attendances as $session)
        <h3>Session #{{ $session->id }} ({{ $session->created_at->format('Y-m-d') }})</h3>
        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($session->attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->student->name }}</td>
                        <td>{{ $attendance->student->email }}</td>
                        <td>{{ $attendance->scanned_at->format('H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html> 