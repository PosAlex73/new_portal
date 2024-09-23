<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Enums\CommonStatus;
use App\Enums\Settings\SettingEnum;
use App\Enums\Users\UserTypes;
use App\Exceptions\ApplicationTerminatedException;
use App\Repository\SettingRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AppEnabledSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected SettingRepository $settingRepository,
        protected Security $security
    ){}

    public function onKernelController(ControllerEvent $event): void
    {
        $appEnabled = $this->settingRepository->findByTitle(SettingEnum::APP_ENABLED->value);

        /** @var User $user */
        $user = $this->security->getUser();

        if (
            !empty($user)
            && $appEnabled->getValue() === CommonStatus::DISABLED->value
            && (is_null($user) || $user->getType() === UserTypes::SIMPLE->value)
        ) {
            throw new ApplicationTerminatedException();
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
