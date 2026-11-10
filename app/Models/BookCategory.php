<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
    protected $table = 'book_categories';
    protected $primaryKey = 'book_category_id';

    protected $fillable = [
        'name',
        'description',
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'book_category_id', 'book_category_id');
    }
}