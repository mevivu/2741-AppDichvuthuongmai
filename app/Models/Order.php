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
        /** ID của người dùng */
        'user_id',
        /** ID của tài xế */
        'driver_id',
        /** ID của cửa hàng  */
        'store_id',
        /** ID của phương tiện  */
        'vehicle_id',
        /** Vĩ độ của điểm bắt đầu */
        'start_latitude',
        /** Kinh độ của điểm bắt đầu */
        'start_longitude',
        /** Địa chỉ của điểm bắt đầu */
        'start_address',
        /** Vĩ độ của điểm kết thúc */
        'end_latitude',
        /** Kinh độ của điểm kết thúc */
        'end_longitude',
        /** Địa chỉ của điểm kết thúc */
        'end_address',
        /** Tổng tiền phụ của đơn hàng */
        'sub_total',
        /** Mã thanh toán */
        'payment_code',
        /** Phương thức giao hàng */
        'shipping_method',
        /** Phương thức thanh toán */
        'payment_method',
        /** Địa chỉ giao hàng */
        'shipping_address',
        /** Loại đơn hàng */
        'order_type',
        /** Tổng tiền của đơn hàng */
        'total',
        /** Trạng thái của đơn hàng */
        'status',
        /** Ghi chú cho đơn hàng */
        'note',
        /** Số lượng hành khách */
        'passenger_count',
        /** Số lượng hành lý */
        'luggage_count',
        /** Giờ khởi hành */
        'departure_time',
        /** Giờ trả xe */
        'return_time'
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'payment_method' => PaymentMethod::class,
        'order_type' => OrderType::class,
        'total' => 'double',
        'departure_time' => 'datetime',
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
