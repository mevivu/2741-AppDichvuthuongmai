<?php

namespace App\Models;

use App\Enums\Vehicle\VehicleStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Vehicle\VehicleType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicles';
    protected $fillable = [
        /** ID tài xế */
        'driver_id',
        /** Tên phương tiện */
        'name',
        /** Thương hiệu */
        'brand',
        /** Màu sắc */
        'color',
        /** Loại phương tiện */
        'type',
        /** Số ghế */
        'seat_number',
        /** Biển số xe */
        'license_plate',
        /** Ảnh biển số xe */
        'license_plate_image',
        /** Giá */
        'price',
        /** Nhà sản xuất xe */
        'vehicle_company',
        /** Giấy đăng ký xe mặt trước */
        'vehicle_registration_front',
        /** Giấy đăng ký xe mặt sau */
        'vehicle_registration_back',
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
        /** Tiện nghi */
        'amenities',
        /** Mô tả */
        'description',
        /** Hình đại diện */
        'avatar',
        /** Trạng thái */
        'status'
    ];

    protected $casts = [
        'name' => 'string',
        'brand' => 'string',
        'color' => 'string',
        'seat_number' => 'integer',
        'license_plate' => 'string',
        'type' => VehicleType::class,
        'status' => VehicleStatus::class,
        'price' =>'double'
    ];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }


}
