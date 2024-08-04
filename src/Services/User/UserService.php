<?php

namespace App\Services\User;

use App\Entity\User;
use App\Enums\Users\UserStatuses;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function blockUser(User $user)
    {
        $user->setStatus(UserStatuses::DISABLED->value);
        $this->entityManager->flush();
    }

    public function unblockUser(User $user)
    {
        $user->setStatus(UserStatuses::ACTIVE->value);
        $this->entityManager->flush();
    }
}
