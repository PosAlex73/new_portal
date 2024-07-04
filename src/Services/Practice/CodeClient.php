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
    private readonly string $url;
    private readonly string $port;

    public function __construct(
        protected ParameterBagInterface $parameterBag,
        protected HttpClientInterface $httpClient
    )
    {
        $this->url = $this->parameterBag->get('code_checker.url');
        $this->port = $this->parameterBag->get('code_checker.port');
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
