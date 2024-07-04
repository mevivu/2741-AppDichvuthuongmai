<?php

namespace App\Enums\Vehicle;

use App\Supports\Enum;

enum VehicleType: int
{
    use Enum;

    // Chưa được phân loại
    case Unclassified = 1;

    // Xe gắn máy
    case Motorcycle = 2;

    // Ô tô
    case Car = 3;

    // Xe tải
    case Truck = 4;

    // Xe tải đông lạnh
    case RefrigeratedRuck = 5;

    public function badge(): string
    {
        return match ($this) {
            self::Unclassified => 'bg-green-lt',
            self::Motorcycle => 'bg-orange-lt',
            self::Car => 'bg-red-lt',
            self::Truck => 'bg-blue-lt',
            self::RefrigeratedRuck => 'bg-pink-lt'
        };
    }

}
