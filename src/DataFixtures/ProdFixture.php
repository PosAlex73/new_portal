<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enums\Users\UserStatuses;
use App\Enums\Users\UserTypes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProdFixture extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        protected UserPasswordHasherInterface $passwordHasher,
    ){}

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setType(UserTypes::ADMIN->value);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin'));
        $admin->setFirstName('Admin');
        $admin->setLastName('Admin');
        $admin->setEmail('a@a.ru');
        $admin->setStatus(UserStatuses::ACTIVE->value);
        $admin->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $admin->setIsVerified(true);

        $manager->persist($admin);
        $manager->flush();

    }

    public function getDependencies()
    {
        return [
            SettingsFixture::class,
            PageFixture::class
        ];
    }

    public static function getGroups(): array
    {
        return ['g3'];
    }
}
