<?php

namespace App\Controller\Admin\SimpleControllers;

use App\Entity\User;
use App\Form\UserProfileFormType;
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

    #[Route('/admin/profile/{id}', name: 'show_profile')]
    public function index(User $user, Request $request): Response
    {
        $userProfile = $user->getUserProfile();
        $profileForm = $this->createForm(UserProfileFormType::class, $userProfile);

        $profileForm->handleRequest($request);

        if ($profileForm->isSubmitted() && $profileForm->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', 'Профиль успешно обновлен!');
        }

        return $this->render('admin/profile/index.html.twig', [
            'userProfile' => $userProfile,
            'user' => $user,
            'profileForm' => $profileForm
        ]);
    }
}
