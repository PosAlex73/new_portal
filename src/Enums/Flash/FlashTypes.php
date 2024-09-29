<?php

namespace App\Enums\Flash;

enum FlashTypes: string
{
    case NOTICE = 'notice';
    case ERROR = 'error';
    case SUCCESS = 'success';
}
