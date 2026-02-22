<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ComplaintFlow;
use App\Models\ComplaintService;

class ComplaintSeeder extends Seeder
{
    public function run()
    {
        // Seed Complaint Flows
        $flows = [
            [
                'step_number' => 1,
                'title' => 'Pengaduan Diterima',
                'description' => 'Pengaduan Anda telah diterima oleh sistem dan menunggu verifikasi',
                'icon' => 'fa-inbox',
                'duration_days' => 0,
                'order' => 1,
                'is_active' => true
            ],
            [
                'step_number' => 2,
                'title' => 'Verifikasi',
                'description' => 'Tim kami sedang memverifikasi kelengkapan data pengaduan Anda',
                'icon' => 'fa-check-circle',
                'duration_days' => 2,
                'order' => 2,
                'is_active' => true
            ],
            [
                'step_number' => 3,
                'title' => 'Dalam Proses',
                'description' => 'Pengaduan Anda sedang ditindaklanjuti oleh tim terkait',
                'icon' => 'fa-cog',
                'duration_days' => 7,
                'order' => 3,
                'is_active' => true
            ],
            [
                'step_number' => 4,
                'title' => 'Selesai',
                'description' => 'Pengaduan Anda telah diselesaikan dan menunggu feedback',
                'icon' => 'fa-check-double',
                'duration_days' => 1,
                'order' => 4,
                'is_active' => true
            ],
            [
                'step_number' => 5,
                'title' => 'Ditutup',
                'description' => 'Pengaduan telah ditutup setelah mendapat feedback dari Anda',
                'icon' => 'fa-times-circle',
                'duration_days' => 0,
                'order' => 5,
                'is_active' => true
            ]
        ];

        foreach ($flows as $flow) {
            ComplaintFlow::create($flow);
        }

        // Seed Complaint Services
        $services = [
            [
                'name' => 'Layanan Kesehatan',
                'slug' => 'layanan-kesehatan',
                'description' => 'Pengaduan terkait pelayanan rumah sakit, puskesmas, klinik, dan fasilitas kesehatan lainnya',
                'icon' => 'fa-hospital',
                'color' => '#3b82f6',
                'order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Fasilitas Kesehatan',
                'slug' => 'fasilitas-kesehatan',
                'description' => 'Pengaduan terkait kondisi gedung, peralatan, kebersihan, dan fasilitas kesehatan',
                'icon' => 'fa-building',
                'color' => '#10b981',
                'order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'Tenaga Medis',
                'slug' => 'tenaga-medis',
                'description' => 'Pengaduan terkait sikap, kompetensi, atau pelayanan tenaga medis dan paramedis',
                'icon' => 'fa-user-md',
                'color' => '#8b5cf6',
                'order' => 3,
                'is_active' => true
            ],
            [
                'name' => 'Obat & Alat Kesehatan',
                'slug' => 'obat-alkes',
                'description' => 'Pengaduan terkait ketersediaan, kualitas, atau distribusi obat dan alat kesehatan',
                'icon' => 'fa-pills',
                'color' => '#f59e0b',
                'order' => 4,
                'is_active' => true
            ],
            [
                'name' => 'Administrasi & BPJS',
                'slug' => 'administrasi-bpjs',
                'description' => 'Pengaduan terkait administrasi pendaftaran, BPJS, dan pelayanan non-medis',
                'icon' => 'fa-file-alt',
                'color' => '#06b6d4',
                'order' => 5,
                'is_active' => true
            ],
            [
                'name' => 'Lainnya',
                'slug' => 'lainnya',
                'description' => 'Pengaduan umum lainnya yang tidak termasuk kategori di atas',
                'icon' => 'fa-ellipsis-h',
                'color' => '#64748b',
                'order' => 6,
                'is_active' => true
            ]
        ];

        foreach ($services as $service) {
            ComplaintService::create($service);
        }
    }
}