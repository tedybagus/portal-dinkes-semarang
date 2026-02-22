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
        Schema::create('standar_pelayanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('kategori')->default('Perizinan');
            $table->text('deskripsi')->nullable();
            $table->json('persyaratan');         // array of { judul, items[] }
            $table->text('catatan')->nullable();
            $table->string('icon')->default('fa-file-alt');
            $table->string('warna')->default('#f59e0b');
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('view_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standar_pelayanans');
    }
};
