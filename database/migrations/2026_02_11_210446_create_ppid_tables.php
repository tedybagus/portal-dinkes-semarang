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
        // Tabel Kategori Informasi Publik
        Schema::create('ppid_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Berkala, Serta Merta, Setiap Saat, Dikecualikan
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('color', 7)->default('#3b82f6'); // Hex color untuk UI
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel Informasi Publik
        Schema::create('ppid_informations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ppid_category_id')->constrained()->onDelete('cascade');
            
            // Informasi Dasar
            $table->string('title'); // Judul/Nama Informasi
            $table->text('description')->nullable(); // Deskripsi
            $table->string('information_number')->nullable(); // Nomor Informasi/SK
            
            // Kategori & Klasifikasi
            $table->string('type')->nullable(); // Jenis informasi
            $table->string('responsible_unit')->nullable(); // Unit Penanggung Jawab
            $table->string('information_format')->nullable(); // Softcopy/Hardcopy/Keduanya
            
            // Waktu
            $table->year('year')->default(date('Y')); // Tahun
            $table->date('published_date')->nullable(); // Tanggal dipublikasikan
            $table->date('validity_period')->nullable(); // Masa berlaku
            
            // File/Link
            $table->string('file_path')->nullable(); // Path file jika ada
            $table->string('file_size')->nullable(); // Ukuran file
            $table->string('external_link')->nullable(); // Link eksternal
            
            // Metadata
            $table->text('keywords')->nullable(); // Kata kunci
            $table->text('notes')->nullable(); // Catatan
            $table->boolean('is_public')->default(true); // Tampilkan di publik
            $table->integer('view_count')->default(0); // Jumlah dilihat
            $table->integer('download_count')->default(0); // Jumlah download
            
            $table->timestamps();
            
            // Indexes
            $table->index('ppid_category_id');
            $table->index('year');
            $table->index('is_public');
        });

        // Tabel untuk Log Download
        Schema::create('ppid_download_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ppid_information_id')->constrained()->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('downloaded_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppid_download_logs');
        Schema::dropIfExists('ppid_informations');
        Schema::dropIfExists('ppid_categories');
    }
};