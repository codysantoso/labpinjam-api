<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LabPinjam API — Studi Kasus RESTful API Laravel</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|jet-brains-mono:400,500" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Instrument Sans', 'sans-serif'],
                            mono: ['JetBrains Mono', 'monospace'],
                        },
                        colors: {
                            brand: {
                                50: '#f0fdf4',
                                100: '#dcfce7',
                                500: '#22c55e',
                                600: '#16a34a',
                                700: '#15803d',
                            }
                        }
                    }
                }
            }
        </script>
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="bg-slate-50 text-slate-800 antialiased selection:bg-emerald-500 selection:text-white dark:bg-slate-950 dark:text-slate-100 min-h-screen flex flex-col justify-between">
        
        <!-- Header & Navigasi -->
        <header class="sticky top-0 z-50 backdrop-blur-md bg-white/80 dark:bg-slate-900/80 border-b border-slate-200 dark:border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-emerald-600 text-white shadow-md shadow-emerald-500/20 font-bold text-lg leading-none">
                        🔬
                    </span>
                    <div>
                        <h1 class="text-base font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2">
                            LabPinjam API
                            <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/80 dark:text-emerald-300 font-semibold border border-emerald-200 dark:border-emerald-800">v1.0</span>
                        </h1>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Studi Kasus Pembelajaran RESTful API Laravel</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ url('/api/v1/alats') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-medium rounded-lg text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition">
                        <span>Lihat API JSON</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                    <a href="#endpoints" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-semibold rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white shadow-sm transition">
                        Daftar Endpoint
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full space-y-12">

            <!-- Hero Section -->
            <section class="text-center max-w-3xl mx-auto space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-300 text-xs font-medium border border-slate-200 dark:border-slate-800">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Server RESTful API Aktif & Siap Digunakan
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    Sistem Peminjaman Alat Laboratorium Kampus
                </h2>
                <p class="text-base text-slate-600 dark:text-slate-300 leading-relaxed">
                    Arsitektur backend modern yang mengimplementasikan <strong>Pola MVC</strong>, <strong>Eloquent ORM</strong>, 
                    <strong>Autentikasi Sanctum Bearer Token</strong>, transaksi atomik ACID, dan standarisasi respons API.
                </p>

                <!-- Live Database Counters -->
                <div class="grid grid-cols-3 gap-4 pt-4 max-w-lg mx-auto">
                    <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm text-center">
                        <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $totalAlat ?? 0 }}</div>
                        <div class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-1">Alat Tersedia</div>
                    </div>
                    <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm text-center">
                        <div class="text-2xl font-bold text-sky-600 dark:text-sky-400">{{ $totalPeminjaman ?? 0 }}</div>
                        <div class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-1">Peminjaman</div>
                    </div>
                    <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm text-center">
                        <div class="text-2xl font-bold text-violet-600 dark:text-violet-400">{{ $totalUser ?? 0 }}</div>
                        <div class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-1">Pengguna Terdaftar</div>
                    </div>
                </div>
            </section>

            <!-- 4 Konsep Inti Arsitektur -->
            <section class="space-y-6">
                <div class="text-center">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Komponen Pembelajaran RESTful API</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Materi yang diimplementasikan dalam repositori proyek ini</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                    <!-- Card 1 -->
                    <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col justify-between hover:border-emerald-500/50 transition">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 dark:bg-emerald-950/70 dark:text-emerald-400 flex items-center justify-center font-bold text-lg mb-3">
                                🏗️
                            </div>
                            <h4 class="font-bold text-sm text-slate-900 dark:text-white mb-1">Arsitektur MVC & Request</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                Pemisahan Controller, Form Request (`StoreAlatRequest`), dan API Resource Transformer agar kode modular dan rapi.
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/80 text-[11px] font-mono text-slate-400">
                            app/Http/Controllers/Api/V1
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col justify-between hover:border-sky-500/50 transition">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-700 dark:bg-sky-950/70 dark:text-sky-400 flex items-center justify-center font-bold text-lg mb-3">
                                ⚡
                            </div>
                            <h4 class="font-bold text-sm text-slate-900 dark:text-white mb-1">Eloquent ORM & Relasi</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                Relasi antar model `User hasMany Peminjaman`, `Alat hasMany Peminjaman`, dan integritas referensial foreign key database.
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/80 text-[11px] font-mono text-slate-400">
                            app/Models/Peminjaman.php
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col justify-between hover:border-violet-500/50 transition">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-violet-100 text-violet-700 dark:bg-violet-950/70 dark:text-violet-400 flex items-center justify-center font-bold text-lg mb-3">
                                🔐
                            </div>
                            <h4 class="font-bold text-sm text-slate-900 dark:text-white mb-1">Sanctum Token Auth</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                Mekanisme stateless autentikasi Bearer Token via header HTTP. Dilengkapi middleware `role:admin` untuk hak akses terbatas.
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/80 text-[11px] font-mono text-slate-400">
                            auth:sanctum & role:admin
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col justify-between hover:border-amber-500/50 transition">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 dark:bg-amber-950/70 dark:text-amber-400 flex items-center justify-center font-bold text-lg mb-3">
                                🛡️
                            </div>
                            <h4 class="font-bold text-sm text-slate-900 dark:text-white mb-1">Transaksi ACID Stok</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                Pengurangan stok alat secara atomik menggunakan `DB::transaction()` & `lockForUpdate()`, serta restorasi stok saat alat kembali.
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/80 text-[11px] font-mono text-slate-400">
                            DB::transaction()
                        </div>
                    </div>
                </div>
            </section>

            <!-- Kredensial Akun Pengujian -->
            <section class="p-6 rounded-2xl bg-gradient-to-r from-slate-900 to-slate-800 text-white shadow-lg space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-emerald-400">Uji Coba Cepat</span>
                        <h3 class="text-lg font-bold">Kredensial Akun Seeder Bawaan</h3>
                        <p class="text-xs text-slate-300">Gunakan akun ini untuk pengujian autentikasi di Postman, Thunder Client, atau cURL:</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs">
                        <span class="px-2.5 py-1 rounded bg-slate-800 border border-slate-700 text-slate-300 font-mono">Password: password123</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div class="p-3.5 rounded-xl bg-slate-800/80 border border-slate-700/80 flex items-center justify-between">
                        <div>
                            <div class="text-[11px] font-semibold text-emerald-400 uppercase">Peran Admin / Laboran</div>
                            <div class="font-mono text-xs text-slate-200 select-all">admin@kampus.ac.id</div>
                        </div>
                        <span class="text-xs px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">CRUD Penuh</span>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-800/80 border border-slate-700/80 flex items-center justify-between">
                        <div>
                            <div class="text-[11px] font-semibold text-sky-400 uppercase">Peran Mahasiswa</div>
                            <div class="font-mono text-xs text-slate-200 select-all">mahasiswa@kampus.ac.id</div>
                        </div>
                        <span class="text-xs px-2 py-0.5 rounded bg-sky-500/20 text-sky-300 border border-sky-500/30">Pinjam Alat</span>
                    </div>
                </div>
            </section>

            <!-- Katalog Endpoint API -->
            <section id="endpoints" class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Daftar Endpoint RESTful API v1</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Seluruh rute menggunakan basis URL <code class="px-1.5 py-0.5 rounded bg-slate-200 dark:bg-slate-800 font-mono text-[11px]">/api/v1</code></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300 font-mono font-bold">GET</span>
                        <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-800 dark:bg-green-950 dark:text-green-300 font-mono font-bold">POST</span>
                        <span class="text-xs px-2 py-1 rounded bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300 font-mono font-bold">PUT</span>
                        <span class="text-xs px-2 py-1 rounded bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300 font-mono font-bold">DELETE</span>
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-100/75 dark:bg-slate-800/50 text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-slate-800 font-semibold">
                                <tr>
                                    <th class="py-3 px-4">Method</th>
                                    <th class="py-3 px-4">Endpoint</th>
                                    <th class="py-3 px-4">Hak Akses</th>
                                    <th class="py-3 px-4">Deskripsi</th>
                                    <th class="py-3 px-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 font-sans">
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                                    <td class="py-3 px-4"><span class="px-2 py-0.5 rounded font-mono font-bold bg-green-100 text-green-800 dark:bg-green-950 dark:text-green-300">POST</span></td>
                                    <td class="py-3 px-4 font-mono font-semibold text-slate-900 dark:text-white">/api/v1/login</td>
                                    <td class="py-3 px-4"><span class="text-slate-500">Publik</span></td>
                                    <td class="py-3 px-4 text-slate-600 dark:text-slate-300">Login pengguna & memperoleh Bearer Token</td>
                                    <td class="py-3 px-4 text-right font-mono text-[11px] text-slate-400">200 / 401</td>
                                </tr>
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                                    <td class="py-3 px-4"><span class="px-2 py-0.5 rounded font-mono font-bold bg-green-100 text-green-800 dark:bg-green-950 dark:text-green-300">POST</span></td>
                                    <td class="py-3 px-4 font-mono font-semibold text-slate-900 dark:text-white">/api/v1/logout</td>
                                    <td class="py-3 px-4"><span class="text-amber-600 dark:text-amber-400 font-medium">auth:sanctum</span></td>
                                    <td class="py-3 px-4 text-slate-600 dark:text-slate-300">Mencabut access token pengguna saat ini</td>
                                    <td class="py-3 px-4 text-right font-mono text-[11px] text-slate-400">200</td>
                                </tr>
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                                    <td class="py-3 px-4"><span class="px-2 py-0.5 rounded font-mono font-bold bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300">GET</span></td>
                                    <td class="py-3 px-4 font-mono font-semibold text-slate-900 dark:text-white">/api/v1/alats</td>
                                    <td class="py-3 px-4"><span class="text-slate-500">Publik</span></td>
                                    <td class="py-3 px-4 text-slate-600 dark:text-slate-300">Melihat seluruh katalog inventaris alat lab</td>
                                    <td class="py-3 px-4 text-right">
                                        <a href="{{ url('/api/v1/alats') }}" target="_blank" class="text-emerald-600 hover:underline font-medium">Buka ↗</a>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                                    <td class="py-3 px-4"><span class="px-2 py-0.5 rounded font-mono font-bold bg-green-100 text-green-800 dark:bg-green-950 dark:text-green-300">POST</span></td>
                                    <td class="py-3 px-4 font-mono font-semibold text-slate-900 dark:text-white">/api/v1/alats</td>
                                    <td class="py-3 px-4"><span class="text-rose-600 dark:text-rose-400 font-medium">role:admin</span></td>
                                    <td class="py-3 px-4 text-slate-600 dark:text-slate-300">Menambahkan item alat baru ke inventaris</td>
                                    <td class="py-3 px-4 text-right font-mono text-[11px] text-slate-400">201 / 403</td>
                                </tr>
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                                    <td class="py-3 px-4"><span class="px-2 py-0.5 rounded font-mono font-bold bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300">GET</span></td>
                                    <td class="py-3 px-4 font-mono font-semibold text-slate-900 dark:text-white">/api/v1/peminjamans</td>
                                    <td class="py-3 px-4"><span class="text-amber-600 dark:text-amber-400 font-medium">auth:sanctum</span></td>
                                    <td class="py-3 px-4 text-slate-600 dark:text-slate-300">Riwayat transaksi peminjaman (scoped by user role)</td>
                                    <td class="py-3 px-4 text-right font-mono text-[11px] text-slate-400">200</td>
                                </tr>
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                                    <td class="py-3 px-4"><span class="px-2 py-0.5 rounded font-mono font-bold bg-green-100 text-green-800 dark:bg-green-950 dark:text-green-300">POST</span></td>
                                    <td class="py-3 px-4 font-mono font-semibold text-slate-900 dark:text-white">/api/v1/peminjamans</td>
                                    <td class="py-3 px-4"><span class="text-amber-600 dark:text-amber-400 font-medium">auth:sanctum</span></td>
                                    <td class="py-3 px-4 text-slate-600 dark:text-slate-300">Mengajukan peminjaman & mutasi pengurangan stok</td>
                                    <td class="py-3 px-4 text-right font-mono text-[11px] text-slate-400">201 / 422</td>
                                </tr>
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                                    <td class="py-3 px-4"><span class="px-2 py-0.5 rounded font-mono font-bold bg-purple-100 text-purple-800 dark:bg-purple-950 dark:text-purple-300">PATCH</span></td>
                                    <td class="py-3 px-4 font-mono font-semibold text-slate-900 dark:text-white">/api/v1/peminjamans/{id}/status</td>
                                    <td class="py-3 px-4"><span class="text-rose-600 dark:text-rose-400 font-medium">role:admin</span></td>
                                    <td class="py-3 px-4 text-slate-600 dark:text-slate-300">Update status (`selesai`/`ditolak` merestorasi stok)</td>
                                    <td class="py-3 px-4 text-right font-mono text-[11px] text-slate-400">200</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Contoh Permintaan cURL -->
            <section class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <span>🚀</span> Uji Coba Langsung Melalui Terminal (cURL)
                    </h3>
                    <span class="text-xs text-slate-500 font-mono">Bash / PowerShell</span>
                </div>
                <div class="p-4 rounded-xl bg-slate-950 text-slate-200 font-mono text-xs overflow-x-auto leading-relaxed border border-slate-800">
# 1. Login untuk mendapatkan Token Bearer
curl -X POST http://localhost:8000/api/v1/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"mahasiswa@kampus.ac.id", "password":"password123"}'

# 2. Mengambil katalog alat laboratorium
curl -X GET http://localhost:8000/api/v1/alats \
  -H "Accept: application/json"
                </div>
            </section>

        </main>

        <!-- Footer -->
        <footer class="border-t border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 py-6 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500 dark:text-slate-400">
                <div>
                    <strong>LabPinjam API</strong> — Proyek Studi Kasus Pembelajaran RESTful API Laravel & Arsitektur MVC.
                </div>
                <div class="flex items-center gap-4">
                    <span>Dokumentasi: <a href="{{ url('/api/v1/alats') }}" class="text-emerald-600 dark:text-emerald-400 hover:underline">openapi.yaml</a></span>
                    <span>•</span>
                    <span>Lisensi: MIT</span>
                </div>
            </div>
        </footer>

    </body>
</html>
