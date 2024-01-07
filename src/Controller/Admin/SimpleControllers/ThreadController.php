<?php

namespace App\Controller\Admin\SimpleControllers;

use App\Entity\User;
use App\Repository\ThreadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThreadController extends AbstractController
{
    public function __construct(protected ThreadRepository $threadRepository)
    {
    }

    #[Route('/admin/thread/{id}', name: 'show_thread')]
    public function thread(User $user): Response
    {
        $thread = $this->threadRepository->findByUserId($user->getId());
        $messages = $thread->getThreadMessages();

        return $this->render('admin/thread/index.html.twig', [
            'messages' => $messages,
            'thread' => $thread,
            'user' => $user
        ]);
    }
}
