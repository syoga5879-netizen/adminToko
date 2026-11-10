<?php

namespace App\Http\Controllers;

use App\Models\BookCategory;
use Illuminate\Http\Request;

class BookCategoryController extends Controller
{
    public function index()
    {
        return response()->json(BookCategory::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = BookCategory::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $category
        ], 201);
    }
}