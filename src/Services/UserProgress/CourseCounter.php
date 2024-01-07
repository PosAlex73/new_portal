<?php

namespace App\Services\UserProgress;

use App\Dto\Progress\UserProgressForProfileDto;
use App\Entity\UserProgress;
use App\Repository\CourseRepository;

class CourseCounter
{
    public function __construct(
        protected CourseRepository $courseRepository
    )
    {
    }

    /**
     * @param iterable<UserProgress> $userProgressCollection
     * @return array<UserProgressForProfileDto>
     */
    public function calculateUserProgress(iterable $userProgressCollection)
    {
        if (empty($userProgressCollection)) {
            return [];
        }

        $calculatedProgress = [];

        foreach ($userProgressCollection as $value) {
            $calcProgress = new UserProgressForProfileDto(
                $value->getCourse()->getTitle(),
                $value->getCourse()->taskCount(),
                $value->getDoneTasksCount(),
                $value->getCreated()->format('Y-m-d'),
                $value->getEndDate()?->format('Y-m-d')
            );

            $calculatedProgress[] = $calcProgress;
        }

        return $calculatedProgress;
    }
}
