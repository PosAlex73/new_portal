<?php

namespace App\Controller\Front;

use App\Form\SearchFormType;
use App\Services\Search\SearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    public function __construct(protected SearchService $searchService)
    {
    }

    #[Route('/search', name: 'search')]
    public function index(Request $request): Response
    {
        $text = $request->get('search');
        $search = $this->searchService->search($text);

        return $this->render('front/search/index.html.twig', [
            'courses' => $search['courses'],
            'articles' => $search['articles'],
            'news' => $search['news']
        ]);
    }
}
