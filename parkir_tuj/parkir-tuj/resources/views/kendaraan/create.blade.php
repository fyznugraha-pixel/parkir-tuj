@extends('layouts.app')

@section('title', 'Tambah Kendaraan')
@section('page-title', 'Tambah Kendaraan Baru')

@section('content')
<div class="container-fluid">
    
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('kendaraan.index') }}">Kendaraan</a>
            </li>
            <li class="breadcrumb-item active">Tambah Baru</li>
        </ol>
    </nav>
    
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-car-front"></i> Form Tambah Kendaraan
                    </h5>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('kendaraan.store') }}" method="POST">
                        @csrf
                        
                        <!-- Pilih Pemilik -->
                        <div class="mb-3">
                            <label for="id_pengguna" class="form-label fw-semibold">
                                Pemilik Kendaraan <span class="text-danger">*</span>
                            </label>
                            <select 
                                class="form-select @error('id_pengguna') is-invalid @enderror" 
                                id="id_pengguna" 
                                name="id_pengguna"
                                required
                            >
                                <option value="">-- Pilih Pemilik --</option>
                                @foreach($pengguna as $p)
                                    <option value="{{ $p->id_pengguna }}" {{ old('id_pengguna') == $p->id_pengguna ? 'selected' : '' }}>
                                        {{ $p->nama_pengguna }} - {{ $p->nomor_identitas }} ({{ $p->jenis_pengguna }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_pengguna')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> 
                                Pilih pemilik kendaraan dari data pengguna yang sudah terdaftar
                            </div>
                        </div>
                        
                        <!-- Plat Nomor -->
                        <div class="mb-3">
                            <label for="plat_nomor" class="form-label fw-semibold">
                                Plat Nomor <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-control text-uppercase @error('plat_nomor') is-invalid @enderror" 
                                id="plat_nomor" 
                                name="plat_nomor" 
                                value="{{ old('plat_nomor') }}"
                                placeholder="Contoh: B 1234 ABC"
                                required
                                autofocus
                            >
                            @error('plat_nomor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> 
                                Format: Kode Area + Nomor + Seri (contoh: B 1234 TUJ)
                            </div>
                        </div>
                        
                        <!-- Jenis Kendaraan -->
                        <div class="mb-3">
                            <label for="jenis_kendaraan" class="form-label fw-semibold">
                                Jenis Kendaraan <span class="text-danger">*</span>
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline p-3 border rounded w-100">
                                        <input 
                                            class="form-check-input" 
                                            type="radio" 
                                            name="jenis_kendaraan" 
                                            id="motor" 
                                            value="Motor"
                                            {{ old('jenis_kendaraan') == 'Motor' ? 'checked' : '' }}
                                            required
                                        >
                                        <label class="form-check-label w-100" for="motor">
                                            <i class="fa-solid fa-motorcycle text-danger fs-3 d-block mb-2"></i>
                                            <strong>Motor</strong>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline p-3 border rounded w-100">
                                        <input 
                                            class="form-check-input" 
                                            type="radio" 
                                            name="jenis_kendaraan" 
                                            id="mobil" 
                                            value="Mobil"
                                            {{ old('jenis_kendaraan') == 'Mobil' ? 'checked' : '' }}
                                            required
                                        >
                                        <label class="form-check-label w-100" for="mobil">
                                            <i class="bi bi-car-front text-info fs-3 d-block mb-2"></i>
                                            <strong>Mobil</strong>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('jenis_kendaraan')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Merek Kendaraan -->
                        <div class="mb-4">
                            <label for="merek" class="form-label fw-semibold">
                                Merek Kendaraan <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('merek') is-invalid @enderror" 
                                id="merek" 
                                name="merek" 
                                value="{{ old('merek') }}"
                                placeholder="Contoh: Vario, Beat, Avanza, Xenia, Brio, dll."
                                required
                            >
                            @error('merek')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> 
                                Masukkan merek kendaraan
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <!-- Tombol Aksi -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('kendaraan.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Data
                            </button>
                        </div>
                        
                    </form>
                </div>
            </div>
            
            <!-- Info Box -->
            <div class="alert alert-info mt-3">
                <i class="bi bi-lightbulb"></i>
                <strong>Catatan:</strong>
                <ul class="mb-0 mt-2">
                    <li>Field yang bertanda <span class="text-danger">*</span> wajib diisi</li>
                    <li>Plat nomor harus unik (tidak boleh duplikat)</li>
                    <li>Pastikan pemilik kendaraan sudah terdaftar di data pengguna</li>
                    <li>Data yang disimpan akan dicatat dalam log aktivitas admin</li>
                </ul>
            </div>
            
        </div>
    </div>
    
</div>

@push('scripts')
<script>
    // Auto uppercase untuk plat nomor
    document.getElementById('plat_nomor').addEventListener('input', function(e) {
        this.value = this.value.toUpperCase();
    });
    
    // Capitalize first letter untuk merek
    document.getElementById('merek').addEventListener('input', function(e) {
        let value = this.value;
        this.value = value.charAt(0).toUpperCase() + value.slice(1);
    });
</script>
@endpush

@endsection