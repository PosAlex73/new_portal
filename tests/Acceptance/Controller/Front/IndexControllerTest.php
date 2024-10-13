<?php

namespace App\Tests\Acceptance\Controller\Front;

use App\Entity\Course;
use App\Enums\Courses\CourseStatuses;
use App\Repository\CourseRepository;
use App\Tests\Acceptance\ExtendedWebTestCase;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class IndexControllerTest extends ExtendedWebTestCase
{
    public function testIndexPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertAnySelectorTextContains('a', 'Войти');
        $this->assertAnySelectorTextContains('a', 'Курсы');
        $this->assertAnySelectorTextContains('a', 'Новости');
        $this->assertAnySelectorTextContains('a', 'Статьи');

        /** @var EntityManager $em */
        $em = $this->getContainer()->get(EntityManagerInterface::class);

        /** @var CourseRepository $courseRepository */
        $courseRepository = $em->getRepository(Course::class);

        /** @var Course[] $courses */
        $courses = $courseRepository->getForIndexPage();

        foreach ($courses as $course) {
            $this->assertAnySelectorTextContains('h4', $course->getTitle());
        }
    }

    public function testDisabledCoursesOnIndexpage()
    {
        $client = static::createClient();

        /** @var EntityManager $em */
        $em = $this->getContainer()->get(EntityManagerInterface::class);

        /** @var CourseRepository $courseRepository */
        $courseRepository = $em->getRepository(Course::class);

        /** @var Course[] $courses */
        $courses = $courseRepository->getForIndexPage();

        foreach ($courses as $course) {
            $course->setStatus(CourseStatuses::DISABLED->value);
        }

        $em->flush();
        $client->request('GET', '/');

        foreach ($courses as $course) {
            $this->assertAnySelectorTextNotContains('h4', $course->getTitle());
        }
    }
}
