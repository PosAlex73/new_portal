<?php

namespace App\Controller\Front;

use App\Controller\Front\Traits\BackUrl;
use App\Entity\User;
use App\Entity\UserProgress;
use App\Enums\Flash\FlashTypes;
use App\Event\UserDeletedEvent;
use App\Form\UserFormType;
use App\Form\UserProfileFormType;
use App\Repository\UserProgressRepository;
use App\Services\Menu\BreadCrumbsBuilder;
use App\Services\User\UserRemover;
use App\Services\UserProgress\CourseCounter;
use App\Services\UserProgress\UserProgressResetService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class ProfileController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected UserProgressRepository $userProgressRepository,
        protected CourseCounter $courseCounter,
        protected UserProgressResetService $userProgressResetService,
        protected BreadCrumbsBuilder $breadCrumbsBuilder,
        private UserRemover $userRemover,
        private EventDispatcherInterface $eventDispatcher
    ){}

    use BackUrl;

    #[Route('/profile', name: 'profile')]
    public function index(Request $request): Response
    {
        /** @var User|null $user */
        $user = $this->getUser();

        if (!is_null($user) && !$user->isVerified()) {
            $this->addFlash(
                FlashTypes::ERROR->value,
                'Необходимо подтвердить почтовый ящык. Письмо было отправлено на ваш почтовый ящик: ' . $user->getEmail()
            );
            return $this->redirectToRoute('front_index');
        }

        $userForm = $this->createForm(UserFormType::class, $user);

        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $this->addFlash(FlashTypes::NOTICE->value, 'Информация обновлена!');
            $this->entityManager->flush();

            $this->redirect($this->getBackUrl($request));
        }

        $this->initBreadCrumbs();
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

        $this->initBreadCrumbs();
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

        $this->initBreadCrumbs();
        return $this->render('front/profile/user_settings.html.twig', [
            'profileForm' => $profileForm
        ]);
    }

    #[Route('/profile/reset-user-progress/{id}', name: 'reset_progress')]
    #[IsGranted('ROLE_USER')]
    public function resetUserProgress(UserProgress $userProgress, Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $result = $this->userProgressResetService->resetProgress($userProgress, $user);
        if ($result) {
            $this->addFlash(FlashTypes::NOTICE->value, 'Прогресс успешно сброшен.');
        } else {
            $this->addFlash(FlashTypes::ERROR->value, 'Прогресс не удалось сбросить.');
        }

        return $this->redirectToRoute('profile');
    }

    private function initBreadCrumbs()
    {
        $this->breadCrumbsBuilder->addIndexRoute();
        $this->breadCrumbsBuilder->addBreadCrumbs('Профиль', $this->generateUrl('profile'));
    }

    #[Route('/profile/delete-profile', name: 'delete_profile')]
    #[IsGranted('ROLE_USER')]
    public function deleteProfile(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();
        $this->eventDispatcher->dispatch((new UserDeletedEvent($user)));
        $result = $this->userRemover->deleteUser($user);

        if ($result) {
            $this->addFlash(FlashTypes::NOTICE->value, 'Пользователь успешно удален!');

            return $this->redirectToRoute('app_logout');
        }

        $this->addFlash(FlashTypes::ERROR->value, 'Данного пользователя нельзя удалить.');
        return $this->redirect($this->getBackUrl($request));
    }
}
