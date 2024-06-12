<?php

namespace App\Enums\Topping;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

final class ToppingStatus extends Enum implements LocalizedEnum
{
    const HetMon = 0;
    const ConMon = 1;

}
