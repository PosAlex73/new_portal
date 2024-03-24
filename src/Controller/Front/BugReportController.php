<?php

namespace App\Controller\Front;

use App\Controller\Front\Traits\BackUrl;
use App\Entity\Course;
use App\Entity\CourseBugReport;
use App\Enums\Flash\FlashTypes;
use App\Form\BugCourseReportType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BugReportController extends AbstractController
{
    use BackUrl;

    #[Route('/report/{id}', name: 'bug_report', methods: ['GET', 'POST'])]
    public function index(Course $course, Request $request): Response
    {
        $form = $this->createForm(BugCourseReportType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $report = $form->getData();
            dd($report);

            $this->addFlash(FlashTypes::NOTICE->value, 'Сообщение успешно отправлено!');

            return $this->redirectToRoute('course_details', [
                'id' => $course->getId()
            ]);
        } else {
            $bugReport = new CourseBugReport();
            $bugReport->setCourse($course);

            $form->setData($bugReport);

            return $this->render(
                'front/bug_report/index.html.twig',
                [
                    'form' => $form,
                ]
            );
        }

    }
}
