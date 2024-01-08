<?php

namespace App\Services\UserProgress;

use App\Entity\Course;
use App\Entity\User;
use App\Repository\UserProgressRepository;

class ProgressUserChecker
{
    public function __construct(protected UserProgressRepository $userProgressRepository)
    {
    }

    /**
     * @param User $user
     * @param Course $course
     * @return bool
     */
    public function checkIfUserHasCourse(User $user, Course $course)
    {
        return (bool) $this->userProgressRepository->getByUserProgress($user->getId(), $course->getId());
    }
}
