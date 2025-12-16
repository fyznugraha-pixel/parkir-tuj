@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')

@section('content')

<!-- Header Section -->
<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1">Data Pengguna</h4>
            <p class="text-muted mb-0">Kelola data mahasiswa, dosen, staff, pimpinan, dan tamu</p>
        </div>
        <a href="{{ route('pengguna.create') }}" class="btn-add">
            <i class="bi bi-plus-circle"></i> Tambah Pengguna
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid-wrapper mb-4">
    <div class="mini-stat-card">
        <div class="mini-stat-icon" style="background: #E31E24;">
            <i class="bi bi-people"></i>
        </div>
        <div class="mini-stat-info">
            <h5>{{ $pengguna->count() }}</h5>
            <p>Total</p>
        </div>
    </div>
    <div class="mini-stat-card">
        <div class="mini-stat-icon" style="background: #6366f1;">
            <i class="bi bi-mortarboard-fill"></i>
        </div>
        <div class="mini-stat-info">
            <h5>{{ $pengguna->where('jenis_pengguna', 'Mahasiswa')->count() }}</h5>
            <p>Mahasiswa</p>
        </div>
    </div>
    <div class="mini-stat-card">
        <div class="mini-stat-icon" style="background: #22c55e;">
            <i class="bi bi-person-badge"></i>
        </div>
        <div class="mini-stat-info">
            <h5>{{ $pengguna->where('jenis_pengguna', 'Dosen')->count() }}</h5>
            <p>Dosen</p>
        </div>
    </div>
    <div class="mini-stat-card">
        <div class="mini-stat-icon" style="background: #f59e0b;">
            <i class="bi bi-briefcase"></i>
        </div>
        <div class="mini-stat-info">
            <h5>{{ $pengguna->where('jenis_pengguna', 'Staff')->count() }}</h5>
            <p>Staff</p>
        </div>
    </div>
    <div class="mini-stat-card">
        <div class="mini-stat-icon" style="background: #8b5cf6;">
            <i class="bi bi-star"></i>
        </div>
        <div class="mini-stat-info">
            <h5>{{ $pengguna->where('jenis_pengguna', 'Pimpinan')->count() }}</h5>
            <p>Pimpinan</p>
        </div>
    </div>
    <div class="mini-stat-card">
        <div class="mini-stat-icon" style="background: #6c757d;">
            <i class="bi bi-person"></i>
        </div>
        <div class="mini-stat-info">
            <h5>{{ $pengguna->where('jenis_pengguna', 'Tamu')->count() }}</h5>
            <p>Tamu</p>
        </div>
    </div>
</div>

<!-- Filter & Search -->
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex gap-3 align-items-center flex-wrap">
            <div class="filter-group">
                <button type="button" class="filter-btn active" onclick="filterJenis('all')">
                    <i class="bi bi-list"></i> Semua
                </button>
                <button type="button" class="filter-btn" onclick="filterJenis('Mahasiswa')">
                    <i class="bi bi-mortarboard"></i> Mahasiswa
                </button>
                <button type="button" class="filter-btn" onclick="filterJenis('Dosen')">
                    <i class="bi bi-person-badge"></i> Dosen
                </button>
                <button type="button" class="filter-btn" onclick="filterJenis('Staff')">
                    <i class="bi bi-briefcase"></i> Staff
                </button>
                <button type="button" class="filter-btn" onclick="filterJenis('Pimpinan')">
                    <i class="bi bi-star"></i> Pimpinan
                </button>
                <button type="button" class="filter-btn" onclick="filterJenis('Tamu')">
                    <i class="bi bi-person"></i> Tamu
                </button>
            </div>
            <div class="search-box flex-grow-1">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" placeholder="Cari nama, NIM/NIP, atau kartu ID...">
            </div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="card">
    <div class="card-body p-0">
        @if($pengguna->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="penggunaTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama</th>
                            <th width="12%">Jenis</th>
                            <th width="15%">No. Identitas</th>
                            <th width="13%">Kartu ID</th>
                            <th width="13%">No. HP</th>
                            <th width="12%">Terdaftar</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengguna as $index => $item)
                        <tr data-jenis="{{ $item->jenis_pengguna }}">
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="user-box">
                                    <div class="user-ava">
                                        @if($item->jenis_pengguna == 'Mahasiswa')
                                            <i class="bi bi-mortarboard-fill" style="color: #6366f1;"></i>
                                        @elseif($item->jenis_pengguna == 'Dosen')
                                            <i class="bi bi-person-badge" style="color: #22c55e;"></i>
                                        @elseif($item->jenis_pengguna == 'Staff')
                                            <i class="bi bi-briefcase" style="color: #f59e0b;"></i>
                                        @elseif($item->jenis_pengguna == 'Pimpinan')
                                            <i class="bi bi-star" style="color: #8b5cf6;"></i>
                                        @else
                                            <i class="bi bi-person" style="color: #6c757d;"></i>
                                        @endif
                                    </div>
                                    <strong>{{ $item->nama_pengguna }}</strong>
                                </div>
                            </td>
                            <td>
                                @if($item->jenis_pengguna == 'Mahasiswa')
                                    <span class="badge-custom blue">
                                        <i class="bi bi-mortarboard"></i> Mahasiswa
                                    </span>
                                @elseif($item->jenis_pengguna == 'Dosen')
                                    <span class="badge-custom green">
                                        <i class="bi bi-person-badge"></i> Dosen
                                    </span>
                                @elseif($item->jenis_pengguna == 'Staff')
                                    <span class="badge-custom orange">
                                        <i class="bi bi-briefcase"></i> Staff
                                    </span>
                                @elseif($item->jenis_pengguna == 'Pimpinan')
                                    <span class="badge-custom purple">
                                        <i class="bi bi-star"></i> Pimpinan
                                    </span>
                                @else
                                    <span class="badge-custom gray">
                                        <i class="bi bi-person"></i> Tamu
                                    </span>
                                @endif
                            </td>
                            <td><code>{{ $item->nomor_identitas }}</code></td>
                            <td><span class="badge-id">{{ $item->kartu_id }}</span></td>
                            <td>{{ $item->no_hp ?? '-' }}</td>
                            <td><small class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</small></td>
                            <td class="text-center">
                                <div class="btn-group-action">
                                    <a href="{{ route('pengguna.edit', $item->id_pengguna) }}" class="btn-action edit" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn-action delete" onclick="confirmDelete({{ $item->id_pengguna }}, '{{ $item->nama_pengguna }}')" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h5>Belum ada data pengguna</h5>
                <p>Klik tombol "Tambah Pengguna" untuk menambah data baru</p>
                <a href="{{ route('pengguna.create') }}" class="btn-add">
                    <i class="bi bi-plus-circle"></i> Tambah Pengguna
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Form Delete (Hidden) -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('styles')
<style>
    /* Stats Grid - Semua Card Sejajar */
    .stats-grid-wrapper {
        display: flex;
        gap: 16px;
        overflow-x: auto;
        padding-bottom: 4px;
    }
    
    .stats-grid-wrapper::-webkit-scrollbar {
        height: 6px;
    }
    
    .stats-grid-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .stats-grid-wrapper::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 10px;
    }
    
    .stats-grid-wrapper::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
    
    .page-header h4 {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a1a;
    }
    
    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: #E31E24;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-add:hover {
        background: #b71c21;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(227, 30, 36, 0.3);
        color: white;
    }
    
    .mini-stat-card {
        background: white;
        border-radius: 10px;
        padding: 16px;
        border: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
        min-width: 160px;
        transition: all 0.2s;
    }
    
    .mini-stat-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    /* FIX BORDER RADIUS TABLE */
    .card table {
        border-radius: 12px;
        overflow: hidden;
    }

    /* Rapihin kolom No */
    #penggunaTable th:first-child,
    #penggunaTable td:first-child {
        text-align: left;
        padding-left: 22px;
        width: 60px;
        font-weight: 600;
    }
    
    .mini-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        flex-shrink: 0;
    }
    
    .mini-stat-info h5 {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }
    
    .mini-stat-info p {
        font-size: 12px;
        color: #6c757d;
        margin: 0;
    }
    
    .filter-group {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .filter-btn {
        padding: 8px 16px;
        background: white;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        color: #6c757d;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .filter-btn:hover {
        border-color: #E31E24;
        color: #E31E24;
        background: #fff5f5;
    }
    
    .filter-btn.active {
        background: #E31E24;
        color: white;
        border-color: #E31E24;
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
    }
    
    .search-box input {
        width: 100%;
        padding: 12px 16px 12px 44px;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    .search-box input:focus {
        outline: none;
        border-color: #E31E24;
        box-shadow: 0 0 0 4px rgba(227, 30, 36, 0.08);
    }
    
    .user-box {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .user-ava {
        width: 36px;
        height: 36px;
        background: #f8f9fa;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    
    .badge-custom {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .badge-custom.blue {
        background: #eff6ff;
        color: #1e40af;
    }
    
    .badge-custom.green {
        background: #f0fdf4;
        color: #166534;
    }
    
    .badge-custom.orange {
        background: #fffbeb;
        color: #92400e;
    }
    
    .badge-custom.purple {
        background: #f5f3ff;
        color: #6b21a8;
    }
    
    .badge-custom.gray {
        background: #f3f4f6;
        color: #4b5563;
    }
    
    .badge-id {
        padding: 4px 10px;
        background: #f8f9fa;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        color: #6c757d;
        font-family: 'Courier New', monospace;
    }
    
    .btn-group-action {
        display: flex;
        gap: 6px;
        justify-content: center;
    }
    
    .btn-action {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        background: #f8f9fa;
        color: #6c757d;
    }
    
    .btn-action.edit:hover {
        background: #fffbeb;
        color: #f59e0b;
    }
    
    .btn-action.delete:hover {
        background: #fff5f5;
        color: #E31E24;
    }
    
    .empty-state {
        text-align: center;
        padding: 64px 32px;
    }
    
    .empty-state i {
        font-size: 64px;
        color: #d1d5db;
        margin-bottom: 16px;
    }
    
    .empty-state h5 {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }
    
    .empty-state p {
        color: #6c757d;
        margin-bottom: 24px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid-wrapper {
            overflow-x: scroll;
        }
        
        .mini-stat-card {
            min-width: 140px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmDelete(id, nama) {
        if (confirm(`Apakah Anda yakin ingin menghapus pengguna "${nama}"?\n\nData yang dihapus tidak dapat dikembalikan.`)) {
            const form = document.getElementById('deleteForm');
            form.action = `/pengguna/${id}`;
            form.submit();
        }
    }
    
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#penggunaTable tbody tr');
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
    });
    
    function filterJenis(jenis) {
        const buttons = document.querySelectorAll('.filter-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        event.target.closest('button').classList.add('active');
        
        const tableRows = document.querySelectorAll('#penggunaTable tbody tr');
        tableRows.forEach(row => {
            if (jenis === 'all') {
                row.style.display = '';
            } else {
                row.style.display = row.dataset.jenis === jenis ? '' : 'none';
            }
        });
    }
</script>
@endpush

@endsection