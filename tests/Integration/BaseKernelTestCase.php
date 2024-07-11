<?php

namespace App\Tests\Integration;

use App\Entity\User;
use App\Entity\UserProgress;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BaseKernelTestCase extends KernelTestCase
{
    public function getEntityManager(): EntityManagerInterface
    {
        /** @var EntityManagerInterface $em */
        $em = $this->getContainer()->get(EntityManagerInterface::class);

        return $em;
    }

    public function getUserRepository(): UserRepository
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->getEntityManager()->getRepository(User::class);

        $user = $userRepository->findByEmail('u@u.ru');
        $userProgress = new UserProgress();

    }
}
