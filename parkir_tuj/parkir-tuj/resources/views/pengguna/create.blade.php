@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna Baru')

@section('content')

<!-- Breadcrumb -->
<nav class="breadcrumb-custom mb-4">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <i class="bi bi-chevron-right"></i>
    <a href="{{ route('pengguna.index') }}">Pengguna</a>
    <i class="bi bi-chevron-right"></i>
    <span>Tambah Baru</span>
</nav>

<div class="row justify-content-center">
    <div class="col-lg-8">
        
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-person-plus"></i> Form Tambah Pengguna</h5>
            </div>
            
            <div class="card-body">
                <form action="{{ route('pengguna.store') }}" method="POST">
                    @csrf
                    
                    <!-- Nama Pengguna -->
                    <div class="mb-3">
                        <label for="nama_pengguna" class="form-label">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('nama_pengguna') is-invalid @enderror" 
                            id="nama_pengguna" 
                            name="nama_pengguna" 
                            value="{{ old('nama_pengguna') }}"
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
                        <label for="jenis_pengguna" class="form-label">
                            Jenis Pengguna <span class="text-danger">*</span>
                        </label>
                        <div class="role-selector">
                            <div class="role-option">
                                <input type="radio" id="mahasiswa" name="jenis_pengguna" value="Mahasiswa" {{ old('jenis_pengguna') == 'Mahasiswa' ? 'checked' : '' }} required>
                                <label for="mahasiswa">
                                    <div class="role-icon" style="background: #eff6ff; color: #1e40af;">
                                        <i class="bi bi-mortarboard-fill"></i>
                                    </div>
                                    <strong>Mahasiswa</strong>
                                </label>
                            </div>
                            
                            <div class="role-option">
                                <input type="radio" id="dosen" name="jenis_pengguna" value="Dosen" {{ old('jenis_pengguna') == 'Dosen' ? 'checked' : '' }} required>
                                <label for="dosen">
                                    <div class="role-icon" style="background: #f0fdf4; color: #166534;">
                                        <i class="bi bi-person-badge"></i>
                                    </div>
                                    <strong>Dosen</strong>
                                </label>
                            </div>
                            
                            <div class="role-option">
                                <input type="radio" id="staff" name="jenis_pengguna" value="Staff" {{ old('jenis_pengguna') == 'Staff' ? 'checked' : '' }} required>
                                <label for="staff">
                                    <div class="role-icon" style="background: #fffbeb; color: #92400e;">
                                        <i class="bi bi-briefcase"></i>
                                    </div>
                                    <strong>Staff</strong>
                                </label>
                            </div>
                            
                            <div class="role-option">
                                <input type="radio" id="pimpinan" name="jenis_pengguna" value="Pimpinan" {{ old('jenis_pengguna') == 'Pimpinan' ? 'checked' : '' }} required>
                                <label for="pimpinan">
                                    <div class="role-icon" style="background: #f5f3ff; color: #6b21a8;">
                                        <i class="bi bi-star"></i>
                                    </div>
                                    <strong>Pimpinan</strong>
                                </label>
                            </div>
                            
                            <div class="role-option">
                                <input type="radio" id="tamu" name="jenis_pengguna" value="Tamu" {{ old('jenis_pengguna') == 'Tamu' ? 'checked' : '' }} required>
                                <label for="tamu">
                                    <div class="role-icon" style="background: #f3f4f6; color: #4b5563;">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <strong>Tamu</strong>
                                </label>
                            </div>
                        </div>
                        @error('jenis_pengguna')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Nomor Identitas -->
                    <div class="mb-3">
                        <label for="nomor_identitas" class="form-label">
                            <span id="labelIdentitas">Nomor Identitas</span> <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('nomor_identitas') is-invalid @enderror" 
                            id="nomor_identitas" 
                            name="nomor_identitas" 
                            value="{{ old('nomor_identitas') }}"
                            placeholder="Contoh: 102042400062"
                            required
                        >
                        @error('nomor_identitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted" id="hintIdentitas">
                            <i class="bi bi-info-circle"></i> NIM untuk mahasiswa, NIP untuk dosen/staff, atau ID khusus
                        </small>
                    </div>
                    
                    <!-- Kartu ID -->
                    <div class="mb-3">
                        <label for="kartu_id" class="form-label">
                            <span id="labelKartu">Kartu ID</span> <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('kartu_id') is-invalid @enderror" 
                            id="kartu_id" 
                            name="kartu_id" 
                            value="{{ old('kartu_id') }}"
                            placeholder="Contoh: KTM102062"
                            required
                        >
                        @error('kartu_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted" id="hintKartu">
                            <i class="bi bi-info-circle"></i> Nomor kartu yang akan digunakan untuk scan
                        </small>
                    </div>
                    
                    <!-- No HP -->
                    <div class="mb-4">
                        <label for="no_hp" class="form-label">Nomor HP</label>
                        <input 
                            type="text" 
                            class="form-control @error('no_hp') is-invalid @enderror" 
                            id="no_hp" 
                            name="no_hp" 
                            value="{{ old('no_hp') }}"
                            placeholder="Contoh: 081234567890"
                        >
                        @error('no_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="bi bi-info-circle"></i> Opsional, dapat dikosongkan
                        </small>
                    </div>
                    
                    <hr class="my-4">
                    
                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('pengguna.index') }}" class="btn-secondary-custom">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn-primary-custom">
                            <i class="bi bi-save"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Info Box -->
        <div class="info-box">
            <i class="bi bi-lightbulb"></i>
            <div>
                <strong>Catatan Penting:</strong>
                <ul class="mb-0 mt-2">
                    <li>Field dengan tanda <span class="text-danger">*</span> wajib diisi</li>
                    <li>Nomor identitas dan Kartu ID harus unik (tidak boleh duplikat)</li>
                    <li>Pilih jenis pengguna sesuai dengan status di kampus</li>
                    <li>Data yang disimpan akan tercatat dalam log aktivitas admin</li>
                </ul>
            </div>
        </div>
        
    </div>
</div>

@push('styles')
<style>
    .breadcrumb-custom {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #6c757d;
    }
    
    .breadcrumb-custom a {
        color: #6c757d;
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .breadcrumb-custom a:hover {
        color: #E31E24;
    }
    
    .breadcrumb-custom span {
        color: #1a1a1a;
        font-weight: 600;
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
    }
    
    .form-label {
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 8px;
    }
    
    .form-control {
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        border-color: #E31E24;
        box-shadow: 0 0 0 4px rgba(227, 30, 36, 0.08);
    }
    
    .role-selector {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 12px;
    }
    
    .role-option {
        position: relative;
    }
    
    .role-option input[type="radio"] {
        position: absolute;
        opacity: 0;
    }
    
    .role-option label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 16px 12px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
    }
    
    .role-option input[type="radio"]:checked + label {
        border-color: #E31E24;
        background: #fff5f5;
    }
    
    .role-option label:hover {
        border-color: #E31E24;
    }
    
    .role-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    
    .role-option strong {
        font-size: 13px;
        color: #1a1a1a;
    }
    
    .btn-primary-custom {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: #E31E24;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-primary-custom:hover {
        background: #b71c21;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(227, 30, 36, 0.3);
    }
    
    .btn-secondary-custom {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: white;
        color: #6c757d;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .btn-secondary-custom:hover {
        border-color: #E31E24;
        color: #E31E24;
    }
    
    .info-box {
        margin-top: 24px;
        padding: 20px;
        background: #f0f9ff;
        border-left: 4px solid #0284c7;
        border-radius: 8px;
        display: flex;
        gap: 16px;
    }
    
    .info-box > i {
        font-size: 24px;
        color: #0284c7;
    }
    
    .info-box ul {
        padding-left: 20px;
        margin-top: 8px;
    }
    
    .info-box li {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 6px;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto format nomor HP
    document.getElementById('no_hp').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value;
    });
    
    // Update label dan hint berdasarkan jenis pengguna
    const radioButtons = document.querySelectorAll('input[name="jenis_pengguna"]');
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            updateLabels(this.value);
        });
    });
    
    function updateLabels(jenis) {
        const labelIdentitas = document.getElementById('labelIdentitas');
        const hintIdentitas = document.getElementById('hintIdentitas');
        const labelKartu = document.getElementById('labelKartu');
        const hintKartu = document.getElementById('hintKartu');
        const identitasInput = document.getElementById('nomor_identitas');
        const kartuInput = document.getElementById('kartu_id');
        
        switch(jenis) {
            case 'Mahasiswa':
                labelIdentitas.textContent = 'NIM (Nomor Induk Mahasiswa)';
                identitasInput.placeholder = 'Contoh: 102042400062';
                labelKartu.textContent = 'Kartu ID (KTM)';
                kartuInput.placeholder = 'Contoh: KTM102062';
                hintKartu.innerHTML = '<i class="bi bi-info-circle"></i> Nomor Kartu Tanda Mahasiswa';
                break;
            case 'Dosen':
                labelIdentitas.textContent = 'NIP Dosen';
                identitasInput.placeholder = 'Contoh: D001';
                labelKartu.textContent = 'Kartu ID Karyawan';
                kartuInput.placeholder = 'Contoh: KRY001';
                hintKartu.innerHTML = '<i class="bi bi-info-circle"></i> Nomor Kartu Karyawan Dosen';
                break;
            case 'Staff':
                labelIdentitas.textContent = 'NIP Staff';
                identitasInput.placeholder = 'Contoh: STF001';
                labelKartu.textContent = 'Kartu ID Staff';
                kartuInput.placeholder = 'Contoh: KSTAFF001';
                hintKartu.innerHTML = '<i class="bi bi-info-circle"></i> Nomor Kartu Staff';
                break;
            case 'Pimpinan':
                labelIdentitas.textContent = 'NIP Pimpinan';
                identitasInput.placeholder = 'Contoh: PMP001';
                labelKartu.textContent = 'Kartu ID Pimpinan';
                kartuInput.placeholder = 'Contoh: KPIMP001';
                hintKartu.innerHTML = '<i class="bi bi-info-circle"></i> Nomor Kartu Pimpinan';
                break;
            case 'Tamu':
                labelIdentitas.textContent = 'ID Tamu';
                identitasInput.placeholder = 'Contoh: TMU001';
                labelKartu.textContent = 'Kartu ID Tamu';
                kartuInput.placeholder = 'Contoh: KTAMU001';
                hintKartu.innerHTML = '<i class="bi bi-info-circle"></i> Nomor Kartu Tamu Sementara';
                break;
        }
    }
    
    // Set initial labels jika ada old value
    const checkedRadio = document.querySelector('input[name="jenis_pengguna"]:checked');
    if (checkedRadio) {
        updateLabels(checkedRadio.value);
    }
</script>
@endpush

@endsection