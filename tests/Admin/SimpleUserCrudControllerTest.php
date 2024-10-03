<?php

namespace App\Tests\Admin;

use App\Controller\Admin\IndexController;
use App\Controller\Admin\UserCrudController;
use App\Tests\Traits\LoginTrait;
use App\Tests\Traits\ServiceGetter;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

class SimpleUserCrudControllerTest extends AbstractCrudTestCase
{
    use ServiceGetter;
    use LoginTrait;

    protected function getControllerFqcn(): string
    {
        return UserCrudController::class;
    }

    protected function getDashboardFqcn(): string
    {
        return IndexController::class;
    }

    public function testIndexSimpleUserPage()
    {
        $this->loginAsUser($this->client);
        $this->client->request('GET', $this->generateIndexUrl());
        static::assertResponseStatusCodeSame(403);
    }

    public function testNoUser()
    {
        $this->client->request('GET', $this->generateIndexUrl());
        static::assertResponseRedirects();
    }
}
