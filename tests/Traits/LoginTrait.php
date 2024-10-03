<?php

namespace App\Tests\Traits;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait LoginTrait
{
    public function loginAsUser(KernelBrowser $client, string $email = 'u@u.ru')
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->getRepositoryByModel(User::class);

        $user = $userRepository->findByEmail($email);
        $client->loginUser($user);
    }
}
