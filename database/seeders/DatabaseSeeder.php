<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\JenisAduan;
use App\Models\Aduan;
use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tambahkan kategori khusus buku perpustakaan
        BookCategory::firstOrCreate(['name' => 'Teknologi & Pemrograman']);
        BookCategory::firstOrCreate(['name' => 'Sains & Matematika']);
        BookCategory::firstOrCreate(['name' => 'Novel & Sastra']);
        BookCategory::firstOrCreate(['name' => 'Sejarah & Budaya']);
        BookCategory::firstOrCreate(['name' => 'Elektronik']);
        BookCategory::firstOrCreate(['name' => 'Fashion']);
        BookCategory::firstOrCreate(['name' => 'Makanan & Minuman']);
        BookCategory::firstOrCreate(['name' => 'Olahraga']);

        // 1. Panggil CategorySeeder bawaan proyek Anda (mengisi tabel categories)
        if (Category::count() === 0) {
            $this->call([
                CategorySeeder::class,
            ]);
        }

        // 2. Buat data dummy User (pakai firstOrCreate agar tidak error duplikat email)
        $user = User::firstOrCreate(
            ['email' => 'budi@example.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password123'),
            ]
        );

        // 3. Buat data awal Jenis Aduan
        $jenisTeknis = JenisAduan::firstOrCreate(['nama_jenis' => 'Kendala Teknis']);
        JenisAduan::firstOrCreate(['nama_jenis' => 'Pelayanan']);
        JenisAduan::firstOrCreate(['nama_jenis' => 'Pengiriman Barang']);

        // 4. Ambil data pertama dari tabel categories
        $kategori = Category::first();

        // 5. Buat 1 contoh data Aduan awal (lengkap dengan category_id)
        if ($kategori) {
            Aduan::create([
                'user_id' => $user->id,
                'jenis_aduan_id' => $jenisTeknis->jenis_aduan_id,
                'category_id' => $kategori->category_id,
                'prioritas' => 'high',
                'teks' => 'Aplikasi sering force close saat membuka halaman pembayaran.',
            ]);
        }

        // 6. Data awal buku perpustakaan (menggunakan BookCategory & book_category_id)
        $buku = [
            ['Belajar Laravel untuk Pemula', 'Taylor Otwell', 'Informatika', 2024, '978-602-0001-01-1', 5, 'Elektronik'],
            ['Pemrograman Web dengan React', 'Dan Abramov', 'Andi Publisher', 2023, '978-602-0001-02-8', 4, 'Elektronik'],
            ['Basis Data MySQL', 'Michael Widenius', 'Erlangga', 2022, '978-602-0001-03-5', 3, 'Elektronik'],
            ['Desain dan Busana Modern', 'Anne Fashion', 'Gramedia', 2021, '978-602-0001-04-2', 2, 'Fashion'],
            ['Tren Fashion Indonesia', 'Dian Sastro', 'Kompas', 2020, '978-602-0001-05-9', 6, 'Fashion'],
            ['Resep Masakan Nusantara', 'Sisca Soewitomo', 'Gramedia', 2019, '978-602-0001-06-6', 7, 'Makanan & Minuman'],
            ['Kopi dan Teh Indonesia', 'Budi Kopi', 'Elex Media', 2022, '978-602-0001-07-3', 3, 'Makanan & Minuman'],
            ['Dasar-Dasar Atletik', 'Lalu Zohri', 'Erlangga', 2023, '978-602-0001-08-0', 4, 'Olahraga'],
        ];

        foreach ($buku as [$judul, $penulis, $penerbit, $tahun, $isbn, $stok, $namaKategori]) {
            // Diubah mencari dari BookCategory dan kolom 'name'
            $bookCategoryId = BookCategory::where('name', $namaKategori)->value('book_category_id');

            if ($bookCategoryId) {
                Book::firstOrCreate(
                    ['isbn' => $isbn],
                    [
                        'title' => $judul,
                        'author' => $penulis,
                        'publisher' => $penerbit,
                        'publication_year' => $tahun,
                        'stock' => $stok,
                        'book_category_id' => $bookCategoryId, // Menggunakan book_category_id
                        'synopsis' => 'Buku ' . $judul . ' karya ' . $penulis . '.',
                    ]
                );
            }
        }
    }
}