<?php

namespace App\Services\UserProgress;

use App\Dto\Progress\CourseAddResultDto;
use App\Entity\Course;
use App\Entity\Task;
use App\Entity\User;
use App\Entity\UserProgress;
use App\Repository\UserProgressRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProgressCreator
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected UserProgressRepository $userProgressRepository
    )
    {
    }

    public function addProgressToUser(User $user, Course $course)
    {
        $userProgress = $this->userProgressRepository->getByUserProgress($user->getId(), $course->getId());

        if (!empty($userProgress)) {
            return new CourseAddResultDto(false, 'Курс уже существует');
        }

        $newProgress = new UserProgress();
        $newProgress->setOwner($user);
        $newProgress->setCourse($course);

        $this->entityManager->persist($newProgress);
        $this->entityManager->flush();

        return new CourseAddResultDto(true);
    }

    public function addTaskToProgress(Task $task, UserProgress $userProgress)
    {
        $taskData = $userProgress->getTasksArray();

    }
}
