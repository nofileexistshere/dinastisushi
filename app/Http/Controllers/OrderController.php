<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\Rating;

class OrderController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $menuItem = MenuItem::findOrFail($request->menu_item_id);
        
        $order = Order::create([
            'user_id' => Auth::id(),
            'menu_item_id' => $request->menu_item_id,
            'quantity' => $request->quantity,
            'total_price' => $menuItem->price * $request->quantity,
        ]);

        return back()->with('success', 'Pesanan berhasil ditambahkan!');
    }

    public function rate(Request $request, $orderId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Create or update rating
        Rating::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'menu_item_id' => $order->menu_item_id,
            ],
            [
                'rating' => $request->rating,
            ]
        );

        // Update menu item's average rating
        $menuItem = MenuItem::find($order->menu_item_id);
        $ratings = Rating::where('menu_item_id', $order->menu_item_id)->get();
        $menuItem->average_rating = $ratings->avg('rating');
        $menuItem->rating_count = $ratings->count();
        $menuItem->save();

        return back()->with('success', 'Rating berhasil disimpan!');
    }
}
