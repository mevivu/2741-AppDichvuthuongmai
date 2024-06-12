<?php

namespace App\Enums\Vehicle;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

/**
 * @method static static Published()
 * @method static static Draft()
 */
final class VehicleType extends Enum implements LocalizedEnum
{

    // Chưa được phân loại
    const Unclassified = 1;

    // Xe gắn máy
    const Motorcycle = 2;

    // Ô tô
    const Car = 3;

    // Xe tải
    const Truck = 4;

    // Xe tải đông lạnh
    const RefrigeratedRuck = 5;

    public function colorText(): string
    {
        return match($this->value) {
            VehicleType::Unclassified => 'text-danger',
            VehicleType::Motorcycle => 'text-success',
            VehicleType::Car => 'text-primary',
            VehicleType::Truck => 'text-warning',
            VehicleType::RefrigeratedRuck => 'text-secondary',
            default => 'text-dark'
        };
    }

    public function colorBg(): string
    {
        return match($this->value) {
            VehicleType::Unclassified => 'bg-danger',
            VehicleType::Motorcycle => 'bg-success',
            VehicleType::Car => 'bg-primary',
            VehicleType::Truck => 'bg-warning',
            VehicleType::RefrigeratedRuck => 'bg-secondary',
            default => 'bg-light'
        };
    }

}
