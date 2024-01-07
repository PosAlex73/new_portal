<?php

namespace App\Controller\Front;

use App\Controller\Front\Traits\BackUrl;
use App\Entity\Course;
use App\Enums\Courses\CourseStatuses;
use App\Enums\Flash\FlashTypes;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursesController extends AbstractController
{
    use BackUrl;

    public function __construct(protected CourseRepository $courseRepository)
    {
    }

    #[Route('/courses', name: 'courses_list')]
    public function index(): Response
    {
        $courses = $this->courseRepository->getForCoursePage();

        return $this->render('front/courses/index.html.twig', [
            'courses' => $courses,
        ]);
    }

    #[Route('/courses/details/{id}', name: 'courses_detail')]
    public function details(Course $course, Request $request)
    {
        if ($course->getStatus() !== CourseStatuses::ACTIVE->value) {
            $this->addFlash(FlashTypes::NOTICE->value, 'Данный курс не доступен или был отключен');

            $this->redirect($this->getBackUrl($request));
        }

        return $this->render('front/courses/detail.html.twig', [
            'course' => $course
        ]);
    }
}
