<?php

namespace App\MessageHandler;

use App\Message\UserRegistered;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UserRegisteredHandler
{
    public function __invoke(UserRegistered $registered)
    {

    }
}
