<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    public function __construct(protected CategoryRepository $categoryRepository)
    {
    }

    #[Route('/admin/category', name: 'categories_list')]
    public function index(Request $request): Response
    {
        $page = $request->get('page', 0);
        $categories = $this->categoryRepository->getWithPaginate($page);

        return $this->render('admin/categories/list.html.twig', [
            'categories' => $categories,
            'page' => $page
        ]);
    }

    #[Route('/admin/categories/delete', name: 'categories_delete')]
    public function delete(Request $request)
    {

    }

    #[Route('/admin/categories/create', name: 'categories_create')]
    public function create()
    {

    }

    #[Route('/admin/categories/update/{id}', name: 'categories_update')]
    public function update(Category $category)
    {

    }
}
