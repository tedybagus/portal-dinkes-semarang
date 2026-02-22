<?php

namespace Database\Seeders;

use App\Models\StandarPelayanan;
use Illuminate\Database\Seeder;

class StandarPelayananSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama'      => 'Rekomendasi Perizinan Laik Higenitas Sanitasi dan Izin Laik Sehat',
                'kategori'  => 'Sanitasi & Higienitas',
                'deskripsi' => 'Pelayanan rekomendasi perizinan untuk tempat usaha yang memenuhi standar higienitas dan sanitasi yang ditetapkan.',
                'icon'      => 'fa-shield-alt',
                'warna'     => '#10b981',
                'urutan'    => 1,
                'catatan'   => 'Detail Persyaratan lain bisa scan barcode yang tersedia. Seluruh Pelayanan GRATIS.',
                'persyaratan' => [
                    [
                        'judul' => 'Persyaratan',
                        'items' => [
                            'Surat Permohonan',
                            'Fotocopy KTP',
                            'Fotocopy NPWP',
                            'Akta Perusahaan (Bila Berbadan Hukum)',
                            'Denah Lokasi / Peta Sederhana',
                            'Denah Tempat Usaha',
                            'Izin Usaha',
                            'Jika perpanjang dilampirkan izin Laik Higiene Sanitasi yang lama',
                            'NIB (Nomor Induk Berusaha)',
                            'IMB (Izin Mendirikan Bangunan) / PGM (Persetujuan Bangunan Gudang) Sesuai info tata ruang',
                        ],
                    ],
                ],
            ],
            [
                'nama'      => 'Pemenuhan Komitmen Pengurusan SPP-IRT',
                'kategori'  => 'Pangan & IRTP',
                'deskripsi' => 'Pelayanan pengurusan Sertifikat Produksi Pangan Industri Rumah Tangga (SPP-IRT) bagi pelaku usaha pangan rumahan.',
                'icon'      => 'fa-utensils',
                'warna'     => '#f59e0b',
                'urutan'    => 2,
                'catatan'   => 'Detail Persyaratan lain bisa scan barcode yang tersedia. Seluruh Pelayanan GRATIS.',
                'persyaratan' => [
                    [
                        'judul' => 'Persyaratan',
                        'items' => [
                            'FC KTP',
                            'FC Nomor Induk Berusaha',
                            'FC Sertifikat Penyuluhan Keamanan Pangan (PKP) bagi pemohon lama / perpanjang',
                            'Foto ukuran 4x6 (Berwarna) 2 lembar',
                            'Surat pernyataan bermaterai',
                            'Sertifikat IPRT (untuk pemohon perpanjang)',
                            'Data industri rumah tangga dan data produk',
                            'Desain label yang akan digunakan (Bagi pemohon baru)',
                            'Label lama (Bagi pemohon perpanjang)',
                            'Surat pernyataan penanggung jawab (Jika ada)',
                            'Surat kuasa (Jika diuruskan pihak lain)',
                            'Pakta integritas',
                        ],
                    ],
                ],
            ],
            [
                'nama'      => 'Rekomendasi Perizinan Apotek',
                'kategori'  => 'Perizinan Fasyankes',
                'deskripsi' => 'Pelayanan rekomendasi perizinan untuk pendirian dan operasional apotek di Kabupaten Semarang.',
                'icon'      => 'fa-pills',
                'warna'     => '#3b82f6',
                'urutan'    => 3,
                'catatan'   => 'Detail Persyaratan lain bisa scan barcode yang tersedia. Seluruh Pelayanan GRATIS.',
                'persyaratan' => [
                    [
                        'judul' => 'Persyaratan',
                        'items' => [
                            'Surat permohonan kepada DPMPTSP Kab Semarang dari calon APA',
                            'Fotokopi STTRA calon APA',
                            'Fotokopi SIPA Calon APA',
                            'Fotokopi ijazah Apoteker',
                            'Fotokopi KTP Calon APA',
                            'Fotokopi KTP untuk pemohon perseorangan atau Fotokopi Akta Badan Usaha',
                            'Denah bangunan, denah lokasi apotek dan denah apotek terhadap apotek lain',
                            'Daftar asisten apoteker dengan mencantumkan Nama, Alamat, Tanggal kelulusan dan SIKPTTK (dilampiri FC Ijazah dan SIKPTTK)',
                        ],
                    ],
                ],
            ],
            [
                'nama'      => 'Rekomendasi Perizinan Toko Obat',
                'kategori'  => 'Perizinan Fasyankes',
                'deskripsi' => 'Pelayanan rekomendasi perizinan untuk pendirian toko obat di Kabupaten Semarang.',
                'icon'      => 'fa-store',
                'warna'     => '#8b5cf6',
                'urutan'    => 4,
                'catatan'   => 'Detail Persyaratan lain bisa scan barcode yang tersedia. Seluruh Pelayanan GRATIS.',
                'persyaratan' => [
                    [
                        'judul' => 'Persyaratan',
                        'items' => [
                            'Surat permohonan kepada DPMPTSP Kab. Semarang dari calon penanggung jawab toko obat',
                            'FC STRTTK Calon Penanggung jawab toko obat',
                            'FC SIPTTK Calon penanggung jawab toko obat',
                            'FC Ijazah kefarmasian min D3 Farmasi',
                            'FC KTP Calon Penanggung jawab toko obat',
                            'FC KTP untuk pemohon perseorangan atau FC Akta badan usaha',
                            'Denah Bangunan, denah lokasi toko obat dan denah toko obat terhadap toko obat lain',
                            'Daftar alat perlengkapan toko obat',
                        ],
                    ],
                ],
            ],
            [
                'nama'      => 'Rekomendasi Perizinan Klinik',
                'kategori'  => 'Perizinan Fasyankes',
                'deskripsi' => 'Pelayanan rekomendasi perizinan untuk pendirian klinik pratama maupun klinik utama di Kabupaten Semarang.',
                'icon'      => 'fa-clinic-medical',
                'warna'     => '#06b6d4',
                'urutan'    => 5,
                'catatan'   => 'Detail Persyaratan lain bisa scan barcode yang tersedia. Seluruh Pelayanan GRATIS.',
                'persyaratan' => [
                    [
                        'judul' => 'Persyaratan',
                        'items' => [
                            'Permohonan pendirian klinik',
                            'FC KTP Pemohon',
                            'FC Akta pendirian perusahaan yang sah',
                            'FC Hak kepemilikan / penggunaan tanah / sewa minimal 5 tahun',
                            'Profil klinik yang memuat struktur organisasi, tenaga dilengkapi SIP, sarana prasarana klinik dan peralatan serta jenis pelayanan',
                            'FC izin lingkungan SPPL/UKL-UPL',
                            'FC izin lokasi / Keterangan lokasi (Rawat inap)',
                            'FC IMB',
                            'NIB (Nomor Induk Berusaha) dan izin klinik dari OSS',
                            'Izin Operasional Klinik (Bila perpanjang)',
                            'Penanggung jawab klinik: Klinik Utama (dr spesialis) / Klinik Pratama (Dokter umum / Dokter Gigi)',
                        ],
                    ],
                ],
            ],
            [
                'nama'      => 'Rekomendasi Perizinan Puskesmas',
                'kategori'  => 'Perizinan Fasyankes',
                'deskripsi' => 'Pelayanan rekomendasi perizinan untuk operasional Puskesmas di wilayah Kabupaten Semarang.',
                'icon'      => 'fa-hospital',
                'warna'     => '#10b981',
                'urutan'    => 6,
                'catatan'   => 'Detail Persyaratan lain bisa scan barcode yang tersedia. Seluruh Pelayanan GRATIS.',
                'persyaratan' => [
                    [
                        'judul' => 'Persyaratan',
                        'items' => [
                            'Persyaratan Umum Usaha',
                            'Persyaratan Perpanjang',
                            'Persyaratan Perubahan Perizinan Berusaha',
                            'Persyaratan Khusus',
                            'Sarana',
                            'Struktur Organisasi',
                            'Pelayanan',
                        ],
                    ],
                ],
            ],
            [
                'nama'      => 'Rekomendasi Perizinan Rumah Sakit',
                'kategori'  => 'Perizinan Fasyankes',
                'deskripsi' => 'Pelayanan rekomendasi perizinan untuk pendirian dan operasional rumah sakit di Kabupaten Semarang.',
                'icon'      => 'fa-hospital-alt',
                'warna'     => '#ef4444',
                'urutan'    => 7,
                'catatan'   => 'Detail Persyaratan lain bisa scan barcode yang tersedia. Seluruh Pelayanan GRATIS.',
                'persyaratan' => [
                    [
                        'judul' => 'Persyaratan Umum',
                        'items' => [
                            'Berbadan Hukum',
                            'Dokumen Profil Rumah Sakit',
                            'Dokumen Komitmen untuk melakukan akreditasi untuk Rumah Sakit baru',
                            'Surat keterangan pembebasan lahan dari Pemerintah Daerah',
                            'Surat keterangan yang dibutuhkan',
                            'Dokumen Self Assessment Rumah Sakit yang meliputi jenis pelayanan, sumber daya manusia, sarana, prasarana, dan alat kesehatan',
                            'Durasi pemenuhan standar oleh pelaku usaha yang perizinan baru selama 1 (satu) tahun, sejak NIB dan sertifikat standar yang belum terverifikasi terbit',
                        ],
                    ],
                ],
            ],
            [
                'nama'      => 'Rekomendasi Perizinan Panti Sehat',
                'kategori'  => 'Perizinan Kesehatan Tradisional',
                'deskripsi' => 'Pelayanan rekomendasi perizinan untuk pendirian panti sehat di Kabupaten Semarang.',
                'icon'      => 'fa-spa',
                'warna'     => '#f97316',
                'urutan'    => 8,
                'catatan'   => 'Detail Persyaratan lain bisa scan barcode yang tersedia. Seluruh Pelayanan GRATIS.',
                'persyaratan' => [
                    [
                        'judul' => 'Persyaratan',
                        'items' => [
                            'Persyaratan Umum',
                            'Persyaratan Perpanjang',
                            'Persyaratan Perubahan',
                            'Persyaratan Khusus Usaha',
                            'Sarana',
                            'Struktur Organisasi SDM',
                            'Persyaratan Produk / Jasa / Proses',
                        ],
                    ],
                ],
            ],
            [
                'nama'      => 'Rekomendasi Perizinan Penyehat Tradisional / Hattra / STPT',
                'kategori'  => 'Perizinan Kesehatan Tradisional',
                'deskripsi' => 'Pelayanan rekomendasi perizinan bagi penyehat tradisional (Hattra) dan penerbitan Surat Terdaftar Penyehat Tradisional (STPT).',
                'icon'      => 'fa-leaf',
                'warna'     => '#84cc16',
                'urutan'    => 9,
                'catatan'   => 'Detail Persyaratan lain bisa scan barcode yang tersedia. Seluruh Pelayanan GRATIS.',
                'persyaratan' => [
                    [
                        'judul' => 'Persyaratan',
                        'items' => [
                            'Surat permohonan dari penanggung jawab kepada kepala DPMPTSP Kab. Semarang (Bermaterai Rp. 10.000,-)',
                            'Surat pernyataan mengenai metode atau teknik pelayanan yang diberikan',
                            'FC KTP yang masih berlaku',
                            'Pas foto terbaru 4x6 sebanyak 2 lembar',
                            'Surat keterangan lokasi tempat praktik dari lurah atau desa',
                            'Surat pengantar dari puskesmas',
                            'Surat rekomendasi dari Dinkes kabupaten',
                            'Surat rekomendasi dari asosiasi sejenis atau surat keterangan dari tempat kegiatan magang',
                            'FC sertifikat / ijazah penyehat tradisional (Bila ada)',
                            'Denah lokasi menuju sarana Hattra',
                        ],
                    ],
                ],
            ],
            [
                'nama'      => 'Rekomendasi Perizinan Griya Sehat',
                'kategori'  => 'Perizinan Kesehatan Tradisional',
                'deskripsi' => 'Pelayanan rekomendasi perizinan untuk pendirian griya sehat sebagai fasilitas pelayanan kesehatan tradisional.',
                'icon'      => 'fa-home',
                'warna'     => '#14b8a6',
                'urutan'    => 10,
                'catatan'   => 'Detail Persyaratan lain bisa scan barcode yang tersedia. Seluruh Pelayanan GRATIS.',
                'persyaratan' => [
                    [
                        'judul' => 'Persyaratan Umum',
                        'items' => [
                            'Surat permohonan dari penanggung jawab kepada Kepala DPMPTSP Kabupaten Semarang',
                            'Dokumen Profil Griya Sehat',
                            'Durasi pemenuhan standar oleh pelaku usaha untuk perizinan usaha baru selama 6 (enam) bulan sejak NIB diterbitkan',
                        ],
                    ],
                    [
                        'judul' => 'Persyaratan Khusus',
                        'items' => [
                            'Dokumen sarana, prasarana dan peralatan',
                            'Dokumen SIP TKT (Surat Izin Praktik Tenaga Kesehatan Tradisional)',
                        ],
                    ],
                    [
                        'judul' => 'Persyaratan Perpanjang',
                        'items' => [
                            'Dokumen sertifikat standar usaha griya sehat atau surat izin operasional griya sehat yang masih berlaku',
                            'Dokumen self assessment griya sehat',
                        ],
                    ],
                ],
            ],
            [
                'nama'      => 'Pelayanan Pengajuan BPJS PBPU BP Pemda',
                'kategori'  => 'Jaminan Kesehatan',
                'deskripsi' => 'Pelayanan pengajuan kepesertaan BPJS Kesehatan bagi Pekerja Bukan Penerima Upah (PBPU) yang dibiayai oleh Pemerintah Daerah Kabupaten Semarang.',
                'icon'      => 'fa-id-card',
                'warna'     => '#6366f1',
                'urutan'    => 11,
                'catatan'   => 'Seluruh Pelayanan GRATIS.',
                'persyaratan' => [
                    [
                        'judul' => 'Persyaratan',
                        'items' => [
                            'Fotocopy KK',
                            'Fotocopy KTP',
                            'SKTM (Surat Keterangan Tidak Mampu yang ditandatangani lurah dan camat)',
                        ],
                    ],
                    [
                        'judul' => 'Data Dukung',
                        'items' => [
                            'Buku KIA untuk ibu hamil',
                            'Surat keterangan dokter untuk yang sakit kronis / katastropik / ODGJ / sedang di rawat di rumah sakit atau puskesmas dan klinik rawat inap',
                            'Surat keterangan dari Dinas Sosial atau dokter bagi penyandang disabilitas',
                        ],
                    ],
                ],
            ],
        ];

        foreach ($data as $item) {
            StandarPelayanan::create($item);
        }

        $this->command->info('✅ ' . count($data) . ' Standar Pelayanan berhasil ditambahkan!');
    }
}