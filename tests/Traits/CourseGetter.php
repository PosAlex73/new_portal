<?php

namespace App\Tests\Traits;

use App\Entity\Course;
use App\Repository\CourseRepository;
use App\Tests\TestExceptions\MethodNotExistsException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

trait CourseGetter
{
    private function getCourseRepository(): CourseRepository
    {
        if (!method_exists($this, 'getContainer')) {
            throw new MethodNotExistsException();
        }

        /** @var EntityManager $em */
        $em = $this->getContainer()->get(EntityManagerInterface::class);

        /** @var CourseRepository $courseRepository */
        $courseRepository = $em->getRepository(Course::class);

        return $courseRepository;
    }
}
