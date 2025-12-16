<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Informasi Pengguna - Sistem Parkir TUJ</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --telkom-red: #E31E24;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ffffff 0%, #f5f5f5 100%);
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: var(--telkom-red);
            opacity: 0.03;
            border-radius: 50%;
            top: -200px;
            right: -200px;
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
            padding: 40px;
            box-shadow: 0 4px 24px rgba(227, 30, 36, 0.08);
            border: 1px solid rgba(227, 30, 36, 0.1);
        }
        
        .logo-section {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .logo-icon {
            width: 64px;
            height: 64px;
            background: var(--telkom-red);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 32px;
            color: white;
        }
        
        .logo-section h3 {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 6px;
        }
        
        .logo-section p {
            font-size: 14px;
            color: #6c757d;
        }
        
        .form-label {
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-control {
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--telkom-red);
            box-shadow: 0 0 0 4px rgba(227, 30, 36, 0.08);
        }
        
        .input-group-custom {
            position: relative;
            margin-bottom: 16px;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(30%);
            color: #9ca3af;
            font-size: 18px; /* bisa disesuaikan sedikit */
            pointer-events: none;
            line-height: 1;
        }

        .input-group-custom .form-control {
            height: 48px;
            padding-left: 46px;
            padding-top: 0;
            padding-bottom: 0;
            display: flex;
            align-items: center;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: var(--telkom-red);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s;
            margin-top: 8px;
        }
        
        .btn-login:hover {
            background: #b71c21;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(227, 30, 36, 0.3);
        }
        
        .divider {
            text-align: center;
            position: relative;
            margin: 24px 0;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e5e7eb;
        }
        
        .divider span {
            position: relative;
            background: white;
            padding: 0 12px;
            color: #9ca3af;
            font-size: 13px;
        }
        
        .link-section {
            text-align: center;
        }
        
        .link-section a {
            color: var(--telkom-red);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }
        
        .link-section a:hover {
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
            font-size: 14px;
            margin-bottom: 20px;
        }
        
        .alert-danger {
            background: #fff5f5;
            color: #c81e1e;
            border-left: 3px solid var(--telkom-red);
        }
        
        .footer-text {
            text-align: center;
            margin-top: 24px;
            color: #9ca3af;
            font-size: 13px;
        }
    </style>
</head>
<body>
    
    <div class="login-container">
        <div class="login-card">
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="bi bi-person-circle"></i>
                </div>
                <h3>Portal Informasi Pengguna</h3>
                <p>Cek riwayat parkir Anda</p>
            </div>
            
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif
            
            <form action="{{ route('portal.login.post') }}" method="POST">
                @csrf
                
                <div class="input-group-custom">
                    <label for="kartu_id" class="form-label">Kartu ID / NIM</label>
                    <i class="bi bi-card-text input-icon"></i>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="kartu_id" 
                        name="kartu_id" 
                        placeholder="Masukkan Kartu ID atau NIM"
                        value="{{ old('kartu_id') }}"
                        required
                        autofocus
                    >
                </div>
                
                <button type="submit" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk Portal
                </button>
            </form>
            
            <div class="divider">
                <span>ATAU</span>
            </div>
            
            <div class="link-section">
                <a href="{{ route('welcome') }}">
                    <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
        
        <div class="footer-text">
            © 2025 Telkom University Jakarta
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>