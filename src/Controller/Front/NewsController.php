<?php

namespace App\Controller\Front;

use App\Controller\Front\Traits\BackUrl;
use App\Entity\AppNew;
use App\Enums\CommonStatus;
use App\Enums\Flash\FlashTypes;
use App\Enums\Settings\SettingEnum;
use App\Repository\AppNewRepository;
use App\Services\Settings\Set;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    use BackUrl;

    public function __construct(
        protected AppNewRepository $appNewRepository,
        protected Set $set
    ){}

    #[Route('/news', name: 'news_list')]
    public function index(Request $request): Response
    {
        $offset = max(0, $request->get('offset', 0));
        $frontendPageNumber = $this->set->get(SettingEnum::FRONT_PAGINATION);
        $news = $this->appNewRepository->getForListPage($frontendPageNumber->getValue(), $offset);

        return $this->render('front/news/index.html.twig', [
            'paginator' => $news,
            'previous' => $offset - $frontendPageNumber->getValue(),
            'next' => min(count($news), $offset + $frontendPageNumber->getValue())
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
