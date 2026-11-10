<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // Menampilkan daftar buku + fitur Search + Pagination
    public function index(Request $request)
    {
        $query = Book::with('category');

        // Fitur Pencarian berdasarkan judul, penulis, atau ISBN
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori (opsional)
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Pagination 5 data per halaman
        $books = $query->latest()->paginate(5);

        return response()->json($books, 200);
    }

    // Menyimpan pendaftaran buku baru + Upload File Cover
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'author'           => 'required|string|max:255',
            'publisher'        => 'required|string|max:255',
            'publication_year' => 'required|digits:4|integer',
            'isbn'             => 'required|string|unique:perpustakaan_books,isbn',
            'stock'            => 'required|integer|min:1',
            'category_id'      => 'required|exists:categories,category_id',
            'synopsis'         => 'nullable|string',
            'cover_img'        => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('cover_img')) {
            $validated['cover_img'] = $request->file('cover_img')->store('books', 'public');
        }

        $book = Book::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Buku baru berhasil didaftarkan',
            'data'    => $book->load('category')
        ], 201);
    }

    // Menghapus buku
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        if ($book->cover_img) {
            Storage::disk('public')->delete($book->cover_img);
        }

        $book->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Buku berhasil dihapus'
        ], 200);
    }
}