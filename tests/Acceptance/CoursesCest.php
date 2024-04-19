<?php


namespace Tests\Acceptance;

use App\Entity\Course;
use App\Repository\CourseRepository;
use App\Repository\UserProgressRepository;
use App\Repository\UserRepository;
use App\Services\Courses\CourseLoader;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Tests\Support\AcceptanceTester;

class CoursesCest
{
    private CourseRepository $courseRepository;

    private UserRepository $userRepository;

    private UserProgressRepository $userProgressRepository;

    private Security $security;

    public function _before(AcceptanceTester $I)
    {
        $this->courseRepository = $I->grabService(CourseRepository::class);
        $this->userRepository = $I->grabService(UserRepository::class);
        $this->userProgressRepository = $I->grabService(UserProgressRepository::class);
        $this->security = $I->grabService(Security::class);
    }

    // tests
    public function testCoursesPage(AcceptanceTester $I)
    {
        /** @var RouterInterface $router */
        $router = $I->grabService(RouterInterface::class);
        $course = $this->courseRepository->findOneBy([
            'title' => 'php'
        ]);

        $coursesUrl = $router->generate('course_details', ['id' => $course->getId()]);

        $I->amOnPage($coursesUrl);
        $I->see('Войти');
        $I->see($course->getTitle());
        $I->dontSee('У вас уже есть данный курс');

        $I->login('u@u.ru', 'user');
        $I->amOnPage($coursesUrl);
        $I->dontSee('Войти');
        $I->see('У вас уже есть данный курс');
    }

    public function testCourseToUser(AcceptanceTester $I)
    {
        $I->login('u@u.ru', 'user');
        /** @var RouterInterface $router */
        $router = $I->grabService(RouterInterface::class);
        $course = $this->courseRepository->findOneBy([
            'title' => 'php'
        ]);

        $coursesUrl = $router->generate('course_details', ['id' => $course->getId()]);

        $I->amOnPage($coursesUrl);
    }

    public function checkCourseApplied(AcceptanceTester $tester)
    {
        $tester->login('u@u.ru', 'user');

    }
}
