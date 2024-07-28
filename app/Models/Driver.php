<?php

namespace App\Models;

use App\Admin\Traits\Roles;
use App\Enums\Driver\AutoAccept;
use App\Enums\Driver\DriverStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Roles;

    protected $table = 'drivers';
    protected $fillable = [
        /**  ID người dùng */
        'user_id',
        /** CCCD */
        'id_card',
        /** CCCD mặt trước */
        'id_card_front',
        /** CCCD mặt sau */
        'id_card_back',
        /** Giấy phép lái xe mặt trước */
        'driver_license_front',
        /** Giấy phép lái xe mặt sau */
        'driver_license_back',
        /** Tên ngân hàng */
        'bank_name',
        /** Tên tài khoản ngân hàng */
        'bank_account_name',
        /** Số tài khoản ngân hàng */
        'bank_account_number',
        /** Tự động chấp nhận đơn */
        'auto_accept',
        /** Vĩ độ hiện tại */
        'current_lat',
        /** Kinh độ hiện tại */
        'current_lng',
        /** Địa chỉ hiện tại */
        'current_address',
        /** Tình trạng đơn hàng đã chấp nhận */
        'order_accepted',
        /** Trạng thái khóa */
        'is_locked',
        /** Trạng thái hoạt động */
        'is_on',
    ];
    protected $casts = [
        'auto_accept' => AutoAccept::class,
        'order_accepted' => DriverStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function vehicle(): HasOne
    {
        return $this->hasOne(Vehicle::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'driver_id');
    }

    public function scopeDriver($query)
    {
        return $query->whereHas('user.roles', function ($query) {
            $query->where('name', $this->getRoleDriver());
        });
    }
}
