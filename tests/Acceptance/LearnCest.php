<?php


namespace Tests\Acceptance;

use App\Entity\Task;
use App\Entity\UserProgress;
use App\Enums\Task\TaskTypes;
use App\Repository\UserProgressRepository;
use Symfony\Component\Routing\RouterInterface;
use Tests\Support\AcceptanceTester;

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
