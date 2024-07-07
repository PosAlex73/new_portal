<?php

namespace App\Tests\Acceptance\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Tests\Traits\ServiceGetter;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NewsControllerTest extends WebTestCase
{
    use ServiceGetter;

    public function testNewsList()
    {
        $client = static::createClient();

        /** @var ArticleRepository $articlesRepository */
        $articlesRepository = $this->getRepositoryByModel(Article::class);


        /** @var Article[] $articles */
        $articles = $articlesRepository->getForListPage(1);
        $this->assertNotEmpty($articles);

        $blogUrl = $this->getUrlGenerator()->generate('blog_list');

        $client->request('GET', $blogUrl);
        $this->assertResponseIsSuccessful();
    }
}
