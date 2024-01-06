<?php

namespace App\EventListeners;

use App\Dto\Courses\InitialCourseDto;
use App\Dto\Progress\UserProgressDataStartDto;
use App\Entity\UserProgress;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::prePersist, method: 'preCreated', entity: UserProgress::class)]
class UserProgressCreated
{
    public function preCreated(UserProgress $progress, PrePersistEventArgs $args)
    {
        $progress->setData(json_encode(UserProgressDataStartDto::getStartData()));
    }
}
