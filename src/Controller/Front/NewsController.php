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
    public function index(): Response
    {
        $news = $this->appNewRepository->getForListPage();

        return $this->render('front/news/index.html.twig', [
            'news' => $news,
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
