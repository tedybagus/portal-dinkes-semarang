<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $faqs = [
            // Umum
            [
                'kategori'   => 'Umum',
                'pertanyaan' => 'Apa itu Portal Kesehatan ini?',
                'jawaban'    => 'Portal Kesehatan adalah platform digital resmi Dinas Kesehatan yang menyediakan informasi layanan kesehatan, fasilitas kesehatan, pengaduan masyarakat, dan berbagai informasi kesehatan lainnya.',
                'urutan'     => 1,
            ],
            [
                'kategori'   => 'Umum',
                'pertanyaan' => 'Apakah layanan ini gratis?',
                'jawaban'    => 'Ya, semua layanan informasi di portal ini sepenuhnya gratis dan dapat diakses oleh seluruh masyarakat tanpa biaya apapun.',
                'urutan'     => 2,
            ],
            [
                'kategori'   => 'Umum',
                'pertanyaan' => 'Jam operasional layanan kesehatan?',
                'jawaban'    => "Jam operasional berbeda-beda tergantung jenis fasilitas:\n- Puskesmas: Senin–Jumat 07.30–14.00 WIB\n- Rumah Sakit: 24 jam\n- Apotek: bervariasi, cek di halaman Fasyankes",
                'urutan'     => 3,
            ],
            // Pengaduan
            [
                'kategori'   => 'Pengaduan',
                'pertanyaan' => 'Bagaimana cara mengajukan pengaduan?',
                'jawaban'    => "Cara mengajukan pengaduan:\n1. Klik menu Pengaduan di halaman utama\n2. Pilih kategori layanan\n3. Isi formulir dengan lengkap\n4. Upload bukti pendukung (opsional)\n5. Submit dan simpan nomor tiket Anda",
                'urutan'     => 1,
            ],
            [
                'kategori'   => 'Pengaduan',
                'pertanyaan' => 'Berapa lama pengaduan diproses?',
                'jawaban'    => 'Pengaduan diproses dalam 3×24 jam kerja. Anda dapat memantau status pengaduan menggunakan nomor tiket yang diberikan saat pengajuan.',
                'urutan'     => 2,
            ],
            [
                'kategori'   => 'Pengaduan',
                'pertanyaan' => 'Bagaimana cara melacak status pengaduan?',
                'jawaban'    => 'Masukkan nomor tiket pengaduan Anda di menu "Lacak Pengaduan" atau scan QR code yang ada di halaman sukses setelah pengajuan.',
                'urutan'     => 3,
            ],
            // Fasyankes
            [
                'kategori'   => 'Fasyankes',
                'pertanyaan' => 'Bagaimana cara mencari fasilitas kesehatan terdekat?',
                'jawaban'    => 'Buka menu Fasyankes, klik "Lihat Peta" untuk melihat lokasi semua fasilitas kesehatan. Anda juga dapat memfilter berdasarkan kategori (Puskesmas, Rumah Sakit, Apotek, dll).',
                'urutan'     => 1,
            ],
            [
                'kategori'   => 'Fasyankes',
                'pertanyaan' => 'Apakah data fasilitas kesehatan selalu diperbarui?',
                'jawaban'    => 'Ya, data fasilitas kesehatan diperbarui secara berkala oleh tim Dinas Kesehatan. Jika ada data yang tidak akurat, silakan laporkan melalui menu Pengaduan.',
                'urutan'     => 2,
            ],
        ];

        foreach ($faqs as $data) {
            Faq::create($data);
        }

        $this->command->info('✅ ' . count($faqs) . ' FAQ berhasil ditambahkan!');
    }
}
