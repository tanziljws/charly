<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Admin SMKN 4 BOGOR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #64748b;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #06b6d4;
            --light: #f8fafc;
            --dark: #0f172a;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--gray-50);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
        }

        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: white;
            color: var(--gray-900);
            padding: 2.5rem 2rem 2rem 2rem;
            text-align: center;
            border-bottom: 1px solid var(--gray-200);
        }

        .school-logo {
            width: 80px;
            height: 80px;
            background: var(--gray-100);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            border: 1px solid var(--gray-200);
        }

        .school-logo i {
            font-size: 2rem;
            color: var(--gray-600);
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--gray-900);
        }

        .login-subtitle {
            font-size: 0.875rem;
            color: var(--gray-600);
            font-weight: 400;
        }

        .login-body {
            padding: 2.5rem 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .form-control-modern {
            width: 100%;
            padding: 0.875rem 1rem;
            padding-left: 3rem;
            font-size: 0.95rem;
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            background: var(--gray-50);
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-control-modern:focus {
            outline: none;
            border-color: var(--gray-900);
            background: white;
            box-shadow: 0 0 0 3px rgba(17, 24, 39, 0.1);
        }

        .form-control-modern.is-invalid {
            border-color: var(--danger);
            background: #fef2f2;
        }

        .form-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            font-size: 1rem;
            pointer-events: none;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .password-toggle:hover {
            color: var(--gray-600);
            background: var(--gray-100);
        }

        .form-check-modern {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }

        .form-check-modern input[type="checkbox"] {
            width: 18px;
            height: 18px;
            border: 2px solid var(--gray-300);
            border-radius: 4px;
            background: white;
            cursor: pointer;
        }

        .form-check-modern input[type="checkbox"]:checked {
            background: var(--gray-900);
            border-color: var(--gray-900);
        }

        .form-check-modern label {
            font-size: 0.875rem;
            color: var(--gray-600);
            cursor: pointer;
            user-select: none;
        }

        .btn-login {
            width: 100%;
            padding: 0.875rem 1.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            color: white;
            background: var(--gray-900);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-login:hover {
            background: var(--gray-800);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            margin: 2rem 0;
            position: relative;
            text-align: center;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--gray-200);
        }

        .divider span {
            background: white;
            color: var(--gray-500);
            font-size: 0.875rem;
            padding: 0 1rem;
            position: relative;
        }

        .auth-footer {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            align-items: center;
        }

        .auth-info {
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.8rem;
            color: var(--gray-600);
            text-align: center;
            width: 100%;
        }

        .auth-info i {
            color: var(--info);
            margin-right: 0.5rem;
        }

        .btn-register {
            color: var(--gray-900);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-register:hover {
            background: var(--gray-100);
            color: var(--gray-900);
        }

        .alert-modern {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            color: #065f46;
            border-left: 4px solid var(--success);
        }

        .alert-danger {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            color: #991b1b;
            border-left: 4px solid var(--danger);
        }

        .invalid-feedback {
            display: block;
            font-size: 0.8rem;
            color: var(--danger);
            margin-top: 0.5rem;
            font-weight: 500;
        }

        @media (max-width: 576px) {
            .login-container {
                max-width: 100%;
                margin: 0;
            }
            
            .login-card {
                border-radius: 16px;
                margin: 0.5rem;
            }
            
            .login-header {
                padding: 2rem 1.5rem 1.5rem;
            }
            
            .login-body {
                padding: 2rem 1.5rem;
            }
            
            .school-logo {
                width: 70px;
                height: 70px;
            }
            
            .login-title {
                font-size: 1.25rem;
            }
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
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="school-logo">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1 class="login-title">SMKN 4 BOGOR</h1>
                <p class="login-subtitle">Portal Admin Sekolah</p>
            </div>
            
            <div class="login-body">
                @if(session('success'))
                    <div class="alert-modern alert-success">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert-modern alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        @foreach($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="position-relative">
                            <i class="form-icon fas fa-envelope"></i>
                            <input type="email" 
                                   class="form-control-modern @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   placeholder="admin@example.com" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="position-relative">
                            <i class="form-icon fas fa-lock"></i>
                            <input type="password" 
                                   class="form-control-modern @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Enter your password" 
                                   required>
                            <div class="password-toggle" onclick="togglePassword('password','icon-pass-login')">
                                <i id="icon-pass-login" class="fas fa-eye"></i>
                            </div>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check-modern">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me for 30 days</label>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Sign In to Dashboard
                    </button>
                </form>

                <div class="divider">
                    <span>Login Information</span>
                </div>
                
                <div class="auth-footer">
                    <div class="auth-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Default Login:</strong> admin@gallery.local / password123
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add loading state to form submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.btn-login');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Signing In...';
            submitBtn.disabled = true;
            
            // Re-enable button after 3 seconds in case of error
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 3000);
        });

        // Add focus animations
        document.querySelectorAll('.form-control-modern').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
    </script>
</body>
</html>
