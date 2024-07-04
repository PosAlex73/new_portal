<?php

namespace App\DataFixtures;

use App\Entity\Page;
use App\Enums\CommonStatus;
use App\Enums\Pages\PageCategories;
use App\Services\Menu\FooterMenuGetter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PageFixture extends Fixture
{
    public function __construct(
        protected FooterMenuGetter $footerMenu
    ){}

    public function load(ObjectManager $manager)
    {
        $footerMenuElements = $this->footerMenu->getFooterMenuData();

        foreach ($footerMenuElements as $footerMenuElement) {
            $page = new Page();
            $page->setName($footerMenuElement->getName());
            $page->setTitle($footerMenuElement->getTitle());
            $page->setText('');
            $page->setStatus(CommonStatus::ACTIVE->value);
            $page->setType(PageCategories::COMMON->value);

            $manager->persist($page);
        }

        $manager->flush();
    }
}
