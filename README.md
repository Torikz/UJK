# Dokumentasi Aplikasi Klinik (UJK)

## Deskripsi
Aplikasi ini adalah sistem informasi manajemen klinik berbasis **CodeIgniter** yang dikembangkan untuk memenuhi kebutuhan UJK. Sistem ini dirancang untuk memudahkan pengelolaan administrasi pasien, mulai dari pendaftaran hingga proses asesmen medis.

## Fitur Utama
* **Kelola Data Pasien:** Manajemen identitas pasien tetap.
* **Kelola Data Pendaftaran:** Pencatatan registrasi awal kedatangan pasien.
* **Kelola Data Kunjungan:** Penempatan pasien ke unit layanan atau poli spesifik.
* **Kelola Asesmen:** Pencatatan keluhan dan diagnosa medis oleh tenaga kesehatan.
* **Cetak Rekam Medis:** Fitur untuk mencetak dokumen terkait pendaftaran dan hasil pemeriksaan.

## Hak Akses dan Fitur
Sistem menggunakan pembagian peran (Role-Based Access Control) untuk menjaga keamanan data:

### 1. Super Admin
* Memiliki hak akses penuh (**CRUD**) pada seluruh modul (Pasien, Pendaftaran, Kunjungan, dan Asesmen).
* Dapat melakukan pencatatan dan pencetakan data di semua lini.

### 2. Admisi
* Memiliki hak akses **CRUD** dan Cetak pada modul:
    * Pasien.
    * Pendaftaran.
    * Kunjungan (Poli).

### 3. Perawat
* **Akses Penuh (CRUD & Cetak):** Pada modul Pasien dan Asesmen.
* **Akses Terbatas (Hanya Baca & Cetak):** Pada modul Pendaftaran dan Kunjungan (tidak dapat mengubah atau menghapus data).

## Struktur Database
Berikut adalah gambaran tabel utama yang digunakan dalam database `db_klinik`:

* **Tabel users:** Menyimpan data pengguna (id, username, password, role).
* **Tabel pasien:** Menyimpan identitas pasien (id, nama, norm, alamat).
* **Tabel pendaftaran:** Menghubungkan pasien dengan nomor registrasi (id, pasienid, noregistrasi, tglregistrasi).
* **Tabel kunjungan:** Menentukan jenis layanan poli (id, pendaftaranpasienid, jeniskunjungan, tglkunjungan).
* **Tabel asesmen:** Mencatat keluhan medis (id, kunjunganid, keluhan_utama, keluhan_tambahan).

## Cara Menjalankan Aplikasi
Ikuti langkah-langkah berikut untuk menjalankan aplikasi di lingkungan lokal:

1. **Install Dependency**
   Pastikan Anda sudah masuk ke direktori proyek, lalu jalankan:
   ```bash
   composer install
2. ```bash
   php spark serve
3. Akses sistem melalui browser Anda di alamat:
   http://localhost:8080
