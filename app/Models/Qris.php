<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qris extends Model
{
    protected $table = 'qris';

    protected $fillable = ['image', 'dana_number', 'account_name', 'note'];

    public static function current(): self
    {
        return static::firstOrCreate([]);
    }
}
