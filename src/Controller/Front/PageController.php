<?php

namespace App\Controller\Front;

use App\Controller\Front\Traits\BackUrl;
use App\Enums\Flash\FlashTypes;
use App\Enums\Pages\PageNames;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    use BackUrl;

    public function __construct(protected PageRepository $pageRepository)
    {
    }

    #[Route('/about-us', name: 'about_us')]
    public function aboutUs(Request $request): Response
    {
        $page = $this->pageRepository->getPageByName(PageNames::ABOUT_US->name);

        if (empty($page)) {
            $this->addFlash(FlashTypes::ERROR->value, 'Страница временно не доступна');
            $this->redirect($this->getBackUrl($request));
        }

        return $this->render('front/pages/about_us.html.twig', [
            'page' => $page
        ]);
    }

    #[Route('/help', name: 'help')]
    public function help(Request $request): Response
    {
        $page = $this->pageRepository->getPageByName(PageNames::HELP->name);

        if (empty($page)) {
            $this->addFlash(FlashTypes::ERROR->value, 'Страница временно не доступна');
            $this->redirect($this->getBackUrl($request));
        }

        return $this->render('front/pages/help.html.twig', [
            'page' => $page
        ]);
    }

    #[Route('service-statement', name: 'service_statement')]
    public function serviceStatement(Request $request): Response
    {
        $page = $this->pageRepository->getPageByName(PageNames::SERVICE_STATEMENT->name);

        if (empty($page)) {
            $this->addFlash(FlashTypes::ERROR->value, 'Страница временно не доступна');
            $this->redirect($this->getBackUrl($request));
        }

        return $this->render('front/pages/service_statement.html.twig', [
            'page' => $page
        ]);
    }
}
