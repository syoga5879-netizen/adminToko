<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perpustakaan_books', function (Blueprint $table) {
            $table->id('book_id'); // Primary Key
            $table->string('title');
            $table->string('author');
            $table->string('publisher');
            $table->year('publication_year');
            $table->string('isbn')->unique();
            $table->integer('stock')->default(1);
            // Foreign Key ke tabel categories yang sudah ada
            $table->foreignId('category_id')->constrained('categories', 'category_id')->onDelete('cascade');
            $table->string('cover_img')->nullable(); // Menyimpan file gambar cover buku
            $table->text('synopsis')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perpustakaan_books');
    }
};