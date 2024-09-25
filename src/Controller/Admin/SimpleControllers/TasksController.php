<?php

namespace App\Controller\Admin\SimpleControllers;

use App\Entity\Course;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class TasksController extends AbstractController
{
    #[Route('/admin/course/show-tasks/{id}', name: 'show_tasks')]
    public function showTasks(Course $course)
    {
        return $this->render('admin/tasks/list.html.twig', [
            'course' => $course,
            'tasks' => $course->getTasks()
        ]);
    }

    public function disableTasks()
    {

    }
}
