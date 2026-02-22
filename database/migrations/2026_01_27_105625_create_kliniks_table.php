<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kliniks', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Klinik, Puskesmas, dll
            $table->string('kode', 10)->unique(); // KLN, PKM, RS
            $table->string('icon')->nullable(); // fas fa-clinic-medical
            $table->string('color')->default('info'); // info, success, danger
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kliniks');
    }
};
