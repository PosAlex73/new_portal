<?php

namespace App\Services\Courses;

use App\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;

class CourseService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function saveCourseContent(Course $course, string $text)
    {
        $course->setText($text);
        $this->entityManager->flush();
    }

}
