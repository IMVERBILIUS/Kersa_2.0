<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 25%;
            height: 100vh;
            background-color: white;
            box-shadow: 0 1px 10px rgba(100, 100, 100, 0.05);
            padding-top: 30px;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-content {
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
            padding-bottom: 80px; /* Space for logout button */
        }

        .sidebar h4 {
            font-weight: 700;
            color: #5b6171;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .sidebar a {
            font-weight: 500;
            display: flex;
            align-items: center;
            color: #5b6171;
            padding: 12px 20px;
            margin: 8px 15px;
            text-decoration: none;
            transition: all 0.3s;
            border-radius: 10px;
        }

        .sidebar a i {
            margin-right: 10px;
            font-size: 18px;
        }

        .sidebar a:hover {
            background-color: #e6f7f1;
            color: #36b37e;
            transform: translateX(5px);
        }

        .sidebar a.active {
            background-color: #e6f7f1;
            color: #36b37e;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(54, 179, 126, 0.15);
        }

        .main-content {
            margin-left: 25%;
            width: 75%;
        }

        .content {
            padding: 30px;
            background-color: #FAFBFF;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.03);
        }

        .btn-logout {
            position: absolute;
            bottom: 20px;
            left: 15px;
            right: 15px;
            background-color: #fff;
            border: 1px solid #ff6b6b;
            padding: 12px 20px;
            border-radius: 10px;
            color: #ff6b6b;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-logout:hover {
            background-color: #fff8f8;
            box-shadow: 0 2px 8px rgba(255, 107, 107, 0.2);
        }

        .btn-logout i {
            margin-right: 8px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-container .logo {
            width: 60px;
            height: 60px;
            background-color: #e6f7f1;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .logo-container .logo i {
            font-size: 30px;
            color: #36b37e;
        }

        .nav-links {
            flex-grow: 1;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding-bottom: 85px;
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 15px;
            }
            
            .content {
                margin-top: 0;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid p-0">
    <div class="row g-0">
        <!-- Fixed Sidebar -->
        <div class="sidebar">
            <div class="sidebar-content">
                <div class="logo-container">
                    <div class="logo">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <h4>Admin Panel</h4>
                </div>

                <div class="nav-links">
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.articles.manage') }}" class="{{ request()->routeIs('admin.articles.manage') ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i> Manage Articles
                    </a>
                    <a href="{{ route('articles.approval') }}" class="{{ request()->routeIs('admin.articles.approval') ? 'active' : '' }}">
                        <i class="fas fa-check-circle"></i> Detail / Approval
                    </a>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>