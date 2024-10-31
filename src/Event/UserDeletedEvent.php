<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UserDeletedEvent extends Event
{
    public function __construct(public User $user)
    {
    }

    public function getUser()
    {
        return $this->user;
    }
}
