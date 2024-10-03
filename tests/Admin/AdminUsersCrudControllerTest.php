<?php

namespace App\Tests\Admin;

use App\Controller\Admin\IndexController;
use App\Controller\Admin\UserCrudController;
use App\Tests\Traits\LoginTrait;
use App\Tests\Traits\ServiceGetter;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

class AdminUsersCrudControllerTest extends AbstractCrudTestCase
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

    public function testIndexAdminUserPage()
    {
        $this->loginAsUser($this->client, 'a@a.ru');
        $this->client->request('GET', $this->generateIndexUrl());
        static::assertResponseIsSuccessful();
    }
}
