<?php

namespace App\Services\UserProgress\TaskCheckers;

use App\Dto\Progress\TaskDoneDto;
use App\Entity\Task;
use Symfony\Component\HttpFoundation\Request;

interface TaskCheckerInterface
{
    public function check(Task $task, Request $request): TaskDoneDto;
}
