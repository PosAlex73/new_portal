<?php

namespace App\MessageHandler;

use App\Message\EmailCHanged;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class EmailCHangedHandler
{
    public function __invoke(EmailCHanged $message): void
    {

    }
}
