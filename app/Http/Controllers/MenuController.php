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
        
        $query = MenuItem::query();
        
        if ($category !== 'Semua') {
            $query->where('category', $category);
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $menuItems = $query->orderBy('category')->orderBy('name')->get();
        
        // Get user's ordered menu item IDs (for logged in user)
        $orderedMenuIds = Order::where('user_id', Auth::id())
            ->pluck('menu_item_id')
            ->unique()
            ->toArray();

        // Guest cart count from session
        $cart = $request->session()->get('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));
        
        return view('menu.index', compact('menuItems', 'category', 'search', 'orderedMenuIds', 'cartCount'));
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
