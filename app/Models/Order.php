<?php

namespace App\Models;

use App\Enums\Order\OrderStatus;
use App\Enums\Order\OrderType;
use App\Enums\Payment\PaymentMethod;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'driver_id',
        'store_id',
        'start_latitude',
        'start_longitude',
        'start_address',
        'end_latitude',
        'end_longitude',
        'end_address',
        'sub_total',
        'payment_code',
        'shipping_method',
        'payment_method',
        'shipping_address',
        'order_type',
        'total',
        'status',
        'note'
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'payment_method' => PaymentMethod::class,
        'order_type' =>OrderType::class,
        'total' => 'double'
    ];


    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id')->orderBy('id', 'desc');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }




}
