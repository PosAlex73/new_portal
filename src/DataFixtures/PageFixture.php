<?php

namespace App\DataFixtures;

use App\Entity\Page;
use App\Enums\CommonStatus;
use App\Enums\Pages\PageCategories;
use App\Services\Menu\FooterMenuGetter;
use App\Services\Pages\PageContentGetter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class PageFixture extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private PageContentGetter $pageContentGetter
    ){}

    public function load(ObjectManager $manager)
    {
        $documentPages = $this->getPages();

        foreach ($documentPages as $documentPage) {
            $page = new Page();
            $page->setName($documentPage['pageName']);
            $page->setTitle($documentPage['title']);
            $page->setText($this->pageContentGetter->getPageContent($documentPage['pageName']));
            $page->setStatus(CommonStatus::ACTIVE->value);
            $page->setType(PageCategories::COMMON->value);

            $manager->persist($page);
        }

        $manager->flush();
    }

    private function getPages(): array
    {
        return [
            [
                'pageName' => 'cookie',
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
                'pageName' => 'offer',
                'title' => 'Оферта'
            ],
            [
                'pageName' => 'about_us',
                'title' => 'О нас'
            ],
            [
                'pageName' => 'help',
                'title' => 'Помощь'
            ],
            [
                'pageName' => 'service_statement',
                'title' => 'Сервисное соглашение'
            ]
        ];
    }

    public static function getGroups(): array
    {
        return ['g1', 'g3'];
    }
}
