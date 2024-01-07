<?php

namespace App\Controller\Front;

use App\Controller\Front\Traits\BackUrl;
use App\Enums\Flash\FlashTypes;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $entityManager)
    {
    }

    use BackUrl;

    #[Route('/profile', name: 'profile')]
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $userForm = $this->createForm(UserFormType::class);

        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $this->addFlash(FlashTypes::NOTICE->value, 'Информация обновлена!');
            $this->entityManager->flush();

            $this->redirect($this->getBackUrl($request));
        }

        return $this->render('front/profile/index.html.twig', [
            'userForm' => $userForm,
            'user' => $user
        ]);
    }

    #[Route('/profile/progress', name: 'user_progress')]
    public function userProgress()
    {

    }

    #[Route('/profile/settings', name: 'user_settings')]
    public function userProfile()
    {

    }
}
