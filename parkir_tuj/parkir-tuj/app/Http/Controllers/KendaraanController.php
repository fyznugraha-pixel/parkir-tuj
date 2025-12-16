<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kendaraan;
use App\Models\Pengguna;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kendaraan = Kendaraan::with('pengguna')->orderBy('id_kendaraan', 'desc')->get();
        return view('kendaraan.index', compact('kendaraan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pengguna = Pengguna::orderBy('nama_pengguna', 'asc')->get();
        return view('kendaraan.create', compact('pengguna'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'id_pengguna' => 'required|exists:pengguna,id_pengguna',
            'plat_nomor' => 'required|string|max:20|unique:kendaraan,plat_nomor',
            'jenis_kendaraan' => 'required|in:Motor,Mobil',
            'merek' => 'required|string|max:50',
        ], [
            'id_pengguna.required' => 'Pemilik kendaraan wajib dipilih',
            'id_pengguna.exists' => 'Pemilik kendaraan tidak valid',
            'plat_nomor.required' => 'Plat nomor wajib diisi',
            'plat_nomor.unique' => 'Plat nomor sudah terdaftar',
            'jenis_kendaraan.required' => 'Jenis kendaraan wajib dipilih',
            'merek.required' => 'Merek kendaraan wajib diisi',
        ]);

        // Simpan data
        Kendaraan::create($validated);

        // Catat log aktivitas
        $pemilik = Pengguna::find($request->id_pengguna);
        $this->catatLog('Menambahkan kendaraan baru: ' . $request->plat_nomor . ' milik ' . $pemilik->nama_pengguna);

        return redirect()->route('kendaraan.index')
            ->with('success', 'Data kendaraan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kendaraan = Kendaraan::with('pengguna', 'aksesParkir')->findOrFail($id);
        return view('kendaraan.show', compact('kendaraan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        $pengguna = Pengguna::orderBy('nama_pengguna', 'asc')->get();
        return view('kendaraan.edit', compact('kendaraan', 'pengguna'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'id_pengguna' => 'required|exists:pengguna,id_pengguna',
            'plat_nomor' => 'required|string|max:20|unique:kendaraan,plat_nomor,' . $id . ',id_kendaraan',
            'jenis_kendaraan' => 'required|in:Motor,Mobil',
            'merek' => 'required|string|max:50',
        ], [
            'id_pengguna.required' => 'Pemilik kendaraan wajib dipilih',
            'id_pengguna.exists' => 'Pemilik kendaraan tidak valid',
            'plat_nomor.required' => 'Plat nomor wajib diisi',
            'plat_nomor.unique' => 'Plat nomor sudah terdaftar',
            'jenis_kendaraan.required' => 'Jenis kendaraan wajib dipilih',
            'merek.required' => 'merek kendaraan wajib diisi',
        ]);

        // Update data
        $kendaraan->update($validated);

        // Catat log aktivitas
        $this->catatLog('Mengupdate data kendaraan: ' . $request->plat_nomor);

        return redirect()->route('kendaraan.index')
            ->with('success', 'Data kendaraan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        $plat = $kendaraan->plat_nomor;

        // Cek apakah kendaraan memiliki riwayat parkir
        if ($kendaraan->aksesParkir()->count() > 0) {
            return redirect()->route('kendaraan.index')
                ->with('error', 'Tidak dapat menghapus kendaraan yang memiliki riwayat akses parkir');
        }

        // Hapus data
        $kendaraan->delete();

        // Catat log aktivitas
        $this->catatLog('Menghapus data kendaraan: ' . $plat);

        return redirect()->route('kendaraan.index')
            ->with('success', 'Data kendaraan berhasil dihapus');
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