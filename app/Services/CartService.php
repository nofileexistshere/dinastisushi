<?php

namespace App\Services;

use App\Models\MenuItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

/**
 * Service class for handling cart operations
 * 
 * @package App\Services
 */
class CartService
{
    /**
     * Get cart items with their details
     *
     * @param array $cart
     * @return Collection
     */
    public function getCartItems(array $cart): Collection
    {
        if (empty($cart)) {
            return collect();
        }

        $menuItems = MenuItem::whereIn('id', array_keys($cart))->get();
        
        return $menuItems->map(function ($menuItem) use ($cart) {
            $quantity = $cart[$menuItem->id]['quantity'] ?? 0;
            
            return [
                'model' => $menuItem,
                'quantity' => $quantity,
                'total_price' => $menuItem->price * $quantity,
            ];
        });
    }

    /**
     * Calculate cart total
     *
     * @param Collection $items
     * @return float
     */
    public function calculateTotal(Collection $items): float
    {
        return $items->sum('total_price');
    }

    /**
     * Get cart count
     *
     * @param array $cart
     * @return int
     */
    public function getCartCount(array $cart): int
    {
        return array_sum(array_column($cart, 'quantity'));
    }

    /**
     * Add item to cart
     *
     * @param int $menuItemId
     * @param int $quantity
     * @return array
     */
    public function addItem(int $menuItemId, int $quantity): array
    {
        $menuItem = MenuItem::findOrFail($menuItemId);
        
        $cart = Session::get('cart', []);
        
        if (isset($cart[$menuItemId])) {
            $cart[$menuItemId]['quantity'] += $quantity;
        } else {
            $cart[$menuItemId] = [
                'quantity' => $quantity,
            ];
        }
        
        Session::put('cart', $cart);
        
        return $cart;
    }

    /**
     * Remove item from cart
     *
     * @param int $menuItemId
     * @return array
     */
    public function removeItem(int $menuItemId): array
    {
        $cart = Session::get('cart', []);
        unset($cart[$menuItemId]);
        Session::put('cart', $cart);
        
        return $cart;
    }

    /**
     * Update item quantity in cart
     *
     * @param int $menuItemId
     * @param int $quantity
     * @return array
     */
    public function updateItem(int $menuItemId, int $quantity): array
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$menuItemId])) {
            $cart[$menuItemId]['quantity'] = $quantity;
            Session::put('cart', $cart);
        }
        
        return $cart;
    }

    /**
     * Clear all items from cart
     *
     * @return void
     */
    public function clearCart(): void
    {
        Session::forget('cart');
    }

    /**
     * Validate menu item exists
     *
     * @param int $menuItemId
     * @return bool
     */
    public function validateMenuItem(int $menuItemId): bool
    {
        return MenuItem::where('id', $menuItemId)->exists();
    }
}
