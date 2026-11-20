<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'amount',
        'method',
        'status',
        'received_at',
        'proof_path',
        'proof_uploaded_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'received_at' => 'datetime',
            'proof_uploaded_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isEwallet(): bool
    {
        return $this->method !== 'cod';
    }

    public function methodLabel(): string
    {
        return $this->method === 'cod'
            ? 'COD'
            : config("payment.wallets.{$this->method}.label", strtoupper($this->method));
    }
}
