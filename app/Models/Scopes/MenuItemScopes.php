<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Scope for menu item queries
 */
class MenuItemScopes implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Default ordering for menu items
        $builder->orderBy('category')->orderBy('name');
    }
}

/**
 * Trait for menu item scopes
 */
trait MenuItemScopeTrait
{
    /**
     * Scope a query to only include popular items
     *
     * @param Builder $query
     * @param int $minOrders
     * @return Builder
     */
    public function scopePopular(Builder $query, int $minOrders = 5): Builder
    {
        return $query->withCount('orders')
            ->having('orders_count', '>=', $minOrders)
            ->orderByDesc('orders_count');
    }

    /**
     * Scope a query to only include highly rated items
     *
     * @param Builder $query
     * @param float $minRating
     * @return Builder
     */
    public function scopeHighlyRated(Builder $query, float $minRating = 4.0): Builder
    {
        return $query->where('average_rating', '>=', $minRating)
            ->where('rating_count', '>', 0)
            ->orderByDesc('average_rating');
    }

    /**
     * Scope a query to search by name and description
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    /**
     * Scope a query to get items by category with ordering
     *
     * @param Builder $query
     * @param string $category
     * @return Builder
     */
    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category)
            ->orderByDesc('average_rating')
            ->orderByDesc('rating_count');
    }
}
