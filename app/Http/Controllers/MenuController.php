<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MenuItem;
use App\Models\Order;

class MenuController extends Controller
{

    public function index(Request $request)
    {
        $category = $request->get('category', 'Semua');
        $search = $request->get('search', '');
        
        // Recommendations Logic
        $recommendations = collect();
        
        if ($category === 'Semua') {
            // Global Recommendations (Top 1 from each category)
            $categories = ['Sushi Roll', 'Nigiri & Sashimi', 'Ramen & Udon', 'Snack & Dessert', 'Rice', 'Party', 'Beverages'];
            
            foreach ($categories as $cat) {
                $bestItem = MenuItem::where('category', $cat)
                    ->withCount('orders')
                    ->orderByDesc('orders_count')
                    ->orderByDesc('average_rating')
                    ->first();
                    
                if ($bestItem) {
                    $recommendations->push($bestItem);
                }
            }
        } else {
            // Specific Category Recommendations (Top 3 from this category)
            $recommendations = MenuItem::where('category', $category)
                ->withCount('orders')
                ->orderByDesc('orders_count')
                ->orderByDesc('average_rating')
                ->take(3)
                ->get();
        }

        $query = MenuItem::withCount('orders');
        
        if ($category !== 'Semua') {
            $query->where('category', $category);
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Return collection instead of paginator if grouping is needed easily, 
        // or just get() as before.
        $menuItems = $query->orderBy('category')->orderBy('name')->get();
        
        // Get user's ordered menu item IDs (for logged in user)
        $orderedMenuIds = Order::where('user_id', Auth::id())
            ->pluck('menu_item_id')
            ->unique()
            ->toArray();

        // Guest cart count from session
        $cart = $request->session()->get('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));
        
        return view('menu.index', compact('menuItems', 'category', 'search', 'orderedMenuIds', 'cartCount', 'recommendations'));
    }

    public function show(Request $request, $id)
    {
        $menuItem = MenuItem::with('ratings')->findOrFail($id);
        
        // Get similar users count (users who also rated this item)
        $similarUsersCount = Order::where('menu_item_id', $id)
            ->where('user_id', '!=', Auth::id())
            ->distinct('user_id')
            ->count();
        
        // Guest cart count from session
        $cart = $request->session()->get('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));

        return view('menu.show', compact('menuItem', 'similarUsersCount', 'cartCount'));
    }
}
