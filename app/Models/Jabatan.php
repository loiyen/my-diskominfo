<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jabatan extends Model
{
    protected $table = 'Jabatan';

    protected $primaryKey = 'id_jabatan';

    protected $fillable = [
        'nama_jabatan',
        'gaji_pokok',
    ];

    public function pegawai(): HasMany
    {
        return $this->hasMany(Pegawai::class, 'id_jabatan', 'id_jabatan');
    }
}
