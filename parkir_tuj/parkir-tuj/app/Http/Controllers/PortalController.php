<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class PortalController extends Controller
{
    /**
     * Tampilkan halaman login portal mahasiswa
     */
    public function showLogin()
    {
        // Jika sudah login, redirect ke dashboard
        if (Session::has('portal_user_id')) {
            return redirect()->route('portal.dashboard');
        }
        
        return view('portal.login');
    }
    
    /**
     * Proses login portal mahasiswa
     */
    public function login(Request $request)
    {
        $request->validate([
            'kartu_id' => 'required|string',
        ]);
        
        // Cari pengguna berdasarkan kartu_id atau nomor_identitas
        $pengguna = DB::table('pengguna')
            ->where('kartu_id', $request->kartu_id)
            ->orWhere('nomor_identitas', $request->kartu_id)
            ->first();
        
        if (!$pengguna) {
            return back()
                ->withInput()
                ->with('error', 'Kartu ID atau NIM tidak ditemukan!');
        }
        
        // Set session
        Session::put('portal_user_id', $pengguna->id_pengguna);
        Session::put('portal_user_nama', $pengguna->nama_pengguna);
        Session::put('portal_user_jenis', $pengguna->jenis_pengguna);
        
        return redirect()->route('portal.dashboard')
            ->with('success', 'Selamat datang, ' . $pengguna->nama_pengguna);
    }
    
    /**
     * Dashboard portal mahasiswa
     */
    public function dashboard()
    {
        $userId = Session::get('portal_user_id');
        
        if (!$userId) {
            return redirect()->route('portal.login');
        }
        
        // Data pengguna
        $pengguna = DB::table('pengguna')
            ->where('id_pengguna', $userId)
            ->first();
        
        // Ambil kendaraan pengguna
        $kendaraanIds = DB::table('kendaraan')
            ->where('id_pengguna', $userId)
            ->pluck('id_kendaraan');
        
        // Total parkir
        $totalParkir = DB::table('akses_parkir')
            ->whereIn('id_kendaraan', $kendaraanIds)
            ->count();
        
        // Sedang parkir
        $sedangParkir = DB::table('akses_parkir')
            ->whereIn('id_kendaraan', $kendaraanIds)
            ->where('status', 'Masuk')
            ->whereNull('waktu_keluar')
            ->count();
        
        // Parkir bulan ini
        $bulanIni = DB::table('akses_parkir')
            ->whereIn('id_kendaraan', $kendaraanIds)
            ->whereMonth('waktu_masuk', Carbon::now()->month)
            ->whereYear('waktu_masuk', Carbon::now()->year)
            ->count();
        
        // Riwayat parkir (20 terakhir)
        $riwayat = DB::table('akses_parkir')
            ->join('kendaraan', 'akses_parkir.id_kendaraan', '=', 'kendaraan.id_kendaraan')
            ->select(
                'akses_parkir.*',
                'kendaraan.plat_nomor',
                'kendaraan.jenis_kendaraan'
            )
            ->whereIn('akses_parkir.id_kendaraan', $kendaraanIds)
            ->orderBy('akses_parkir.waktu_masuk', 'desc')
            ->limit(20)
            ->get();
        
        // Hitung durasi untuk setiap riwayat
        $riwayat = $riwayat->map(function($item) {
            if ($item->waktu_keluar) {
                $masuk = Carbon::parse($item->waktu_masuk);
                $keluar = Carbon::parse($item->waktu_keluar);
                $diff = $masuk->diff($keluar);
                $item->durasi = $diff->h . ' jam ' . $diff->i . ' menit';
            }
            return $item;
        });
        
        return view('portal.dashboard', compact(
            'pengguna',
            'totalParkir',
            'sedangParkir',
            'bulanIni',
            'riwayat'
        ));
    }
    
    /**
     * Logout dari portal mahasiswa
     */
    public function logout()
    {
        Session::forget('portal_user_id');
        Session::forget('portal_user_nama');
        Session::forget('portal_user_jenis');
        
        return redirect()->route('portal.login')
            ->with('success', 'Anda telah logout');
    }
}