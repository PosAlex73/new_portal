<?php

namespace App\Tests\Traits;

use App\Tests\TestExceptions\MethodNotExistsException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

trait EntityManagerGetter
{
    public function getEntityManager(): EntityManager
    {
        if (!method_exists($this, 'getContainer')) {
            throw new MethodNotExistsException();
        }

        /** @var EntityManager $em */
        $em = $this->getContainer()->get(EntityManagerInterface::class);

        return $em;
    }
}
