<?php

namespace App\EventSubscriber;

use App\Event\UserDeletedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserDeletedSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            UserDeletedEvent::class => 'onUserDeleted'
        ];
    }

    public function onUserDeleted(UserDeletedEvent $userDeletedEvent)
    {
        //fixme что-то сделать с удалением пользователя
    }
}
