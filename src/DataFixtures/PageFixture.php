<?php

namespace App\DataFixtures;

use App\Entity\Page;
use App\Enums\CommonStatus;
use App\Enums\Pages\PageCategories;
use App\Services\Menu\FooterMenu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PageFixture extends Fixture
{
    public function __construct(
        protected FooterMenu $footerMenu
    ){}

    public function load(ObjectManager $manager)
    {
        $footerMenuPages = $this->footerMenu->getFooterMenu();
        foreach ($footerMenuPages as $menuItem) {
            $page = new Page();
            $page->setTitle($menuItem->title);
            $page->setText('');
            $page->setStatus(CommonStatus::ACTIVE->value);
            $page->setType(PageCategories::COMMON->value);
            $manager->persist($page);
        }

        $manager->flush();
    }
}
