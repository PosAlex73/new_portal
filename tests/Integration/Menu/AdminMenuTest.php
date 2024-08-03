<?php

namespace App\Tests\Integration\Menu;

use App\Services\Menu\AdminMainMenu;
use App\Tests\Acceptance\ExtendedWebTestCase;
use App\Tests\Integration\BaseKernelTestCase;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Routing\Generator\UrlGenerator;

class AdminMenuTest extends BaseKernelTestCase
{
    public function testGetAdminMenu()
    {
        self::bootKernel();

        /** @var AdminMainMenu $adminMenu */
        $adminMenu = $this->getContainer()->get(AdminMainMenu::class);

        $menuItems = $adminMenu->getMainMenu();
        $this->assertCount(3, $menuItems);

        foreach ($menuItems as $menuItem) {
            $this->assertNotEmpty($menuItem->title);
            $this->assertNotEmpty($menuItem->route);
        }
    }

    public function testTest()
    {
        $urlGeneratorMock = $this->createMock(UrlGenerator::class);
        $urlGeneratorMock->method('generate')->willReturn('lalalala');

        $this->assertEquals('lalalala', $urlGeneratorMock->generate('fdfd'));

    }
}
