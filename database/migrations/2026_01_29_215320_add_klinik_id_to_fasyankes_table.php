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
        Schema::table('fasyankes', function (Blueprint $table) {
            if (!Schema::hasColumn('fasyankes', 'klinik_id')) {
            Schema::table('fasyankes', function (Blueprint $table) {
                // Tambah kolom klinik_id setelah kolom id
                $table->unsignedBigInteger('klinik_id')->after('id');
                
                // Tambah foreign key constraint
                $table->foreign('klinik_id')
                      ->references('id')
                      ->on('kliniks')
                      ->onDelete('cascade');
            });
        }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fasyankes', function (Blueprint $table) {
            // Hapus foreign key dulu
            $table->dropForeign(['klinik_id']);
            // Baru hapus kolom
            $table->dropColumn('klinik_id');
        });
    }
};
