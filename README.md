# PT Maju Jaya Teknologi - Test Programmer

## Tech Stack

- Laravel 12
- Filament
- Filament Shield
- MySQL


## Fitur

### Authentication
- Admin
- User

### Master Data
- Jabatan
- Pegawai
- Presensi

### Dashboard
- Jumlah Pegawai
- Total Lembur
- Total Potongan
- Rekap Gaji

### API
- GET /api/jabatan
- GET /api/pegawai
- GET /api/presensi

### Export
- PDF Rekap Gaji

## SQL Query Jawaban Soal 2-4

(tempel query yang sudah dibuat)

## Cara Menjalankan

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve

#login super admin
Email: admin@test.com
Password: password

##Screenshot Aplikasi

Saya buatkan di folder: ss aplikasi


#SOAL TEST PROGRAMMER

#Sorting Pegawai Berdasarkan Gelar
SELECT
    p.id_pegawai,
    p.nama,
    p.gelar,
    j.nama_jabatan
FROM pegawai p
JOIN jabatan j ON j.id_jabatan = p.id_jabatan
ORDER BY
    CASE p.gelar
        WHEN 'D3' THEN 1
        WHEN 'S1' THEN 2
        WHEN 'S2' THEN 3
        ELSE 4
    END ASC;

#Hitung Total Potongan Presensi Pegawai
SELECT
    p.id_pegawai,
    p.nama,
    COUNT(CASE WHEN pr.status_hadir = 'alpa' THEN 1 END) AS total_alpa,
    COALESCE(SUM(pr.terlambat_menit), 0) AS total_terlambat_menit,
    COUNT(CASE WHEN pr.status_hadir = 'alpa' THEN 1 END) * 100000 AS potongan_alpa,
    COALESCE(SUM(pr.terlambat_menit), 0) * 2000 AS potongan_terlambat,
    (
        COUNT(CASE WHEN pr.status_hadir = 'alpa' THEN 1 END) * 100000
        +
        COALESCE(SUM(pr.terlambat_menit), 0) * 2000
    ) AS total_potongan
FROM pegawai p
LEFT JOIN presensi pr ON pr.id_pegawai = p.id_pegawai
WHERE MONTH(pr.tanggal) = 1
  AND YEAR(pr.tanggal) = 2025
GROUP BY
    p.id_pegawai,
    p.nama;

#Hitung Total Lembur Pegawai
SELECT
    p.id_pegawai,
    p.nama,
    COALESCE(SUM(pr.lembur_menit), 0) AS total_lembur_menit,
    COALESCE(SUM(pr.lembur_menit), 0) * 1000 AS total_lembur
FROM pegawai p
LEFT JOIN presensi pr ON pr.id_pegawai = p.id_pegawai
WHERE MONTH(pr.tanggal) = 1
  AND YEAR(pr.tanggal) = 2025
GROUP BY
    p.id_pegawai,
    p.nama;
    
#Hitung Gaji Bersih Pegawai
SELECT
    p.nama AS pegawai,
    j.nama_jabatan AS jabatan,
    j.gaji_pokok AS gaji_pokok,

    (
        COUNT(CASE WHEN pr.status_hadir = 'alpa' THEN 1 END) * 100000
        +
        COALESCE(SUM(pr.terlambat_menit), 0) * 2000
    ) AS total_potongan,

    COALESCE(SUM(pr.lembur_menit), 0) * 1000 AS total_lembur,

    (
        j.gaji_pokok
        -
        (
            COUNT(CASE WHEN pr.status_hadir = 'alpa' THEN 1 END) * 100000
            +
            COALESCE(SUM(pr.terlambat_menit), 0) * 2000
        )
        +
        COALESCE(SUM(pr.lembur_menit), 0) * 1000
    ) AS gaji_bersih

FROM pegawai p
JOIN jabatan j ON j.id_jabatan = p.id_jabatan
LEFT JOIN presensi pr ON pr.id_pegawai = p.id_pegawai
WHERE MONTH(pr.tanggal) = 1
  AND YEAR(pr.tanggal) = 2025
GROUP BY
    p.id_pegawai,
    p.nama,
    j.nama_jabatan,
    j.gaji_pokok
ORDER BY p.id_pegawai ASC;


#soal no 8 
http://127.0.0.1:8000/laporan-gaji?bulan=1&tahun=2025 => untuk export laporan PDF 