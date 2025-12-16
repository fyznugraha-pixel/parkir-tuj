<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LogAktivitasController extends Controller
{

    public function index()
    {
        // Ambil semua log dengan pagination
        $logs = LogAktivitas::with('admin')
            ->orderBy('waktu', 'desc')
            ->paginate(50);
        
        // Statistik
        $totalLog = LogAktivitas::count();
        
        $logHariIni = LogAktivitas::whereDate('waktu', Carbon::today())
            ->count();
        
        $logMingguIni = LogAktivitas::whereBetween('waktu', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
            ->count();
        
        // Hitung jumlah admin yang pernah melakukan aktivitas
        $adminAktif = LogAktivitas::distinct('id_admin')->count('id_admin');
        
        return view('log.index', compact(
            'logs',
            'totalLog',
            'logHariIni',
            'logMingguIni',
            'adminAktif'
        ));
    }

    /**
     * Filter log berdasarkan tanggal
     */
    public function filter(Request $request)
    {
        $query = LogAktivitas::with('admin');
        
        // Filter berdasarkan tanggal
        if ($request->has('tanggal_mulai') && $request->tanggal_mulai) {
            $query->whereDate('waktu', '>=', $request->tanggal_mulai);
        }
        
        if ($request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $query->whereDate('waktu', '<=', $request->tanggal_akhir);
        }
        
        // Filter berdasarkan admin
        if ($request->has('id_admin') && $request->id_admin) {
            $query->where('id_admin', $request->id_admin);
        }
        
        $logs = $query->orderBy('waktu', 'desc')->paginate(50);
        
        // Statistik
        $totalLog = LogAktivitas::count();
        $logHariIni = LogAktivitas::whereDate('waktu', Carbon::today())->count();
        $logMingguIni = LogAktivitas::whereBetween('waktu', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count();
        $adminAktif = LogAktivitas::distinct('id_admin')->count('id_admin');
        
        return view('log.index', compact(
            'logs',
            'totalLog',
            'logHariIni',
            'logMingguIni',
            'adminAktif'
        ));
    }

        /**
     * Export log ke Excel
     */
    public function export(Request $request)
    {
        // Get filter parameters
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        // Query logs
        $query = DB::table('log_aktivitas')
            ->join('admin', 'log_aktivitas.id_admin', '=', 'admin.id_admin')
            ->select('log_aktivitas.*', 'admin.nama_admin')
            ->orderBy('log_aktivitas.waktu', 'desc');
        
        // Apply date filters if provided
        if ($startDate) {
            $query->whereDate('log_aktivitas.waktu', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('log_aktivitas.waktu', '<=', $endDate);
        }
        
        $logs = $query->get();
        
        // Generate filename
        $filename = 'log_aktivitas_' . date('YmdHis') . '.xlsx';
        
         // Check if PhpSpreadsheet is installed
        if (!class_exists(\PhpOffice\PhpSpreadsheet\Spreadsheet::class)) {
            return back()->with('error', 'PhpSpreadsheet package tidak terinstall. Install dengan: composer require phpoffice/phpspreadsheet');
        }
        
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set headers
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Tanggal & Waktu');
        $sheet->setCellValue('C1', 'Admin');
        $sheet->setCellValue('D1', 'Aktivitas');
        
        // Style headers
        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E31E24']
            ],
            'font' => ['color' => ['rgb' => 'FFFFFF']]
        ];
        $sheet->getStyle('A1:D1')->applyFromArray($headerStyle);
        
        // Add data
        $row = 2;
        $no = 1;
        foreach ($logs as $log) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, Carbon::parse($log->waktu)->format('d/m/Y H:i:s'));
            $sheet->setCellValue('C' . $row, $log->nama_admin);
            $sheet->setCellValue('D' . $row, $log->aktivitas);
            $row++;
        }
        
        // Auto-size columns
        foreach(range('A','D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Generate filename
        $filename = 'log_aktivitas_' . date('YmdHis') . '.xlsx';
        
        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}