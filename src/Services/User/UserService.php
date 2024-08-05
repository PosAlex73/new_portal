<?php

namespace App\Services\User;

use App\Entity\User;
use App\Enums\Users\UserStatuses;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository,
    ){}

    public function blockUser(User $user)
    {
        $user->setStatus(UserStatuses::BANNED->value);
        $this->entityManager->flush();
    }

    public function unblockUser(User $user)
    {
        $user->setStatus(UserStatuses::ACTIVE->value);
        $this->entityManager->flush();
    }

    public function checkUserIsBlockedByEmail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);

        if (empty($user)) {
            return true;
        }

        if ($user->getStatus() === UserStatuses::BANNED->value) {
            return true;
        }

        return false;
    }
}
