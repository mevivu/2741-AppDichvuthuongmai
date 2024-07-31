<?php

namespace App\Enums\Topping;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

/**
 * @method static static available()
 * @method static static soldOut()
 */
final class ToppingStatus extends Enum implements LocalizedEnum
{
    const available = 1;
    const soldOut = 2;

}
