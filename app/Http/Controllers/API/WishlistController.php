<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class WishlistController extends Controller
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
        
        return response()->json([
            'data' => Wishlist::with('product:id,name,price,image')
                ->where('user_id', $userId)
                ->get()
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
        ]);

        $existing = Wishlist::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Already in wishlist'], 400);
        }

        $wishlist = Wishlist::create([
            'user_id' => $userId,
            'product_id' => $request->product_id,
        ]);

        $wishlist->load('product:id,name,price,image');

        return response()->json($wishlist, 201);
    }

    public function destroy(Request $request, $id)
    {
        $userId = $this->getUserId($request);
        if (!$userId) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        Wishlist::where('user_id', $userId)->where('id', $id)->delete();

        return response()->json(['message' => 'Removed from wishlist']);
    }
}