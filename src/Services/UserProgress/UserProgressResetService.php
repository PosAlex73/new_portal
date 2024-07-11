<?php

namespace App\Services\UserProgress;

use App\Dto\Progress\UserProgressDataStartDto;
use App\Entity\User;
use App\Entity\UserProgress;
use App\Repository\UserProgressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class UserProgressResetService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserProgressRepository $userProgressRepository
    ){}

    /**
     * Сбрасывает прогресс пользователя до начального.
     *
     * @param UserProgress $userProgress
     * @return bool
     */
    public function resetProgress(UserProgress $userProgress, User $user): bool
    {
        if (empty($user)) {
            return false;
        }

        $userCourses = $this->userProgressRepository->getCourseIdsByUserId($user->getId());
        if (!in_array($userProgress->getId(), $userCourses)) {
            return false;
        }

        $userProgress->setData(json_encode(UserProgressDataStartDto::getStartData()));
        $this->entityManager->flush();

        return true;
    }
}
