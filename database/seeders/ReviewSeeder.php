<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reviews = [
            [
                'reviewer_name' => 'Budi Santoso',
                'reviewer_email' => 'budi.santoso@example.com',
                'reviewer_phone' => '081234567890',
                'rating' => 5,
                'review_text' => 'Pelayanan sangat memuaskan! Petugas sangat ramah dan profesional. Fasilitasnya bersih dan nyaman. Proses administrasi juga cepat. Sangat recommend untuk yang butuh layanan kesehatan berkualitas!',
                'service_type' => 'Layanan Kesehatan',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => 'Admin',
                'created_at' => now()->subDays(15),
            ],
            [
                'reviewer_name' => 'Siti Nurhaliza',
                'reviewer_email' => 'siti.nurhaliza@example.com',
                'rating' => 5,
                'review_text' => 'Dokternya sangat sabar dalam menjelaskan kondisi kesehatan. Waktu tunggu tidak terlalu lama. Obat yang diberikan juga tepat dan efektif. Terima kasih atas pelayanan yang luar biasa!',
                'service_type' => 'Layanan Farmasi',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => 'Admin',
                'created_at' => now()->subDays(12),
            ],
            [
                'reviewer_name' => 'Ahmad Fauzi',
                'reviewer_email' => 'ahmad.fauzi@example.com',
                'reviewer_phone' => '082345678901',
                'rating' => 4,
                'review_text' => 'Secara keseluruhan pelayanan bagus dan memuaskan. Hanya saja kadang antriannya agak lama di jam sibuk. Tapi setelah masuk, pelayanannya oke dan petugas ramah.',
                'service_type' => 'Layanan Umum',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => 'Admin',
                'created_at' => now()->subDays(10),
            ],
            [
                'reviewer_name' => 'Dewi Lestari',
                'reviewer_email' => 'dewi.lestari@example.com',
                'rating' => 5,
                'review_text' => 'Senang sekali dengan pelayanan bidannya. Sangat care, sabar, dan membantu. Ruang tunggunya nyaman dan bersih. Rekomendasi banget untuk ibu hamil yang cari pelayanan terbaik.',
                'service_type' => 'Layanan Bidan',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => 'Admin',
                'created_at' => now()->subDays(8),
            ],
            [
                'reviewer_name' => 'Rizki Pratama',
                'reviewer_email' => 'rizki.pratama@example.com',
                'reviewer_phone' => '083456789012',
                'rating' => 4,
                'review_text' => 'Bagus dan profesional. Sudah beberapa kali kesini dan selalu puas dengan layanannya. Staff juga helpful dan informatif. Akan tetap menggunakan layanan ini.',
                'service_type' => 'Layanan Kesehatan',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => 'Admin',
                'created_at' => now()->subDays(7),
            ],
            [
                'reviewer_name' => 'Lina Marlina',
                'reviewer_email' => 'lina.marlina@example.com',
                'rating' => 5,
                'review_text' => 'Pengalaman yang sangat positif! Dari pendaftaran sampai selesai semuanya lancar. Dokternya kompeten dan komunikatif. Tempatnya juga strategis dan mudah dijangkau.',
                'service_type' => 'Layanan Kesehatan',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => 'Admin',
                'created_at' => now()->subDays(6),
            ],
            [
                'reviewer_name' => 'Hendra Gunawan',
                'reviewer_email' => 'hendra.gunawan@example.com',
                'reviewer_phone' => '084567890123',
                'rating' => 4,
                'review_text' => 'Pelayanan cukup baik. Harga terjangkau dan kualitas OK. Mungkin bisa ditingkatkan lagi untuk fasilitas ruang tunggunya. Overall recommended!',
                'service_type' => 'Layanan Farmasi',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => 'Admin',
                'created_at' => now()->subDays(5),
            ],
            [
                'reviewer_name' => 'Maya Sari',
                'rating' => 5,
                'review_text' => 'Sangat puas dengan konsultasi gizi yang saya dapat. Ahli gizinya sangat membantu dan memberikan advice yang praktikal. Program dietnya juga efektif. Terima kasih!',
                'service_type' => 'Layanan Gizi',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => 'Admin',
                'created_at' => now()->subDays(4),
            ],
            [
                'reviewer_name' => 'Bambang Suryanto',
                'reviewer_email' => 'bambang.s@example.com',
                'rating' => 5,
                'review_text' => 'Excellent service! Staff sangat ramah dan helpful. Prosedurnya jelas dan transparan. Highly recommended untuk siapa saja yang butuh layanan kesehatan berkualitas.',
                'service_type' => 'Layanan Kesehatan',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => 'Admin',
                'created_at' => now()->subDays(3),
            ],
            [
                'reviewer_name' => 'Rina Wati',
                'reviewer_email' => 'rina.wati@example.com',
                'reviewer_phone' => '085678901234',
                'rating' => 4,
                'review_text' => 'Pelayanan memuaskan. Petugas sigap dan ramah. Tempatnya bersih. Sedikit saran mungkin bisa ditambah kursi di ruang tunggu karena kadang penuh.',
                'service_type' => 'Layanan Umum',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => 'Admin',
                'created_at' => now()->subDays(2),
            ],
            
            // Pending reviews (belum disetujui)
            [
                'reviewer_name' => 'Andi Wijaya',
                'reviewer_email' => 'andi.wijaya@example.com',
                'rating' => 5,
                'review_text' => 'Review yang luar biasa! Pelayanan sangat baik dan profesional. Sangat merekomendasikan!',
                'service_type' => 'Layanan Kesehatan',
                'status' => 'pending',
                'created_at' => now()->subHours(5),
            ],
            [
                'reviewer_name' => 'Putri Ayu',
                'reviewer_email' => 'putri.ayu@example.com',
                'rating' => 3,
                'review_text' => 'Lumayan bagus, tapi masih ada yang perlu ditingkatkan terutama waktu tunggu.',
                'service_type' => 'Layanan Umum',
                'status' => 'pending',
                'created_at' => now()->subHours(2),
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }

        $this->command->info('✅ ' . count($reviews) . ' reviews created successfully!');
        $this->command->info('   - Approved: ' . Review::approved()->count());
        $this->command->info('   - Pending: ' . Review::pending()->count());
        $this->command->info('   - Average Rating: ' . number_format(Review::averageRating(), 2));
    }
}