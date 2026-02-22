<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KlinikSeeder extends Seeder
{
    /**
     * Seeder ini mengisi tabel "kliniks" dengan 5 kategori fasyankes.
     * 
     * Jalankan dengan perintah:
     *   php artisan db:seed --class=KlinikSeeder
     */
    public function run(): void
    {
        // Hapus data kategori lama (ID 1-5)
        DB::table('kliniks')->whereIn('id', [1, 2, 3, 4, 5])->delete();

        // Isi 5 kategori fasyankes
        DB::table('kliniks')->insert([
            [
                'id'          => 1,
                'nama'        => 'Klinik',
                'kode'        => 'KLN',
                'icon'        => 'fas fa-clinic-medical',
                'color'       => 'info',
                'deskripsi'   => 'Fasilitas pelayanan kesehatan tingkat pertama',
                'is_active'   => true,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'id'          => 2,
                'nama'        => 'Puskesmas',
                'kode'        => 'PKM',
                'icon'        => 'fas fa-hospital',
                'color'       => 'success',
                'deskripsi'   => 'Pusat Kesehatan Masyarakat',
                'is_active'   => true,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'id'          => 3,
                'nama'        => 'Rumah Sakit',
                'kode'        => 'RS',
                'icon'        => 'fas fa-hospital-alt',
                'color'       => 'danger',
                'deskripsi'   => 'Fasilitas pelayanan kesehatan rujukan',
                'is_active'   => true,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'id'          => 4,
                'nama'        => 'Apotek',
                'kode'        => 'APT',
                'icon'        => 'fas fa-pills',
                'color'       => 'warning',
                'deskripsi'   => 'Fasilitas penyedia obat dan alat kesehatan',
                'is_active'   => true,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'id'          => 5,
                'nama'        => 'Laboratorium',
                'kode'        => 'LAB',
                'icon'        => 'fas fa-flask',
                'color'       => 'info',
                'deskripsi'   => 'Fasilitas pemeriksaan kesehatan',
                'is_active'   => true,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
        ]);

        // Tampilkan konfirmasi di terminal
        $this->command->info('✅ Kategori fasyankes berhasil diisi:');
        $this->command->info('   1 = Klinik');
        $this->command->info('   2 = Puskesmas');
        $this->command->info('   3 = Rumah Sakit');
        $this->command->info('   4 = Apotek');
        $this->command->info('   5 = Laboratorium');
    }
}