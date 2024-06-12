<?php

namespace App\Enums\Driver;


use App\Admin\Support\Enum;

enum DriverTransactionStatus: int
{
    use Enum;

    //  Chưa chuyển khoản hệ thống
    case Pending = 1;

    // Đã chuyển khoản hệ thống
    case Success = 2;

    public function badge(): string
    {
        return match ($this) {
            self::Success => 'bg-green',
            self::Pending => 'bg-yellow',

        };
    }

}
