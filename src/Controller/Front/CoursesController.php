<?php

namespace App\Controller\Front;

use App\Controller\Front\Traits\BackUrl;
use App\Entity\Course;
use App\Entity\User;
use App\Enums\Courses\CourseStatuses;
use App\Enums\Flash\FlashTypes;
use App\Repository\CourseRepository;
use App\Repository\UserProgressRepository;
use App\Services\UserProgress\ProgressCreator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CoursesController extends AbstractController
{
    use BackUrl;

    public function __construct(
        protected CourseRepository $courseRepository,
        protected ProgressCreator $progressCreator,
        protected UserProgressRepository $userProgressRepository
    )
    {
    }

    #[Route('/courses', name: 'courses_list')]
    public function index(): Response
    {
        $courses = $this->courseRepository->getForCoursePage();

        return $this->render('front/courses/index.html.twig', [
            'courses' => $courses,
        ]);
    }

    #[Route('/courses/details/{id}', name: 'course_details')]
    public function details(Course $course, Request $request)
    {
        if ($course->getStatus() !== CourseStatuses::ACTIVE->value) {
            $this->addFlash(FlashTypes::NOTICE->value, 'Данный курс не доступен или был отключен');

            $this->redirect($this->getBackUrl($request));
        }

        /** @var User $user */
        $user = $this->getUser();
        $hasCourse = $this->userProgressRepository->getByUserProgress($user->getId(), $course->getId());

        return $this->render('front/courses/detail.html.twig', [
            'course' => $course,
            'hasCourse' => $hasCourse
        ]);
    }

    #[Route('/courses/add-course/{id}', name: 'course_add_to_user')]
    #[IsGranted('ROLE_USER')]
    public function addCourseForUser(Course $course, Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();
        $result = $this->progressCreator->addProgressToUser($user, $course);

        if (!$result->isResult()) {
            $this->addFlash(FlashTypes::ERROR->value, $result->getMessage());

            return $this->redirect($this->getBackUrl($request));
        }

        $this->addFlash(FlashTypes::NOTICE->value, 'Новый курс добавлен!');

        return $this->redirectToRoute('user_progress');
    }
}
