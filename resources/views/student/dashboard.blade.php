@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Student Dashboard</div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <h4>Scan QR Code</h4>
                        <button class="btn btn-primary" onclick="startScanner()">Open Scanner</button>
                    </div>

                    <div id="reader" class="mb-4" style="display: none;"></div>

                    <h4>Recent Attendances</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(auth()->user()->attendances()->latest()->take(5)->get() as $attendance)
                                <tr>
                                    <td>{{ $attendance->scanned_at->format('Y-m-d') }}</td>
                                    <td>{{ $attendance->scanned_at->format('H:i:s') }}</td>
                                    <td><span class="badge bg-success">Present</span></td>
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

<!-- Include HTML5-QRCode library -->
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
let html5QrcodeScanner = null;

function startScanner() {
    const reader = document.getElementById('reader');
    reader.style.display = 'block';

    if (html5QrcodeScanner === null) {
        html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: 250 }
        );
    }

    html5QrcodeScanner.render((decodedText) => {
        // Handle the scanned code
        window.location.href = decodedText;
        html5QrcodeScanner.clear();
        reader.style.display = 'none';
    });
}
</script>
@endsection 