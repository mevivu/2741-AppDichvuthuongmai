<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItemTopping extends Model
{
    use HasFactory;

    protected $table = 'cart_item_toppings';

    public $timestamps = false;

    protected $fillable = [
        'cart_item_id',
        'topping_id',
        'quantity'
    ];

    public function cartItem(): BelongsTo
    {
        return $this->belongsTo(CartItem::class, 'cart_item_id');
    }

    public function topping(): BelongsTo
    {
        return $this->belongsTo(Topping::class, 'topping_id');
    }
}
