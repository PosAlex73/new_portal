<?php

namespace App\Services\Practice;

use App\Dto\Practice\PracticeCodeDto;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CodeClient
{
    protected PracticeCodeDto $practiceCodeDto;
    protected string $secret;
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

    private function getFullUrl(): string
    {
        $checkUrl =  $this->url;

        if (!empty($this->port)) {
            $checkUrl .= ':' . $this->port;
        }

        return $checkUrl;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function sendCode()
    {
        try {
            $response = $this->httpClient->request('POST', $this->getFullUrl(),
                [
                    'headers' => $this->getCommonHeaders(),
                    'body' => $this->practiceCodeDto->toJson()
                ]
            )->getContent();

            $response = json_decode($response, true);

            return $response;
        } catch (\Throwable $exception) {
            //FIXME сделать логирование ошибок
            return false;
        }

    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function checkAlive(): array
    {
        try {
            $response = $this->httpClient->request('GET', $this->getFullUrl() . '/check_alive',
                [
                    'headers' => $this->getCommonHeaders(),
                    'timeout' => 0.5
                ]
            )->getContent();

            return json_decode($response, true);
        } catch (\Throwable $exception) {
            //FIXME сделать логирование ошибок от сервиса
            return ['status' => 'error'];
        }
    }

    private function getCommonHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
    }
}
