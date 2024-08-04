<?php

namespace App\Controller\Admin\SimpleControllers;

use App\Controller\Front\Traits\BackUrl;
use App\Entity\User;
use App\Enums\Flash\FlashTypes;
use App\Form\UserProfileFormType;
use App\Services\User\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    use BackUrl;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserService $userService
    ){}

    #[Route('/admin/profile/{id}', name: 'show_profile')]
    public function index(User $user, Request $request): Response
    {
        $userProfile = $user->getUserProfile();
        $profileForm = $this->createForm(UserProfileFormType::class, $userProfile);

        $profileForm->handleRequest($request);

        if ($profileForm->isSubmitted() && $profileForm->isValid()) {
            $this->entityManager->flush();

            $this->addFlash(FlashTypes::NOTICE->value, 'Профиль успешно обновлен!');
        }

        return $this->render('admin/profile/index.html.twig', [
            'userProfile' => $userProfile,
            'user' => $user,
            'profileForm' => $profileForm
        ]);
    }

    #[Route('/admin/profile/block/{id}', name: 'block_user', methods: 'GET')]
    public function blockUser(User $user, Request $request)
    {
        $this->userService->blockUser($user);

        return $this->redirect($this->getBackUrl($request));
    }

    #[Route('/admin/profile/unblock/{id}', name: 'unblock_user', methods: 'GET')]
    public function unblockUser(User $user, Request $request)
    {
        $this->userService->unblockUser($user);

        return $this->redirect($this->getBackUrl($request));
    }
}
