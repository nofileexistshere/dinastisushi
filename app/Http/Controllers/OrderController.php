<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Order Controller
 * 
 * Handles order operations including checkout, order creation, and rating
 */
class OrderController extends Controller
{
    private OrderService $orderService;
    private CartService $cartService;

    /**
     * Constructor
     *
     * @param OrderService $orderService
     * @param CartService $cartService
     */
    public function __construct(OrderService $orderService, CartService $cartService)
    {
        $this->orderService = $orderService;
        $this->cartService = $cartService;
    }

    /**
     * Process checkout from cart
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('error', 'Silakan login terlebih dahulu untuk checkout.');
            }

            $cart = $request->session()->get('cart', []);

            if (empty($cart)) {
                return redirect()->route('cart.index')
                    ->with('error', 'Keranjang Anda kosong.');
            }

            $this->orderService->processCheckout($cart);
            $this->cartService->clearCart();

            return redirect()->route('history.index')
                ->with('success', 'Pesanan berhasil! Jangan lupa kasih rating ya!');

        } catch (\Exception $e) {
            \Log::error('Checkout error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses checkout.');
        }
    }

    /**
     * Create a single order
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('error', 'Silakan login terlebih dahulu untuk membuat pesanan.');
            }

            $validated = $request->validate([
                'menu_item_id' => 'required|integer|exists:menu_items,id',
                'quantity' => 'required|integer|min:1|max:10',
            ]);

            $this->orderService->createOrder($validated['menu_item_id'], $validated['quantity']);

            return back()->with('success', 'Pesanan berhasil ditambahkan!');

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->validator())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Create order error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat membuat pesanan.');
        }
    }

    /**
     * Rate a menu item
     *
     * @param Request $request
     * @param int $orderId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rate(Request $request, int $orderId): \Illuminate\Http\RedirectResponse
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('error', 'Silakan login terlebih dahulu untuk memberikan rating.');
            }

            $validated = $request->validate([
                'rating' => 'required|integer|min:1|max:5',
            ]);

            $this->orderService->rateOrder($orderId, $validated['rating']);

            return back()->with('success', 'Rating berhasil disimpan!');

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->validator())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Rate order error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan rating.');
        }
    }

    /**
     * Get order history for the authenticated user
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function history(Request $request): \Illuminate\View\View
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('error', 'Silakan login terlebih dahulu.');
            }

            $orders = $this->orderService->getUserOrderHistory(Auth::id());
            
            return view('history.index', compact('orders'));

        } catch (\Exception $e) {
            \Log::error('Order history error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat riwayat pesanan.');
        }
    }

    /**
     * Get order statistics (AJAX endpoint)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getStatistics(Request $request): JsonResponse
    {
        try {
            if (!Auth::check() || !Auth::user()->is_admin) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $stats = $this->orderService->getOrderStatistics();
            
            return response()->json($stats);

        } catch (\Exception $e) {
            \Log::error('Get order statistics error: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to get statistics'], 500);
        }
    }
}
