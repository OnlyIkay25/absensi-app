<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('waktu_absen');
            $table->enum('status', ['Hadir', 'Terlambat', 'Izin', 'Sakit'])->default('Hadir');
            $table->longText('foto_snapshot')->nullable();// Untuk bukti foto saat absen
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};