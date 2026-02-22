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
         Schema::table('complaints', function (Blueprint $table) {
            // Add default values for columns that might be missing them
            
            // Counters - set default to 0
            if (Schema::hasColumn('complaints', 'view_count')) {
                $table->integer('view_count')->default(0)->change();
            } else {
                $table->integer('view_count')->default(0)->after('feedback');
            }
            
            if (Schema::hasColumn('complaints', 'download_count')) {
                $table->integer('download_count')->default(0)->change();
            } else {
                $table->integer('download_count')->default(0)->after('view_count');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('complaints', function (Blueprint $table) {
            // Optional: Remove default values
            $table->integer('view_count')->default(null)->change();
            $table->integer('download_count')->default(null)->change();
        });
    }
};
