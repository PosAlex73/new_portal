<?php

namespace App\Controller\Front;

use App\Controller\Front\Traits\BackUrl;
use App\Entity\Course;
use App\Entity\CourseBugReport;
use App\Enums\Flash\FlashTypes;
use App\Form\BugCourseReportType;
use App\Repository\CourseBugReportRepository;
use App\Services\Courses\BugReportService;
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
        protected CourseBugReportRepository $courseBugReportRepository
    ){}

    #[Route('/report/{id}', name: 'bug_report', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function index(Course $course, Request $request): Response
    {
        $form = $this->createForm(BugCourseReportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->courseBugReportRepository->checkUserCreatedManyReports($this->getUser())) {
                $this->addFlash(FlashTypes::ERROR->value, 'Вы создали слишком много сообщений. Вы сможете создавать новые сообщения, когда администрация рассмотрит ваши отчеты');
            } else {
                /** @var CourseBugReport $report */
                $report = $form->getData();
                $report->setCourse($course);
                $this->bugReportService->saveBugReport($report);

                $this->addFlash(FlashTypes::NOTICE->value, 'Отчет об ошибке успешно отправлен!');
            }

            return $this->redirectToRoute('course_details', [
                'id' => $course->getId()
            ]);
        } else {
            return $this->render(
                'front/bug_report/index.html.twig',
                [
                    'form' => $form,
                    'course_id' => $course->getId()
                ]
            );
        }

    }
}
