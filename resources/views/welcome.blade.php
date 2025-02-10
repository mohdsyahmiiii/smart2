<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Smart Attendance System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            .feature-icon {
                font-size: 2.5rem;
                color: #0d6efd;
                margin-bottom: 1rem;
            }
            .hero-section {
                background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3');
                background-size: cover;
                background-position: center;
                color: white;
                padding: 100px 0;
            }
            .feature-card {
                transition: transform 0.3s ease;
                cursor: pointer;
            }
            .feature-card:hover {
                transform: translateY(-5px);
            }
        </style>
    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Smart Attendance</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
            @if (Route::has('login'))
                    @auth
                                @if(auth()->user()->isLecturer())
                                    <li class="nav-item">
                                        <a href="{{ route('lecturer.dashboard') }}" class="nav-link">Dashboard</a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a href="{{ route('student.dashboard') }}" class="nav-link">Dashboard</a>
                                    </li>
                                @endif
                    @else
                                <li class="nav-item">
                                    <a href="{{ route('login') }}" class="nav-link">Log in</a>
                                </li>
                        @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                                    </li>
                                @endif
                            @endauth
                        @endif
                    </ul>
                </div>
                </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-section text-center">
            <div class="container">
                <h1 class="display-4 mb-4">Smart Attendance System</h1>
                <p class="lead mb-5">Revolutionizing attendance tracking with QR code technology</p>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-3">Get Started</a>
                @endif
                <a href="#features" class="btn btn-outline-light btn-lg">Learn More</a>
                                </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-5">
            <div class="container">
                <h2 class="text-center mb-5">Key Features</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 feature-card">
                            <div class="card-body text-center">
                                <div class="feature-icon">📱</div>
                                <h5 class="card-title">QR Code Scanning</h5>
                                <p class="card-text">Quick and easy attendance marking using QR code technology through mobile devices.</p>
                            </div>
                        </div>
                                </div>
                    <div class="col-md-4">
                        <div class="card h-100 feature-card">
                            <div class="card-body text-center">
                                <div class="feature-icon">📊</div>
                                <h5 class="card-title">Real-time Analytics</h5>
                                <p class="card-text">Comprehensive dashboard with attendance statistics and detailed reports.</p>
                            </div>
                                </div>
                            </div>
                    <div class="col-md-4">
                        <div class="card h-100 feature-card">
                            <div class="card-body text-center">
                                <div class="feature-icon">🔔</div>
                                <h5 class="card-title">Instant Notifications</h5>
                                <p class="card-text">Real-time Telegram notifications when students mark their attendance.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works -->
        <section class="bg-light py-5">
            <div class="container">
                <h2 class="text-center mb-5">How It Works</h2>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h4>For Lecturers</h4>
                        <ul class="list-group">
                            <li class="list-group-item">1. Generate unique QR codes for each session</li>
                            <li class="list-group-item">2. Monitor real-time attendance</li>
                            <li class="list-group-item">3. Access detailed analytics and reports</li>
                            <li class="list-group-item">4. Receive instant notifications</li>
                        </ul>
                    </div>
                    <div class="col-md-6 mb-4">
                        <h4>For Students</h4>
                        <ul class="list-group">
                            <li class="list-group-item">1. Scan QR code using smartphone</li>
                            <li class="list-group-item">2. Mark attendance instantly</li>
                            <li class="list-group-item">3. View attendance history</li>
                            <li class="list-group-item">4. Track personal attendance records</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-dark text-light py-4">
            <div class="container text-center">
                <p class="mb-0">© 2024 Smart Attendance System. All rights reserved.</p>
        </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
