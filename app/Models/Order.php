<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'menu_item_id',
        'quantity',
        'total_price',
    ];

    protected $casts = [
        'total_price' => 'decimal:0',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}
