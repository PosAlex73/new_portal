<?php

namespace App\Controller;

use App\Entity\User;
use App\Enums\Flash\FlashTypes;
use App\Enums\Users\UserTypes;
use App\Messages\UserRegistered;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public function __construct(protected MessageBusInterface $bus)
    {

    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        /** @var User $user */
        $user = $this->getUser();

         if ($user && !$user->isVerified()) {
             $this->addFlash(FlashTypes::NOTICE->value, 'Необходимо подтвердить почту, чтобы продолжить работу с профилем!');
             return $this->redirectToRoute('front_index');
         }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error' => $error
            ]
        );
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {

    }
}
