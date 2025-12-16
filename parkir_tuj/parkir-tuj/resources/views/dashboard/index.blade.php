    @extends('layouts.app')

    @section('title', 'Dashboard')
    @section('page-title', 'Dashboard')

    @section('content')

    <!-- Welcome Banner -->
    <div class="welcome-banner mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">Selamat Datang, {{ session('admin_nama') }}! 👋</h4>
                <p class="text-muted mb-0">Berikut adalah ringkasan sistem parkir hari ini</p>
            </div>
            <div class="welcome-time">
                {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
            </div>
        </div>
    </div>

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

    <!-- Statistik Cards -->
    <div class="row g-3 mb-4">
        <!-- Total Pengguna -->
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #E31E24 0%, #b71c21 100%);">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-content">
                    <p class="stat-label">Total Pengguna</p>
                    <h3 class="stat-value">{{ $totalPengguna ?? 0 }}</h3>
                    <small class="stat-desc">Mahasiswa & Dosen</small>
                </div>
                <a href="{{ route('pengguna.index') }}" class="stat-link">
                    Lihat detail <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <!-- Total Kendaraan -->
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                    <i class="bi bi-car-front"></i>
                </div>
                <div class="stat-content">
                    <p class="stat-label">Total Kendaraan</p>
                    <h3 class="stat-value">{{ $totalKendaraan ?? 0 }}</h3>
                    <small class="stat-desc">Terdaftar</small>
                </div>
                <a href="{{ route('kendaraan.index') }}" class="stat-link">
                    Lihat detail <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <!-- Parkir Hari Ini -->
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="stat-content">
                    <p class="stat-label">Parkir Hari Ini</p>
                    <h3 class="stat-value">{{ $parkirHariIni ?? 0 }}</h3>
                    <small class="stat-desc">Kendaraan Masuk</small>
                </div>
                <a href="{{ route('akses-parkir.index') }}" class="stat-link">
                    Lihat transaksi <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <!-- Sedang Parkir -->
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <i class="bi bi-p-circle"></i>
                </div>
                <div class="stat-content">
                    <p class="stat-label">Sedang Parkir</p>
                    <h3 class="stat-value">{{ $sedangParkir ?? 0 }}</h3>
                    <small class="stat-desc">Real-time</small>
                </div>
                <div class="stat-badge">
                    <span class="badge-live"></span> Live
                </div>
            </div>
        </div>
    </div>

    <!-- Motor & Mobil Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="vehicle-card">
                <div class="vehicle-header">
                    <div class="vehicle-icon motor">
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
                        <i class="fa-solid fa-motorcycle"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Kendaraan Motor</h5>
                        <small class="text-muted">Statistik motor terdaftar</small>
                    </div>
                </div>
                <div class="vehicle-stats">
                    <div class="stat-item">
                        <div class="stat-number">{{ $totalMotor ?? 0 }}</div>
                        <div class="stat-text">Total Terdaftar</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number text-success">{{ $motorParkir ?? 0 }}</div>
                        <div class="stat-text">Sedang Parkir</div>
                    </div>
                </div>
                <div class="progress-bar-custom">
                    <div class="progress-fill motor" style="width: {{ $totalMotor > 0 ? ($motorParkir / $totalMotor * 100) : 0 }}%"></div>
                </div>
                <small class="text-muted">
                    {{ $totalMotor > 0 ? number_format(($motorParkir / $totalMotor * 100), 1) : 0 }}% Occupancy
                </small>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="vehicle-card">
                <div class="vehicle-header">
                    <div class="vehicle-icon mobil">
                        <i class="bi bi-car-front-fill"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Kendaraan Mobil</h5>
                        <small class="text-muted">Statistik mobil terdaftar</small>
                    </div>
                </div>
                <div class="vehicle-stats">
                    <div class="stat-item">
                        <div class="stat-number">{{ $totalMobil ?? 0 }}</div>
                        <div class="stat-text">Total Terdaftar</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number text-success">{{ $mobilParkir ?? 0 }}</div>
                        <div class="stat-text">Sedang Parkir</div>
                    </div>
                </div>
                <div class="progress-bar-custom">
                    <div class="progress-fill mobil" style="width: {{ $totalMobil > 0 ? ($mobilParkir / $totalMobil * 100) : 0 }}%"></div>
                </div>
                <small class="text-muted">
                    {{ $totalMobil > 0 ? number_format(($mobilParkir / $totalMobil * 100), 1) : 0 }}% Occupancy
                </small>
            </div>
        </div>
    </div>

    <!-- Kendaraan Sedang Parkir -->
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Kendaraan Sedang Parkir</h5>
                    <small class="text-muted">Daftar kendaraan yang aktif di area parkir</small>
                </div>
                <span class="badge-count">{{ $kendaraanParkir->count() ?? 0 }} Kendaraan</span>
            </div>
        </div>
        <div class="card-body p-0">
            @if(isset($kendaraanParkir) && $kendaraanParkir->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Plat Nomor</th>
                                <th>Pemilik</th>
                                <th>Jenis</th>
                                <th>Waktu Masuk</th>
                                <th>Durasi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kendaraanParkir as $index => $akses)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong class="text-danger">{{ $akses->plat_nomor }}</strong></td>
                                <td>
                                    {{ $akses->nama_pengguna }}
                                    <br>
                                    <small class="text-muted">{{ $akses->jenis_pengguna }}</small>
                                </td>
                                <td>
                                    @if($akses->jenis_kendaraan == 'Motor')
                                        <span class="badge-vehicle motor">
                                            <i class="bi bi-motorcycle"></i> Motor
                                        </span>
                                    @else
                                        <span class="badge-vehicle mobil">
                                            <i class="bi bi-car-front"></i> Mobil
                                        </span>
                                    @endif
                                </td>
                                <td><small>{{ \Carbon\Carbon::parse($akses->waktu_masuk)->format('d/m/Y H:i:s') }}<small></td>
                                            <td>
                                                @php
                                                    $masuk = \Carbon\Carbon::parse($akses->waktu_masuk);
                                                    $sekarang = \Carbon\Carbon::now();
                                                    $durasi = $masuk->diff($sekarang);
                                                    
                                                    // Format durasi yang lebih readable
                                                    $hari = $durasi->d;
                                                    $jam = $durasi->h;
                                                    $menit = $durasi->i;
                                                    
                                                    $durasiText = '';
                                                    if ($hari > 0) {
                                                        $durasiText .= $hari . 'd ';
                                                    }
                                                    if ($jam > 0 || $hari > 0) {
                                                        $durasiText .= $jam . 'j ';
                                                    }
                                                    $durasiText .= $menit . 'm';
                                                @endphp
                                    <span class="badge-duration">{{ $durasi->h }}j {{ $durasi->i }}m</span>
                                </td>
                                <td><span class="badge-status active">Parkir</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>Tidak ada kendaraan yang sedang parkir</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Log Aktivitas Terbaru -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Aktivitas Terbaru</h5>
                    <small class="text-muted">5 aktivitas terakhir dari administrator</small>
                </div>
                <a href="{{ route('log.index') }}" class="btn-link-custom">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            @if(isset($logTerbaru) && $logTerbaru->count() > 0)
                <div class="activity-list">
                    @foreach($logTerbaru as $log)
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="bi bi-circle-fill"></i>
                        </div>
                        <div class="activity-content">
                            <p class="activity-text">{{ $log->aktivitas }}</p>
                            <small class="activity-meta">
                                <i class="bi bi-person-badge"></i> {{ $log->nama_admin }} •
                                <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($log->waktu)->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-clock-history"></i>
                    <p>Belum ada aktivitas</p>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
    <style>
        .welcome-banner {
            background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
            padding: 24px;
            border-radius: 12px;
            border: 1px solid rgba(227, 30, 36, 0.1);
        }
        
        .welcome-banner h4 {
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .welcome-time {
            color: #6c757d;
            font-size: 14px;
        }

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
        
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e5e7eb;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            margin-bottom: 16px;
        }
        
        .stat-label {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 4px;
            font-weight: 500;
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 4px;
        }
        
        .stat-desc {
            font-size: 12px;
            color: #9ca3af;
        }
        
        .stat-link {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: #E31E24;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            margin-top: 12px;
            transition: gap 0.3s;
        }
        
        .stat-link:hover {
            gap: 8px;
        }
        
        .stat-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: #f0fdf4;
            border-radius: 20px;
            font-size: 12px;
            color: #166534;
            font-weight: 600;
            margin-top: 12px;
        }
        
        .badge-live {
            width: 6px;
            height: 6px;
            background: #22c55e;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .vehicle-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #e5e7eb;
            height: 100%;
        }
        
        .vehicle-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }
        
        .vehicle-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
        }
        
        .vehicle-icon.motor {
            background: linear-gradient(135deg, #E31E24 0%, #b71c21 100%);
        }
        
        .vehicle-icon.mobil {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        }
        
        .vehicle-stats {
            display: flex;
            gap: 24px;
            margin-bottom: 16px;
        }
        
        .stat-item .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .stat-item .stat-text {
            font-size: 12px;
            color: #6c757d;
        }
        
        .progress-bar-custom {
            height: 8px;
            background: #f3f4f6;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 8px;
        }
        
        .progress-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 1s ease;
        }
        
        .progress-fill.motor {
            background: linear-gradient(90deg, #E31E24 0%, #ff4d52 100%);
        }
        
        .progress-fill.mobil {
            background: linear-gradient(90deg, #6366f1 0%, #818cf8 100%);
        }
        
        .card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        
        .card-header {
            padding: 20px 24px;
            background: white;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .card-header h5 {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .badge-count {
            padding: 6px 12px;
            background: #E31E24;
            color: white;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        
        .table thead th {
            font-size: 13px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px 24px;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .table tbody td {
            padding: 16px 24px;
            vertical-align: middle;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .badge-vehicle {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-vehicle.motor {
            background: #fff5f5;
            color: #E31E24;
        }
        
        .badge-vehicle.mobil {
            background: #eef2ff;
            color: #4f46e5;
        }
        
        .badge-duration {
            padding: 4px 8px;
            background: #f3f4f6;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
        }
        
        .badge-status.active {
            padding: 4px 10px;
            background: #f0fdf4;
            color: #166534;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: #9ca3af;
        }
        
        .empty-state i {
            font-size: 48px;
            margin-bottom: 12px;
            opacity: 0.5;
        }
        
        .activity-list {
            padding: 12px 0;
        }
        
        .activity-item {
            display: flex;
            gap: 16px;
            padding: 16px 24px;
            transition: background 0.2s;
        }
        
        .activity-item:hover {
            background: #f9fafb;
        }
        
        .activity-icon {
            color: #E31E24;
            font-size: 8px;
            padding-top: 6px;
        }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-text {
            font-size: 14px;
            color: #1a1a1a;
            margin-bottom: 4px;
        }
        
        .activity-meta {
            font-size: 12px;
            color: #9ca3af;
        }
        
        .btn-link-custom {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: #E31E24;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: gap 0.3s;
        }
        
        .btn-link-custom:hover {
            gap: 8px;
        }
    </style>
    @endpush

    @endsection