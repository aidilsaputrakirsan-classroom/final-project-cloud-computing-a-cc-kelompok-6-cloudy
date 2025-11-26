@extends('layouts.admin')

@section('title', 'Activity Log')

@section('page_header')
    <h4 class="m-0">
        <i class="bi bi-clock-history me-2"></i> Activity Log
    </h4>
@endsection

@section('content')
<div class="card shadow-sm border-10">
    <div class="card-body">
        <table class="table table-striped table-bordered align-middle">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Aktivitas</th>
                    <th>IP Address</th>
                    <th>Browser</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr>
                    <td>{{ $log->name }}</td>
                    <td>{{ $log->role }}</td>
                    <td>{{ $log->activity }}</td>
                    <td>{{ $log->ip }}</td>
                    <td>{{ Str::limit($log->user_agent, 25) }}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
