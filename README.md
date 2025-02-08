## Deskripsi

Ayumee_Website adalah sebuah platform e-commerce berbasis PHP yang memungkinkan administrator untuk mengelola produk, termasuk menambah, mengedit, dan menghapus produk menggunakan sistem berbasis database.

## Fitur

CRUD Produk: Tambah, edit, hapus, dan lihat produk.

Upload Gambar Produk: Menyimpan gambar produk di folder tertentu.

Autentikasi Admin: Hanya admin yang dapat mengelola produk.

Database dengan PDO: Menggunakan PDO untuk koneksi database yang lebih aman.

## Teknologi yang Digunakan

Backend: PHP (dengan PDO untuk koneksi database)

Frontend: HTML, CSS

Database: MySQL

Framework: Tidak menggunakan framework (PHP Native)

Server: XAMPP atau Apache

## Struktur Direktori

Ayumee_Website/
│── admin/
│   │── add_product.php
│   │── edit_product.php
│   │── delete_product.php
│   │── products.php
│
│── includes/
│   │── config.php  (Koneksi database dengan PDO)
│   │── header.php  (Header yang digunakan di setiap halaman admin)
│
│── uploads/
│   │── (Folder penyimpanan gambar produk)
│
│── index.php  (Landing page utama)
│── README.md  (Dokumentasi proyek)

## Instalasi

Clone repository ini atau unduh sebagai ZIP.

Pindahkan folder Ayumee_Website ke dalam direktori XAMPP (htdocs).

Buat database di phpMyAdmin dengan nama ayumee_db.

Import file SQL yang berisi struktur tabel.

Konfigurasi database di includes/config.php:

$host = 'localhost';
$dbname = 'ayumee_db';
$username = 'root';
$password = '';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

Jalankan server XAMPP dan buka http://localhost/ayumee_website/admin/products.php di browser.

## Cara Penggunaan

Login sebagai Admin (jika ada sistem login).

Menambahkan Produk:

Pergi ke add_product.php.

Isi formulir dengan ID produk (varchar), nama, harga, stok, dan gambar.

Klik submit.

Mengedit Produk:

Pilih produk dan klik Edit.

Ubah informasi produk yang diinginkan.

Simpan perubahan.

Menghapus Produk:

Klik Delete pada produk yang ingin dihapus.

Melihat Produk:

Semua produk tersedia di halaman products.php.

Catatan

Gambar produk disimpan di folder uploads/.

Saat menambah produk, ID harus berupa varchar, bukan angka.

Jika ingin kembali ke halaman produk setelah mengisi form, pastikan ada redirect:

header('Location: products.php');

## Kontributor

Lavie Nies - Developer

## Lisensi

Proyek ini bersifat open-source dan bebas digunakan dengan menyertakan atribusi kepada pengembang.