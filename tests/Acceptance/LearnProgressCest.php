<?php

namespace App\Tests\Acceptance;

use App\Repository\UserProgressRepository;
use Tests\Support\AcceptanceTester;

class LearnProgressCest
{
    /** @var UserProgressRepository */
    private $userProgressRepository;

    public function _before(AcceptanceTester $tester)
    {
        $this->userProgressRepository = $tester->grabService(UserProgressRepository::class);
    }
    public function testLearnPage(AcceptanceTester $tester)
    {
        $tester->login('u@u.ru', 'user');
        $userProgress = $this->userProgressRepository->getByUserEmail('u@u.ru');


    }
}
