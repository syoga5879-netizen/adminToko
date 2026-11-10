<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Buat tabel kategori khusus buku perpustakaan
        Schema::create('book_categories', function (Blueprint $table) {
            $table->id('book_category_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // 2. Buat tabel buku perpustakaan yang berelasi ke book_categories
        Schema::create('perpustakaan_books', function (Blueprint $table) {
            $table->id('book_id');
            $table->string('title');
            $table->string('author');
            $table->string('publisher');
            $table->year('publication_year');
            $table->string('isbn')->unique();
            $table->integer('stock')->default(1);
            // Foreign Key mengarah ke tabel book_categories
            $table->foreignId('book_category_id')
                  ->constrained('book_categories', 'book_category_id')
                  ->onDelete('cascade');
            $table->string('cover_img')->nullable();
            $table->text('synopsis')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perpustakaan_books');
        Schema::dropIfExists('book_categories');
    }
};