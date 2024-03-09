<?php


namespace Tests\Acceptance;

use Symfony\Component\Routing\RouterInterface;
use Tests\Support\AcceptanceTester;

class IndexPageCest
{
    public function _before(AcceptanceTester $I)
    {

    }

    public function frontpageWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Популярные курсы');
        $I->see('Курсы');
        $I->see('Новости');
        $I->see('Статьи');
    }

    public function testMenu(AcceptanceTester $I)
    {
        /** @var RouterInterface $router */
        $router = $I->grabService(RouterInterface::class);
        $courseUrl = $router->generate('courses_list');

        $I->amOnPage($courseUrl);
        $I->see('Список курсов');
        $I->see('Посмотреть курс');
        $I->dontSee('fsdfdsfsd');

        $newsUrl = $router->generate('news_list');
        $I->amOnPage($newsUrl);
        $I->see('Новости');
        $I->see('Посмотреть новость');
        $I->dontSee('Посмотреть курсы');
    }
}
