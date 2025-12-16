<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display the home page
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Total slot parkir (sesuaikan dengan kapasitas real parkir kampus)
        $totalSlot = 100;
        
        // Hitung kendaraan yang sedang parkir (status Masuk dan belum keluar)
        $slotTerisi = DB::table('akses_parkir')
            ->where('status', 'Masuk')
            ->whereNull('waktu_keluar')
            ->count();
        
        // Hitung slot yang masih kosong
        $slotKosong = $totalSlot - $slotTerisi;
        
        // Pastikan slot kosong tidak negatif
        if ($slotKosong < 0) {
            $slotKosong = 0;
        }
        
        return view('home', compact(
            'totalSlot',
            'slotKosong',
            'slotTerisi'
        ));
    }
}