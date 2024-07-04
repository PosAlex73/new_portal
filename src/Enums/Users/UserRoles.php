<?php

namespace App\Enums\Users;

enum UserRoles: string
{
    case ROLE_ADMIN = 'ROLE_ADMIN';
    case ROLE_USER = 'ROLE_USER';
}
