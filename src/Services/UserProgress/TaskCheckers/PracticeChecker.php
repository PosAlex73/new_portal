<?php

namespace App\Services\UserProgress\TaskCheckers;

use App\Entity\Task;

class PracticeChecker
{
    public function check(Task $task)
    {
        return false; //fixme
    }
}
