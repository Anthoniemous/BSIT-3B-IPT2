<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Activity Logs | Coffee Admin</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('admin/darkpan/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/darkpan/css/light.css') }}">
</head>
<body>

<div class="container-fluid p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Activity Logs</h4>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-primary">Back</a>
  </div>

  <div class="bg-secondary rounded p-4">
    <div class="table-responsive">
      <table class="table table-bordered table-hover mb-0">
        <thead>
          <tr>
            <th>Date</th>
            <th>User</th>
            <th>Role</th>
            <th>Module</th>
            <th>Action</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          @forelse($logs as $log)
            <tr>
              <td>{{ optional($log->created_at)->format('M d, Y h:i A') }}</td>
              <td>{{ $log->user_id ?? '—' }}</td>
              <td>{{ $log->role ?? '—' }}</td>
              <td>{{ $log->module ?? '—' }}</td>
              <td>{{ $log->action }}</td>
              <td>{{ $log->description ?? '—' }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center">No logs yet.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $logs->links() }}
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
