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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('reviewer_name');
            $table->string('reviewer_email')->nullable();
            $table->string('reviewer_phone')->nullable();
            $table->string('reviewer_photo')->nullable(); // path to uploaded photo
            $table->integer('rating'); // 1-5 stars
            $table->text('review_text');
            $table->string('service_type')->nullable(); // Layanan yang direview
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('rating');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
