<?php

namespace App\Services\User;

use App\Entity\User;
use App\Enums\CommonStatus;
use App\Enums\Users\UserTypes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class UserRegistrator
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected RolesGetter $rolesGetter
    ){}

    public function registerUser(Request $request, User $newUser)
    {
        $newUser->setStatus(CommonStatus::DISABLED->value);
        $newUser->setType(UserTypes::SIMPLE->value);
        $newUser->setRoles($this->rolesGetter->getRolesForUser(UserTypes::SIMPLE));

        $this->entityManager->persist($newUser);
        $this->entityManager->flush();
    }
}