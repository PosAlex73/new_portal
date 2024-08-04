<?php

namespace App\Services\Dashboard;

use App\Entity\User;
use App\Enums\Users\UserTypes;
use App\Services\Redis\RedisClient;

class StatisticsTabsSaver
{
    private const LOGIN_USER_COUNTER_KEY = 'user_count_daily';

    public function __construct(private RedisClient $redisClient)
    {

    }

    public function incrementUserLogin(User $user)
    {
        if ($user->getType() !== UserTypes::SIMPLE->value) {
            return;
        }

        $this->redisClient->getRedisClient()->incr(static::LOGIN_USER_COUNTER_KEY);
    }
}
