# Proyek Berbagi Lokasi

## Deskripsi
Proyek ini adalah aplikasi berbagi lokasi khusus untuk ambulan yang bertujuan untuk meningkatkan efisiensi dan kecepatan dalam merespons keadaan darurat. Aplikasi ini memungkinkan tim ambulan untuk membagikan lokasi mereka secara real-time sebelum berangkat menuju lokasi pasien atau rumah sakit. Dengan fitur ini, pusat kendali dapat memantau pergerakan ambulan, mengoptimalkan rute, dan memberikan panduan yang lebih akurat. Selain itu, aplikasi ini juga membantu koordinasi antar tim ambulan dan memudahkan komunikasi dengan rumah sakit tujuan, sehingga persiapan penanganan pasien dapat dilakukan lebih dini.

## Fitur Utama
1. Berbagi lokasi real-time menggunakan Google Maps API
2. Peta interaktif untuk visualisasi lokasi ambulan dan rute
3. Sistem komentar untuk komunikasi antar pengguna
4. Manajemen pengguna dengan peran admin dan pengguna biasa
5. Pembuatan dan pengeditan posting dengan titik awal dan akhir
6. Tampilan responsif menggunakan Bootstrap
7. Autentikasi pengguna
8. Pagination untuk daftar posting
9. Fitur "Muat Lebih Banyak" untuk posting

## Struktur Proyek
- `app/`: Direktori untuk logika aplikasi (Http/, Models/, Providers/)
- `config/`: File konfigurasi aplikasi
- `database/`: Direktori untuk migrasi dan seed (migrations/, seeders/)
- `public/`: Direktori untuk file publik (css/, js/, images/)
- `resources/`: Direktori untuk tampilan dan aset (views/, lang/, sass/)
- `routes/`: Direktori untuk definisi rute (web.php, api.php)
- `storage/`: Penyimpanan file yang dihasilkan aplikasi
- `tests/`: Direktori untuk file pengujian

## Struktur Database SQL
1. Tabel `users`: id, name, email, password, role, created_at, updated_at
2. Tabel `posts`: id, user_id, title, content, start_point, end_point, created_at, updated_at
3. Tabel `comments`: id, post_id, user_id, content, created_at, updated_at
4. Tabel `ambulances`: id, plate_number, status, created_at, updated_at
5. Tabel `ambulance_assignments`: id, ambulance_id, user_id, start_time, end_time, created_at, updated_at

## Persyaratan
- PHP 7.4+
- Laravel 8.x
- MySQL 5.7+
- Google Maps JavaScript API
- Bootstrap 5

## Instalasi
1. Clone repositori ini
2. Salin `.env.example` ke `.env` dan sesuaikan konfigurasi
3. Jalankan `composer install`
4. Jalankan `php artisan key:generate`
5. Jalankan migrasi dengan `php artisan migrate`

## Penggunaan
1. Jalankan server dengan `php artisan serve`
2. Buka aplikasi di browser
3. Daftar atau masuk ke akun Anda
4. Mulai berbagi lokasi dan berinteraksi dengan pengguna lain

## Kontribusi
Kami menyambut kontribusi! Silakan buat pull request atau laporkan masalah di halaman Issues.

## Lisensi
Proyek ini dilisensikan di bawah MIT License. Lihat file `LICENSE` untuk informasi lebih lanjut.

## Kontak
Untuk pertanyaan atau saran, silakan hubungi [setopratama@gmail.com](mailto:setopratama@gmail.com)
