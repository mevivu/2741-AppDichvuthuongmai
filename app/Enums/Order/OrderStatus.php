<?php

namespace App\Enums\Order;

use App\Supports\Enum;

enum OrderStatus: int
{
    use Enum;

    // Chờ xác nhận
    case Pending = 1;
    // Đã xác nhận
    case Confirmed = 2;

    // Đang di chuyển
    case InTransit = 3;

    // Đã đến cửa hàng
    case ArrivedAtStore = 4;

    // Đang di chuyển đến điểm đến
    case MovingToDestination = 5;
    // Hoàn thành
    case Completed = 6;
    // Hủy bỏ
    case Cancelled = 7;

    // Không thành công
    case Failed = 8;

    public function badge(): string
    {
        return match($this) {
            self::Pending => 'bg-yellow-lt',
            self::Confirmed => 'bg-blue-lt',
            self::InTransit => 'bg-purple-lt',
            self::ArrivedAtStore => 'bg-orange-lt',
            self::MovingToDestination => 'bg-teal-lt',
            self::Completed => 'bg-green-lt',
            self::Cancelled => 'bg-red-lt',
            self::Failed => 'bg-dark-lt',
        };
    }

}
