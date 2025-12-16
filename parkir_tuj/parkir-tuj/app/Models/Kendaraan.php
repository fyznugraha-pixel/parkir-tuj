<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $table = 'kendaraan';
    protected $primaryKey = 'id_kendaraan';
    public $timestamps = false;
    
    protected $fillable = [
        'id_pengguna',
        'plat_nomor',
        'jenis_kendaraan',
        'merek',
    ];
    
    // Relasi: Kendaraan dimiliki oleh satu pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
    
    // Relasi: Kendaraan memiliki banyak akses parkir
    public function aksesParkir()
    {
        return $this->hasMany(AksesParkir::class, 'id_kendaraan', 'id_kendaraan');
    }
}