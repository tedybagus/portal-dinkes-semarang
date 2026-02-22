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
        Schema::create('produk_hukum', function (Blueprint $table) {
             $table->id();
            
            // Basic Info
            $table->string('nomor'); // Nomor peraturan
            $table->integer('tahun'); // Tahun peraturan
            $table->string('kategori'); // Perda, Perbup, SK, dll
            $table->text('tentang'); // Tentang apa
            
            // Dates
            $table->date('tanggal_penetapan');
            $table->date('tanggal_berlaku')->nullable();
            
            // Status
            $table->enum('status', ['berlaku', 'tidak_berlaku', 'draft'])->default('berlaku');
            
            // File
            $table->string('file_path');
            $table->string('file_name');
            $table->integer('file_size'); // in bytes
            
            // Additional
            $table->text('keterangan')->nullable();
            $table->integer('download_count')->default(0);
            $table->boolean('is_active')->default(true);
            
            // Meta
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            
            // Indexes
            $table->index('kategori');
            $table->index('tahun');
            $table->index('status');
            $table->index(['kategori', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_hukum');
    }
};
