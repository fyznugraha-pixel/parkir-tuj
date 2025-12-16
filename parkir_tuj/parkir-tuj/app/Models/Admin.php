<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Admin
 */
class Admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    public $timestamps = false;
    
    protected $fillable = [
        'username',
        'password',
        'nama_admin',
    ];
    
    protected $hidden = [
        'password',
    ];
    
    // Relasi: Admin memiliki banyak log aktivitas
    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class, 'id_admin', 'id_admin');
    }
}