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
        'avatar',
        'id_card',
        'id_card_front',
        'id_card_back',
        'license_plate',
        'vehicle_company',
        'vehicle_registration_front',
        'vehicle_registration_back',
        'driver_license_front',
        'driver_license_back',
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
