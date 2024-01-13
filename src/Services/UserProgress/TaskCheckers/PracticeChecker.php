<?php

namespace App\Services\UserProgress\TaskCheckers;

use App\Dto\Progress\TaskDoneDto;
use App\Entity\Task;
use Symfony\Component\HttpFoundation\Request;

class PracticeChecker implements TaskCheckerInterface
{
    public function check(Task $task, Request $request): TaskDoneDto
    {
        return new TaskDoneDto(false, 'test'); //fixme
    }
}
