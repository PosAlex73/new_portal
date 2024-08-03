<?php

namespace App\Services\UserProgress;

use App\Entity\Learn\LearnTemplates;
use App\Entity\Task;
use App\Enums\Task\TaskTypes;
use App\Exceptions\TemplateNotDefinedException;

class TemplateGetter
{
    /**
     * @throws TemplateNotDefinedException
     */
    public function getTemplateForTask(Task $task)
    {
        return match ($task->getType()) {
            TaskTypes::THEORY->value => LearnTemplates::Theory->value,
            TaskTypes::TEST->value => LearnTemplates::Test->value,
            TaskTypes::PRACTICE->value => LearnTemplates::Practice->value,
            default => throw new TemplateNotDefinedException()
        };
    }
}
