# Fixoria Sales - Sistem Inventaris & Manajemen Mutasi Stok Barang

![Laravel](https://img.shields.io/badge/Laravel-v13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-v8.4-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Pest PHP](https://img.shields.io/badge/Pest_PHP-v5-00D9A5?style=for-the-badge)

**Fixoria Sales** adalah sistem manajemen inventaris dan rekapitulasi mutasi stok barang berbasis web yang dirancang modern, responsif, dan kaya akan fitur analitis. Aplikasi ini memudahkan pengelolaan data barang, stok masuk/keluar, pelaporan, serta hak akses pengguna secara efisien dan terstruktur.

---

## 🚀 Fitur Utama

- 📊 **Dashboard Analitik**: Ringkasan performa inventaris, total produk, total stok, indikator stok menipis, dan transaksi mutasi terbaru.
- 📦 **Master Produk**: Kelola informasi barang, kode SKU, kategori, supplier, harga beli, harga jual, stok minimum, dan foto produk.
- 🏷️ **Kategori & Supplier**: Pengelompokan data kategori produk serta manajemen data vendor/pemasok barang.
- 🔄 **Transaksi Stok (Mutasi)**: Pencatatan otomatis barang masuk (*stock in*) dan barang keluar (*stock out*) dengan pembaruan stok *real-time* serta pencegahan stok negatif.
- 📈 **Laporan & Ekspor Data**: Rekapitulasi mutasi stok dengan filter rentang tanggal, jenis transaksi, dan kategori, dilengkapi fitur **Ekspor CSV/Excel** dan **Cetak PDF**.
- 👥 **Manajemen Pengguna & Role**: Pengelolaan akun pengguna, status akun (Aktif/Nonaktif), fitur reset password, serta pembagian peran (*Administrator*, *Inventory Manager*, *Staff Gudang*) dan hak akses (*permissions*).

---

## 🛠️ Teknologi & Tools

- **Framework**: [Laravel 13](https://laravel.com/)
- **Bahasa Pemrograman**: PHP 8.4
- **Frontend & Styling**: Blade Templating, Vanilla CSS, & [Tailwind CSS v4](https://tailwindcss.com/)
- **Pengujian (Testing)**: [Pest PHP 5](https://pestphp.com/)
- **Database**: MySQL / SQLite

---

## 📋 Prasyarat Sistem

Sebelum menjalankan aplikasi, pastikan sistem Anda telah terpasang:
- PHP >= 8.3 / 8.4 (beserta ekstensi PDO, OpenSSL, Mbstring, Tokenizer, XML, Ctype, JSON)
- Composer
- Node.js & NPM
- Database MySQL atau SQLite

---

## ⚡ Cara Instalasi & Mengjalankan Proyek

1. **Kloning Repositori**:
   ```bash
   git clone https://github.com/faiznfl/inventory-barang.git
   cd inventory-barang
   ```

2. **Instal Dependensi PHP**:
   ```bash
   composer install
   ```

3. **Salin & Konfigurasi File Lingkungan (.env)**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi Database & Jalankan Migrasi**:
   Sesuaikan pengaturan database di file `.env`, kemudian jalankan perintah:
   ```bash
   php artisan migrate
   ```

5. **Instal & Build Aset Frontend**:
   ```bash
   npm install
   npm run build
   ```

6. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui peramban web di `http://127.0.0.1:8000`.

---

## 🧪 Menjalankan Pengujian (Automated Tests)

Aplikasi ini dilengkapi dengan pengujian *Feature & Unit Tests* menggunakan **Pest PHP**:

```bash
php artisan test --compact
```

---

## 📄 Lisensi

Proyek ini berada di bawah lisensi [MIT License](LICENSE).
