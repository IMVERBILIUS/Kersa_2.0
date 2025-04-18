<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Kersa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e6f7f1 100%);
            min-height: 100vh;
        }

        .card {
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.9);
        }

        .card-body {
            padding: 2.5rem;
        }

        .logo-container {
            width: 80px;
            height: 80px;
            background-color: #e6f7f1;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.2);
        }

        .logo-icon {
            font-size: 2.5rem;
            color: #36b37e;
        }

        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1px solid rgba(102, 126, 234, 0.2);
            background-color: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.15);
        }

        .input-group-text {
            background-color: transparent;
            border-right: none;
        }

        .form-control.border-start-0 {
            border-left: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #5B93FF 0%, #4A7FD9 100%);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(102, 126, 234, 0.3);
        }

        .alert {
            border-radius: 12px;
            border: none;
        }

        .alert-success {
            background-color: rgba(52, 199, 89, 0.1);
            color: #34c759;
        }

        .alert-danger {
            background-color: rgba(255, 59, 48, 0.1);
            color: #ff3b30;
        }

        .social-login {
            background: white;
            border-radius: 12px;
            padding: 1rem;
            transition: all 0.3s ease;
        }

        .social-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .social-icon {
            width: 24px;
            height: 24px;
            margin-right: 0.5rem;
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 1.5rem;
            }

            .logo-container {
                width: 60px;
                height: 60px;
            }

            .logo-icon {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center py-4 py-sm-5">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-8 col-md-7 col-lg-5 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="logo-container">
                            <i class="fas fa-book-reader logo-icon"></i>
                        </div>
                        <h1 class="h3 fw-bold text-dark mb-1">Selamat Datang</h1>
                        <p class="text-muted mb-0">Masuk ke akun Anda untuk melanjutkan</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success d-flex align-items-center mb-3">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger d-flex align-items-center mb-3">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium text-dark">Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input type="email" name="email" id="email" required
                                       class="form-control border-start-0"
                                       placeholder="nama@email.com">
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="password" class="form-label fw-medium text-dark">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" name="password" id="password" required
                                       class="form-control border-start-0"
                                       placeholder="Masukkan password Anda">
                            </div>
                        </div>

                        <div class="mb-4 text-end">
                            <a href="{{ route('password.request') }}" class="text-decoration-none text-primary small fw-medium">
                                Lupa Password?
                            </a>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-4">
                            <i class="fas fa-sign-in-alt me-2"></i> Masuk
                        </button>

                        <div class="text-center text-muted mb-4">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="text-decoration-none fw-medium text-primary">Daftar di sini</a>
                        </div>

                        <div class="text-center">
                            <p class="text-muted mb-3">Atau masuk dengan</p>
                            <div class="social-login">
                                <a href="{{ route('auth.google') }}" class="d-flex align-items-center justify-content-center text-decoration-none text-dark">
                                    <svg class="social-icon" viewBox="0 0 24 24">
                                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                                    </svg>
                                    <span class="ms-2">Google</span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
