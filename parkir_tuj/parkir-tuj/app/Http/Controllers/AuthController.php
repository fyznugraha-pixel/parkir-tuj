<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function showLogin()
    {
        // Jika sudah login, redirect ke dashboard
        if (Session::has('admin_id')) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }
    
    /**
     * Proses login admin
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);
        
        $username = $request->input('username');
        $password = md5($request->input('password')); // Sesuai dengan database yang menggunakan MD5
        
        // Cek admin di database
        $admin = DB::table('admin')
            ->where('username', $username)
            ->where('password', $password)
            ->first();
        
        if ($admin) {
            // Set session
            Session::put('admin_id', $admin->id_admin);
            Session::put('admin_username', $admin->username);
            Session::put('admin_nama', $admin->nama_admin);
            
            // Catat log aktivitas login
            $this->catatLog($admin->id_admin, 'Login ke sistem');
            
            // Redirect ke dashboard (bukan home)
            return redirect()->route('dashboard')
                ->with('success', 'Login berhasil! Selamat datang, ' . $admin->nama_admin);
        } else {
            // Login gagal
            return back()
                ->withInput()
                ->with('error', 'Username atau password salah!');
        }
    }
    
    /**
     * Logout admin
     */
    public function logout(Request $request)
    {
        $adminId = Session::get('admin_id');
        
        // Catat log aktivitas logout
        if ($adminId) {
            $this->catatLog($adminId, 'Logout dari sistem');
        }
        
        // Hapus semua session
        Session::flush();
        
        // Redirect ke landing page (bukan login)
        return redirect()->route('welcome')
            ->with('success', 'Anda telah logout. Terima kasih!');
    }
    
    /**
     * Helper function untuk mencatat log aktivitas
     */
    private function catatLog($adminId, $aktivitas)
    {
        DB::table('log_aktivitas')->insert([
            'id_admin' => $adminId,
            'aktivitas' => $aktivitas,
            'waktu' => now(),
        ]);
    }
}