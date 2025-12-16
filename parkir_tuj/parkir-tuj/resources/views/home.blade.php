@extends('layouts.app')

@section('title', 'Home')
@section('page-title', 'Beranda')

@section('content')

<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-content">
        <div class="hero-icon">
            <i class="bi bi-p-square-fill"></i>
        </div>
        <h1 class="hero-title">Sistem Parkir Otomatis</h1>
        <h2 class="hero-subtitle">Telkom University Jakarta</h2>
        <p class="hero-description">
            Aplikasi ini memudahkan mahasiswa dan staf untuk mengelola parkir secara digital 
            menggunakan scan KTM. Sistem terintegrasi, aman, dan efisien untuk mengelola 
            area parkir kampus dengan lebih baik.
        </p>
    </div>
</div>

<!-- Alert Selamat Datang (jika ada scan) -->
@if(session('scan_success') && session('nama_pengguna'))
<div class="alert-welcome" id="alertWelcome">
    <div class="alert-content">
        <div class="alert-icon">
            <i class="bi bi-check-circle"></i>
        </div>
        <div class="alert-text">
            <h5>Selamat Datang!</h5>
            <p>Halo, <strong>{{ session('nama_pengguna') }}</strong>! Kendaraan Anda berhasil tercatat.</p>
        </div>
        <button type="button" class="btn-close-alert" onclick="closeAlert()">
            <i class="bi bi-x"></i>
        </button>
    </div>
</div>
@endif

<!-- Info Slot Parkir -->
<div class="row g-3 mb-4">
    <!-- Total Slot -->
    <div class="col-md-4">
        <div class="slot-card total">
            <div class="slot-icon">
                <i class="bi bi-grid-3x3-gap"></i>
            </div>
            <div class="slot-info">
                <h3>{{ $totalSlot ?? 100 }}</h3>
                <p>Total Slot Parkir</p>
            </div>
        </div>
    </div>
    
    <!-- Slot Kosong -->
    <div class="col-md-4">
        <div class="slot-card available">
            <div class="slot-icon">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="slot-info">
                <h3>{{ $slotKosong ?? 75 }}</h3>
                <p>Slot Tersedia</p>
            </div>
            <div class="slot-badge available">
                <span class="pulse-dot"></span> Tersedia
            </div>
        </div>
    </div>
    
    <!-- Slot Terisi -->
    <div class="col-md-4">
        <div class="slot-card occupied">
            <div class="slot-icon">
                <i class="bi bi-car-front-fill"></i>
            </div>
            <div class="slot-info">
                <h3>{{ $slotTerisi ?? 25 }}</h3>
                <p>Slot Terpakai</p>
            </div>
            <div class="slot-progress">
                <div class="slot-progress-bar" style="width: {{ $totalSlot > 0 ? ($slotTerisi / $totalSlot * 100) : 0 }}%"></div>
            </div>
        </div>
    </div>
</div>

<!-- Fitur Utama -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="feature-card">
            <div class="feature-icon red">
                <i class="bi bi-qr-code-scan"></i>
            </div>
            <h5>Scan KTM</h5>
            <p>Scan kartu mahasiswa/karyawan untuk masuk area parkir</p>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="feature-card">
            <div class="feature-icon blue">
                <i class="bi bi-clock-history"></i>
            </div>
            <h5>Real-time</h5>
            <p>Pantau status parkir secara langsung dan akurat</p>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="feature-card">
            <div class="feature-icon green">
                <i class="bi bi-shield-check"></i>
            </div>
            <h5>Aman</h5>
            <p>Data terenkripsi dan tersimpan dengan sistem keamanan tinggi</p>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="feature-card">
            <div class="feature-icon orange">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
            <h5>Laporan</h5>
            <p>Analisis data parkir untuk pengambilan keputusan</p>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="action-section">
    <h4 class="mb-3">Aksi Cepat</h4>
    <div class="row g-3">
        <div class="col-md-6">
            <a href="{{ route('scan.index') }}" class="action-button primary">
                <div class="action-icon">
                    <i class="bi bi-qr-code-scan"></i>
                </div>
                <div class="action-text">
                    <h5>Scan Barcode KTM</h5>
                    <p>Mulai scan kartu untuk masuk parkir</p>
                </div>
                <i class="bi bi-arrow-right action-arrow"></i>
            </a>
        </div>
        
        <div class="col-md-6">
            <a href="{{ route('dashboard') }}" class="action-button secondary">
                <div class="action-icon">
                    <i class="bi bi-speedometer2"></i>
                </div>
                <div class="action-text">
                    <h5>Lihat Dashboard</h5>
                    <p>Pantau statistik dan aktivitas parkir</p>
                </div>
                <i class="bi bi-arrow-right action-arrow"></i>
            </a>
        </div>
    </div>
</div>

<!-- Info Tambahan -->
<div class="info-section">
    <div class="info-card">
        <i class="bi bi-info-circle"></i>
        <div>
            <strong>Cara Menggunakan:</strong>
            <ol class="mb-0 mt-2">
                <li>Dekatkan kartu KTM/Karyawan ke scanner</li>
                <li>Tunggu notifikasi berhasil</li>
                <li>Masuk ke area parkir yang tersedia</li>
                <li>Saat keluar, scan kembali kartu Anda</li>
            </ol>
        </div>
    </div>
</div>

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, #E31E24 0%, #b71c21 100%);
        border-radius: 16px;
        padding: 64px 32px;
        text-align: center;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
        top: -150px;
        right: -150px;
    }
    
    .hero-content {
        position: relative;
        z-index: 1;
    }
    
    .hero-icon {
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        font-size: 40px;
        color: white;
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    .hero-title {
        font-size: 42px;
        font-weight: 700;
        color: white;
        margin-bottom: 8px;
    }
    
    .hero-subtitle {
        font-size: 24px;
        font-weight: 600;
        color: rgba(255,255,255,0.9);
        margin-bottom: 20px;
    }
    
    .hero-description {
        font-size: 16px;
        color: rgba(255,255,255,0.85);
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }
    
    /* Alert Welcome */
    .alert-welcome {
        position: fixed;
        top: 100px;
        right: 32px;
        z-index: 9999;
        animation: slideInRight 0.5s ease;
    }
    
    @keyframes slideInRight {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    .alert-content {
        background: white;
        padding: 20px 24px;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(227, 30, 36, 0.2);
        border-left: 4px solid #22c55e;
        display: flex;
        align-items: center;
        gap: 16px;
        min-width: 350px;
    }
    
    .alert-icon {
        width: 48px;
        height: 48px;
        background: #f0fdf4;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #22c55e;
        font-size: 24px;
    }
    
    .alert-text h5 {
        font-size: 16px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 4px;
    }
    
    .alert-text p {
        font-size: 14px;
        color: #6c757d;
        margin: 0;
    }
    
    .btn-close-alert {
        background: none;
        border: none;
        color: #9ca3af;
        font-size: 20px;
        cursor: pointer;
        transition: color 0.2s;
    }
    
    .btn-close-alert:hover {
        color: #1a1a1a;
    }
    
/* Biar semua slot-card seragam */
    .slot-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #e5e7eb;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s;
        min-height: 200px; /* tinggi seragam */
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* biar konten dalamnya rapi */
    }

    
    .slot-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    }
    
    .slot-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 48px;
        opacity: 0.1;
    }
    
    .slot-card.total .slot-icon { color: #E31E24; }
    .slot-card.available .slot-icon { color: #22c55e; }
    .slot-card.occupied .slot-icon { color: #6366f1; }
    
    .slot-info h3 {
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    
    .slot-card.total .slot-info h3 { color: #E31E24; }
    .slot-card.available .slot-info h3 { color: #22c55e; }
    .slot-card.occupied .slot-info h3 { color: #6366f1; }
    
    .slot-info p {
        font-size: 14px;
        color: #6c757d;
        margin: 0;
    }
    
    .slot-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-top: 12px;
    }
    
    .slot-badge.available {
        background: #f0fdf4;
        color: #166534;
    }
    
    .pulse-dot {
        width: 6px;
        height: 6px;
        background: #22c55e;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.2); }
    }
    
    .slot-progress {
        height: 6px;
        background: #f3f4f6;
        border-radius: 3px;
        margin-top: 12px;
        overflow: hidden;
    }
    
    .slot-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #6366f1 0%, #818cf8 100%);
        border-radius: 3px;
        transition: width 1s ease;
    }
    
    /* Feature Cards */
    .feature-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #e5e7eb;
        text-align: center;
        transition: all 0.3s;
    }
    
    .feature-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    }
    
    .feature-icon {
        width: 64px;
        height: 64px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 28px;
        color: white;
    }
    
    .feature-icon.red { background: linear-gradient(135deg, #E31E24 0%, #b71c21 100%); }
    .feature-icon.blue { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); }
    .feature-icon.green { background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); }
    .feature-icon.orange { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
    
    .feature-card h5 {
        font-size: 16px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }
    
    .feature-card p {
        font-size: 13px;
        color: #6c757d;
        margin: 0;
    }
    
    /* Action Section */
    .action-section {
        margin-bottom: 32px;
    }
    
    .action-section h4 {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a1a;
    }
    
    .action-button {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 24px;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .action-button:hover {
        transform: translateX(8px);
        border-color: #E31E24;
        box-shadow: 0 4px 16px rgba(227, 30, 36, 0.1);
    }
    
    .action-button.primary:hover {
        background: linear-gradient(135deg, rgba(227, 30, 36, 0.05) 0%, rgba(227, 30, 36, 0.02) 100%);
    }
    
    .action-icon {
        width: 56px;
        height: 56px;
        background: #f8f9fa;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: #E31E24;
    }
    
    .action-text {
        flex: 1;
    }
    
    .action-text h5 {
        font-size: 16px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 4px;
    }
    
    .action-text p {
        font-size: 13px;
        color: #6c757d;
        margin: 0;
    }
    
    .action-arrow {
        font-size: 24px;
        color: #E31E24;
        transition: transform 0.3s;
    }
    
    .action-button:hover .action-arrow {
        transform: translateX(4px);
    }
    
    /* Info Section */
    .info-section {
        margin-top: 32px;
    }
    
    .info-card {
        background: #f0f9ff;
        border-left: 4px solid #0284c7;
        padding: 20px 24px;
        border-radius: 8px;
        display: flex;
        gap: 16px;
    }
    
    .info-card > i {
        font-size: 24px;
        color: #0284c7;
    }
    
    .info-card strong {
        color: #1a1a1a;
    }
    
    .info-card ol {
        padding-left: 20px;
    }
    
    .info-card li {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 8px;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto close alert after 5 seconds
    setTimeout(function() {
        const alert = document.getElementById('alertWelcome');
        if (alert) {
            alert.style.animation = 'slideOutRight 0.5s ease';
            setTimeout(() => alert.remove(), 500);
        }
    }, 5000);
    
    function closeAlert() {
        const alert = document.getElementById('alertWelcome');
        alert.style.animation = 'slideOutRight 0.5s ease';
        setTimeout(() => alert.remove(), 500);
    }
    
    // Animation for slide out
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endpush

@endsection