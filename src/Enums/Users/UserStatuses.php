<?php

namespace App\Enums\Users;

enum UserStatuses: string
{
    case ACTIVE = 'A';
    case PENDING = 'P';
    case DISABLED = 'D';
}
