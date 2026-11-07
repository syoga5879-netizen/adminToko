<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,product_id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Gabungkan item yang product_id-nya sama
        $items = collect($request->items)
            ->groupBy('product_id')
            ->map(fn ($rows) => $rows->sum('quantity'));

        // Transaksi: jika satu produk stoknya kurang, semua dibatalkan
        $result = DB::transaction(function () use ($items) {
            $sold = [];
            $total = 0;

            foreach ($items as $productId => $quantity) {
                $product = Product::lockForUpdate()->findOrFail($productId);

                if ($product->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'items' => ["Stok {$product->name} tidak mencukupi (tersisa {$product->stock})."],
                    ]);
                }

                $product->decrement('stock', $quantity);
                $total += $product->price * $quantity;
                $sold[] = $product->fresh('category');
            }

            return ['products' => $sold, 'total' => $total];
        });

        return response()->json([
            'message' => 'Checkout berhasil, stok produk diperbarui',
            'total' => (float) $result['total'],
            'data' => ProductResource::collection(collect($result['products'])),
        ]);
    }
}