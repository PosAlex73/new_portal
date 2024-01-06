<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Setting;
use App\Entity\User;
use App\Enums\CommonStatus;
use App\Enums\Users\UserStatuses;
use App\Enums\Users\UserTypes;
use App\Services\Settings\SettingsCreator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CommonFixture extends Fixture
{
    public function __construct(
        protected SettingsCreator $settingsCreator,
        protected UserPasswordHasherInterface $passwordHasher
    )
    {
    }


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        foreach (range(0, 30) as $_) {
            $category = new Category();
            $category->setTitle($faker->realText(20));
            $category->setText($faker->realText());
            $category->setStatus(CommonStatus::ACTIVE->value);

            $manager->persist($category);
            $manager->flush();
        }

        $initialSettings = $this->settingsCreator->getInitialSettings();
        foreach ($initialSettings as $tab => $tabContent) {
            foreach ($tabContent as $title => $setting) {
                $newSetting = new Setting();
                $newSetting->setTitle($title);
                $newSetting->setValue($setting['value']);
                $newSetting->setTab($tab);
                $newSetting->setType('');
                $newSetting->setUpdated(new \DateTime());

                $manager->persist($newSetting);
                $manager->flush();
            }
        }

        $admin = new User();
        $admin->setType(UserTypes::ADMIN->value);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin'));
        $admin->setFirstName($faker->firstName());
        $admin->setLastName($faker->lastName());
        $admin->setEmail('a@a.ru');
        $admin->setStatus(UserStatuses::ACTIVE->value);
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);
        $manager->flush();

        $user = new User();
        $user->setRoles(['ROLE_SIMPLE']);
        $user->setEmail('u@u.ru');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'user'));
        $user->setType(UserTypes::SIMPLE->value);
        $user->setStatus(UserStatuses::ACTIVE->value);
        $user->setLastName($faker->lastName());
        $user->setFirstName($faker->firstName());

        $manager->persist($user);
        $manager->flush();
    }
}
