# Sistem Informasi Key Performance Indicator (KPI) 🚀
**Studi Kasus: PT Multi Data Palembang**

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.x-blue)](https://tailwindcss.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-purple)](https://php.net)

Aplikasi berbasis web ini dirancang untuk mendigitalisasi proses evaluasi kinerja karyawan yang sebelumnya dilakukan secara manual. Sistem ini memungkinkan perhitungan skor kinerja secara otomatis, transparan, dan terstandarisasi berdasarkan indikator dan bobot yang ditetapkan untuk setiap divisi.

Dikembangkan sebagai **Tugas Akhir (Skripsi)** Program Studi Sistem Informasi, Universitas Multi Data Palembang.

---

## ✨ Fitur Utama (Key Features)

* **👥 Role-Based Access Control (RBAC):** Hak akses spesifik untuk Admin (HRD), Manajer Divisi, dan Karyawan.
* **📊 Dashboard Interaktif:** Visualisasi data kinerja menggunakan grafik garis (*Sparkline*) untuk melihat tren kenaikan/penurunan performa antar periode (Q1-Q4).
* **🧮 Auto-Calculation:** Perhitungan otomatis Nilai Akhir berdasarkan rumus: `(Realisasi / Target) × Bobot`.
* **📂 Manajemen KPI:** Pengaturan dinamis untuk Kategori, Indikator, Target, dan Bobot penilaian per divisi.
* **📄 Laporan PDF:** Fitur cetak Rapor Kinerja Karyawan dan Laporan Ranking Divisi secara otomatis (*Export to PDF*).
* **🏆 Leaderboard:** Perankingan karyawan terbaik secara *real-time*.

---

## 🛠️ Teknologi yang Digunakan

* **Backend:** Laravel 10 (PHP Framework)
* **Frontend:** Blade Templates + Tailwind CSS
* **Database:** MySQL
* **Asset Bundler:** Vite
* **Library Pendukung:**
    * `dompdf/dompdf`: Untuk generate laporan PDF.
    * `chart.js` / SVG: Untuk visualisasi grafik.

---

## 💻 Panduan Instalasi (Installation Guide)

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di komputer lokal (*Localhost*).

### 1. Prasyarat Sistem
Pastikan komputer Anda sudah terinstal:
* PHP >= 8.1
* Composer
* Node.js & NPM
* MySQL (via XAMPP/Laragon)

### 2. Clone Repository
Buka terminal (Git Bash / CMD / Terminal VS Code) dan jalankan:
```bash
git clone [https://github.com/username-anda/nama-repo-skripsi.git](https://github.com/username-anda/nama-repo-skripsi.git)
cd nama-repo-skripsi
