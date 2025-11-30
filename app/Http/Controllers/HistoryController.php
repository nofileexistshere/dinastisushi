<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Rating;

class HistoryController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $sortBy = $request->get('sort', 'date');
        
        // Get user statistics
        $totalOrders = Order::where('user_id', $user->id)->count();
        $totalSpent = Order::where('user_id', $user->id)->sum('total_price');
        $averageRating = Rating::where('user_id', $user->id)->avg('rating');
        
        // Get orders with ratings
        $ordersQuery = Order::with(['menuItem', 'menuItem.ratings' => function($query) use ($user) {
            $query->where('user_id', $user->id);
        }])
        ->where('user_id', $user->id);
        
        if ($sortBy === 'rating') {
            $ordersQuery->join('ratings', function($join) use ($user) {
                $join->on('orders.menu_item_id', '=', 'ratings.menu_item_id')
                     ->where('ratings.user_id', '=', $user->id);
            })->orderBy('ratings.rating', 'desc');
        } else {
            $ordersQuery->orderBy('created_at', 'desc');
        }
        
        $orders = $ordersQuery->get();
        
        return view('history.index', compact('orders', 'totalOrders', 'totalSpent', 'averageRating', 'sortBy'));
    }
}
