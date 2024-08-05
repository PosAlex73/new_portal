<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Enums\Users\UserStatuses;
use App\Exceptions\UserBannedException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CheckUserBannedSubscriber implements EventSubscriberInterface
{
    public function __construct(private Security $security)
    {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        /** @var User|null $user */
        $user = $this->security->getUser();
        if (empty($user)) {
            return;
        }

        if ($user->getStatus() === UserStatuses::BANNED->value) {
            throw new UserBannedException();
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
