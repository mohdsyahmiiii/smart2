@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Lecturer Dashboard</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Generate QR Code</h5>
                                    <p class="card-text">Create a new attendance session with QR code</p>
                                    <a href="{{ route('qr.generate') }}" class="btn btn-primary">Generate QR</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Analytics</h5>
                                    <p class="card-text">View attendance statistics and reports</p>
                                    <a href="{{ route('lecturer.analytics') }}" class="btn btn-info">View Analytics</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Download Report</h5>
                                    <p class="card-text">Generate and download attendance reports</p>
                                    <a href="{{ route('attendance.report') }}" class="btn btn-success">Download PDF</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Sessions -->
                    <div class="mt-4">
                        <h4>Recent Sessions</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Attendees</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentSessions as $session)
                                    <tr>
                                        <td>{{ $session->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td>{{ $session->attendances->count() }}</td>
                                        <td>
                                            @if($session->is_active && $session->expires_at->isFuture())
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Expired</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 