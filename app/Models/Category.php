<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_id';

    protected $fillable = [
        'name', // Sesuaikan jika nama kolom di migration Anda berbeda (misal: 'nama_kategori')
    ];

    // Relasi ke tabel products
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    // Relasi ke tabel aduans (jika jenis_aduan berelasi ke tabel categories)
    public function aduans()
    {
        return $this->hasMany(Aduan::class, 'jenis_aduan_id', 'category_id');
    }
}