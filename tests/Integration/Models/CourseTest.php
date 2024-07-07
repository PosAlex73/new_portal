<?php

namespace App\Tests\Integration\Models;

use App\Entity\Course;
use App\Enums\Courses\CourseStatuses;
use App\Enums\Courses\CourseTypes;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CourseTest extends KernelTestCase
{
    public function testCourseDates(): void
    {
        $kernel = self::bootKernel();

        /** @var EntityManager $em */
        $em = $this->getContainer()->get(EntityManagerInterface::class);
        $course = $this->getCourseForTest();

        $this->assertEmpty($course->getCreated());
        $this->assertEmpty($course->getUpdated());

        $em->persist($course);
        $em->flush();

        $this->assertNotEmpty($course->getCreated());
        $this->assertNotEmpty($course->getUpdated());
    }

    private function getCourseForTest(): Course
    {
        $course = new Course();
        $course->setText('test');
        $course->setTitle('test_title');
        $course->setStatus(CourseStatuses::ACTIVE->value);
        $course->setType(CourseTypes::FREE->value);
        $course->setPosition(0);
        $course->setCourseCode('php');
        $course->setLang('php');

        return $course;
    }
}
