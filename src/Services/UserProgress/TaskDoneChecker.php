<?php

namespace App\Services\UserProgress;

use App\Dto\Progress\TaskDoneDto;
use App\Entity\Task;
use App\Enums\Task\TaskTypes;
use App\Services\Practice\CodeClient;
use App\Services\UserProgress\TaskCheckers\PracticeChecker;
use App\Services\UserProgress\TaskCheckers\TaskCheckerInterface;
use App\Services\UserProgress\TaskCheckers\TestChecker;
use App\Services\UserProgress\TaskCheckers\TheoryChecker;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class TaskDoneChecker
{
    public function __construct(protected CodeClient $client)
    {
    }

    public function checkTask(Task $task, Request $request): TaskDoneDto
    {
        $checker = $this->resolveChecker(TaskTypes::from($task->getType()));
        return $checker->check($task, $request);
    }

    /**
     * @param TaskTypes $type
     * @return TaskCheckerInterface
     * @throws Exception
     */
    protected function resolveChecker(TaskTypes $type): TaskCheckerInterface
    {
        return match ($type) {
            TaskTypes::THEORY => new TheoryChecker(),
            TaskTypes::TEST => new TestChecker(),
            TaskTypes::PRACTICE => new PracticeChecker($this->client),
        };
    }
}
