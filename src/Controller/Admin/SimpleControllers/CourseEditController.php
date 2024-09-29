<?php

namespace App\Controller\Admin\SimpleControllers;

use App\Controller\Front\Traits\BackUrl;
use App\Entity\Course;
use App\Enums\Flash\FlashTypes;
use App\Enums\Http\HttpRequest;
use App\Services\Courses\CourseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CourseEditController extends AbstractController
{
    use BackUrl;

    public function __construct(private CourseService $courseService)
    {

    }

    #[Route('/admin/editCourse/{id}', name: 'editCourse', methods: ['GET', 'POST'])]
    public function editCourse(Request $request, Course $course): Response
    {
        if ($request->getMethod() === HttpRequest::POST->value) {
            $content = $request->get('content');
            $this->courseService->saveCourseContent($course, $content);

            $this->addFlash(FlashTypes::SUCCESS->value, 'Текст курса сохранён');

            return $this->redirect($this->getBackUrl($request));
        }

        return $this->render('admin/courses/course_edit.html.twig', [
            'course' => $course
        ]);
    }
}
