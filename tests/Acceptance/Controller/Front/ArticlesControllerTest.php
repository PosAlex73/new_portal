<?php

namespace App\Tests\Acceptance\Controller\Front;

use App\Entity\Article;
use App\Enums\CommonStatus;
use App\Enums\Http\HttpRequest;
use App\Enums\System\FrontRouteNames;
use App\Repository\ArticleRepository;
use App\Tests\Acceptance\ExtendedWebTestCase;
use App\Tests\Traits\ServiceGetter;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticlesControllerTest extends ExtendedWebTestCase
{
    public function testArticleList()
    {
        $client = static::createClient();

        /** @var ArticleRepository $articlesRepository */
        $articlesRepository = $this->getRepositoryByModel(Article::class);

        /** @var Article[] $articles */
        $articles = $articlesRepository->getForListPage(1);
        $this->assertNotEmpty($articles);

        $blogUrl = $this->getUrlGenerator()->generate(FrontRouteNames::BLOG_LIST->value);

        $client->request(HttpRequest::GET->value, $blogUrl);
        $this->assertResponseIsSuccessful();

        foreach ($articles as $article) {
            $this->assertAnySelectorTextContains('a', $article->getTitle());
        }
    }

    public function testArticleDetails()
    {
        $client = static::createClient();
        $em = $this->getEntityManager();
        $urlGenerator = $this->getUrlGenerator();

        $article = new Article();
        $article->setStatus(CommonStatus::ACTIVE->value);
        $article->setTitle('ttt');
        $article->setText('text');
        $article->setViews(0);
        $em->persist($article);
        $em->flush();

        $client->request(
            HttpRequest::GET->value,
            $urlGenerator->generate(FrontRouteNames::BLOG_DETAILS->value, ['id' => $article->getId()])
        );

        $this->assertResponseIsSuccessful();
        $this->assertAnySelectorTextContains('h2', $article->getTitle());
    }
}
