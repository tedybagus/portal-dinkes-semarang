<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fasyankes;

class FasyankesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Klinik
            [
                'kategori' => 'klinik',
                'nama' => 'Klinik Sehat Sentosa',
                'kode' => 'KLN-001',
                'alamat' => 'Jl. Pemuda No. 123, Klaten Utara, Klaten',
                'latitude' => -7.7056,
                'longitude' => 110.6061,
            ],
            [
                'kategori' => 'Klinik',
                'nama' => 'Klinik Pratama Sejahtera',
                'kode' => 'KLN-002',
                'alamat' => 'Jl. Diponegoro No. 45, Klaten Tengah, Klaten',
                'latitude' => -7.7103,
                'longitude' => 110.6089,
            ],
            [
                'kategori' => 'Klinik',
                'nama' => 'Klinik Medika Utama',
                'kode' => 'KLN-003',
                'alamat' => 'Jl. Ahmad Yani No. 78, Klaten Selatan, Klaten',
                'latitude' => -7.7156,
                'longitude' => 110.6045,
            ],

            // Puskesmas
            [
                'kategori' => 'Puskesmas',
                'nama' => 'Puskesmas Klaten Utara',
                'kode' => 'PKM-001',
                'alamat' => 'Jl. Merbabu No. 1, Klaten Utara, Klaten',
                'latitude' => -7.7012,
                'longitude' => 110.6123,
            ],
            [
                'kategori' => 'Puskesmas',
                'nama' => 'Puskesmas Klaten Tengah',
                'kode' => 'PKM-002',
                'alamat' => 'Jl. Veteran No. 56, Klaten Tengah, Klaten',
                'latitude' => -7.7089,
                'longitude' => 110.6078,
            ],
            [
                'kategori' => 'Puskesmas',
                'nama' => 'Puskesmas Delanggu',
                'kode' => 'PKM-003',
                'alamat' => 'Jl. Raya Delanggu No. 12, Delanggu, Klaten',
                'latitude' => -7.6178,
                'longitude' => 110.6856,
            ],
            [
                'kategori' => 'Puskesmas',
                'nama' => 'Puskesmas Trucuk',
                'kode' => 'PKM-004',
                'alamat' => 'Jl. Raya Trucuk No. 34, Trucuk, Klaten',
                'latitude' => -7.6934,
                'longitude' => 110.7123,
            ],

            // Rumah Sakit
            [
                'kategori' => 'umah_sakit',
                'nama' => 'RSUD Klaten',
                'kode' => 'RS-001',
                'alamat' => 'Jl. Raya Solo-Jogja KM 5, Klaten',
                'latitude' => -7.7234,
                'longitude' => 110.6234,
            ],
            [
                'kategori' => 'rumah_sakit',
                'nama' => 'RSI Klaten',
                'kode' => 'RS-002',
                'alamat' => 'Jl. Raya Jogja-Solo KM 3, Klaten',
                'latitude' => -7.7145,
                'longitude' => 110.5989,
            ],
            [
                'kategori' => 'rumah_sakit',
                'nama' => 'RS Cakra Husada',
                'kode' => 'RS-003',
                'alamat' => 'Jl. Veteran No. 99, Klaten',
                'latitude' => -7.7089,
                'longitude' => 110.6134,
            ],

            // TPMD & DG
            [
                'kategori' => 'tpmd_dg',
                'nama' => 'TPMD Klaten Kota',
                'kode' => 'TPMD-001',
                'alamat' => 'Jl. Kartini No. 12, Klaten',
                'latitude' => -7.7078,
                'longitude' => 110.6067,
            ],
            [
                'kategori' => 'tpmd_dg',
                'nama' => 'TPMD Jogonalan',
                'kode' => 'TPMD-002',
                'alamat' => 'Jl. Raya Jogonalan No. 45, Jogonalan, Klaten',
                'latitude' => -7.7345,
                'longitude' => 110.5456,
            ],

            // TPMB
            [
                'kategori' => 'tpmb',
                'nama' => 'TPMB Pedan',
                'kode' => 'TPMB-001',
                'alamat' => 'Jl. Raya Pedan No. 23, Pedan, Klaten',
                'latitude' => -7.5789,
                'longitude' => 110.6723,
            ],
            [
                'kategori' => 'tpmb',
                'nama' => 'TPMB Ceper',
                'kode' => 'TPMB-002',
                'alamat' => 'Jl. Raya Ceper No. 67, Ceper, Klaten',
                'latitude' => -7.6723,
                'longitude' => 110.6812,
            ],

            // TPMP
            [
                'kategori' => 'tpmp',
                'nama' => 'TPMP Prambanan',
                'kode' => 'TPMP-001',
                'alamat' => 'Jl. Raya Prambanan No. 89, Prambanan, Klaten',
                'latitude' => -7.7523,
                'longitude' => 110.4912,
            ],
            [
                'kategori' => 'tpmp',
                'nama' => 'TPMP Juwiring',
                'kode' => 'TPMP-002',
                'alamat' => 'Jl. Raya Juwiring No. 34, Juwiring, Klaten',
                'latitude' => -7.7834,
                'longitude' => 110.7234,
            ],

            // Labkes
            [
                'kategori' => 'labkes',
                'nama' => 'Laboratorium Kesehatan Daerah Klaten',
                'kode' => 'LAB-001',
                'alamat' => 'Jl. Pemuda No. 234, Klaten',
                'latitude' => -7.7067,
                'longitude' => 110.6078,
            ],
            [
                'kategori' => 'labkes',
                'nama' => 'Laboratorium Klinik Prodia Klaten',
                'kode' => 'LAB-002',
                'alamat' => 'Jl. Diponegoro No. 156, Klaten',
                'latitude' => -7.7112,
                'longitude' => 110.6089,
            ],

            // STPT
            [
                'kategori' => 'stpt',
                'nama' => 'Stasiun Transfusi Darah PMI Klaten',
                'kode' => 'STPT-001',
                'alamat' => 'Jl. Merbabu No. 45, Klaten',
                'latitude' => -7.7045,
                'longitude' => 110.6101,
            ],
            [
                'kategori' => 'stpt',
                'nama' => 'STPT RS Cakra Husada',
                'kode' => 'STPT-002',
                'alamat' => 'Jl. Veteran No. 99, Klaten',
                'latitude' => -7.7091,
                'longitude' => 110.6135,
            ],
        ];

        foreach ($data as $item) {
            Fasyankes::create($item);
        }
    echo "✅ Menus created successfully!\n";
}
     
}
