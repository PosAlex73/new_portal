<?php

namespace App\Controller\Front;

use App\Controller\Front\Traits\BackUrl;
use App\Entity\User;
use App\Enums\Flash\FlashTypes;
use App\Enums\Users\UserRoles;
use App\Form\UserFormType;
use App\Form\UserProfileFormType;
use App\Repository\UserProgressRepository;
use App\Services\UserProgress\CourseCounter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ProfileController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected UserProgressRepository $userProgressRepository,
        protected CourseCounter $courseCounter
    ){}

    use BackUrl;

    #[Route('/profile', name: 'profile')]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $userForm = $this->createForm(UserFormType::class, $user);

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
    #[IsGranted('ROLE_USER')]
    public function userProgress()
    {
        /** @var User $user */
        $user = $this->getUser();
        $userProgress = $user->getUserProgress();
        $calculatedData = $this->courseCounter->calculateUserProgress($userProgress);

        return $this->render('front/profile/user_progress.html.twig', [
            'userProgress' => $userProgress,
            'progressData' => $calculatedData
        ]);
    }

    #[Route('/profile/settings', name: 'user_settings')]
    #[IsGranted('ROLE_USER')]
    public function userProfile(Request $request)
    {
        $userProfile = $this->getUser()->getUserProfile();
        $profileForm = $this->createForm(UserProfileFormType::class, $userProfile);

        $profileForm->handleRequest($request);

        if ($profileForm->isSubmitted() && $profileForm->isValid()) {
            $this->entityManager->flush();

            $this->addFlash(FlashTypes::NOTICE->value, 'Профиль успешно обновлен!');
        }

        return $this->render('front/profile/user_settings.html.twig', [
            'profileForm' => $profileForm
        ]);
    }
}
