<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\Rating;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk checkout.');
        }

        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $menuItems = MenuItem::whereIn('id', array_keys($cart))->get();
        
        foreach ($menuItems as $menuItem) {
            if (isset($cart[$menuItem->id])) {
                $quantity = $cart[$menuItem->id]['quantity'];
                Order::create([
                    'user_id' => Auth::id(),
                    'menu_item_id' => $menuItem->id,
                    'quantity' => $quantity,
                    'total_price' => $menuItem->price * $quantity,
                ]);
            }
        }

        $request->session()->forget('cart');

        return redirect()->route('history.index')->with('success', 'Pesanan berhasil! Jangan lupa kasih rating ya!');
    }

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
