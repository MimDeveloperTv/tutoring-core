<?php

namespace App\Enums;

use App\Traits\EnumEnhancements;

enum GendersEnum: string
{
    use EnumEnhancements;
    case MALE = 'MALE';
    case FEMALE = 'FEMALE';
    case OTHERS = 'OTHERS';
}
