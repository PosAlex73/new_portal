<?php

namespace App\Controller\Front;

use App\Controller\Front\Traits\BackUrl;
use App\Entity\Article;
use App\Enums\CommonStatus;
use App\Enums\Flash\FlashTypes;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    use BackUrl;

    public function __construct(protected ArticleRepository $articleRepository)
    {
    }

    #[Route('/blog', name: 'blog_list')]
    public function index(): Response
    {
        $articles = $this->articleRepository->getForListPage();

        return $this->render('front/blog/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/blog/details/{id}', name: 'blog_details')]
    public function details(Article $article, Request $request)
    {
        if ($article->getStatus() !== CommonStatus::ACTIVE->value) {
            $this->addFlash(FlashTypes::ERROR->value, 'Данная статья пока что не опубликована');

            $this->redirect($this->getBackUrl($request));
        }

        return $this->render('front/blog/details.html.twig', [
            'article' => $article
        ]);
    }
}
