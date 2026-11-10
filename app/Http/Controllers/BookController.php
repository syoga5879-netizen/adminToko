<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('bookCategory');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('book_category_id')) {
            $query->where('book_category_id', $request->book_category_id);
        }

        $books = $query->latest()->paginate(5);

        return response()->json($books, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'author'           => 'required|string|max:255',
            'publisher'        => 'required|string|max:255',
            'publication_year' => 'required|digits:4|integer',
            'isbn'             => 'required|string|unique:perpustakaan_books,isbn',
            'stock'            => 'required|integer|min:1',
            'book_category_id' => 'required|exists:book_categories,book_category_id',
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
            'data'    => $book->load('bookCategory')
        ], 201);
    }

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