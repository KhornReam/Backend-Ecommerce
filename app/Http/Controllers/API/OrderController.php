<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class OrderController extends Controller
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

    public function checkout(Request $request)
    {
        $userId = $this->getUserId($request);
        if (!$userId) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $cartItems = Cart::with('product:id,name,price,stock')
            ->where('user_id', $userId)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return response()->json([
                    'message' => "Insufficient stock for {$item->product->name}"
                ], 400);
            }
        }

        $order = Order::create([
            'user_id' => $userId,
            'total' => 0,
            'status' => 'pending',
        ]);

        $total = 0;

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);

            $item->product->decrement('stock', $item->quantity);

            $total += $item->product->price * $item->quantity;
        }

        $order->update(['total' => $total]);
        Cart::where('user_id', $userId)->delete();

        // Return order without circular references
        return response()->json([
            'message' => 'Order placed successfully',
            'order' => [
                'id' => $order->id,
                'user_id' => $order->user_id,
                'total' => $order->total,
                'status' => $order->status,
                'created_at' => $order->created_at,
                'items' => $order->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'product' => $item->product ? [
                            'id' => $item->product->id,
                            'name' => $item->product->name,
                            'price' => $item->product->price,
                            'image' => $item->product->image,
                        ] : null,
                    ];
                }),
            ]
        ], 201);
    }

    public function index(Request $request)
    {
        $userId = $this->getUserId($request);
        if (!$userId) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        
        $orders = Order::with(['items:id,order_id,product_id,quantity,price'])
            ->where('user_id', $userId)
            ->latest()
            ->paginate(10);

        return response()->json([
            'data' => $orders
        ]);
    }

    public function show(Request $request, $id)
    {
        $userId = $this->getUserId($request);
        if (!$userId) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        
        $order = Order::with(['items:id,order_id,product_id,quantity,price', 'items.product:id,name,price,image'])
            ->where('user_id', $userId)
            ->findOrFail($id);

        return response()->json([
            'data' => [
                'id' => $order->id,
                'user_id' => $order->user_id,
                'total' => $order->total,
                'status' => $order->status,
                'created_at' => $order->created_at,
                'items' => $order->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'product' => $item->product ? [
                            'id' => $item->product->id,
                            'name' => $item->product->name,
                            'price' => $item->product->price,
                            'image' => $item->product->image,
                        ] : null,
                    ];
                }),
            ]
        ]);
    }
}