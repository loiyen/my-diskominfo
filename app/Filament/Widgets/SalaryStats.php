<?php

namespace App\Filament\Widgets;

use App\Models\Pegawai;
use App\Models\Presensi;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalaryStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $bulan = now()->month;
        $tahun = now()->year;

        $presensi = Presensi::query()
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        $totalLembur = (clone $presensi)->sum('lembur_menit') * 1000;

        $totalPotonganAlpa = (clone $presensi)
            ->where('status_hadir', 'alpa')
            ->count() * 100000;

        $totalPotonganTerlambat = (clone $presensi)->sum('terlambat_menit') * 2000;

        $totalPotongan = $totalPotonganAlpa + $totalPotonganTerlambat;

        return [
            Stat::make('Jumlah Pegawai', Pegawai::count())
                ->description('Total pegawai aktif'),

            Stat::make('Total Lembur Bulan Ini', 'Rp ' . number_format($totalLembur, 0, ',', '.'))
                ->description('Dari total menit lembur'),

            Stat::make('Total Potongan Bulan Ini', 'Rp ' . number_format($totalPotongan, 0, ',', '.'))
                ->description('Alpa + keterlambatan'),
        ];
    }
}
