<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

/**
 * Cart Controller
 * 
 * Handles all cart-related operations including adding, removing, and updating items
 */
class CartController extends Controller
{
    private CartService $cartService;

    /**
     * Constructor
     *
     * @param CartService $cartService
     */
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display the shopping cart
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): \Illuminate\View\View
    {
        try {
            $cart = $request->session()->get('cart', []);
            $items = $this->cartService->getCartItems($cart);
            $total = $this->cartService->calculateTotal($items);
            $cartCount = $this->cartService->getCartCount($cart);

            return view('cart.index', compact('items', 'total', 'cartCount'));
        } catch (\Exception $e) {
            \Log::error('Cart index error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat keranjang.');
        }
    }

    /**
     * Add item to cart
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validate([
                'menu_item_id' => 'required|integer|exists:menu_items,id',
                'quantity' => 'required|integer|min:1|max:10',
            ]);

            $this->cartService->addItem($validated['menu_item_id'], $validated['quantity']);

            return back()->with('success', 'Menu berhasil dimasukkan ke keranjang!');
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->validator())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Add to cart error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menambahkan menu ke keranjang.');
        }
    }

    /**
     * Remove item from cart
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validate([
                'menu_item_id' => 'required|integer',
            ]);

            $this->cartService->removeItem($validated['menu_item_id']);

            return back()->with('success', 'Menu dihapus dari keranjang.');
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->validator())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Remove from cart error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus menu dari keranjang.');
        }
    }

    /**
     * Update item quantity in cart
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validate([
                'menu_item_id' => 'required|integer',
                'quantity' => 'required|integer|min:1|max:10',
            ]);

            $this->cartService->updateItem($validated['menu_item_id'], $validated['quantity']);

            return back()->with('success', 'Jumlah pesanan diperbarui.');
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->validator())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Update cart error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui jumlah pesanan.');
        }
    }

    /**
     * Clear all items from cart
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $this->cartService->clearCart();
            return back()->with('success', 'Semua item di keranjang telah dihapus.');
        } catch (\Exception $e) {
            \Log::error('Clear cart error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengosongkan keranjang.');
        }
    }

    /**
     * Get cart count (AJAX endpoint)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getCartCount(Request $request): JsonResponse
    {
        try {
            $cart = $request->session()->get('cart', []);
            $count = $this->cartService->getCartCount($cart);
            
            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            \Log::error('Get cart count error: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to get cart count'], 500);
        }
    }
}
