<?php

namespace App\Controller\Front;

use App\Enums\System\FrontRouteNames;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    public function __construct(protected CourseRepository $courseRepository)
    {
    }

    #[Route('/', name: 'front_index')]
    public function index(): Response
    {
        $courses = $this->courseRepository->getForIndexPage();

        return $this->render('front/index/index.html.twig', [
            'courses' => $courses,
        ]);
    }
}
