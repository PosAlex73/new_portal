<?php

namespace App\Services\Practice;

use App\Dto\Practice\PracticeCodeDto;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CodeClient
{
    protected PracticeCodeDto $practiceCodeDto;

    protected string $secret;

    protected string $checkerUrl;

    public function __construct(protected ParameterBagInterface $parameterBag)
    {
        $this->secret = $this->parameterBag->get('lalalala');
        $this->checkerUrl = $this->parameterBag->get('checker_url');
    }

    public function setCodeDto(PracticeCodeDto $practiceCodeDto)
    {
        $this->practiceCodeDto = $practiceCodeDto;
    }

    public function sendCode()
    {
        return true;
    }
}
