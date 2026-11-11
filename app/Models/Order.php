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

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /** Item pesanan dari keranjang (jasa dan/atau produk). */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Supaya semua tampilan lama ($order->servicePrice->name / image / price) tetap jalan:
     * - pesanan lama (1 layanan)            -> layanan aslinya
     * - pesanan dengan banyak item / produk -> "Item pertama +N lainnya" dengan gambar item pertama
     */
    public function getServicePriceAttribute()
    {
        $service = $this->getRelationValue('servicePrice');
        $items = $this->items;

        if ($items->count() > 1 || ($items->count() === 1 && ! $service)) {
            $first = $items->first();
            $more = $items->count() - 1;
            $subtotal = $items->sum(fn ($i) => (float) $i->price * (int) $i->quantity);

            return (new ServicePrice)->forceFill([
                'name' => $first->name.($first->quantity > 1 ? ' x'.$first->quantity : '').($more > 0 ? ' +'.$more.' lainnya' : ''),
                'description' => null,
                'image' => $first->image,
                'price' => $subtotal,
                'badge' => $items->count() > 1 ? 'Keranjang' : ($first->isProduct() ? 'Produk' : null),
            ]);
        }

        if ($service || ! $this->product_id) {
            return $service;
        }

        // Pesanan produk dari alur lama (product_id langsung di tabel orders)
        $product = $this->product;

        return $product ? (new ServicePrice)->forceFill([
            'name' => $product->name.($this->quantity > 1 ? ' x'.$this->quantity : ''),
            'description' => $product->description,
            'image' => $product->image,
            'price' => $product->price,
            'badge' => 'Produk',
        ]) : null;
    }

    /** Kembalikan stok produk (dipanggil saat pesanan dibatalkan). */
    public function restock(): void
    {
        $items = $this->items()->where('item_type', 'product')->get();

        foreach ($items as $item) {
            Product::where('id', $item->product_id)->increment('stock', max(1, (int) $item->quantity));
        }

        if ($items->isEmpty() && $this->product_id) {
            Product::where('id', $this->product_id)->increment('stock', max(1, (int) $this->quantity));
        }
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
