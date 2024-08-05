<?php

namespace App\Controller\Admin\SimpleControllers;

use App\Entity\Course;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class TasksController extends AbstractController
{
    #[Route('/admin/course/show-tasks/{id}')]
    public function showTasks(Course $course)
    {
        $this->render('admin/tasks/list.html.twig', [
            'course' => $course,
            'tasks' => $course->getTasks()
        ]);
    }
}
