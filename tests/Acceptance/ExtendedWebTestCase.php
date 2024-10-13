<?php

namespace App\Tests\Acceptance;

use App\Entity\User;
use App\Entity\UserProgress;
use App\Enums\System\FrontRouteNames;
use App\Repository\UserProgressRepository;
use App\Repository\UserRepository;
use App\Services\Settings\Set;
use App\Tests\Traits\ServiceGetter;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExtendedWebTestCase extends WebTestCase
{
    use ServiceGetter;

    public function getUrlByRouteName(FrontRouteNames $frontRouteName, array $options = []): string
    {
        $urlGenerator = $this->getUrlGenerator();
        return $urlGenerator->generate($frontRouteName->value, $options);
    }

    public function loginDefaultTestUser(KernelBrowser $client)
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->getRepositoryByModel(User::class);

        $user = $userRepository->findByEmail('u@u.ru');
        $client->loginUser($user);
    }

    public function getUserProgressRepository(): UserProgressRepository
    {
        /** @var UserProgressRepository $userProgressRepository */
        $userProgressRepository = $this->getRepositoryByModel(UserProgress::class);
        return $userProgressRepository;
    }


    public function getSet(): Set
    {
        /** @var Set $set */
        $set = $this->getContainer()->get(Set::class);
        return $set;
    }
}
