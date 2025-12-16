<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Portal Informasi Pengguna</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
            background: #f5f5f5;
        }
        
        .navbar-custom {
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            padding: 16px 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .btn-logout {
            padding: 8px 20px;
            background: var(--telkom-red);
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
        }
        
        .profile-card {
            background: linear-gradient(135deg, var(--telkom-red) 0%, #b71c21 100%);
            border-radius: 16px;
            padding: 32px;
            color: white;
            margin-bottom: 24px;
        }
        
        .profile-avatar {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin-bottom: 16px;
        }
        
        .profile-name {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        
        .profile-info {
            display: flex;
            gap: 24px;
            margin-top: 16px;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #e5e7eb;
            margin-bottom: 16px;
        }
        
        .stat-number {
            font-size: 36px;
            font-weight: 700;
            color: var(--telkom-red);
            margin-bottom: 8px;
        }
        
        .stat-label {
            font-size: 14px;
            color: #6c757d;
        }
        
        .history-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        
        .history-header {
            padding: 20px 24px;
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
        }
        
        .history-header h5 {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0;
        }
        
        .history-item {
            padding: 20px 24px;
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.2s;
        }
        
        .history-item:hover {
            background: #f9fafb;
        }
        
        .history-item:last-child {
            border-bottom: none;
        }
        
        .history-date {
            font-size: 13px;
            color: #9ca3af;
            margin-bottom: 8px;
        }
        
        .history-plate {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .history-times {
            display: flex;
            gap: 24px;
            font-size: 14px;
            color: #6c757d;
        }
        
        .badge-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-keluar {
            background: #f3f4f6;
            color: #4b5563;
        }
        
        .badge-parkir {
            background: #f0fdf4;
            color: #166534;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #9ca3af;
        }
        
        .empty-state i {
            font-size: 64px;
            margin-bottom: 16px;
            opacity: 0.3;
        }
    </style>
</head>
<body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-custom">
        <div class="container">
            <span class="navbar-brand">
                <i class="bi bi-p-square-fill text-danger"></i> Portal Informasi Pengguna
            </span>
            <form action="{{ route('portal.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-logout">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </nav>
    
    <!-- Content -->
    <div class="container py-4">
        
        <!-- Profile Card -->
        <div class="profile-card">
            <div class="profile-avatar">
                <i class="bi bi-person"></i>
            </div>
            <div class="profile-name">{{ $pengguna->nama_pengguna }}</div>
            <div class="profile-info">
                <div class="info-item">
                    <i class="bi bi-mortarboard"></i>
                    <span>{{ $pengguna->jenis_pengguna }}</span>
                </div>
                <div class="info-item">
                    <i class="bi bi-card-text"></i>
                    <span>{{ $pengguna->nomor_identitas }}</span>
                </div>
            </div>
        </div>
        
        <!-- Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-number">{{ $totalParkir }}</div>
                    <div class="stat-label">Total Parkir</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-number">{{ $sedangParkir }}</div>
                    <div class="stat-label">Sedang Parkir</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-number">{{ $bulanIni }}</div>
                    <div class="stat-label">Bulan Ini</div>
                </div>
            </div>
        </div>
        
        <!-- History -->
        <div class="history-card">
            <div class="history-header">
                <h5><i class="bi bi-clock-history"></i> Riwayat Parkir</h5>
            </div>
            
            @if($riwayat->count() > 0)
                @foreach($riwayat as $item)
                <div class="history-item">
                    <div class="history-date">
                        {{ \Carbon\Carbon::parse($item->waktu_masuk)->format('l, d F Y') }}
                    </div>
                    <div class="history-plate">
                        <i class="bi bi-car-front text-danger"></i> {{ $item->plat_nomor }}
                    </div>
                    <div class="history-times">
                        <div>
                            <i class="bi bi-box-arrow-in-right text-success"></i>
                            Masuk: {{ \Carbon\Carbon::parse($item->waktu_masuk)->format('H:i') }}
                        </div>
                        @if($item->waktu_keluar)
                        <div>
                            <i class="bi bi-box-arrow-right text-danger"></i>
                            Keluar: {{ \Carbon\Carbon::parse($item->waktu_keluar)->format('H:i') }}
                        </div>
                        <div>
                            <i class="bi bi-hourglass-split"></i>
                            Durasi: {{ $item->durasi }}
                        </div>
                        @else
                        <span class="badge-status badge-parkir">
                            <i class="bi bi-check-circle"></i> Sedang Parkir
                        </span>
                        @endif
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h5>Belum ada riwayat parkir</h5>
                    <p>Riwayat parkir Anda akan muncul di sini</p>
                </div>
            @endif
        </div>
        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>