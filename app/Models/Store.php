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
    protected $table = 'stores';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $fillable = [
        /** ID danh mục */
        'category_id',
        /** ID khu vực */
        'area_id',
        /** Mã cửa hàng */
        'code',
        /** Tên đăng nhập */
        'username',
        /** Tên cửa hàng */
        'store_name',
        /** Số điện thoại cửa hàng */
        'store_phone',
        /** Tên người liên hệ */
        'contact_name',
        /** Email người liên hệ */
        'contact_email',
        /** Số điện thoại người liên hệ */
        'contact_phone',
        /** Logo cửa hàng */
        'logo',
        /** Địa chỉ cửa hàng */
        'address',
        /** Chi tiết địa chỉ cửa hàng */
        'address_detail',
        /** Mã số thuế */
        'tax_code',
        /** Giờ mở cửa 1 */
        'open_hours_1',
        /** Giờ đóng cửa 1 */
        'close_hours_1',
        /** Giờ mở cửa 2 */
        'open_hours_2',
        /** Giờ đóng cửa 2 */
        'close_hours_2',
        /** Trạng thái cửa hàng */
        'status',
        /** Độ ưu tiên */
        'priority',
        /** Kinh độ */
        'lng',
        /** Vĩ độ */
        'lat',
        /** Token lấy lại mật khẩu */
        'token_get_password',
        /** Thời gian xác thực email */
        'email_verified_at',
        /** Token thiết bị */
        'device_token',
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
