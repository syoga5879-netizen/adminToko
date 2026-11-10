<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aduan extends Model
{
    // Menentukan primary key karena bukan 'id'
    protected $primaryKey = 'aduan_id';

    // Fields yang boleh diisi massal
   protected $fillable = [
        'user_id',
        'jenis_aduan_id',
        'category_id', // Pastikan baris ini ada
        'prioritas',
        'teks',
    ];

    // Relasi ke tabel users (FK: user_id)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke tabel jenis_aduans (FK: jenis_aduan_id)
    public function jenisAduan()
    {
        return $this->belongsTo(JenisAduan::class, 'jenis_aduan_id');
    }
}