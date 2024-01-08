<?php

namespace App\Services\UserProgress\TaskCheckers;

use App\Dto\Progress\TaskDoneDto;
use App\Entity\Task;

interface TaskCheckerInterface
{
    public function check(Task $task): TaskDoneDto;
}
