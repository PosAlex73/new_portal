<?php

namespace App\Services\Practice;

use App\Dto\Practice\PracticeCodeDto;

class CodeClient
{
    protected PracticeCodeDto $practiceCodeDto;

    public function setCodeDto(PracticeCodeDto $practiceCodeDto)
    {
        $this->practiceCodeDto = $practiceCodeDto;
    }

    public function sendCode()
    {
        return true;
    }
}
