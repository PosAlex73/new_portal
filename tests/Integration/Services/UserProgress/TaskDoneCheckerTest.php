<?php

namespace App\Tests\Integration\Services\UserProgress;

use App\Enums\Task\TaskTypes;
use App\Services\UserProgress\TaskCheckers\PracticeChecker;
use App\Services\UserProgress\TaskCheckers\TestChecker;
use App\Services\UserProgress\TaskCheckers\TheoryChecker;
use App\Services\UserProgress\TaskDoneChecker;
use App\Tests\Integration\BaseKernelTestCase;

class TaskDoneCheckerTest extends BaseKernelTestCase
{
    public function testResolveChecker()
    {
        /** @var TaskDoneChecker $taskDoneChecker */
        $taskDoneChecker = $this->getContainer()->get(TaskDoneChecker::class);
        $reflectionMethod = new \ReflectionMethod($taskDoneChecker, 'resolveChecker');
        $theoryChecker = $reflectionMethod->invoke($taskDoneChecker, TaskTypes::THEORY);
        $testChecker = $reflectionMethod->invoke($taskDoneChecker, TaskTypes::TEST);
        $practiceChecker = $reflectionMethod->invoke($taskDoneChecker, TaskTypes::PRACTICE);

        $this->assertInstanceOf(TheoryChecker::class, $theoryChecker);
        $this->assertInstanceOf(TestChecker::class, $testChecker);
        $this->assertInstanceOf(PracticeChecker::class, $practiceChecker);
    }
}
