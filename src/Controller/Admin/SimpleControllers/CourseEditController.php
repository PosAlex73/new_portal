<?php

namespace App\Controller\Admin\SimpleControllers;

use App\Entity\Course;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CourseEditController extends AbstractController
{
    #[Route('/admin/editCourse/{id}', name: 'editCourse', methods: ['GET', 'POST'])]
    public function editCourse(Request $request, Course $course): Response
    {
        return $this->render('admin/courses/course_edit.html.twig', [
            'course' => $course
        ]);
    }
}
