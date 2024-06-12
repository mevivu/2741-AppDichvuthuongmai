<?php

namespace App\Enums\Driver;


use App\Admin\Support\Enum;

enum DriverAssignmentType: int
{
    use Enum;

    case Auto  = 1;
    case Manual  = 2;

}
