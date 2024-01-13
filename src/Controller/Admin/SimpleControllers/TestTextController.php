<?php

namespace App\Controller\Admin\SimpleControllers;

use App\Controller\Front\Traits\BackUrl;
use App\Entity\Task;
use App\Entity\TestText;
use App\Enums\Task\TaskTypes;
use App\Form\TestTextFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestTextController extends AbstractController
{
    use BackUrl;

    public function __construct(protected EntityManagerInterface $entityManager)
    {
    }

    #[Route('/admin/test-texts/{id}', name: 'edit_test_text')]
    public function index(Task $task, Request $request): Response
    {
        if ($task->getType() !== TaskTypes::TEST->value) {
            $this->redirect($this->getBackUrl($request));
        }

        $testTexts = $task->getTestTexts();

        return $this->render('admin/tasks/test_texts.html.twig', [
            'testTexts' => $testTexts,
            'task' => $task
        ]);
    }

    #[Route('/admin/test-details/{id}', name: 'edit_test_text_details')]
    public function details(TestText $testText, Request $request): Response
    {
        $form = $this->createForm(TestTextFormType::class, $testText);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirect($this->getBackUrl($request));
        }

        return $this->render('admin/tasks/test_tests_details.html.twig', [
            'testTestForm' => $form,
            'testText' => $testText,
        ]);
    }
}
