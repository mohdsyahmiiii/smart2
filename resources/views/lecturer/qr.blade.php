@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Generate QR Code</h4>
                </div>
                <div class="card-body">
                    <!-- QR Code Generation Form -->
                    <form method="POST" action="{{ route('qr.generate') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="session_name">Session Name</label>
                            <input type="text" class="form-control" id="session_name" name="session_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Generate QR</button>
                    </form>

                    <!-- Display QR Code if available -->
                    @if(isset($qrCode))
                        <div class="text-center mt-4">
                            <h5>Session: {{ $sessionName }}</h5>
                            <div class="qr-code-container">
                                {!! $qrCode !!}
                            </div>
                            <p class="mt-2">Expires in: {{ $expiresIn }} minutes</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 