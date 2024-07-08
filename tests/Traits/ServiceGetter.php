<?php

namespace App\Tests\Traits;

use App\Tests\TestExceptions\MethodNotExistsException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

trait ServiceGetter
{
    public function getRepositoryByModel(string $model)
    {
        if (!method_exists($this, 'getContainer')) {
            throw new MethodNotExistsException();
        }

        /** @var EntityManager $em */
        $em = $this->getContainer()->get(EntityManagerInterface::class);
        return $em->getRepository($model);
    }

    public function getUrlGenerator()
    {
        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $this->getContainer()->get(UrlGeneratorInterface::class);

        return $urlGenerator;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        if (!method_exists($this, 'getContainer')) {
            throw new MethodNotExistsException();
        }

        return $this->getContainer()->get(EntityManagerInterface::class);
    }
}
