<?php

namespace App\Services\User;

use App\Entity\User;
use App\Enums\Users\UserStatuses;
use App\Enums\Users\UserTypes;
use Doctrine\ORM\EntityManagerInterface;

class UserRemover
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function deleteUser(User $user)
    {
        if ($user->getStatus() !== UserStatuses::ACTIVE->value) {
            return true;
        }

        if ($user->getType() === UserTypes::ADMIN->value) {
            return false;
        }

        $user->setEmail('deleted'. $user->getId() . '@mail.ru');
        $user->setPassword('deleted');
        $user->setStatus(UserStatuses::DISABLED->value);
        $user->setFirstName('deleted');
        $user->setLastName('deleted');
        $user->setIsVerified(false);

        $this->entityManager->flush();

        return true;
    }
}
