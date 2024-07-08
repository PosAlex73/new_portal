<?php

namespace App\Controller\Front;

use App\Controller\Front\Traits\BackUrl;
use App\Entity\AppNew;
use App\Enums\CommonStatus;
use App\Enums\Flash\FlashTypes;
use App\Repository\AppNewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    use BackUrl;

    public function __construct(protected AppNewRepository $appNewRepository)
    {
    }

    #[Route('/news', name: 'news_list')]
    public function index(Request $request): Response
    {
        $page = $request->get('page', 1);
        $news = $this->appNewRepository->getForListPage($page);

        return $this->render('front/news/index.html.twig', [
            'paginator' => $news,
        ]);
    }

    #[Route('/news/details/{id}', name: 'news_details')]
    public function detail(AppNew $appNew, Request $request)
    {
        if ($appNew->getStatus() !== CommonStatus::ACTIVE->value) {
            $this->addFlash(FlashTypes::ERROR->value, 'Новость пока что не опубликована');

            return $this->redirect($this->getBackUrl($request));
        }

        return $this->render('front/news/details.html.twig', [
            'new' => $appNew
        ]);
    }
}
