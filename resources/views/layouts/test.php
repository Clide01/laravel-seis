<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>SEIS | Admin Dashboard</title>
</head>
<body>
    <div class="d-flex">
        <nav class="bg-dark text-white p-3" style="width: 250px; min-height: 100vh;">
            <h4>SEIS Admin</h4>
            <ul class="nav flex-column mt-4">
                <li class="nav-item"><a href="/admin/dashboard" class="nav-link text-white">Dashboard</a></li>
                <li class="nav-item"><a href="/admin/students" class="nav-link text-white">Students</a></li>
                <li class="nav-item"><a href="/admin/sections" class="nav-link text-white">Sections</a></li>
            </ul>
        </nav>
        
        <main class="flex-grow-1 p-4">
            @yield('content')
        </main>
    </div>
</body>
</html>