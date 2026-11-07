<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\JenisAduan;
use App\Models\Aduan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat data dummy User
        $user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password123'),
        ]);

        // 2. Buat data awal Jenis Aduan
        $jenisTeknis = JenisAduan::create(['nama_jenis' => 'Kendala Teknis']);
        $jenisLayanan = JenisAduan::create(['nama_jenis' => 'Pelayanan']);
        $jenisPengiriman = JenisAduan::create(['nama_jenis' => 'Pengiriman Barang']);

        // 3. Buat 1 contoh data Aduan awal
        Aduan::create([
            'user_id' => $user->id,
            'jenis_aduan_id' => $jenisTeknis->jenis_aduan_id,
            'prioritas' => 'high',
            'teks' => 'Aplikasi sering force close saat membuka halaman pembayaran.',
        ]);
    }
}