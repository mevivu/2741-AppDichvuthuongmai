<?php

namespace App\Models;

use App\Admin\Support\Eloquent\Sluggable;
use App\Casts\OpenHour;
use App\Enums\Store\StoreStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Store extends Authenticatable implements JWTSubject
{
    use HasRoles, HasFactory, HasApiTokens, Sluggable, Notifiable;

    protected $columnSlug = 'store_name';
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'open_hours_1' => OpenHour::class,
        'close_hours_1' => OpenHour::class,
        'open_hours_2' => OpenHour::class,
        'close_hours_2' => OpenHour::class,
        'status' => StoreStatus::class,
        'priority' => 'integer',
        'lng' => 'double',
        'lat' => 'double'
    ];

    public function fullAddress(): string
    {
        $address = '';
        $address = $this->address_detail ? rtrim($this->address_detail, ',') : $address;
        return $this->address_detail . ', ' . $this->address;
    }

    public function operatingTime1(): string
    {
        return $this->open_hours_1 . ' - ' . $this->close_hours_1;
    }

    public function operatingTime2(): ?string
    {

        if ($this->open_hours_2 || $this->close_hours_2) {
            return $this->open_hours_2 . ' - ' . $this->close_hours_2;
        }
        return null;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(StoreCategory::class, 'category_id');
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id')
            ->withPivot('model_type')
            ->wherePivot('model_type', self::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
