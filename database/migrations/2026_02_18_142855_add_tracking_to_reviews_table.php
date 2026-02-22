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
        Schema::table('reviews', function (Blueprint $table) {
             // Tracking code untuk lacak review
            $table->string('tracking_code', 20)->unique()->nullable()->after('ip_address');
            
            // View count untuk statistik
            $table->integer('view_count')->default(0)->after('tracking_code');
            
            // Index untuk performa
            $table->index('tracking_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex(['tracking_code']);
            $table->dropColumn(['tracking_code', 'view_count']);
        });
    }
};
