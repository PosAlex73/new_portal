<?php

namespace App\Controller\Front;

use App\Controller\Front\Traits\BackUrl;
use App\Entity\Course;
use App\Entity\CourseBugReport;
use App\Entity\User;
use App\Entity\UserProgress;
use App\Enums\Flash\FlashTypes;
use App\Form\BugCourseReportType;
use App\Repository\CourseBugReportRepository;
use App\Repository\UserProgressRepository;
use App\Services\Courses\BugReportService;
use App\Services\Menu\BreadCrumbsBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class BugReportController extends AbstractController
{
    use BackUrl;

    public function __construct(
        protected BugReportService $bugReportService,
        protected CourseBugReportRepository $courseBugReportRepository,
        protected BreadCrumbsBuilder $breadCrumbsBuilder,
        protected UserProgressRepository $userProgressRepository
    ){}

    #[Route('/report/{id}', name: 'bug_report', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function index(Course $course, Request $request): Response
    {
        $form = $this->createForm(BugCourseReportType::class);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var User $user */
            if ($this->courseBugReportRepository->checkUserCreatedManyReports($user)) {
                $this->addFlash(
                    FlashTypes::ERROR->value,
                    'Вы создали слишком много сообщений. Вы сможете создавать новые сообщения, когда администрация рассмотрит ваши отчеты'
                );
            } else {
                /** @var CourseBugReport $report */
                $report = $form->getData();
                $report->setCourse($course);
                $this->bugReportService->saveBugReport($report);

                $this->addFlash(FlashTypes::NOTICE->value, 'Отчет об ошибке успешно отправлен!');
            }

            /** @var UserProgress $userProgress */
            $userProgress = $this->userProgressRepository->getByUserProgress(
                $user->getId(),
                $course->getId(),
                true
            );

            return $this->redirectToRoute('front_learn', [
                'id' => $userProgress->getId()
            ]);
        } else {

            $userProgress = $this->userProgressRepository->getByUserProgress(
                $user->getId(),
                $course->getId(),
                true
            );

            $this->initBreadCrumbs();
            $this->breadCrumbsBuilder->addBreadCrumbs(
                $course->getTitle(), $this->generateUrl('front_learn', ['id' => $userProgress->getId()])
            );

            return $this->render(
                'front/bug_report/index.html.twig',
                [
                    'form' => $form,
                    'course_id' => $course->getId()
                ]
            );
        }
    }

    private function initBreadCrumbs()
    {
        $this->breadCrumbsBuilder->addIndexRoute();
    }
}
