<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Presensi;
use App\Services\SalaryService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function salaryReport(Request $request, SalaryService $salaryService)
    {
        $bulan = (int) $request->get('bulan', now()->month);
        $tahun = (int) $request->get('tahun', now()->year);

        $rekapGaji = $salaryService->calculateAll($bulan, $tahun);

        $totalLembur = collect($rekapGaji)->sum('total_lembur');
        $totalPotongan = collect($rekapGaji)->sum('total_potongan');

        $data = [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'jumlah_pegawai' => Pegawai::count(),
            'total_lembur' => $totalLembur,
            'total_potongan' => $totalPotongan,
            'rekap_gaji' => $rekapGaji,
        ];

        $pdf = Pdf::loadView('reports.salary-report', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->download("laporan-gaji-{$bulan}-{$tahun}.pdf");
    }
}