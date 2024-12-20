<?php

namespace App\Tests\Acceptance\Controller\Front;

use App\Entity\AppNew;
use App\Enums\CommonStatus;
use App\Enums\Http\HttpRequest;
use App\Enums\Settings\SettingEnum;
use App\Enums\System\FrontRouteNames;
use App\Repository\AppNewRepository;
use App\Tests\Acceptance\ExtendedWebTestCase;

class NewsControllerTest extends ExtendedWebTestCase
{
    public function testNewList()
    {
        $client = static::createClient();

        /** @var AppNewRepository $newsRepository */
        $newsRepository = $this->getRepositoryByModel(AppNew::class);
        $urlGenerator = $this->getUrlGenerator();

        $frontPageNumber = $this->getSet()->get(SettingEnum::FRONT_PAGINATION);

        /** @var AppNew[] $news */
        $news = $newsRepository->getForListPage($frontPageNumber->getValue());
        $client->request(
            HttpRequest::GET->value,
            $urlGenerator->generate(FrontRouteNames::NEWS_LIST->value)
        );

        $this->assertResponseIsSuccessful();
        foreach ($news as $new) {
            $this->assertAnySelectorTextContains('h2', $new->getTitle());
        }
    }

    public function testNewsDetails()
    {
        $client = static::createClient();

        $new = new AppNew();
        $new->setTitle('test new');
        $new->setText('test test');
        $new->setStatus(CommonStatus::ACTIVE->value);
        $new->setViews(0);

        $em = $this->getEntityManager();
        $em->persist($new);
        $em->flush();

        $urlGenerator = $this->getUrlGenerator();
        $client->request(
            HttpRequest::GET->value,
            $urlGenerator->generate(FrontRouteNames::NEWS_DETAILS->value, ['id' => $new->getId()])
        );

        $this->assertResponseIsSuccessful();
        $this->assertAnySelectorTextContains('h2', $new->getTitle());
    }
}
