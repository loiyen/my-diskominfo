<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presensi extends Model
{
    protected $table = 'presensi';

    protected $primaryKey = 'id_presensi';

    protected $fillable = [
        'id_pegawai',
        'tanggal',
        'status_hadir',
        'jam_masuk',
        'jam_keluar',
        'jam_masuk_normal',
        'jam_keluar_normal',
        'terlambat_menit',
        'lembur_menit',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime:H:i',
        'jam_keluar' => 'datetime:H:i',
        'jam_masuk_normal' => 'datetime:H:i',
        'jam_keluar_normal' => 'datetime:H:i',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }
}