<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderManagementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $dateFilter = $request->get('date', '');
        
        $query = Order::with(['user', 'menuItem']);
        
        if ($search) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('menuItem', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }
        
        if ($dateFilter) {
            $query->whereDate('created_at', $dateFilter);
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(20);
        $totalRevenue = Order::sum('total_price');
        
        return view('admin.orders.index', compact('orders', 'totalRevenue', 'search', 'dateFilter'));
    }
    
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        
        return back()->with('success', 'Pesanan berhasil dihapus.');
    }
}
