# Sistem Informasi Pemesanan KopiKu Coffee Shop Berbasis Web ☕

Proyek Aplikasi Web Point of Sale (POS) & Manajemen Coffee Shop modern, interaktif, dan berpenampilan elegan. Disusun sebagai Laporan Proyek Rekayasa Perangkat Lunak oleh:
- **Ryan Sheva Danarindra**
- **David Prastiansyah**

---

## 🌟 Fitur Unggulan

1. **Sisi Pelanggan (Customer / Guest):**
   - Pemilihan tipe layanan pemesanan: **Dine-in (Makan di Tempat)** atau **Takeaway (Bawa Pulang)**.
   - Daftar menu interaktif lengkap dengan foto, harga, deskripsi, pencarian cepat, & filter kategori (*Kopi, Non-Kopi, Snack, Pastry*).
   - Kustomisasi pesanan (*Less Sugar, Extra Shot, No Ice, dll.*) serta keranjang belanja interaktif berbasis Alpine.js.
   - Pilihan metode pembayaran modern (*QRIS Instant, E-Wallet, Kartu Debit, Tunai di Kasir*).
   - Pelacakan status pesanan secara *real-time visual timeline* & nomor antrean harian otomatis (*contoh: KP-001*).

2. **Sisi Staf & Manajemen (Admin, Kasir, Barista):**
   - **Kasir:** Verifikasi pembayaran pesanan, kelola antrean pesanan masuk, dan perbaruan status.
   - **Barista (Kitchen Display):** Layar khusus dapur untuk memantau pesanan yang harus disiapkan & menandai pesanan siap diambil.
   - **Admin Dashboard:** Statistik ringkas hari ini, grafik pendapatan & menu terlaris interaktif (*Chart.js*), serta manajemen lengkap CRUD (*Menu, Kategori, Staf*).

---

## 🛠️ Teknologi yang Digunakan

- **Backend Framework:** [Laravel 13](https://laravel.com) (PHP 8.2+)
- **Database:** MySQL 8.0+
- **Frontend Styling:** Tailwind CSS v4 + Light Theme Kafe Elegan
- **Interaktivitas:** Alpine.js
- **Visualisasi Grafik:** Chart.js
- **Bundler:** Vite

---

## 📋 Persyaratan Sistem (*Prerequisites*)

Pastikan komputer/server Anda telah menginstal:
- **PHP** minimal versi **8.2** atau lebih baru
- **Composer** (PHP Package Manager)
- **Node.js** & **npm** minimal versi 18+
- **MySQL Server** (bisa menggunakan Laragon, XAMPP, atau MySQL native)
- **Git**

---

## 🚀 1. Cara Clone Proyek

Buka terminal (*Git Bash / PowerShell / Command Prompt*) di komputer Anda, lalu jalankan perintah berikut untuk mengkloning repositori ini:

```bash
git clone (https://github.com/daviddprs/RPL.git)
cd "laravel coffeshop"
```

*(Jika sudah memiliki folder proyek di komputer lokal, langsung buka terminal di dalam folder proyek tersebut).*

---

## ⚙️ 2. Cara Install Proyek

Ikuti langkah-langkah instalasi dependensi dan konfigurasi database di bawah ini:

### A. Install Dependensi Backend & Frontend

```bash
# 1. Install paket PHP via Composer
composer install

# 2. Install paket JavaScript & Tailwind via NPM
npm install
```

### B. Konfigurasi File Environment (`.env`)

Salin file `.env.example` menjadi `.env`, lalu buat *Application Key*:

```bash
# Untuk Windows (Command Prompt / PowerShell):
copy .env.example .env

# Untuk Linux / macOS / Git Bash:
cp .env.example .env

# Generate Key Aplikasi Laravel:
php artisan key:generate
```

Buka file `.env` menggunakan teks editor Anda dan sesuaikan konfigurasi database MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=coffee_shop_db
DB_USERNAME=root
DB_PASSWORD=
```

### C. Buat Database & Jalankan Migrasi + Seeder

Pastikan *MySQL Server* Anda sudah berjalan (contoh: via Laragon/XAMPP). Buat database baru bernama **`coffee_shop_db`**, kemudian jalankan perintah migrasi beserta data awal (*seeder*):

```bash
# Migrasi tabel sekaligus mengisi data awal (akun default & 12 menu lengkap foto):
php artisan migrate:fresh --seed

# Buat symbolic link untuk folder penyimpanan foto menu:
php artisan storage:link
```

### D. Build Aset Frontend

Kompilasi CSS Tailwind dan JavaScript agar tampilan berjalan sempurna:

```bash
npm run build
```

---

## ▶️ 3. Cara Run (Menjalankan Aplikasi)

Untuk menjalankan server pengembangan lokal:

```bash
php artisan serve --port=8000
```

Buka browser Anda dan kunjungi alamat berikut:
👉 **http://localhost:8000**

---

## 🔐 Akun Login Default (*Testing*)

Anda dapat mencoba masuk menggunakan salah satu akun default berikut di **http://localhost:8000/login**:

| Peran (*Role*) | Alamat Email | Kata Sandi | Akses Utama |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@coffeeshop.com` | `password` | Dashboard analitik, CRUD Menu, Kategori, & Manajemen Staf |
| **Kasir** | `kasir@coffeeshop.com` | `password` | Verifikasi pembayaran & kelola antrean pesanan masuk |
| **Barista** | `barista@coffeeshop.com` | `password` | Layar pesanan dapur (*Kitchen Display*) |
| **Pelanggan** | `ryan@pelanggan.com` | `password` | Riwayat pesanan pelanggan |
| **Pelanggan** | `david@pelanggan.com` | `password` | Riwayat pesanan pelanggan |

---

## 📁 Struktur Direktori Penting

```text
├── app/
│   ├── Http/Controllers/       # Logika aplikasi (Auth, Admin, Kasir, Barista, Order)
│   ├── Http/Middleware/        # Proteksi rute berbasis peran (RoleMiddleware)
│   └── Models/                 # Model Eloquent (User, Category, Menu, Order, dll)
├── database/
│   ├── migrations/             # Skema tabel database MySQL
│   └── seeders/                # Data awal & foto menu (DatabaseSeeder.php)
├── resources/
│   ├── css/app.css             # Tema warna & konfigurasi Tailwind CSS
│   ├── js/app.js               # Manajemen state keranjang dengan Alpine.js
│   └── views/                  # Tampilan UI Blade (Customer, Admin, Kasir, Barista)
└── routes/web.php              # Daftar rute aplikasi
```

---

## 📜 Lisensi & Pengembang
Dibuat untuk Laporan Proyek Rekayasa Perangkat Lunak — **Ryan Sheva Danarindra** & **David Prastiansyah**.
