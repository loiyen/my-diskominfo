<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       
        Schema::create('jabatan', function (Blueprint $table) {
            $table->id('id_jabatan');
            $table->string('nama_jabatan', 100);
            $table->decimal('gaji_pokok', 12, 2);
            $table->timestamps();
        });

        Schema::create('pegawai', function (Blueprint $table) {
            $table->id('id_pegawai');
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('nama', 150);
            $table->enum('gelar', ['D3', 'S1', 'S2']);
            $table->unsignedBigInteger('id_jabatan');
            $table->timestamps();
            $table->foreign('id_jabatan')
                ->references('id_jabatan')
                ->on('jabatan')
                ->cascadeOnDelete();
        });

        Schema::create('presensi', function (Blueprint $table) {
            $table->id('id_presensi');
            $table->unsignedBigInteger('id_pegawai');
            $table->date('tanggal');
            $table->enum('status_hadir', [
                'hadir',
                'alpa'
            ]);
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->time('jam_masuk_normal')
                ->default('09:00:00');
            $table->time('jam_keluar_normal')
                ->default('17:00:00');
            $table->integer('terlambat_menit')
                ->default(0);
            $table->integer('lembur_menit')
                ->default(0);
            $table->timestamps();
            $table->foreign('id_pegawai')
                ->references('id_pegawai')
                ->on('pegawai')
                ->cascadeOnDelete();
            $table->unique([
                'id_pegawai',
                'tanggal'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
        Schema::dropIfExists('pegawai');
        Schema::dropIfExists('jabatan');
        Schema::dropIfExists('users');
    }
};
