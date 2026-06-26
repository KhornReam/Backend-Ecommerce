<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = Cache::remember('dashboard.stats', 60, function () {
            return [
                'totalProducts' => Product::count(),
                'totalOrders' => Order::count(),
                'totalUsers' => User::where('role', 'user')->count(),
                'totalRevenue' => Order::where('status', 'delivered')->sum('total'),
                'pendingOrders' => Order::where('status', 'pending')->count(),
                'lowStockProducts' => Product::where('stock', '<', 10)->count(),
            ];
        });

        $recentOrders = Cache::remember('dashboard.recent_orders', 60, function () {
            return Order::with('user:id,name,email')
                ->select('id', 'user_id', 'total', 'status', 'created_at')
                ->latest()
                ->take(5)
                ->get();
        });

        $chartData = Cache::remember('dashboard.chart_data', 60, function () {
            $startDate = now()->subDays(6)->format('Y-m-d');
            $endDate = now()->format('Y-m-d');

            $ordersLast7Days = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('count', 'date')
                ->toArray();

            $revenueLast7Days = Order::where('status', 'delivered')
                ->selectRaw('DATE(created_at) as date, SUM(total) as total')
                ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('total', 'date')
                ->toArray();

            $statusData = Order::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();

            $chartLabels = [];
            $chartData = [];
            $revenueLabels = [];
            $revenueData = [];

            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $label = now()->subDays($i)->format('M d');
                $chartLabels[] = $label;
                $chartData[] = $ordersLast7Days[$date] ?? 0;
                $revenueLabels[] = $label;
                $revenueData[] = isset($revenueLast7Days[$date]) ? (float)$revenueLast7Days[$date] : 0;
            }

            return [
                'chartLabels' => $chartLabels,
                'chartData' => $chartData,
                'revenueLabels' => $revenueLabels,
                'revenueData' => $revenueData,
                'statusData' => $statusData,
            ];
        });

        return view('admin.dashboard.index', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'chartLabels' => $chartData['chartLabels'],
            'chartData' => $chartData['chartData'],
            'revenueLabels' => $chartData['revenueLabels'],
            'revenueData' => $chartData['revenueData'],
            'statusData' => $chartData['statusData'],
        ]);
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