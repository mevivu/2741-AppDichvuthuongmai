<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ToppingProduct extends Model
{
    use HasFactory;
    protected $table = 'topping_product';

    protected $fillable = [
        'product_id',
        'topping_id',

    ];
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function topping(): BelongsTo
    {
        return $this->belongsTo(Topping::class, 'topping_id');
    }
}
