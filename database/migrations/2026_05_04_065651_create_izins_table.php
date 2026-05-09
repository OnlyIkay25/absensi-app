<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('izins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Relasi ke mahasiswa
            $table->string('jenis_izin'); // Sakit atau Izin
            $table->text('keterangan'); // Alasan
            $table->string('bukti_file')->nullable(); // Path untuk foto surat dokter
            $table->string('status')->default('Menunggu'); // Menunggu, Disetujui, Ditolak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('izins');
    }
};