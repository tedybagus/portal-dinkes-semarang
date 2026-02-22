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
        // Tabel untuk Alur Permohonan Informasi
        Schema::create('information_flows', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer('step_number');
            $table->string('icon')->nullable();
            $table->integer('duration_days')->nullable(); // Estimasi waktu
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel untuk Permohonan Informasi
        Schema::create('information_requests', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique(); // No. registrasi
            
            // Data Pemohon
            $table->string('name');
            $table->text('address');
            $table->string('phone');
            $table->string('email');
            $table->string('id_card_number'); // NIK
            $table->string('id_card_file')->nullable(); // Upload KTP
            $table->enum('requester_type', ['perorangan', 'kelompok', 'organisasi'])->default('perorangan');
            
            // Data Permohonan
            $table->text('information_needed'); // Informasi yang dibutuhkan
            $table->text('information_purpose'); // Tujuan penggunaan informasi
            $table->enum('information_format', ['softcopy', 'hardcopy', 'keduanya'])->default('softcopy');
            $table->enum('delivery_method', ['langsung', 'pos', 'email', 'kurir'])->default('email');
            
            // Status & Tracking
            $table->enum('status', [
                'submitted',      // Diajukan
                'verified',       // Diverifikasi
                'processed',      // Diproses
                'ready',          // Siap diambil
                'completed',      // Selesai
                'rejected'        // Ditolak
            ])->default('submitted');
            
            $table->text('rejection_reason')->nullable();
            $table->text('admin_notes')->nullable();
            
            // File hasil
            $table->string('result_file')->nullable();
            $table->dateTime('submitted_at');
            $table->dateTime('processed_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            
            $table->timestamps();
        });

        // Tabel untuk Tindak Lanjut / Tracking
        Schema::create('information_followups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('information_request_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('status');
            $table->text('description');
            $table->string('updated_by')->nullable(); // Nama admin/petugas
            $table->timestamps();
        });

        // Tabel untuk FAQ Permohonan Informasi
        Schema::create('information_faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information_followups');
        Schema::dropIfExists('information_requests');
        Schema::dropIfExists('information_flows');
        Schema::dropIfExists('information_faqs');
    }
    };

