<?php

namespace App\Services;

use App\Models\MenuItem;
use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Service class for handling menu operations and recommendations
 * 
 * @package App\Services
 */
class MenuService
{
    /**
     * Get menu items with filtering and search
     *
     * @param string $category
     * @param string $search
     * @return Collection
     */
    public function getMenuItems(string $category = 'Semua', string $search = ''): Collection
    {
        $query = MenuItem::withCount('orders');
        
        if ($category !== 'Semua') {
            $query->where('category', $category);
        }
        
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        return $query->orderBy('category')->orderBy('name')->get();
    }

    /**
     * Get menu recommendations based on category and user behavior
     *
     * @param string $category
     * @return Collection
     */
    public function getRecommendations(string $category): Collection
    {
        if ($category === 'Semua') {
            return $this->getGlobalRecommendations();
        }
        
        return $this->getCategoryRecommendations($category);
    }

    /**
     * Get global recommendations (top items from each category)
     *
     * @return Collection
     */
    private function getGlobalRecommendations(): Collection
    {
        $categories = ['Sushi Roll', 'Nigiri & Sashimi', 'Ramen & Udon', 'Snack & Dessert', 'Rice', 'Party', 'Beverages'];
        $recommendations = collect();
        
        foreach ($categories as $cat) {
            $bestItem = MenuItem::where('category', $cat)
                ->withCount('orders')
                ->orderByDesc('orders_count')
                ->orderByDesc('average_rating')
                ->first();
                
            if ($bestItem) {
                $recommendations->push($bestItem);
            }
        }
        
        return $recommendations;
    }

    /**
     * Get category-specific recommendations
     *
     * @param string $category
     * @return Collection
     */
    private function getCategoryRecommendations(string $category): Collection
    {
        return MenuItem::where('category', $category)
            ->withCount('orders')
            ->orderByDesc('orders_count')
            ->orderByDesc('average_rating')
            ->take(3)
            ->get();
    }

    /**
     * Get menu item with details
     *
     * @param int $id
     * @return MenuItem
     */
    public function getMenuItem(int $id): MenuItem
    {
        return MenuItem::with('ratings')->findOrFail($id);
    }

    /**
     * Get similar users count for a menu item
     *
     * @param int $menuItemId
     * @return int
     */
    public function getSimilarUsersCount(int $menuItemId): int
    {
        return Order::where('menu_item_id', $menuItemId)
            ->where('user_id', '!=', Auth::id())
            ->distinct('user_id')
            ->count();
    }

    /**
     * Get user's ordered menu item IDs
     *
     * @return array
     */
    public function getUserOrderedMenuIds(): array
    {
        return Order::where('user_id', Auth::id())
            ->pluck('menu_item_id')
            ->unique()
            ->toArray();
    }

    /**
     * Get popular menu items
     *
     * @param int $limit
     * @return Collection
     */
    public function getPopularMenuItems(int $limit = 10): Collection
    {
        return MenuItem::withCount('orders')
            ->orderByDesc('orders_count')
            ->orderByDesc('average_rating')
            ->limit($limit)
            ->get();
    }

    /**
     * Search menu items
     *
     * @param string $query
     * @param int $limit
     * @return Collection
     */
    public function searchMenuItems(string $query, int $limit = 20): Collection
    {
        return MenuItem::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orWhere('category', 'like', "%{$query}%")
            ->withCount('orders')
            ->orderByDesc('orders_count')
            ->limit($limit)
            ->get();
    }

    /**
     * Get menu statistics
     *
     * @return array
     */
    public function getMenuStatistics(): array
    {
        return [
            'total_items' => MenuItem::count(),
            'total_categories' => MenuItem::distinct('category')->count('category'),
            'average_rating' => MenuItem::avg('average_rating'),
            'most_popular' => $this->getPopularMenuItems(1)->first(),
        ];
    }
}
