<?php

namespace App\EventListeners;

use App\Entity\Thread;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Enums\CommonStatus;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postPersist, method: 'postCreated', entity: User::class)]
class UserCreated
{
    public function __construct(protected EntityManagerInterface $manager)
    {
    }

    public function postCreated(User $user, PostPersistEventArgs $args)
    {
        $userProfile = new UserProfile();
        $userProfile->setOwner($user);
        $userProfile->setAdminNotification(CommonStatus::ACTIVE->value);

        $this->manager->persist($userProfile);
        $this->manager->flush();

        $thread = new Thread();
        $thread->setOwner($user);

        $this->manager->persist($thread);
        $this->manager->flush();
    }
}
