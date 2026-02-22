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
        // Tabel untuk Visi Misi & Motto
        Schema::create('visi_misi', function (Blueprint $table) {
            $table->id();
            $table->text('visi');
            $table->text('misi');
            $table->string('motto', 255)->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel untuk Tupoksi (Tugas Pokok dan Fungsi)
        Schema::create('tupoksi', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('tugas_pokok');
            $table->text('fungsi');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel untuk Struktur Organisasi
        Schema::create('struktur_organisasi', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // Bagan struktur organisasi
            $table->text('content')->nullable(); // Penjelasan tambahan
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel untuk Profil Pejabat Struktural
        Schema::create('pejabat_struktural', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->string('jabatan', 150);
            $table->string('nip', 50)->nullable();
            $table->string('foto')->nullable();
            $table->string('pendidikan', 100)->nullable();
            $table->text('riwayat_jabatan')->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->integer('order')->default(0); // Urutan tampilan
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('pejabat_struktural');
        Schema::dropIfExists('struktur_organisasi');
        Schema::dropIfExists('tupoksi');
        Schema::dropIfExists('visi_misi');
    }
};
