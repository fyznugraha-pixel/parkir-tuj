@extends('layouts.app')

@section('title', 'Scan Barcode - Masuk & Keluar')
@section('page-title', 'Scan QR code')

@push('styles')
<style>
    .scan-header h4 {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a1a;
    }
    
    .badge-mode {
        display: inline-block;
        padding: 4px 12px;
        background: linear-gradient(135deg, #22c55e 0%, #f59e0b 100%);
        color: white;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        margin-left: 8px;
    }
    
    .btn-close-scan {
        padding: 12px 24px;
        background: white;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        color: #6c757d;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-close-scan:hover {
        border-color: #E31E24;
        color: #E31E24;
        background: #fff5f5;
    }
    
    .scanner-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }
    
    .scanner-header {
        padding: 20px 24px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .scanner-status {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        color: #6c757d;
    }
    
    .status-indicator {
        width: 12px;
        height: 12px;
        background: #9ca3af;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }
    
    .status-indicator.active {
        background: #22c55e;
    }
    
    .status-indicator.scanning {
        background: #E31E24;
        animation: blink 1s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }
    
    .btn-switch-camera {
        padding: 8px 16px;
        background: white;
        border: 1.5px solid #e5e7eb;
        border-radius: 6px;
        color: #6c757d;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-switch-camera:hover {
        border-color: #E31E24;
        color: #E31E24;
    }
    
    .scanner-container {
        position: relative;
        background: #000;
        min-height: 600px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    #reader {
        width: 100%;
        min-height: 600px;
        border: none;
    }
    
    #reader video {
        border-radius: 0;
        width: 100% !important;
        height: auto !important;
        max-width: 100%;
        object-fit: cover;
    }
    
    #reader__scan_region {
        border: none !important;
    }
    
    #reader__dashboard_section {
        display: none !important;
    }
    
    .scanner-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        pointer-events: none;
        z-index: 10;
    }
    
    .scan-region {
        width: 400px;
        height: 400px;
        position: relative;
        border: 2px solid rgba(227, 30, 36, 0.5);
        border-radius: 16px;
    }
    
    .corner {
        position: absolute;
        width: 32px;
        height: 32px;
        border: 4px solid #E31E24;
    }
    
    .corner.top-left {
        top: -2px;
        left: -2px;
        border-right: none;
        border-bottom: none;
        border-radius: 12px 0 0 0;
    }
    
    .corner.top-right {
        top: -2px;
        right: -2px;
        border-left: none;
        border-bottom: none;
        border-radius: 0 12px 0 0;
    }
    
    .corner.bottom-left {
        bottom: -2px;
        left: -2px;
        border-right: none;
        border-top: none;
        border-radius: 0 0 0 12px;
    }
    
    .corner.bottom-right {
        bottom: -2px;
        right: -2px;
        border-left: none;
        border-top: none;
        border-radius: 0 0 12px 0;
    }
    
    .scan-region::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, transparent, #E31E24, transparent);
        box-shadow: 0 0 10px #E31E24;
        animation: scanLine 2s ease-in-out infinite;
    }
    
    @keyframes scanLine {
        0% { transform: translateY(0); opacity: 0; }
        50% { opacity: 1; }
        100% { transform: translateY(400px); opacity: 0; }
    }
    
    .scan-instruction {
        margin-top: 32px;
        color: white;
        font-size: 15px;
        font-weight: 600;
        background: rgba(0,0,0,0.7);
        padding: 10px 20px;
        border-radius: 24px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }
    
    .scanner-controls {
        padding: 20px 24px;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
        display: flex;
        gap: 12px;
        justify-content: center;
    }
    
    .btn-control {
        padding: 12px 32px;
        background: #E31E24;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-control:hover {
        background: #b71c21;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(227, 30, 36, 0.3);
    }
    
    .manual-input-section {
        padding: 24px;
        background: white;
    }
    
    .divider {
        text-align: center;
        position: relative;
        margin-bottom: 24px;
    }
    
    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #e5e7eb;
    }
    
    .divider span {
        position: relative;
        background: white;
        padding: 0 16px;
        color: #9ca3af;
        font-size: 13px;
        font-weight: 600;
    }
    
    .input-group-custom {
        position: relative;
    }
    
    .input-group-custom label {
        display: block;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 8px;
        font-size: 14px;
    }
    
    .input-group-custom .form-control {
        width: 100%;
        padding: 12px 100px 12px 16px;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
    }
    
    .input-group-custom .form-control:focus {
        outline: none;
        border-color: #E31E24;
        box-shadow: 0 0 0 4px rgba(227, 30, 36, 0.08);
    }
    
    .btn-submit-manual {
        position: absolute;
        right: 4px;
        bottom: 4px;
        padding: 8px 16px;
        background: #E31E24;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-submit-manual:hover {
        background: #b71c21;
    }
    
    .result-card,
    .history-card,
    .instruction-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 20px;
        margin-bottom: 16px;
    }
    
    .result-card h5,
    .history-card h5,
    .instruction-card h5 {
        font-size: 16px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .empty-result {
        text-align: center;
        padding: 32px;
        color: #9ca3af;
    }
    
    .empty-result i {
        font-size: 48px;
        margin-bottom: 12px;
        opacity: 0.5;
    }
    
    .result-success {
        padding: 16px;
        border-radius: 8px;
        animation: slideIn 0.3s ease;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .result-id {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    
    .result-info {
        font-size: 13px;
        color: #6c757d;
    }
    
    .history-item {
        padding: 12px;
        background: #f9fafb;
        border-radius: 8px;
        margin-bottom: 8px;
        font-size: 13px;
    }
    
    .history-id {
        font-weight: 600;
        color: #1a1a1a;
    }
    
    .history-time {
        color: #9ca3af;
        font-size: 12px;
    }
    
    .instruction-list {
        padding-left: 20px;
        margin: 0;
    }
    
    .instruction-list li {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 8px;
        line-height: 1.5;
    }
    
    .instruction-list li strong {
        color: #E31E24;
    }
    
    @media (max-width: 768px) {
        .scan-region {
            width: 300px;
            height: 300px;
        }
        
        @keyframes scanLine {
            0% { transform: translateY(0); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateY(300px); opacity: 0; }
        }
        
        .scanner-container {
            min-height: 500px;
        }
        
        #reader {
            min-height: 500px;
        }
    }
    
    @media (max-width: 576px) {
        .scan-region {
            width: 250px;
            height: 250px;
        }
        
        @keyframes scanLine {
            0% { transform: translateY(0); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateY(250px); opacity: 0; }
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    
    <div class="scan-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">
                    Scan QR Code KTM/Kartu Pegawai  
                    <span class="badge-mode">MASUK & KELUAR</span>
                </h4>
                <p class="text-muted mb-0">Scan otomatis mendeteksi masuk atau keluar parkir</p>
            </div>
            <button type="button" class="btn-close-scan" onclick="stopScanning()">
                <i class="bi bi-x-lg"></i> Tutup Scanner
            </button>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="scanner-card">
                <div class="scanner-header">
                    <div class="scanner-status" id="scannerStatus">
                        <span class="status-indicator"></span>
                        <span id="statusText">Mempersiapkan kamera...</span>
                    </div>
                    <button type="button" class="btn-switch-camera" id="switchCamera" style="display: none;">
                        <i class="bi bi-camera-reels"></i> Ganti Kamera
                    </button>
                </div>
                
                <div class="scanner-container">
                    <div id="reader"></div>
                    
                    <div class="scanner-overlay">
                        <div class="scan-region">
                            <div class="corner top-left"></div>
                            <div class="corner top-right"></div>
                            <div class="corner bottom-left"></div>
                            <div class="corner bottom-right"></div>
                        </div>
                        <p class="scan-instruction">Posisikan QR code di dalam area scan</p>
                    </div>
                </div>
                
                <div class="scanner-controls">
                    <button type="button" class="btn-control" id="startButton" onclick="startScanning()">
                        <i class="bi bi-play-fill"></i> Mulai Scan
                    </button>
                    <button type="button" class="btn-control" id="stopButton" onclick="pauseScanning()" style="display: none;">
                        <i class="bi bi-pause-fill"></i> Jeda
                    </button>
                </div>
                
                <div class="manual-input-section">
                    <div class="divider">
                        <span>ATAU</span>
                    </div>
                    <form id="manualForm">
                        @csrf
                        <div class="input-group-custom">
                            <label for="kartu_id_manual">Input Manual Kartu ID (Masuk/Keluar)</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="kartu_id_manual" 
                                name="kartu_id" 
                                placeholder="Ketik nomor kartu ID secara manual..."
                            >
                            <button type="submit" class="btn-submit-manual">
                                <i class="bi bi-send"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="result-card">
                <h5><i class="bi bi-check-circle"></i> Hasil Scan</h5>
                <div id="scanResult" class="result-content">
                    <div class="empty-result">
                        <i class="bi bi-qr-code-scan"></i>
                        <p>Belum ada hasil scan</p>
                    </div>
                </div>
            </div>
            
            <div class="history-card">
                <h5><i class="bi bi-clock-history"></i> Riwayat Scan</h5>
                <div id="scanHistory" class="history-content">
                    <p class="text-muted text-center">Belum ada riwayat scan</p>
                </div>
            </div>
            
            <div class="instruction-card">
                <h5><i class="bi bi-info-circle"></i> Cara Menggunakan</h5>
                <ol class="instruction-list">
                    <li>Klik tombol "Mulai Scan"</li>
                    <li>Izinkan akses kamera pada browser</li>
                    <li>Dekatkan QR code ke kamera</li>
                    <li><strong>Scan pertama kali = MASUK parkir</strong></li>
                    <li><strong>Scan kedua kali = KELUAR parkir</strong></li>
                    <li>Sistem otomatis mendeteksi status kendaraan</li>
                </ol>
            </div>
        </div>
    </div>
    
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
    let html5QrcodeScanner = null;
    let isScanning = false;
    let cameras = [];
    let currentCameraIndex = 0;
    let scanHistory = [];
    let lastScanTime = 0;
    let scanCooldown = 5000; // 5 detik cooldown antara scan
    
    document.addEventListener('DOMContentLoaded', function() {
        initializeScanner();
        
        // Handle manual form submit
        document.getElementById('manualForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const kartuId = document.getElementById('kartu_id_manual').value.trim();
            if (kartuId) {
                submitScanResult(kartuId);
                document.getElementById('kartu_id_manual').value = '';
            }
        });
    });
    
    function initializeScanner() {
        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                cameras = devices;
                console.log(`Found ${cameras.length} camera(s)`);
                
                if (cameras.length > 1) {
                    document.getElementById('switchCamera').style.display = 'block';
                }
                
                updateStatus('Kamera siap. Klik "Mulai Scan" untuk memulai', false);
            } else {
                updateStatus('Tidak ada kamera ditemukan', false);
                alert('Tidak ada kamera yang terdeteksi. Pastikan kamera Anda terhubung dan izinkan akses kamera.');
            }
        }).catch(err => {
            console.error('Error getting cameras:', err);
            updateStatus('Error: ' + err, false);
        });
    }
    
    function startScanning() {
        if (isScanning) return;
        
        const cameraId = cameras.length > 0 
            ? cameras[currentCameraIndex].id 
            : { facingMode: "environment" };
        
        html5QrcodeScanner = new Html5Qrcode("reader");
        
        const config = {
            fps: 30,
            qrbox: { width: 400, height: 400 },
            aspectRatio: 1.777778,
            disableFlip: false,
            videoConstraints: {
                facingMode: "environment",
                advanced: [
                    { width: { min: 1280, ideal: 1920, max: 3840 } },
                    { height: { min: 720, ideal: 1080, max: 2160 } },
                    { aspectRatio: 1.777778 },
                    { focusMode: "continuous" },
                ]
            }
        };

        html5QrcodeScanner.start(
            cameraId,
            config,
            (decodedText, decodedResult) => onScanSuccess(decodedText, decodedResult),
            (errorMessage) => {}
        ).then(() => {
            isScanning = true;
            updateStatus('Scanning... Dekatkan barcode ke kamera', true);
            document.getElementById('startButton').style.display = 'none';
            document.getElementById('stopButton').style.display = 'inline-flex';
        }).catch(err => {
            console.error('Error starting scanner:', err);
            alert('Gagal memulai scanner: ' + err);
            updateStatus('Error: ' + err, false);
        });
    }
    
    function pauseScanning() {
        if (!isScanning) return;
        
        html5QrcodeScanner.stop().then(() => {
            isScanning = false;
            html5QrcodeScanner = null;
            updateStatus('Scanner dijeda', false);
            document.getElementById('startButton').style.display = 'inline-flex';
            document.getElementById('stopButton').style.display = 'none';
        }).catch(err => {
            console.error('Error stopping scanner:', err);
        });
    }
    
    function stopScanning() {
        if (isScanning && html5QrcodeScanner) {
            html5QrcodeScanner.stop().then(() => {
                window.location.href = '{{ route("akses-parkir.index") }}';
            }).catch(err => {
                console.error('Error stopping scanner:', err);
                window.location.href = '{{ route("akses-parkir.index") }}';
            });
        } else {
            window.location.href = '{{ route("akses-parkir.index") }}';
        }
    }
    
    function switchCamera() {
        if (cameras.length <= 1) return;
        
        currentCameraIndex = (currentCameraIndex + 1) % cameras.length;
        
        if (isScanning) {
            pauseScanning();
            setTimeout(() => {
                startScanning();
            }, 500);
        }
    }
    
    document.getElementById('switchCamera')?.addEventListener('click', switchCamera);
    
    function onScanSuccess(decodedText, decodedResult) {
        // Cek cooldown - cegah scan berulang terlalu cepat
        const currentTime = Date.now();
        const timeSinceLastScan = currentTime - lastScanTime;
        
        if (timeSinceLastScan < scanCooldown) {
            console.log(`Scan terlalu cepat. Tunggu ${Math.ceil((scanCooldown - timeSinceLastScan) / 1000)} detik lagi.`);
            return; // Abaikan scan jika masih dalam cooldown
        }
        
        lastScanTime = currentTime;
        console.log('Scan result:', decodedText);
        
        // Pause scanner immediately untuk cegah scan ganda
        if (isScanning) {
            html5QrcodeScanner.pause(true);
        }
        
        try {
            const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBjWMzPLTgjMGHm7A7+OZSA8PVqzn77BdGAg+ltryxnMpBSh+zPDajj0HGGm98OScTRANUKXh8bllHAU2jdXyzn0vBSh+zPDajj0HGGm98OScTRANUKXh8bllHAU2jdXyzn0vBSh+zPDajj0HGGm98OScTRANUKXh8bllHAU2jdXyzn0vBSh+zPDajj0HGGm98OScTRANUKXh8bllHAU2jdXyzn0vBQ==');
            audio.play().catch(() => {});
        } catch(e) {}
        
        addToHistory(decodedText);
        displayResult(decodedText);
        submitScanResult(decodedText);
        
        // Stop scanner setelah berhasil scan
        setTimeout(() => {
            pauseScanning();
        }, 1500);
    }
    
    function displayResult(kartuId) {
        const resultDiv = document.getElementById('scanResult');
        
        resultDiv.innerHTML = `
            <div class="result-success" style="background: #f0f9ff; border: 1px solid #0284c7;">
                <div class="result-id" style="color: #075985;">
                    <i class="bi bi-hourglass-split text-info"></i>
                    ${kartuId}
                </div>
                <div class="result-info">
                    Kartu ID berhasil terdeteksi. Memproses data...
                </div>
            </div>
        `;
    }
    
    function addToHistory(kartuId) {
        const now = new Date();
        const timeStr = now.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit' 
        });
        
        scanHistory.unshift({
            id: kartuId,
            time: timeStr
        });
        
        if (scanHistory.length > 5) {
            scanHistory.pop();
        }
        
        updateHistoryDisplay();
    }
    
    function updateHistoryDisplay() {
        const historyDiv = document.getElementById('scanHistory');
        
        if (scanHistory.length === 0) {
            historyDiv.innerHTML = '<p class="text-muted text-center">Belum ada riwayat scan</p>';
            return;
        }
        
        let html = '';
        scanHistory.forEach(item => {
            html += `
                <div class="history-item">
                    <div class="history-id">${item.id}</div>
                    <div class="history-time">${item.time}</div>
                </div>
            `;
        });
        
        historyDiv.innerHTML = html;
    }
    
    function submitScanResult(kartuId) {
        const formData = new FormData();
        formData.append('kartu_id', kartuId);
        formData.append('_token', '{{ csrf_token() }}');
        
        // Gunakan route scan.process yang otomatis deteksi masuk/keluar
        fetch('{{ route("scan.process") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Tampilkan pesan berbeda untuk MASUK vs KELUAR
                if (data.action === 'masuk') {
                    displaySuccessResult(data, 'masuk');
                    alert('BERHASIL MASUK!\n\n' + 
                          'Selamat datang, ' + data.data.nama + '!\n' +
                          'Kendaraan: ' + data.data.plat_nomor + '\n' +
                          'Jenis: ' + data.data.jenis_kendaraan + '\n' +
                          'Waktu: ' + data.data.waktu_masuk);
                } else if (data.action === 'keluar') {
                    displaySuccessResult(data, 'keluar');
                    alert('BERHASIL KELUAR!\n\n' + 
                          'Terima kasih, ' + data.data.nama + '!\n' +
                          'Kendaraan: ' + data.data.plat_nomor + '\n' +
                          'Durasi Parkir: ' + data.data.durasi + '\n' +
                          'Waktu Keluar: ' + data.data.waktu_keluar);
                }
                
                setTimeout(() => {
                    window.location.href = '{{ route("akses-parkir.index") }}';
                }, 3000);
            } else {
                alert('❌ Error: ' + (data.message || 'Gagal memproses data'));
                // Resume scanning jika error
                setTimeout(() => {
                    startScanning();
                }, 1000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Terjadi kesalahan saat mengirim data');
            // Resume scanning jika error
            setTimeout(() => {
                startScanning();
            }, 1000);
        });
    }
    
    function displaySuccessResult(data, action) {
        const resultDiv = document.getElementById('scanResult');
        
        if (action === 'masuk') {
            resultDiv.innerHTML = `
                <div class="result-success" style="background: #f0fdf4; border: 1px solid #22c55e;">
                    <div class="result-id" style="color: #166534;">
                        <i class="bi bi-box-arrow-in-right text-success"></i>
                        KENDARAAN MASUK
                    </div>
                    <div class="result-info">
                        <strong>${data.data.nama}</strong><br>
                        ${data.data.plat_nomor} - ${data.data.jenis_kendaraan}<br>
                        <small>Masuk: ${data.data.waktu_masuk}</small>
                    </div>
                </div>
            `;
        } else if (action === 'keluar') {
            resultDiv.innerHTML = `
                <div class="result-success" style="background: #fffbeb; border: 1px solid #f59e0b;">
                    <div class="result-id" style="color: #92400e;">
                        <i class="bi bi-box-arrow-right text-warning"></i>
                        KENDARAAN KELUAR
                    </div>
                    <div class="result-info">
                        <strong>${data.data.nama}</strong><br>
                        ${data.data.plat_nomor}<br>
                        <small>Durasi: ${data.data.durasi}</small><br>
                        <small>Keluar: ${data.data.waktu_keluar}</small>
                    </div>
                </div>
            `;
        }
    }
    
    function updateStatus(message, scanning) {
        const statusText = document.getElementById('statusText');
        const indicator = document.querySelector('.status-indicator');
        
        statusText.textContent = message;
        
        if (scanning) {
            indicator.classList.add('scanning');
            indicator.classList.remove('active');
        } else {
            indicator.classList.remove('scanning');
            indicator.classList.add('active');
        }
    }
    
    window.addEventListener('beforeunload', (e) => {
        if (isScanning) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
</script>
@endpush