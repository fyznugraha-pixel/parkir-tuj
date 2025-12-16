@extends('layouts.app')

@section('title', 'Manajemen Kendaraan')
@section('page-title', 'Manajemen Kendaraan')

@section('content')
<div class="container-fluid">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Header dengan tombol tambah -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Data Kendaraan</h4>
            <p class="text-muted mb-0">Kelola data kendaraan mahasiswa dan dosen</p>
        </div>
        <a href="{{ route('kendaraan.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Kendaraan
        </a>
    </div>
    
    <!-- Statistik Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Total Kendaraan</h6>
                            <h2 class="mb-0 fw-bold">{{ $kendaraan->count() }}</h2>
                        </div>
                        <i class="bi bi-car-front fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Motor</h6>
                            <h2 class="mb-0 fw-bold">{{ $kendaraan->where('jenis_kendaraan', 'Motor')->count() }}</h2>
                        </div>
                        <i class="fa-solid fa-motorcycle fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Mobil</h6>
                            <h2 class="mb-0 fw-bold">{{ $kendaraan->where('jenis_kendaraan', 'Mobil')->count() }}</h2>
                        </div>
                        <i class="bi bi-car-front-fill fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card Tabel -->
    <div class="card">
        <div class="card-body">
            
            <!-- Filter dan Search -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary active" onclick="filterJenis('all')">
                            <i class="bi bi-list"></i> Semua ({{ $kendaraan->count() }})
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="filterJenis('Motor')">
                            <i class="fa-solid fa-motorcycle"></i> Motor ({{ $kendaraan->where('jenis_kendaraan', 'Motor')->count() }})
                        </button>
                        <button type="button" class="btn btn-outline-info" onclick="filterJenis('Mobil')">
                            <i class="bi bi-car-front"></i> Mobil ({{ $kendaraan->where('jenis_kendaraan', 'Mobil')->count() }})
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari plat nomor, pemilik, atau merek...">
                    </div>
                </div>
            </div>
            
            <!-- Tabel Kendaraan -->
            @if($kendaraan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="kendaraanTable">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Plat Nomor</th>
                                <th width="25%">Pemilik</th>
                                <th width="12%">Jenis</th>
                                <th width="13%">Jenis Kendaraan</th>
                                <th width="12%">Merek Kendaraan</th>
                                <th width="13%">Terdaftar</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kendaraan as $index => $item)
                            <tr data-jenis="{{ $item->jenis_kendaraan }}">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong class="text-primary">{{ $item->plat_nomor }}</strong>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $item->pengguna->nama_pengguna }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            {{ $item->pengguna->nomor_identitas }}
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    @if($item->pengguna->jenis_pengguna == 'Mahasiswa')
                                        <span class="badge bg-primary">
                                            <i class="bi bi-mortarboard"></i> Mahasiswa
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            <i class="bi bi-person-badge"></i> Dosen
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->jenis_kendaraan == 'Motor')
                                        <span class="badge bg-danger">
                                            <i class="fa-solid fa-motorcycle"></i> Motor
                                        </span>
                                    @else
                                        <span class="badge bg-info">
                                            <i class="bi bi-car-front"></i> Mobil
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $item->merek }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($item->created_at ?? now())->format('d/m/Y') }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('kendaraan.edit', $item->id_kendaraan) }}" 
                                           class="btn btn-warning" 
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-danger" 
                                                onclick="confirmDelete({{ $item->id_kendaraan }}, '{{ $item->plat_nomor }}')"
                                                title="Hapus">
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
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                    <h5>Belum ada data kendaraan</h5>
                    <p>Klik tombol "Tambah Kendaraan" untuk menambah data baru</p>
                </div>
            @endif
            
        </div>
    </div>
    
</div>

<!-- Form Delete (Hidden) -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
    // Fungsi konfirmasi delete
    function confirmDelete(id, plat) {
        if (confirm(`Apakah Anda yakin ingin menghapus kendaraan "${plat}"?\n\nData yang dihapus tidak dapat dikembalikan.`)) {
            const form = document.getElementById('deleteForm');
            form.action = `/kendaraan/${id}`;
            form.submit();
        }
    }
    
    // Live search
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#kendaraanTable tbody tr');
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
    });
    
    // Filter berdasarkan jenis kendaraan
    function filterJenis(jenis) {
        const buttons = document.querySelectorAll('.btn-group button');
        buttons.forEach(btn => btn.classList.remove('active'));
        event.target.closest('button').classList.add('active');
        
        const tableRows = document.querySelectorAll('#kendaraanTable tbody tr');
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