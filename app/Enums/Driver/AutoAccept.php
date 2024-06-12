<?php

namespace App\Enums\Driver;


use App\Admin\Support\Enum;

enum AutoAccept: int
{
    use Enum;

    case Auto = 1;
    case Off = 2;
}
