<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AduanController extends Controller
{
    // Menampilkan semua data aduan beserta relasi user & jenis aduannya
    public function index()
    {
        $aduans = Aduan::with(['user', 'jenisAduan'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $aduans
        ], 200);
    }

    // Menambahkan data aduan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis_aduan_id' => 'required|exists:jenis_aduans,jenis_aduan_id',
            'prioritas' => 'required|in:high,middle,low',
            'teks' => 'required|string',
        ]);

        $aduan = Aduan::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Aduan berhasil ditambahkan',
            'data' => $aduan->load(['user', 'jenisAduan'])
        ], 201);
    }

    // Menambahkan user baru (jika ingin test tambah user dari Postman)
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil ditambahkan',
            'data' => $user
        ], 201);
    }
}