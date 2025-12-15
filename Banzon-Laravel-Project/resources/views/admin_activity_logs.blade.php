@extends('admin.layout')

@section('title', 'Activity Logs')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h6 class="mb-0">Activity Logs</h6>
        </div>

        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        <th>ID</th>
                        <th>Actor</th>
                        <th>Module</th>
                        <th>Action</th>
                        <th>Route</th>
                        <th>IP</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $l)
                        <tr>
                            <td>{{ $l->id }}</td>
                            <td>{{ strtoupper($l->actor_type ?? 'GUEST') }} ({{ $l->actor_id ?? '-' }})</td>
                            <td>{{ $l->module }}</td>
                            <td>{{ $l->action }}</td>
                            <td>{{ $l->method }} {{ $l->route_name ?? '-' }}</td>
                            <td>{{ $l->ip_address }}</td>
                            <td>{{ \Carbon\Carbon::parse($l->created_at)->format('d M Y, h:i A') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">No logs yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
