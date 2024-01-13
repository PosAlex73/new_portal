<?php

namespace App\Services\User;

use App\Enums\Users\UserTypes;

class RolesGetter
{
    public function getRolesForUser(UserTypes $type): array
    {
        return match ($type) {
            UserTypes::ADMIN => ['ROLE_ADMIN', 'ROLE_USER'],
            UserTypes::SIMPLE => ['ROLE_USER'],
            default => throw new \Exception('Неправильный тип пользователя')
        };
    }
}
