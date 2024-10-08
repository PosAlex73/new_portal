<?php

namespace App\Controller\Front;

use App\Controller\Front\Traits\BackUrl;
use App\Entity\Article;
use App\Enums\CommonStatus;
use App\Enums\Flash\FlashTypes;
use App\Enums\Settings\SettingEnum;
use App\Repository\ArticleRepository;
use App\Services\Settings\Set;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    use BackUrl;

    public function __construct(
        protected ArticleRepository $articleRepository,
        protected Set $set
    ){}

    #[Route('/blog', name: 'blog_list')]
    public function index(Request $request): Response
    {
        $offset = max(0, $request->get('offset', 0));
        $frontendPageNumber = $this->set->get(SettingEnum::FRONT_PAGINATION);
        $articles = $this->articleRepository->getForListPage($frontendPageNumber->getValue(), $offset);

        $data = [
            'paginator' => $articles,
            'previous' => $offset - $frontendPageNumber->getValue(),
            'next' => min(count($articles), $offset + $frontendPageNumber->getValue())
        ];

        return $this->render('front/blog/index.html.twig', $data);
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
