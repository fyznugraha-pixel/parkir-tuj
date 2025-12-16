@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Data Pengguna')

@section('content')
<div class="container-fluid">
    
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('pengguna.index') }}">Pengguna</a>
            </li>
            <li class="breadcrumb-item active">Edit Data</li>
        </ol>
    </nav>
    
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square"></i> Form Edit Pengguna
                    </h5>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('pengguna.update', $pengguna->id_pengguna) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Info Badge -->
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> 
                            <strong>Sedang mengedit data:</strong> {{ $pengguna->nama_pengguna }}
                        </div>
                        
                        <!-- Nama Pengguna -->
                        <div class="mb-3">
                            <label for="nama_pengguna" class="form-label fw-semibold">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('nama_pengguna') is-invalid @enderror" 
                                id="nama_pengguna" 
                                name="nama_pengguna" 
                                value="{{ old('nama_pengguna', $pengguna->nama_pengguna) }}"
                                placeholder="Contoh: Fayiz Apriwansyah"
                                required
                                autofocus
                            >
                            @error('nama_pengguna')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Jenis Pengguna -->
                        <div class="mb-3">
                            <label for="jenis_pengguna" class="form-label fw-semibold">
                                Jenis Pengguna <span class="text-danger">*</span>
                            </label>
                            <select 
                                class="form-select @error('jenis_pengguna') is-invalid @enderror" 
                                id="jenis_pengguna" 
                                name="jenis_pengguna"
                                required
                            >
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Mahasiswa" {{ old('jenis_pengguna', $pengguna->jenis_pengguna) == 'Mahasiswa' ? 'selected' : '' }}>
                                    Mahasiswa
                                </option>
                                <option value="Dosen" {{ old('jenis_pengguna', $pengguna->jenis_pengguna) == 'Dosen' ? 'selected' : '' }}>
                                    Dosen
                                </option>
                                <option value="Pimpinan" {{ old('jenis_pengguna', $pengguna->jenis_pengguna) == 'Pimpinan' ? 'selected' : '' }}>
                                    Pimpinan
                                </option>
                                <option value="Staff" {{ old('jenis_pengguna', $pengguna->jenis_pengguna) == 'Staff' ? 'selected' : '' }}>
                                    Staff
                                </option>
                                <option value="Tamu" {{ old('jenis_pengguna', $pengguna->jenis_pengguna) == 'Tamu' ? 'selected' : '' }}>
                                    Tamu
                                </option>
                            </select>
                            @error('jenis_pengguna')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Nomor Identitas -->
                        <div class="mb-3">
                            <label for="nomor_identitas" class="form-label fw-semibold">
                                Nomor Identitas (NIM/NIP) <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('nomor_identitas') is-invalid @enderror" 
                                id="nomor_identitas" 
                                name="nomor_identitas" 
                                value="{{ old('nomor_identitas', $pengguna->nomor_identitas) }}"
                                placeholder="Contoh: 102042400062 atau D001"
                                required
                            >
                            @error('nomor_identitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> 
                                Masukkan NIM untuk mahasiswa atau NIP untuk Pimpinan, Dosen, dan Staff Serta No KTP untuk tamu
                            </div>
                        </div>
                        
                        <!-- Kartu ID -->
                        <div class="mb-3">
                            <label for="kartu_id" class="form-label fw-semibold">
                                Kartu ID <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('kartu_id') is-invalid @enderror" 
                                id="kartu_id" 
                                name="kartu_id" 
                                value="{{ old('kartu_id', $pengguna->kartu_id) }}"
                                placeholder="Contoh: KTM102062 atau KRY001"
                                required
                            >
                            @error('kartu_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> 
                                Nomor kartu KTM (mahasiswa) atau Kartu Karyawan (dosen)
                            </div>
                        </div>
                        
                        <!-- No HP -->
                        <div class="mb-4">
                            <label for="no_hp" class="form-label fw-semibold">
                                Nomor HP
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('no_hp') is-invalid @enderror" 
                                id="no_hp" 
                                name="no_hp" 
                                value="{{ old('no_hp', $pengguna->no_hp) }}"
                                placeholder="Contoh: 081234567890"
                            >
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> 
                                Opsional, dapat dikosongkan
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <!-- Info Terakhir Update -->
                        <div class="alert alert-light border">
                            <small class="text-muted">
                                <i class="bi bi-clock"></i> 
                                Data terdaftar: {{ \Carbon\Carbon::parse($pengguna->created_at)->format('d F Y H:i') }}
                            </small>
                        </div>
                        
                        <!-- Tombol Aksi -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('pengguna.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="bi bi-check-circle"></i> Update Data
                            </button>
                        </div>
                        
                    </form>
                </div>
            </div>
            
            <!-- Warning Box -->
            <div class="alert alert-warning mt-3">
                <i class="bi bi-exclamation-triangle"></i>
                <strong>Perhatian:</strong>
                <ul class="mb-0 mt-2">
                    <li>Pastikan data yang diubah sudah benar</li>
                    <li>Nomor identitas dan Kartu ID tidak boleh sama dengan pengguna lain</li>
                    <li>Perubahan data akan dicatat dalam log aktivitas</li>
                </ul>
            </div>
            
        </div>
    </div>
    
</div>

@push('scripts')
<script>
    // Auto-format nomor HP
    document.getElementById('no_hp').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, ''); // Hapus non-digit
        e.target.value = value;
    });
    
    // Update label berdasarkan jenis pengguna
    document.getElementById('jenis_pengguna').addEventListener('change', function() {
        const identitasLabel = document.querySelector('label[for="nomor_identitas"]');
        const kartuLabel = document.querySelector('label[for="kartu_id"]');
        
        if (this.value === 'Mahasiswa') {
            identitasLabel.innerHTML = 'Nomor Identitas (NIM) <span class="text-danger">*</span>';
            kartuLabel.innerHTML = 'Kartu ID (KTM) <span class="text-danger">*</span>';
            document.getElementById('nomor_identitas').placeholder = 'Contoh: 102042400062';
            document.getElementById('kartu_id').placeholder = 'Contoh: KTM102062';
        } else if (this.value === 'Dosen') {
            identitasLabel.innerHTML = 'Nomor Identitas (NIP) <span class="text-danger">*</span>';
            kartuLabel.innerHTML = 'Kartu ID (Karyawan) <span class="text-danger">*</span>';
            document.getElementById('nomor_identitas').placeholder = 'Contoh: D001';
            document.getElementById('kartu_id').placeholder = 'Contoh: DSN001';
        } else if (this.value === 'Pimpinan') {
            identitasLabel.innerHTML = 'Nomor Identitas (NIP) <span class="text-danger">*</span>';
            kartuLabel.innerHTML = 'Kartu ID (Karyawan) <span class="text-danger">*</span>';
            document.getElementById('nomor_identitas').placeholder = 'Contoh: D001';
            document.getElementById('kartu_id').placeholder = 'Contoh: PMP001';
        } else if (this.value === 'Staff') {
            identitasLabel.innerHTML = 'Nomor Identitas (NIP) <span class="text-danger">*</span>';
            kartuLabel.innerHTML = 'Kartu ID (Karyawan) <span class="text-danger">*</span>';
            document.getElementById('nomor_identitas').placeholder = 'Contoh: D001';
            document.getElementById('kartu_id').placeholder = 'Contoh: KRY001';
        } else if (this.value === 'Tamu') {
            identitasLabel.innerHTML = 'Nomor Identitas (NIP) <span class="text-danger">*</span>';
            kartuLabel.innerHTML = 'Kartu ID (Karyawan) <span class="text-danger">*</span>';
            document.getElementById('nomor_identitas').placeholder = 'Contoh: D001';
            document.getElementById('kartu_id').placeholder = 'Contoh: TMU001';
        } 
    });
</script>
@endpush

@endsection