<?php

namespace App\MessageHandlers;

use App\Messages\UserRegistered;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UserRegisteredHandler
{
    public function __invoke(UserRegistered $registered)
    {

    }
}
