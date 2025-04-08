<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Responsive -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
            background-color: #343a40;
            color: white;
            padding-top: 20px;
            min-height: 100vh;
        }

        .sidebar a {
            color: white;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #495057;
        }

        .content {
            padding: 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                height: auto;
                padding-bottom: 15px;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <div class="col-md-3 col-12 sidebar">
            <h4 class="text-center mb-4">Admin Panel</h4>

            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.articles.manage') }}" class="{{ request()->routeIs('admin.articles.manage') ? 'active' : '' }}">Manage Articles</a>
            <a href="{{ route('articles.approval') }}" class="{{ request()->routeIs('admin.articles.approval') ? 'active' : '' }}">Detail / Approval</a>
            <form action="{{ route('logout') }}" method="POST" class="mt-4 px-3">
                @csrf
                <button class="btn btn-sm btn-danger w-100">Logout</button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-12 content">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
