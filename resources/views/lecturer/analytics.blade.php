@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Attendance Analytics</span>
                    <a href="{{ route('attendance.report') }}" class="btn btn-primary">Download PDF Report</a>
                </div>
                <div class="card-body">
                    <!-- Attendance Chart -->
                    <div class="Attendance Overview">
                        <h2 class="text-xl font-semibold mb-4">Attendance Overview</h2>
                        
                        <div class="bg-white p-4 rounded-lg shadow">
                            <canvas id="attendanceChart"></canvas>
                        </div>
                    </div>

                    <!-- Recent Sessions Table -->
                    <div class="mt-4">
                        <h4>Recent Sessions</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Session Date</th>
                                        <th>Total Attendees</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sessions as $session)
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
                                        <td>
                                            <a href="{{ route('attendance.viewAttendees', $session->id) }}" class="btn btn-info">View Attendees</a>
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

<!-- Attendees Modal -->
<div class="modal fade" id="attendeesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Session Attendees</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="attendeesList"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
.Attendance.Overview .bg-white {
    min-height: 400px;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartData['labels']),
            datasets: [{
                label: 'Number of Students',
                data: @json($chartData['data']),
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Student Attendance per Session'
                },
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        }
    });
});

// Function to show attendees in modal
function showAttendees(sessionId) {
    fetch(`/api/sessions/${sessionId}/attendees`)
        .then(response => response.json())
        .then(data => {
            const list = document.getElementById('attendeesList');
            list.innerHTML = data.map(attendee => `
                <div class="d-flex justify-content-between border-bottom py-2">
                    <span>${attendee.student.name}</span>
                    <span>${new Date(attendee.scanned_at).toLocaleTimeString()}</span>
                </div>
            `).join('');
            new bootstrap.Modal(document.getElementById('attendeesModal')).show();
        });
}
</script>
@endpush 