<?php

namespace App\Controller\Front;

use App\Entity\Course;
use App\Entity\Task;
use App\Entity\User;
use App\Entity\UserProgress;
use App\Repository\UserProgressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class LearnController extends AbstractController
{
    public function __construct(protected UserProgressRepository $userProgressRepository)
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

        return $this->render('front/learn/index.html.twig', [
            'userProgress' => $userProgress,
            'course' => $course
        ]);
    }

    #[Route('/profile/task-learn/{id}')]
    public function task(Task $task): Response
    {

    }
}
