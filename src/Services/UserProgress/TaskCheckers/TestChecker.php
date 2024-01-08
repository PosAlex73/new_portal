<?php

namespace App\Services\UserProgress\TaskCheckers;

use App\Entity\Task;

class TestChecker
{
    public function check(Task $task)
    {
        return false; //fixme
    }
}
