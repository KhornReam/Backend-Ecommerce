<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Wishlist::with('product.category')
                ->where('user_id', auth()->id())
                ->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $existing = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Already in wishlist'], 400);
        }

        $wishlist = Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
        ]);

        $wishlist->load('product.category');

        return response()->json($wishlist, 201);
    }

    public function destroy($id)
    {
        Wishlist::where('user_id', auth()->id())->where('id', $id)->delete();

        return response()->json(['message' => 'Removed from wishlist']);
    }
}