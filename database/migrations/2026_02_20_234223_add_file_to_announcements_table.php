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
        Schema::table('announcements', function (Blueprint $table) {
        // File attachment
            $table->string('file_path')->nullable()->after('content');
            $table->string('file_name')->nullable()->after('file_path');
            $table->string('file_type')->nullable()->after('file_name'); // pdf, doc, jpg, etc
            $table->integer('file_size')->nullable()->after('file_type'); // in bytes
            
            
            // Featured image (optional)
            $table->string('image')->nullable()->after('file_size');
            
            // View counter
            $table->integer('view_count')->default(0)->after('is_active');
            
            // Priority/pinned
            $table->boolean('is_pinned')->default(false)->after('view_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
           $table->dropColumn([
                'file_path', 
                'file_name', 
                'file_type', 
                'file_size',
                'image',
                'view_count',
                'is_pinned'
            ]);
        });
    }
};
