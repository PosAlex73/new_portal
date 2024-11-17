<?php

namespace App\DataFixtures;

use App\Entity\Page;
use App\Enums\CommonStatus;
use App\Enums\Pages\PageCategories;
use App\Services\Menu\FooterMenuGetter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class PageFixture extends Fixture implements FixtureGroupInterface
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

        $documentPages = [
            [
                'pageName' => 'cookie_page',
                'title' => 'Использование cookie',
            ],
            [
                'pageName' => 'personal_data',
                'title' => 'Соглашение об использовании персональных данных'
            ],
            [
                'pageName' => 'use_materials',
                'title' => 'Соглашение об использовании материалов'
            ],
            [
                'pageName' => 'offerPage',
                'title' => 'Оферта'
            ],
        ];

        foreach ($documentPages as $documentPage) {
            $page = new Page();
            $page->setName($documentPage['pageName']);
            $page->setTitle($documentPage['title']);
            $page->setText('');
            $page->setStatus(CommonStatus::ACTIVE->value);
            $page->setType(PageCategories::COMMON->value);

            $manager->persist($page);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['g1', 'g3'];
    }
}
