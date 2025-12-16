@extends('layouts.app')

@section('title', 'Akses Parkir')
@section('page-title', 'Manajemen Akses Parkir')

@push('styles')
<style>
    /* FORCE HIDE ALL LARGE ARROWS AND ICONS */
    .pagination svg,
    .pagination img,
    .pagination .page-link svg,
    .pagination .page-link img {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
        visibility: hidden !important;
    }
    
    /* Remove any large icon elements */
    .pagination .page-link > * {
        font-size: 13px !important;
    }
    
    /* Custom Pagination Styling - COMPLETE OVERRIDE */
    .pagination {
        margin: 0 !important;
        display: flex !important;
        gap: 8px !important;
        list-style: none !important;
        padding: 0 !important;
        flex-wrap: wrap !important;
    }
    
    .pagination .page-item {
        margin: 0 !important;
        display: inline-block !important;
    }
    
    .pagination .page-link {
        padding: 8px 14px !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 6px !important;
        background: white !important;
        color: #6c757d !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        transition: all 0.2s !important;
        min-width: 40px !important;
        height: 38px !important;
        text-align: center !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-decoration: none !important;
        line-height: 1 !important;
        vertical-align: middle !important;
    }
    
    /* Force remove content and add text labels */
    .pagination .page-item:first-child .page-link {
        font-size: 0 !important;
    }
    
    .pagination .page-item:first-child .page-link::after {
        content: "‹ Prev" !important;
        font-size: 14px !important;
        display: inline-block !important;
    }
    
    .pagination .page-item:last-child .page-link {
        font-size: 0 !important;
    }
    
    .pagination .page-item:last-child .page-link::after {
        content: "Next ›" !important;
        font-size: 14px !important;
        display: inline-block !important;
    }
    
    /* Hover states */
    .pagination .page-link:hover {
        background: #fff5f5 !important;
        border-color: #E31E24 !important;
        color: #E31E24 !important;
        transform: translateY(-1px) !important;
    }
    
    .pagination .page-item.active .page-link {
        background: #E31E24 !important;
        border-color: #E31E24 !important;
        color: white !important;
    }
    
    .pagination .page-item.disabled .page-link {
        background: #f8f9fa !important;
        border-color: #e5e7eb !important;
        color: #d1d5db !important;
        cursor: not-allowed !important;
        opacity: 0.6 !important;
    }
    
    .pagination .page-item.disabled .page-link:hover {
        background: #f8f9fa !important;
        border-color: #e5e7eb !important;
        color: #d1d5db !important;
        transform: none !important;
    }
    
    /* Dark Mode Pagination */
    body.dark-mode .pagination .page-link {
        background: #353535 !important;
        border-color: #404040 !important;
        color: #d1d5db !important;
    }
    
    body.dark-mode .pagination .page-link:hover {
        background: #4a1a1c !important;
        border-color: #E31E24 !important;
        color: #ff6b6f !important;
    }
    
    body.dark-mode .pagination .page-item.active .page-link {
        background: #E31E24 !important;
        border-color: #E31E24 !important;
        color: white !important;
    }
    
    body.dark-mode .pagination .page-item.disabled .page-link {
        background: #2d2d2d !important;
        border-color: #404040 !important;
        color: #6c757d !important;
    }
    
    /* Extra safety: hide any spans or divs inside page-link */
    .pagination .page-link span,
    .pagination .page-link div {
        display: none !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Transaksi Akses Parkir</h4>
            <p class="text-muted mb-0">Kelola kendaraan masuk dan keluar area parkir</p>
        </div>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalMasuk">
            <i class="bi bi-plus-circle"></i> Kendaraan Masuk
        </button>
    </div>
    
    <!-- Statistik Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Sedang Parkir</h6>
                            <h2 class="mb-0 fw-bold">{{ $sedangParkir }}</h2>
                        </div>
                        <i class="bi bi-p-circle fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Masuk Hari Ini</h6>
                            <h2 class="mb-0 fw-bold">{{ $masukHariIni }}</h2>
                        </div>
                        <i class="bi bi-box-arrow-in-right fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Keluar Hari Ini</h6>
                            <h2 class="mb-0 fw-bold">{{ $keluarHariIni }}</h2>
                        </div>
                        <i class="bi bi-box-arrow-right fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Total Riwayat Parkir</h6>
                            <h2 class="mb-0 fw-bold">{{ $totalTransaksi }}</h2>
                        </div>
                        <i class="bi bi-list-check fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="sedang-parkir-tab" data-bs-toggle="tab" data-bs-target="#sedang-parkir" type="button">
                <i class="bi bi-p-circle"></i> Sedang Parkir ({{ $sedangParkir }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button">
                <i class="bi bi-clock-history"></i> Riwayat Parkir
            </button>
        </li>
    </ul>
    
    <!-- Tab Content -->
    <div class="tab-content">
        
        <!-- Tab: Sedang Parkir -->
        <div class="tab-pane fade show active" id="sedang-parkir">
            <div class="card">
                <div class="card-body">
                    @if($kendaraanParkir->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Plat Nomor</th>
                                        <th>Pemilik</th>
                                        <th>Jenis</th>
                                        <th>Waktu Masuk</th>
                                        <th>Durasi</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kendaraanParkir as $index => $akses)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong class="text-primary">{{ $akses->kendaraan->plat_nomor }}</strong>
                                        </td>
                                        <td>
                                            <div>
                                                {{ $akses->kendaraan->pengguna->nama_pengguna }}
                                                <br>
                                                <small class="text-muted">{{ $akses->kendaraan->pengguna->jenis_pengguna }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if($akses->kendaraan->jenis_kendaraan == 'Motor')
                                                <span class="badge bg-danger">
                                                    <i class="bi bi-bicycle"></i> Motor
                                                </span>
                                            @else
                                                <span class="badge bg-info">
                                                    <i class="bi bi-car-front"></i> Mobil
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($akses->waktu_masuk)->format('d/m/Y H:i:s') }}</td>
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
                                            <span class="badge bg-secondary">
                                                {{ trim($durasiText) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('akses-parkir.keluar', $akses->id_akses) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning" 
                                                        onclick="return confirm('Konfirmasi kendaraan {{ $akses->kendaraan->plat_nomor }} keluar?')">
                                                    <i class="bi bi-box-arrow-right"></i> Keluar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                            <h5>Tidak ada kendaraan yang sedang parkir</h5>
                            <p>Klik tombol "Kendaraan Masuk" untuk mencatat kendaraan masuk</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Tab: Riwayat -->
        <div class="tab-pane fade" id="history">
            <div class="card">
                <div class="card-body">
                    @if($riwayat->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Plat Nomor</th>
                                        <th>Pemilik</th>
                                        <th>Jenis</th>
                                        <th>Waktu Masuk</th>
                                        <th>Waktu Keluar</th>
                                        <th>Durasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayat as $index => $akses)
                                    <tr>
                                        <td>{{ $riwayat->firstItem() + $index }}</td>
                                        <td>
                                            <strong>{{ $akses->kendaraan->plat_nomor }}</strong>
                                        </td>
                                        <td>
                                            <div>
                                                {{ $akses->kendaraan->pengguna->nama_pengguna }}
                                                <br>
                                                <small class="text-muted">{{ $akses->kendaraan->pengguna->jenis_pengguna }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if($akses->kendaraan->jenis_kendaraan == 'Motor')
                                                <span class="badge bg-danger">Motor</span>
                                            @else
                                                <span class="badge bg-info">Mobil</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ \Carbon\Carbon::parse($akses->waktu_masuk)->format('d/m/Y H:i:s') }}</small>
                                        </td>
                                        <td>
                                            @if($akses->waktu_keluar)
                                                <small>{{ \Carbon\Carbon::parse($akses->waktu_keluar)->format('d/m/Y H:i:s') }}</small>
                                            @else
                                                <small class="text-muted">-</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($akses->waktu_keluar)
                                                @php
                                                    $masuk = \Carbon\Carbon::parse($akses->waktu_masuk);
                                                    $keluar = \Carbon\Carbon::parse($akses->waktu_keluar);
                                                    $durasi = $masuk->diff($keluar);
                                                    
                                                    $hari = $durasi->d;
                                                    $jam = $durasi->h;
                                                    $menit = $durasi->i;
                                                    
                                                    $durasiText = '';
                                                    if ($hari > 0) {
                                                        $durasiText .= $hari . ' hari ';
                                                    }
                                                    if ($jam > 0 || $hari > 0) {
                                                        $durasiText .= $jam . ' jam ';
                                                    }
                                                    $durasiText .= $menit . ' menit';
                                                @endphp
                                                <small>{{ trim($durasiText) }}</small>
                                            @else
                                                <small class="text-muted">-</small>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                <small>
                                    Menampilkan {{ $riwayat->firstItem() }} sampai {{ $riwayat->lastItem() }} 
                                    dari {{ $riwayat->total() }} data
                                </small>
                            </div>
                            <div>
                                @include('pagination.custom', ['paginator' => $riwayat])
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                            <h5>Belum ada riwayat transaksi</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
    </div>
    
</div>

<!-- Modal Kendaraan Masuk -->
<div class="modal fade" id="modalMasuk" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-box-arrow-in-right"></i> Kendaraan Masuk
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('akses-parkir.masuk') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kartu_id" class="form-label fw-semibold">
                            Scan/Input Kartu ID <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control form-control-lg" 
                            id="kartu_id" 
                            name="kartu_id" 
                            placeholder="Scan atau ketik Kartu ID"
                            required
                            autofocus
                        >
                        <div class="form-text">
                            <i class="bi bi-info-circle"></i> 
                            Scan kartu KTM/Karyawan atau ketik manual
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <small>
                            <i class="bi bi-lightbulb"></i>
                            Sistem akan otomatis mencatat waktu masuk kendaraan
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Catat Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto focus pada input kartu ID saat modal dibuka
    document.getElementById('modalMasuk').addEventListener('shown.bs.modal', function () {
        document.getElementById('kartu_id').focus();
    });
    
    // Auto uppercase kartu ID
    document.getElementById('kartu_id').addEventListener('input', function(e) {
        this.value = this.value.toUpperCase();
    });
    
    // Auto refresh setiap 30 detik untuk update durasi
    setInterval(function() {
        location.reload();
    }, 30000);
</script>
@endpush

@endsection