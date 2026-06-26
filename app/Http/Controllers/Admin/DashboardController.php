<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalProducts' => Product::count(),
            'totalOrders' => Order::count(),
            'totalUsers' => User::where('role', 'user')->count(),
            'totalRevenue' => Order::where('status', 'delivered')->sum('total'),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'lowStockProducts' => Product::where('stock', '<', 10)->count(),
        ];

        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Chart data - orders per day for last 7 days
        $ordersLast7Days = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('M d');
            $found = $ordersLast7Days->firstWhere('date', $date);
            $chartData[] = $found ? $found->count : 0;
        }

        // Revenue chart - last 7 days
        $revenueLast7Days = Order::where('status', 'delivered')
            ->selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $revenueLabels = [];
        $revenueData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $revenueLabels[] = now()->subDays($i)->format('M d');
            $found = $revenueLast7Days->firstWhere('date', $date);
            $revenueData[] = $found ? (float)$found->total : 0;
        }

        // Orders by status
        $statusData = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('admin.dashboard.index', compact(
            'stats', 
            'recentOrders',
            'chartLabels',
            'chartData',
            'revenueLabels',
            'revenueData',
            'statusData'
        ));
    }

    public function apiStats()
    {
        $stats = [
            'totalProducts' => Product::count(),
            'totalOrders' => Order::count(),
            'totalUsers' => User::where('role', 'user')->count(),
            'totalRevenue' => Order::where('status', 'delivered')->sum('total'),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'lowStockProducts' => Product::where('stock', '<', 10)->count(),
        ];

        return response()->json(['data' => $stats]);
    }

    public function apiCharts()
    {
        $ordersLast7Days = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('M d');
            $found = $ordersLast7Days->firstWhere('date', $date);
            $chartData[] = $found ? $found->count : 0;
        }

        $revenueLast7Days = Order::where('status', 'delivered')
            ->selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $revenueLabels = [];
        $revenueData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $revenueLabels[] = now()->subDays($i)->format('M d');
            $found = $revenueLast7Days->firstWhere('date', $date);
            $revenueData[] = $found ? (float)$found->total : 0;
        }

        $statusData = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return response()->json([
            'data' => [
                'ordersChart' => ['labels' => $chartLabels, 'data' => $chartData],
                'revenueChart' => ['labels' => $revenueLabels, 'data' => $revenueData],
                'statusChart' => ['labels' => array_keys($statusData), 'data' => array_values($statusData)],
            ]
        ]);
    }
}