<?php

namespace App\Models;

use App\Admin\Traits\Roles;
use App\Enums\Driver\AutoAccept;
use App\Enums\Driver\DriverStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Roles;

    protected $table = 'drivers';
    protected $fillable = [
        'user_id',
        /** CCCD */
        'id_card',
        /** CCCD mặt trước */
        'id_card_front',
        /** CCCD mặt sau */
        'id_card_back',
        /** Biển số xe */
        'license_plate',
        /** Ảnh Biển số xe */
        'license_plate_image',
        /** Nhà sản xuất xe */
        'vehicle_company',
        /** Giấy đăng ký xe mặt trước */
        'vehicle_registration_front',
        /** Giấy đăng ký xe mặt sau */
        'vehicle_registration_back',
        /** Giấy phép lái xe mặt trước */
        'driver_license_front',
        /** Giấy phép lái xe mặt sau */
        'driver_license_back',
        /** Ảnh xe phía trước */
        'vehicle_front_image',
        /** Ảnh xe phía sau */
        'vehicle_back_image',
        /** Ảnh hông xe */
        'vehicle_side_image',
        /** Ảnh nội thất xe */
        'vehicle_interior_image',
        /** Ảnh mặt trước bảo hiểm xe */
        'insurance_front_image',
        /** Ảnh mặt sau bảo hiểm xe */
        'insurance_back_image',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'auto_accept',
        'current_lat',
        'current_lng',
        'current_address',
        'order_accepted',
    ];
    protected $casts = [
        'auto_accept' => AutoAccept::class,
        'order_accepted' => DriverStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
