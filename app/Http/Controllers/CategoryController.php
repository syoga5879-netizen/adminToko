<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan semua data categories
    public function index()
    {
       

        return response()->json([
            'status' => 'success',
            'data' => \App\Models\Category::all()
        ], 200);
    }

    // Menambahkan category baru dari Postman
    public function store(Request $request)
{
    $validated = $request->validate([
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string',
        'category_id' => 'required|exists:categories,category_id',
        'price'       => 'required|numeric',
        'img'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Jika ada upload gambar
    if ($request->hasFile('img')) {
        $validated['img'] = $request->file('img')->store('products', 'public');
    }

    // Jika menggunakan slug otomatis
    $validated['slug'] = \Illuminate\Support\Str::slug($request->name);

    $product = \App\Models\Product::create($validated);

    return response()->json([
        'status'  => 'success',
        'message' => 'Produk berhasil ditambahkan',
        'data'    => $product->load('category')
    ], 201);
}
}