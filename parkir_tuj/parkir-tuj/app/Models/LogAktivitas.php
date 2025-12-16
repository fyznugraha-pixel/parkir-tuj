<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';
    protected $primaryKey = 'id_log';
    public $timestamps = false;
    
    protected $fillable = [
        'id_admin',
        'aktivitas',
        'waktu',
    ];
    
    protected $dates = [
        'waktu',
    ];

    public function export(Request $request)
    {
        // Validasi input (opsional)
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        
        // Query log dengan filter tanggal (jika ada)
        $query = DB::table('log_aktivitas')
            ->join('admin', 'log_aktivitas.id_admin', '=', 'admin.id_admin')
            ->select(
                'log_aktivitas.id_log',
                'log_aktivitas.waktu',
                'admin.nama_admin',
                'admin.username',
                'log_aktivitas.aktivitas'
            )
            ->orderBy('log_aktivitas.waktu', 'desc');
        
        // Filter berdasarkan tanggal jika ada
        if ($request->start_date) {
            $query->whereDate('log_aktivitas.waktu', '>=', $request->start_date);
        }
        
        if ($request->end_date) {
            $query->whereDate('log_aktivitas.waktu', '<=', $request->end_date);
        }
        
        $logs = $query->get();
        
        // Generate nama file dengan timestamp
        $filename = 'log_aktivitas_' . date('Y-m-d_His') . '.csv';
        
        // Headers untuk download CSV
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        // Callback untuk generate CSV
        $callback = function() use ($logs, $request) {
            $file = fopen('php://output', 'w');
            
            // Add BOM untuk support UTF-8 di Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header CSV
            fputcsv($file, [
                'No',
                'Tanggal',
                'Waktu',
                'Nama Admin',
                'Username',
                'Aktivitas',
                'Kategori'
            ]);
            
            // Data CSV
            $no = 1;
            foreach ($logs as $log) {
                // Tentukan kategori
                $kategori = 'Lainnya';
                $aktivitas = strtolower($log->aktivitas);
                
                if (stripos($aktivitas, 'login') !== false) {
                    $kategori = 'Login';
                } elseif (stripos($aktivitas, 'logout') !== false) {
                    $kategori = 'Logout';
                } elseif (stripos($aktivitas, 'tambah') !== false || stripos($aktivitas, 'menambah') !== false) {
                    $kategori = 'Tambah';
                } elseif (stripos($aktivitas, 'update') !== false || stripos($aktivitas, 'edit') !== false || stripos($aktivitas, 'mengupdate') !== false) {
                    $kategori = 'Update';
                } elseif (stripos($aktivitas, 'hapus') !== false) {
                    $kategori = 'Hapus';
                }
                
                fputcsv($file, [
                    $no++,
                    \Carbon\Carbon::parse($log->waktu)->format('d/m/Y'),
                    \Carbon\Carbon::parse($log->waktu)->format('H:i:s'),
                    $log->nama_admin,
                    $log->username,
                    $log->aktivitas,
                    $kategori
                ]);
            }
            
            // Info export
            fputcsv($file, []); // Empty row
            fputcsv($file, ['Export Information']);
            fputcsv($file, ['Total Records', count($logs)]);
            fputcsv($file, ['Export Date', date('d/m/Y H:i:s')]);
            
            if ($request->start_date || $request->end_date) {
                fputcsv($file, ['Date Filter']);
                if ($request->start_date) {
                    fputcsv($file, ['From', \Carbon\Carbon::parse($request->start_date)->format('d/m/Y')]);
                }
                if ($request->end_date) {
                    fputcsv($file, ['To', \Carbon\Carbon::parse($request->end_date)->format('d/m/Y')]);
                }
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    // Relasi: Log aktivitas dimiliki oleh satu admin
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
}
