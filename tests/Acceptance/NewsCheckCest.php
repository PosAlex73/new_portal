<?php

namespace App\Tests\Acceptance;

use App\Tests\Support\AcceptanceTester;

class NewsCheckCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function testNews(AcceptanceTester $I)
    {
        $I->amOnPage('/news');
        $I->see('Новости');
        $I->see('Посмотреть новость');
        $I->see('Назад');
        $I->see('Вперед');
        $I->see('Личный кабинет');
        $I->click('[data-news-link="true"]');
        $I->seeElement('[data-news-title]');
        $I->see('Назад к списку');
        $I->click('[data-news-list-back-button]');
        $I->see('Новости');
    }

    public function testNewsFail(AcceptanceTester $I)
    {
        $I->amOnPage('/news/fsdfsdfsdfsd');
        $I->dontSeeElement('[data-news-title]');
        $I->dontSeeElement('[data-news-list-back-button]');
    }
}
