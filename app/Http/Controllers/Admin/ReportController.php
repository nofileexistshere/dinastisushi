<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\User;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display report index with all 4 reports
     */
    public function index()
    {
        return view('admin.reports.index');
    }

    /**
     * Report 1: Laporan Penjualan (Sales Report)
     */
    public function sales(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $orders = Order::with(['user', 'menuItem'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $orders->sum('total_price');
        $totalOrders = $orders->count();
        $totalItems = $orders->sum('quantity');

        $dailySales = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as revenue'),
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(quantity) as items')
            )
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return view('admin.reports.sales', compact(
            'orders',
            'totalRevenue',
            'totalOrders',
            'totalItems',
            'dailySales',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Report 2: Laporan Menu Terlaris (Top Menu Report)
     */
    public function topMenu(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $topMenuItems = MenuItem::select('menu_items.*')
            ->selectRaw('COALESCE(SUM(orders.quantity), 0) as total_sold')
            ->selectRaw('COALESCE(SUM(orders.total_price), 0) as total_revenue')
            ->selectRaw('COUNT(orders.id) as order_count')
            ->leftJoin('orders', function ($join) use ($startDate, $endDate) {
                $join->on('menu_items.id', '=', 'orders.menu_item_id')
                    ->whereDate('orders.created_at', '>=', $startDate)
                    ->whereDate('orders.created_at', '<=', $endDate);
            })
            ->groupBy('menu_items.id')
            ->orderByDesc('total_sold')
            ->get();

        $categoryStats = MenuItem::select('menu_items.category')
            ->selectRaw('COALESCE(SUM(orders.quantity), 0) as total_sold')
            ->selectRaw('COALESCE(SUM(orders.total_price), 0) as total_revenue')
            ->leftJoin('orders', function ($join) use ($startDate, $endDate) {
                $join->on('menu_items.id', '=', 'orders.menu_item_id')
                    ->whereDate('orders.created_at', '>=', $startDate)
                    ->whereDate('orders.created_at', '<=', $endDate);
            })
            ->groupBy('menu_items.category')
            ->orderByDesc('total_sold')
            ->get();

        return view('admin.reports.top-menu', compact(
            'topMenuItems',
            'categoryStats',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Report 3: Laporan Pengguna (User Report)
     */
    public function users(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $users = User::where('is_admin', false)
            ->withCount(['orders' => function ($query) use ($startDate, $endDate) {
                $query->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate);
            }])
            ->withSum(['orders' => function ($query) use ($startDate, $endDate) {
                $query->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate);
            }], 'total_price')
            ->withCount('ratings')
            ->orderByDesc('orders_sum_total_price')
            ->get();

        $totalUsers = User::where('is_admin', false)->count();
        $activeUsers = $users->where('orders_count', '>', 0)->count();
        $newUsers = User::where('is_admin', false)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->count();

        $topSpenders = $users->take(10);

        return view('admin.reports.users', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'newUsers',
            'topSpenders',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Report 4: Laporan Rating (Rating Report)
     */
    public function ratings(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $ratings = Rating::with(['user', 'menuItem'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRatings = $ratings->count();
        $averageRating = $ratings->avg('rating') ?? 0;

        $ratingDistribution = Rating::select('rating', DB::raw('COUNT(*) as count'))
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get()
            ->pluck('count', 'rating')
            ->toArray();

        $menuRatings = MenuItem::select('menu_items.*')
            ->selectRaw('COALESCE(AVG(ratings.rating), 0) as avg_rating')
            ->selectRaw('COUNT(ratings.id) as rating_count')
            ->leftJoin('ratings', function ($join) use ($startDate, $endDate) {
                $join->on('menu_items.id', '=', 'ratings.menu_item_id')
                    ->whereDate('ratings.created_at', '>=', $startDate)
                    ->whereDate('ratings.created_at', '<=', $endDate);
            })
            ->groupBy('menu_items.id')
            ->orderByDesc('avg_rating')
            ->get();

        return view('admin.reports.ratings', compact(
            'ratings',
            'totalRatings',
            'averageRating',
            'ratingDistribution',
            'menuRatings',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Print/Export report
     */
    public function print(Request $request, $type)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        switch ($type) {
            case 'sales':
                return $this->printSales($startDate, $endDate);
            case 'top-menu':
                return $this->printTopMenu($startDate, $endDate);
            case 'users':
                return $this->printUsers($startDate, $endDate);
            case 'ratings':
                return $this->printRatings($startDate, $endDate);
            default:
                return redirect()->back()->with('error', 'Tipe laporan tidak valid');
        }
    }

    private function printSales($startDate, $endDate)
    {
        $orders = Order::with(['user', 'menuItem'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $orders->sum('total_price');
        $totalOrders = $orders->count();
        $totalItems = $orders->sum('quantity');

        return view('admin.reports.print.sales', compact(
            'orders', 'totalRevenue', 'totalOrders', 'totalItems', 'startDate', 'endDate'
        ));
    }

    private function printTopMenu($startDate, $endDate)
    {
        $topMenuItems = MenuItem::select('menu_items.*')
            ->selectRaw('COALESCE(SUM(orders.quantity), 0) as total_sold')
            ->selectRaw('COALESCE(SUM(orders.total_price), 0) as total_revenue')
            ->leftJoin('orders', function ($join) use ($startDate, $endDate) {
                $join->on('menu_items.id', '=', 'orders.menu_item_id')
                    ->whereDate('orders.created_at', '>=', $startDate)
                    ->whereDate('orders.created_at', '<=', $endDate);
            })
            ->groupBy('menu_items.id')
            ->orderByDesc('total_sold')
            ->get();

        return view('admin.reports.print.top-menu', compact(
            'topMenuItems', 'startDate', 'endDate'
        ));
    }

    private function printUsers($startDate, $endDate)
    {
        $users = User::where('is_admin', false)
            ->withCount(['orders' => function ($query) use ($startDate, $endDate) {
                $query->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate);
            }])
            ->withSum(['orders' => function ($query) use ($startDate, $endDate) {
                $query->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate);
            }], 'total_price')
            ->orderByDesc('orders_sum_total_price')
            ->get();

        return view('admin.reports.print.users', compact(
            'users', 'startDate', 'endDate'
        ));
    }

    private function printRatings($startDate, $endDate)
    {
        $ratings = Rating::with(['user', 'menuItem'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('created_at', 'desc')
            ->get();

        $averageRating = $ratings->avg('rating') ?? 0;

        return view('admin.reports.print.ratings', compact(
            'ratings', 'averageRating', 'startDate', 'endDate'
        ));
    }
}
