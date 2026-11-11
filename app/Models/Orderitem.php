<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'item_type', 'service_price_id', 'product_id',
        'name', 'image', 'price', 'quantity',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getSubtotalAttribute(): float
    {
        return (float) $this->price * (int) $this->quantity;
    }

    public function isProduct(): bool
    {
        return $this->item_type === 'product';
    }
}
