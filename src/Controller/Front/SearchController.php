<?php

namespace App\Controller\Front;

use App\Enums\Http\HttpRequest;
use App\Services\Menu\BreadCrumbsBuilder;
use App\Services\Search\SearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    public function __construct(
        protected SearchService $searchService,
        protected BreadCrumbsBuilder $breadCrumbsBuilder
    )
    {
    }

    #[Route('/search', name: 'search')]
    public function index(Request $request): Response
    {
        $this->initBreadCrumbs();
        if ($request->getMethod() === HttpRequest::POST->value) {
            $text = $request->get('search');
            $search = $this->searchService->search($text);

            return $this->render('front/search/index.html.twig', [
                'courses' => $search['courses'],
                'articles' => $search['articles'],
                'news' => $search['news'],
                'newSearch' => false,
                'searchText' => $text
            ]);
        }

        return $this->render('front/search/index.html.twig', [
            'newSearch' => true,
            'searchText' => ''
        ]);
    }

    private function initBreadCrumbs()
    {
        $this->breadCrumbsBuilder->addIndexRoute();
        $this->breadCrumbsBuilder->addBreadCrumbs('Поиск', $this->generateUrl('search'));
    }
}
