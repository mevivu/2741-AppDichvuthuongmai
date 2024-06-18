<?php

namespace App\Enums\DiscountCode;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

/**
 * @method static static Published()
 * @method static static Draft()
 */
final class DiscountCodeStatus extends Enum implements LocalizedEnum
{
    const Activities = 1; // Hoạt động
    const NotActivated = 2; // Chưa kích hoạt
    const Expired = 3; // Hết hạn
    const Used = 4; // Đã sử dụng
    const ConditionsNotMet = 5; // Điều kiện không đạt
    const UsageLimits = 6; // Gioi Hạn sử dụng

    public function colorText(){
        return match($this->value) {
            DiscountCodeStatus::Activities => 'text-success',
            DiscountCodeStatus::NotActivated => 'text-info',
            DiscountCodeStatus::Used => 'text-yellow',
            DiscountCodeStatus::Expired => 'text-danger',
            DiscountCodeStatus::ConditionsNotMet => 'text-yellow',
            DiscountCodeStatus::UsageLimits => 'text-info',
            default => ''
        };
    }

    public function colorBg(){
        return match($this->value) {
            DiscountCodeStatus::Activities => 'bg-success',
            DiscountCodeStatus::NotActivated => 'bg-info',
            DiscountCodeStatus::Used => 'bg-yellow',
            DiscountCodeStatus::Expired => 'bg-danger',
            DiscountCodeStatus::ConditionsNotMet => 'bg-yellow',
            DiscountCodeStatus::UsageLimits => 'bg-info',
            default => ''
        };
    }
}
