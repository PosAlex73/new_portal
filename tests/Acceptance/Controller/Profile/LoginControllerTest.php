<?php

namespace App\Tests\Acceptance\Controller\Profile;

use App\Enums\Http\HttpRequest;
use App\Enums\System\FrontRouteNames;
use App\Tests\Acceptance\ExtendedWebTestCase;

class LoginControllerTest extends ExtendedWebTestCase
{
    public function testLoginForm()
    {
        $client = static::createClient();
        $urlGenerator = $this->getUrlGenerator();

        $client->request(
            HttpRequest::GET->value,
            $urlGenerator->generate(FrontRouteNames::LOGIN->value)
        );

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('[type="email"]');
        $this->assertSelectorExists('[type="password"]');
        $this->assertSelectorTextContains('button', 'Войти');

//        $client->submitForm('Войти', [
//            '[type="email"]' => 'u@u.fdfsd',
//            '[type="password"]' => 'user',
//        ], HttpRequest::POST->value);
    }
}
