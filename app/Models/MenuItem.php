<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
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

    protected $casts = [
        'tags' => 'array',
        'price' => 'decimal:0',
        'average_rating' => 'decimal:2',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
