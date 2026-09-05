# KapanRich

Aplikasi pelacak keuangan pribadi berbasis web, dibangun dari nol dengan desain sistem **neubrutalism**. Dibuat untuk penggunaan harian sekaligus sebagai portfolio piece.

> ⚠️ **Status: Work in Progress** — sedang dalam proses deployment ke production. Belum ada demo publik yang bisa diakses.

<!-- 
  TODO: Tambahkan screenshot/preview UI di sini setelah tersedia.
  Contoh: ![KapanRich Preview](./docs/preview.png)
-->

---

## Daftar Isi

- [Tentang Proyek](#tentang-proyek)
- [Fitur](#fitur)
- [Tech Stack](#tech-stack)
- [Desain Sistem](#desain-sistem)
- [Instalasi Lokal](#instalasi-lokal)
- [Struktur Environment](#struktur-environment)
- [Deployment](#deployment)
- [Roadmap](#roadmap)
- [Lisensi](#lisensi)

---

## Tentang Proyek

KapanRich adalah aplikasi manajemen keuangan pribadi yang dirancang untuk mencatat pemasukan, pengeluaran, dan utang dengan cepat, jelas, dan enak dipandang. Proyek ini dikembangkan sendiri (solo project) sebagai media belajar sekaligus showcase kemampuan full-stack development menggunakan Laravel dan Livewire.

## Fitur

- **Form Transaksi Modal** — dipicu tombol FAB, dengan tab income/expense dan kategori dinamis
- **Riwayat Transaksi** — daftar transaksi dikelompokkan per tanggal, dengan filter periode dan layout dua kolom
- **Buku Utang (Debt Book)** — pencatatan utang belum lunas dengan modal konfirmasi kustom
- **Manajemen Kategori** — CRUD kategori transaksi
- **Navigasi Responsif** — sidebar persisten untuk desktop, drawer + bottom navigation untuk mobile
- **Tema Gelap/Terang** — dengan persistensi tema lintas navigasi SPA (`wire:navigate`)
- **Avatar Personal** — avatar bergaya anime dari DiceBear, digenerate dari seed unik per pengguna
- **Format Mata Uang Real-Time** — pemisah ribuan gaya Indonesia (titik)
- **Toast Notifikasi Global** — animasi checkmark SVG yang bisa dipakai ulang di seluruh aplikasi
- **Pagination Independen** — menggunakan multiple paginator Livewire yang berjalan terpisah

## Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel 13 |
| Frontend Reactivity | Livewire 3 (dengan Volt) |
| Interaktivitas Ringan | Alpine.js |
| Styling | Tailwind CSS |
| Database | MySQL |
| Autentikasi | Laravel Breeze (varian Livewire) |
| Build Tool | Vite |

## Desain Sistem

KapanRich menggunakan sistem desain **neubrutalism** kustom dengan token desain berikut:

- **Border:** 3px solid black
- **Shadow:** hard shadow `4px 4px`, tanpa blur
- **Border radius:** 5px
- **Tipografi:** bold, tegas
- **Tema:** CSS custom properties untuk mode light/dark

**Palet warna fungsional:**

| Warna | Fungsi |
|---|---|
| 🟢 Hijau | Pemasukan (income) |
|  Pink | Pengeluaran (expense) |
|  Kuning | Utang belum lunas |
| 🔵 Teal | Aksi utama (primary action) |

## Instalasi Lokal

### Prasyarat

- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL

### Langkah

```bash
# Clone repository
git clone https://github.com/<username>/kapanrich.git
cd kapanrich

# Install dependencies PHP
composer install

# Install dependencies frontend
npm install

# Salin file environment
cp .env.example .env
php artisan key:generate

# Konfigurasi koneksi database di .env, lalu jalankan migrasi
php artisan migrate

# Build asset frontend
npm run build

# Jalankan server lokal
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`.

## Struktur Environment

Proyek ini menggunakan dua konfigurasi environment terpisah:

- `.env.example` — untuk pengembangan lokal
- `.env.production.example` — template untuk production (Aiven + Wasmer Edge)

Untuk koneksi database production, sertifikat SSL Aiven disimpan di `storage/certs/aiven-ca.pem`.

## Deployment

Arsitektur production KapanRich dirancang 100% gratis tanpa memerlukan kartu kredit:

- **Database:** [Aiven](https://aiven.io/) (MySQL free-tier, dengan koneksi SSL)
- **Hosting Aplikasi:** [Wasmer Edge](https://wasmer.io/) (containerized via Docker + Nginx + Supervisor)

Konfigurasi deployment (`Dockerfile`, `wasmer.toml`, script Nginx/Supervisor) tersedia di repository ini.

**Progres saat ini:**

- [x] Provisioning MySQL di Aiven
- [x] Konfigurasi file deployment (Dockerfile, wasmer.toml, dll.)
- [x] Generate `APP_KEY` production
- [ ] Instalasi Wasmer CLI
- [ ] Setup secrets via `wasmer app secrets create`
- [ ] Migrasi database ke Aiven
- [ ] `wasmer deploy`

## Roadmap

- [ ] Deployment production selesai dan live
- [ ] Visualisasi data dengan Chart.js (grafik pemasukan/pengeluaran)
- [ ] Fitur lanjutan sesuai roadmap Fase 2/3
