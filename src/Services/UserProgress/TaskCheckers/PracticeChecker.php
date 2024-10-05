<?php

namespace App\Services\UserProgress\TaskCheckers;

use App\Dto\Practice\PracticeCodeDto;
use App\Dto\Progress\TaskDoneDto;
use App\Entity\Task;
use App\Services\Practice\CodeClient;
use Symfony\Component\HttpFoundation\Request;

class PracticeChecker implements TaskCheckerInterface
{
    public function __construct(protected CodeClient $client)
    {
    }

    public function check(Task $task, Request $request): TaskDoneDto
    {
        $code = $request->get('code');

        if (empty($code)) {
            return new TaskDoneDto(false, 'Пустое поле для кода');
        }

        $codeDto = new PracticeCodeDto(
            $code,
            $task->getCourse()->getId(),
            $task->getId(),
            $task->getCourse()->getLang()
        );

        $this->client->setCodeDto($codeDto);
        $result = $this->client->sendCode();

        if ($result) {

        }
    }
}
