<?php

namespace App\Tests\Acceptance\Controller\Profile;

use App\Entity\UserProgress;
use App\Enums\Http\HttpRequest;
use App\Enums\System\FrontRouteNames;
use App\Tests\Acceptance\ExtendedWebTestCase;

class ProfileControllerTest extends ExtendedWebTestCase
{
    public function testUserProfile()
    {
        $client = static::createClient();
        $this->loginDefaultTestUser($client);

        $client->request(
            HttpRequest::GET->value,
            $this->getUrlByRouteName(FrontRouteNames::PROFILE)
        );

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('[id="user_form_email"]');
        $this->assertSelectorExists('[id="user_form_firstName"]');
        $this->assertSelectorExists('[id="user_form_lastName"]');

        $this->assertAnySelectorTextContains('a', 'Общая информация');
        $this->assertAnySelectorTextContains('a', 'Обучение');
        $this->assertAnySelectorTextContains('a', 'Настройки');

        $client->clickLink('Обучение');
        $this->assertAnySelectorTextContains('th', 'Название курса');
        $this->assertAnySelectorTextContains('th', 'Количество задач в курсе');

        /** @var UserProgress[] $userProgress */
        $userProgress = $this->getUserProgressRepository()->getByUserEmail('u@u.ru');

        foreach ($userProgress as $progress) {
            $this->assertAnySelectorTextContains('td', $progress->getCourse()->getTitle());
        }

        $client->clickLink('Настройки');
        $this->assertResponseIsSuccessful();

        $this->assertAnySelectorTextContains('label', 'Получать уведомления от администрации на почту');
        $client->clickLink('Обучение');
        $client->clickLink('Начать обучение');
        $this->assertResponseIsSuccessful();

        $this->assertAnySelectorTextContains('a', 'Информация о курсе');
        $this->assertAnySelectorTextContains('a', 'Задачи');
    }
}
