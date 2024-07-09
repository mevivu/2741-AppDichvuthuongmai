<?php

namespace App\Enums\Vehicle;

use App\Supports\Enum;

enum VehicleStatus: int
{
    use Enum;

    // Chờ xác nhận
    case Pending = 1;

    // Đã thuê
    case Rented = 2;

    // Không hoạt động
    case Inactive = 3;

    // Đang bảo trì
    case UnderMaintenance = 4;

    public function badge(): string
    {
        return match ($this) {
            self::Pending => 'bg-green-lt',
            self::Rented => 'bg-orange-lt',
            self::Inactive => 'bg-red-lt',
            self::UnderMaintenance => 'bg-blue-lt'
        };
    }

}
