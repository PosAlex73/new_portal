<?php

namespace App\Services\Courses;

use App\Dto\Courses\TestCourseDto;
use App\Entity\Course;
use App\Entity\Task;
use App\Entity\TestText;
use App\Enums\CommonStatus;
use App\Enums\Courses\CourseStatuses;
use App\Enums\Courses\CourseTypes;
use App\Enums\Task\TaskTypes;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Faker\Generator;

class TestCourseCreatorService
{
    private Generator $faker;

    public function __construct(
        protected CourseLoader $courseLoader,
        protected EntityManagerInterface $manager,
    ){
        $this->faker = Factory::create();
    }

    public function createFakeCourse(TestCourseDto $testCourseDto)
    {
        $initialCourseDto = $this->courseLoader->getCourseByName('test', $testCourseDto->getCourseName());
        $newCourse = new Course();
        $newCourse->setTitle($initialCourseDto->getTitle());
        $newCourse->setStatus(CourseStatuses::ACTIVE->value);
        $newCourse->setText($this->faker->realText(1000));
        $newCourse->setPosition(0);
        $newCourse->setShortDescription($this->faker->realText());
        $newCourse->setCategory($testCourseDto->getCategory());
        $newCourse->setCourseCode('test/' . $testCourseDto->getCourseName());
        $newCourse->setType(CourseTypes::FREE->value);
        $newCourse->setLang($initialCourseDto->getLang());
        $this->manager->persist($newCourse);
        $this->manager->flush();

        foreach ($initialCourseDto->getTasks() as $task) {
            $newTask = new Task();
            $newTask->setCourse($newCourse);
            $newTask->setType($this->getTaskType($task['type']));
            $newTask->setTitle($this->faker->realText(20));
            $newTask->setText($this->faker->realText(500));
            $newTask->setStatus(CommonStatus::ACTIVE->value);
            $this->manager->persist($newTask);
            $this->manager->flush();

            if ($task['type'] === 'test' && !empty($task['tests'])) {
                foreach ($task['tests'] as $testText) {
                    $newTestText = new TestText();
                    $newTestText->setText($testText['text']);
                    $newTestText->setTask($newTask);
                    $newTestText->setVariantOne($testText['variants']['variant_1']);
                    $newTestText->setVariantTwo($testText['variants']['variant_2']);
                    $newTestText->setVariantThree($testText['variants']['variant_3']);
                    $newTestText->setVariantFour($testText['variants']['variant_4']);
                    $newTestText->setRightVariant($testText['right_variant']);
                    $this->manager->persist($newTestText);
                    $this->manager->flush();
                }
            }
        }
    }

    private function getTaskType(string $type)
    {
        return match ($type) {
            'theory' => TaskTypes::THEORY->value,
            'test' => TaskTypes::TEST->value,
            'practice' => TaskTypes::PRACTICE->value,
        };
    }
}
