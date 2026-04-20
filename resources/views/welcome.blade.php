<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEIS | University Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .portal-card { transition: transform 0.2s; cursor: pointer; }
        .portal-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .hero-section { background: #0d6efd; color: white; padding: 60px 0; margin-bottom: 40px; }
    </style>
</head>
<body>

    <div class="hero-section text-center shadow">
        <h1 class="display-4 fw-bold">Student Enrollment Information System</h1>
        <p class="lead">Select your portal to continue</p>
    </div>

    <div class="container">
        <div class="row g-4 justify-content-center">
            
            <div class="col-md-5 col-lg-3">
                <a href="{{ route('apply') }}" class="text-decoration-none text-dark">
                    <div class="card portal-card h-100 border-0 shadow-sm text-center p-4">
                        <h1 class="text-success mb-3">📝</h1>
                        <h4 class="card-title fw-bold">Admission</h4>
                        <p class="card-text text-muted">Apply for enrollment as a new student.</p>
                        <span class="btn btn-outline-success mt-auto">Apply Now</span>
                    </div>
                </a>
            </div>

            <div class="col-md-5 col-lg-3">
                <a href="{{ route('login') }}" class="text-decoration-none text-dark">
                    <div class="card portal-card h-100 border-0 shadow-sm text-center p-4">
                        <h1 class="text-primary mb-3">🎓</h1>
                        <h4 class="card-title fw-bold">Student Portal</h4>
                        <p class="card-text text-muted">View grades, schedules, and enrollment status.</p>
                        <span class="btn btn-outline-primary mt-auto">Student Login</span>
                    </div>
                </a>
            </div>

            <div class="col-md-5 col-lg-3">
                <a href="{{ route('login') }}" class="text-decoration-none text-dark">
                    <div class="card portal-card h-100 border-0 shadow-sm text-center p-4">
                        <h1 class="text-warning mb-3">👨‍🏫</h1>
                        <h4 class="card-title fw-bold">Staff Portal</h4>
                        <p class="card-text text-muted">Review applications and assign sections.</p>
                        <span class="btn btn-outline-warning mt-auto">Staff Login</span>
                    </div>
                </a>
            </div>

            <div class="col-md-5 col-lg-3">
                <a href="{{ route('login') }}" class="text-decoration-none text-dark">
                    <div class="card portal-card h-100 border-0 shadow-sm text-center p-4">
                        <h1 class="text-danger mb-3">⚙️</h1>
                        <h4 class="card-title fw-bold">Admin Portal</h4>
                        <p class="card-text text-muted">Manage users, subjects, and system settings.</p>
                        <span class="btn btn-outline-danger mt-auto">Admin Login</span>
                    </div>
                </a>
            </div>

        </div>
    </div>

</body>
</html>