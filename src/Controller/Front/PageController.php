<?php

namespace App\Controller\Front;

use App\Controller\Front\Traits\BackUrl;
use App\Enums\Flash\FlashTypes;
use App\Enums\Pages\PageNames;
use App\Repository\PageRepository;
use App\Services\Menu\BreadCrumbsBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    use BackUrl;

    public function __construct(
        protected PageRepository $pageRepository,
        protected BreadCrumbsBuilder $breadCrumbsBuilder
    ){}

    #[Route('/about-us', name: 'about_us')]
    public function aboutUs(Request $request): Response
    {
        $this->initBreadCrumbs();
        $this->breadCrumbsBuilder->addBreadCrumbs('О нас', $this->generateUrl('about_us'));
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
        $this->initBreadCrumbs();
        $this->breadCrumbsBuilder->addBreadCrumbs('Помощь', $this->generateUrl('help'));
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
        $this->initBreadCrumbs();
        $this->breadCrumbsBuilder->addBreadCrumbs('Сервисное соглашение', $this->generateUrl('service_statement'));
        $page = $this->pageRepository->getPageByName(PageNames::SERVICE_STATEMENT->name);

        if (empty($page)) {
            $this->addFlash(FlashTypes::ERROR->value, 'Страница временно не доступна');
            $this->redirect($this->getBackUrl($request));
        }

        return $this->render('front/pages/service_statement.html.twig', [
            'page' => $page
        ]);
    }

    private function initBreadCrumbs()
    {
        $this->breadCrumbsBuilder->addIndexRoute();
    }
}
