<?php

namespace App\Tests\Acceptance;

use App\Repository\UserProgressRepository;
use App\Repository\UserRepository;
use Tests\Support\AcceptanceTester;

class ProfileCest
{
    /**
     * @var UserProgressRepository
     */
    private $userProgressRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function _before(AcceptanceTester $tester)
    {
        $this->userRepository = $tester->grabService(UserRepository::class);
        $this->userProgressRepository = $tester->grabService(UserProgressRepository::class);
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

        $tester->submitForm('#user_profile_form', [
            'user_form[firstName]' => 'ivann',
            'user_form[lastName]' => 'ivanov',
            'user_form[email]' => 'u@u.ru',
        ]);
        $tester->see('Информация обновлена!');
        $tester->see('ivann');
        $tester->see('ivanov');

        $tester->submitForm('#user_profile_form', [
            'user_form[firstName]' => 'f',
            'user_form[lastName]' => 'f',
            'user_form[email]' => 'u@u.ru',
        ]);
        $tester->see('Значение слишком короткое. Должно быть равно 5 символам или больше.');
    }

    public function testLearnTab(AcceptanceTester $tester)
    {
        $tester->login('u@u.ru', 'user');
        $tester->amOnPage('/profile');
        $tester->see('Обучение');
        $tester->seeElement('[data-profile-learn-tab]');
        $tester->click('[data-profile-learn-tab]');
        $tester->seeInCurrentUrl('/progress');
        $tester->see('Курсы для обучения');

        $user = $this->userRepository->findOneBy([
            'email' => 'u@u.ru'
        ]);

        $userProgressCourses = $this->userProgressRepository->getProgressByUserId($user->getId());

        foreach ($userProgressCourses as $userProgress) {
            $tester->see($userProgress->getCourse()->getTitle());
        }
    }

    public function testSettingsTab(AcceptanceTester $tester)
    {
        $tester->login('u@u.ru', 'user');
        $tester->amOnPage('/profile');
        $tester->click('[data-profile-settings-tab]');
        $tester->see('Настройки пользователя');
        $tester->see('Активно');
        $tester->see('Сохранить настройки');
        $tester->selectOption('#user_profile_form_adminNotification', 'Отключено');
        $tester->click('Сохранить настройки');
        $tester->see('Профиль успешно обновлен!');
    }

    public function testNotifications(AcceptanceTester $tester)
    {
        $tester->amOnPage('/notifications');
        $tester->see('Вход в личный кабинет');
        $tester->login('u@u.ru', 'user');
        $tester->amOnPage('/notifications');
        $tester->see('Уведомления');
    }
}
