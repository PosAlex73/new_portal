<?php

namespace App\Tests\Acceptance\Controller\Front;

use App\Entity\Course;
use App\Enums\Courses\CourseStatuses;
use App\Tests\Acceptance\ExtendedWebTestCase;
use App\Tests\Traits\CourseGetter;
use App\Tests\Traits\EntityManagerGetter;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CourseControllerTest extends ExtendedWebTestCase
{
    use CourseGetter;
    use EntityManagerGetter;

    public function testCourseListPage()
    {
        $client = static::createClient();

        $client->request('GET', '/courses');
        $this->assertAnySelectorTextContains('a', 'Посмотреть курс');
        $this->assertAnySelectorTextContains('h4', 'Список курсов');

        $client->clickLink('Посмотреть курс');
        $this->assertResponseIsSuccessful();
    }

    public function testCourseDetailPage()
    {
        $client = static::createClient();

        $courseRepository = $this->getCourseRepository();
        $em = $this->getEntityManager();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $this->getContainer()->get(UrlGeneratorInterface::class);

        /** @var Course[] $course */
        $course = $courseRepository->getForIndexPage();
        $firstCourse = current($course);

        $activeCourseUrl = $urlGenerator->generate('course_details', ['id' => $firstCourse->getId()]);
        $client->request('GET', $activeCourseUrl);

        $this->assertResponseIsSuccessful();
        $this->assertAnySelectorTextNotContains('p', 'Данный курс не доступен или был отключен');
        $this->assertAnySelectorTextContains('h4', $firstCourse->getTitle());
        $this->assertAnySelectorTextContains('div', $firstCourse->getText());


        $firstCourse->setStatus(CourseStatuses::DISABLED->value);
        $em->flush();

        $client->request('GET', $activeCourseUrl);
        $this->assertResponseIsSuccessful();
        $this->assertAnySelectorTextContains('p', 'Данный курс не доступен или был отключен');
    }
}
