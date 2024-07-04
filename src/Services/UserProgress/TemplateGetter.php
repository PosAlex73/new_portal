<?php

namespace App\Services\UserProgress;

use App\Entity\Learn\LearnTemplates;
use App\Entity\Task;
use App\Enums\Task\TaskTypes;

class TemplateGetter
{
    public function getTemplateForTask(Task $task)
    {
        return match ($task->getType()) {
            TaskTypes::THEORY->value => LearnTemplates::Theory->value,
            TaskTypes::TEST->value => LearnTemplates::Test->value,
            TaskTypes::PRACTICE->value => LearnTemplates::Practice->value,
            default => throw new \Exception('Данного типа шаблона не существует')
        };
    }
}
