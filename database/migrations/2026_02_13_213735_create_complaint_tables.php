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
        // Tabel Alur Pengaduan (Process Flow Steps)
        Schema::create('complaint_flows', function (Blueprint $table) {
            $table->id();
            $table->integer('step_number'); // Urutan langkah (1, 2, 3, dst)
            $table->string('title'); // Judul langkah
            $table->text('description'); // Deskripsi langkah
            $table->string('icon')->nullable(); // Icon font awesome
            $table->integer('duration_days')->nullable(); // Estimasi waktu (hari)
            $table->integer('order')->default(0); // Urutan tampilan
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel Kategori Layanan Pengaduan
        Schema::create('complaint_services', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama layanan
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // Icon
            $table->string('color', 7)->default('#3b82f6'); // Warna hex
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel Pengaduan
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique(); // Nomor tiket unik
            $table->foreignId('complaint_service_id')->constrained()->onDelete('cascade');
            
            // Data Pelapor
            $table->string('reporter_name'); // Nama pelapor
            $table->string('reporter_nik', 16)->nullable(); // NIK
            $table->text('reporter_address')->nullable(); // Alamat
            $table->string('reporter_phone', 20); // No HP
            $table->string('reporter_email')->nullable(); // Email
            
            // Detail Pengaduan
            $table->string('subject'); // Judul/subjek pengaduan
            $table->text('description'); // Isi pengaduan
            $table->text('location')->nullable(); // Lokasi kejadian
            $table->date('incident_date')->nullable(); // Tanggal kejadian
            
            // File & Media
            $table->string('evidence_file')->nullable(); // File bukti
            $table->string('evidence_file_size')->nullable();
            
            // Status & Tracking
            $table->enum('status', [
                'submitted',    // Baru diajukan
                'verified',     // Sudah diverifikasi
                'in_progress',  // Sedang diproses
                'resolved',     // Sudah diselesaikan
                'closed',       // Ditutup
                'rejected'      // Ditolak
            ])->default('submitted');
            
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            
            // Response & Solution
            $table->text('admin_notes')->nullable(); // Catatan admin
            $table->text('response')->nullable(); // Tanggapan/solusi
            $table->string('response_file')->nullable(); // File tanggapan
            $table->string('assigned_to')->nullable(); // Ditugaskan ke siapa
            
            // Ratings & Feedback
            $table->integer('satisfaction_rating')->nullable(); // Rating 1-5
            $table->text('feedback')->nullable(); // Feedback dari pelapor
            
            // Timestamps
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('ticket_number');
            $table->index('status');
            $table->index('created_at');
        });

        // Tabel Timeline/History Pengaduan
        Schema::create('complaint_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['submitted', 'verified', 'in_progress', 'resolved', 'closed', 'rejected']);
            $table->text('description'); // Deskripsi perubahan
            $table->string('updated_by')->nullable(); // Admin yang update
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaint_histories');
        Schema::dropIfExists('complaints');
        Schema::dropIfExists('complaint_services');
        Schema::dropIfExists('complaint_flows');
    }
};