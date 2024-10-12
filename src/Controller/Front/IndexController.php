<?php

namespace App\Controller\Front;

use App\Repository\CourseRepository;
use App\Services\Menu\BreadCrumbsBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    public function __construct(
        protected CourseRepository $courseRepository,
        protected BreadCrumbsBuilder $breadCrumbsService
    ){}

    #[Route('/', name: 'front_index')]
    public function index(): Response
    {
        $courses = $this->courseRepository->getForIndexPage();

        $this->breadCrumbsService->addBreadCrumbs('Главная', $this->generateUrl('front_index'));

        return $this->render('front/index/index.html.twig', [
            'courses' => $courses,
        ]);
    }
}
