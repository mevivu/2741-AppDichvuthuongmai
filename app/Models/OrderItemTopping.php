<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItemTopping extends Model
{
    use HasFactory;

    protected $table = 'order_item_toppings';

    public $timestamps = false;

    protected $fillable = [
        'order_item_id',
        'topping_id',
        'quantity'
    ];

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }
    public function topping(): BelongsTo
    {
        return $this->belongsTo(Topping::class, 'topping_id');
    }
}
