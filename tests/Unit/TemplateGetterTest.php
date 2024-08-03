<?php

namespace App\Tests\Unit;

use App\Entity\Learn\LearnTemplates;
use App\Entity\Task;
use App\Enums\Task\TaskTypes;
use App\Exceptions\TemplateNotDefinedException;
use App\Services\UserProgress\TemplateGetter;
use PHPUnit\Framework\TestCase;

class TemplateGetterTest extends TestCase
{
    public function testSomething(): void
    {
        $templateGetter = new TemplateGetter();
        $taskTest = new Task();
        $taskTest->setType(TaskTypes::TEST->value);

        $taskPractice = new Task();
        $taskPractice->setType(TaskTypes::PRACTICE->value);

        $this->assertEquals(LearnTemplates::Test->value, $templateGetter->getTemplateForTask($taskTest));
        $this->assertEquals(LearnTemplates::Practice->value, $templateGetter->getTemplateForTask($taskPractice));

        $this->expectException(TemplateNotDefinedException::class);
        $templateGetter->getTemplateForTask((new Task())->setType('ffff'));
    }
}
