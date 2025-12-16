<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AksesParkir extends Model
{
    protected $table = 'akses_parkir';
    protected $primaryKey = 'id_akses';
    public $timestamps = false;
    
    protected $fillable = [
        'id_kendaraan',
        'waktu_masuk',
        'waktu_keluar',
        'status',
    ];
    
    protected $dates = [
        'waktu_masuk',
        'waktu_keluar',
    ];
    
    // Relasi: Akses parkir dimiliki oleh satu kendaraan
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'id_kendaraan', 'id_kendaraan');
    }
    
    /**
     * Scope untuk kendaraan yang sedang parkir
     */
    public function scopeSedangParkir($query)
    {
        return $query->where('status', 'Masuk')
                     ->whereNull('waktu_keluar');
    }
    
    /**
     * Scope untuk transaksi hari ini
     */
    public function scopeHariIni($query)
    {
        return $query->whereDate('waktu_masuk', today());
    }
}