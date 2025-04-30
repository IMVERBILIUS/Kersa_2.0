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
            width: 20%;
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
            padding-bottom: 80px;
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
            margin-left: 20%;
            width: 80%;
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

        .mobile-block {
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #e6f7f1 100%);
            padding: 2rem;
            text-align: center;
            overflow: hidden;
            position: relative;
            z-index: 9999;
        }

        .mobile-block-content {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 2.5rem 2rem;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
            width: 90%;
            max-width: 400px;
            animation: fadeIn 0.8s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.6);
            position: relative;
            overflow: hidden;
        }

        .mobile-icon {
            font-size: 3.5rem;
            color: #36b37e;
            margin-bottom: 1.5rem;
            animation: pulse 2s infinite;
        }

        .mobile-block h2 {
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .mobile-block p {
            color: #5b6171;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .desktop-btn {
            background-color: #36b37e;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0 auto;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(54, 179, 126, 0.2);
        }

        .desktop-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(54, 179, 126, 0.3);
        }

        .bg-shapes::before, .bg-shapes::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            z-index: -1;
        }

        .bg-shapes::before {
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background-color: rgba(54, 179, 126, 0.1);
        }

        .bg-shapes::after {
            bottom: -70px;
            left: -70px;
            width: 250px;
            height: 250px;
            background-color: rgba(54, 179, 126, 0.08);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px);}
            to { opacity: 1; transform: translateY(0);}
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1);}
            50% { transform: scale(1.1);}
        }

        @media (max-width: 768px) {
            body > *:not(.mobile-block) {
                display: none !important;
            }
            .mobile-block {
                display: flex !important;
            }
        }
    </style>
</head>
<body>

<!-- Mobile Block -->
<div class="mobile-block">
    <div class="mobile-block-content">
        <div class="bg-shapes"></div>
        <div class="mobile-icon">
            <i class="fas fa-laptop"></i>
        </div>
        <h2>Desktop Experience Required</h2>
        <p>This admin dashboard is optimized for larger screens to provide you with the best management experience. Please switch to a tablet or desktop device.</p>
        <button class="desktop-btn">
            <i class="fas fa-desktop"></i> Best on Desktop
        </button>
    </div>
</div>

<div class="container-fluid p-0">
    <div class="row g-0">
        <!-- Sidebar -->
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
                    <a href="{{ route('articles.approval') }}" class="{{ request()->routeIs('articles.approval') ? 'active' : '' }}">
                        <i class="fas fa-check-circle"></i> Detail / Approval
                    </a>
                    <a href="{{ route('admin.galleries.manage') }}" class="{{ request()->routeIs('admin.galleries.manage') ? 'active' : '' }}">
                        <i class="fas fa-image"></i> Gallery
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('scripts')

</body>
</html>
