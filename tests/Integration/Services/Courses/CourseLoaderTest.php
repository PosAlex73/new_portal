<?php

namespace App\Tests\Integration\Services\Courses;

use App\Services\Courses\CourseLoader;
use App\Tests\Traits\MakeMethodPublic;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CourseLoaderTest extends KernelTestCase
{
    use MakeMethodPublic;

    public function testCoursePath()
    {
        self::bootKernel();

        /** @var ParameterBagInterface $parameterBag */
        $parameterBag = $this->getContainer()->get(ParameterBagInterface::class);
        $path = $parameterBag->get('course_path');
        $this->assertNotEmpty($path);
    }

    public function testGetCourseJson()
    {
        self::bootKernel();

        $courseLoader = $this->getContainer()->get(CourseLoader::class);
        $method = $this->makeMethodPublic($courseLoader, 'getCourseArray');

        $courseArray = $method->invoke($courseLoader, 'test', 'test');

        $this->assertIsArray($courseArray);
        $this->assertNotEmpty($courseArray['technology']);
        $this->assertNotEmpty($courseArray['description']);
        $this->assertNotEmpty($courseArray['level']);
        $this->assertNotEmpty($courseArray['tasks']);
        $this->assertNotEmpty($courseArray['lang']);
    }

    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        /** @var EntityManager $em */
        $em = $this->getContainer()->get(EntityManagerInterface::class);
    }
}
