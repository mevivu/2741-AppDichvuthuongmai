<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VehicleOwner extends Model
{
    use HasFactory;

    protected $table = 'vehicle_owners';
    protected $fillable = [
        'fullname', // Tên đầy đủ của chủ xe
        'phone', // Số điện thoại của chủ xe
        'email', // Email của chủ xe
        'avatar', // Ảnh đại diện của chủ xe
        'lat', // Vĩ độ của địa chỉ
        'lng', // Kinh độ của địa chỉ
        'address', // Địa chỉ của chủ xe
        'birthday', // Ngày sinh của chủ xe
        'id_card', // Số CCCD của chủ xe
        'id_card_front', // Ảnh mặt trước CCCD
        'id_card_back', // Ảnh mặt sau CCCD
        'bank_name', // Tên ngân hàng
        'bank_account_name', // Tên tài khoản ngân hàng
        'bank_account_number', // Số tài khoản ngân hàng
        'area_id', // ID khu vực liên kết
    ];
    protected $casts = [];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function vehicle(): HasOne
    {
        return $this->hasOne(Vehicle::class);
    }
}
