<?php

namespace App\Enums\Order;

use App\Supports\Enum;

enum OrderStatus: int
{
    use Enum;

    // Chờ cửa hàng xác nhận
    case PendingStoreConfirmation  = 1;

    // Chờ tài xế xác nhận
    case PendingDriverConfirmation = 2;

    // Đã xác nhận
    case Confirmed = 3;

    // Đang di chuyển
    case InTransit = 4;

    // Đã đến cửa hàng
    case ArrivedAtStore = 5;

    // Đang di chuyển đến điểm đến
    case MovingToDestination = 6;

    // Hoàn thành
    case Completed = 7;

    // Hủy bỏ
    case Cancelled = 8;

    // Không thành công
    case Failed = 9;

    // Không tìm thấy tài xế
    case DriverUnavailable = 10;

    // Khách hàng hủy
    case CustomerCancelled = 11;
    public function badge(): string
    {
        return match($this) {
            self::PendingStoreConfirmation => 'bg-yellow-lt',
            self::PendingDriverConfirmation => 'bg-cyan-lt',
            self::Confirmed => 'bg-blue-lt',
            self::InTransit => 'bg-purple-lt',
            self::ArrivedAtStore => 'bg-orange-lt',
            self::MovingToDestination => 'bg-teal-lt',
            self::Completed => 'bg-green-lt',
            self::Cancelled => 'bg-red-lt',
            self::Failed => 'bg-dark-lt',
            self::DriverUnavailable => 'bg-grey-lt',
            self::CustomerCancelled => 'bg-pink-lt',
        };
    }

}
