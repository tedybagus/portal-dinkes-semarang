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
        Schema::create('fasyankes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('klinik_id');
            $table->enum('kategori', [
                'klinik',
                'puskesmas',
                'tpmd_dg',
                'tpmb',
                'tpmp',
                'rumah_sakit',
                'labkes',
                'stpt'
            ])->index();
            $table->string('nama');
            $table->string('kode', 50)->unique();
            $table->text('alamat')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();

            // Index untuk pencarian
            $table->index(['nama', 'kode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasyankes');
    }
};
