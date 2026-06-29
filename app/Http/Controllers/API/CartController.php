<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    protected function getUserId(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return null;
        }
        
        $accessToken = PersonalAccessToken::findToken($token);
        return $accessToken?->tokenable_id;
    }

    public function index(Request $request)
    {
        $userId = $this->getUserId($request);
        if (!$userId) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        
        // Load cart items with product relationship
        $cartItems = Cart::where('user_id', $userId)
            ->with(['product:id,name,price,image'])
            ->get();

        return response()->json([
            'data' => $cartItems
        ]);
    }

    public function store(Request $request)
    {
        $userId = $this->getUserId($request);
        if (!$userId) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

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

        $existing = Cart::where('user_id', $userId)
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
            $existing->load('product:id,name,price,image');
            return response()->json($existing);
        }

        $cartItem = Cart::create([
            'user_id' => $userId,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        $cartItem->load('product:id,name,price,image');

        return response()->json($cartItem, 201);
    }

    public function update(Request $request, $id)
    {
        $userId = $this->getUserId($request);
        if (!$userId) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('user_id', $userId)
            ->where('id', $id)
            ->firstOrFail();

        $product = Product::findOrFail($cartItem->product_id);

        if ($product->stock < $request->quantity) {
            return response()->json([
                'message' => 'Insufficient stock'
            ], 400);
        }

        $cartItem->update(['quantity' => $request->quantity]);
        $cartItem->load('product:id,name,price,image');

        return response()->json($cartItem);
    }

    public function destroy(Request $request, $id)
    {
        $userId = $this->getUserId($request);
        if (!$userId) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        Cart::where('user_id', $userId)->where('id', $id)->delete();

        return response()->json(['message' => 'Removed from cart']);
    }
}