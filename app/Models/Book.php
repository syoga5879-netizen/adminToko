<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'perpustakaan_books';
    protected $primaryKey = 'book_id';

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'publication_year',
        'isbn',
        'stock',
        'category_id',
        'cover_img',
        'synopsis',
    ];

    // Relasi ke tabel categories
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}