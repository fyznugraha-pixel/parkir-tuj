<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $timestamps = false;
    
    protected $fillable = [
        'nama_pengguna',
        'jenis_pengguna',
        'nomor_identitas',
        'kartu_id',
        'no_hp',
    ];
    
    // Relasi: Pengguna memiliki banyak kendaraan
    public function kendaraan()
    {
        return $this->hasMany(Kendaraan::class, 'id_pengguna', 'id_pengguna');
    }
}
