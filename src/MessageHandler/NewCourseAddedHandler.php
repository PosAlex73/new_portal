<?php

namespace App\MessageHandler;

use App\Message\NewCourseAdded;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class NewCourseAddedHandler
{
    public function __invoke(NewCourseAdded $message): void
    {
        // do something with your message
    }
}
