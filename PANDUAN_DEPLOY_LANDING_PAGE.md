# Panduan Deploy Landing Page Dinas Kesehatan

Dokumen ini menjelaskan seluruh langkah untuk mengintegrasikan `landing_page_dinkes.html` ke dalam project Laravel yang sudah ada, hingga bisa diakses oleh masyarakat umum.

---

## Tahap 1 — Buat Controller Publik

Buat file baru:  
`app/Http/Controllers/HomeController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Fasyankes;
use App\Models\Image;
use Illuminate\Http\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // Hero slideshow — ambil gambar bertipe "hero", aktif, urutan ascending
        $heroImages = Image::active()->hero()->ordered()->get();

        // Fasyankes untuk grid publik (12 per halaman)
        $fasyankes = Fasyankes::with('klinik')
            ->where('is_active', true)
            ->orderBy('nama')
            ->paginate(12);

        // Statistik untuk stats bar di bawah hero
        $stats = [
            'rs'        => Fasyankes::whereHas('klinik', fn($q) => $q->where('nama', 'Rumah Sakit'))->count(),
            'puskesmas' => Fasyankes::whereHas('klinik', fn($q) => $q->where('nama', 'Puskesmas'))->count(),
            'apotek'    => Fasyankes::whereHas('klinik', fn($q) => $q->where('nama', 'Apotek'))->count(),
            'penduduk'  => '1.6M', // ubah sesuai data nyata
        ];

        return view('home', compact('heroImages', 'fasyankes', 'stats'));
    }
}
```

---

## Tahap 2 — Tambahkan Route Publik

Buka `routes/web.php` dan tambahkan **di luar** group `admin` (tanpa middleware `auth`):

```php
use App\Http\Controllers\HomeController;

// Route publik — tidak butuh login
Route::get('/', [HomeController::class, 'index'])->name('home');

// Isi di bawah ini route admin yang sudah ada
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // ... route admin yang sudah ada tetap di sini
});
```

Verifikasi route:
```bash
php artisan route:list --name=home
```

---

## Tahap 3 — Buat View Blade dari HTML Landing Page

### 3.1 Buat file view

Simpan di:  
`resources/views/home.blade.php`

### 3.2 Konversi HTML ke Blade

Buka `landing_page_dinkes.html` dan lakukan perubahan berikut:

**A. Ganti link Login Admin (baris sekitar 593)**

```html
<!-- SEBELUM -->
<a href="#"><i class="fas fa-sign-in-alt"></i> Login Admin</a>

<!-- SESUDAH -->
<a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login Admin</a>
```

**B. Ganti blok Hero Slideshow dengan loop dari database**

Cari tiga blok `<div class="slide">` demo (yang menggunakan URL unsplash.com) dan ganti seluruhnya dengan:

```blade
@if($heroImages->isNotEmpty())
    @foreach($heroImages as $idx => $img)
    <div class="slide {{ $idx === 0 ? 'active' : '' }}" data-index="{{ $idx }}">
        <div class="slide-img" style="background-image: url('{{ $img->image_url }}');"></div>
        <div class="slide-overlay"></div>
        <div class="slide-content">
            <div class="hero-badge"><i class="fas fa-circle"></i> Portal Resmi Dinas Kesehatan</div>
            <h1>{{ $img->title }}</h1>
            <p class="hero-sub">{{ $img->description }}</p>
            <div class="hero-actions">
                <a href="#fasyankes" class="btn-hero-primary"><i class="fas fa-hospital"></i> Lihat Fasyankes</a>
                <a href="#"         class="btn-hero-outline"><i class="fas fa-map-marked-alt"></i> Peta Kesehatan</a>
            </div>
        </div>
    </div>
    @endforeach
@else
    <!-- Fallback: tidak ada gambar hero di database -->
    <div class="slide active">
        <div class="slide-img" style="background: linear-gradient(135deg, #061539, #0a2463);"></div>
        <div class="slide-overlay"></div>
        <div class="slide-content">
            <div class="hero-badge"><i class="fas fa-circle"></i> Portal Resmi Dinas Kesehatan</div>
            <h1>Layanan Kesehatan <em>Terbaik</em> untuk Masyarakat Kota Semarang</h1>
            <p class="hero-sub">Informasi lengkap tentang fasilitas kesehatan dan layanan publik Dinas Kesehatan.</p>
            <div class="hero-actions">
                <a href="#fasyankes" class="btn-hero-primary"><i class="fas fa-hospital"></i> Lihat Fasyankes</a>
            </div>
        </div>
    </div>
@endif
```

**C. Ganti statistik hero dengan data dinamis**

```blade
<!-- SEBELUM -->
<div class="hero-stat-value">12</div>
<div class="hero-stat-label">Rumah Sakit</div>

<!-- SESUDAH -->
<div class="hero-stat-value">{{ $stats['rs'] }}</div>
<div class="hero-stat-label">Rumah Sakit</div>
```

Ulangi untuk Puskesmas (`$stats['puskesmas']`), Apotek (`$stats['apotek']`), dan Penduduk (`$stats['penduduk']`).

**D. Ganti grid Fasyankes statis dengan loop dari database**

Cari semua `<div class="fasyankes-card">` statis dan ganti dengan:

```blade
@foreach($fasyankes as $item)
<div class="fasyankes-card" data-type="{{ strtolower($item->klinik->nama) == 'rumah sakit' ? 'rs' : strtolower($item->klinik->nama) }}">
    <div class="card-header-strip strip-{{ strtolower($item->klinik->nama) == 'rumah sakit' ? 'rs' : strtolower($item->klinik->nama) }}"></div>
    <div class="card-body">
        <div class="card-category cat-{{ strtolower($item->klinik->nama) == 'rumah sakit' ? 'rs' : strtolower($item->klinik->nama) }}">
            <i class="fas fa-hospital"></i> {{ $item->klinik->nama }}
        </div>
        <h3>{{ $item->nama }}</h3>
        <div class="card-meta">
            <div class="card-meta-item"><i class="fas fa-hashtag"></i> Kode: {{ $item->kode }}</div>
            <div class="card-meta-item"><i class="fas fa-map-marker-alt"></i> {{ $item->alamat }}</div>
        </div>
    </div>
    <div class="card-footer">
        <a href="#">Lihat Detail <i class="fas fa-arrow-right"></i></a>
        @if($item->latitude && $item->longitude)
        <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}" target="_blank" class="map-btn">
            <i class="fas fa-map-marker-alt"></i>
        </a>
        @endif
    </div>
</div>
@endforeach
```

**E. Tambahkan pagination Laravel di bawah grid fasyankes**

Cari tombol "Tampilkan Lebih Banyak" dan ganti dengan:

```blade
@if($fasyankes->hasPages())
<div style="text-align: center; margin-top: 2.5rem;">
    {{ $fasyankes->links('pagination.tailwind') }}
</div>
@endif
```

---

## Tahap 4 — Upload Gambar Hero ke Database

Setelah file `home.blade.php` siap, login ke admin panel dan upload gambar hero:

1. Buka `http://localhost/admin/images/create`
2. Upload gambar (maks 5 MB, format JPEG/PNG/WEBP)
3. Set **Type** ke `Hero`
4. Isi **Title** dan **Description** — ini yang akan tampil sebagai judul dan sub-judul di slideshow
5. Set **Order** untuk mengatur urutan slide (0 = pertama)
6. Centang **Active**
7. Ulangi untuk setiap slide yang diinginkan

---

## Tahap 5 — Test di Lokal

```bash
# Clear semua cache
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Pastikan storage link ada
php artisan storage:link

# Jalankan server
php artisan serve
```

Buka browser dan akses `http://localhost` — landing page seharusnya muncul tanpa login.

**Checklist verifikasi:**
- Slideshow hero berjalan otomatis dan gambar dari database tampil
- Statistik (RS, Puskesmas, Apotek) menampilkan angka dari database
- Grid fasyankes menampilkan data dari database
- Tombol filter (Rumah Sakit, Puskesmas, dst.) bekerja
- Tombol "Login Admin" mengarah ke halaman login
- Tampilan responsif di mobile

---

## Tahap 6 — Deploy ke Server Produksi

### 6.1 Persiapan Server

Pastikan server memiliki:
- PHP 8.1 atau lebih tinggi
- MySQL / MariaDB
- Nginx atau Apache
- Composer dan Node.js (untuk build aset jika menggunakan Vite)

### 6.2 Upload Project

```bash
# Di server produksi
cd /var/www/html
git clone <repo-url> dinkes
cd dinkes

# Install dependencies
composer install --no-dev
npm install
npm run build    # jika menggunakan Vite

# Salin .env
cp .env.example .env
php artisan key:generate
```

### 6.3 Konfigurasi .env

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://dinkes.semarang.go.id

DB_HOST=127.0.0.1
DB_DATABASE=dinkes_prod
DB_USERNAME=dinkes_user
DB_PASSWORD=password_produksi

# Untuk storage gambar
FILESYSTEM_DISK=local
```

### 6.4 Migrasi dan Storage

```bash
php artisan migrate --force
php artisan storage:link

# Atur permission
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### 6.5 Konfigurasi Nginx

Buat file `/etc/nginx/sites-enabled/dinkes`:

```nginx
server {
    listen 443 ssl;
    server_name dinkes.semarang.go.id;

    root /var/www/html/dinkes/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_pass unix:/run/php/php-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Cache aset statis
    location ~* \.(css|js|png|jpg|gif|webp|svg|ico)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }

    # Keamanan
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```bash
sudo nginx -t
sudo systemctl reload nginx
```

### 6.6 SSL Certificate

```bash
sudo certbot --nginx -d dinkes.semarang.go.id
```

### 6.7 Optimasi Produksi Laravel

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## Tahap 7 — Migrasi Gambar Hero ke Server Produksi

Gambar hero yang sudah diupload lokal ada di `storage/app/public/gallery/`. Upload ke server:

```bash
# Di server produksi
scp -r /path/lokal/storage/app/public/gallery/* user@server:/var/www/html/dinkes/storage/app/public/gallery/
```

Atau jika menggunakan database dump, pastikan tabel `images` sudah terisi.

---

## Struktur File Akhir

```
resources/views/
├── home.blade.php                  ← Landing page publik (BARU)
├── layouts/
│   └── admin.blade.php             ← Layout admin (sudah ada)
└── admin/
    ├── fasyankes/                  ← Sudah ada
    ├── images/                     ← Sudah ada
    └── ...

app/Http/Controllers/
├── HomeController.php              ← Controller publik (BARU)
└── Admin/
    ├── FasyankesController.php     ← Sudah ada
    ├── ImageController.php         ← Sudah ada
    └── ...

routes/
└── web.php                         ← Tambahkan Route::get('/') di atas group admin
```

---

## Troubleshooting Umum

| Masalah | Kemungkinan Penyebab | Solusi |
|---|---|---|
| Halaman `/` menampilkan login | Route `/` belum ditambahkan atau masih di-wrap middleware `auth` | Pastikan `Route::get('/')` ada **di luar** group admin |
| Gambar hero tidak muncul | Storage link tidak ada atau gambar belum diupload | Jalankan `php artisan storage:link`, lalu upload gambar dengan type `Hero` |
| Statistik menampilkan 0 | Kolom `is_active` di tabel fasyankes kosong atau `NULL` | Set `is_active = 1` di database untuk data fasyankes |
| Filter fasyankes tidak bekerja | `data-type` di card tidak cocok dengan nilai filter | Pastikan nilai `data-type` konsisten: `rs`, `puskesmas`, `klinik`, `apotek`, `lab` |
| Slideshow berhenti di slide pertama | Tidak ada gambar hero di database | Upload minimal 1 gambar dengan type `Hero` dan status `Active` |
| CSS/JS tidak termuat di produksi | Asset belum di-build atau cache belum diclear | Jalankan `npm run build` dan `php artisan optimize` |
