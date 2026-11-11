<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public const CATEGORIES = [
        'kertas' => 'Kertas',
        'pulpen' => 'Pulpen',
        'pensil' => 'Pensil',
        'lainnya' => 'Lainnya',
    ];

    protected $fillable = ['name', 'category', 'description', 'image', 'price', 'stock'];

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst($this->category);
    }
}
