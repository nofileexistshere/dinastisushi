<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_price');
        $totalMenuItems = MenuItem::count();
        $totalUsers = User::where('is_admin', false)->count();
        
        $recentOrders = Order::with(['user', 'menuItem'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $topMenuItems = MenuItem::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->limit(5)
            ->get();
        
        $dailyRevenue = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();
        
        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalMenuItems',
            'totalUsers',
            'recentOrders',
            'topMenuItems',
            'dailyRevenue'
        ));
    }
}
