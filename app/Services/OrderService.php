<?php

namespace App\Services;

use App\Models\Order;
use App\Models\MenuItem;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Service class for handling order operations
 * 
 * @package App\Services
 */
class OrderService
{
    /**
     * Process checkout from cart
     *
     * @param array $cart
     * @return void
     * @throws \Exception
     */
    public function processCheckout(array $cart): void
    {
        if (empty($cart)) {
            throw new \Exception('Cart is empty');
        }

        DB::beginTransaction();
        
        try {
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
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Create a single order
     *
     * @param int $menuItemId
     * @param int $quantity
     * @return Order
     */
    public function createOrder(int $menuItemId, int $quantity): Order
    {
        $menuItem = MenuItem::findOrFail($menuItemId);
        
        return Order::create([
            'user_id' => Auth::id(),
            'menu_item_id' => $menuItemId,
            'quantity' => $quantity,
            'total_price' => $menuItem->price * $quantity,
        ]);
    }

    /**
     * Rate a menu item
     *
     * @param int $orderId
     * @param int $rating
     * @return void
     * @throws \Exception
     */
    public function rateOrder(int $orderId, int $rating): void
    {
        if ($rating < 1 || $rating > 5) {
            throw new \Exception('Invalid rating value');
        }

        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        DB::beginTransaction();
        
        try {
            // Create or update rating
            Rating::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'menu_item_id' => $order->menu_item_id,
                ],
                [
                    'rating' => $rating,
                ]
            );

            // Update menu item's average rating
            $this->updateMenuItemRating($order->menu_item_id);
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update menu item rating statistics
     *
     * @param int $menuItemId
     * @return void
     */
    private function updateMenuItemRating(int $menuItemId): void
    {
        $menuItem = MenuItem::find($menuItemId);
        $ratings = Rating::where('menu_item_id', $menuItemId)->get();
        
        $menuItem->average_rating = $ratings->avg('rating');
        $menuItem->rating_count = $ratings->count();
        $menuItem->save();
    }

    /**
     * Get user's order history
     *
     * @param int $userId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserOrderHistory(int $userId, int $limit = 50)
    {
        return Order::where('user_id', $userId)
            ->with('menuItem')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get order statistics for dashboard
     *
     * @return array
     */
    public function getOrderStatistics(): array
    {
        return [
            'total_orders' => Order::count(),
            'total_revenue' => Order::sum('total_price'),
            'recent_orders' => Order::with(['menuItem', 'user'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get(),
        ];
    }
}
