<?php

namespace App\Enums;

enum DateTimeFormatEnum: string
{
    case FULL_FORMAT = 'Y-m-d H:i:s';
    case SHORT_FORMAT = 'Y-m-d';
}
