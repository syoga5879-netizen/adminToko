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
        'book_category_id', // Pastikan bernama book_category_id
        'cover_img',
        'synopsis',
    ];

    public function bookCategory()
    {
        return $this->belongsTo(BookCategory::class, 'book_category_id', 'book_category_id');
    }
}