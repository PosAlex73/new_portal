<?php


namespace Tests\Acceptance;

use App\Repository\UserRepository;
use Tests\Support\AcceptanceTester;

class ProfileCest
{
    public function _before(AcceptanceTester $tester)
    {
        $this->userRepository = $tester->grabService(UserRepository::class);
    }

    // tests
    public function testLoginLink(AcceptanceTester $tester)
    {
        $tester->amOnPage('/');
        $tester->see('Войти');
        $tester->see('Регистрация');
        $tester->click('[data-login-link]');
        $tester->see('Вход в личный кабинет');
        $tester->see('Email адрес');
        $tester->see('Пароль');
        $tester->see('Запомнить меня');
        $tester->see('Восстановить пароль');
    }

    public function testLoginForm(AcceptanceTester $tester)
    {
        $tester->login('u@u.ru', 'user');
        $tester->see('Мой профиль');
        $tester->click('[data-logout-button]');
        $tester->amOnPage('/');
        $tester->see('Войти');
        $tester->dontSee('Мой профиль');
    }

    public function testProfileTabs(AcceptanceTester $tester)
    {
        $tester->login('u@u.ru', 'user');
        $tester->amOnPage('/profile');
        $tester->see('Общая информация');
        $tester->see('Обучение');
        $tester->see('Настройки');
        $tester->seeElement('[name="user_form[email]"]');
        $tester->seeElement('[name="user_form[firstName]"]');
        $tester->seeElement('[name="user_form[lastName]"]');
        $tester->seeElement('[name="user_form[submit]"]');
        $tester->submitForm('[name="user_form"]', [
            '[name="user_form[firstName]"]' => 'ivann',
            '[name="user_form[lasName]"]' => 'ivanov',
            '[name="user_form[email]"]' => 'u@u.ru',
        ]);
        $tester->see('Информация обновлена!');
        $tester->see('ivann');
        $tester->see('ivanov');
    }
}
