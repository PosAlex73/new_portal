<?php

namespace App\Controller\Front;

use App\Entity\Course;
use App\Entity\Task;
use App\Entity\User;
use App\Entity\UserProgress;
use App\Enums\Flash\FlashTypes;
use App\Repository\UserProgressRepository;
use App\Services\UserProgress\ProgressCreator;
use App\Services\UserProgress\TaskDoneChecker;
use App\Services\UserProgress\TemplateGetter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class LearnController extends AbstractController
{
    public function __construct(
        protected UserProgressRepository $userProgressRepository,
        protected TaskDoneChecker $taskDoneChecker,
        protected TemplateGetter $templateGetter,
        protected ProgressCreator $progressCreator
    )
    {
    }

    #[Route('/profile/learn/{id}', name: 'front_learn')]
    #[IsGranted('ROLE_USER')]
    public function learn(UserProgress $userProgress): Response
    {
        /** @var User $user */
        $user = $this->getUser(); //fixme проверка на статус и существование
        /** @var Course $course */
        $course = $userProgress->getCourse();
        $taskData = $userProgress->getTasksArray();

        return $this->render('front/learn/index.html.twig', [
            'userProgress' => $userProgress,
            'course' => $course,
            'taskData' => $taskData
        ]);
    }

    #[Route('/profile/learn-task/{id}', name: 'learn_task')]
    #[IsGranted('ROLE_USER')]
    public function learnTask(Task $task): Response
    {
        $taskTemplate = $this->templateGetter->getTemplateForTask($task);

        return $this->render('front/learn/learn.html.twig', [
            'task' => $task,
            'taskTemplate' => $taskTemplate
        ]);
    }

    #[Route('/profile/task-check/{id}/', name: 'check_task')]
    #[IsGranted('ROLE_USER')]
    public function checkTask(Task $task, Request $request): Response
    {

        $result = $this->taskDoneChecker->checkTask($task, $request);

        /** @var User $user */
        $user = $this->getUser();
        $userProgress = $this->userProgressRepository->getByUserProgress($user->getId(), $task->getCourse()->getId(), true);

        if ($result->isResult()) {
            $this->addFlash(FlashTypes::NOTICE->value, 'Задача успешно пройдена');

            $this->progressCreator->addTaskToProgress($task, $userProgress);

            return $this->redirectToRoute('front_learn', ['id' => $userProgress->getId()]);
        }

        $this->addFlash(FlashTypes::ERROR->value, 'Задача не пройдена.');

        return $this->redirectToRoute('learn_task', [
            'id' => $task->getId()
        ]);
    }
}
