<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AksesParkir;
use App\Models\Kendaraan;
use App\Models\Pengguna;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AksesParkirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Kendaraan yang sedang parkir
        $kendaraanParkir = AksesParkir::with(['kendaraan.pengguna'])
            ->where('status', 'Masuk')
            ->whereNull('waktu_keluar')
            ->orderBy('waktu_masuk', 'desc')
            ->get();
        
        // Riwayat transaksi (dengan pagination)
        $riwayat = AksesParkir::with(['kendaraan.pengguna'])
            ->orderBy('waktu_masuk', 'desc')
            ->paginate(20);
        
        // TAMBAHKAN BARIS INI - Preserve tab state saat pagination
        $riwayat->appends(['tab' => 'riwayat']);
        
        // Statistik
        $sedangParkir = AksesParkir::where('status', 'Masuk')
            ->whereNull('waktu_keluar')
            ->count();
        
        $masukHariIni = AksesParkir::whereDate('waktu_masuk', Carbon::today())
            ->count();
        
        $keluarHariIni = AksesParkir::where('status', 'Keluar')
            ->whereDate('waktu_keluar', Carbon::today())
            ->count();
        
        $totalTransaksi = AksesParkir::count();
        
        return view('akses-parkir.index', compact(
            'kendaraanParkir',
            'riwayat',
            'sedangParkir',
            'masukHariIni',
            'keluarHariIni',
            'totalTransaksi'
        ));
    }

    /**
     * Proses kendaraan masuk
     */
    public function masuk(Request $request)
    {
        // Validasi input
        $request->validate([
            'kartu_id' => 'required|string|exists:pengguna,kartu_id',
        ], [
            'kartu_id.required' => 'Kartu ID wajib diisi',
            'kartu_id.exists' => 'Kartu ID tidak terdaftar dalam sistem',
        ]);

        // Cari pengguna berdasarkan kartu ID
        $pengguna = Pengguna::where('kartu_id', $request->kartu_id)->first();

        if (!$pengguna) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kartu ID tidak ditemukan!'
                ], 404);
            }
            return redirect()->route('akses-parkir.index')
                ->with('error', 'Kartu ID tidak ditemukan!');
        }

        // Cari kendaraan milik pengguna
        $kendaraan = Kendaraan::where('id_pengguna', $pengguna->id_pengguna)->first();

        if (!$kendaraan) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengguna ' . $pengguna->nama_pengguna . ' belum memiliki kendaraan terdaftar!'
                ], 404);
            }
            return redirect()->route('akses-parkir.index')
                ->with('error', 'Pengguna ' . $pengguna->nama_pengguna . ' belum memiliki kendaraan terdaftar!');
        }

        // Cek apakah kendaraan sudah parkir
        $sudahParkir = AksesParkir::where('id_kendaraan', $kendaraan->id_kendaraan)
            ->where('status', 'Masuk')
            ->whereNull('waktu_keluar')
            ->exists();

        if ($sudahParkir) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kendaraan ' . $kendaraan->plat_nomor . ' masih tercatat parkir!'
                ], 400);
            }
            return redirect()->route('akses-parkir.index')
                ->with('error', 'Kendaraan ' . $kendaraan->plat_nomor . ' masih tercatat parkir!');
        }

        // Catat kendaraan masuk
        AksesParkir::create([
            'id_kendaraan' => $kendaraan->id_kendaraan,
            'waktu_masuk' => now(),
            'waktu_keluar' => null,
            'status' => 'Masuk',
        ]);

        // Catat log aktivitas
        $this->catatLog('Mencatat kendaraan masuk: ' . $kendaraan->plat_nomor . ' (' . $pengguna->nama_pengguna . ')');

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Selamat datang, ' . $pengguna->nama_pengguna . '!',
                'data' => [
                    'nama' => $pengguna->nama_pengguna,
                    'plat_nomor' => $kendaraan->plat_nomor,
                    'jenis_kendaraan' => $kendaraan->jenis_kendaraan
                ]
            ]);
        }

        return redirect()->route('akses-parkir.index')
            ->with('success', 'Kendaraan ' . $kendaraan->plat_nomor . ' berhasil dicatat masuk!')
            ->with('nama_pengguna', $pengguna->nama_pengguna)
            ->with('scan_success', true);
    }

    /**
     * Proses kendaraan keluar
     */
    public function keluar(string $id)
    {
        $akses = AksesParkir::with('kendaraan.pengguna')->findOrFail($id);

        // Validasi apakah kendaraan sedang parkir
        if ($akses->status != 'Masuk' || $akses->waktu_keluar != null) {
            return redirect()->route('akses-parkir.index')
                ->with('error', 'Kendaraan tidak dalam status parkir!');
        }

        // Update waktu keluar
        $akses->update([
            'waktu_keluar' => now(),
            'status' => 'Keluar',
        ]);

        // Hitung durasi parkir
        $masuk = Carbon::parse($akses->waktu_masuk);
        $keluar = Carbon::now();
        $durasi = $masuk->diff($keluar);
        $durasiText = $durasi->h . ' jam ' . $durasi->i . ' menit';

        // Catat log aktivitas
        $this->catatLog('Mencatat kendaraan keluar: ' . $akses->kendaraan->plat_nomor . ' (Durasi: ' . $durasiText . ')');

        return redirect()->route('akses-parkir.index')
            ->with('success', 'Kendaraan ' . $akses->kendaraan->plat_nomor . ' berhasil keluar! Durasi parkir: ' . $durasiText);
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