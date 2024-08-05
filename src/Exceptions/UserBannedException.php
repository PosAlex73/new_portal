<?php

namespace App\Exceptions;

use Symfony\Component\Security\Core\Exception\AccountStatusException;

class UserBannedException extends AccountStatusException
{
    protected $message = 'Данный пользователь отключен.';
}
