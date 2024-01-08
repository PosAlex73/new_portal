<?php

namespace App\Services\UserProgress\TaskCheckers;

use App\Entity\Task;

class TheoryChecker
{
    public function check(Task $task)
    {
        return true;
    }
}
