<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product.category')
            ->where('user_id', auth()->id())
            ->get();

        return response()->json([
            'data' => $cartItems
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return response()->json([
                'message' => 'Insufficient stock'
            ], 400);
        }

        $existing = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            $newQuantity = $existing->quantity + $request->quantity;
            if ($product->stock < $newQuantity) {
                return response()->json([
                    'message' => 'Insufficient stock'
                ], 400);
            }
            $existing->update(['quantity' => $newQuantity]);
            $existing->load('product.category');
            return response()->json($existing);
        }

        $cartItem = Cart::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        $cartItem->load('product.category');

        return response()->json($cartItem, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        $product = Product::findOrFail($cartItem->product_id);

        if ($product->stock < $request->quantity) {
            return response()->json([
                'message' => 'Insufficient stock'
            ], 400);
        }

        $cartItem->update(['quantity' => $request->quantity]);
        $cartItem->load('product.category');

        return response()->json($cartItem);
    }

    public function destroy($id)
    {
        Cart::where('user_id', auth()->id())->where('id', $id)->delete();

        return response()->json(['message' => 'Removed from cart']);
    }
}