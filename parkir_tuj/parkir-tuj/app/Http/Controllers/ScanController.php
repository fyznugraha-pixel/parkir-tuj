<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class ScanController extends Controller
{
    /**
     * Menampilkan halaman scan barcode untuk MASUK & KELUAR
     */
    public function index()
    {
        return view('scan.index');
    }
    
    /**
     * Process scan result - OTOMATIS deteksi MASUK atau KELUAR (AJAX endpoint)
     */
    public function process(Request $request)
    {
        // Validasi input
        $request->validate([
            'kartu_id' => 'required|string',
        ]);
        
        $kartuId = $request->input('kartu_id');
        
        // Cari pengguna berdasarkan kartu ID
        $pengguna = DB::table('pengguna')
            ->where('kartu_id', $kartuId)
            ->first();
        
        if (!$pengguna) {
            return response()->json([
                'success' => false,
                'message' => 'Kartu ID tidak terdaftar dalam sistem'
            ], 404);
        }
        
        // Cari kendaraan milik pengguna
        $kendaraan = DB::table('kendaraan')
            ->where('id_pengguna', $pengguna->id_pengguna)
            ->first();
        
        if (!$kendaraan) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna ' . $pengguna->nama_pengguna . ' belum memiliki kendaraan terdaftar'
            ], 404);
        }
        
        // ========== CEK STATUS: MASUK atau KELUAR ==========
        // Cek apakah kendaraan SEDANG PARKIR (status Masuk dan belum keluar)
        $sedangParkir = DB::table('akses_parkir')
            ->where('id_kendaraan', $kendaraan->id_kendaraan)
            ->where('status', 'Masuk')
            ->whereNull('waktu_keluar')
            ->first();
        
        if ($sedangParkir) {
            // ===== SCENARIO: KELUAR =====
            // Jika kendaraan SEDANG PARKIR, berarti scan ini untuk KELUAR
            
            DB::table('akses_parkir')
                ->where('id_akses', $sedangParkir->id_akses)
                ->update([
                    'waktu_keluar' => now(),
                    'status' => 'Keluar'
                ]);
            
            // Hitung durasi parkir
            $masuk = Carbon::parse($sedangParkir->waktu_masuk);
            $keluar = Carbon::now();
            $durasi = $masuk->diff($keluar);
            $durasiText = $durasi->h . ' jam ' . $durasi->i . ' menit';
            
            // Log aktivitas
            $this->catatLog('Kendaraan keluar: ' . $kendaraan->plat_nomor . ' (' . $pengguna->nama_pengguna . ') - Durasi: ' . $durasiText);
            
            return response()->json([
                'success' => true,
                'action' => 'keluar',
                'message' => 'Kendaraan ' . $kendaraan->plat_nomor . ' berhasil keluar!',
                'data' => [
                    'nama' => $pengguna->nama_pengguna,
                    'plat_nomor' => $kendaraan->plat_nomor,
                    'durasi' => $durasiText,
                    'waktu_keluar' => $keluar->format('d/m/Y H:i:s')
                ]
            ]);
            
        } else {
            // ===== SCENARIO: MASUK =====
            // Jika kendaraan TIDAK SEDANG PARKIR, berarti scan ini untuk MASUK
            
            DB::table('akses_parkir')->insert([
                'id_kendaraan' => $kendaraan->id_kendaraan,
                'waktu_masuk' => now(),
                'waktu_keluar' => null,
                'status' => 'Masuk'
            ]);
            
            // Log aktivitas
            $this->catatLog('Kendaraan masuk: ' . $kendaraan->plat_nomor . ' (' . $pengguna->nama_pengguna . ')');
            
            return response()->json([
                'success' => true,
                'action' => 'masuk',
                'message' => 'Selamat datang, ' . $pengguna->nama_pengguna . '!',
                'data' => [
                    'nama' => $pengguna->nama_pengguna,
                    'plat_nomor' => $kendaraan->plat_nomor,
                    'jenis_kendaraan' => $kendaraan->jenis_kendaraan,
                    'waktu_masuk' => now()->format('d/m/Y H:i:s')
                ]
            ]);
        }
    }
    
    /**
     * Helper function untuk mencatat log aktivitas
     */
    private function catatLog($aktivitas)
    {
        DB::table('log_aktivitas')->insert([
            'id_admin' => Session::get('admin_id'),
            'aktivitas' => $aktivitas,
            'waktu' => now(),
        ]);
    }
}