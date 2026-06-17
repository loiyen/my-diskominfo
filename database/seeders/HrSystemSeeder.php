<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class HrSystemSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'user']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );

        $admin->assignRole('admin');

        $jabatan = [
            ['id_jabatan' => 1, 'nama_jabatan' => 'Staff IT', 'gaji_pokok' => 3000000],
            ['id_jabatan' => 2, 'nama_jabatan' => 'Programmer', 'gaji_pokok' => 4000000],
            ['id_jabatan' => 3, 'nama_jabatan' => 'Senior Programmer', 'gaji_pokok' => 6000000],
            ['id_jabatan' => 4, 'nama_jabatan' => 'Manager IT', 'gaji_pokok' => 8000000],
        ];

        foreach ($jabatan as $item) {
            Jabatan::updateOrCreate(
                ['id_jabatan' => $item['id_jabatan']],
                $item
            );
        }

        $pegawaiData = [
            [1, 'Andi Pratama', 'S1', 2, 'andi@test.com'],
            [2, 'Budi Hartono', 'D3', 1, 'budi@test.com'],
            [3, 'Clara Wijaya', 'S2', 3, 'clara@test.com'],
            [4, 'Dian Novita', 'S1', 4, 'dian@test.com'],
            [5, 'Taufik Hidayat', 'D3', 1, 'taufik@test.com'],
        ];

        foreach ($pegawaiData as [$id, $nama, $gelar, $idJabatan, $email]) {
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $nama,
                    'password' => Hash::make('password'),
                ]
            );

            $user->assignRole('user');

            Pegawai::updateOrCreate(
                ['id_pegawai' => $id],
                [
                    'user_id' => $user->id,
                    'nama' => $nama,
                    'gelar' => $gelar,
                    'id_jabatan' => $idJabatan,
                ]
            );
        }

        $presensi = [
            [1, 1, '2025-01-02', 'hadir', '09:05:00', '17:30:00', 5, 30],
            [2, 1, '2025-01-03', 'hadir', '09:00:00', '16:50:00', 0, 0],
            [3, 1, '2025-01-04', 'hadir', '09:20:00', '18:00:00', 20, 60],
            [4, 1, '2025-01-05', 'alpa', null, null, 0, 0],
            [5, 1, '2025-01-06', 'hadir', '08:50:00', '17:15:00', 0, 15],

            [6, 2, '2025-01-02', 'hadir', '09:00:00', '17:00:00', 0, 0],
            [7, 2, '2025-01-03', 'hadir', '09:10:00', '17:05:00', 10, 5],
            [8, 2, '2025-01-04', 'hadir', '09:00:00', '17:00:00', 0, 0],
            [9, 2, '2025-01-05', 'hadir', '09:30:00', '17:10:00', 30, 10],
            [10, 2, '2025-01-06', 'hadir', '08:55:00', '16:55:00', 0, 0],

            [11, 3, '2025-01-02', 'hadir', '09:00:00', '19:00:00', 0, 120],
            [12, 3, '2025-01-03', 'hadir', '09:40:00', '17:20:00', 40, 20],
            [13, 3, '2025-01-04', 'alpa', null, null, 0, 0],
            [14, 3, '2025-01-05', 'hadir', '08:55:00', '17:10:00', 0, 10],

            [15, 4, '2025-01-02', 'hadir', '08:45:00', '17:30:00', 0, 30],
            [16, 4, '2025-01-03', 'hadir', '08:50:00', '17:00:00', 0, 0],
            [17, 4, '2025-01-04', 'hadir', '08:40:00', '18:00:00', 0, 60],
            [18, 4, '2025-01-05', 'hadir', '08:55:00', '16:50:00', 0, 0],

            [19, 5, '2025-01-02', 'hadir', '09:30:00', '17:05:00', 30, 5],
            [20, 5, '2025-01-03', 'hadir', '10:00:00', '17:00:00', 60, 0],
            [21, 5, '2025-01-04', 'hadir', '09:50:00', '18:00:00', 50, 60],
            [22, 5, '2025-01-05', 'alpa', null, null, 0, 0],
            [23, 5, '2025-01-06', 'hadir', '09:45:00', '17:10:00', 45, 10],
        ];

        foreach ($presensi as [$id, $idPegawai, $tanggal, $status, $masuk, $keluar, $terlambat, $lembur]) {
            Presensi::updateOrCreate(
                ['id_presensi' => $id],
                [
                    'id_pegawai' => $idPegawai,
                    'tanggal' => $tanggal,
                    'status_hadir' => $status,
                    'jam_masuk' => $masuk,
                    'jam_keluar' => $keluar,
                    'jam_masuk_normal' => '09:00:00',
                    'jam_keluar_normal' => '17:00:00',
                    'terlambat_menit' => $terlambat,
                    'lembur_menit' => $lembur,
                ]
            );
        }
    }
}