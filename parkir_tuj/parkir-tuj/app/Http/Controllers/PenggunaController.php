<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengguna = Pengguna::orderBy('created_at', 'desc')->get();
        return view('pengguna.index', compact('pengguna'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengguna.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input - DIPERBAIKI: Tambahkan Staff, Pimpinan, Tamu
        $validated = $request->validate([
            'nama_pengguna' => 'required|string|max:100',
            'jenis_pengguna' => 'required|in:Mahasiswa,Dosen,Staff,Pimpinan,Tamu', // ✅ FIXED
            'nomor_identitas' => 'required|string|max:50|unique:pengguna,nomor_identitas',
            'kartu_id' => 'required|string|max:50|unique:pengguna,kartu_id',
            'no_hp' => 'nullable|string|max:15',
        ], [
            'nama_pengguna.required' => 'Nama wajib diisi',
            'jenis_pengguna.required' => 'Jenis pengguna wajib dipilih',
            'jenis_pengguna.in' => 'Jenis pengguna tidak valid', // ✅ Tambahan pesan error
            'nomor_identitas.required' => 'Nomor identitas wajib diisi',
            'nomor_identitas.unique' => 'Nomor identitas sudah terdaftar',
            'kartu_id.required' => 'Kartu ID wajib diisi',
            'kartu_id.unique' => 'Kartu ID sudah terdaftar',
        ]);

        // Simpan data
        Pengguna::create($validated);

        // Catat log aktivitas
        $this->catatLog('Menambahkan pengguna baru: ' . $request->nama_pengguna);

        return redirect()->route('pengguna.index')
            ->with('success', 'Data pengguna berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengguna = Pengguna::with('kendaraan')->findOrFail($id);
        return view('pengguna.show', compact('pengguna'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengguna = Pengguna::findOrFail($id);
        return view('pengguna.edit', compact('pengguna'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pengguna = Pengguna::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'nama_pengguna' => 'required|string|max:100',
            'jenis_pengguna' => 'required|in:Mahasiswa,Dosen,Pimpinan,Staff,Tamu',
            'nomor_identitas' => 'required|string|max:50|unique:pengguna,nomor_identitas,' . $id . ',id_pengguna',
            'kartu_id' => 'required|string|max:50|unique:pengguna,kartu_id,' . $id . ',id_pengguna',
            'no_hp' => 'nullable|string|max:15',
        ], [
            'nama_pengguna.required' => 'Nama wajib diisi',
            'jenis_pengguna.required' => 'Jenis pengguna wajib dipilih',
            'nomor_identitas.required' => 'Nomor identitas wajib diisi',
            'nomor_identitas.unique' => 'Nomor identitas sudah terdaftar',
            'kartu_id.required' => 'Kartu ID wajib diisi',
            'kartu_id.unique' => 'Kartu ID sudah terdaftar',
        ]);

        // Update data
        $pengguna->update($validated);

        // Catat log aktivitas
        $this->catatLog('Mengupdate data pengguna: ' . $request->nama_pengguna);

        return redirect()->route('pengguna.index')
            ->with('success', 'Data pengguna berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $nama = $pengguna->nama_pengguna;

        // Cek apakah pengguna memiliki kendaraan
        if ($pengguna->kendaraan()->count() > 0) {
            return redirect()->route('pengguna.index')
                ->with('error', 'Tidak dapat menghapus pengguna yang masih memiliki kendaraan terdaftar');
        }

        // Hapus data
        $pengguna->delete();

        // Catat log aktivitas
        $this->catatLog('Menghapus data pengguna: ' . $nama);

        return redirect()->route('pengguna.index')
            ->with('success', 'Data pengguna berhasil dihapus');
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