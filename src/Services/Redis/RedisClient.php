<?php

namespace App\Services\Redis;

use Predis\Client;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class RedisClient
{
    private readonly string $redisHost;
    private readonly string $redisPort;
    private const SCHEME = 'tcp';
    private Client $redisClient;

    public function __construct(private ParameterBagInterface $parameterBag)
    {
        $this->redisHost = $this->parameterBag->get('redis_host');
        $this->redisPort = $this->parameterBag->get('redis_port');
    }

    public function getRedisClient(): Client
    {
        if (empty($this->redisClient)) {
            $this->redisClient = new Client([
                'scheme' => static::SCHEME,
                'host' => $this->redisHost,
                'port' => $this->redisPort
            ]);
        }

        $this->redisClient->connect();

        return $this->redisClient;
    }
}
