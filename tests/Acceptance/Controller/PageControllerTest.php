<?php

namespace App\Tests\Acceptance\Controller;

use App\Entity\Page;
use App\Enums\Http\HttpRequest;
use App\Enums\Pages\PageNames;
use App\Enums\System\FrontRouteNames;
use App\Repository\PageRepository;
use App\Tests\Traits\ServiceGetter;
use PHPUnit\Util\Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
    use ServiceGetter;

    public function testPages()
    {
        $client = static::createClient();

        /** @var PageRepository $pageRepository */
        $pageRepository = $this->getRepositoryByModel(Page::class);
        $em = $this->getEntityManager();
        $urlGenerator = $this->getUrlGenerator();

        $pages = PageNames::cases();

        foreach ($pages as $page) {
            $aboutUs = $pageRepository->getPageByName($page->value);
            $aboutUs->setText('test test test');

            $em->flush();

            $client->request(
                HttpRequest::GET->value,
                $urlGenerator->generate($this->getRouteForPage($page))
            );

            $this->assertResponseIsSuccessful();
            $this->assertSelectorTextContains('div', 'test test test');
        }
    }

    private function getRouteForPage(PageNames $pageName)
    {
        return match ($pageName->value) {
            PageNames::ABOUT_US->value => FrontRouteNames::ABOUT_US->value,
            PageNames::HELP->value => FrontRouteNames::HELP->value,
            PageNames::SERVICE_STATEMENT->value => FrontRouteNames::SERVICE_STATEMENT->value,
            default => throw new Exception(sprintf('Роут для указанной страницы не найден: %s', $pageName->value))
        };
    }
}
