# 🔬 LabPinjam API — Studi Kasus Pembelajaran RESTful API

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![OpenAPI](https://img.shields.io/badge/OpenAPI-3.0.3-brightgreen.svg)](openapi.yaml)

> **LabPinjam API** adalah proyek studi kasus nyata untuk mempelajari arsitektur **RESTful API** modern menggunakan Laravel. Proyek ini memodelkan sistem peminjaman dan pengelolaan inventaris laboratorium kampus.

---

## 📖 Buku Panduan & Dokumentasi Lengkap
Silakan baca panduan lengkap arsitektur dan langkah belajar di:
👉 **[DOKUMENTASI LENGKAP: dokumentasi.md](./dokumentasi.md)**

🎥 **[Tonton Video Demo Aplikasi: Studi Kasus RESTful API Laravel.webm](./Studi%20Kasus%20RESTful%20API%20Laravel.webm)** (Akses langsung di GitHub: [Tonton di sini](https://github.com/codysantoso/labpinjam-api/blob/main/Studi%20Kasus%20RESTful%20API%20Laravel.webm))

Materi yang dibahas di dalamnya:
1. **Analisis Studi Kasus Nyata:** Kebutuhan sistem peminjaman alat lab.
2. **Prinsip RESTful & Arsitektur MVC:** Stateless, HTTP methods, HTTP response codes, dan alur request lifecycle.
3. **Desain & Migrasi Database:** ERD (Users, Alats, Peminjamans), constraint, foreign keys.
4. **Eloquent ORM:** Relasi antar model (`hasMany`, `belongsTo`), casting, dan mutator.
5. **Autentikasi Token (Sanctum):** Login, Register, Logout, Token generation & middleware guard.
6. **Pembuatan API Terstruktur:** Form Requests, API Resources, Database Transactions untuk stok alat.
7. **Katalog Endpoint & OpenAPI 3.0:** Spesifikasi lengkap di [`openapi.yaml`](./openapi.yaml).
8. **Panduan Git & GitHub:** Cara inisialisasi dan push ke repositori GitHub.

---

## 🚀 Memulai Proyek (Quick Start)

### 1. Klon Repositori & Install Dependensi
```bash
git clone https://github.com/codysantoso/labpinjam-api.git
cd labpinjam-api
composer install
```

### 2. Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```
Sesuaikan konfigurasi koneksi database MySQL pada berkas `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=labpinjam_db
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Migrasi & Seeder Database
```bash
php artisan migrate --seed
```

### 4. Menjalankan Server Lokal
```bash
php artisan serve
```
Akses API di: `http://127.0.0.1:8000/api/v1`

---

## 📑 Spesifikasi API
Spesifikasi interaktif OpenAPI 3.0 tersedia di berkas [`openapi.yaml`](./openapi.yaml). Anda dapat melihatnya secara visual dengan mengunggahnya ke [Swagger Editor](https://editor.swagger.io/).

---

## 📄 Lisensi
Didistribusikan di bawah Lisensi GPL-3.0 / MIT. Bebas digunakan untuk bahan ajar dan referensi open-source.
