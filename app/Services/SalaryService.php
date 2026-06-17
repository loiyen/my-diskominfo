<?php

namespace App\Services;

use App\Models\Pegawai;

class SalaryService
{
    public function calculate(Pegawai $pegawai, int $bulan, int $tahun): array
    {
        $presensi = $pegawai->presensi()
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        $jumlahAlpa = $presensi
            ->where('status_hadir', 'alpa')
            ->count();

        $totalTerlambatMenit = $presensi
            ->sum('terlambat_menit');

        $totalLemburMenit = $presensi
            ->sum('lembur_menit');

        $potonganAlpa = $jumlahAlpa * 100000;

        $potonganTerlambat = $totalTerlambatMenit * 2000;

        $totalPotongan = $potonganAlpa + $potonganTerlambat;

        $totalLembur = $totalLemburMenit * 1000;

        $gajiPokok = $pegawai->jabatan?->gaji_pokok ?? 0;

        $gajiBersih = $gajiPokok - $totalPotongan + $totalLembur;

        return [
            'id_pegawai' => $pegawai->id_pegawai,
            'nama' => $pegawai->nama,
            'gelar' => $pegawai->gelar,
            'jabatan' => $pegawai->jabatan?->nama_jabatan,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'gaji_pokok' => $gajiPokok,
            'jumlah_alpa' => $jumlahAlpa,
            'total_terlambat_menit' => $totalTerlambatMenit,
            'total_lembur_menit' => $totalLemburMenit,
            'potongan_alpa' => $potonganAlpa,
            'potongan_terlambat' => $potonganTerlambat,
            'total_potongan' => $totalPotongan,
            'total_lembur' => $totalLembur,
            'gaji_bersih' => $gajiBersih,
        ];
    }

    public function calculateAll(int $bulan, int $tahun): array
    {
        return Pegawai::with(['jabatan', 'presensi'])
            ->get()
            ->map(fn ($pegawai) => $this->calculate($pegawai, $bulan, $tahun))
            ->toArray();
    }
}