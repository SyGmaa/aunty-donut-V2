# Aunty Donut E-Commerce 🍩

![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Filament](https://img.shields.io/badge/Filament-3.3-orange?style=for-the-badge&logo=laravel&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-3-4e56a6?style=for-the-badge&logo=livewire&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

**Aunty Donut** adalah platform e-commerce modern yang dirancang khusus untuk penjualan donat, mendukung pembelian satuan maupun paket bundle (seperti Box of 6 atau Box of 12) dengan pilihan varian rasa yang dapat disesuaikan oleh pelanggan.

Aplikasi ini dibangun menggunakan framework **Laravel 10** yang handal, dengan **Filament PHP** sebagai panel admin yang powerful, dan **Livewire** untuk pengalaman frontend yang dinamis tanpa perlu menulis banyak JavaScript kustom.

## ✨ Fitur Utama

### 🛒 Halaman Pengguna (Frontend)

-   **Katalog Produk:** Menampilkan daftar donat satuan dan paket bundle yang tersedia.
-   **Detail Produk Interaktif:**
    -   Informasi detail mengenai produk.
    -   **Pilih Varian (Rasa):** Fitur khusus untuk produk bundle dimana pelanggan dapat memilih kombinasi rasa sesuai keinginan (misal: 2 Coklat, 3 Matcha, 1 Tiramisu untuk Box of 6).
    -   Validasi stok varian secara real-time.
-   **Keranjang Belanja (Cart):** Menyimpan item belanjaan sementara.
-   **Checkout:** Proses penyelesaian pesanan yang mudah.

### 🛠 Panel Admin (Backend)

-   **Dashboard:** Ringkasan performa penjualan dan statistik penting lainnya.
-   **Manajemen Produk (Products):**
    -   CRUD (Create, Read, Update, Delete) produk.
    -   Pengaturan tipe produk (Satuan atau Bundle).
    -   Pengaturan harga dan deskripsi.
-   **Manajemen Varian (Variants):**
    -   Mengelola varian rasa (Coklat, Matcha, Keju, dll).
    -   Manajemen stok per varian rasa.
-   **Manajemen Pesanan (Orders):**
    -   Melihat daftar pesanan masuk.
    -   Detail pesanan termasuk varian rasa yang dipilih pelanggan dalam bundle.
    -   Mengubah status pesanan.

## 🚀 Teknologi yang Digunakan

-   **Backend Framework:** Laravel 10.x
-   **Admin Panel:** FilamentPHP 3.3
-   **Frontend Framework:** Laravel Livewire
-   **Styling:** Tailwind CSS 3.4
-   **Database:** MySQL / PostgreSQL
-   **Language:** PHP 8.1+

## 📋 Prasyarat Sistem

Sebelum menginstall, pastikan sistem Anda telah terinstall:

-   [PHP](https://www.php.net/downloads) >= 8.1
-   [Composer](https://getcomposer.org/)
-   [Node.js](https://nodejs.org/) & NPM

## 🛠 Panduan Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lokal komputer Anda:

1.  **Clone Repository**

    ```bash
    git clone https://github.com/username/aunty-donut.git
    cd aunty-donut
    ```

2.  **Install Dependencies PHP**

    ```bash
    composer install
    ```

3.  **Install Dependencies Frontend**

    ```bash
    npm install
    npm run build
    ```

4.  **Konfigurasi Environment**
    Salin file `.env.example` menjadi `.env`:

    ```bash
    cp .env.example .env
    ```

    Sesuaikan konfigurasi database di dalam file `.env`:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_anda
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Generate App Key**

    ```bash
    php artisan key:generate
    ```

6.  **Migrasi Database & Seeding Data**
    Jalankan perintah ini untuk membuat tabel dan mengisi data dummy (Produk, Varian, dan Admin):

    ```bash
    php artisan migrate --seed
    ```

7.  **Link Storage**
    Agar gambar produk dapat diakses oleh publik, jalankan perintah:

    ```bash
    php artisan storage:link
    ```

8.  **Jalankan Server**
    ```bash
    php artisan serve
    ```
    Aplikasi sekarang dapat diakses di `http://localhost:8000`.

## 👤 Akun Demo

Saat menjalankan perintah `php artisan migrate --seed`, sistem akan membuat akun admin secara otomatis:

-   **Login URL:** `http://localhost:8000/admin`
-   **Email:** `admin@auntydonut.com`
-   **Password:** `password`

## 🤝 Kontribusi

Kontribusi selalu diterima! Jika Anda ingin berkontribusi:

1.  Fork repository ini.
2.  Buat branch fitur baru (`git checkout -b fitur-keren`).
3.  Commit perubahan Anda (`git commit -m 'Menambahkan fitur keren'`).
4.  Push ke branch (`git push origin fitur-keren`).
5.  Buat Pull Request.

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).
