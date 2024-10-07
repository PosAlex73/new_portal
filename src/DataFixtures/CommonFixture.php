<?php

namespace App\DataFixtures;

use App\Dto\Courses\TestCourseDto;
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
use App\Services\Courses\TestCourseCreatorService;
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
        protected CourseRepository $courseRepository,
        protected TestCourseCreatorService $testCourseCreatorService
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
        $admin->setIsVerified(true);

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
        $user->setIsVerified(true);

        $manager->persist($user);
        $manager->flush();

        $testCourses = [CourseNames::TEST->value, CourseNames::TEST2->value, CourseNames::TEST3->value];
        $category = $this->categoryRepository->findOneBy([
            'status' => CommonStatus::ACTIVE->value
        ]);

        foreach ($testCourses as $course) {
            $createDto = new TestCourseDto(
                $course, $category
            );
            $this->testCourseCreatorService->createFakeCourse($createDto);
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
            $course->setImage($faker->imageUrl());
            $userProgress = new UserProgress();
            $userProgress->setOwner($user);
            $userProgress->setCourse($course);
            $manager->persist($userProgress);
            $manager->flush();
        }

    }

    public function getDependencies()
    {
        return [
            SettingsFixture::class,
            PageFixture::class
        ];
    }

    public static function getGroups(): array
    {
        return ['g2'];
    }
}
