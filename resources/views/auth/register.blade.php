<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Admin - SMA MADESU 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --bg: #f9fafb; --card: #ffffff; --text: #0f172a; --muted: #6b7280; --border: #e5e7eb; }
        body { background: var(--bg); min-height: 100vh; display: flex; align-items: center; }
        .card-auth { background: var(--card); border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.06); border: 1px solid var(--border); overflow: hidden; }
        .card-header-auth { background: var(--card); color: var(--text); padding: 1.5rem 2rem; text-align: center; border-bottom: 1px solid var(--border); }
        .card-body-auth { padding: 2rem; }
        .form-floating .form-control { border: 1px solid var(--border); border-radius: 10px; }
        .form-floating .form-control:focus { border-color: #d1d5db; box-shadow: 0 0 0 0.2rem rgba(17,24,39,0.05); }
        .btn-primary { background: #111827; color: #fff; border: 1px solid #111827; border-radius: 10px; padding: 12px; font-weight: 600; }
        .btn-primary:hover { filter: brightness(0.95); box-shadow: 0 6px 14px rgba(17,24,39,0.18); }
        .btn-login-link { background: transparent; color: #111827; border: 1px solid #111827; border-radius: 10px; padding: 8px 14px; font-weight: 600; text-decoration: none; }
        .btn-login-link:hover { background: #111827; color: #ffffff; box-shadow: 0 6px 14px rgba(17,24,39,0.12); }
        .muted { color: var(--muted); }
    </style>
    <script>
        // Optional: simple password toggle
        function togglePassword(id, toggleId){
            const input = document.getElementById(id);
            const icon = document.getElementById(toggleId);
            if(input.type === 'password'){ input.type = 'text'; icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); }
            else { input.type = 'password'; icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }
        }
    </script>
    </head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card-auth">
                    <div class="card-header-auth">
                        <i class="fas fa-user-shield fa-2x mb-2 text-muted"></i>
                        <h4 class="mb-0">Daftar Admin Baru</h4>
                        <p class="mb-0 muted small">Buat akun untuk Panel Admin</p>
                    </div>
                    <div class="card-body-auth">
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus>
                                <label for="name"><i class="fas fa-user me-2"></i>Nama Lengkap</label>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="email@example.com" value="{{ old('email') }}" required>
                                <label for="email"><i class="fas fa-envelope me-2"></i>Email</label>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-floating mb-3 position-relative">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                                <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
                                <span class="position-absolute top-50 end-0 translate-middle-y pe-3" style="cursor:pointer" onclick="togglePassword('password','icon-pass')"><i id="icon-pass" class="fas fa-eye text-muted"></i></span>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-floating mb-4 position-relative">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" required>
                                <label for="password_confirmation"><i class="fas fa-lock me-2"></i>Konfirmasi Password</label>
                                <span class="position-absolute top-50 end-0 translate-middle-y pe-3" style="cursor:pointer" onclick="togglePassword('password_confirmation','icon-pass2')"><i id="icon-pass2" class="fas fa-eye text-muted"></i></span>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-user-plus me-2"></i>Buat Akun
                            </button>
                        </form>

                        <div class="d-flex justify-content-end align-items-center">
                            <small class="muted me-2">Sudah punya akun?</small>
                            <a href="{{ route('login') }}" class="btn btn-login-link btn-sm">Masuk</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


