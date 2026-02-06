<?php

namespace App\Http\Controllers;

use App\Services\MenuService;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Menu Controller
 * 
 * Handles menu display, search, filtering, and recommendations
 */
class MenuController extends Controller
{
    private MenuService $menuService;
    private CartService $cartService;

    /**
     * Constructor
     *
     * @param MenuService $menuService
     * @param CartService $cartService
     */
    public function __construct(MenuService $menuService, CartService $cartService)
    {
        $this->menuService = $menuService;
        $this->cartService = $cartService;
    }

    /**
     * Display menu items with filtering and search
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): \Illuminate\View\View
    {
        try {
            $validated = $request->validate([
                'category' => 'nullable|string|in:Semua,Sushi Roll,Nigiri & Sashimi,Ramen & Udon,Snack & Dessert,Rice,Party,Beverages',
                'search' => 'nullable|string|max:255',
            ]);

            $category = $validated['category'] ?? 'Semua';
            $search = $validated['search'] ?? '';

            $menuItems = $this->menuService->getMenuItems($category, $search);
            $recommendations = $this->menuService->getRecommendations($category);
            $orderedMenuIds = $this->menuService->getUserOrderedMenuIds();
            
            $cart = $request->session()->get('cart', []);
            $cartCount = $this->cartService->getCartCount($cart);

            return view('menu.index', compact(
                'menuItems', 
                'category', 
                'search', 
                'orderedMenuIds', 
                'cartCount', 
                'recommendations'
            ));

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->validator())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Menu index error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat menu.');
        }
    }

    /**
     * Display single menu item details
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show(Request $request, int $id): \Illuminate\View\View
    {
        try {
            $menuItem = $this->menuService->getMenuItem($id);
            $similarUsersCount = $this->menuService->getSimilarUsersCount($id);
            
            $cart = $request->session()->get('cart', []);
            $cartCount = $this->cartService->getCartCount($cart);

            return view('menu.show', compact('menuItem', 'similarUsersCount', 'cartCount'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('menu.index')
                ->with('error', 'Menu tidak ditemukan.');
        } catch (\Exception $e) {
            \Log::error('Menu show error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat detail menu.');
        }
    }

    /**
     * Search menu items (AJAX endpoint)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'query' => 'required|string|min:2|max:255',
                'limit' => 'nullable|integer|min:1|max:50',
            ]);

            $limit = $validated['limit'] ?? 20;
            $results = $this->menuService->searchMenuItems($validated['query'], $limit);
            
            return response()->json([
                'success' => true,
                'data' => $results,
                'count' => $results->count()
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Menu search error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan saat melakukan pencarian.'
            ], 500);
        }
    }

    /**
     * Get menu recommendations (AJAX endpoint)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getRecommendations(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'category' => 'nullable|string|in:Semua,Sushi Roll,Nigiri & Sashimi,Ramen & Udon,Snack & Dessert,Rice,Party,Beverages',
            ]);

            $category = $validated['category'] ?? 'Semua';
            $recommendations = $this->menuService->getRecommendations($category);
            
            return response()->json([
                'success' => true,
                'data' => $recommendations
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Get recommendations error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan saat memuat rekomendasi.'
            ], 500);
        }
    }

    /**
     * Get menu statistics (AJAX endpoint)
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

            $stats = $this->menuService->getMenuStatistics();
            
            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            \Log::error('Get menu statistics error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Unable to get menu statistics'
            ], 500);
        }
    }
}
