<?php

namespace App\Services\Practice;

use App\Dto\Practice\PracticeCodeDto;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CodeClient
{
    protected PracticeCodeDto $practiceCodeDto;

    protected string $secret;

    protected string $checkerUrl;

    public function __construct(
        protected ParameterBagInterface $parameterBag,
        protected HttpClientInterface $httpClient
    )
    {
        $this->secret = $this->parameterBag->get('secret');
        $this->checkerUrl = $this->parameterBag->get('checker_url');
    }

    public function setCodeDto(PracticeCodeDto $practiceCodeDto)
    {
        $this->practiceCodeDto = $practiceCodeDto;
    }

    public function sendCode()
    {
        $response = $this->httpClient->request('POST', $this->checkerUrl,
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'auth' => $this->secret
                ],
                'body' => $this->practiceCodeDto->toJson()
            ]
        )->getContent();
    }
}
