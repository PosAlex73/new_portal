<?php

namespace App\Services\UserProgress\TaskCheckers;

use App\Dto\Progress\TaskDoneDto;
use App\Entity\Task;
use Symfony\Component\HttpFoundation\Request;

class TestChecker implements TaskCheckerInterface
{
    public function check(Task $task, Request $request): TaskDoneDto
    {
        $testAnswers = $request->get('test_answers');

        if (empty($testAnswers) || !is_array($testAnswers)) {
            return new TaskDoneDto(false, 'Неверный формат ответа');
        }

        $testTexts = $task->getTestTexts();
        $result = [];

        foreach ($testTexts as $testText) {
            if ($testText->getRightVariant() === (int) $testAnswers[$testText->getId()]) {
                $result[$testText->getId()] = true;
            } else {
                $result[$testText->getId()] = false;
            }
        }

        if (in_array(false, $result, true)) {
            return new TaskDoneDto(false, 'Некоторые вопросы были отвечены неверно, попробуйте еще раз', $result);
        }

        return new TaskDoneDto(true, 'Задача успешно выполнена');
    }
}
