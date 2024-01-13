<?php

namespace App\DataFixtures;

use App\Entity\AppNew;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Course;
use App\Entity\Task;
use App\Entity\TestText;
use App\Entity\TestVariant;
use App\Entity\User;
use App\Entity\UserProgress;
use App\Enums\CommonStatus;
use App\Enums\Courses\CourseNames;
use App\Enums\Courses\CourseStatuses;
use App\Enums\Courses\CourseTypes;
use App\Enums\Task\TaskTypes;
use App\Enums\Users\UserStatuses;
use App\Enums\Users\UserTypes;
use App\Repository\CategoryRepository;
use App\Repository\CourseRepository;
use App\Services\Courses\CourseLoader;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CommonFixture extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        protected UserPasswordHasherInterface $passwordHasher,
        protected CourseLoader $courseLoader,
        protected CategoryRepository $categoryRepository,
        protected CourseRepository $courseRepository
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        foreach (range(0, 30) as $_) {
            $category = new Category();
            $category->setTitle($faker->realText(20));
            $category->setText($faker->realText());
            $category->setStatus(CommonStatus::ACTIVE->value);

            $manager->persist($category);
            $manager->flush();
        }

        $admin = new User();
        $admin->setType(UserTypes::ADMIN->value);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin'));
        $admin->setFirstName($faker->firstName());
        $admin->setLastName($faker->lastName());
        $admin->setEmail('a@a.ru');
        $admin->setStatus(UserStatuses::ACTIVE->value);
        $admin->setRoles(['ROLE_ADMIN', 'ROLE_USER']);

        $manager->persist($admin);
        $manager->flush();

        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $user->setEmail('u@u.ru');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'user'));
        $user->setType(UserTypes::SIMPLE->value);
        $user->setStatus(UserStatuses::ACTIVE->value);
        $user->setLastName($faker->lastName());
        $user->setFirstName($faker->firstName());

        $manager->persist($user);
        $manager->flush();

        $testCourses = [CourseNames::TEST->value, CourseNames::TEST2->value, CourseNames::TEST3->value];
        $category = $this->categoryRepository->findOneBy([
            'status' => CommonStatus::ACTIVE->value
        ]);

        foreach ($testCourses as $course) {
            $initialCourseDto = $this->courseLoader->getCourseByName('test', $course);
            $newCourse = new Course();
            $newCourse->setTitle($initialCourseDto->getTitle());
            $newCourse->setStatus(CourseStatuses::ACTIVE->value);
            $newCourse->setText($faker->realText(1000));
            $newCourse->setPosition(0);
            $newCourse->setShortDescription($faker->realText());
            $newCourse->setCategory($category);
            $newCourse->setCourseCode('test/' . $course);
            $newCourse->setType(CourseTypes::FREE->value);
            $manager->persist($newCourse);
            $manager->flush();

            foreach ($initialCourseDto->getTasks() as $task) {
                $newTask = new Task();
                $newTask->setCourse($newCourse);
                $newTask->setType($this->getTaskType($task['type']));
                $newTask->setTitle($faker->realText(20));
                $newTask->setText($faker->realText(500));
                $newTask->setStatus(CommonStatus::ACTIVE->value);
                $manager->persist($newTask);
                $manager->flush();

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
                        $manager->persist($newTestText);
                        $manager->flush();
                    }
                }
            }

        }

        foreach (range(0, 30) as $_) {
            $article = new Article();
            $article->setText($faker->realText(2000));
            $article->setTitle($faker->realText(20));
            $article->setStatus(CommonStatus::ACTIVE->value);

            $manager->persist($article);
            $manager->flush();
        }

        foreach (range(0, 30) as $_) {
            $new = new AppNew();
            $new->setStatus(CommonStatus::ACTIVE->value);
            $new->setTitle($faker->realText(20));
            $new->setText($faker->realText(2000));

            $manager->persist($new);
            $manager->flush();
        }

        $courses = $this->courseRepository->findAll();
        foreach ($courses as $course) {
            $userProgress = new UserProgress();
            $userProgress->setOwner($user);
            $userProgress->setCourse($course);
            $manager->persist($userProgress);
            $manager->flush();
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

    public function getDependencies()
    {
        return [
            SettingsFixture::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['g2'];
    }
}
