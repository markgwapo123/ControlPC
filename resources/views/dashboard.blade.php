<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remote PC Control</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2 class="mb-4">Remote PC Control</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>IP Address</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pcs as $pc)
            <tr>
                <td>{{ $pc->id }}</td>
                <td>{{ $pc->ip }}</td>
                <td>
                    <span class="badge bg-{{ $pc->status == 'connected' ? 'success' : 'danger' }}">
                        {{ ucfirst($pc->status) }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-danger" onclick="controlPC('{{ $pc->ip }}', 'shutdown')">Shutdown</button>
                    <button class="btn btn-warning" onclick="controlPC('{{ $pc->ip }}', 'restart')">Restart</button>
                    <button class="btn btn-success" onclick="controlPC('{{ $pc->ip }}', 'wake')">Wake-on-LAN</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function controlPC(ip, action) {
            $.post("{{ url('/api/control-pc') }}", { ip: ip, action: action, _token: "{{ csrf_token() }}" }, function(response) {
                alert(response.message);
                location.reload();
            }).fail(function() {
                alert('Failed to send command.');
            });
        }
    </script>

</body>
</html>
