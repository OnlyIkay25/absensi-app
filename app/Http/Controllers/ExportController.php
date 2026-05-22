<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\AbsensiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Absensi;

class ExportController extends Controller
{
    public function exportExcel() 
    {
        return Excel::download(new AbsensiExport, 'rekap-absensi-'.date('d-M-Y').'.xlsx');
    }

    public function exportPdf() 
    {
        $absensis = Absensi::with('user')->orderBy('waktu_absen', 'desc')->get();
        
        // Kita buat view khusus untuk PDF
        $pdf = Pdf::loadView('admin.export-pdf', compact('absensis'));
        return $pdf->download('rekap-absensi-'.date('d-M-Y').'.pdf');
    }
}