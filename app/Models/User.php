<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Admin\Support\Eloquent\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Enums\User\{UserRoles, UserVip, UserGender};
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements JWTSubject
{
    use Sluggable, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'code',
        'fullname',
        'email',
        'phone',
        'birthday',
        'gender',
        'active',
        'avatar',
        'area_id',
        'address',
        'password',
        'status',
        'longitude',
        'latitude',
        'roles',
        'token_get_password',
        'device_token',
        'notification_preference',
        'vip',
    ];

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
        'roles' => UserRoles::class,
        'gender' => UserGender::class,
        'vip' => UserVip::class,
        'active' => 'boolean',

    ];

    public function sumEarningPoint(){
        return DB::table('order_earning_point')
        ->where('user_id', $this->id)
        ->sum('point');
    }
    public function getDiscountProduct(){
        $repository = app()->make('App\Repositories\Setting\SettingRepositoryInterface');
        $discount = 0;
        $setting = $repository->getAll();
        switch ($this->vip) {
            case UserVip::Default():
                $discount = $setting->getValueByKey('user_vip_default');
                break;
            case UserVip::Bronze():
                $discount = $setting->getValueByKey('user_vip_bronze');
                break;
            case UserVip::Silver():
                $discount = $setting->getValueByKey('user_vip_silver');
                break;
            case UserVip::Gold():
                $discount = $setting->getValueByKey('user_vip_gold');
                break;
            case UserVip::Diamond():
                $discount = $setting->getValueByKey('user_vip_diamond');
                break;
            default:
                $discount = 0;
                break;
        }
        return $discount;
    }

    public function reviews(){
        return $this->hasMany(Review::class, 'user_id', 'id');
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
