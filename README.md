<div align="center">

<img src="public/videos/nesyel_logos.gif" width="600" alt="NESYEL CLARITE Logo">

# ✨ NESYÈL CLARITÉ — POS System

**a point of sale system built for beauty stores. clean, elegant, it just works.**

[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat-square&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![License](https://img.shields.io/badge/License-MIT-d4af37?style=flat-square)](LICENSE)

</div>

---

## 🎓 Informasi Proyek (Tugas Sekolah)

> **Tugas Aplikasi POS (Point of Sale)** <br>
> Repositori ini dibuat untuk memenuhi tugas mata pelajaran produktif.

- **Judul Proyek:** LAPORAN DOKUMENTASI APLIKASI - NESYÈL CLARITÉ POS System
- **Nama Pengembang:** Nesya Kirani Nurroffi (Absen 27)
- **Kelas / Program Keahlian:** XI PPLG-RPL 2 / Pengembangan Perangkat Lunak & Gim (PPLG)
- **Kepala Program Keahlian:** Pak Yaqub Hadi Permana
- **Link Repository:** [github.com/nsyakiraninurroffi/nesyel-clarite-pos](https://github.com/nsyakiraninurroffi/nesyel-clarite-pos)

---

## 🌸 about this project

**NESYÈL CLARITÉ** adalah sistem Point of Sale (POS) berbasis web yang dirancang khusus untuk toko skincare & makeup. dibangun dengan Laravel 12, sistem ini menggabungkan estetika modern dengan fungsionalitas kasir yang lengkap — dari manajemen produk, kasir real-time, laporan pendapatan harian, hingga dashboard analitik dengan grafik interaktif.

> *"not just a cashier app. it's the vibe your beauty store deserves."*

---

## 🚀 core features

| Fitur | Deskripsi |
|---|---|
| 🔐 **Auth System** | Login, Register, Forgot Password — protected routes |
| 📊 **Dashboard** | Statistik harian, grafik 7 hari, top produk, pie chart kategori |
| 🛍️ **Kasir (POS)** | Cart interaktif, search + filter, proses transaksi real-time |
| 📦 **Manajemen Produk** | CRUD produk lengkap dengan upload gambar |
| 🧾 **Riwayat Transaksi** | History semua transaksi + detail struk per transaksi |
| 🖨️ **Print Struk** | Cetak struk kasir langsung dari browser |
| 📈 **Laporan Harian** | Filter laporan pendapatan per hari/bulan + grafik bar chart |
| 📥 **Export Excel** | Export data laporan ke format native `.xls` |
| 👤 **Profile Admin** | Edit nama, email, dan ganti password |
| 🌙 **Dark Mode** | Toggle light/dark mode, persistent via localStorage |

---

## 🛠️ tech stack

```
Backend   → Laravel 12, PHP 8.2
Frontend  → Blade Templating, Bootstrap 5.3, Vanilla JS
Charts    → Chart.js (Line, Doughnut, Bar)
Alerts    → SweetAlert2
Icons     → Font Awesome 6
Fonts     → Poppins + Playfair Display (Google Fonts)
Database  → MySQL
```

---

## ⚡ quick start

### prerequisites
- PHP `>= 8.2`
- Composer
- Node.js & NPM
- MySQL

### installation

```bash
# 1. clone the repo
git clone https://github.com/nsyakiraninurroffi/nesyel-clarite-pos.git
cd nesyel-clarite-pos

# 2. install dependencies
composer install
npm install

# 3. setup environment
cp .env.example .env
php artisan key:generate

# 4. configure database di .env
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

# 5. migrate database
php artisan migrate

# 6. run the app
php artisan serve
# open http://localhost:8000
```

---

## 📸 screenshots & documentation

> *Laporan Dokumentasi Aplikasi lengkap (PDF) beserta screenshot dari seluruh modul telah disusun dan tersedia untuk proses penilaian.*

---

## 🎨 design system

- **Color Palette**: Pink `#f8a1c4` · Purple `#a18cd1` · Gold `#d4af37`
- **Typography**: Playfair Display (headings) + Poppins (body)
- **UI Style**: Glassmorphism navbar · Soft card shadows · Smooth animations
- **Dark Mode**: Deep purple/mocha palette

---

## 📄 license

Distributed under the MIT License. See `LICENSE` for more information.

---

<div align="center">

Heartcrafted for those who adore beauty & technology.

*© 2026 Nesya Kirani Nurroffi. All rights reserved.*

</div>
