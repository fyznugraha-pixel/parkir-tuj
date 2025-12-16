@extends('layouts.app')

@section('title', 'Log Aktivitas')
@section('page-title', 'Log Aktivitas Sistem')


@section('content')

<div class="container-fluid">
    
    <!-- Header -->
    <div class="page-header mb-4">
        <div>
            <h4 class="mb-1">Log Aktivitas Sistem</h4>
            <p class="text-muted mb-0">Riwayat semua aktivitas yang dilakukan administrator</p>
        </div>
    </div>
    
    <!-- Statistik Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card-mini">
                <div class="stat-icon" style="background: #E31E24;">
                    <i class="bi bi-list-ul"></i>
                </div>
                <div class="stat-info">
                    <h5>{{ $totalLog }}</h5>
                    <p>Total Log</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stat-card-mini">
                <div class="stat-icon" style="background: #22c55e;">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h5>{{ $logHariIni }}</h5>
                    <p>Hari Ini</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stat-card-mini">
                <div class="stat-icon" style="background: #f59e0b;">
                    <i class="bi bi-calendar3"></i>
                </div>
                <div class="stat-info">
                    <h5>{{ $logMingguIni }}</h5>
                    <p>Minggu Ini</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stat-card-mini">
                <div class="stat-icon" style="background: #6366f1;">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-info">
                    <h5>{{ $adminAktif }}</h5>
                    <p>Admin Aktif</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Search & Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Cari Aktivitas</label>
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari aktivitas atau nama admin...">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn-export w-100">
                        <i class="bi bi-download"></i> Export Log
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Table Card -->
    <div class="card">
        <div class="card-header">
            <h5><i class="bi bi-clock-history"></i> Riwayat Aktivitas</h5>
        </div>
        
        <div class="card-body p-0">
            @if($logs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="logTable">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="12%">Tanggal</th>
                                <th width="10%">Waktu</th>
                                <th width="18%">Admin</th>
                                <th width="45%">Aktivitas</th>
                                <th width="10%">Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $index => $log)
                            <tr>
                                <td>{{ $logs->firstItem() + $index }}</td>
                                <td>
                                    <div class="log-date">
                                        {{ \Carbon\Carbon::parse($log->waktu)->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td>
                                    <div class="log-time">
                                        {{ \Carbon\Carbon::parse($log->waktu)->format('H:i:s') }}
                                    </div>
                                </td>
                                <td>
                                    <div class="admin-info">
                                        <div class="admin-avatar">
                                            <i class="bi bi-person-circle"></i>
                                        </div>
                                        <div class="admin-details">
                                            <div class="admin-name">{{ $log->admin->nama_admin }}</div>
                                            <div class="admin-username">{{ $log->admin->username }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="activity-text">{{ $log->aktivitas }}</div>
                                    <div class="activity-time">
                                        <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($log->waktu)->diffForHumans() }}
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $badge = 'secondary';
                                        $icon = 'gear';
                                        $text = 'Lainnya';
                                        
                                        if (stripos($log->aktivitas, 'login') !== false) {
                                            $badge = 'success';
                                            $icon = 'box-arrow-in-right';
                                            $text = 'Login';
                                        } elseif (stripos($log->aktivitas, 'logout') !== false) {
                                            $badge = 'warning';
                                            $icon = 'box-arrow-right';
                                            $text = 'Logout';
                                        } elseif (stripos($log->aktivitas, 'tambah') !== false || stripos($log->aktivitas, 'menambah') !== false) {
                                            $badge = 'primary';
                                            $icon = 'plus-circle';
                                            $text = 'Tambah';
                                        } elseif (stripos($log->aktivitas, 'update') !== false || stripos($log->aktivitas, 'edit') !== false || stripos($log->aktivitas, 'mengupdate') !== false) {
                                            $badge = 'info';
                                            $icon = 'pencil';
                                            $text = 'Update';
                                        } elseif (stripos($log->aktivitas, 'hapus') !== false) {
                                            $badge = 'danger';
                                            $icon = 'trash';
                                            $text = 'Hapus';
                                        }
                                    @endphp
                                    <span class="badge-category badge-{{ $badge }}">
                                        <i class="bi bi-{{ $icon }}"></i>
                                        {{ $text }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Custom Pagination -->
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Menampilkan {{ $logs->firstItem() }} - {{ $logs->lastItem() }} dari {{ $logs->total() }} log
                    </div>
                    <div class="pagination-controls">
                        <nav>
                            <ul class="pagination-custom">
                                {{-- Previous Button --}}
                                @if ($logs->onFirstPage())
                                    <li class="page-item-custom disabled">
                                        <span class="page-link-custom">
                                            <i class="bi bi-chevron-left"></i>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item-custom">
                                        <a class="page-link-custom" href="{{ $logs->previousPageUrl() }}">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- Page Numbers --}}
                                @php
                                    $start = max($logs->currentPage() - 2, 1);
                                    $end = min($start + 4, $logs->lastPage());
                                    $start = max($end - 4, 1);
                                @endphp

                                @if($start > 1)
                                    <li class="page-item-custom">
                                        <a class="page-link-custom" href="{{ $logs->url(1) }}">1</a>
                                    </li>
                                    @if($start > 2)
                                        <li class="page-item-custom disabled">
                                            <span class="page-link-custom">...</span>
                                        </li>
                                    @endif
                                @endif

                                @for($page = $start; $page <= $end; $page++)
                                    @if($page == $logs->currentPage())
                                        <li class="page-item-custom active">
                                            <span class="page-link-custom">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item-custom">
                                            <a class="page-link-custom" href="{{ $logs->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endfor

                                @if($end < $logs->lastPage())
                                    @if($end < $logs->lastPage() - 1)
                                        <li class="page-item-custom disabled">
                                            <span class="page-link-custom">...</span>
                                        </li>
                                    @endif
                                    <li class="page-item-custom">
                                        <a class="page-link-custom" href="{{ $logs->url($logs->lastPage()) }}">{{ $logs->lastPage() }}</a>
                                    </li>
                                @endif

                                {{-- Next Button --}}
                                @if ($logs->hasMorePages())
                                    <li class="page-item-custom">
                                        <a class="page-link-custom" href="{{ $logs->nextPageUrl() }}">
                                            <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item-custom disabled">
                                        <span class="page-link-custom">
                                            <i class="bi bi-chevron-right"></i>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h5>Belum ada log aktivitas</h5>
                    <p>Log akan muncul setelah admin melakukan aktivitas</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Info Box -->
    <div class="info-box-log">
        <div class="info-header">
            <i class="bi bi-info-circle"></i>
            <strong>Informasi Log Aktivitas</strong>
        </div>
        <ul class="info-list">
            <li>Log mencatat semua aktivitas admin secara otomatis</li>
            <li>Data log digunakan untuk keperluan audit dan monitoring sistem</li>
            <li>Log tidak dapat diedit atau dihapus untuk menjaga integritas data</li>
            <li>Halaman ini otomatis refresh setiap 60 detik</li>
        </ul>
    </div>
    
    <!-- Modal Export -->
    <div class="modal fade" id="modalExport" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-download"></i> Export Log Aktivitas
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('log.export') }}" method="GET">
                    <div class="modal-body">
                        
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            <strong>Filter Tanggal (Opsional)</strong><br>
                            <small>Kosongkan untuk export semua data</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="start_date" class="form-label fw-semibold">
                                Tanggal Mulai
                            </label>
                            <input 
                                type="date" 
                                class="form-control" 
                                id="start_date" 
                                name="start_date"
                                max="{{ date('Y-m-d') }}"
                            >
                        </div>
                        
                        <div class="mb-3">
                            <label for="end_date" class="form-label fw-semibold">
                                Tanggal Akhir
                            </label>
                            <input 
                                type="date" 
                                class="form-control" 
                                id="end_date" 
                                name="end_date"
                                max="{{ date('Y-m-d') }}"
                            >
                        </div>
                        
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            <small>File akan di-download dalam format xlsx (Excel)</small>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-download"></i> Download Log
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> 
</div>

@push('styles')
<style>
    .page-header h4 {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a1a;
    }
    
    .stat-card-mini {
        background: white;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.3s;
    }
    
    .stat-card-mini:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    }
    
    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        flex-shrink: 0;
    }
    
    .stat-info h5 {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }
    
    .stat-info p {
        font-size: 13px;
        color: #6c757d;
        margin: 0;
    }
    
    .card-header {
        background: white;
        border-bottom: 1px solid #e5e7eb;
        padding: 20px 24px;
    }
    
    .card-header h5 {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .search-box {
        position: relative;
    }
    
    .search-box i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        z-index: 1;
    }
    
    .search-box .form-control {
        padding-left: 44px;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        transition: all 0.3s;
    }
    
    .search-box .form-control:focus {
        border-color: #E31E24;
        box-shadow: 0 0 0 4px rgba(227, 30, 36, 0.08);
    }
    
    .btn-export {
        padding: 12px 24px;
        background: #E31E24;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .btn-export:hover {
        background: #b71c21;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(227, 30, 36, 0.3);
    }
    
    .table {
        margin: 0;
    }
    
    .table thead th {
        font-size: 13px;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 16px 20px;
        border-bottom: 2px solid #e5e7eb;
        background: #f9fafb;
    }
    
    .table tbody td {
        padding: 16px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
    }
    
    .table tbody tr:hover {
        background: #f9fafb;
    }
    
    .log-date {
        font-weight: 600;
        color: #1a1a1a;
    }
    
    .log-time {
        font-family: 'Courier New', monospace;
        color: #6c757d;
        font-size: 13px;
    }
    
    .admin-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .admin-avatar {
        width: 40px;
        height: 40px;
        background: #f3f4f6;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #E31E24;
        font-size: 24px;
        flex-shrink: 0;
    }
    
    .admin-details {
        flex: 1;
        min-width: 0;
    }
    
    .admin-name {
        font-weight: 600;
        color: #1a1a1a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .admin-username {
        font-size: 12px;
        color: #9ca3af;
    }
    
    .activity-text {
        color: #1a1a1a;
        margin-bottom: 4px;
        line-height: 1.4;
    }
    
    .activity-time {
        font-size: 12px;
        color: #9ca3af;
    }
    
    .badge-category {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }
    
    .badge-success {
        background: #f0fdf4;
        color: #166534;
    }
    
    .badge-warning {
        background: #fffbeb;
        color: #92400e;
    }
    
    .badge-primary {
        background: #eff6ff;
        color: #1e40af;
    }
    
    .badge-info {
        background: #f0f9ff;
        color: #075985;
    }
    
    .badge-danger {
        background: #fff5f5;
        color: #dc2626;
    }
    
    .badge-secondary {
        background: #f3f4f6;
        color: #4b5563;
    }
    
    /* Custom Pagination Styles */
    .pagination-wrapper {
        padding: 20px 24px;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }
    
    .pagination-info {
        font-size: 14px;
        color: #6c757d;
    }
    
    .pagination-controls {
        display: flex;
        align-items: center;
    }
    
    .pagination-custom {
        margin: 0;
        padding: 0;
        display: flex;
        gap: 4px;
        list-style: none;
        align-items: center;
    }
    
    .page-item-custom {
        display: inline-block;
    }
    
    .page-link-custom {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        color: #6c757d;
        background: white;
        font-weight: 500;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.2s;
        cursor: pointer;
    }
    
    .page-link-custom i {
        font-size: 12px;
        line-height: 1;
    }
    
    .page-item-custom.active .page-link-custom {
        background: #E31E24;
        border-color: #E31E24;
        color: white;
    }
    
    .page-item-custom.disabled .page-link-custom {
        color: #d1d5db;
        background: #f9fafb;
        cursor: not-allowed;
        pointer-events: none;
    }
    
    .page-item-custom:not(.disabled):not(.active) .page-link-custom:hover {
        background: #fff5f5;
        border-color: #E31E24;
        color: #E31E24;
    }
    
    .empty-state {
        text-align: center;
        padding: 80px 32px;
        color: #9ca3af;
    }
    
    .empty-state i {
        font-size: 64px;
        margin-bottom: 16px;
        opacity: 0.5;
    }
    
    .empty-state h5 {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }
    
    .info-box-log {
        margin-top: 24px;
        padding: 20px 24px;
        background: #f0f9ff;
        border-left: 4px solid #0284c7;
        border-radius: 8px;
    }
    
    .info-header {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #0284c7;
        font-weight: 600;
        margin-bottom: 12px;
    }
    
    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .info-list li {
        padding-left: 24px;
        position: relative;
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 8px;
        line-height: 1.5;
    }
    
    .info-list li::before {
        content: '•';
        position: absolute;
        left: 8px;
        color: #0284c7;
        font-weight: bold;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .admin-info {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .pagination-wrapper {
            flex-direction: column;
            text-align: center;
        }
        
        .pagination-custom {
            flex-wrap: wrap;
            justify-content: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Live search
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#logTable tbody tr');
        
        let visibleCount = 0;
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchValue)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Update pagination info
        const paginationInfo = document.querySelector('.pagination-info');
        if (paginationInfo && searchValue) {
            paginationInfo.textContent = `Menampilkan ${visibleCount} hasil pencarian`;
        }
    });

    // Auto refresh setiap 60 detik
    setTimeout(function() {
        location.reload();
    }, 60000);

    // Export function - Open Modal (UPDATED)
    document.querySelector('.btn-export').addEventListener('click', function() {
        const modal = new bootstrap.Modal(document.getElementById('modalExport'));
        modal.show();
    });

    // Validate date range
    document.getElementById('end_date').addEventListener('change', function() {
        const startDate = document.getElementById('start_date').value;
        const endDate = this.value;
        
        if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
            alert('Tanggal akhir tidak boleh lebih kecil dari tanggal mulai!');
            this.value = '';
        }
    });
</script>
@endpush

@endsection