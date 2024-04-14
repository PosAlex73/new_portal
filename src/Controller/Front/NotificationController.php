<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class NotificationController extends AbstractController
{
    #[Route('/notifications', name: 'notifications')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        return $this->render('front/notifications/index.html.twig', [

        ]);
    }
}
