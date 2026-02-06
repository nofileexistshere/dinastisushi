<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Menu Item Model
 * 
 * Represents a menu item in the restaurant
 * 
 * @property int $id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property string $category
 * @property string $image
 * @property float $average_rating
 * @property int $rating_count
 * @property array $tags
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection<Order> $orders
 * @property-read \Illuminate\Database\Eloquent\Collection<Rating> $ratings
 * @property-read int $orders_count
 */
class MenuItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'image',
        'average_rating',
        'rating_count',
        'tags',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'array',
        'price' => 'decimal:0',
        'average_rating' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        // Update average rating when rating is added/updated
        static::saved(function ($menuItem) {
            if ($menuItem->wasChanged(['average_rating', 'rating_count'])) {
                // Clear cache if using caching
                cache()->forget("menu_item_{$menuItem->id}_stats");
            }
        });
    }

    /**
     * Get the orders for the menu item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the ratings for the menu item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Get the formatted price.
     *
     * @return string
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get the rating stars HTML.
     *
     * @return string
     */
    public function getRatingStarsAttribute(): string
    {
        $stars = '';
        $fullStars = floor($this->average_rating);
        $hasHalfStar = ($this->average_rating - $fullStars) >= 0.5;
        
        // Add full stars
        for ($i = 0; $i < $fullStars; $i++) {
            $stars .= '<i class="fas fa-star text-yellow-500"></i>';
        }
        
        // Add half star if needed
        if ($hasHalfStar && $fullStars < 5) {
            $stars .= '<i class="fas fa-star-half-alt text-yellow-500"></i>';
            $fullStars++;
        }
        
        // Add empty stars
        for ($i = $fullStars; $i < 5; $i++) {
            $stars .= '<i class="far fa-star text-gray-300"></i>';
        }
        
        return $stars;
    }

    /**
     * Scope a query to get items with ratings count.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithRatingsCount(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->withCount('ratings');
    }

    /**
     * Scope a query to get popular items in category.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $category
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopularInCategory(\Illuminate\Database\Eloquent\Builder $query, string $category, int $limit = 3): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('category', $category)
            ->withCount('orders')
            ->orderByDesc('orders_count')
            ->orderByDesc('average_rating')
            ->limit($limit);
    }

    /**
     * Check if the menu item is popular.
     *
     * @return bool
     */
    public function isPopular(): bool
    {
        return ($this->orders_count ?? 0) >= 5 && $this->average_rating >= 4.0;
    }

    /**
     * Get the main tag (first tag if available).
     *
     * @return string|null
     */
    public function getMainTagAttribute(): ?string
    {
        return $this->tags[0] ?? null;
    }
}
