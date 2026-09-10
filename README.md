# Cafe RJ - Point of Sale (POS) & Order Management System

Sistem kasir digital (POS) berbasis Laravel 12 dan MySQL yang dirancang untuk mengelola pemesanan, multi-metode pembayaran, cetak struk faktur real-time, dan pencatatan transaksi operasional kedai kopi.

---

## Masalah Operasional yang Diatasi

Pencatatan nota manual pada kedai kopi konvensional sering menimbulkan masalah:
- Selisih hitung kembalian dan lambatnya alur antrean saat jam sibuk (rush hour).
- Kurangnya fleksibilitas metode bayar nontunai (QRIS & transfer bank).
- Kerentanan hilangnya riwayat pesanan fisik dan lambatnya rekapitulasi omzet harian pemilik cafe.
- Format cetak struk konvensional yang kerap terpotong atau tidak kompatibel antar perangkat printer.

Aplikasi ini mendigitalkan seluruh alur dari katalog menu, keranjang pesanan kasir, kalkulasi kembalian otomatis, verifikasi pembayaran digital, hingga pelaporan transaksi terpusat.

---

## Fitur Utama

### 1. Terminal Kasir POS (Frontend Kasir)
- Katalog menu visual dengan pemfilteran berbasis kategori dan indikator sisa stok real-time.
- Keranjang belanja interaktif dengan kontrol kuantitas cepat (tambah, kurang, hapus, kosongkan).
- Segmented payment selector dengan transisi animasi halus antar mode pembayaran:
  - Tunai (Cash): Tombol kalkulasi cepat uang pas, pecahan nominal (+20rb, +50rb, +100rb), serta kalkulasi uang kembalian real-time.
  - QRIS Standar Nasional: Standee QR Code dinamis terintegrasi total belanja, dilengkapi modal perbesar layar penuh untuk kemudahan scan dari meja pelanggan.
  - Transfer Bank: Pilihan rekening tujuan resmi (BCA, Mandiri, BRI) dengan fitur salin nomor rekening satu-klik (one-click clipboard copy).
- Validasi transaksi ketat (mencegah checkout keranjang kosong atau pembayaran tunai kurang).
- Proteksi sesi tanpa gangguan: auto-sync token CSRF dan penanganan exception otomatis untuk mencegah error 419 Page Expired.

### 2. Cetak Struk Fleksibel (Print Engine)
- Faktur Layar Penuh (Full Width / A4): Tata letak invoice profesional untuk arsip pelanggan atau transaksi partai besar.
- Struk Thermal Mini (80mm): Format ringkas siap cetak untuk printer kasir thermal POS standar.
- Otomatis memunculkan dialog cetak browser saat transaksi berhasil diselesaikan.

### 3. Panel Manajemen Produk & Kategori (Admin Only)
- Pengelolaan master kategori menu.
- CRUD produk lengkap: nama menu, kategori, harga jual, jumlah stok, dan upload foto produk dengan live preview sebelum disimpan.
- Penyimpanan file media terisolasi di storage/app/public/products via symbolic link.

### 4. Laporan & Riwayat Transaksi
- Daftar transaksi lengkap dengan ID transaksi, kasir penanggung jawab, total bayar, metode bayar, dan status lunas.
- Filter riwayat berdasarkan rentang tanggal.
- Rekapitulasi total transaksi dan akumulasi pendapatan kotor harian/bulanan.
- Cetak ulang struk (reprint receipt) dari riwayat transaksi kapan saja.

### 5. Keamanan & Multi-Role Access Control
- Autentikasi berbasis session dengan middleware pembatas peran (admin dan kasir).
- Kasir dibatasi hanya pada terminal POS dan riwayat transaksi.
- Admin memiliki kendali penuh atas master kategori, produk, dan laporan.

---

## Arsitektur & Teknologi

- Backend: Laravel 12 (PHP 8.2+)
- Basis Data: MySQL 8.x (Database: caferj)
- Frontend: Blade Templates, Tailwind CSS CDN, Vanilla JavaScript (zero bloat, fast load)
- Tipografi & Ikon: Plus Jakarta Sans & Vector SVG Icons
- Storage: Laravel Storage Public Disk (Symbolic Link)

---

## Struktur Direktori

```
caferj/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # Login, logout, session auth
│   │   │   ├── CategoryController.php      # CRUD master kategori (Admin)
│   │   │   ├── PosController.php           # Logika kasir, keranjang, checkout
│   │   │   ├── ProductController.php       # CRUD produk & upload foto (Admin)
│   │   │   └── TransactionController.php   # Riwayat & laporan pendapatan
│   │   └── Middleware/
│   │       ├── CheckRole.php               # Guard otorisasi role kasir/admin
│   │       └── VerifyCsrfToken.php         # Penyesuaian token keamanan
│   └── Models/
│       ├── Category.php                    # Relasi produk kategori
│       ├── Order.php                       # Header pesanan & pembayaran
│       ├── OrderItem.php                   # Item detail pesanan
│       ├── Product.php                     # Master menu & stok
│       └── User.php                        # Akun kasir & admin
├── bootstrap/
│   └── app.php                             # Exception handler global (anti-419)
├── database/
│   ├── migrations/                         # Skema tabel orders, items, products, users
│   └── seeders/
│       └── DatabaseSeeder.php              # Akun default & data menu awal
├── resources/
│   └── views/
│       ├── admin/                          # View kategori & produk (create, edit, index)
│       ├── auth/
│       │   └── login.blade.php             # Form autentikasi
│       ├── layouts/
│       │   └── app.blade.php               # Master layout admin & riwayat
│       ├── pos/
│       │   ├── index.blade.php             # Antarmuka kasir POS interaktif
│       │   └── receipt.blade.php           # Template cetak struk full & mini
│       └── transactions/
│           └── history.blade.php           # Laporan riwayat transaksi
├── routes/
│   └── web.php                             # Routing aplikasi, middleware, ping, csrf
└── storage/
    └── app/public/products/                # Direktori upload gambar menu
```

---

## Panduan Instalasi Lokal

### Prasyarat
- PHP >= 8.2 (ekstensi: pdo_mysql, mbstring, gd, fileinfo)
- Composer
- MySQL Server
- Web Browser modern (Chrome, Edge, Firefox)

### Langkah Instalasi

1. Clone repositori:
```bash
git clone https://github.com/yanzyuyu/caferj.git
cd caferj
```

2. Pasang dependensi PHP:
```bash
composer install
```

3. Konfigurasi environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Sesuaikan konfigurasi database pada .env:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=caferj
DB_USERNAME=root
DB_PASSWORD=
```

5. Jalankan migrasi database dan seeders:
```bash
php artisan migrate --seed
```

6. Buat tautan simbolis storage untuk media gambar:
```bash
php artisan storage:link
```

7. Jalankan server lokal:
```bash
php artisan serve
```

Aplikasi dapat diakses melalui browser di http://127.0.0.1:8000.

---

## Kredensial Akun Default

Database seeder menyediakan dua akun awal untuk pengujian operasional:

| Role | Email | Password | Hak Akses |
|---|---|---|---|
| Admin | admin@caferj.local | admin123 | Akses penuh: POS, Produk, Kategori, Riwayat Transaksi |
| Kasir | kasir@caferj.local | kasir123 | Akses operasional: POS Terminal & Riwayat Transaksi |

---

## Hasil Pengujian & Verifikasi Kualitas

### 1. Pengujian Otomatis (PHPUnit / Feature & Unit Tests)

Pengujian menyeluruh pada fungsionalitas sistem autentikasi, proteksi hak akses kasir/admin, terminal POS, dan detail riwayat transaksi.

```text
$ php artisan test

   PASS  Tests\Unit\ExampleTest
  ✓ that true is true                                                                                            0.62s  

   PASS  Tests\Feature\ExampleTest
  ✓ guest is redirected to login from home                                                                       4.85s  
  ✓ login page renders successfully                                                                              0.37s  
  ✓ authenticated user can access pos                                                                            1.69s  

   PASS  Tests\Feature\TransactionTest
  ✓ user can view transaction history and detail                                                                 0.46s  
  ✓ admin pages render successfully                                                                              0.68s  

  Tests:    6 passed (18 assertions)
  Duration: 13.82s
```

### 2. Audit Keamanan Kode Sumber (tyw-audit)

Audit kode statis (SAST) untuk mendeteksi kerentanan injeksi, kebocoran kredensial, dan validasi input.

```text
$ npx tyw-cli scan . --format json
{
  "score": 100,
  "status": "PASSED",
  "summary": {
    "total": 0,
    "critical": 0,
    "high": 0,
    "medium": 0,
    "low": 0,
    "info": 0
  },
  "issues": []
}
```

Hasil verifikasi: Status PASSED (Skor 100/100, 0 temuan kerentanan).

---

## Lisensi

Proyek ini dikembangkan di bawah [lisensi MIT](LICENSE).
