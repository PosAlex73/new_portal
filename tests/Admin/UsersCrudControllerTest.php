<?php

namespace App\Tests\Admin;

use App\Controller\Admin\IndexController;
use App\Controller\Admin\UserCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

class UsersCrudControllerTest extends AbstractCrudTestCase
{

    protected function getControllerFqcn(): string
    {
       return UserCrudController::class;
    }

    protected function getDashboardFqcn(): string
    {
        return IndexController::class;
    }

    public function testIndexPage()
    {
        $this->client->request('GET', $this->generateIndexUrl());
        static::assertResponseRedirects();
    }
}
