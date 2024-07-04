<?php

namespace App\Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class ArticlesCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->amOnPage('/blog');
        $I->see('Назад');
        $I->see('Вперед');
        $I->see('Посмотреть статью');
        $I->seeElement('[data-blog-title]');
        $I->click('[data-blog-details-button]');
        $I->seeElement('[data-article-title]');
        $I->see('Назад к списку статей');
        $I->seeElement('[data-blog-back-button]');
        $I->click('[data-blog-back-button]');
        $I->see('Посмотреть статью');
    }
}
