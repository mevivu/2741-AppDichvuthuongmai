<?php

namespace App\Enums\Driver;

use BenSampo\Enum\Enum;

final class DriverConfirmOrder extends Enum
{
    const DangCho = 0;
    const DaXacNhan = 1;
    const TuChoi = 2;
    public static function getDescription($value): string
    {
        switch ($value) {
            case self::DangCho:
                return 'Đang chờ';
            case self::DaXacNhan:
                return 'Đã xác nhận';
            case self::TuChoi:
                return 'Từ chối';
            default:
                return parent::getDescription($value);
        }
    }



}
