<?php

namespace App\Services\UserProgress;

use App\Dto\Progress\TaskDoneDto;
use App\Entity\Task;
use App\Enums\Task\TaskTypes;
use App\Services\UserProgress\TaskCheckers\PracticeChecker;
use App\Services\UserProgress\TaskCheckers\TaskCheckerInterface;
use App\Services\UserProgress\TaskCheckers\TestChecker;
use App\Services\UserProgress\TaskCheckers\TheoryChecker;
use Exception;

class TaskDoneChecker
{
    public function checkTask(Task $task):  TaskDoneDto
    {
        $checker = $this->resolveChecker($task->getType());
        return $checker->check($task);
    }

    /**
     * @param string $type
     * @return TaskCheckerInterface
     * @throws Exception
     */
    protected function resolveChecker(string $type): TaskCheckerInterface
    {
        return match ($type) {
            TaskTypes::THEORY->value => new TheoryChecker(),
            TaskTypes::TEST->value => new TestChecker(),
            TaskTypes::PRACTICE->value => new PracticeChecker(),
            default => throw new Exception()
        };
    }
}
