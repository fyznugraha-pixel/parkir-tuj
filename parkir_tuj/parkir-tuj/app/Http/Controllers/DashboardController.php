<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan statistik
     */
    public function index()
    {
        // Total Pengguna (Mahasiswa + Dosen)
        $totalPengguna = DB::table('pengguna')->count();
        
        // Total Kendaraan Terdaftar
        $totalKendaraan = DB::table('kendaraan')->count();
        
        // Kendaraan Parkir Hari Ini (sudah masuk hari ini)
        $parkirHariIni = DB::table('akses_parkir')
            ->whereDate('waktu_masuk', Carbon::today())
            ->count();
        
        // Kendaraan yang Sedang Parkir (status Masuk dan waktu_keluar NULL)
        $sedangParkir = DB::table('akses_parkir')
            ->where('status', 'Masuk')
            ->whereNull('waktu_keluar')
            ->count();
        
        // Total Motor
        $totalMotor = DB::table('kendaraan')
            ->where('jenis_kendaraan', 'Motor')
            ->count();
        
        // Total Mobil
        $totalMobil = DB::table('kendaraan')
            ->where('jenis_kendaraan', 'Mobil')
            ->count();
        
        // Motor yang Sedang Parkir
        $motorParkir = DB::table('akses_parkir')
            ->join('kendaraan', 'akses_parkir.id_kendaraan', '=', 'kendaraan.id_kendaraan')
            ->where('akses_parkir.status', 'Masuk')
            ->whereNull('akses_parkir.waktu_keluar')
            ->where('kendaraan.jenis_kendaraan', 'Motor')
            ->count();
        
        // Mobil yang Sedang Parkir
        $mobilParkir = DB::table('akses_parkir')
            ->join('kendaraan', 'akses_parkir.id_kendaraan', '=', 'kendaraan.id_kendaraan')
            ->where('akses_parkir.status', 'Masuk')
            ->whereNull('akses_parkir.waktu_keluar')
            ->where('kendaraan.jenis_kendaraan', 'Mobil')
            ->count();
        
        // ========== TAMBAHAN: Slot Parkir ==========
        // Jika Anda punya tabel 'slot_parkir' atau konfigurasi slot
        // Sesuaikan query dengan struktur database Anda
        
        // Opsi 1: Jika ada tabel slot_parkir
        // $totalSlot = DB::table('slot_parkir')->count();
        
        // Opsi 2: Jika slot didefinisikan di tabel konfigurasi
        // $totalSlot = DB::table('konfigurasi')->value('total_slot') ?? 100;
        
        // Opsi 3: Hardcode sementara (ganti dengan query database yang sesuai)
        $totalSlot = 100; // Total kapasitas parkir
        
        // Slot yang sedang terisi = kendaraan yang sedang parkir
        $slotTerisi = $sedangParkir;
        
        // Slot yang masih kosong
        $slotKosong = $totalSlot - $slotTerisi;
        
        // Pastikan slot kosong tidak negatif
        if ($slotKosong < 0) {
            $slotKosong = 0;
        }
        
        // Daftar Kendaraan yang Sedang Parkir (dengan relasi)
        $kendaraanParkir = DB::table('akses_parkir')
            ->join('kendaraan', 'akses_parkir.id_kendaraan', '=', 'kendaraan.id_kendaraan')
            ->join('pengguna', 'kendaraan.id_pengguna', '=', 'pengguna.id_pengguna')
            ->select(
                'akses_parkir.*',
                'kendaraan.plat_nomor',
                'kendaraan.jenis_kendaraan',
                'pengguna.nama_pengguna',
                'pengguna.jenis_pengguna'
            )
            ->where('akses_parkir.status', 'Masuk')
            ->whereNull('akses_parkir.waktu_keluar')
            ->orderBy('akses_parkir.waktu_masuk', 'desc')
            ->limit(10)
            ->get();
        
        // Log Aktivitas Terbaru (5 terakhir)
        $logTerbaru = DB::table('log_aktivitas')
            ->join('admin', 'log_aktivitas.id_admin', '=', 'admin.id_admin')
            ->select('log_aktivitas.*', 'admin.nama_admin')
            ->orderBy('log_aktivitas.waktu', 'desc')
            ->limit(5)
            ->get();
        
        return view('dashboard.index', compact(
            'totalPengguna',
            'totalKendaraan',
            'parkirHariIni',
            'sedangParkir',
            'totalMotor',
            'totalMobil',
            'motorParkir',
            'mobilParkir',
            'kendaraanParkir',
            'logTerbaru',
            // Tambahkan variabel slot parkir
            'totalSlot',
            'slotTerisi',
            'slotKosong'
        ));
    }
}