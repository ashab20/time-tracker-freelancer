<!DOCTYPE html>
<html>
<head>
    <title>Time Logs Report</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Time Logs Report</h1>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Project</th>
                <th>Client</th>
                <th>Hours</th>
                <th>Tags</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->date }}</td>
                <td>{{ $log->project->name }}</td>
                <td>{{ $log->client->name }}</td>
                <td>{{ $log->hours }}</td>
                <td>{{ implode(', ', $log->tags ?? []) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>