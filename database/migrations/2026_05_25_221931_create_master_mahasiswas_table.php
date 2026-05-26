<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('master_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nim')->unique();
            $table->string('nama_lengkap')->nullable();
            $table->boolean('is_registered')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('master_mahasiswas');
    }
};