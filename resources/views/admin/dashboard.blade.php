@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Admin Dashboard</div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Lecturers</h5>
                                    <p class="card-text">Total: {{ $lecturers->count() }}</p>
                                    <a href="{{ route('admin.lecturers.index') }}" class="btn btn-primary">Manage Lecturers</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Students</h5>
                                    <p class="card-text">Total: {{ $students->count() }}</p>
                                    <a href="{{ route('admin.students.index') }}" class="btn btn-primary">Manage Students</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 