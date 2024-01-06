<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    public function __construct(protected CategoryRepository $categoryRepository)
    {
    }

    #[Route('/admin/category', name: 'categories_list')]
    public function index(): Response
    {
        $categories = $this->categoryRepository->getWithPaginate();

        return $this->render('admin/categories/list.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
}
