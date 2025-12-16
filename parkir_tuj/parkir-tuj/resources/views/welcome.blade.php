<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistem Parkir - Telkom University Jakarta</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    
    <style>
        :root {
            --telkom-red: #E31E24;
            --telkom-dark: #1a1a1a;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            background: #ffffff;
        }
        
        /* Navbar */
        .navbar-custom {
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            padding: 16px 0;
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            color: var(--telkom-dark);
            text-decoration: none;
        }
        
        .navbar-logo {
            width: 40px;
            height: 40px;
            background: var(--telkom-red);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }
        
        .btn-login {
            padding: 10px 24px;
            background: var(--telkom-red);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            background: #b71c21;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(227, 30, 36, 0.3);
            color: white;
        }
        
        /* Hero Section */
        .hero-section {
            min-height: 90vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;

            background-image:
                linear-gradient(
                    rgba(255, 255, 255, 0.82),
                    rgba(255, 255, 255, 0.55)
                ),
                url('/tekstur.jpg');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }       

        
        .hero-section::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: var(--telkom-red);
            opacity: 0.03;
            border-radius: 50%;
            top: -300px;
            right: -200px;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #fff5f5;
            border: 1px solid rgba(227, 30, 36, 0.2);
            border-radius: 24px;
            color: var(--telkom-red);
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 24px;
        }
        
        .hero-title {
            font-size: 64px;
            font-weight: 800;
            color: var(--telkom-dark);
            line-height: 1.1;
            margin-bottom: 24px;
        }
        
        .hero-title .highlight {
            color: var(--telkom-red);
        }
        
        .hero-description {
            font-size: 20px;
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 40px;
            max-width: 600px;
        }
        
        .hero-buttons {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }
        
        .btn-primary-custom:hover {
            background: #b71c21;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(227, 30, 36, 0.3);
            color: white;
        }
        
        .btn-secondary-custom {
            padding: 16px 32px;
            background: white;
            color: var(--telkom-dark);
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }
        
        .btn-secondary-custom:hover {
            border-color: var(--telkom-red);
            color: var(--telkom-red);
        }
        
        .hero-image {
            position: relative;
            z-index: 1;
        }
        
        .hero-card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            border: 1px solid #e5e7eb;
        }
        
        .hero-card-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--telkom-red) 0%, #b71c21 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 40px;
            margin-bottom: 24px;
        }
        
        /* Stats Section */
        .stats-section {
            padding: 80px 0;
            background: white;
        }
        
        .stat-card {
            text-align: center;
            padding: 32px;
            background: #f9fafb;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            transition: all 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.08);
        }
        
        .stat-number {
            font-size: 48px;
            font-weight: 800;
            color: var(--telkom-red);
            margin-bottom: 8px;
        }
        
        .stat-label {
            font-size: 16px;
            color: #6c757d;
            font-weight: 600;
        }
        
        /* Features Section */
        .features-section {
            padding: 80px 0;
            background: #f9fafb;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 64px;
        }
        
        .section-badge {
            display: inline-block;
            padding: 8px 16px;
            background: #fff5f5;
            color: var(--telkom-red);
            border-radius: 24px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 16px;
        }
        
        .section-title {
            font-size: 42px;
            font-weight: 800;
            color: var(--telkom-dark);
            margin-bottom: 16px;
        }
        
        .section-description {
            font-size: 18px;
            color: #6c757d;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .feature-card {
            background: white;
            border-radius: 16px;
            padding: 40px 32px;
            border: 1px solid #e5e7eb;
            height: 100%;
            transition: all 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.08);
            border-color: var(--telkom-red);
        }
        
        .feature-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--telkom-red) 0%, #b71c21 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
            margin-bottom: 24px;
        }
        
        .feature-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--telkom-dark);
            margin-bottom: 12px;
        }
        
        .feature-description {
            font-size: 15px;
            color: #6c757d;
            line-height: 1.6;
        }
        
        /* CTA Section */
        .cta-section {
            padding: 100px 0;
            background: linear-gradient(135deg, var(--telkom-red) 0%, #b71c21 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            top: -200px;
            left: -100px;
        }
        
        .cta-content {
            text-align: center;
            position: relative;
            z-index: 1;
        }
        
        .cta-title {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 16px;
        }
        
        .cta-description {
            font-size: 18px;
            opacity: 0.9;
            margin-bottom: 40px;
        }
        
        .btn-cta {
            padding: 16px 40px;
            background: white;
            color: var(--telkom-red);
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }
        
        .btn-cta:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.2);
            color: var(--telkom-red);
        }
        
        /* Footer */
        .footer {
            padding: 40px 0;
            background: #1a1a1a;
            color: white;
            text-align: center;
        }
        
        .footer-logo {
            margin-bottom: 16px;
        }
        
        .footer-text {
            color: #9ca3af;
            font-size: 14px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 42px;
            }
            
            .hero-description {
                font-size: 16px;
            }
            
            .section-title {
                font-size: 32px;
            }
            
            .cta-title {
                font-size: 32px;
            }
        }
    </style>
</head>
<body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <div class="navbar-logo">
                    <i class="bi bi-p-square-fill"></i>
                </div>
                <span>Sistem Parkir TUJ</span>
            </a>
            <a href="{{ route('login') }}" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i> Login Admin
            </a>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <div class="hero-badge">
                        <i class="bi bi-stars"></i>
                        Sistem Parkir Modern
                    </div>
                    <h1 class="hero-title">
                        Parkir <span class="highlight">Kampus</span><br>
                        Jadi Lebih Mudah
                    </h1>
                    <p class="hero-description">
                        Sistem parkir otomatis berbasis scan kartu KTM/Karyawan untuk Telkom University Jakarta. 
                        Cepat, aman, dan terintegrasi.
                    </p>
                    <div class="hero-buttons">
                        <a href="#features" class="btn-secondary-custom">
                            <i class="bi bi-info-circle"></i>
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 hero-image mt-5 mt-lg-0">
                    <div class="hero-card">
                        <div class="hero-card-icon">
                            <i class="bi bi-qr-code-scan"></i>
                        </div>
                        <h4 class="mb-3">Scan & Go</h4>
                        <p class="text-muted mb-4">
                            Dekatkan kartu KTM atau Kartu Karyawan ke scanner, 
                            sistem otomatis mencatat waktu masuk dan keluar kendaraan Anda.
                        </p>
                        <div class="d-flex gap-3">
                            <div class="flex-fill text-center p-3 bg-light rounded">
                                <div class="h5 mb-1 text-danger"><i class="fa-solid fa-motorcycle"></i></div>
                                <small class="text-muted">Motor</small>
                            </div>
                            <div class="flex-fill text-center p-3 bg-light rounded">
                                <div class="h5 mb-1 text-primary"><i class="bi bi-car-front"></i></div>
                                <small class="text-muted">Mobil</small>
                            </div>
                        </div>
                        <div class="hero-buttons">
                            <a href="{{ route('portal.login') }}" class="btn-secondary-custom" style="margin-top: 12px;">
                                <i class="bi bi-person-circle"></i>
                                Portal Informasi Pengguna
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-number">100+</div>
                        <div class="stat-label">Slot Parkir</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Pengguna Aktif</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Akses Sistem</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Gratis</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <div class="section-header">
                <div class="section-badge">Fitur Unggulan</div>
                <h2 class="section-title">Kenapa Pilih Sistem Kami?</h2>
                <p class="section-description">
                    Sistem parkir modern yang dirancang khusus untuk kemudahan civitas akademika Telkom University Jakarta
                </p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-qr-code-scan"></i>
                        </div>
                        <h3 class="feature-title">Scan Otomatis</h3>
                        <p class="feature-description">
                            Cukup scan kartu KTM/Karyawan, sistem otomatis mencatat masuk dan keluar kendaraan Anda tanpa ribet.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <h3 class="feature-title">Real-time Monitoring</h3>
                        <p class="feature-description">
                            Pantau ketersediaan slot parkir secara real-time melalui dashboard yang mudah diakses.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h3 class="feature-title">Aman & Terpercaya</h3>
                        <p class="feature-description">
                            Data terenkripsi dengan sistem keamanan tingkat tinggi untuk melindungi privasi pengguna.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <h3 class="feature-title">Gratis 100%</h3>
                        <p class="feature-description">
                            Tidak ada biaya parkir. Sistem ini disediakan gratis untuk semua civitas akademika.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <h3 class="feature-title">Laporan Lengkap</h3>
                        <p class="feature-description">
                            Admin dapat mengakses laporan dan analisis data parkir untuk pengambilan keputusan.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-phone"></i>
                        </div>
                        <h3 class="feature-title">Responsive Design</h3>
                        <p class="feature-description">
                            Dapat diakses dari berbagai perangkat: desktop, tablet, maupun smartphone.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Siap Mulai Menggunakan?</h2>
                <p class="cta-description">
                    Login sebagai admin untuk mengelola sistem parkir kampus
                </p>
                <a href="{{ route('login') }}" class="btn-cta">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Login Sekarang
                </a>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-logo mb-3">
                <div class="navbar-brand d-inline-flex">
                    <div class="navbar-logo">
                        <i class="bi bi-p-square-fill"></i>
                    </div>
                    <span class="text-white ms-2">Parkir TU Jakarta</span>
                </div>
            </div>
            <p class="footer-text mb-2">
                Sistem Informasi Manajemen Parkir
            </p>
            <p class="footer-text">
                © 2025 Telkom University Jakarta. All rights reserved.
            </p>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Smooth Scroll -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>