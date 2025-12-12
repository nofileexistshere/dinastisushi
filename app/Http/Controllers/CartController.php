<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $items = [];
        $total = 0;

        if (!empty($cart)) {
            $menuItems = MenuItem::whereIn('id', array_keys($cart))->get();
            foreach ($menuItems as $menuItem) {
                $qty = $cart[$menuItem->id]['quantity'] ?? 0;
                $lineTotal = $menuItem->price * $qty;
                $total += $lineTotal;
                $items[] = [
                    'model' => $menuItem,
                    'quantity' => $qty,
                    'total_price' => $lineTotal,
                ];
            }
        }

        $cartCount = array_sum(array_column($cart, 'quantity'));

        return view('cart.index', compact('items', 'total', 'cartCount'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $menuItem = MenuItem::findOrFail($request->menu_item_id);

        $cart = $request->session()->get('cart', []);
        if (isset($cart[$menuItem->id])) {
            $cart[$menuItem->id]['quantity'] += $request->quantity;
        } else {
            $cart[$menuItem->id] = [
                'quantity' => $request->quantity,
            ];
        }

        $request->session()->put('cart', $cart);

        return back()->with('success', 'Menu berhasil dimasukkan ke keranjang!');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|integer',
        ]);

        $cart = $request->session()->get('cart', []);
        unset($cart[$request->menu_item_id]);
        $request->session()->put('cart', $cart);

        return back()->with('success', 'Menu dihapus dari keranjang.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$request->menu_item_id])) {
            $cart[$request->menu_item_id]['quantity'] = $request->quantity;
            $request->session()->put('cart', $cart);
        }

        return back()->with('success', 'Jumlah pesanan diperbarui.');
    }

    public function clear(Request $request)
    {
        $request->session()->forget('cart');

        return back()->with('success', 'Semua item di keranjang telah dihapus.');
    }
}
