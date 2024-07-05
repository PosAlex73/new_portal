<?php

namespace App\Tests\Acceptance;

use App\Entity\UserProgress;
use App\Repository\UserProgressRepository;
use App\Tests\Support\AcceptanceTester;
use Symfony\Component\Routing\RouterInterface;

class LearnCest
{
    private UserProgressRepository $userProgressRepository;

    private RouterInterface $router;

    public function _before(AcceptanceTester $tester)
    {
        $this->userProgressRepository = $tester->grabService(UserProgressRepository::class);
        $this->router = $tester->grabService(RouterInterface::class);
    }

    // tests
    public function testLearn(AcceptanceTester $tester)
    {
        /** @var UserProgress[] $userProgress */
        $userProgress = $this->userProgressRepository->getByUserEmail('u@u.ru');
        $firstUserProgress = current($userProgress);
        $learnUrl = $this->router->generate('front_learn', ['id' => $firstUserProgress->getId()]);

        $tester->amOnPage($learnUrl);
        $tester->dontSee('Информация о курсе');
        $tester->dontSee('Задачи');
        $tester->login('u@u.ru', 'user');
        $tester->see('Информация о курсе');
        $tester->see('Задачи');
        $tester->see('Название');
        $tester->see('Тип задачи');
        $tester->see('Выполнение');
    }
}
