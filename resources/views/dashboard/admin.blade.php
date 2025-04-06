<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
        }

        .sidebar a {
            color: white;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .content {
            padding: 20px;
        }

        .card {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 sidebar">
            <h4 class="text-center">Admin Panel</h4>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="#">Manage</a>
            <form action="{{ route('logout') }}" method="POST" class="mt-3 px-3">
                @csrf
                <button class="btn btn-sm btn-danger w-100">Logout</button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 content">
            <h2>Dashboard</h2>
            <p>Welcome, {{ Auth::user()->name }}!</p>

            <h4>All Articles</h4>

            <!-- Dummy Articles -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">How Laravel Works</h5>
                    <p class="card-text">An introductory article explaining the Laravel framework basics.</p>
                    <span class="badge bg-info">Author: John Doe</span>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">PHP 8 New Features</h5>
                    <p class="card-text">A quick overview of new features in PHP 8 and how they improve development.</p>
                    <span class="badge bg-info">Author: Jane Smith</span>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Building REST APIs</h5>
                    <p class="card-text">Learn how to build RESTful APIs using Laravel in simple steps.</p>
                    <span class="badge bg-info">Author: Admin</span>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>
