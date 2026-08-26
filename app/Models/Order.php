<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_price_id',
        'description',
        'reference_image',
        'recipient_name',
        'recipient_phone',
        'shipping_address',
        'status',
        'shipped_at',
        'total_price',
    ];

    protected function casts(): array
    {
        return [
            'shipped_at' => 'datetime',
            'total_price' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function servicePrice(): BelongsTo
    {
        return $this->belongsTo(ServicePrice::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
