<?php

namespace App\Services\UserProgress\TaskCheckers;

use App\Dto\Progress\TaskDoneDto;
use App\Entity\Task;

class TheoryChecker implements TaskCheckerInterface
{
    public function check(Task $task): TaskDoneDto
    {
        return new TaskDoneDto(true, 'test'); //fixme
    }
}
