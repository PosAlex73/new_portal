<?php

namespace App\UserCheckers;

use App\Enums\Users\UserStatuses;
use App\Exceptions\UserBannedException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{

    public function checkPreAuth(UserInterface $user): void
    {
        if ($user->getStatus() === UserStatuses::BANNED->value) {
            throw new UserBannedException();
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        // TODO: Implement checkPostAuth() method.
    }
}

