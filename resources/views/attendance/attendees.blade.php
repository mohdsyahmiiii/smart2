@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Attendees for Session: {{ $session->session_name }}</h4>
                </div>
                <div class="card-body">
                    @if($attendees->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Time Recorded</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendees as $attendance)
                                    <tr>
                                        <td>{{ $attendance->student->student->student_id }}</td>
                                        <td>{{ $attendance->student->name }}</td>
                                        <td>{{ $attendance->scanned_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No attendees found for this session.</p>
                    @endif
                    
                    <a href="{{ route('lecturer.analytics') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 