<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Sistem Parkir TU Jakarta</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --telkom-red: #E31E24;
            --telkom-dark: #1a1a1a;
            --telkom-gray: #6c757d;
            --telkom-light: #f8f9fa;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ffffff 0%, #f5f5f5 100%);
            font-family: 'Inter', sans-serif;
            position: relative;
            overflow: hidden;
        }
        
        /* Background Pattern */
        body::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: var(--telkom-red);
            opacity: 0.03;
            border-radius: 50%;
            top: -300px;
            right: -300px;
        }
        
        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: var(--telkom-red);
            opacity: 0.03;
            border-radius: 50%;
            bottom: -200px;
            left: -200px;
        }
        
        .login-container {
            width: 100%;
            max-width: 440px;
            padding: 20px;
            position: relative;
            z-index: 1;
        }
        
        .login-card {
            background: white;
            border-radius: 16px;
            padding: 48px 40px;
            box-shadow: 0 4px 24px rgba(227, 30, 36, 0.08);
            border: 1px solid rgba(227, 30, 36, 0.1);
            animation: fadeInUp 0.6s ease;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .logo-section {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .logo-icon {
            width: 64px;
            height: 64px;
            background: var(--telkom-red);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 32px;
            color: white;
            box-shadow: 0 4px 16px rgba(227, 30, 36, 0.2);
        }
        
        .logo-section h3 {
            font-size: 24px;
            font-weight: 700;
            color: var(--telkom-dark);
            margin-bottom: 8px;
        }
        
        .logo-section p {
            font-size: 14px;
            color: var(--telkom-gray);
            margin: 0;
        }
        
        .form-label {
            font-weight: 500;
            font-size: 14px;
            color: var(--telkom-dark);
            margin-bottom: 8px;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 12px 16px;
            border: 1.5px solid #e0e0e0;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #fafafa;
        }
        
        .form-control:focus {
            border-color: var(--telkom-red);
            box-shadow: 0 0 0 4px rgba(227, 30, 36, 0.08);
            background: white;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-group-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--telkom-gray);
            z-index: 3;
        }
        
        .input-group .form-control {
            padding-left: 44px;
        }
        
        .btn-toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--telkom-gray);
            cursor: pointer;
            z-index: 3;
            padding: 4px 8px;
            transition: color 0.3s;
        }
        
        .btn-toggle-password:hover {
            color: var(--telkom-red);
        }
        
        .btn-login {
            background: var(--telkom-red);
            border: none;
            border-radius: 8px;
            padding: 14px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(227, 30, 36, 0.2);
        }
        
        .btn-login:hover {
            background: #c91a1f;
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(227, 30, 36, 0.3);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .security-badge {
            text-align: center;
            margin-top: 24px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        
        .security-badge small {
            color: var(--telkom-gray);
            font-size: 13px;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
            font-size: 14px;
            padding: 12px 16px;
        }
        
        .alert-danger {
            background: #fff5f5;
            color: #c81e1e;
            border-left: 3px solid var(--telkom-red);
        }
        
        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border-left: 3px solid #22c55e;
        }
        
        .alert-info {
            background: #f0f9ff;
            color: #075985;
            border-left: 3px solid #0284c7;
        }
        
        .footer-text {
            text-align: center;
            margin-top: 32px;
            color: var(--telkom-gray);
            font-size: 13px;
        }
        
        .demo-info {
            margin-top: 24px;
            padding: 16px;
            background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
            border-radius: 8px;
            border: 1px dashed rgba(227, 30, 36, 0.3);
        }
        
        .demo-info strong {
            color: var(--telkom-red);
        }
        
        .demo-info code {
            background: white;
            padding: 2px 8px;
            border-radius: 4px;
            color: var(--telkom-red);
            font-weight: 600;
            border: 1px solid rgba(227, 30, 36, 0.1);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="bi bi-p-square-fill"></i>
                </div>
                <h3>Sistem Parkir TUJ</h3>
                <p>Telkom University Jakarta</p>
            </div>
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                
                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <i class="bi bi-person input-group-icon"></i>
                        <input 
                            type="text" 
                            class="form-control @error('username') is-invalid @enderror" 
                            id="username" 
                            name="username" 
                            placeholder="Masukkan username"
                            value="{{ old('username') }}"
                            required
                            autofocus
                        >
                    </div>
                    @error('username')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <i class="bi bi-lock input-group-icon"></i>
                        <input 
                            type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            id="password" 
                            name="password" 
                            placeholder="Masukkan password"
                            required
                        >
                        <button class="btn-toggle-password" type="button" id="togglePassword">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-login w-100 text-white">
                    <i class="bi bi-box-arrow-in-right"></i> Login Admin
                </button>
            </form>
            
            <div class="security-badge">
                <small>
                    <i class="bi bi-shield-check"></i> Hanya untuk Administrator Sistem
                </small>
            </div>
            
            <!-- Demo Info -->
            <div class="demo-info">
                <small>
                    <strong>Demo Login:</strong><br>
                    Username: <code>admin_tu</code><br>
                    Password: <code>admin123</code>
                </small>
            </div>
        </div>
        
        <div class="footer-text">
            © 2025 Telkom University Jakarta
            <br>
            <small>Sistem Informasi Manajemen Parkir</small>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle show/hide password
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        });
        
        // Auto focus
        window.addEventListener('load', function() {
            document.getElementById('username').focus();
        });
    </script>
</body>
</html>