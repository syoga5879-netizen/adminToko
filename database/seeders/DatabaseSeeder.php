<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\JenisAduan;
use App\Models\Aduan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Panggil CategorySeeder bawaan proyek Anda (mengisi tabel categories)
        $this->call([
            CategorySeeder::class,
        ]);

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
    }
}