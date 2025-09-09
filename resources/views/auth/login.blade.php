<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Admin Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --bg: #f9fafb;
            --card: #ffffff;
            --text: #0f172a;
            --muted: #6b7280;
            --border: #e5e7eb;
        }
        body {
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            background: var(--card);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            border: 1px solid var(--border);
            overflow: hidden;
        }
        .login-header {
            background: var(--card);
            color: var(--text);
            padding: 1.5rem 2rem;
            text-align: center;
            border-bottom: 1px solid var(--border);
        }
        .login-body { padding: 2rem; }
        .form-floating .form-control {
            border: 1px solid var(--border);
            border-radius: 10px;
        }
        .form-floating .form-control:focus {
            border-color: #d1d5db;
            box-shadow: 0 0 0 0.2rem rgba(17,24,39,0.05);
        }
        .btn-login {
            background: #111827;
            color: #fff;
            border: 1px solid #111827;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
        }
        .btn-login:hover { filter: brightness(0.95); box-shadow: 0 6px 14px rgba(17,24,39,0.18); }
        .btn-register {
            background: transparent;
            color: #111827;
            border: 1px solid #111827;
            border-radius: 10px;
            padding: 8px 14px;
            font-weight: 600;
            text-decoration: none;
        }
        .btn-register:hover { background: #111827; color: #ffffff; box-shadow: 0 6px 14px rgba(17,24,39,0.12); }
        .auth-footer { display: flex; flex-wrap: wrap; gap: 10px 16px; align-items: center; justify-content: space-between; }
        .auth-meta { color: var(--muted); font-size: 0.875rem; display: flex; align-items: center; gap: 6px; }
        .auth-cta { display: flex; align-items: center; gap: 8px; }
        @media (max-width: 576px) {
            .auth-footer { flex-direction: column; align-items: flex-start; }
            .btn-login { padding: 12px 14px; }
        }
    </style>
    <script>
        function togglePassword(id, toggleId){
            const input = document.getElementById(id);
            const icon = document.getElementById(toggleId);
            if (!input || !icon) return;
            if (input.type === 'password') { input.type = 'text'; icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); }
            else { input.type = 'password'; icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-card">
                    <div class="login-header">
                        <i class="fas fa-images fa-2x mb-2 text-muted"></i>
                        <h4 class="mb-0">Admin Sekolah SMA MADESU 1</h4>
                        <p class="mb-0 text-muted small">Masuk ke Panel Admin</p>
                    </div>
                    
                    <div class="login-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                @foreach($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" placeholder="name@example.com" 
                                       value="{{ old('email') }}" required autofocus>
                                <label for="email"><i class="fas fa-envelope me-2"></i>Email</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3 position-relative">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" placeholder="Password" required>
                                <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
                                <span class="position-absolute top-50 end-0 translate-middle-y pe-3" style="cursor:pointer" onclick="togglePassword('password','icon-pass-login')"><i id="icon-pass-login" class="fas fa-eye text-muted"></i></span>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Ingat saya
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-login w-100">
                                <i class="fas fa-sign-in-alt me-2"></i>Masuk
                            </button>
                        </form>

                        <hr class="my-4">
                        <div class="auth-footer">
                            <div class="auth-meta">
                                <i class="fas fa-info-circle"></i>
                                <span>Default: admin@gallery.local / password123</span>
                            </div>
                            <div class="auth-cta">
                                <small class="text-muted">Belum punya akun?</small>
                                <a href="{{ route('register') }}" class="btn btn-register btn-sm">Buat akun admin</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
